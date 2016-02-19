<?php
    /**
     Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
     **/

    /**
     */
    class Request
    {
        protected $vars = [];

        protected static $instance;

        public static function getInstance()
        {
            if (self::$instance === null) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        protected function __construct()
        {
            $this->vars = $_GET;

            /*
            // have to rely on parsing QUERY_STRING, thanks to PHP
            // http://bugs.php.net/bug.php?id=39078
            // http://bugs.php.net/bug.php?id=45149
            $all_vars = explode('&', $_SERVER['QUERY_STRING']);
            foreach ($all_vars as $keyval)
            {
                if (strlen($keyval) == 0)
                    continue;
                
                if (strpos($keyval, '=') === false)
                {
                    $key = $keyval;
                    $value = true;
                }
                else
                {
                    list($key, $value) = explode('=', $keyval);
                    #$value = str_replace('%2B', '[[PLUS]]', $value);
                    $value = urldecode($value);
                    #$value = str_replace('[[PLUS]]', '+', $value);
                }
                $this->vars[$key] = $value;
            }
            */
        }

        public function get($key, $default = null)
        {
            if (isset($this->vars[$key])) {
                return $this->vars[$key];
            } else {
                return $default;
            }
        }

        public function set($key, $value)
        {
            $this->vars[$key] = $value;
        }

        public function getInt($key, $default = 0)
        {
            $value = self::get($key);
            if (strlen($value) > 0) {
                return intval($value);
            } else {
                return $default;
            }
        }

        public function getFloat($key, $default = 0)
        {
            $value = self::get($key);
            if (strlen($value) > 0) {
                return floatval($value);
            } else {
                return $default;
            }
        }

        public function getCoordinate($key, $default = 0)
        {
            $v = self::get($key);
            if (strlen($v) > 0 && WideImage_Coordinate::parse($v) !== null) {
                return self::get($key);
            } else {
                return $default;
            }
        }

        public function getOption($key, $valid = [], $default = null)
        {
            $value = self::get($key);
            if ($value !== null && in_array($value, $valid)) {
                return strval($value);
            } else {
                return $default;
            }
        }

        public function getColor($key, $default = '000000')
        {
            $value = self::get($key);
            if (substr($value, 0, 1) == '#') {
                $value = substr($value, 1);
            }

            if ($value === '' || preg_match('~^[0-9a-f]{1,6}$~i', $value)) {
                return $value;
            } else {
                return $default;
            }
        }

        public function getRegex($key, $regex, $default = null)
        {
            $value = self::get($key);
            if ($value !== null && preg_match($regex, $value)) {
                return $value;
            } else {
                return $default;
            }
        }
    }
