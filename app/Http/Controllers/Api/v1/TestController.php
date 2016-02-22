<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public $server;

    public function __construct()
    {
        $server = new Request();
        $url = $_SERVER['REQUEST_URI'];
        $server = parse_url($url);
        $server['path'] = dirname($server['path']);
        $server = parse_url($server['path']);
        $server['path'] = dirname($server['path']);
        $this->server = 'http://'.$_SERVER['HTTP_HOST'].$server['path'].'/';
    }

    public static function callGetApi($url)
    {
        //dd($url);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'error:'.curl_error($curl);
        }

        return $response;
        curl_close($curl);
    }

    public static function callPostApi($url, $data)
    {
        //dd($url);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'error:'.curl_error($curl);
        }

        return $response;
        curl_close($curl);
    }

    public function ticketReply()
    {

        //$file = file_get_contents(base_path() . '/../lb-faveo/Img/Ladybird.png');

        $data = [

            'ticket_ID'     => '1',
            'reply_content' => 'reply for the ticket id',
            'api_key'       => '9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN',
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

        $url = $this->server.'helpdesk/reply?token='.\Config::get('app.token');

        $_this = new self();
        $respose = $_this->callPostApi($url, $data);

        return $respose;
    }

    public function createTicket()
    {

        //$file = file_get_contents(base_path() . '/../lb-faveo/Img/Ladybird.png');

        $data = [
            'user_id'   => 1,
            'subject'   => 'Api create via faveo api',
            'body'      => 'Test me when call api',
            'helptopic' => '1',
            'sla'       => '1',
            'priority'  => '1',
            'headers'   => [0 => 'vijaycodename47@gmail.com'],
            'dept'      => '1',
            'api_key'   => '9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN',
                /* if attachment */
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

        $url = $this->server.'helpdesk/create?token='.\Config::get('app.token');

        $_this = new self();
        $respose = $_this->callPostApi($url, $data);

        return $respose;
    }

    public function generateToken()
    {
        $data = [
            //'email'=>'vijaycodename47@gmail.com',
            'username' => 'vijay',
            'password' => 'manjapra',
            'api_key'  => '9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN',
        ];

        $data = http_build_query($data, '', '&');

        $url = $this->server.'authenticate';
        //dd($url);
        $_this = new self();
        $respose = $_this->callPostApi($url, $data);

        return $respose;
    }

    public function createUser()
    {
        $data = [
            'email'    => 'vijaycodename@gmail.com',
            'password' => 'manjapra',
            'api_key'  => '9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN',
        ];

        $data = http_build_query($data, '', '&');
        $url = $this->server.'register';
        $_this = new self();
        $respose = $_this->callPostApi($url, $data);

        return $respose;
    }

    public function getAuthUser()
    {
        $url = $this->server.'authenticate/user?api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function editTicket()
    {
        $data = [
            'ticket_id'       => '13',
            'subject'         => 'Api editing ticket via faveo api',
            'sla_plan'        => '2',
            'help_topic'      => '2',
            'ticket_source'   => '2',
            'api_key'         => '9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN',
            'ticket_priority' => '2',
        ];

        $data = http_build_query($data, '', '&');
        $url = $this->server.'helpdesk/edit?token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callPostApi($url, $data);

        return $respose;
    }

    public function deleteTicket()
    {
        $data = [
            'ticket_id' => [11],
            'api_key'   => '9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN',
        ];

        $data = http_build_query($data, '', '&');
        $url = $this->server.'helpdesk/delete?token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callPostApi($url, $data);

        return $respose;
    }

    public function openedTickets()
    {
        $url = $this->server.'helpdesk/open?api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function unassignedTickets()
    {
        //dd('dsdf');
        $url = $this->server.'helpdesk/unassigned?api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callGetApi($url);
        //dd($respose);
        return $respose;
    }

    public function closeTickets()
    {
        $url = $this->server.'helpdesk/closed?api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function getAgents()
    {
        $url = $this->server.'helpdesk/agents?api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function getTeams()
    {
        $url = $this->server.'helpdesk/teams?api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function assignTicket()
    {
        $data = [
            'ticket_id' => 1,
            'user'      => 'vijay.sebastian@ladybirdweb.com',
            'api_key'   => '9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN',
        ];
        $data = http_build_query($data, '', '&');
        $url = $this->server.'helpdesk/assign?token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callPostApi($url, $data);

        return $respose;
    }

    public function getCustomers()
    {
        $search = [
            'search'  => 'vij',
            'api_key' => '9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN',
        ];
        $data = http_build_query($search, '', '&');
        $url = $this->server.'helpdesk/customers?token='.\Config::get('app.token');
        $url = $url.'&'.$data;
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function getCustomer()
    {
        $search = [
            'user_id' => '1',
            'api_key' => '9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN',
        ];
        $data = http_build_query($search, '', '&');
        $url = $this->server.'helpdesk/customer?token='.\Config::get('app.token');
        $url = $url.'&'.$data;
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function getSearch()
    {
        $search = [
            'search'  => 'api',
            'api_key' => '9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN',
        ];
        $data = http_build_query($search, '', '&');
        $url = $this->server.'helpdesk/ticket-search?token='.\Config::get('app.token');
        $url = $url.'&'.$data;
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function ticketThreads()
    {
        $search = [
            'id'      => '1',
            'api_key' => '9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN',
        ];
        $data = http_build_query($search, '', '&');
        $url = $this->server.'helpdesk/ticket-thread?token='.\Config::get('app.token');
        $url = $url.'&'.$data;
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function url()
    {
        $search = [
            'url'     => 'http://localhost/faveo-helpdesk-github/public/',
            'api_key' => '9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN',
        ];
        $data = http_build_query($search, '', '&');
        $url = $this->server.'helpdesk/url?token='.\Config::get('app.token');
        $url = $url.'&'.$data;
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function generateApiKey()
    {
        $url = $this->server.'helpdesk/api_key?api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function getHelpTopic()
    {
        $url = $this->server.'helpdesk/help-topic?api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function getSlaPlan()
    {
        $url = $this->server.'helpdesk/sla-plan?api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function getPriority()
    {
        $url = $this->server.'helpdesk/priority?api_key=clYbe1g7BYVEJznBdvCEBR0xDCLDqKgg&token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function getDepartment()
    {
        $url = $this->server.'helpdesk/department?api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function getTickets()
    {
        $url = $this->server.'helpdesk/tickets?api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function inbox()
    {
        $url = $this->server.'helpdesk/inbox?api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function internalNote()
    {
        $data = [
            'ticketid' => '1',
            'userid'   => 1,
            'body'     => 'Testing the api internal note',
            'api_key'  => '9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN',
        ];
        $data = http_build_query($data, '', '&');
        $url = $this->server.'helpdesk/internal-note?token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callPostApi($url, $data);

        return $respose;
    }

    public function trash()
    {
        $url = $this->server.'helpdesk/trash?api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token='.\Config::get('app.token');
        $_this = new self();
        $respose = $_this->callGetApi($url);

        return $respose;
    }

    public function myTickets()
    {
        try {
            $url = $this->server.'helpdesk/my-tickets?user_id=1&api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token='.\Config::get('app.token');
            $_this = new self();
            $respose = $_this->callGetApi($url);

            return $respose;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        }
    }

     public function getTicketById(){
        try{
            $url = $this->server . "helpdesk/my-tickets?id=1&api_key=9p41T2XFZ34YRZJUNQAdmM7iV0Rr1CjN&token=" . \Config::get('app.token');
            $_this = new self();
            $respose = $_this->callGetApi($url);
            return $respose;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();
            return response()->json(compact('error', 'file', 'line'));
        }
    }


}
