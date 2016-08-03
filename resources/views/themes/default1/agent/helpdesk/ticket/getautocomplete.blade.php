<?php

$term=$_GET["term"];
$users = app\User::where('email', 'LIKE', '%'.$term.'%')->where('active', '=', 1)->get();
  
$json=array();
 
    foreach ($users as $user) {
   
        $json[] = array(
            'value'=> $user["email"],
            'label'=>'Name: '.$user["first_name"] .' '.$user["last_name"].' | '.('Email: <'.$user["email"].'>'),
            'email' =>$user["email"],
            'user_name' =>$user["user_name"],
            'first_name' =>$user["first_name"],
            'last_name' =>$user["last_name"]
        );
    }

echo json_encode($json);