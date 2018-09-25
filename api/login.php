<?php
    include '../core/Users.php';
    header("Accept:Application/JSON");
    header("Content-Type:Application/JSON");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $users = new Users();
        $json = json_decode(file_get_contents('php://input'),TRUE);
        $email = $json['email'];
        $passowrd = $json['password'];
        $users->authenticate(array('email'=>$email,'password'=>$passowrd));
    }
?>