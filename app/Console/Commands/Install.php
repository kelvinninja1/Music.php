<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs the application, assuming prerequisites are met.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = $this->laravel->environmentFilePath();
        $this->call('passport:install');
        $client = Illuminate\Support\Facades\DB::table('oauth_clients')->where('password_client', 1)->first();
        /**
         * This is the Laravel 5.4 method of replacing environment values which
         * is more to date. It's quite complicated however, so it only remains
         * here for reference purposes.
         */
        // file_put_contents($this->laravel->environmentFilePath(), preg_replace(
        //     $this->keyReplacementPattern(),
        //     'PASSWORD_CLIENT_ID='.$passwordClient->id,
        //     file_get_contents($this->laravel->environmentFilePath())
        // ));
        file_put_contents($path, str_replace(
            'PASSWORD_CLIENT_ID='.env('PASSWORD_CLIENT_ID'), 'PASSWORD_CLIENT_ID='.$client->id, file_get_contents($path)
        ));
        file_put_contents($path, str_replace(
            'PASSWORD_CLIENT_SECRET='.env('PASSWORD_CLIENT_SECRET'), 'PASSWORD_CLIENT_SECRET='.$client->secret, file_get_contents($path)
        ));
        // $this->call('passport:install', [
        //     'user' => 1, '--queue' => 'default'
        // ]);
    }
}
