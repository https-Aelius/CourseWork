<?php
session_start();
include_once('connection.php');

if (isset($_GET['itemID'])) {
    $itemID = $_GET['itemID'];

    $stmt = $conn->prepare("SELECT * FROM Products WHERE itemID = :itemID");
    $stmt->bindParam(':itemID', $itemID);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $name = $product['name'];
        $description = $product['description'];
        $price = number_format($product['price'], 2);
        $productImage = $product['productImage'];
        $description=$product['description'];
        $dimensionImage=$product['dimensionImage'];
        $quant=$product['quant'];
        $productType=$product['productType'];
        $itemSold=$product['itemSold'];
        $discount = $product['discountRate'];
        $actualPrice = $discount > 0 ? number_format($price - ($price * $discount / 100), 2) : $price;
    } else {
        echo "Product not found!";
        exit;
    }
} else {
    echo "Invalid product ID!";
    exit;
}
?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BottleLeak & Co.</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class = "navbar navbar-default navbar-fixed-top">  
        <div class = "navbar-brand" style = "font-size:20px;">
            <a href='mainPage.php'>
            BOTTLELEAK
            </a>
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

    <!--Body of the website-->
    <main>
        <div class="container productPage">
            <div class="row">
                <!--Image gallery-->
                <div class="col-md-6 cold-sm-12 text-center">
                    <div class="mainImage">
                        <img src="Images/<?php echo $productImage; ?>">
                    </div>
                    <div class="thumbnailList">
                        <img src="Images/<?php echo $dimensionImage; ?>">
                    </div>
                </div>
                <!--Info of product-->
                <div class="col-md-6 col-sm-12">
                    <ol class="breadcrumb" style="background:none;">
                        <li><a href='#'><?php echo $productType; ?></a></li>
                        <li><a href="#"><?php echo $name;?></a></li>
                    </ol>

                    <h2 class="productTitle"><?php echo $name;?></h2>

                    <div class="rating"></div>

                    <div class="priceSection">
                        <?php if ($discount > 0): ?>
                            <span class="originalPrice">$<?php echo $price; ?></span>
                            <span class="discountedPrice">$<?php echo $actualPrice; ?></span>
                            <span class="discountBadge"><?php echo $discount; ?>% OFF</span>
                        <?php else: ?>
                            <span class="price">$<?php echo $price; ?></span>
                        <?php endif; ?>
                    </div>
                    <p class="description">
                        <?php echo $description; ?>
                    </p>

                    <div class="quantity">
                        
                        <button class="btn btn-default quantBtn" id="decreaseQuant">-</button>
                        <input type="text" class="form-control quantInput" id="quantInput" value="1" readonly max='<?php echo $quant;?>'>
                        <button class="btn btn-default quantBtn" id="increaseQuant">+</button>


                        <script>
                            const decrease = document.getElementById("decreaseQuant");
                            const increase = document.getElementById("increaseQuant");
                            const quant = document.getElementById("quantInput");
                            const max = quant.getAttribute("max");

                      
                            console.log(max);

                            increase.addEventListener('click', () => {
                                if(parseInt(quant.value) < max){
                                    quant.value = parseInt(quant.value) +1;
                                    console.log("increase pressed");
                                    
                                }
      
                            });

                            decrease.addEventListener('click', () => {
                                if (quant.value > 1){
                                    quant.value= parseInt(quant.value) -1;
                                    console.log("decreased pressed");
                                    console.log(quant.value);
                                    console.log(max);
                                }
                                console.log("decrease pressed but won't allow for products below 1");
                            });
                            
                            


                        </script>
                    </div>
                    
                    <?php
                    if (isset($_SESSION['userID'])){
                        if ($quant <= 0) {
                            echo '<button class="btn btn-danger add-to-cart-btn" disabled>Pre-Order Now</button>';
                            echo '<p class="stockStatus">In Stock Soon!</p>';
                        } else {
                            echo "<a type ='button' href='#' id = 'addToCartButton' class='btn btn-sixth'>Add to Cart</a>";
    
                        }
                    } else{
                        echo '<button class="btn btn-danger add-to-cart-btn" disabled>Please Log in / Sign up</button>';
                        echo '<p class="stockStatus">To add this product to your basket you must <a href="login.php">login</a> here</p>';
                    }
                    
                    ?>
                    <script>
                        document.getElementById("addToCartButton").addEventListener("click", function(event) {
                            const quantity = document.getElementById("quantInput").value;
                            const itemID = <?php echo $itemID; ?>;
                            window.location.href = `cartAddFunction.php?itemID=${itemID}&quantity=${quantity}`;
                        });
                    </script>

                </div>

            </div>
        </div>
    </main>
    <div class="modal fade" id='myModal' role='dialog'>
        <div class="modal-dialog">
        <!--Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type = 'button' class='close' data-dismiss='modal'>&times;</button>
                <h4 class = 'modal-title'>Edit Account Details</h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
            </div>
        </div>

    <!--Bottom of navbar-->
    <div class="navbar-bottom">
    </div>
    <?php include_once('basketModal.php'); ?>
</body>
</html>
