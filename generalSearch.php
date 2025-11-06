<?php

session_start();
include_once('connection.php');
$_SESSION['last_page'] = $_SERVER['REQUEST_URI']; // Store the current page URL
?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BottleLeak & Co.</title>
    <link rel="stylesheet" href="styles.css">
    <link rel='stylesheet' href='mainPageCss.css'>

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
        <div class="search-header" style="padding-top:75px;">
            <div class="form-group-row">
                <h1 style="text-align: center; font-size:32px">Search Results</h1>

                <form class="general-search-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="width:100%; !important; self-align:right; flex-direction:row; height:10%;">
                    <div class="">

                        <input name ='search' type="" id='search-box-general' class="general-search-box" placeholder="Search product by name or description..." style="margin-left:20%;">

                        <button style='margin-right:23.5%; margin-top:20px; font-size:18px;' type = "reset" class ='btn btn-search'>
                            <span class="glyphicon glyphicon-remove-circle"></span> <!--clear icon-->
                        </button> 
                        <button style='margin-right:20%; margin-top:20px; font-size:18px; border-left: 1px solid #2c2c2c2c;' type = "submit" class = 'btn btn-search'>
                            <span class="glyphicon glyphicon-search"></span> <!--Search icon-->
                        </button> 
                    </div>

                </form>

            </div>
            
        </div>
        <div class="mainSection container" style='display:flex; min-height:100dvh; padding-top:100px; padding-bottom:100px;'>
            <div class="product-grid-container" style='position:relative;'>

                <ul id="product-grid" class="
            grid product-grid grid--2-col-tablet-down
            grid--4-col-desktop
            ">
                <!-- other cards-->
                 <?php
                 include_once('connection.php');

                 if(isset($_POST['search'])){
                    $search="%" . $_POST['search'] . "%";
    
    
                    $stmt=$conn->prepare("SELECT * FROM Products WHERE name LIKE :search OR description LIKE :search");
                    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
                } else{
                    $stmt = $conn->prepare("SELECT * FROM Products");
                }    
                    $stmt->execute();
                 if($stmt->rowCount()>0){
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $itemID=$row['itemID'];
                        $name=$row['name'];
                        $price=$row['price'];
                        $productImage=$row['productImage'];
                        $description=$row['description'];
                        $dimensionImage=$row['dimensionImage'];
                        $quant=$row['quant'];
                        $productType=$row['productType'];
                        $itemSold=$row['itemSold'];
                        $discountRate=$row['discountRate'];
                        if($discountRate>0){
                            $actualPrice= $price - ($price * ($discountRate/100));
                        } else {
                            $actualPrice = $price;
                        }
                        $actualPrice = number_format($actualPrice, 2);
                        echo ("

                        <li class='grid__item product-custom-card' style=''>
                            <a href='genericProductPage.php?itemID=$itemID' class='product-link' style='text-decoration:none; color:black;'>
                                <div class='product-card'>
                                    <div class='product-image'>
                                ");
                                if($discountRate>0){
                                    echo("<span class='discount-tag'>$discountRate% Off</span>
                                        <img src='Images/$productImage' class='product-thumb' alt=''>
                                        <button class='card-btn'>Add to Basket</button>
                                    </div>
                                    <div class='product-info'>
                                        <h3 class='product-brand'>$name</h3>

                                        <span class='price'>$ $actualPrice</span><span class='actual-price'>$ $price</span>
                                    </div>
                                </div>
                                </a>
                        </li>
                                    
                                    ");
                                } else{
                                    echo("
                                    
                                    <img src='Images/$productImage' class='product-thumb' alt=''>
                                        <button class='card-btn'>Add to Basket</button>
                                    </div>
                                    <div class='product-info'>
                                        <h3 class='product-brand'>$name</h3>

                                        <span class='price'>$ $actualPrice</span>
                                    </div>
                                </div>
                                </a>
                        </li>

                                    ");
                                }
                    }}
                 ?>
            </ul>

            </div>
        </div>
    </main>

    <!--Bottom of navbar-->
    <div class="navbar-bottom">
    </div>
    <?php include_once('basketModal.php'); ?>
</body>
</html>
