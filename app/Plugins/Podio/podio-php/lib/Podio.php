<?php

class Podio
{
    public static $oauth, $debug, $logger, $session_manager, $last_response, $auth_type;
    protected static $url, $client_id, $client_secret, $secret, $ch, $headers;
    private static $stdout;

    const VERSION = '4.3.0';

    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    public static function setup($client_id, $client_secret, $options = ['session_manager' => null, 'curl_options' => []])
    {
        // Setup client info
    self::$client_id = $client_id;
        self::$client_secret = $client_secret;

    // Setup curl
    self::$url = empty($options['api_url']) ? 'https://api.podio.com:443' : $options['api_url'];
        self::$debug = self::$debug ? self::$debug : false;
        self::$ch = curl_init();
        self::$headers = [
      'Accept' => 'application/json',
    ];
        curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, 0); //check this on server and change 0 to 1
    curl_setopt(self::$ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt(self::$ch, CURLOPT_USERAGENT, 'Podio PHP Client/'.self::VERSION);
        curl_setopt(self::$ch, CURLOPT_HEADER, true);
        curl_setopt(self::$ch, CURLINFO_HEADER_OUT, true);

    //Update CA root certificates - require: https://github.com/Kdyby/CurlCaBundle
    if (class_exists('\\Kdyby\\CurlCaBundle\\CertificateHelper')) {
        \Kdyby\CurlCaBundle\CertificateHelper::setCurlCaInfo(self::$ch);
    }

        if ($options && !empty($options['curl_options'])) {
            curl_setopt_array(self::$ch, $options['curl_options']);
        }

        self::$session_manager = null;
        if ($options && !empty($options['session_manager'])) {
            if (is_string($options['session_manager']) && class_exists($options['session_manager'])) {
                self::$session_manager = new $options['session_manager']();
            } elseif (is_object($options['session_manager']) && method_exists($options['session_manager'], 'get') && method_exists($options['session_manager'], 'set')) {
                self::$session_manager = $options['session_manager'];
            }
            if (self::$session_manager) {
                self::$oauth = self::$session_manager->get();
            }
        }

    // Register shutdown function for debugging and session management
    register_shutdown_function('Podio::shutdown');
    }

    public static function authenticate_with_app($app_id, $app_token)
    {
        return self::authenticate('app', ['app_id' => $app_id, 'app_token' => $app_token]);
    }

    public static function authenticate_with_password($username, $password)
    {
        return self::authenticate('password', ['username' => $username, 'password' => $password]);
    }

    public static function authenticate_with_authorization_code($authorization_code, $redirect_uri)
    {
        return self::authenticate('authorization_code', ['code' => $authorization_code, 'redirect_uri' => $redirect_uri]);
    }

    public static function refresh_access_token()
    {
        return self::authenticate('refresh_token', ['refresh_token' => self::$oauth->refresh_token]);
    }

    public static function authenticate($grant_type, $attributes)
    {
        $data = [];
        $auth_type = ['type' => $grant_type];

        switch ($grant_type) {
      case 'password':
        $data['grant_type'] = 'password';
        $data['username'] = $attributes['username'];
        $data['password'] = $attributes['password'];

        $auth_type['identifier'] = $attributes['username'];
        break;
      case 'refresh_token':
        $data['grant_type'] = 'refresh_token';
        $data['refresh_token'] = $attributes['refresh_token'];
        break;
      case 'authorization_code':
        $data['grant_type'] = 'authorization_code';
        $data['code'] = $attributes['code'];
        $data['redirect_uri'] = $attributes['redirect_uri'];
        break;
      case 'app':
        $data['grant_type'] = 'app';
        $data['app_id'] = $attributes['app_id'];
        $data['app_token'] = $attributes['app_token'];

        $auth_type['identifier'] = $attributes['app_id'];
      default:
        break;
    }

        $request_data = array_merge($data, ['client_id' => self::$client_id, 'client_secret' => self::$client_secret]);
        if ($response = self::request(self::POST, '/oauth/token', $request_data, ['oauth_request' => true])) {
            $body = $response->json_body();
            self::$oauth = new PodioOAuth($body['access_token'], $body['refresh_token'], $body['expires_in'], $body['ref']);

      // Don't touch auth_type if we are refreshing automatically as it'll be reset to null
      if ($grant_type !== 'refresh_token') {
          self::$auth_type = $auth_type;
      }

            if (self::$session_manager) {
                self::$session_manager->set(self::$oauth, self::$auth_type);
            }

            return true;
        }

        return false;
    }

