<?php
    //header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    //initializing 
    include_once('../core/initialize.php');

    //instantiate car
    $car = new Car($db);

    //get raw data
    $data = json_decode(file_get_contents("php://input"));

    $car->id = $data->id;
    $car->name = $data->name;
    $car->year = $data->year;

    //create car
    if ($car->update()){
        echo json_encode(
            array('message' => 'Car updated.')
        );
    }
    else{
        echo json_encode(
            array('message' => 'Error: cannot update.')
        );
    }
?>