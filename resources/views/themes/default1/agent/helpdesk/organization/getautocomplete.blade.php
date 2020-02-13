<?php

$term = $_GET["term"];
$organizations =App\Model\helpdesk\Agent_panel\Organization::where('name', 'LIKE', '%' . $term . '%')->get();
$json = array();

foreach ($organizations as $organization) {

    $json[] = array(
    'value' => $organization["name"],
     'label' => $organization["name"],
    
    'org' => $organization["name"],
   

    );
}

echo json_encode($json);