<?php

namespace App\Plugins\Zapier\Controllers\HappyFoxChat;

use App\Http\Controllers\Controller;

class ProcessController extends Controller {

    private $request;
    
    public function __construct($requests) {
        $this->request = $requests;
    }
    /**
     * get the name
     * @return string
     */
    public function name() {
        $name = $this->checkArray('name', $this->request);
        return $name;
    }
    /**
     * get email
     * @return string
     */
    public function email() {
        $email = $this->checkArray('email', $this->request);
        return $email;
    }
    /**
     * get message
     * @return string
     */
    public function message() {
        $message = $this->checkArray('message', $this->request);
        return $message;
    }
    /**
     * get visitor phone number
     * @return string
     */
    public function phone() {
        return "";
    }
    /**
     * get visitor's phone code
     * @return string
     */
    public function phoneCode() {
        return "";
    }
    /**
     * get visitor's mobile number
     * @return string
     */
    public function mobile() {
        return "";
    }
    /**
     * get the application name
     * @return string
     */
    public function channel() {
        $app = $this->checkArray('app', $this->request);
        return $app;
    }
    /**
     * get ticket created through
     * @return string
     */
    public function via() {
        return "chat";
    }
    /**
     * subject of the ticket
     * @return string
     */
    public function subject() {
        return "Chat from HappyFox Chat";
    }
    /**
     * get the value of an array using key
     * @param string $key
     * @param array $array
     * @return string
     */
    public function checkArray($key, $array) {
        $value = "";
        if (array_key_exists($key, $array)) {   
            $value = $array[$key];
        }
        return $value;
    }

}
