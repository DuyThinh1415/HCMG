<?php
    //header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    //initializing 
    include_once('../core/initialize.php');

    //instantiate car
    $auth = new Authentication($db);

    //get raw data
    if (!isset($_POST['username']) || $_POST['username'] == "") echo json_encode(array('message' => 'Please insert username', 'status' => 'fail'));
    else if (!isset($_POST['pass']) || $_POST['pass'] == "") echo json_encode(array('message' => 'Please insert password', 'status' => 'fail'));
    else if (!isset($_POST['repass']) || $_POST['repass'] == "") echo json_encode(array('message' => 'Please re-enter password', 'status' => 'fail'));
    else{
        $auth->User_name = $_POST['username'];
        $auth->User_password = md5(sha1(md5($_POST['pass'])));
        $auth_repass = md5(sha1(md5($_POST['repass'])));

        if ($auth->User_password === $auth_repass){
            //create new user
            if (!$auth->getByUser_name($auth->User_name)){
                if ($auth->create()){
                    session_start();
                    $_SESSION['User_id'] = $auth->User_id;
                    $_SESSION['User_name'] = $auth->User_name;
                    $_SESSION['isLogged'] = true;
                    $_SESSION['cartNum'] = 0;
                    echo json_encode(array('message' => 'Successfully sign up', 'status' => 'succ'));
                }
                else{
                    echo json_encode(array('message' => 'Cannot sign up', 'status' => 'fail'));
                }
            }
            else echo json_encode(array('message' => 'Username is already taken', 'status' => 'fail'));
        }
        else echo json_encode(array('message' => 'Password re-entered differently', 'status' => 'fail'));
    }    
?>