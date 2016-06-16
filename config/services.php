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
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'github' => [
        'client_id' => getenv('GITHUB_CLIENT_ID'),
        'client_secret' => getenv('GITHUB_CLIENT_SECRET'),
        'redirect' => getenv('GITHUB_URL'),
        //'redirect' => 'http://eurostadium.app/login/callback/github',
        //'redirect' => 'http://www.eurostadium.net/login/callback/github',
    ],

    'google' => [
        'client_id' => getenv('GOOGLE_CLIENT_ID'),
        'client_secret' => getenv('GOOGLE_CLIENT_SECRET'),
        'redirect' => getenv('GOOGLE_URL'),
        //'redirect' => 'http://eurostadium.app/login/callback/google',
        //'redirect' => 'http://www.eurostadium.net/login/callback/google',
    ],

    'linkedin' => [
        'client_id' => getenv('LINKEDIN_CLIENT_ID'),
        'client_secret' => getenv('LINKEDIN_CLIENT_SECRET'),
        'redirect' => getenv('LINKEDIN_URL'),
        //'redirect' => 'http://localhost/Laravel/eurostadium/public/login/callback/linkedin',
        //'redirect' => 'http://eurostadium.app/login/callback/linkedin',
        //'redirect' => 'http://www.eurostadium.net/login/callback/linkedin',
    ],

    'facebook' => [
        'client_id' => getenv('FACEBOOK_CLIENT_ID'),
        'client_secret' => getenv('FACEBOOK_CLIENT_SECRET'),
        'redirect' => getenv('FACEBOOK_URL'),
        //'redirect' => 'http://localhost/Laravel/eurostadium/public/login/callback/facebook',
        //'redirect' => 'http://eurostadium.app/login/callback/facebook',
        //'redirect' => 'http://www.eurostadium.net/login/callback/facebook',
    ],

    'twitter' => [
        'client_id' => getenv('TWITTER_CLIENT_ID'),
        'client_secret' => getenv('TWITTER_CLIENT_SECRET'),
        'redirect' => getenv('TWITTER_URL'),
    ],

    'bitbucket' => [
        'client_id' => getenv('BITBUCKET_CLIENT_ID'),
        'client_secret' => getenv('BITBUCKET_CLIENT_SECRET'),
        'redirect' => getenv('BITBUCKET_URL'),
    ]
];
