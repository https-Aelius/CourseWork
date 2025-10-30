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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                    <form class = "navbar-form navbar-right" role="search" style = "padding-left:20px; padding-right:15px;">
                        <div class="search-bar-wrapper">
                            <input type = "text" class = 'navbar-search-input' placeholder = 'SEARCH'>
                            <button type = "submit" class = 'btn btn-search'>
                            <span class="glyphicon glyphicon-search"></span> <!--Search icon-->
                            </button> 
                        </div>
                        
                    </form>
                </li>
                <li><a type='button' data-toggle='modal' data-target='#basketModal'><img src = "online-shopping.png" style = "width:18px; height:18px;"></a></li> <!--Cart-->
                <li><a href = ""><img src = "avatar.png" style = "height:17px; width:17px;"></a></li> <!-- User picture -->
            </ul>
        </div>
    </nav>
    <!--Start of PHP-->
    <!--End of PHP-->
    <main style='background-color: #d9d9d9;'>
    <?php
        include_once ("connection.php");

        // Fetch items from the database
        $sql = "SELECT itemID, productType FROM Products";
        $stmt = $conn->query($sql);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>
        <div class = "update-stock-container">
            <div class="backToHome" style='display:flex;'>
                <a href='adminPage.php' class='btn btn-primary' style='font-size:18px; margin-left:30px; margin-top:20px; margin-bottom:20px; padding:10px 20px; border-radius:15px; background-color:#03045e; border:none;'><- Back</a>
                <div style='margin-top:-10px; margin-left:80%;'>
                    <h2 style='margin-left:-78px;'>Admin</h2>
                    <h4 style='margin-left:-100px;'> Products/ View All Orders</h4>
                </div>

            </div>
            <div class="container" style='display:flex; border-top:1.5px solid #03045e; margin-bottom:5vh; width:100%;'>

                    <div class="accountTop" style='height:10%; width:25%; margin-left:30px; margin-right:0; margin-top:5vh;' >
                        <h2 style='margin-top:5vh; margin-bottom:5vh; margin-left:10px; color:white;'>View Orders</h2>

                    </div>
                    <div class="container" style='margin-top:8vh; margin-left:1vh; display:flex;'>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style='flex-direction:row'>
                                <input name ='search' type="text" id='searchBox' class="searchBox" placeholder="Search Order by userID or deliveryID..." style='width:70%; height:60%; margin-left:10vh;'>
                                <button type='submit' class='btn btn-primary' style='font-size:18px; padding:10px 20px; border-radius:15px; background-color:#03045e; border:none;'>Search</button>
                                <div id="searchResults" class="mt-3"></div>
                            </form>
                    </div>

            </div>
            <!--
            <script>
                $(document).ready(function () {
                    $('#searchBox').on('keyup', function () {
                        const query = $(this).val();

                        // Only search if query is at least 2 characters
                        if (query.length >= 2) {
                            $.ajax({
                                url: 'searchProducts.php',
                                type: 'GET',
                                data: { search: query },
                                success: function (response) {
                                    $('#searchResults').html(response);
                                },
                                error: function () {
                                    $('#searchResults').html('<p style="color:red;">Error fetching results</p>');
                                }
                            });
                        } else {
                            $('#searchResults').html(''); // clear results if input too short
                        }
                    });
                });
        
            </script>
            -->
            <div class="searchForProduct">

            <?php
            include_once('connection.php');

            if(isset($_POST['search'])){
                $search="%" . $_POST['search'] . "%";


                $stmt=$conn->prepare("SELECT * FROM Orders WHERE userID LIKE :search OR deliveryID LIKE :search");
                $stmt->bindParam(':search', $search, PDO::PARAM_STR);
            } else{
                $stmt = $conn->prepare("SELECT * FROM Orders");
            }    
                $stmt->execute();


                $sql2 = "SELECT Users.forename, Users.telephone, Users.postcode, Users.addressLine, Products.name, Orders.toPay, Users.surname, Users.email, Orders.deliveryID, Orders.itemID, Orders.userID
                FROM Orders
                JOIN Users ON Orders.userID = Users.userID
                JOIN Products ON Orders.itemID = Products.itemID";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute();
            while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                $orderID = $row2['deliveryID'];
                $forename = $row2['forename'];
                $surname = $row2['surname'];
                $itemID=$row2['itemID'];
                $userID = $row2['userID'];
                $telephone = $row2['telephone'];
                $postcode = $row2['postcode'];
                $addressLine = $row2['addressLine'];
                $productName = $row2['name'];
                $toPay = $row2['toPay'];
                $email = $row2['email'];
                        echo "
                    
                        <div class='productItem container-fluid' style='width:90%;'>
                    <div class='row'>
                        <div class='col-6' style=''>
                            <label>
                                OrderID:
                            </label>
                            $orderID
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-6 col-md-3'>
                            <label>
                                User's Name:
                            </label>
                            $forename $surname
                        </div>
                        <div class='col-6 col-md-3'>
                            <label>
                                Product Name:
                            </label>
                            <br>
                            $productName
                        </div>
                        <div class='col-6 col-md-3'>
                            <label>
                                Product ID:
                            </label>
                            $itemID
                        </div>
                        <div class='col-6 col-md-3'>
                            <label>
                                Telephone:
                            </label>
                            $telephone
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-6 col-md-3'>
                            <label>
                                Email:
                            </label>
                            <p>$email</p>
                        </div>
                        <div class='col-6 col-md-3'></div>
                        <div class='col-6 col-md-3'>
                            <label>
                                Address:
                            </label>
                            <br>
                            $addressLine, $postcode
                        </div>
                    </div>
                </div>
    
                        ";      
                    }

                

            
            ?>
            
            <?php
            /*
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
                        <p>$description</p>
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
                    <button type='button' 
                            class='btn btn-sixth editBtn' 
                            data-toggle='modal' 
                            data-target='#myModal'
                            data-itemid='$itemID'
                            data-name='$name'
                            data-description='$description'
                            data-price='$price'
                            data-quant='$quant'
                            data-itemSold='$itemSold'
                            data-productType='$productType'
                            data-productImage='$productImage'
                            data-dimensionImage='$dimensionImage'
                            style='margin-left:90%; font-size:18px;'>
                        Edit
                    </button>
                </div>
            </div>

                    ";      
                    
                }
                
            */
            ?>
            </div>
        <!--script to populate the modal with the correct data-->


        <script>
            openModal=0;
            console.log('script starting');
            $(document).on('click', '.editBtn', function () {
            const itemID = $(this).data('itemid');
            window.location.href = "updateStockPage.php?itemID=" + itemID + "&openModal=1";
        });
        console.log(openModal);
        </script>

        

        <?php
        include_once("connection.php");

        if (isset($_GET['itemID'])) {
            $itemID = $_GET['itemID'];

            $stmt = $conn->prepare("SELECT * FROM Products WHERE itemID = :itemID");
            $stmt->bindParam(':itemID', $itemID, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            $itemID=$product['itemID'];
            $name=$product['name'];
            $description=$product['description'];
            $price=$product['price'];
            $quant=$product['quant'];
            $productType=$product['productType'];
            $itemSold=$product['itemSold'];
            $productImage=$product['productImage'];
            $dimensionImage=$product['dimensionImage'];
            $discountRate=$product['discountRate'];

        }
        ?>

        <script>
            $(document).ready(function () {
                <?php if (isset($_GET['openModal']) && $_GET['openModal'] == 1 && $product): ?>
                    // Auto open modal
                    $('#myModal').modal('show');
                    //cleaning up URL so it doesn't open on refresh
                    $('#myModal').on('shown.bs.modal', function () {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('openModal'); // remove the openModal param completely
                    window.history.replaceState({}, '', url); // replace URL without reloading
                    
        });
                <?php endif; ?>
            });
        </script>


    
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
                            <input type='hidden' id='itemID' name='itemID' value='<?php echo $itemID;?>' required>
                            <div class="container-fluid" style='width:100%;'>
                                <div class="row" style='width:100%; height:100%;'>
                                    <div class="col-md-4">
                                        <div class="accountTop" style='height:10%; width:90%; margin-left:30px;' >
                                            <h2 style='margin-top:5vh; margin-bottom:5vh; margin-left:10px; color:white;'>Product ID: <?php echo $itemID;?> <!--add php for item id/name--></h2>
                                        </div>
                                        <div id='form-general-name' style='height:10%; margin-left:30px; width:96%;'>
                                            <p style='font-size:26px;'>Name:</p>
                                            <input type='text'  class='listProduct' name='title' placeholder='Enter Name Here...' value='<?php echo $name;?>' style='border-radius:50px; border:3px solid #03045e; height:100%; font-size:30px; width:95%; margin-left:0; margin-right:0;'required>
                                        </div>
                                        <p style='font-size:26px; margin-top:5vh;'>Product Image:</p>
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
                                                                            imagePreview1.src = ""; //ensuring no image is shown if none is selected, but this shouldn't happen since I put required in the input box 
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
                                        <p style='font-size:26px; margin-top:15vh;'>Dimension Image:</p>
                                        <div class="listProductForm2" style='width:95%; margin-top:10px;'>
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
                                                                                imagePreview2.src = ""; //ensuring no image is shown if none is selected, but this shouldn't happen since I put required in the input box 
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
                                            <p style='font-size:26px;'>Product Description:</p>
                                            <div class="custom-column" style='height:72vh; width:100%;'>
                                                <textarea name="description" type='text' class='descriptionTextArea' placeholder='Enter Description here...' required><?php echo $description;?></textarea>
                                            </div>
                                            <div class="custom-column" style='height:5%; width:100%; padding-top:1vh;'>
                                                <p style='font-size:28px;'>Price ($):
                                                <input value = '<?php echo $price;?>' type="text" class='inputForPrice' name='price' placeholder='00.00' style='border-radius:50px; width:50%;'required>
                                                </p>
                                            </div>

                                            <div class="form-general-discountRate" style='height:10%; margin-left:30px; width:95%; margin-top:18vh;'>
                                                <p style='font-size:18px;'>Discount Rate (%): - If None, Enter 0</p>
                                                <input value = '<?php echo $discountRate;?>'type='number' class='listProduct' name='discountRate' placeholder='0' style='border-radius:50px; border:3px solid #03045e; height:100%; font-size:30px; width:95%; margin-left:0; margin-right:0;'required>
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
                                        <p style='font-size:26px;'>Product Type:</p>
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
                                        <p style='font-size:26px; margin-top:23vh;'>Number of Items Sold:</p>
                                        <div class="editNoSold" style='height:10%; margin-left:30px; width:95%;'>
                                            <input value='<?php echo $itemSold;?>' type='number'  class='listProduct' id ='itemSold' name='itemSold' placeholder='Edit Number of Items Sold Here...' style='border-radius:50px; border:3px solid #03045e; height:100%; font-size:30px; width:95%; margin-left:0; margin-right:0;'required>
                                        </div>
                                        <p style='font-size:26px; margin-top:23vh;'>Quantity:</p>
                                        <div id='form-general-quant' style='height:10%; margin-left:30px; width:95%;'>
                                            <input value='<?php echo $quant;?>' type='number'  class='listProduct' name='quantity' placeholder='Enter Quantity Here...' style='border-radius:50px; border:3px solid #03045e; height:100%; font-size:30px; width:95%; margin-left:0; margin-right:0;'required>
                                        </div>
                                        <button type = 'submit' class = 'btn-seventh' style='margin-top:10vh; margin-left:15vh; font-size:40px; width:60%;'>Update Item</button>
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


        

    </main>


    <?php include_once('basketModal.php'); ?>
</body>
</html>
