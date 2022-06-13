<?php
    //header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    session_start();
    if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true){
        echo json_encode(array('show' => ['.panel-user', 'a.toCart', '#sec_userLib header a'],
                               'hide' => ['.panel-guest', '#lib_asGuest']));
        // echo "<script>
        //         $(document).ready(function(){
        //             $('#panel-user').removeClass('hidden').addClass('visible');
        //             $('#panel-guest').removeClass('visible').addClass('hidden');
        //             $('a.toCart').attr('style', 'display: block !important');
        //         });
        //         </script>";
    }
    else{
        echo json_encode(array('show' => ['.panel-guest', '#lib_asGuest'],
                               'hide' => ['.panel-user', 'a.toCart', '#sec_userLib header a']));
        // echo "<script>
        //         $(document).ready(function(){
        //             $('#panel-guest').removeClass('hidden').addClass('visible');
        //             $('#panel-user').removeClass('visible').addClass('hidden');
        //             $('a.toCart').attr('style', 'display: none !important');
        //         });
        //         </script>";
    }
?>