<?php
    //header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    //initializing 
    include_once('../core/initialize.php');

    //instantiate car
    $car = new Car($db);

    $car->id = isset($_GET['id']) ? $_GET['id'] : die();
    $car->read_single();

    $car_arr = array(
        'id' => $car->id,
        'name' => $car->name,
        'year' => $car->year,
    );

    //make a json
    echo json_encode($car_arr);
?>