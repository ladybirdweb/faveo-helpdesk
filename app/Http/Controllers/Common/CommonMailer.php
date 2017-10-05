<?php

namespace App\Http\Controllers\Common;

use Exception;

class CommonMailer
{
    public function setSmtpDriver($config)
    {
        try {
            if (!$config) {
                return false;
            }

            $transport = \Swift_SmtpTransport::newInstance($config['host'], $config['port'], $config['security'])
                    ->setStreamOptions(['ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                ],
            ]);
            $transport->setUsername($config['username']);
            $transport->setPassword($config['password']);
            $set = new \Swift_Mailer($transport);
            // Set the mailer
            \Mail::setSwiftMailer($set);

            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function setMailGunDriver($config)
    {
        if (!$config) {
            return false;
        }

        return true;
    }
}
