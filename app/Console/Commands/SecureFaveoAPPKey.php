<?php

namespace App\Console\Commands;

//classes
use App\Model\helpdesk\Email\Emails;
use App\User;
use Artisan;
use Exception;
use File;
use Hash;
use Illuminate\Console\Command;
//Models
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Str;

class SecureFaveoAPPKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faveo:secure-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command updates the APP_KEY of the system keeping encrypted data intact with new key to make it easy for users to secure their app for old sahred key. Admin credentials are required to run this command successfully.';

    /**
     * @var array
     */
    private $email = [];

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
        $username = $this->ask('Enter admin account username');
        $password = $this->secret('Enter admin account password');
        if (!$username || !$password) {
            throw new Exception('Username and password are required.', 1);
        }
        if (!Hash::check($password, User::where('user_name', $username)->value('password'))) {
            throw new Exception('We do not recognize you, make sure the username or password you provided are correct.', 1);
        }

        if ($this->confirm('This will update APP_KEY in your environment which may invalidate all your encrypted URLs, such URLs will no longer work and result in 404. Do you wish to continue?', true)) {
            $this->info('That\'s a smart choice');
            $file = base_path().DIRECTORY_SEPARATOR.'.env';
            if (file_exists($file)) {
                $datacontent = File::get($file);
                $this->updateAppKey($file, $datacontent);
            }
            $this->line("\r\nAPP_KEY has been updated in the environment.");
            $this->line("\r\nNext you might want to check if your configured email is working fine or not. If it has any problem you can update the password and restart your queue workers if you are processing mail jobs in queue.\r\n");
            exit;
        }
        $this->info('Alright, calm down we did not make any changes to your environment. But if you think your APP_KEY was compromised or you were using Faveo without generating APP_KEY explicitly(for version v1.10.* or older) we recommend you to run this command on priority basis.');
    }

    /**
     * Function adds APP_KEY and generate new application key if does not
     * exist in .env.
     *
     * This method also updates the email passwords after new key generation
     * so that the imap/smtp does not stop working after update
     *
     * This method also updates the LDAP passwords after new key generation
     * so that the LDAP plugin does not stop working after update
     *
     * @param string $file
     * @param string $datacontent
     *
     * @return voif
     */
    private function updateAppKey(string $file, string $datacontent): void
    {
        $this->fetchAndStoreEmailPassword();
        if (!$this->doesEnvVaribaleExists($datacontent, 'APP_KEY')) {
            $datacontent = $datacontent."\r\nAPP_KEY=base64:h3KjrHeVxyE+j6c8whTAs2YI+7goylGZ/e2vElgXT6I=";
            File::put($file, $datacontent);
        }
        Artisan::call('key:generate', ['--force' => true]);
        Artisan::call('queue:restart');
        // If the key starts with "base64:", we will need to decode the key before handing
        // it off to the encrypter. Keys may be base-64 encoded for presentation and we
        // want to make sure to convert them back to the raw bytes before encrypting.
        if (Str::startsWith($key = $this->key(), 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }
        $encrypter = new Encrypter($key, config('app.cipher'));
        $this->updateEmailsPasswordWithNewKey($encrypter);
    }

    /**
     * Function checks if given $key exist in $envContent string.
     *
     * @param string $envContent
     * @param string $key
     *
     * @return bool true if given key exist otherwise false
     */
    private function doesEnvVaribaleExists(string $envContent, string $key): bool
    {
        return !(strpos($envContent, $key) === false);
    }

    /**
     * Function stores all emails and their passwords as key => value in $emails prop.
     *
     * @return void
     */
    private function fetchAndStoreEmailPassword(): void
    {
        $this->emails = Emails::all()->pluck('password', 'email_address')->toArray();
    }

    /**
     * Function updates all emails's password.
     *
     * @return void
     */
    private function updateEmailsPasswordWithNewKey($encrypter): void
    {
        foreach ($this->emails as $email => $password) {
            Emails::where('email_address', $email)->update([
                'password' => $encrypter->encrypt($password),
            ]);
        }
    }

    /**
     * Extract the encryption key from the given configuration.
     *
     * @param array $config
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    private function key()
    {
        return tap(config('app.key'), function ($key) {
            if (empty($key)) {
                throw new RuntimeException(
                    'No application encryption key has been specified.'
                );
            }
        });
    }
}
