<?php

$term = $_GET["term"];
$users = app\User::where('email', 'LIKE', '%' . $term . '%')->where('active', '=', 1)->get();
// $users = app\User::where('active', '=', 1)->get();
// dd($users);
$json = array();

foreach ($users as $user) {

    $json[] = array(
    'value' => $user["email"],
    'label' => 'Name: '.$user["first_name"] .' '.$user["last_name"].' | '.('Email: <'.$user["email"].'>'),
    'autoname' => $user["email"],
    // 'autoname' => $user["user_name"],
    // 'first_name' => $user["first_name"],
    // 'last_name' => $user["last_name"],
    // 'country_code' => $user["country_code"],
    // 'mobile' => $user["mobile"],
    // 'phone_number' => $user["phone_number"]

    );
}
// dd($json);
echo json_encode($json);
// dd($json);
