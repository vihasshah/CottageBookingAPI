<?php
    include 'Helper.php';

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

        function exist($email){
            $query = "select * from users where email='$email'";
            $res = mysqli_query($this->conn,$query);
            if(mysqli_num_rows($res) > 0){
                return true;
            }else{
                return false;
            }
        }

        function add($data){
            $firstname = $data['firstname'];
            $lastname = $data['lastname'];
            $contact = $data['contact'];
            $email = $data['email'];
            $password = md5($data['password']);

            if(!$this->exist($email)){
                $query = "insert into users values(null,'$firstname','$lastname','$contact','$email','$password')";
                $res = mysqli_query($this->conn,$query);
                if($res > 0){
                    $this->helper->create_response(true,"User added",$this->get_user_by_id(mysqli_insert_id($this->conn)));
                }else{
                    $this->helper->create_response(false,"User not added",null);
                }
            }else{
                $this->helper->create_response(false,"User already registered",null);
            }
        }

        private function get_user_by_id($id){
            $query = "select * from users where id='$id' limit 1";
            $res = mysqli_query($this->conn,$query);
            if(mysqli_num_rows($res) > 0){
                $user_info = mysqli_fetch_array($res,MYSQLI_ASSOC);
                unset($user_info['password']); // remove password key from array
                return $user_info;
            }else{
                return [];
            }
        }

        function update_info($data){
            $user_id = $data['user_id'];
            $firstname = $data['firstname'];
            $lastname = $data['lastname'];
            $contact = $data['contact'];
            $email = $data['email'];

            $query = "update users set firstname='$firstname', lastname='$lastname', contact='$contact', email='$email' where id='$user_id'";
            $res = mysqli_query($this->conn,$query);
            if(mysqli_affected_rows($this->conn) > 0){
                
                $this->helper->create_response(true,"User Info updated",$this->get_user_by_id($user_id));
            }else{
                $this->helper->create_response(false,"User Info not updated",[]);
            }
        }

        function update_password($data){
            $email = $data['email'];
            $old_password = md5($data['old_password']);
            $newPassword = md5($data['password']);
            $user_id = $data['user_id'];

            $query = "update users set password='$newPassword' where email='$email' and password='$old_password' and id='$user_id'";
            $res = mysqli_query($this->conn,$query);
            if(mysqli_affected_rows($this->conn) > 0){
                $this->helper->create_response(true,"Password updated",null);
            }else{
                $this->helper->create_response(false,"Given wrong credentials",null);
            }
        }

        function authenticate($data){
            $email = $data['email'];
            $password = md5($data['password']);
            
            $query = "select * from users where email='$email' and password='$password' limit 1";
            $res = mysqli_query($this->conn,$query);

            if(mysqli_num_rows($res) == 1){
                $user_info = mysqli_fetch_array($res,MYSQLI_ASSOC);
                unset($user_info['password']); // remove password key from array
                $this->helper->create_response(true,"Authentication successful",$user_info);
            }else{
                $this->helper->create_response(false,"Invalid User",null);
            }
        }
    }

    // $users = new Users();
    // $users->update_info(array("firstname"=>"ula","lastname"=>"testing","contact"=>"123","email"=>"email@email.com","user_id"=>4));
    // $users->update_password(array("password"=>"testPassword","email"=>"email@email.com","user_id"=>4));
    // $users->authenticate(array("password"=>"testPassword","email"=>"email@email.com"));
?>