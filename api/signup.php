<?php
    include '../core/Users.php';
    header("Accept:Application/JSON");
    header("Content-Type:Application/JSON");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $users = new Users();
        $json = json_decode(file_get_contents('php://input'),TRUE);
        $firstname = $json['firstname'];
        $lastname = $json['lastname'];
        $contact = $json['contact'];
        $email = $json['email'];
        $password = $json['password'];
        $users->add(array(
            'firstname'=>$firstname,
            'lastname'=>$lastname,
            'contact'=>$contact,
            'email'=>$email,
            'password'=>$password
        ));
    }
?>