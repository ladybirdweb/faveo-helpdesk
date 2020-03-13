<?php

//Check if we are getting the image
if (isset($_FILES['image'])) {
    //Get the image array of details
    $img = $_FILES['image'];
    //The new path of the uploaded image, rand is just used for the sake of it
    $path = 'upload/'.rand().$img['name'];
    //Move the file to our new path
    move_uploaded_file($img['tmp_name'], $path);
    //Get image info, reuiqred to biuld the JSON object
    $data = getimagesize($path);
    //The direct link to the uploaded image, this might varyu depending on your script location
    $link = "http://$_SERVER[HTTP_HOST]".'/codex/'.$path;
    //Here we are constructing the JSON Object
    $res = ['upload' => [
        'links' => ['original' => $link],
        'image' => ['width' => $data[0],
            'height'        => $data[1],
        ],
    ]];
    //echo out the response :)
    echo json_encode($res);
}
