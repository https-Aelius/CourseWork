<?php
    //connects webpage to the database to allow for validation
    include_once('connection.php');

    //starting the session to ensure that the user is an admin
    session_start();
    //if user's role isn't 2, then its not an admin and they get sent back to the mainPage.
    //getting the session variable from previous page (login_logic.php)
    if ($_SESSION['role'] != 1){
        header('Location: login.php');
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

    <!--Body of the website-->
    <main>
        <div class="accountPageDiv">
<!--Now creating the modal-->
            <div class="modal fade" id='myModal' role='dialog'>
                <div class="modal-dialog">
                    <!--Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type = 'button' class='close' data-dismiss='modal'>&times;</button>
                            <h4 class = 'modal-title'>Edit Account Details</h4>
                        </div>
                        <div class="modal-body">
                            <!--Start of PHP-->
                            <?php
                                $stmt = $conn->prepare("SELECT * FROM Users WHERE userID=:userID");
                                $stmt->bindParam(':userID', $_SESSION['userID']);
                                $stmt->execute();
                                $results = $stmt->fetchAll();

                                $stmt->execute();
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    $username = $row['username'];
                                    $forename = $row['forename'];
                                    $surname = $row['surname'];
                                    $email = $row['email'];
                                    $password = $row['password'];
                                    $telephone = $row['telephone'];
                                    $postcode = $row['postcode'];
                                    $addressLine = $row['addressLine'];
                                    
                                }
                                $_SESSION['username'] = $username;
                            ?>
                            <!--End of PHP-->
                            <!--Start of the form-->
                            <div class="editDetails">

                                <form action = "editDetails_logic.php" method = 'POST' class="needs-validation" novalidate>


                                    <h3>
                                        Name
                                    </h3>
                                        <input type = "text" name = "username" value='<?php echo($username)?>' required>
                                        <input type = 'text' name = 'forename' value='<?php echo($forename)?>'required>
                                        <input type = 'text' name ='surname' value='<?php echo($surname)?>'required>
                                    
                                    <br>

                                    
                                    <h3>
                                        Email
                                    </h3>
                                    <?php
                                        session_start();
                                        if (isset($_SESSION['Message1'])){
                                            echo($_SESSION['Message1']);
                                            unset($_SESSION['Message1']);
                                        }
                                    ?>
                                    <input type = 'text' name = 'email' value='<?php echo($email)?>'required>
                                    <br>


                                    <h3>
                                        Contact
                                    </h3>
                                    <input type = 'tel' name = 'telephone' value='<?php echo($telephone)?>' required>
                                    
                                    <h3>
                                        Address
                                    </h3>
                                    <input type = 'text' name = 'postcode' value='<?php echo($postcode)?>' required>
                                    <input type = 'text' name = 'addressLine' value='<?php echo($addressLine)?>' required>

                                    


                                    <h3>
                                        Password
                                    </h3>
                                    <?php
                                        session_start();
                                        if (isset($_SESSION['Message2'])){
                                            echo($_SESSION['Message2']);
                                            unset($_SESSION['Message2']);
                                        }
                                    ?>
                                    <div class = "passwordContainer">
                                        <input name = 'currentPassword' type = 'password' id = 'currentPassword' placeholder = 'Enter Current Password'>
                                        <i class = 'fa-solid fa-eye' id = 'togglePassword' style = 'cursor: pointer;'></i>
                                    </div>
                                    <div class = "passwordContainer">
                                        <input name = 'newPassword' type = 'password' id='newPassword' placeholder='New Password'>
                                        <i class = 'fa-solid fa-eye' id = 'toggleConfirmPassword' style = 'cursor: pointer;'></i>
                                    </div>
                                    <button type='submit' class = 'btn btn-sixth'>Save</button>
                                    <!--remember: data-dismiss='modal'-->
                                </form>

                            </div>
                                <!--End of the form-->
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
<!--Now end of modal-->
            <div class="container-fluid mt-5">
                <div class="row">
                    <div class = 'col-md-4'>
                        <div class='accountTop'>
                            <h3>
                            <?php
                            echo $_SESSION['username'];
                            ?>    
                            </h3>
                        </div>
                        <!--PROFITS SECTION SECTION-->
                        <!--记得要写php code -->
                            <div class="customColumn">
                                <h3>Account Details</h3>
                                
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM Users WHERE userID=:userID");
                                    $stmt->bindParam(':userID', $_SESSION['userID']);
                                    $stmt->execute();
                                    $results = $stmt->fetchAll();
    
                                    $stmt->execute();
                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        $username = $row['username'];
                                        $forename = $row['forename'];
                                        $surname = $row['surname'];
                                        $email = $row['email'];
                                        $password = $row['password'];
                                        $telephone = $row['telephone'];
                                        $postcode = $row['postcode'];
                                        $addressLine = $row['addressLine'];
                                        
                                    }
                                    ?>
                                     <div class="form-group row">
                                            <label>Username</label>
                                            <input type="text" readonly class="form-control-plaintext input-for-accountPage" id="staticEmail" value='<?php echo($username)?>'>
                                    </div>
                                    <div class="form-group row">
                                            <label>Forename</label>
                                            <input type="text" readonly class="form-control-plaintext input-for-accountPage" id="staticEmail" value='<?php echo($forename)?>'>
                                    </div>
                                    <div class="form-group row">
                                            <label>Surname</label>
                                            <input type="text" readonly class="form-control-plaintext input-for-accountPage" id="staticEmail" value='<?php echo($surname)?>'>
                                    </div>
                                    <div class="form-group row">
                                        <label>Email</label>
                                        <input type="text" readonly class="form-control-plaintext input-for-accountPage" id="staticEmail" value='<?php echo($email)?>'>
                                    </div>
                                    <div class="form-group row">
                                            <label>Telephone</label>
                                            <input type="text" readonly class="form-control-plaintext input-for-accountPage" id="staticEmail" value='<?php echo($telephone)?>'>
                                    </div>
                                    <div class="form-group row">
                                            <label>Postcode</label>
                                            <input type="text" readonly class="form-control-plaintext input-for-accountPage" id="staticEmail" value='<?php echo($postcode)?>'>
                                    </div>
                                    <div class="form-group row">
                                            <label>Address Line</label>
                                            <input type="text" readonly class="form-control-plaintext input-for-accountPage" id="staticEmail" value='<?php echo($addressLine)?>'>
                                    </div>
                                    
                                        

                                <button type = 'button' class = 'btn btn-sixth' data-toggle='modal' data-target='#myModal'>Edit</button>
                                <a type ='button' href='logout_logic.php' id = 'addToCartButton' class='btn btn-sixth' style='margin-left:3vh;'>Log Out</a>
                            </div>
                    </div>
                    <div class = 'col-md-8'>
                        <div class='customColumn'>
                            <h3>Past Orders</h3>
                            <div class="productsQuickView" data-bs-spy="scroll">
                                <?php
                                $sql = "SELECT Orders.deliveryID, Products.name, Products.productImage, Orders.orderDate 
                                        FROM Orders
                                        JOIN Products ON Orders.itemID = Products.itemID
                                        WHERE Orders.userID = :userID
                                        ORDER BY Orders.orderDate DESC";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':userID', $_SESSION['userID']);
                                $stmt->execute();
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    $orderID = $row['deliveryID'];
                                    $productName = $row['name'];
                                    $productImage = $row['productImage'];
                                    $orderDate = $row['orderDate'];

                                    echo "<div class='productItem' style='margin-bottom:10px; display:flex; align-items:center;'>
                                            <img src=Images/$productImage style='width:100px; height:100px; margin-right:20px;'>
                                            <div>
                                                <p><b>Order ID: $orderID</b></p>
                                                <p>Product Name: $productName</p>
                                                <p>Order Date: $orderDate</p>
                                            </div>
                                        </div>";   
                                }
                                ?>
                            </div>

                            <a type ='button' href='supportPage.php' class='btn btn-sixth' style='margin-left:38%;'>Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        
        

    </main>

    <!--Bottom of navbar-->
    <div class="navbar-bottom">
    </div>

        <?php include_once('basketModal.php'); ?>

    
</body>
</html>
