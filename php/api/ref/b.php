<?php
    //header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    //initializing 
    include_once('../core/initialize.php');
?>

<?php
function check($name, $year){
    if ($name=="" || $year=="init") return false;
    if (5<=strlen($name) && strlen($name)<=40) return true;
    return false;
}
?>

<?php
    //instantiate car
    $car = new Car($db);

    //get raw data
    //$data = json_decode(file_get_contents("php://input"));

    if (check($_POST['carName'], $_POST['carYear'])){
        $car->name = $_POST['carName'];
        $car->year = $_POST['carYear'];

        //create car
        if ($car->create()) echo json_encode( array('message' => 'New record created.') );
        else echo json_encode( array('message' => 'Error: cannot create.') );

    }
    else echo json_encode( array('message' => 'Error: invalid input.') );
?>