    public static function clear_authentication()
    {
        self::$oauth = new PodioOAuth();

        if (self::$session_manager) {
            self::$session_manager->set(self::$oauth, self::$auth_type);
        }
    }

    public static function authorize_url($redirect_uri, $scope)
    {
        $parsed_url = parse_url(self::$url);
        $host = str_replace('api.', '', $parsed_url['host']);

        return 'https://'.$host.'/oauth/authorize?response_type=code&client_id='.self::$client_id.'&redirect_uri='.rawurlencode($redirect_uri).'&scope='.rawurlencode($scope);
    }

    public static function is_authenticated()
    {
        return self::$oauth && self::$oauth->access_token;
    }

    public static function request($method, $url, $attributes = [], $options = [])
    {
        if (!self::$ch) {
            throw new Exception('Client has not been setup with client id and client secret.');
        }

    // Reset attributes so we can reuse curl object
    curl_setopt(self::$ch, CURLOPT_POSTFIELDS, null);
        unset(self::$headers['Content-length']);
        $original_url = $url;
        $encoded_attributes = null;

        if (is_object($attributes) && substr(get_class($attributes), 0, 5) == 'Podio') {
            $attributes = $attributes->as_json(false);
        }

        if (!is_array($attributes) && !is_object($attributes)) {
            throw new PodioDataIntegrityError('Attributes must be an array');
        }

        switch ($method) {
      case self::GET:
        curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, self::GET);
        self::$headers['Content-type'] = 'application/x-www-form-urlencoded';

        $separator = strpos($url, '?') ? '&' : '?';
        if ($attributes) {
            $query = self::encode_attributes($attributes);
            $url = $url.$separator.$query;
        }

        self::$headers['Content-length'] = '0';
        break;
      case self::DELETE:
        curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, self::DELETE);
        self::$headers['Content-type'] = 'application/x-www-form-urlencoded';

        $separator = strpos($url, '?') ? '&' : '?';
        if ($attributes) {
            $query = self::encode_attributes($attributes);
            $url = $url.$separator.$query;
        }

