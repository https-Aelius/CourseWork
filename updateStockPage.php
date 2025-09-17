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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
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
    <!--Start of PHP-->
    <?php
    include_once("connection.php");
    $stmt = $conn->prepare("SELECT * FROM Products WHERE itemID=23");
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $productImage=$row['productImage'];
        $dimensionImage=$row['dimensionImage'];
        $name=$row['name'];
        $itemID=$row['itemID'];
        $description=$row['description'];
        $price=$row['price'];
        $quant=$row['quant'];
        $productType=$row['productType'];
        $itemSold=$row['itemSold'];
    }
    ?>
    <!--End of PHP-->
    <main style='background-color: #d9d9d9;'>
    <!-- Start of  Modal -->
    <div class="modal fade" id='myModal' role='dialog' style='width:100%;'>
        <div class="modal-dialog" style='width:95%; height:100%;'>
            <!--Modal content-->
            <div class="modal-content" style='width:100%;'>
                <div class="modal-header">
                    <button type = 'button' class='close' data-dismiss='modal'>&times;</button>
                    <h4 class = 'modal-title'>Edit Product ID: <?php echo $itemID;?> 's Details</h4>
                </div>
                <div class="modal-body">
                    <!--Start of the form-->
                    <div class="editDetails" style='width:100%;'>
                        <form action='updateProduct_logic.php' method='POST' enctype='multipart/form-data' style='width:100%; height:100%;'>
                            <div class="container-fluid" style='width:100%;'>
                                <div class="row" style='width:100%; height:100%;'>
                                    <div class="col-md-4">
                                        <div class="accountTop" style='height:10%; width:90%; margin-left:30px;' >
                                            <h2 style='margin-top:5vh; margin-bottom:5vh; margin-left:10px; color:white;'>Product ID: <?php echo $itemID;?> <!--add php for item id/name--></h2>
                                        </div>

                                        <div id='form-general-name' style='height:10%; margin-left:30px; width:96%;'>
                                            <input type='text'  class='listProduct' name='title' placeholder='Enter Name Here...' value='<?php echo $name;?>' style='border-radius:50px; border:3px solid #03045e; height:100%; font-size:30px; width:95%; margin-left:0; margin-right:0;'required>
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
                                                <img style='max-height:20vh; max-width:50vh;' id='imagePreview1' src="Images/<?php echo $productImage; ?>">
                                                
                                                        
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
                                                    <img style='max-height:20vh; max-width:50vh;' id='imagePreview2' src="Images/<?php echo $dimensionImage; ?>">
                                            </div>
                                        </div>
                                        <!--Using enctype multipart since I am importing files into the database -->
                                        
                                    </div>
                                    <div class="col-md-4">
                                        <div id='form-general-description' style='height:70%; width:100%;'>
                                            <div class="custom-column" style='height:72vh; width:100%;'>
                                                <textarea name="description" type='text' class='descriptionTextArea' placeholder='Enter Description here...' required><?php echo $description;?></textarea>
                                            </div>
                                            <div class="custom-column" style='height:5%; width:100%; padding-top:1vh;'>
                                                <p style='font-size:28px;'>Price (£):
                                                <input value = '<?php echo $price;?>' type="text" class='inputForPrice' name='price' placeholder='00.00' style='border-radius:50px; width:50%;'required>
                                                </p>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="status">
                                            <?php
                                            /*
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
                                                */
                                            ?>        
                                        </div>
                                        <div class="listProductForm" style=''>
                                            <div id='form-general-productType' style='height:5%; width:100%; align-items:centre;'>

                                                    <select name="productType" id="productType" class='dropdown-toggle' data-toggle='dropdown'>
                                                        <option selected><?php echo $productType;?></option>
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


                                        <div id='form-general-quant' style='height:10%; margin-left:30px; width:95%; margin-top:45vh;'>
                                            <input value='<?php echo $quant;?>' type='number'  class='listProduct' name='quantity' placeholder='Enter Quantity Here...' style='border-radius:50px; border:3px solid #03045e; height:100%; font-size:30px; width:95%; margin-left:0; margin-right:0;'required>
                                        </div>
                                        <button type = 'submit' class = 'btn-seventh' style='margin-top:10vh; margin-left:30vh; font-size:40px;'>List Item</button>
                                    </div>
                                </div>
                            </div>
                        </form>    
                    </div>
                        <!--End of the form-->
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div> 
     <!-- End of Modal -->
    <?php
        include_once ("connection.php");

        // Fetch items from the database
        $sql = "SELECT itemID, productType FROM Products";
        $stmt = $conn->query($sql);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>
        <div class = "update-stock-container">
            <div class="accountTop" style='height:10%; width:25%; margin-left:30px;' >
                <h2 style='margin-top:5vh; margin-bottom:5vh; margin-left:10px; color:white;'>Edit Products</h2>
            </div>
            <div class="searchForProduct">
            <?php
                $stmt = $conn->prepare("SELECT * FROM Products");
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $productImage=$row['productImage'];
                    $dimensionImage=$row['dimensionImage'];
                    $name=$row['name'];
                    $itemID=$row['itemID'];
                    $description=$row['description'];
                    $price=$row['price'];
                    $quant=$row['quant'];
                    $productType=$row['productType'];
                    $itemSold=$row['itemSold'];
                    echo "
                <div class='productItem container-fluid' style='width:90%;'>
                    <div class='row'>
                        <div class='col-6' style=''>
                            <label>
                                itemID:
                            </label>
                            $itemID
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-6 col-md-3'>
                            <label>
                                Product Name:
                            </label>
                            $name
                        </div>
                        <div class='col-6 col-md-3'>
                            <div class='row'>
                                <label style='margin-top:10px;'>
                                    Product Images:
                                </label>
                            </div>
                            <img src='Images/$productImage' alt='Product Image' style='max-height:20vh; max-width:50vh;'>
                            <img src='Images/$dimensionImage' alt='Dimension Image' style='max-height:20vh; max-width:50vh;'>
                        </div>
                        <div class='col-6 col-md-3'>
                            <label>
                                Product Type:
                            </label>
                            $productType
                        </div>
                        <div class='col-6 col-md-3'>
                            <label>
                                Price:
                            </label>
                            $price 
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-6 col-md-3'>
                            <label>
                                Description:
                            </label>
                            $description
                        </div>
                        <div class='col-6 col-md-3'></div>
                        <div class='col-6 col-md-3'>
                            <label>
                                Quantity:
                            </label>
                            $quant
                        </div>
                        <div class='col-6 col-md-3'>
                            <label>
                                Number Sold:
                            </label>
                            $itemSold
                        </div>
                    </div>
                </div>
                    ";      
                    
                }
                

            ?>
            </div>
            <?php
                include_once("connection.php");
                $stmt = $conn->prepare("SELECT * FROM Products WHERE itemID = 23");
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $productImage=$row['productImage'];
                    $dimensionImage=$row['dimensionImage'];
                    $name=$row['name'];
                    $itemID=$row['itemID'];
                    $description=$row['description'];
                    $price=$row['price'];
                    $quant=$row['quant'];
                    $productType=$row['productType'];
                    $itemSold=$row['itemSold'];
                }
            ?>
            <div class="productItem container-fluid" style='width:90%;'>
                <div class="row">
                    <div class="col-6" style=''>
                        <label>
                            itemID:
                        </label>
                        <?php echo $itemID; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-3">
                        <label>
                            Product Name:
                        </label>
                        <?php echo $name; ?>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="row">
                            <label style='margin-top:10px;'>
                                Product Images:
                            </label>
                        </div>
                        <img src="Images/<?php echo $productImage; ?>" alt="Product Image" style='max-height:20vh; max-width:50vh;'>
                        <img src="Images/<?php echo $dimensionImage; ?>" alt="Dimension Image" style='max-height:20vh; max-width:50vh;'>
                    </div>
                    <div class="col-6 col-md-3">
                        <label>
                            Product Type:
                        </label>
                        <?php echo $productType; ?>
                    </div>
                    <div class="col-6 col-md-3">
                        <label>
                            Price:
                        </label>
                        <?php echo $price; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-3">
                        <label>
                            Description
                        </label>
                        <?php echo $description; ?>
                    </div>
                    <div class="col-6 col-md-3"></div>
                    <div class="col-6 col-md-3">
                        <label>
                            Quantity
                        </label>
                        <?php echo $quant; ?>
                    </div>
                    <div class="col-6 col-md-3">
                        <label>
                            Number Sold
                        </label>
                        <?php echo $itemSold; ?>
                    </div>
                    <button type = 'button' class = 'btn btn-sixth' data-toggle='modal' data-target='#myModal' style='margin-left:90%; font-size:18px;'>Edit</button>
                </div>
            </div>
            
        </div>
        
        

    </main>




</body>
</html>
