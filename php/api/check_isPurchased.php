<?php
    //header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    //initializing 
    include_once('../core/initialize.php');

    //instantiate prod
    $user = new User($db);
    $prod = new Product($db);

    //set User_id and get all Product_id in this user library
    $user->User_id = $_POST['User_id'];
    $user->get_gameLib();

    //Check $_POST['Product_id'] is existed in user's library
    $checker = false;
    foreach ($user->gameLib as $item){
        if ($item['Product_id'] == $_POST['Product_id']){
            $checker = true;
            break;
        }
    }

    echo json_encode(array('checker' => $checker));
?>