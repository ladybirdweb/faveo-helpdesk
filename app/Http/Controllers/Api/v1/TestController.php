<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller {

    public $server;

    public function __construct() {
        $server = new Request();
        $url = $_SERVER['REQUEST_URI'];
        $server = parse_url($url);
        $server["path"] = dirname($server["path"]);
        $server = parse_url($server["path"]);
        $server["path"] = dirname($server["path"]);
        $this->server = "http://" . $_SERVER['HTTP_HOST'] . $server['path'] . "/";
    }

    static function CallGetApi($url) {
        //dd($url);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'error:' . curl_error($curl);
        }

        return $response;
        curl_close($curl);
    }

    static function CallPostApi($url, $data) {
        //dd($url);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'error:' . curl_error($curl);
        }

        return $response;
        curl_close($curl);
    }

    public function TicketReply() {
        
        //$file = file_get_contents(base_path() . '/../lb-faveo/Img/Ladybird.png');
        
        $data = [

            'ticket_ID' => '4',
            'ReplyContent' => 'reply for the ticket id',
            'api-key' => 'clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg',
//            'attachments' => [
//                [
//                    'name' => 'ladybird',
//                    'size' => '26398',
//                    'type' => 'png',
//                    'file' => $file,
//                ],
//                [
//                    'name' => 'ladybird',
//                    'size' => '26398',
//                    'type' => 'png',
//                    'file' => $file,
//                ]
//            ],
        ];
        $data = http_build_query($data, '', '&');

        $url = $this->server . "helpdesk/reply?token=" . \Config::get('app.token');

        $_this = new self();
        $respose = $_this->CallPostApi($url, $data);
        return $respose;
    }

    public function CreateTicket() {

        //$file = file_get_contents(base_path() . '/../lb-faveo/Img/Ladybird.png');

        $data = [
            'user_id' => 1,
            'subject' => 'Api create via faveo api',
            'body' => 'Test me when call api',
            'helptopic' => '1',
            'sla' => '1',
            'priority' => '1',
            'headers' => [0 => 'vijaycodename47@gmail.com'],
            'dept' => '1',
            'assignto' => '0',
            'source' => 'api',
            'api-key' => 'clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg',
            /** if attachment */
//            'attachments' => [
//                [
//                    'name' => 'ladybird',
//                    'size' => '26398',
//                    'type' => 'png',
//                    'file' => $file,
//                ],
//                [
//                    'name' => 'ladybird',
//                    'size' => '26398',
//                    'type' => 'png',
//                    'file' => $file,
//                ]
//            ],
        ];
        $data = http_build_query($data, '', '&');

        $url = $this->server . "helpdesk/create?token=" . \Config::get('app.token');

        $_this = new self();
        $respose = $_this->CallPostApi($url, $data);
        return $respose;
    }

    public function GenerateToken() {
        $data = [
            //'email'=>'vijaycodename47@gmail.com',
            'username' => 'vijay',
            'password' => 'manjapra',
            'api-key' => 'clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg'
        ];

        $data = http_build_query($data, '', '&');

        $url = $this->server . "authenticate";
        //dd($url);
        $_this = new self();
        $respose = $_this->CallPostApi($url, $data);
        return $respose;
    }

    public function CreateUser() {
        $data = [
            'email' => 'vijaycodename@gmail.com',
            'password' => 'manjapra',
            'api-key' => 'clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg'
        ];

        $data = http_build_query($data, '', '&');
        $url = $this->server . "register";
        $_this = new self();
        $respose = $_this->CallPostApi($url, $data);
        return $respose;
    }

    public function GetAuthUser() {

        $url = $this->server . "authenticate/user?api-key=clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg&token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function EditTicket() {
        $data = [
            'ticket_id' => '4',
            'subject' => 'Api editing ticket via faveo api',
            'sla_plan' => '2',
            'help_topic' => '2',
            'ticket_source' => '2',
            'api-key' => 'clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg',
            'ticket_priority' => '2',
        ];

        $data = http_build_query($data, '', '&');
        $url = $this->server . "helpdesk/edit?token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallPostApi($url, $data);
        return $respose;
    }

    public function DeleteTicket() {
        $data = [
            'ticket_id' => [],
            'api-key' => 'clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg'
        ];

        $data = http_build_query($data, '', '&');
        $url = $this->server . "helpdesk/delete?token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallPostApi($url, $data);
        return $respose;
    }

    public function OpenedTickets() {
        $url = $this->server . "helpdesk/open?api-key=clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg&token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function UnassignedTickets() {
        $url = $this->server . "helpdesk/unassigned?api-key=clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg&token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function CloseTickets() {
        $url = $this->server . "helpdesk/closed?api-key=clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg&token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function GetAgents() {
        $url = $this->server . "helpdesk/agents?api-key=clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg&token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function GetTeams() {
        $url = $this->server . "helpdesk/teams?api-key=clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg&token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function AssignTicket() {
        $data = [
            'ticket_id' => '8',
            'user' => 'vijay.sebastian@ladybird.com',
            'api-key' => 'clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg'
        ];
        $data = http_build_query($data, '', '&');
        $url = $this->server . "helpdesk/assign?token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallPostApi($url, $data);
        return $respose;
    }

    public function GetCustomers() {
        $search = [
            'search' => 'vij',
            'api-key' => 'clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg'
        ];
        $data = http_build_query($search, '', '&');
        $url = $this->server . "helpdesk/customers?token=" . \Config::get('app.token');
        $url = $url . '&' . $data;
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function GetCustomer() {
        $search = [
            'user_id' => '1',
            'api-key' => 'clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg'
        ];
        $data = http_build_query($search, '', '&');
        $url = $this->server . "helpdesk/customer?token=" . \Config::get('app.token');
        $url = $url . '&' . $data;
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function GetSearch() {
        $search = [
            'search' => 'api',
            'api-key' => 'clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg'
        ];
        $data = http_build_query($search, '', '&');
        $url = $this->server . "helpdesk/ticket-search?token=" . \Config::get('app.token');
        $url = $url . '&' . $data;
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function TicketThreads() {
        $search = [
            'id' => '8',
            'api-key' => 'clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg'
        ];
        $data = http_build_query($search, '', '&');
        $url = $this->server . "helpdesk/ticket-thread?token=" . \Config::get('app.token');
        $url = $url . '&' . $data;
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function Url() {
        $search = [
            'url' => 'http://localhost/Faveo-HelpDesk-My-Branch/public/',
            'api-key' => 'clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg'
        ];
        $data = http_build_query($search, '', '&');
        $url = $this->server . "helpdesk/url?token=" . \Config::get('app.token');
        $url = $url . '&' . $data;
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function GenerateApiKey() {
        $url = $this->server . "helpdesk/api-key?api-key=clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg&token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function GetHelpTopic() {
        $url = $this->server . "helpdesk/help-topic?api-key=clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg&token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function GetSlaPlan() {
        $url = $this->server . "helpdesk/sla-plan?api-key=clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg&token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function GetPriority() {
        $url = $this->server . "helpdesk/priority?api-key=clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg&token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function GetDepartment() {
        $url = $this->server . "helpdesk/department?api-key=clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg&token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function GetTickets() {
        $url = $this->server . "helpdesk/tickets?api-key=clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg&token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }

    public function Inbox() {
        $url = $this->server . "helpdesk/inbox?api-key=clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg&token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallGetApi($url);
        return $respose;
    }
    
    public function InternalNote() {
        $data = [
            'ticketid' => '23',
            'userid' => 1,
            'body' => 'Testing the api internal note',
            'api-key' => 'clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg'
        ];
        $data = http_build_query($data, '', '&');
        $url = $this->server . "helpdesk/internal-note?token=" . \Config::get('app.token');
        $_this = new self();
        $respose = $_this->CallPostApi($url, $data);
        return $respose;
    }

}
