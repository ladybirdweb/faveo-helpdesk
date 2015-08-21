<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Psy\Util\String;
use View;
use Session;
use Input;
use Response;
use App\Message;
use Illuminate\Http\Request;

    class MessageController extends Controller {
     
        /**
         * show a view with form to create settings
         */
        public function add() {
            return View::make( 'settings/new' );
        }
     
        /**
         * handle data posted by ajax request
         */
        public function create(Message $message) {
            //check if its our form
            if ( Session::token() !== Input::get( '_token' ) ) {
                return Response::json( array(
                    'msg' => 'Unauthorized attempt to create setting'
                ) );
            }
     
            $message->message_title = Input::get( 'setting_name' );
            $message->message = Input::get( 'setting_value' );
     $message->save();
            //.....
            //validate data
            //and then store it in DB
            //.....
     
            $response = array(
                'status' => 'success',
                'msg' => 'Setting created successfully',
            );
     
            return Response::json( $response );
        }
        public function show($id){
//        echo $response;
//            $id = json_decode($response);
            $message = Message::whereId($id)->first();
           $msg = $message->message; 
          
     return Response::json( $msg );
           //return \Redirect::back()->with('msg' , $msg);
        }
        
    //end of class
        
    }