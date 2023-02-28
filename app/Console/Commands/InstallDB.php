<?php

namespace App\Console\Commands;

use App\Http\Controllers\Installer\helpdesk\InstallController;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'installing database';

    protected $install;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->install = new InstallController();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            if ($this->confirm('Do you want to migrate tables now?')) {
                $env = base_path().DIRECTORY_SEPARATOR.'.env';
                if (!is_file($env)) {
                    throw new \Exception("Please run 'php artisan install:faveo'");
                }
                $dummy_confirm = $this->confirm('Would you like to install dummy data in database to test before going live?');
                $this->call('key:generate', ['--force' => true]);
                if (!$dummy_confirm) {
                    $this->call('install:migrate');
                    $this->call('install:seed');
                } else {
                    $path = base_path().'/DB/dummy-data.sql';
                    DB::unprepared(file_get_contents($path));
                }
                $headers = ['user_name', 'email', 'password'];
                $data = [
                    [
                        'user_name' => 'demo_admin',
                        'email'     => '',
                        'password'  => 'demopass',
                    ],
                ];
                $this->table($headers, $data);
                $this->warn('Please update your email and change the password immediately');
                $this->install->updateInstalEnv();
                $this->updateAppUrl();
            }
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }
    }

    public function updateAppUrl()
    {
        $url = $this->ask('Enter your app url (with http/https and www/non www)');
        if (Str::finish($url, '/')) {
            $url = rtrim($url, '/ ');
        }
        $systems = new \App\Model\helpdesk\Settings\System();
        $system = $systems->first();
        $system->url = $url;
        $system->save();
        $this->info('Thank you! Faveo has been installed successfully');
    }
}
