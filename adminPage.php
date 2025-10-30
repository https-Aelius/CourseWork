<?php
    session_start();
    //connects webpage to the database to allow for validation
    include_once('connection.php');

    //starting the session to ensure that the user is an admin
    
    //if user's role isn't 2, then its not an admin and they get sent back to the mainPage.
    //getting the session variable from previous page (login_logic.php)
    if ($_SESSION['role'] != 2){
        header('Location: mainPage.php');
        exit();
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

    <main>
        <div class="accountPageDiv">
            <div class="container-fluid mt-5">
                <div class="row">
                    
                    <div class="col-md-4">
                    <div class='accountTop'>
                        <h3>Admin</h3>
                    </div>
                    <!--PROFITS SECTION SECTION-->
                    <!--记得要写php code -->
                        <div class="customColumn">
                            <h2>Total Profits & Revenue</h2>
                            <?php
                            try{
                                //assuming 20% profit margin (we can change this value later if needed)
                                $sql1 = "SELECT SUM(Products.price) AS totalRevenue, SUM(Products.price)*0.2 AS totalProfits
                                        FROM Orders
                                        JOIN Products ON Orders.itemID = Products.itemID";
                                $stmt1 = $conn->prepare($sql1);
                                $stmt1->execute();
                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                $totalRevenue = number_format($row1['totalRevenue'], 2);
                                $totalProfits = number_format($row1['totalProfits'], 2);
                                echo "<div class='profitsSection' style='margin-top:2vh;'>
                                        <p><b>Total Revenue: </b> $$totalRevenue</p>
                                        <p><b>Total Profits: </b> $$totalProfits</p>
                                    </div>";
                            } catch (PDOException $e) {
                                echo "Database error: " . $e->getMessage();
                            }

                            ?>
                            <a type ='button' href='https://dashboard.stripe.com' class='btn btn-sixth' style='margin-top:2vh;'>Stripe Dashboard</a>
                            <h2>!Products Low in Stock!</h2>
                            <div class="productsQuickView" style='max-height:40vh;'>
                                <?php
                                try{
                                    $sql4 = "SELECT* FROM Products WHERE quant <= 5 ORDER BY quant ASC";
                                    $stmt4 = $conn->prepare($sql4);
                                    $stmt4->execute();
                                    while($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)){
                                        $name = $row4['name'];
                                        $quant = $row4['quant'];
                                        $itemID= $row4['itemID'];

                                        echo "<div class='productItem' style='margin-bottom:10px;'>
                                                <p><b>itemID: </b>$itemID</p>
                                                <p><b>name: </b>$name</p>
                                                <p><b>Stock: </b>$quant</p>



                                            </div>";   
                                        
                                    }
                                }
                                catch (PDOException $e) {
                                    echo "Database error: " . $e->getMessage();
                                }
                                ?>
                            </div>
                            
                        </div>
                        <a type ='button' href='logout_logic.php' id = 'addToCartButton' class='btn btn-sixth' style='margin-top:4vh; margin-left:3vh;'>Log Out</a>
                    </div>
                
            

                    <!--ALL ORDERS SECTION-->


                    <div class="col-md-4" style='margin-top:14.6vh;'>
                        <div class="customColumn">
                            <h2>All Orders</h2>
                            <div class="productsQuickView" data-bs-spy='scroll'>
                                <?php
                                try{

                                    $sql2 = "SELECT Users.forename, Users.telephone, Users.postcode, Users.addressLine, Products.name 
                                            FROM Orders
                                            JOIN Users ON Orders.userID = Users.userID
                                            JOIN Products ON Orders.itemID = Products.itemID";
                                    $stmt2 = $conn->prepare($sql2);
                                    $stmt2->execute();
                                    while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                                        $forename = $row2['forename'];
                                        $telephone = $row2['telephone'];
                                        $postcode = $row2['postcode'];
                                        $addressLine = $row2['addressLine'];
                                        $productName = $row2['name'];

                                        echo "<div class='productItem' style='margin-bottom:10px;'>
                                                <p><b>Product Name: </b> $productName</p>
                                                <p><b>Customer Name: </b> $forename</p>
                                                <p><b>Telephone: </b> $telephone</p>
                                                <p><b>Address: </b> $addressLine, $postcode</p>
                                            </div>";   
                                    }
                                } catch (PDOException $e) {
                                    echo "Database error: " . $e->getMessage();
                                }
                                ?>
                                <?php
                                ?>
                            </div>
                            <a type ='button' href='viewOrders.php' class='btn btn-sixth' style='margin-left:38%;'>View Orders</a>
                        </div>
                    <!--记得要写php code -->
                        
                    </div>


                    <!--DATABASES/STOCK SECTION-->
                
                    <div class="col-md-4" style='margin-top:14.6vh;'>
                    <!--记得要写php code -->
                        <div class="customColumn">
                            <h2>Products & Stock</h2>
                            <div class="productsQuickView" data-bs-spy='scroll'>
                                <?php
                                    $stmt3 = $conn->prepare("SELECT * FROM Products");
                                    $stmt3->execute();
                                    while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
                                        $name = $row3['name'];
                                        $quant = $row3['quant'];
                                        $itemSold = $row3['itemSold'];
                                        $itemID= $row3['itemID'];

                                        echo "<div class='productItem' style='margin-bottom:10px;'>
                                                <p><b>$name</b></p>
                                                <p>Stock: $quant</p>
                                                <p>Items Sold: $itemSold</p>
                                            </div>";   
                                        
                                    }

                                ?>
                            </div>
                            <div class="customColumnBottom">
                                <form action='addProductPage.php' class ='adminPageButtons' style='margin-top:2vh;'>
                                    <button class="btn btn-sixth" type = 'submit'>Add Product</button>
                                </form>
                                <form action = 'updateStockPage.php' class = 'adminPageButtons' style='margin-top:2vh;'>
                                    <button class="btn btn-sixth" type='submit'>Update Stock</button>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>    
        </div>
        
        

    </main>



    </div>
    <?php include_once('basketModal.php'); ?>
    
</body>
</html>
