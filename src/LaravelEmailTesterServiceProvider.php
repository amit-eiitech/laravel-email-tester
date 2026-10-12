<?php

namespace Eii\LaravelEmailTester;

use Eii\LaravelEmailTester\Console\Commands\MailTestCommand;
use Illuminate\Support\ServiceProvider;

class LaravelEmailTesterServiceProvider extends ServiceProvider
{
    /**
     * Register package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/mail-test.php',
            'mail-test'
        );
    }

    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MailTestCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../config/mail-test.php' => config_path('mail-test.php'),
        ], 'mail-test-config');
    }
}
