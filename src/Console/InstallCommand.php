<?php

namespace Laravel\Asterisk\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asterisk:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the Asterisk Config files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', ['--tag' => 'asterisk-config']);

        file_put_contents(
            $this->laravel->basePath('docker-compose.yml'),
            str_replace(
                [
                    './vendor/paxha/laravel-asterisk/config',
                ],
                [
                    './asterisk/config',
                ],
                file_get_contents($this->laravel->basePath('docker-compose.yml'))
            )
        );
    }
}