<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    */

    'mailers' => [

        'smtp' => [
            'transport'   => 'smtp',
            'scheme'      => env('MAIL_SCHEME'),
            'url'         => env('MAIL_URL'),
            'host'        => env('MAIL_HOST', 'smtp.gmail.com'),
            'port'        => env('MAIL_PORT', 587),
            'username'    => env('MAIL_USERNAME'),
            'password'    => env('MAIL_PASSWORD'),
            'encryption'  => env('MAIL_ENCRYPTION', 'tls'),
            'timeout'     => null,
            'local_domain'=> env('MAIL_EHLO_DOMAIN', parse_url((string) env('APP_URL', 'http://localhost'), PHP_URL_HOST)),

            /*
            |--------------------------------------------------------------------------
            | IPv4 Fix (PREVENT Gmail SMTP Failure)
            |--------------------------------------------------------------------------
            */
            'stream' => [
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                ],
                'socket' => [
                    'bindto' => '0.0.0.0:0', // ⬅ Force IPv4 only
                ],
            ],
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'postmark' => [
            'transport' => 'postmark',
        ],

        'resend' => [
            'transport' => 'resend',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path'      => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel'   => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        /*
        |--------------------------------------------------------------------------
        | Failover (tries SMTP then logs if fails)
        |--------------------------------------------------------------------------
        */
        'failover' => [
            'transport' => 'failover',
            'mailers'   => ['smtp', 'log'],
            'retry_after' => 60,
        ],

        /*
        |--------------------------------------------------------------------------
        | Round Robin (not used but preserved)
        |--------------------------------------------------------------------------
        */
        'roundrobin' => [
            'transport' => 'roundrobin',
            'mailers'   => ['ses', 'postmark'],
            'retry_after' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global From Address
    |--------------------------------------------------------------------------
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'anonymousdoyin@gmail.com'),
        'name'    => env('MAIL_FROM_NAME', 'ImperialVilla'),
    ],

];
