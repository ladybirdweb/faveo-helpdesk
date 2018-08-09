<?php

namespace App\Console\Commands;

use App\Http\Controllers\Installer\helpdesk\InstallController;
use Illuminate\Console\Command;

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
                $this->call('key:generate', ['--force' => true]);
                $this->call('install:migrate');
                $this->call('install:seed');
                $headers = ['user_name', 'email', 'password'];
                $data = [
                    [
                        'user_name' => 'demo_admin',
                        'email'     => '',
                        'password'  => 'password',
                    ],
                ];
                $this->table($headers, $data);
                $this->warn('Please change the password immediately');
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
        if (str_finish($url, '/')) {
            $url = rtrim($url, '/ ');
        }
        $systems = new \App\Model\helpdesk\Settings\System();
        $system = $systems->updateOrCreate(['id'=>1], [
            'url'=> $url,
        ]);
        $this->info('Thank you! Faveo has been installed successfully');
    }
}
