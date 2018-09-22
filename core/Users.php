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
            print_r($res);
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
    }

    $users = new Users();
    $users->add_user(array("firstname"=>"testing","lastname"=>"testing","contact"=>"123","email"=>"email@email.com","password"=>"password"));
    $users->user_exist("email@email.com");
?>