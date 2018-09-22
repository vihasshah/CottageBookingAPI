<?php
    include 'Helper.php';

    class News {
        var $conn = null;
        var $helper = null;

        function __construct(){
            if($this->helper == null){
                $this->helper = new Helper();
            }

            if($this->conn == null){
                $this->conn = $this->helper->db();
            }
        }

        function get_news() {
            $query = "SELECT * from news";
            $res = mysqli_query($this->conn,$query);
            if(mysqli_num_rows($res) > 0){
                $list = [];
                while($result = mysqli_fetch_array($res,MYSQLI_ASSOC)){
                    $list[] = $result;
                }
                $this->helper->create_response(true,"News Found",$list);
            }else{
                $this->helper->create_response(false,"No News Found",null);
            }
        }
    }

    // $news = new News();
    // $news->get_news();
?>