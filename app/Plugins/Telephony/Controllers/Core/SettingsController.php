<?php

namespace App\Plugins\Telephony\Controllers\Core;

use App\Http\Controllers\Controller;
use Schema;
use Artisan;
use App\Plugins\Telephony\Model\Core\Telephone;
use App\Plugins\Telephony\database\seeds\TelephonySeeder;
use Exception;
use App\Plugins\Telephony\Model\Core\TelephoneDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Agent\helpdesk\TicketController;

class SettingsController extends Controller {

    public function settings() {
        try {
            $telephone = new Telephone();
            return view("telephone::core.settings", compact('telephone'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function activate() {
        if (env('DB_INSTALL') == 1 && !Schema::hasTable('telephone_providers')) {
            $path = "app" . DIRECTORY_SEPARATOR . "Plugins" . DIRECTORY_SEPARATOR . "Telephony" . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "migrations";
            Artisan::call('migrate', [
                '--path' => $path,
                '--force' => true,
            ]);
            $this->seed();
        }
    }

    public function seed() {
        $seeder = new TelephonySeeder();
        $seeder->run();
    }

    public function settingsProvider($short) {
        try {
            $telephones = new Telephone();
            $telephone = $telephones->where('short', $short)->first();
            $details = new TelephoneDetail();
            $name = $telephone->name;
            return view("telephone::$short.settings", compact('details', 'short', 'name'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function postSettingsProvider($short, Request $request) {
        try {
            $requests = $request->except('_token');
            $this->updateDetails($requests, $short);
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function updateDetails($requests, $short) {
        $details = new TelephoneDetail();
        if (count($requests) > 0) {
            foreach ($requests as $key => $value) {
                //$this->deleteDetails($key, $short);
                $details->create([
                    'provider' => $short,
                    'key' => $key,
                    'value' => $value,
                ]);
            }
        }
    }

    public function deleteDetails($key, $short) {
        $details = new TelephoneDetail();
        $detail = $details->where('provider', $short)->where('key', $key)->first();
        if ($detail) {
            $detail->delete();
        }
    }

    public function saveCall($callid, $provider, $request) {
        $calls = new \App\Plugins\Telephony\Model\Core\TelephoneCall();
        if (count($request) > 0) {
            foreach ($request as $key => $value) {
                $calls->create([
                    'callid' => $callid,
                    'provider' => $provider,
                    'key' => $key,
                    'value' => $value,
                ]);
            }
            $ticket = $this->createTicket($request);
            $this->saveTicketId($ticket, $provider);
        }
    }

    public function saveTicketId($ticket, $provider) {
        if ($ticket) {
            $ticketid = $ticket->id;
            $request = ['ticket_id' => $ticketid];
            $this->updateDetails($request, $provider);
        }
    }

    public function checkKey($key, $array) {
        $value = "";
        if (array_key_exists($key, $array)) {
            $value = $array[$key];
        }
        return $value;
    }

    public function getTicketControl() {
        $PhpMailController = new \App\Http\Controllers\Common\PhpMailController();
        $NotificationController = new \App\Http\Controllers\Common\NotificationController();
        $ticketController = new TicketController($PhpMailController, $NotificationController);
        return $ticketController;
    }

    public function createTicket($request) {
        $ticket_controller = $this->getTicketControl();
        $email = NULL;
        $username = $this->checkKey('from', $request);
        $body = $this->ticketBody($request);
        $sla = $ticket_controller->getSystemDefaultSla();
        $priority = $ticket_controller->getSystemDefaultPriority();
        $department = $ticket_controller->getSystemDefaultDepartment();
        $helptopic = $ticket_controller->getSystemDefaultHelpTopic();
        $phone = $this->checkKey('from', $request);
        $phonecode = "";
        $mobile = $this->checkKey('from', $request);
        $source = $ticket_controller->getSourceByname('call')->id;
        $headers = [];
        $assignto = NULL;
        $from_data = [];
        $auto_response = "";
        $status = "";
        $subject = "New Call";
        $result = $ticket_controller->create_user($email, $username, $subject, $body, $phone, $phonecode, $mobile, $helptopic, $sla, $priority, $source, $headers, $department, $assignto, $from_data, $auto_response, $status);
        $ticket = $ticket_controller->findTicketFromTicketCreateUser($result);
        return $ticket;
    }

    public function ticketBody($request) {
        $html = "";
        $recored = $this->checkKey('record', $request);
        $created = $this->checkKey('date', $request);
        if ($recored !== "") {
            $html = \Lang::get('telephone::lang.listen-to-call-recording')."<br><audio controls>
                        <source src='" . $recored . "' type='audio/ogg'>
                        <source src='" . $recored . "' type='audio/mpeg'>
                      Your browser does not support the audio element.
                      </audio><br>".\Lang::get('telephone::lang.incoming-call-recieved-on'). " ". $created;
        }
        return $html;
    }

}
