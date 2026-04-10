<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;


class StartApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:start-app';
    protected $signature = 'app:start {--host=0.0.0.0} {--port=8000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running npm build…');

        $npm = new Process(['npm', 'run', 'build']);
        $npm->setTimeout(null);
        $npm->run(function ($type, $buffer) {
            echo $buffer;
        });

        if (! $npm->isSuccessful()) {
            $this->error('npm build failed');
            return Command::FAILURE;
        }

        $this->info('Starting Laravel Octane (Swoole)…');

        $octane = new Process([
            'php',
            'artisan',
            'octane:start',
            '--server=swoole',
            '--host=' . $this->option('host'),
            '--port=' . $this->option('port'),
        ]);

        // IMPORTANT: keep process running
        $octane->setTimeout(null);
        $octane->run(function ($type, $buffer) {
            echo $buffer;
        });

        return Command::SUCCESS;
    }
}
