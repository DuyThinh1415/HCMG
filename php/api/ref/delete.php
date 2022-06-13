<?php
     //header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    //initializing 
    include_once('../core/initialize.php');

    //instantiate car
    $car = new Car($db);

    //get raw data
    $data = json_decode(file_get_contents("php://input"));

    $car->id = $data->id;

    //delete car
    if ($car->delete()){
        echo json_encode(
            array('message' => 'Car deleted.')
        );
    }
    else{
        echo json_encode(
            array('message' => 'Error: cannot delete.')
        );
    }
?>