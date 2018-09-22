<?php
    class DBHelper {

        public function __construct() {
            session_start();
            date_default_timezone_set('Asia/Kolkata');
        } 

        // get connection of database
        public function db() {
            $conn = mysqli_connect("localhost","root","","CottageBooking")
            return $conn;
        }
        
    }
?>