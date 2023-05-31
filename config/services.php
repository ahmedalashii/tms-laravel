<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'stripe' => [
        'key'   => env('STRIPE_KEY') ?? "pk_test_51NAzMEI32GpgQPmomiUzy5KhsEEGUsfujjI7giLWutr3kRFo8AnZujSeyKFLuob7cyeqcC2QzbaBBRHvUnLMRo7V00p1HzYncj",
        'secret' => env('STRIPE_SECRET') ?? "sk_test_51NAzMEI32GpgQPmoTZIi2aZTcdmmLgysecbwdtPbCNIP1Qs1FJY87ABr6vAMpX5thjRWmOpUGH80TFBYCp1xLyo2003a5dIlva",
    ],

    'firebase' => [
        'api_key' => 'api_key', // Only used from JS integration
        'auth_domain' => 'auth_domain', // Only used from JS integration
        'database_url' => 'https://database_url.com/',
        'storage_bucket' => '', // Only used from JS integration
    ],
];
