<?php
    include '../core/Users.php';
    header("Accept:Application/JSON");
    header("Content-Type:Application/JSON");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $users = new Users();
        $json = json_decode(file_get_contents('php://input'),TRUE);
        $user_id = $json['user_id'];
        $email = $json['email'];
        $old_password = $json['old_password'];
        $password = $json['password'];
        $users->update_password(array(
            'email'=>$email,
            "user_id"=>$user_id,
            "old_password"=>$old_password,
            "password"=>$password
        ));
    }
?>