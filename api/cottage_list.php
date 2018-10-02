<?php
    include '../core/Cottage.php';
    header('Accept:Application/JSON');
    header("Content-Type:Application/JSON");
	if($_SERVER['REQUEST_METHOD'] == "GET"){
        $cottage = new Cottage();
        $str = $_SERVER['QUERY_STRING'];
		parse_str($str,$array);
		if($_GET){
            if(isset($_GET['id'])){
                $cottage->search_by($_GET['id'],"category",null,null);
            }else if(isset($_GET['place'])){
                $cottage->search_by($_GET['place'],"place",null,null);
            }else if(isset($_GET['id']) && isset($_GET['place'])){
                $cottage->search_by($_GET['id'],"category",$_GET['place'],"place");
            }
        }else{
            $cottage->get_list();
        }
    }
?>