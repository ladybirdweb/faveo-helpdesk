<?php

namespace App\Plugins\Telephony\Controllers\Exotel;

use App\Http\Controllers\Controller;
use App\Plugins\Telephony\Model\Core\Telephone;
use Exception;
use App\Plugins\Telephony\Model\Core\TelephoneDetail;
use Illuminate\Http\Request;

class ExotelController extends Controller {
    
    public function setSettings(){
        $settings = new \App\Plugins\Telephony\Controllers\Core\SettingsController();
        return $settings;
    }


    public function passThrough(Request $request){
        $callid = $request->input('CallSid');
        $provider = "exotel";
        $requests = $request->except('CallSid');
        $requ = $this->setParameter($requests);
        $settings = $this->setSettings();
        $settings->saveCall($callid,$provider,$requ);
    }
    
    public function setParameter($requests){
        $settings = $this->setSettings();
        return[
            'from'=>$settings->checkKey('From',$requests),//$requests['From'],
            'to'=>$settings->checkKey('To',$requests),//$requests['To'],
            'record'=>$settings->checkKey('RecordingUrl',$requests),//$requests['RecordingUrl'],
            'toWhom'=>$settings->checkKey('DialWhomNumber',$requests),//$requests['DialWhomNumber'],
            'date'=>$settings->checkKey('Created',$requests),//$requests['Created'],
        ];
    }
    
    
    public function getValues(){
        $values = $this->dummyValues();
        echo "<form action='".url('telephone/exotel/pass')."' name='redirect'>";
        echo $values;
        echo '</form>';
        echo "<script language='javascript'>document.redirect.submit();</script>";
    }
    
    public function dummyValues(){
        $values = "";
        $json = '{"CallSid":"d95feaed6383fb24d71a6756126d5350","From":"08042096073","To":"08033172870","Direction":"incoming","DialCallDuration":"13","StartTime":"2016-08-17 19:42:43","EndTime":"0000-00-00 00:00:00","CallType":"completed","RecordingUrl":"https:\/\/s3-ap-southeast-1.amazonaws.com\/exotelrecordings\/laad5\/d95feaed6383fb24d71a6756126d5350.mp3","DialWhomNumber":"09663218862","Created":"Wed, 17 Aug 2016 19:42:43","RecordingAvailableBy":"Wed, 17 Aug 2016 19:47:58","flow_id":"107722","tenant_id":"42758","CallFrom":"08042096073","CallTo":"08033172870","DialCallStatus":"completed","CurrentTime":"2016-08-17 19:42:58"}';
        $array = json_decode($json);
        foreach($array as $key=>$value){
            $values .="<input type='text' name='".$key."' value='".$value."'>"; 
        }
        return $values;
    }
    
}
