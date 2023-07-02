<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class MyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Logika perintah Anda di sini
        $process = new Process(['ls', '-l']);
        $process->run();

        if ($process->isSuccessful()) {
            $this->info($process->getOutput());
        } else {
            $this->error($process->getErrorOutput());
        }
    }
}
