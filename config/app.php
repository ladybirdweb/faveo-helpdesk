<?php

return [
    'env' => env('APP_ENV', 'production'),
    /*
      |--------------------------------------------------------------------------
      | Application Debug Mode
      |--------------------------------------------------------------------------
      |
      | When your application is in debug mode, detailed error messages with
      | stack traces will be shown on every error that occurs within your
      | application. If disabled, a simple generic error page is shown.
      |
     */
    'debug' => env('APP_DEBUG', false),
    /*
      |--------------------------------------------------------------------------
      | Error Log
      |--------------------------------------------------------------------------
      |
      | This error log will send email to faveo about the errors. So that before
      | reporting about the errors we at faveo will start solving the issues already.
      | The errors mails will never share your files or data. it will only share
      | the line number and error occured.
      | To dissable you may just change '%1%' to 0.
     */
    'ErrorLog' => '1',
    /*
      |--------------------------------------------------------------------------
      | Application Version
      |--------------------------------------------------------------------------
      |
      | This tells about aplication current version.
      |
     */
    'version' => 'Community 1.0.8.0 RC',
    /*
      |--------------------------------------------------------------------------
      | Application Name
      |--------------------------------------------------------------------------
      |
      | This Applocation name is used for installation and update checking
      |
     */
    'name' => 'Faveo helpdesk community',
    /*
      |--------------------------------------------------------------------------
      | Application URL
      |--------------------------------------------------------------------------
      |
      | This URL is used by the console to properly generate URLs when using
      | the Artisan command line tool. You should set this to the root of
      | your application so that it is used when running Artisan tasks.
      |
     */
    'url' => env('APP_URL'),
    /*
      |--------------------------------------------------------------------------
      | Application Timezone
      |--------------------------------------------------------------------------
      |
      | Here you may specify the default timezone for your application, which
      | will be used by the PHP date and date-time functions. We have gone
      | ahead and set this to a sensible default for you out of the box.
      |
     */
    'timezone' => 'UTC',
    /*
      |--------------------------------------------------------------------------
      | Application Locale Configuration
      |--------------------------------------------------------------------------
      |
      | The application locale determines the default locale that will be used
      | by the translation service provider. You are free to set this value
      | to any of the locales which will be supported by the application.
      |
     */
    'locale' => 'en',
    /*
      |--------------------------------------------------------------------------
      | Application Fallback Locale
      |--------------------------------------------------------------------------
      |
      | The fallback locale determines the locale to use when the current one
      | is not available. You may change the value to correspond to any of
      | the language folders that are provided through your application.
      |
     */
    'fallback_locale' => 'en',
    /*
      |--------------------------------------------------------------------------
      | Encryption Key
      |--------------------------------------------------------------------------
      |
      | This key is used by the Illuminate encrypter service and should be set
      | to a random, 32 character string, otherwise these encrypted strings
      | will not be safe. Please do this before deploying an application!
      |
     */
    'key'    => env('APP_KEY', 'F70u5RfMoiq7ptPR'),
    'cipher' => MCRYPT_RIJNDAEL_128,
    /*
      |--------------------------------------------------------------------------
      | Logging Configuration
      |--------------------------------------------------------------------------
      |
      | Here you may configure the log settings for your application. Out of
      | the box, Laravel uses the Monolog PHP logging library. This gives
      | you a variety of powerful log handlers / formatters to utilize.
      |
      | Available Settings: "single", "daily", "syslog", "errorlog"
      |
     */
    'log' => 'daily',
    /*
      |---------------------------------------------------------------------------------
      | Bugsnag error reporting
      |-----------------------------------------------------------------------------------
      |Accepts true or false as a value. It decides whether to send the error
      |to FAVEO team when any exception/error occurs or not. True value of this variable will
      |allow application to send error reports to FAVEO team's bugsnag log.
     */
    'bugsnag_reporting' => env('APP_BUGSNAG', true),
    /*
      |--------------------------------------------------------------------------
      | Autoloaded Service Providers
      |--------------------------------------------------------------------------
      |
      | The service providers listed here will be automatically loaded on the
      | request to your application. Feel free to add your own services to
      | this array to grant expanded functionality to your applications.
      |
     */
    'providers' => [

        'Illuminate\Broadcasting\BroadcastServiceProvider',
        'DaveJamesMiller\Breadcrumbs\ServiceProvider',
        /*
         * Laravel Framework Service Providers...
         */


        'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Bus\BusServiceProvider',
        'Illuminate\Cache\CacheServiceProvider',
        'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
        'Illuminate\Cookie\CookieServiceProvider',
        'Illuminate\Database\DatabaseServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider',
        'Illuminate\Filesystem\FilesystemServiceProvider',
        'Illuminate\Foundation\Providers\FoundationServiceProvider',
        'Illuminate\Hashing\HashServiceProvider',
        Illuminate\Mail\MailServiceProvider::class,
        'Illuminate\Pagination\PaginationServiceProvider',
        'Illuminate\Pipeline\PipelineServiceProvider',
        'Illuminate\Queue\QueueServiceProvider',
        'Illuminate\Redis\RedisServiceProvider',
        'Illuminate\Auth\Passwords\PasswordResetServiceProvider',
        'Illuminate\Session\SessionServiceProvider',
        'Illuminate\Translation\TranslationServiceProvider',
        'Illuminate\Validation\ValidationServiceProvider',
        'Illuminate\View\ViewServiceProvider',
        'Illuminate\Html\HtmlServiceProvider',
        /*
         * Application Service Providers...
         */
        'App\Providers\AppServiceProvider',
        'App\Providers\EventServiceProvider',
        'App\Providers\RouteServiceProvider',
        'App\Providers\ConfigServiceProvider',
        'Propaganistas\LaravelPhone\LaravelPhoneServiceProvider',
        'Bugsnag\BugsnagLaravel\BugsnagLaravelServiceProvider',
        'Vsmoraes\Pdf\PdfServiceProvider',
        'Thomaswelton\LaravelGravatar\LaravelGravatarServiceProvider',
        'Chumper\Datatable\DatatableServiceProvider',
        'Chumper\Zipper\ZipperServiceProvider',
        Unisharp\Laravelfilemanager\LaravelFilemanagerServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        'Tymon\JWTAuth\Providers\JWTAuthServiceProvider',
        'Torann\GeoIP\GeoIPServiceProvider',
        LaravelFCM\FCMServiceProvider::class,
        Barryvdh\Debugbar\ServiceProvider::class,
        Collective\Bus\BusServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,
        Laravel\Socialite\SocialiteServiceProvider::class,
        App\FaveoLog\LaravelLogViewerServiceProvider::class,


    ],
    /*
      |--------------------------------------------------------------------------
      | Class Aliases
      |--------------------------------------------------------------------------
      |
      | This array of class aliases will be registered when this application
      | is started. However, feel free to register as many as you wish as
      | the aliases are "lazy" loaded so they don't hinder performance.
      |
     */
    'aliases' => [
        'App'         => 'Illuminate\Support\Facades\App',
        'Artisan'     => 'Illuminate\Support\Facades\Artisan',
        'Auth'        => 'Illuminate\Support\Facades\Auth',
        'Blade'       => 'Illuminate\Support\Facades\Blade',
        'Cache'       => 'Illuminate\Support\Facades\Cache',
        'Config'      => 'Illuminate\Support\Facades\Config',
        'Cookie'      => 'Illuminate\Support\Facades\Cookie',
        'Crypt'       => 'Illuminate\Support\Facades\Crypt',
        'DB'          => 'Illuminate\Support\Facades\DB',
        'Eloquent'    => 'Illuminate\Database\Eloquent\Model',
        'Event'       => 'Illuminate\Support\Facades\Event',
        'File'        => 'Illuminate\Support\Facades\File',
        'Hash'        => 'Illuminate\Support\Facades\Hash',
        'Input'       => 'Illuminate\Support\Facades\Input',
        'Inspiring'   => 'Illuminate\Foundation\Inspiring',
        'Lang'        => 'Illuminate\Support\Facades\Lang',
        'Log'         => 'Illuminate\Support\Facades\Log',
        'Mail'        => 'Illuminate\Support\Facades\Mail',
        'Password'    => 'Illuminate\Support\Facades\Password',
        'Queue'       => 'Illuminate\Support\Facades\Queue',
        'Redirect'    => 'Illuminate\Support\Facades\Redirect',
        'Redis'       => 'Illuminate\Support\Facades\Redis',
        'Request'     => 'Illuminate\Support\Facades\Request',
        'Response'    => 'Illuminate\Support\Facades\Response',
        'Route'       => 'Illuminate\Support\Facades\Route',
        'Schema'      => 'Illuminate\Support\Facades\Schema',
        'Session'     => 'Illuminate\Support\Facades\Session',
        'Storage'     => 'Illuminate\Support\Facades\Storage',
        'URL'         => 'Illuminate\Support\Facades\URL',
        'Validator'   => 'Illuminate\Support\Facades\Validator',
        'View'        => 'Illuminate\Support\Facades\View',
        'Form'        => 'Illuminate\Html\FormFacade',
        'HTML'        => 'Illuminate\Html\HtmlFacade',
        'phone'       => 'The :attribute field contains an invalid number.',
        'Bugsnag'     => 'Bugsnag\BugsnagLaravel\BugsnagFacade',
        'PDF'         => 'Vsmoraes\Pdf\PdfFacade',
        'Gravatar'    => 'Thomaswelton\LaravelGravatar\Facades\Gravatar',
        'UTC'         => 'App\Http\Controllers\Agent\helpdesk\TicketController',
        'Ttable'      => 'App\Http\Controllers\Agent\helpdesk\TicketController', //to use getTable function.
        'SMTPS'       => 'App\Http\Controllers\HomeController',
        'Datatable'   => 'Chumper\Datatable\Facades\DatatableFacade',
        'Zipper'      => 'Chumper\Zipper\Zipper',
        'JWTAuth'     => 'Tymon\JWTAuth\Facades\JWTAuth',
        'JWTFactory'  => 'Tymon\JWTAuth\Facades\JWTFactory',
        'Breadcrumbs' => 'DaveJamesMiller\Breadcrumbs\Facade',
        'GeoIP'       => 'Torann\GeoIP\GeoIPFacade',
        'Image'       => Intervention\Image\Facades\Image::class,
        'FCM'         => LaravelFCM\Facades\FCM::class,
        'FCMGroup'    => LaravelFCM\Facades\FCMGroup::class,
        'Debugbar'    => Barryvdh\Debugbar\Facade::class,
        'Excel'       => Maatwebsite\Excel\Facades\Excel::class,
        'Socialite'   => Laravel\Socialite\Facades\Socialite::class,
        'UnAuth'      => 'App\Http\Controllers\Client\helpdesk\UnAuthController',

    ],
];
