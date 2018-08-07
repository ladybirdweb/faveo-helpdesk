<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateEncryption extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encryption';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This update the encryption value from old to AES-256-CBC';

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
        $emails = \App\Model\helpdesk\Email\Emails::get();

        foreach ($emails as $email) {
            $email->password = encrypt('password');
            $email->save();
        }
    }
}
