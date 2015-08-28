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
        'domain' => 'postmaster@sandboxad0d60c6cc1d4a60bfa0b88bc1ff74ae.mailgun.org',
        'secret' => 'key-02c7bfdc17d833537049a4d403b578b4',
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
        'model'  => serranatural\User::class,
        'key'    => '',
        'secret' => '',
    ],

];
