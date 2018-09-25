<?php
    include '../core/Users.php';
    header("Accept:Application/JSON");
    header("Content-Type:Application/JSON");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $users = new Users();
        $json = json_decode(file_get_contents('php://input'),TRUE);
        $user_id = $json['user_id'];
        $firstname = $json['firstname'];
        $lastname = $json['lastname'];
        $contact = $json['contact'];
        $email = $json['email'];
        $users->update_info(array(
            'firstname'=>$firstname,
            'lastname'=>$lastname,
            'contact'=>$contact,
            'email'=>$email,
            "user_id"=>$user_id
        ));
    }
?>