<?php
    //connects webpage to the database to allow for validation
    include_once('connection.php');

    //starting the session to ensure that the user is an admin
    session_start();
    //if user's role isn't 2, then its not an admin and they get sent back to the mainPage.
    //getting the session variable from previous page (login_logic.php)
    if ($_SESSION['role'] != 2){
        header('Location: mainPage.php');
    }
    
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BottleLeak & Co.</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body style='background-color:#d9d9d9;'>
    <nav class = "navbar navbar-default navbar-fixed-top">  
        <div class = "navbar-brand" style = "font-size:20px;">
            BOTTLELEAK
        </div>
        <div class = "collapse navbar-collapse" id="myNavbar">
            <ul class = "nav navbar-nav navbar-right">
                <li><a href = "">WATER BOTTLES</a></li>
                <li><a href = "">FOOD STORAGE</a></li>
                <li><a href = "">PETS</a></li>
                <li><a href = "">ACCESSORIES</a></li>
                <li><a href = "">SUPPORT</a></li>
                <li><a href = "">ABOUT</a></li>
                <li>
                    <form class = "navbar-form navbar-right" role="search" style = "padding-left:20px; padding-right:15px;">
                        <div class="search-bar-wrapper">
                            <input type = "text" class = 'navbar-search-input' placeholder = 'SEARCH'>
                            <button type = "submit" class = 'btn btn-search'>
                            <span class="glyphicon glyphicon-search"></span> <!--Search icon-->
                            </button> 
                        </div>
                        
                    </form>
                </li>
                <li><a href = ""><img src = "online-shopping.png" style = "width:18px; height:18px;"></a></li> <!--Cart-->
                <li><a href = ""><img src = "avatar.png" style = "height:17px; width:17px;"></a></li> <!-- User picture -->
            </ul>
        </div>
    </nav>

    <main class='addProductPageMain'>

        <div class="row">
            <div class="col-md-4">
                <div class="accountTop" style='height:10%; width:90%; margin-left:30px;' >
                    <h2 style='margin-top:5vh; margin-bottom:5vh; margin-left:10px; color:white;'>Add New Product</h2>
                </div>

                <form action='addProduct_logic.php' method='post' style='height:10%; margin-left:30px; width:96%;'>
                    <input type='text'  class='listProduct' name='title' placeholder='Enter Name Here...' style='border-radius:50px; border:3px solid #03045e; height:100%; font-size:30px; width:95%; margin-left:0; margin-right:0;'required>
                </form>

                <div class="listProductForm">
                    <div class="custom-class justify-content-centre">
                        <div class="mb-3">
                            <form action="addProduct_logic.php" method='post' enctype='multipart/form-data' style='height:10%; width:96%; align-items:centre;'>
                                <label for="fileToUpload1" class="file-upload-button" style='font-size:22px; font-weight:normal; border-radius:30px; height:100px;'>
                                    <span class='file-upload-button-label'>Click to Upload Image</span>
                                </label>
                                <input style='z-index:-5;'name="file-to-upload" type="file" id="fileToUpload1" class='file-to-upload-input' onchange='previewImage()'>
                                <br><br>
                                <img id='imagePreview1' src=''>
                                <!--adding JS to preview the image-->
                                <script>
                                        function previewImage() {
                                        const fileInput = document.getElementById('fileToUpload1');
                                        const imagePreview = document.getElementById('imagePreview2');

                                        const file = fileInput.files[0];
                                        if (file) {
                                            const reader = new FileReader();
                                            reader.onload = function(e) {
                                                imagePreview.src = e.target.result;
                                            }
                                                reader.readAsDataURL(file);
                                            } else {
                                                imagePreview.src = ''; //ensuring no image is shown if none is selected, but this shouldn't happen since I put required in the input box 
                                            }
                                        }
                                </script>

                            </form>
                            
                        </div>
                        
                                
                    </div>

                </div>
                <div class="listProductForm" style='margin-top:150px;'>
                    <div class="custom-class justify-content-centre">
                        <div class="mb-3">
                                <form action="addProduct_logic.php" method='post' enctype='multipart/form-data' style='height:10%; width:96%; align-items:centre;'>
                                        <label for="fileToUpload2" class="file-upload-button" style='font-size:22px; font-weight:normal; border-radius:30px; height:100px;'>
                                            <span class='file-upload-button-label'>Click to Upload Dimensions</span>
                                        </label>
                                        <input style='z-index:-5;'name="file-to-upload" type="file" id="fileToUpload2" class='file-to-upload-input' onchange='previewImage()'>
                                        <br><br>
                                        <img id='imagePreview2' src=''>
                                        <!--adding JS to preview the image-->
                                        <script>
                                                function previewImage() {
                                                const fileInput = document.getElementById('fileToUpload2');
                                                const imagePreview = document.getElementById('imagePreview2');

                                                const file = fileInput.files[0];
                                                if (file) {
                                                    const reader = new FileReader();
                                                    reader.onload = function(e) {
                                                        imagePreview.src = e.target.result;
                                                    }
                                                        reader.readAsDataURL(file);
                                                    } else {
                                                        imagePreview.src = ''; //ensuring no image is shown if none is selected, but this shouldn't happen since I put required in the input box 
                                                    }
                                                }
                                    </script>
                                </form>
                            </div>
                    </div>
                </div>
                <!--Using enctype multipart since I am importing files into the database -->
                
            </div>
            <div class="col-md-4">
                <form action='addProduct_logic.php' method='post' style='height:70%; width:100%;'>
                    <div class="custom-column" style='height:72vh; width:100%;'>
                        <textarea name="description" type='text' class='descriptionTextArea' placeholder='Enter Description here...' required></textarea>
                    </div>
                    <input type="text" class='inputForPrice' name='price' placeholder='Enter Price here...' style='border-radius:50px;'required>
                </form>
            </div>
            <div class="col-md-4">
            <form action='addProduct_logic.php' method='post' style='height:70%; width:100%;'>
                <div class="custom-column" style='height:72vh; width:100%;'>
                    <select name="selectedType" id="dropdownMenuButton" class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' style='margin-bottom:150px;'>
                        <option selected disabled>Select Type</option>
                        <?php
                        include_once('connection.php');
                        $stmt = $conn->prepare('SELECT productType FROM Types');
                        $stmt->execute();
                        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                            echo('<option value = ".$row["productType"]">')
                        }
                        ?>

                    </select>
                </div>
            </form>
            </div>
        </div>
    </main>


    <div class="navbar-bottom">
    </div>
</body>
</html>
