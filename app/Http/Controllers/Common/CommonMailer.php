<?php

namespace App\Http\Controllers\Common;

use Exception;

class CommonMailer
{
    public function setSmtpDriver($config)
    {
        try {
            if (! $config) {
                return false;
            }
            $https = [];
            $https['ssl']['verify_peer'] = false;
            $https['ssl']['verify_peer_name'] = false;
            $transport = new \Swift_SmtpTransport($config['host'], $config['port'], $config['security']);
            $transport->setUsername($config['username']);
            $transport->setPassword($config['password']);
            $transport->setStreamOptions($https);
            $set = new \Swift_Mailer($transport);

            // Set the mailer
            \Mail::setSwiftMailer($set);

            return true;
        } catch (Exception $e) {
            loging('mail-config', $e->getMessage());

            return $e->getMessage();
        }
    }

    public function setMailGunDriver($config)
    {
        if (! $config) {
            return false;
        }

        return true;
    }
}
