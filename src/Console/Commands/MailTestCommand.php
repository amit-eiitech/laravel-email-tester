<?php

namespace Eii\LaravelEmailTester\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class MailTestCommand extends Command
{
    protected $signature = 'mail:test
                            {--to= : Recipient email address}
                            {--from= : Sender email address}
                            {--mailer= : Mailer to use}
                            {--subject= : Email subject}
                            {--body= : Email body text}
                            {--debug : Show mail configuration summary before sending}';

    protected $description = 'Send a synchronous test email to verify mail delivery';

    public function handle(): int
    {
        $to = $this->option('to')
            ?: config('mail-test.default_to')
            ?: config('mail.from.address');

        if (! $to || ! filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $this->error('A valid recipient is required. Use --to=your@email.com or set MAIL_TEST_TO in .env.');

            return self::FAILURE;
        }

        $mailer = $this->option('mailer')
            ?: config('mail-test.default_mailer')
            ?: (string) config('mail.default');

        $from = $this->option('from')
            ?: config('mail-test.default_from');

        $subject = $this->option('subject')
            ?: (string) config('mail-test.default_subject', 'Mail delivery test');

        $body = $this->option('body')
            ?: 'This is an automated mail delivery test from ' . config('app.name') . '. Sent at ' . now()->toDateTimeString() . '.';

        if ($this->option('debug')) {
            $this->showDebugInfo($to, $from, $mailer, $subject);
        }

        $this->info("Sending test email via [{$mailer}] to {$to}...");

        try {
            Mail::mailer($mailer)->raw($body, function ($message) use ($to, $from, $subject) {
                $message->to($to)->subject($subject);

                if ($from) {
                    $message->from($from);
                }
            });

            $this->info('Test email sent successfully.');

            Log::info('Mail test sent successfully.', [
                'to' => $to,
                'mailer' => $mailer,
                'subject' => $subject,
            ]);

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error('Failed to send test email: ' . $e->getMessage());

            Log::error('Mail test failed.', [
                'to' => $to,
                'mailer' => $mailer,
                'subject' => $subject,
                'error' => $e->getMessage(),
            ]);

            return self::FAILURE;
        }
    }

    private function showDebugInfo(string $to, ?string $from, string $mailer, string $subject): void
    {
        $this->table(
            ['Setting', 'Value'],
            [
                ['Recipient', $to],
                ['Sender', $from ?: '(global default)'],
                ['Mailer', $mailer],
                ['Subject', $subject],
                ['App', (string) config('app.name')],
                ['Environment', (string) app()->environment()],
            ]
        );
    }
}
