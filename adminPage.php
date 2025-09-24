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
                            <h3>Total Profits & Revenue</h3>
                            <p>[the details......]</p>
                        </div>
                    </div>
                
            

                    <!--ALL ORDERS SECTION-->


                    <div class="col-md-4" style='margin-top:14.6vh;'>
                        <div class="customColumn">
                            <h3>All Orders</h3>
                            <p>[the details......]</p>
                        </div>
                    <!--记得要写php code -->
                        
                    </div>


                    <!--DATABASES/STOCK SECTION-->
                
                    <div class="col-md-4" style='margin-top:14.6vh;'>
                    <!--记得要写php code -->
                        <div class="customColumn">
                            <h3>Products & Stock</h3>
                            <div class="productsQuickView" data-bs-spy='scroll'>
                                <?php
                                    $stmt = $conn->prepare("SELECT * FROM Products");
                                    $stmt->execute();
                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        $name = $row['name'];
                                        $quant = $row['quant'];
                                        $itemSold = $row['itemSold'];
                                        $itemID= $row['itemID'];

                                        echo "<div class='productItem' style='margin-bottom:10px;'>
                                                <p><b>$name</b></p>
                                                <p>Stock: $quant</p>
                                                <p>Items Sold: $itemSold</p>
                                            </div>";   
                                        
                                    }

                                ?>
                            </div>
                            <div class="customColumnBottom">
                                <form action='addProductPage.php' class ='adminPageButtons'>
                                    <button class="btn btn-sixth" type = 'submit'>Add Product</button>
                                </form>
                                <form action = 'updateStockPage.php' class = 'adminPageButtons'>
                                    <button class="btn btn-sixth" type='submit'>Update Stock</button>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>    
        </div>
        
        

    </main>


    <div class="navbar-bottom">
    </div>
</body>
</html>
