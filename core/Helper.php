<?php
    class Helper {

        // $current_conn = null;

        public function __construct() {
            date_default_timezone_set('Asia/Kolkata');
        } 

        // get connection of database
        public function db() {
            $conn = mysqli_connect("localhost","root","","CottageBooking");
            if (mysqli_connect_errno())
            {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            return $conn;
        }

        public function create_response($isSuccess,$message,$data) {
            
            if($isSuccess){
                if($data != null){
                    echo json_encode(array('success'=>1,'message'=>$message,'data'=>$data));
                }else{
                    echo json_encode(array('success'=>1,'message'=>$message));
                }
            }else{
                echo json_encode(array('success'=>0,'message'=>$message));
            }
        }
    }
?>