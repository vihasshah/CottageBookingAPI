<?php
    include '../core/Cottage.php';
    header("Accept:Application/JSON");
    header("Content-Type:Application/JSON");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $cottage = new Cottage();
        $json = json_decode(file_get_contents('php://input'),TRUE);
        $cottage_id = $json['cottage_id'];
        $start_date = $json['start_date'];
        $end_date = $json['end_date'];
        $cottage->book_cottage(array('cottage_id'=>$cottage_id,'start_date'=>$start_date,'end_date' =>$end_date));
    }
?>