<?php

namespace Database\Seeders\v_2_0_0;

use App\Model\MailJob\MailService;
use App\Model\MailJob\QueueService;
use Illuminate\Database\Seeder;

class OutboundMailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mail = new MailService();
        $mail_services = ['smtp' => 'SMTP', 'mail' => 'Php Mail', 'sendmail' => 'Send Mail', 'mailgun' => 'Mailgun', 'mandrill' => 'Mandrill', 'log' => 'Log file'];
        foreach ($mail_services as $key => $value) {
            $mail->create([
                'name'       => $value,
                'short_name' => $key,
            ]);
        }

        $queue = new QueueService();
        $services = ['sync' => 'Sync', 'database' => 'Database', 'beanstalkd' => 'Beanstalkd', 'sqs' => 'SQS', 'iron' => 'Iron', 'redis' => 'Redis'];
        foreach ($services as $key => $value) {
            $queue->create([
                'name'       => $value,
                'short_name' => $key,
                'status'     => 0,
            ]);
        }
        $q = $queue->where('short_name', 'sync')->first();
        if ($q) {
            $q->status = 1;
            $q->save();
        }
    }
}
