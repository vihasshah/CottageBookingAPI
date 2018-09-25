<?php
    include '../core/Cottage.php';
    header("Accept:Application/JSON");
    header("Content-Type:Application/JSON");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $cottage = new Cottage();
        $json = json_decode(file_get_contents('php://input'),TRUE);
        $review = $json['review'];
        $cottage_id = $json['cottage_id'];
        $date = $json['date'];
        $ratings = $json['ratings'];
        $cottage->add_review(array(
            'review'=>$review,
            "cottage_id"=>$cottage_id,
            "date"=>$date,
            "ratings" => $ratings
        ));
    }
?>