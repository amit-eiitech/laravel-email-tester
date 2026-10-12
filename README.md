# Laravel Email Tester

Send a synchronous test email from the command line to verify that a Laravel application's mail delivery is working.

## Requirements

- PHP ^8.3
- Laravel ^13

## Installation

Install the package using Composer:

```bash
composer require eii/laravel-email-tester
```

Laravel will discover the service provider automatically.

## Configuration

Publish the package configuration:

```bash
php artisan vendor:publish --tag=mail-test-config
```

Available environment variables:

```dotenv
MAIL_TEST_TO=you@example.com
MAIL_TEST_FROM=no-reply@example.com
MAIL_TEST_SUBJECT="Mail delivery test"
MAIL_TEST_MAILER=smtp
```

If `MAIL_TEST_TO` is not set, the command falls back to `MAIL_FROM_ADDRESS`.

## Usage

Send a test email:

```bash
php artisan mail:test
```

Send to a specific address:

```bash
php artisan mail:test --to=you@example.com
```

Show configuration details before sending:

```bash
php artisan mail:test --to=you@example.com --debug
```

Use a specific mailer:

```bash
php artisan mail:test --to=you@example.com --mailer=smtp
```

Custom subject and body:

```bash
php artisan mail:test --to=you@example.com --subject="Mail check" --body="This is a custom test"
```

## Output

Successful delivery returns exit code `0`.

Failed delivery returns exit code `1` and logs the error to Laravel's default log channel.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).