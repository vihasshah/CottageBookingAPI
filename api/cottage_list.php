<?php
    include '../core/Cottage.php';
    header('Accept:Application/JSON');
    header("Content-Type:Application/JSON");
	if($_SERVER['REQUEST_METHOD'] == "GET"){
        $cottage = new Cottage();
        $cottage->get_list();
    }
?>