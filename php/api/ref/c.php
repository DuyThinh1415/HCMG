<?php
    //header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    //initializing 
    include_once('../core/initialize.php');
?>

<?php
function check($name, $year){
    if ($name=="" || $year=="Year") return false;
    return (5<=strlen($name) && strlen($name)<=40);
}
?>

<?php
    //instantiate car
    $car = new Car($db);

    $alterName = $_POST['e_carName'];
    $alterYear = $_POST['e_carYear'];
    if (check($alterName, $alterYear)){
        $car->id = $_POST['e_carID'];
        $car->name = $alterName;
        $car->year = $alterYear;
    
        //update car
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
    }
    else{
        echo json_encode( array('message' => 'Error: invalid input.') );
    }

?>