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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body style='background-color:#d9d9d9;'>
    <nav class = "navbar navbar-default navbar-fixed-top">  
    <a href="mainPage.php">
            <div class = "navbar-brand" style = "font-size:20px;">
                BOTTLELEAK
            </div>
        </a>
        <div class = "collapse navbar-collapse" id="myNavbar">
            <ul class = "nav navbar-nav navbar-right">
                <li><a href = "waterBottleSec.php">WATER BOTTLES</a></li>
                <li><a href = "foodStorageSec.php">FOOD STORAGE</a></li>
                <li><a href = "petsSec.php">PETS</a></li>
                <li><a href = "accessoriesSec.php">ACCESSORIES</a></li>
                <li><a href = "supportPage.php">CONTACT</a></li>
                <li><a href = "aboutPage.php">ABOUT</a></li>
                <li>
                    <form action="generalSearch.php" class = "navbar-form navbar-right" role="search" style = "padding-left:20px; padding-right:15px;">
                        <div class="search-bar-wrapper">
                            <input type = "text" class = 'navbar-search-input' placeholder = 'SEARCH'>
                            <button type = "submit" class = 'btn btn-search'>
                            <span class="glyphicon glyphicon-search"></span> <!--Search icon-->
                            </button> 
                        </div>
                        
                    </form>
                </li>
                <li><a type='button' data-toggle='modal' data-target='#basketModal'><img src = "online-shopping.png" style = "width:18px; height:18px;">
                <!--adding span-->
                <span class="badge badge-pill badge-danger" id="cart-count" style="width:25px; letter-spacing: .15px;">
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM Basket WHERE userID=:userID");

                    $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);
            
                    $stmt->execute();
                    //loop through the basket database based of the userID
            
                    while($basketRow = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $productQuantity = $basketRow['quantBasket'];
                        $count+= $productQuantity;
                    }
                    if ($count>0){
                        echo $count;
                    }
                    else{
                        echo "0";
                    }

                    ?>
            </a></li> <!--Cart-->
                <!-- account pages depending on the role --> 
                <?php
                if(isset($_SESSION)){
                    if ($_SESSION['role']==2){
                        echo '<li><a href = "adminPage.php"><img src = "avatar.png" style = "height:17px; width:17px;"></a></li>';
                        
                    }
                    else{
                        echo '<li><a href = "accountPage.php"><img src = "avatar.png" style = "height:17px; width:17px;"></a></li>';

                    }
                }
                
                else{
                    echo '<li><a href = "login.php"><img src = "avatar.png" style = "height:17px; width:17px;"></a></li> ';

                }
                ?>
            </ul>
        </div>
    </nav>

    <main class='addProductPageMain'>
        <form action='addProduct_logic.php' method='POST' enctype='multipart/form-data' style='width:100%; height:100%;'>
            <div class="container-fluid" style='width:100%;'>
                <div class="row" style='width:100%; height:100%;'>
                    <div class="col-md-4">
                        <div class="backToHome">
                            <a href='adminPage.php' class='btn btn-primary' style='font-size:18px; margin-left:30px; margin-top:-60px; margin-bottom:20px; padding:10px 20px; border-radius:15px; background-color:#03045e; border:none;'><- Back</a>
                        </div>
                        <div class="accountTop" style='height:10%; width:90%; margin-left:30px;' >
                            <h2 style='margin-top:5vh; margin-bottom:5vh; margin-left:10px; color:white;'>Add New Product</h2>
                        </div>

                        <div id='form-general-name' style='height:10%; margin-left:30px; width:96%;'>
                            <input type='text'  class='listProduct' name='title' placeholder='Enter Name Here...' style='border-radius:50px; border:3px solid #03045e; height:100%; font-size:30px; width:95%; margin-left:0; margin-right:0;'required>
                        </div>

                        <div class="listProductForm">
                            <div class="custom-class justify-content-centre">
                                <div class="mb-3">
                                    <div id='form-general-image1' style='height:10%; width:96%; align-items:centre;'>
                                        <label for="fileToUpload1" class="file-upload-button" style='font-size:22px; font-weight:normal; border-radius:30px; height:50%;'>
                                            <span class='file-upload-button-label'>Click to Upload Image</span>
                                        </label>
                                        <input style='z-index:-100; display:none;'name="fileToUpload1" type="file" id="fileToUpload1" class='file-to-upload-input' onchange='previewImage1()'>
                                        <br><br>
                                        <!--adding JS to preview the image-->
                                        <script>
                                                function previewImage1() {
                                                    const fileInput1 = document.getElementById('fileToUpload1');
                                                    const imagePreview1 = document.getElementById('imagePreview1');

                                                    const file = fileInput1.files[0];
                                                    if (file) {
                                                        const reader = new FileReader();
                                                        reader.onload = function(e) {
                                                            imagePreview1.src = e.target.result;
                                                        }
                                                            reader.readAsDataURL(file);
                                                        } else {
                                                            imagePreview1.src = ''; //ensuring no image is shown if none is selected, but this shouldn't happen since I put required in the input box 
                                                        }
                                                        imagePreview1.style='z-index:10;'
                                                        imagePreview1.style='max-height:27.5vh;'
                                                    }
                                            </script>

                                        </div>
                                    
                                </div>
                                <img id='imagePreview1' src=''>
                                
                                        
                            </div>

                        </div>
                        <div class="listProductForm2" style='width:95%;'>
                            <div class="custom-class justify-content-centre">
                                <div class="mb-3">
                                        <div id='form-general-image2' style='height:10%; width:100%; align-items:centre;'>
                                                <label for="fileToUpload2" class="file-upload-button" style='font-size:21px; font-weight:normal; border-radius:30px; height:50%;'>
                                                    <span class='file-upload-button-label'>Click to Upload Dimensions</span>
                                                </label>
                                                <input style='z-index:-100; display:none;' name="fileToUpload2" type="file" id="fileToUpload2" class='file-to-upload-input' onchange='previewImage2()'>
                                                <br><br>

                                                <!--adding JS to preview the image-->
                                                <script>
                                                        function previewImage2() {
                                                        const fileInput2 = document.getElementById('fileToUpload2');
                                                        const imagePreview2 = document.getElementById('imagePreview2');
                                                        const listProductForm = document.querySelector('.listProductForm2');

                                                        const file = fileInput2.files[0];
                                                        if (file) {
                                                            const reader = new FileReader();
                                                            reader.onload = function(e) {
                                                                imagePreview2.src = e.target.result;
                                                            }
                                                                reader.readAsDataURL(file);
                                                            } else {
                                                                imagePreview2.src = ''; //ensuring no image is shown if none is selected, but this shouldn't happen since I put required in the input box 
                                                            }
                                                            imagePreview2.style='z-index:10;'
                                                            imagePreview2.style='max-height:27.5vh;'
                                                            listProductForm.style='margin-top:5vh;'
                                                            console.log('test');
                                                        }
                                            </script>
                                        </div>
                                    </div>
                                    <img id='imagePreview2' src=''>
                            </div>
                        </div>
                        <!--Using enctype multipart since I am importing files into the database -->
                        
                    </div>
                    <div class="col-md-4">
                        <div id='form-general-description' style='height:70%; width:100%;'>
                            <div class="custom-column" style='height:72vh; width:100%;'>
                                <textarea name="description" type='text' class='descriptionTextArea' placeholder='Enter Description here...' required></textarea>
                            </div>
                            <div class="custom-column" style='height:5%; width:100%; padding-top:1vh;'>
                                <p style='font-size:28px;'>Price ($):
                                <input type="text" class='inputForPrice' name='price' placeholder='00.00' style='border-radius:50px; width:50%;'required>
                                </p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="status">
                            <?php
                                if (isset($_SESSION['Message5'])) {
                                    echo $_SESSION['Message5'];
                                    unset($_SESSION['Message5']);
                                }
                                if (isset($_SESSION['Message3'])) {
                                    echo $_SESSION['Message3'];
                                    unset($_SESSION['Message3']);
                                }
                                if (isset($_SESSION['Message7'])) {
                                    echo $_SESSION['Message7'];
                                    unset($_SESSION['Message7']);
                                }
                                if (isset($_SESSION['Message8'])) {
                                    echo $_SESSION['Message8'];
                                    unset($_SESSION['Message8']);
                                }
                                if (isset($_SESSION['Message1'])) {
                                    echo $_SESSION['Message1'];
                                    unset($_SESSION['Message1']);
                                }
                            ?>        
                        </div>
                        <div class="listProductForm" style=''>
                            <div id='form-general-productType' style='height:5%; width:100%; align-items:centre;'>

                                    <select name="productType" id="productType" class='dropdown-toggle' data-toggle='dropdown'>
                                        <option selected disabled>Select Type</option>
                                        <?php
                                        include_once('connection.php');
                                        $stmt = $conn->prepare('SELECT * FROM Types');
                                        $stmt->execute();
                                        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

                                        echo('<option class="select-type-option" value="' . $row["productType"] . '">' . $row["productType"] . '</option>');
                                        }
                                        ?>

                                    </select>

                            </div>
                        </div>
                        <div class="form-general-discountRate" style='height:10%; margin-left:30px; width:95%; margin-top:18vh;'>
                            <p style='font-size:18px;'>Discount Rate (%): - If None, Enter 0</p>
                            <input type='number' class='listProduct' name='discountRate' placeholder='0' style='border-radius:50px; border:3px solid #03045e; height:100%; font-size:30px; width:95%; margin-left:0; margin-right:0;'required>
                        </div>

                        <div id='form-general-quant' style='height:10%; margin-left:30px; width:95%; margin-top:21vh;'>
                            <input type='number'  class='listProduct' name='quantity' placeholder='Enter Quantity Here...' style='border-radius:50px; border:3px solid #03045e; height:100%; font-size:30px; width:95%; margin-left:0; margin-right:0;'required>
                        </div>
                        <button type = 'submit' class = 'btn-seventh' style='margin-top:10vh; margin-left:30vh; font-size:40px;'>List Item</button>
                    </div>
                </div>
            </div>
        </form>    
    </main>



    </div>

        <?php include_once('basketModal.php'); ?>

    
</body>
</html>
