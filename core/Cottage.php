<?php
    include 'Helper.php';

    class Cottage {
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
        private function _exists($data){
            $cottage_name = $data['cottage_name'];
            $place = $data['place'];
            $contact_no = $data['contact_no'];
            $query = "SELECT * FROM cottages WHERE name='$cottage_name' AND place='$place' AND contact='$contact_no'";
            $res = mysqli_query($this->conn,$query);
            if(mysqli_num_rows($res) > 0){
                return true;
            }else{
                return false;
            }
        }

        function add($data) {
            $cottage_name = $data['cottage_name'];
            $place = $data['place'];
            $contact_no = $data['contact_no'];
            $category = $data['category'];
            $amenities = $data['amenities'];
            $available = $data['available'];
            $price = $data['price'];
            $images = $data['images'];
            if(!$this->_exists($data)){
                $query = "INSERT INTO cottages VALUES(null,'$cottage_name','$place','$images','$available','$price','$amenities','$contact_no',5,0,'$category',null,null)";
                $res = mysqli_query($this->conn,$query);
                if($res > 0){
                    return array("success" => true,"message"=> "Cottage added");
                }else{
                    return array("success" => true,"message"=> "Cottage not added");
                }
            }else{
                return array("success" => true,"message"=> "Cottage Exists");
            }
        }

        function get_list(){
            $query = "SELECT cot.*,cat.category FROM cottages cot INNER JOIN categories cat ON cot.id = cat.id ORDER BY cot.id DESC";
            $res = mysqli_query($this->conn,$query);
            if(mysqli_num_rows($res) > 0){
                $list = [];
                while($result = mysqli_fetch_array($res,MYSQLI_ASSOC)){
                    $result['reviews'] = $this->_get_reviews($result['id']);
                    $list[] = $result;
                }
                $this->helper->create_response(true,"List Found",$list);
            }else{
                $this->helper->create_response(false,"List Not Found",null);
            }
        }

        /**
         * strict search in category id and lasy search in place
         * @param searchInput input value by user
         * @param field identifier
         *      category -> search by category
         *      place -> search by place
         */
        function search_by($searchInput,$field,$searchInput1,$field1){
            $query = "SELECT cot.*,cat.category FROM cottages cot INNER JOIN categories cat ON cot.category_id = cat.id"; // all data (filter not applied) 
            if($field == 'category' && $searchInput1 == null && $field1 == null){
                $query = "SELECT cot.*,cat.category FROM cottages cot INNER JOIN categories cat ON cot.category_id = cat.id WHERE cot.category_id='$searchInput'"; // search by category
            }else if($field == 'place' && $searchInput1 == null && $field1 == null){
                $query = "SELECT cot.*,cat.category FROM cottages cot INNER JOIN categories cat ON cot.category_id = cat.id WHERE cot.place LIKE '$searchInput'"; // search by place (lasy search)
            }else if($field == 'category' && $field1 == 'place'){
                $query = "SELECT cot.*,cat.category FROM cottages cot INNER JOIN categories cat ON (cot.category_id = cat.id AND cot.category_id = '$searchInput' AND cot.place LIKE '$searchInput1')"; // search by place (lasy search)
            }
            $res = mysqli_query($this->conn,$query);
            if(mysqli_num_rows($res) > 0){
                $list = [];
                while($result = mysqli_fetch_array($res,MYSQLI_ASSOC)){
                    $result['reviews'] = $this->_get_reviews($result['id']);
                    $list[] = $result;
                }
                $this->helper->create_response(true,"Found",$list);
            }else{
                $this->helper->create_response(false,"No Results Found",null);
            }
        }

        // date format should be yyyy-mm-dd
        function add_review($data){
            $review = $data['review'];
            $cottage_id = $data['cottage_id'];
            $ratings = $data['ratings'];
            $dateTime = new DateTime($data['date']); // use for fail safe 
            $date = $dateTime->format('Y-m-d');
            $query = "INSERT INTO reviews VALUES(null,'$review','$ratings','$cottage_id','$date')";
            $res = mysqli_query($this->conn,$query);
            if($res > 0){
                $this->helper->create_response(true,"Review added",null);
            }else{
                $this->helper->create_response(true,"Sorry! try again later",null);
            }
        }
        
        private function _get_reviews($cottage_id){
            $reviewQuery = "SELECT review,ratings,`date` from reviews where cottage_id='$cottage_id'";
            $res = mysqli_query($this->conn,$reviewQuery);
            if(mysqli_num_rows($res) > 0) {
                $list = [];
                while ($result = mysqli_fetch_array($res,MYSQLI_ASSOC)){
                    $dateTime = new DateTime($result['date']); // change date format
                    $result['date'] = $dateTime->format('d M, Y');
                    $list[] = $result;
                }
                return $list;
            }else{
                return [];
            }
        }
        
        //block cottage
        function block_cottage($data){
            $cottage_id = $data['cottage_id'];
            $block_status = $data['block_status'];
            $message = "";
            if($block_status == "0"){
                $message = "Unblocked";
            }else{
                $message = "Blocked";
            }
            $updateQuery = "UPDATE cottages SET blocked='$block_status' WHERE id='$cottage_id'";
            $res = mysqli_query($this->conn,$updateQuery);
            if(mysqli_affected_rows($this->conn) > 0){
                $this->helper->create_response(true,$message,[]);
            }else{
                $this->helper->create_response(false,"Status not updated",[]);
            }
        }

        private function _alreadyBooked($id){
            $query = "SELECT * FROM cottages WHERE id='$id' AND available='0'";
            $res = mysqli_query($this->conn,$query);
            $res = mysqli_query($this->conn,$query);
            if(mysqli_num_rows($res) > 0){
                return true;
            }else{
                return false;
            }
        }

        // book cottage for specific dates 
        // checks first if it is already booked or not
        function book_cottage($data){
            $cottage_id = $data['cottage_id'];
            $start_date = $data['start_date'];
            $end_date = $data['end_date'];
            if(!$this->_alreadyBooked($cottage_id)){
                $updateQuery = "UPDATE cottages SET available='0',start_date='$start_date', end_date='$end_date' WHERE id='$cottage_id'";
                $res = mysqli_query($this->conn,$updateQuery);
                if(mysqli_affected_rows($this->conn) > 0){
                    $this->helper->create_response(true,"Booked",[]);
                }else{
                    $this->helper->create_response(false,"Booking Fail",[]);
                }
            }else{
                $this->helper->create_response(true,"Already Booked",[]);
            }
        }
    }

    // $cottage = new Cottage();
    // $cottage->get_list();
    // $cottage->search_by("%ahmedabad%",'place');
    // $cottage->search_by("1",'category');
    // $cottage->add_review(array("review"=>"this is review for old rethel greens","cottage_id"=>1,"date"=>"01-05-2016"));
?>