        self::$headers['Content-length'] = '0';
        break;
      case self::POST:
        curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, self::POST);
        if (!empty($options['upload'])) {
            curl_setopt(self::$ch, CURLOPT_POST, true);
            if (defined('CURLOPT_SAFE_UPLOAD')) {
                curl_setopt(self::$ch, CURLOPT_SAFE_UPLOAD, false);
            }
            curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $attributes);
            self::$headers['Content-type'] = 'multipart/form-data';
        } elseif (empty($options['oauth_request'])) {
            // application/json
          $encoded_attributes = json_encode($attributes);
            curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $encoded_attributes);
            self::$headers['Content-type'] = 'application/json';
        } else {
            // x-www-form-urlencoded
          $encoded_attributes = self::encode_attributes($attributes);
            curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $encoded_attributes);
            self::$headers['Content-type'] = 'application/x-www-form-urlencoded';
        }
        break;
      case self::PUT:
        $encoded_attributes = json_encode($attributes);
        curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, self::PUT);
        curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $encoded_attributes);
        self::$headers['Content-type'] = 'application/json';
        break;
    }

    // Add access token to request
    if (isset(self::$oauth) && !empty(self::$oauth->access_token) && !(isset($options['oauth_request']) && $options['oauth_request'] == true)) {
        $token = self::$oauth->access_token;
        self::$headers['Authorization'] = "OAuth2 {$token}";
    } else {
        unset(self::$headers['Authorization']);
    }

    // File downloads can be of any type
    if (empty($options['file_download'])) {
        self::$headers['Accept'] = 'application/json';
    } else {
        self::$headers['Accept'] = '*/*';
    }

        curl_setopt(self::$ch, CURLOPT_HTTPHEADER, self::curl_headers());
        curl_setopt(self::$ch, CURLOPT_URL, empty($options['file_download']) ? self::$url.$url : $url);

        $response = new PodioResponse();

        if (isset($options['return_raw_as_resource_only']) && $options['return_raw_as_resource_only'] == true) {
            $result_handle = fopen('php://temp', 'w');
            curl_setopt(self::$ch, CURLOPT_FILE, $result_handle);
            curl_exec(self::$ch);
            if (isset(self::$stdout) && is_resource(self::$stdout)) {
                fclose(self::$stdout);
            }
            self::$stdout = fopen('php://stdout', 'w');
            curl_setopt(self::$ch, CURLOPT_FILE, self::$stdout);
            curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, true);
            $raw_headers_size = curl_getinfo(self::$ch, CURLINFO_HEADER_SIZE);

            fseek($result_handle, 0);
            $response->status = curl_getinfo(self::$ch, CURLINFO_HTTP_CODE);
            $response->headers = self::parse_headers(fread($result_handle, $raw_headers_size));
            self::$last_response = $response;

            return $result_handle;
        }

        $raw_response = curl_exec(self::$ch);
        if ($raw_response === false) {
            // throw new PodioConnectionError('Connection to Podio API failed: [' . curl_errno(self::$ch) . '] ' . curl_error(self::$ch), curl_errno(self::$ch));
      echo 'PodioConnectionError';
        }
        $raw_headers_size = curl_getinfo(self::$ch, CURLINFO_HEADER_SIZE);

        $response->body = substr($raw_response, $raw_headers_size);
        $response->status = curl_getinfo(self::$ch, CURLINFO_HTTP_CODE);
        $response->headers = self::parse_headers(substr($raw_response, 0, $raw_headers_size));
        self::$last_response = $response;

        if (!isset($options['oauth_request'])) {
            $curl_info = curl_getinfo(self::$ch, CURLINFO_HEADER_OUT);
            self::log_request($method, $url, $encoded_attributes, $response, $curl_info);
        }

        switch ($response->status) {
      case 200:
      case 201:
      case 204:
        return $response;
        break;
      case 400:
        // invalid_grant_error or bad_request_error
        $body = $response->json_body();
        if (strstr($body['error'], 'invalid_grant')) {
            // Reset access token & refresh_token
          self::clear_authentication();
          //throw new PodioInvalidGrantError($response->body, $response->status, $url);
          echo 'PodioInvalidGrantError';
            break;
        } else {
            // throw new PodioBadRequestError($response->body, $response->status, $url);
          echo 'PodioBadRequestError';
        }
        break;
      case 401:
        $body = $response->json_body();
        if (strstr($body['error_description'], 'expired_token') || strstr($body['error'], 'invalid_token')) {
            if (self::$oauth->refresh_token) {
                // Access token is expired. Try to refresh it.
            if (self::authenticate('refresh_token', ['refresh_token' => self::$oauth->refresh_token])) {
                // Try the original request again.
              return self::request($method, $original_url, $attributes);
            } else {
                self::clear_authentication();
              //throw new PodioAuthorizationError($response->body, $response->status, $url);
              echo 'PodioAuthorizationError';
            }
            } else {
                // We have tried in vain to get a new access token. Log the user out.
            self::clear_authentication();
            // throw new PodioAuthorizationError($response->body, $response->status, $url);
            echo 'PodioAuthorizationError';
            }
        } elseif (strstr($body['error'], 'invalid_request') || strstr($body['error'], 'unauthorized')) {
            // Access token is invalid.
          self::clear_authentication();
          // throw new PodioAuthorizationError($response->body, $response->status, $url);
          echo 'PodioAuthorizationError';
        }
        break;
      case 403:
        // throw new PodioForbiddenError($response->body, $response->status, $url);
        echo 'PodioForbiddenError';
        break;
      case 404:
        // throw new PodioNotFoundError($response->body, $response->status, $url);
        echo 'PodioNotFoundError';
        break;
      case 409:
        //throw new PodioConflictError($response->body, $response->status, $url);
        echo 'PodioConflictError';
        break;
      case 410:
        // throw new PodioGoneError($response->body, $response->status, $url);
        echo 'PodioGoneError';
        break;
      case 420:
        // throw new PodioRateLimitError($response->body, $response->status, $url);
        echo 'PodioRateLimitError';
        break;
      case 500:
        // throw new PodioServerError($response->body, $response->status, $url);
        echo 'PodioServerError';
        break;
      case 502:
      case 503:
      case 504:
        // throw new PodioUnavailableError($response->body, $response->status, $url);
        echo 'PodioUnavailableError';
        break;
      default:
        // throw new PodioError($response->body, $response->status, $url);
        echo '/Some thing went wrong';
        break;
    }

        return false;
    }

    public static function get($url, $attributes = [], $options = [])
    {
        return self::request(self::GET, $url, $attributes, $options);
    }

    public static function post($url, $attributes = [], $options = [])
    {
        return self::request(self::POST, $url, $attributes, $options);
    }

    public static function put($url, $attributes = [])
    {
        return self::request(self::PUT, $url, $attributes);
    }

    public static function delete($url, $attributes = [])
    {
        return self::request(self::DELETE, $url, $attributes);
    }

    public static function curl_headers()
    {
        $headers = [];
        foreach (self::$headers as $header => $value) {
            $headers[] = "{$header}: {$value}";
        }

        return $headers;
    }

    public static function encode_attributes($attributes)
    {
        $return = [];
        foreach ($attributes as $key => $value) {
            $return[] = urlencode($key).'='.urlencode($value);
        }

        return implode('&', $return);
    }

    public static function url_with_options($url, $options)
    {
        $parameters = [];

        if (isset($options['silent']) && $options['silent']) {
            $parameters[] = 'silent=1';
        }

        if (isset($options['hook']) && !$options['hook']) {
            $parameters[] = 'hook=false';
        }

        if (!empty($options['fields'])) {
            $parameters[] = 'fields='.$options['fields'];
        }

        return $parameters ? $url.'?'.implode('&', $parameters) : $url;
    }

    public static function parse_headers($headers)
    {
        $list = [];
        $headers = str_replace("\r", '', $headers);
        $headers = explode("\n", $headers);
        foreach ($headers as $header) {
            if (strstr($header, ':')) {
                $name = strtolower(substr($header, 0, strpos($header, ':')));
                $list[$name] = trim(substr($header, strpos($header, ':') + 1));
            }
        }

        return $list;
    }

    public static function rate_limit_remaining()
    {
        if (isset($last_response->headers['x-rate-limit-remaining'])) {
            return self::$last_response->headers['x-rate-limit-remaining'];
        }
    }

    public static function rate_limit()
    {
        if (isset($last_response->headers['x-rate-limit'])) {
            return self::$last_response->headers['x-rate-limit'];
        }
    }

  /**
   * Set debug config.
   *
   * @param $toggle True to enable debugging. False to disable
   * @param $output Output mode. Can be "stdout" or "file". Default is "stdout"
   */
  public static function set_debug($toggle, $output = 'stdout')
  {
      if ($toggle) {
          self::$debug = $output;
      } else {
          self::$debug = false;
      }
  }

    public static function log_request($method, $url, $encoded_attributes, $response, $curl_info)
    {
        if (self::$debug) {
            $timestamp = gmdate('Y-m-d H:i:s');
            $text = "{$timestamp} {$response->status} {$method} {$url}\n";
            if (!empty($encoded_attributes)) {
                $text .= "{$timestamp} Request body: ".$encoded_attributes."\n";
            }
            $text .= "{$timestamp} Reponse: {$response->body}\n\n";

            if (self::$debug === 'file') {
                if (!self::$logger) {
                    self::$logger = new PodioLogger();
                }
                self::$logger->log($text);
            } elseif (self::$debug === 'stdout' && php_sapi_name() === 'cli') {
                echo $text;
            } elseif (self::$debug === 'stdout' && php_sapi_name() === 'cli') {
                require_once 'vendor/kint/Kint.class.php';
                Kint::dump("{$method} {$url}", $encoded_attributes, $response, $curl_info);
            }

            self::$logger->call_log[] = curl_getinfo(self::$ch, CURLINFO_TOTAL_TIME);
        }
    }

    public static function shutdown()
    {
        // Write any new access and refresh tokens to session.
    if (self::$session_manager) {
        self::$session_manager->set(self::$oauth, self::$auth_type);
    }

    // Log api call times if debugging
    if (self::$debug && self::$logger) {
        $timestamp = gmdate('Y-m-d H:i:s');
        $count = count(self::$logger->call_log);
        $duration = 0;
        if (self::$logger->call_log) {
            foreach (self::$logger->call_log as $val) {
                $duration += $val;
            }
        }

        $text = "\n{$timestamp} Performed {$count} request(s) in {$duration} seconds\n";
        if (self::$debug === 'file') {
            if (!self::$logger) {
                self::$logger = new PodioLogger();
            }
            self::$logger->log($text);
        } elseif (self::$debug === 'stdout' && php_sapi_name() === 'cli') {
            echo $text;
        }
    }
    }
}
