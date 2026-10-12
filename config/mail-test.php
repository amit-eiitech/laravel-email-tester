<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Test Recipient
    |--------------------------------------------------------------------------
    |
    | This value is used when no --to option is provided to the mail:test
    | command. It can be set in the project's .env file as MAIL_TEST_TO.
    |
    */

    'default_to' => env('MAIL_TEST_TO'),

    /*
    |--------------------------------------------------------------------------
    | Default Test Sender
    |--------------------------------------------------------------------------
    |
    | This value is used when no --from option is provided. If null, the
    | mailer's global "from" address from config/mail.php will be used.
    |
    */

    'default_from' => env('MAIL_TEST_FROM'),

    /*
    |--------------------------------------------------------------------------
    | Default Test Subject
    |--------------------------------------------------------------------------
    |
    | This subject is used when no --subject option is provided.
    |
    */

    'default_subject' => env('MAIL_TEST_SUBJECT', 'Mail delivery test'),

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This mailer is used when no --mailer option is provided. If null, the
    | application's default mailer from config/mail.php will be used.
    |
    */

    'default_mailer' => env('MAIL_TEST_MAILER'),
];
