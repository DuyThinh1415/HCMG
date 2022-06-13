<?php
    //header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    //initializing 
    include_once('../core/initialize.php');

    //instantiate car
    $car = new Car($db);

    //get raw data
    $data = json_decode(file_get_contents("php://input"));

    $car->name = $data->name;
    $car->year = $data->year;

    //create car
    if ($car->create()){
        echo json_encode(
            array('message' => 'New record created.')
        );
    }
    else{
        echo json_encode(
            array('message' => 'Error: cannot create.')
        );
    }
?>