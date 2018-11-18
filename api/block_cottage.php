<?php
    include '../core/Cottage.php';
    header("Accept:Application/JSON");
    header("Content-Type:Application/JSON");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $cottage = new Cottage();
        $json = json_decode(file_get_contents('php://input'),TRUE);
        $cottage_id = $json['cottage_id'];
        $block_status = $json['block_status'];
        $cottage->block_cottage(array('cottage_id'=>$cottage_id,'block_status'=>$block_status));
    }
?>