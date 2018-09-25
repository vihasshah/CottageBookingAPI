<?php
    include '../core/News.php';
    header('Accept:Application/JSON');
    header("Content-Type:Application/JSON");
	if($_SERVER['REQUEST_METHOD'] == "GET"){
        $news = new News();
        $news->get_news(); 
    }
?>