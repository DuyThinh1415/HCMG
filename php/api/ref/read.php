<?php
    //header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    //initializing 
    include_once('../core/initialize.php');

    //instantiate car
    $car = new Car($db);

    //blog car query
    $result = $car->read();

    //get the row count
    $num = $result->rowCount();

    if ($num > 0){
        $car_arr = array();
        $car_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $car_item = array(
                'id' => $id,
                'name' => $name,
                'year' => $year
            );
            array_push($car_arr['data'], $car_item);
        }

        //convert to JSON and output
        echo json_encode($car_arr);
    }
    else {
        echo json_encode(array('message' => 'No cars found.'));
    }
?>