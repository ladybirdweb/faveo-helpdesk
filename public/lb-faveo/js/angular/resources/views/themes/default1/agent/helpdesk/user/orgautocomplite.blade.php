<?php

$term = $_GET["term"];

// dd($term);
$Organizations =App\Model\helpdesk\Agent_panel\Organization::where('name', 'LIKE', '%' . $term . '%')->get();
$json = array();

foreach ($Organizations as $Organization) {

    $json[] = array(
    'value' => $Organization["name"],
     'label' => $Organization["name"],
 );
}

echo json_encode($json);