<?php
    include '../core/Users.php';
    header('Accept:Application/JSON');
    header("Content-Type:Application/JSON");
	if($_SERVER['REQUEST_METHOD'] == "GET"){
        $users = new Users();         
        $users->get_list();
    }
?>