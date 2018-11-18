<?php
    include '../core/Users.php';
    header("Accept:Application/JSON");
    header("Content-Type:Application/JSON");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user = new Users();
        $json = json_decode(file_get_contents('php://input'),TRUE);
        $user_id = $json['user_id'];
        $block_status = $json['block_status'];
        $user->block_user(array('user_id'=>$user_id,'block_status'=>$block_status));
    }
?>