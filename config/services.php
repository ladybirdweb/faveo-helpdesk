<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Third Party Services
      |--------------------------------------------------------------------------
      |
      | This file is for storing the credentials for third party services such
      | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
      | default location for this type of information, allowing packages
      | to have a conventional place to find your various credentials.
      |
     */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],
    'mandrill' => [
        'secret' => '',
    ],
    'ses' => [
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],
    'stripe' => [
        'model'  => 'User',
        'secret' => '',
    ],

    'facebook' => [
        'client_id'     => '', //'1549781705316089', //app id
        'client_secret' => '', //'d87caaf1b1dd1d5620fee458a85fb04b', //app secret
        'redirect'      => '', //'http://localhost/FaveoVersions/faveo-helpdesk/public/social/login/facebook', //redirec
    ],
    'google' => [
        'client_id'     => '', //'688540182553-kp780p6fvhjqtl6c91npm6hjair96vkr.apps.googleusercontent.com', //app id
        'client_secret' => '', //'ZZ9lXX6uqLGgP1NzbQMh8tMT', //secret
        'redirect'      => '', //'http://localhost/FaveoVersions/faveo-helpdesk/public/social/login/google', //redirect
    ],
    'github' => [
        'client_id'     => '', //'32e7f0bf89715bee29c4', //app id
        'client_secret' => '', //'2f279448a6e22bcc3948684b9fd9ae52859aa3dc', //app secrete,
        'redirect'      => '', //'http://localhost/FaveoVersions/faveo-helpdesk/public/social/login/github', //redirect
    ],
    'twitter' => [
        'client_id'     => '', //'zIngm3fOvZSUl2mXQVuUkeyJq', //app id
        'client_secret' => '', //'56qAS0c0AuDQqMKu6eFaixfEuIMt8L0PrOxvXtJ4Lcq08xClT2', //app secrete,
        'redirect'      => '', //'http://twitter-auth.app/FaveoVersions/faveo-helpdesk/public/social/login/twitter', //redirect
    ],
    'linkedin' => [
        'client_id'     => '', //'8124vrpk0p0a4h', //client id
        'client_secret' => '', //'hKWvjrJba80PSzET', //client secrete,
        'redirect'      => '', //'http://localhost/FaveoVersions/faveo-helpdesk/public/social/login/linkedin', //redirect
    ],
    'bitbucket' => [
        'client_id'     => '', //'pLKys6C89Xg6bbuHcL', //client id
        'client_secret' => '', //'dD7HerXuELJR3uZQv93ZYuXsg5vLSzLR', //client secrete,
        'redirect'      => '', //'http://localhost/FaveoVersions/faveo-helpdesk/public/social/login/bitbucket', //redirect
    ],

];
