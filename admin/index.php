<?php
    include '../core/Cottage.php';
    if(!empty($_POST)){
        $cottage_name = !empty($_POST["cottage_name"]) ? $_POST["cottage_name"] : null;
        $place = !empty($_POST["place"]) ? $_POST["place"] : null;
        $contact_no = !empty($_POST["contact_no"]) ? $_POST["contact_no"] : null;
        $category = !empty($_POST["category"]) ? $_POST["category"] : null;
        $amenities = !empty($_POST["amenities"]) ? $_POST["amenities"] : null;
        $available = !empty($_POST["available"]) ? $_POST["available"] : 0;
        $price = !empty($_POST["price"]) ? $_POST["price"] : null;

        $filesLen = count($_FILES['mutlifile']['name']);
        $files = [];
        // url to store in db
        $images = null;
        if($filesLen > 0){
            $initUrl = "/cottage/assets/";
            for($i = 0 ; $i < $filesLen ; $i++){        
                $sourcePath = $_FILES['mutlifile']['tmp_name'][$i];       // Storing source path of the file in a variable
                $targetPath = "../assets/".$_FILES['mutlifile']['name'][$i];
                move_uploaded_file($sourcePath,$targetPath) ;    // Moving Uploaded file
                $files[] = $initUrl.$_FILES['mutlifile']['name'][$i];
            }
            $images = join(",",$files);
        }
        $finalArr = [];
        $finalArr['cottage_name'] = $cottage_name;
        $finalArr['place'] = $place;
        $finalArr['contact_no'] = $contact_no;
        $finalArr['category'] = $category;
        $finalArr['amenities'] = $amenities;
        $finalArr['available'] = $available;
        $finalArr['price'] = $price;
        $finalArr['images'] = $images;

        // print_r($finalArr);
        $cottage = new Cottage();
        $response = $cottage->add($finalArr);
        $resArr = json_decode($response);
        if($resArr['success'] == 1){
            header("Refresh:0");
        }

    }
?>
<html>
<head>
    <!-- color palette -->
    <link rel="stylesheet" href="palette.css">
    <!-- materialize -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- jquery -->
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- custom js -->
    <script src="common.js"></script>
    <!-- custom css -->
    <link rel="stylesheet" href="common.css">
</head>
<body>
    <!-- navbar -->
    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper default-primary-color">
                <a href="#!" class="brand-logo ">Cottage Finder</a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="index.php"><i class="material-icons left">store</i>Cottages</a></li>
                    <li><a href="users.html"><i class="material-icons left">person</i>Users</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- main body  -->
    <div class="row">
        <div class="col s10 offset-s1">
            <h4 class="primary-text-color">Cottages List</h4>
            <div id="cottageList" class="col s12"></div>
            <script>renderCottageList()</script>
        </div>
       
    </div>
    <!-- floating btn -->
    <div class="fixed-action-btn">
        <a id="fab" class="btn-floating btn-large deep-orange modal-trigger" href="#modal1">
            <i class="large material-icons text-primary-color">add</i>
        </a>
    </div>
    <!-- model for add cottage -->
    <div id="modal1" class="modal bottom-sheet large-sheet">
        <div class="modal-content">
            <!-- header -->
            <div class="row">
                <div class="col s10">
                    <h4>Add Cottage</h4>
                </div>
                <div class="col s2">
                    <a id="save" class="modal-close waves-effect waves-green btn-flat right" name="saveBtn">Save</a>
                </div>
            </div>
            <!-- form  -->
            <form action="index.php" method="post" enctype="multipart/form-data" id="addForm">
                <div class="row">
                    <div class="input-field col s12 m4">
                        <input placeholder="e.g., Coconut Cottage" id="cottage_name" type="text" class="validate" value="test" name="cottage_name">
                        <label for="first_name">Cottage Name</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input placeholder="e.g., Trivandrum" id="place" type="text" class="validate" value="test" name="place">
                        <label for="place">Place</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input placeholder="e.g., 9823421231" id="contact_no" type="number" class="validate" value="1231232" name="contact_no">
                        <label for="contact_no">Contact No</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <input placeholder="e.g., Pool, Wifi, club" id="amenities" type="text" class="validate" value="test" name="amenities">
                        <label for="first_name">Amenities</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input placeholder="e.g., 3500" id="price" type="text" class="validate" value="test" name="price">
                        <label for="price">Price</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <select id="category" name="category">
                            <option value="" disabled >Choose your option</option>
                            <option value="1" selected>3 star</option>
                            <option value="2">5 star</option>
                            <option value="3">7 star</option>
                        </select>
                        <label>Category</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <label for="upload_photo">Upload Photos</label>
                        <div class="file-field input-field ">
                            <div class="btn btn-flat">
                                <span>Upload</span>
                                <input type="file" multiple id="mutlifile" name="mutlifile[]">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Upload one or more files" id="file">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <label>
                            <input type="checkbox" id="available" name="available" value="1"/>
                            <span>Available</span>
                        </label>
                    <div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

