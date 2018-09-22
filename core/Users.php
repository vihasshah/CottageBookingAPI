<?php
    include '../core/Helper.php';

    class Users {
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

        function test(){
            print_r($this->conn);
        }

        function user_exist($email){
            $query = "select * from users where email='$email'";
            $res = mysqli_query($this->conn,$query);
            if(mysqli_num_rows($res) > 0){
                return true;
            }else{
                return false;
            }
        }

        function add_user($data){
            $firstname = $data['firstname'];
            $lastname = $data['lastname'];
            $contact = $data['contact'];
            $email = $data['email'];
            $password = $data['password'];

            if(!$this->user_exist($email)){
                $query = "insert into users values(null,'$firstname','$lastname','$contact','$email','$password')";
                $res = mysqli_query($this->conn,$query);
                if($res > 0){
                    $this->helper->create_response(true,"User added",array("user_id"=>mysqli_insert_id($this->conn)));
                }else{
                    $this->helper->create_response(false,"User not added",null);
                }
            }else{
                $this->helper->create_response(false,"User already registered",null);
            }
        }

        function update_user_info($data){
            $id = $data['user_id'];
            $firstname = $data['firstname'];
            $lastname = $data['lastname'];
            $contact = $data['contact'];
            $email = $data['email'];
            $query = "update users set firstname='$firstname', lastname='$lastname', contact='$contact', email='$email' where id='$id'";
            $res = mysqli_query($this->conn,$query);
            if(mysqli_affected_rows($this->conn) > 0){
                $this->helper->create_response(true,"User Info update",null);
            }else{
                $this->helper->create_response(false,"User Info not updated",null);
            }
        }
    }

    $users = new Users();
    $users->update_user_info(array("firstname"=>"ula","lastname"=>"testing","contact"=>"123","email"=>"email@email.com","user_id"=>4));
    $users->user_exist("email@email.com");
?>