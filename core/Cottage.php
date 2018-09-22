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

        function test() {
            print_r($this->conn);
        }

        function get_list(){
            $query = "SELECT cot.*,cat.category FROM cottages cot INNER JOIN categories cat ON cot.category_id = cat.id";
            $res = mysqli_query($this->conn,$query);
            if(mysqli_num_rows($res) > 0){
                $list = [];
                while($result = mysqli_fetch_array($res,MYSQLI_ASSOC)){
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
        function search_by($searchInput,$field){
            $query = "SELECT * FROM cottages"; // all data (filter not applied) 
            if($field == 'category'){
                $query = "SELECT * FROM cottages where category_id='$searchInput'"; // search by category
            }else if($field == 'place'){
                $query = "SELECT * FROM cottages where place LIKE '$searchInput'"; // search by place (lasy search)
            }
            $res = mysqli_query($this->conn,$query);
            if(mysqli_num_rows($res) > 0){
                $list = [];
                while($result = mysqli_fetch_array($res,MYSQLI_ASSOC)){
                    $list[] = $result;
                }
                $this->helper->create_response(true,"Found",$list);
            }else{
                $this->helper->create_response(false,"No Results Found",null);
            }
        }

        
    }

    $cottage = new Cottage();
    // $cottage->get_list();
    $cottage->search_by("%ahmedabad%",'place');
    // $cottage->search_by("1",'category');
?>