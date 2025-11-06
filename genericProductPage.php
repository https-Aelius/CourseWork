<?php
session_start();
include_once('connection.php');
$_SESSION['last_page'] = $_SERVER['REQUEST_URI']; // Store the current page URL

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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="script.js" defer></script>

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
                            <input name ="search" type = "text" class = 'navbar-search-input' placeholder = 'SEARCH'>
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
        <div class="container productPage" style='min-height:100dvh; padding-top:100px; padding-bottom:100px;'>
            <div class="row">
                <!--Image gallery-->
                <div class="col-md-6 cold-sm-12 text-center">
                    <div class="mainImage">
                        <img src="Images/<?php echo $productImage; ?>">
                    </div>
                </div>
                <!--Info of product-->
                <div class="col-md-6 col-sm-12" style="align-self:center; text-center;">
                    <ol class="breadcrumb" style="background:none;">
                        <li><a href='#'><?php echo $productType; ?></a></li>
                        <li><a href="#"><?php echo $name;?></a></li>
                    </ol>

                    <h2 class="productTitle"><?php echo $name;?></h2>

                    <div class="rating">
                        <?php
                        $stmt = $conn->prepare("SELECT AVG(ratingNumber) FROM Reviews WHERE itemID = :itemID");
                        $stmt->bindParam(':itemID', $itemID);
                        $stmt->execute();
                        $averageRating = $stmt->fetchColumn();
                        $fullStars = floor($averageRating);
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $fullStars) {
                                echo "<span class='bi bi-star-fill' style='color:gold;'></span>";
                            } else {
                                echo "<span class='bi bi-star' style='color:gold;'></span>";
                            }
                        }
                        ?>
                    </div>

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
        <div class="container" style='padding:64px 20px; width:100%; background-color: #dedede; border-top:1.5px solid #2c2c2c; border-bottom:1.5px solid #2c2c2c;'>
            <div class="productDimension">
                
                            <?php
                            if ($productType == 'Water Bottles'){
                                echo "
                                <div class='productDimensionSlider' style='margin-left:1vh;'>
                    <h3 class='productDimensionTitle'>Active Dimensions</h3>
                    <div class='dimensionSlider' style='display:flex; gap:32px;'>
                        <ul>
                            <li class='dimensionSliderNav active'>Current Bottle
                                
                            </li>    
                            <li class='dimensionSliderNav'>Crayon Shin Chan Series
                                
                            </li>
                            <li class='dimensionSliderNav'>Taller 32oz Bottle
                                
                            </li>
                            <li class='dimensionSliderNav'>Wider 32oz Bottle
                                
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <div class='productDimensionSlider'>
                    <!--Current Bottle-->
                    <img class='productDimensionSliderImages active' src='Images/$dimensionImage' style='width:100%; height:auto;'>
                    <!--Crayon Shin Chan bottles-->
                    <img class='productDimensionSliderImages' src='Images/Pre database Image/S74979eefff16409fad5d6a832f7d5eecf.jpg_960x960q75.avif' style='width:100%; height:auto;'>
                    <!--Taller 32oz Bottles-->
                    <img class='productDimensionSliderImages' src='Images/Pre database Image/Knicks_Bottle_Dimensions_small_8d088ecf-2c0c-4b93-9965-c84ee28f3904.jpeg' style='width:100%; height:auto;'>
                    <!--Wider 32oz Bottles-->
                    <img class='productDimensionSliderImages' src='Images/Pre database Image/w-active-32-sticker-dimension.png' style='width:100%; height:auto;'>
                </div>
                
                            ";
                            }
                            elseif( $productType == 'Food Jars'){
                                echo "
                <div class='productDimensionSlider' style='margin-left:1vh;'>
                    <h3 class='productDimensionTitle'>Active Dimensions</h3>
                    <div class='dimensionSlider' style='display:flex; gap:32px;'>
                        <ul>
                            <li class='dimensionSliderNav active'>Current Food Storage
                                
                            </li>    
                            <li class='dimensionSliderNav'>18oz
                                
                            </li>
                            <li class='dimensionSliderNav'>25oz
                                
                            </li>
                            <li class='dimensionSliderNav'>32oz
                                
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <div class='productDimensionSlider'>
                    <!--Current Bottle-->
                    <img class='productDimensionSliderImages active' src='Images/$dimensionImage' style='width:100%; height:auto;'>
                    <!--18oz-->
                    <img class='productDimensionSliderImages' src='Images/Pre database Image/jar_small_799153ca-8ac8-4408-83a0-eb6adef93b9c.png' alt='not available' style='width:100%; height:auto;'>
                    <!--25oz-->
                    <img class='productDimensionSliderImages' src='Images/Pre database Image/jar_med.png' style='width:100%; height:auto;'>
                    <!--32oz-->
                    <img class='productDimensionSliderImages' src='Images/Pre database Image/jar_big.png' style='width:100%; height:auto;'>
                </div>
                                ";
                            }
                            elseif ( $productType == 'Pets'){
                                echo "
    <div class='productDimensionSlider' style='margin-left:1vh;'>
                    <h3 class='productDimensionTitle'>Active Dimensions</h3>
                    <div class='dimensionSlider' style='display:flex; gap:32px;'>
                        <ul>

                            <li class='dimensionSliderNav'>Small
                                
                            </li>
                            <li class='dimensionSliderNav'>Large
                                
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <div class='productDimensionSlider'>
                    <!--Small-->
                    <img class='productDimensionSliderImages active' src='Images/Pre database Image/bowl4_73d610fa-9515-40a4-960b-188eed157866.png' style='width:100%; height:auto;'>
                    <!--Large-->
                    <img class='productDimensionSliderImages' src='Images/Pre database Image/bowl8_8a4b751d-c25c-4559-ac23-c0227b476a15.png' alt='not available' style='width:100%; height:auto;'>
                </div>
                                ";
                            }
                            elseif ( $productType == 'Accessories'){
                                echo "
                                <div class='productDimensionSlider' style='margin-left:1vh;'>
                    <h3 class='productDimensionTitle'>Active Dimensions</h3>
                    <div class='dimensionSlider' style='display:flex; gap:32px;'>
                        <ul>
                                <li class='dimensionSliderNav'>Current Item
                                
                            </li>
                            <li class='dimensionSliderNav'>Key Chain
                                
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <div class='productDimensionSlider'>
                    <!--Current Item-->
                    <img class='productDimensionSliderImages active' src='Images/$dimensionImage' style='width:100%; height:auto;'>
                    <!--Key Chain-->
                    <img class='productDimensionSliderImages' src='Images/Pre database Image/Crayon Shinchan & Shiro Hero Duo Keychain Dimension.png' alt='Image Unavailable' style='width:100%; height:auto;'>
                </div>
                                ";
                            }

                            ?>
                <div class='productDimensionSliderExtra' style='margin-right:1vh;'>
                    <div class='productDimensionExtras'>
                        <div class="productDimensionItems">
                            <img src="Images/Pre database Image/cold.png" style="object-fit:contain; object-position:center" width="" height="45">
                            <p style='font-size: 14px;'>24 HOURS HOT/COLD</p>

                        </div>
                        <div class="productDimensionItems">
                            <img src="Images/Pre database Image/steel.avif" style="object-fit:contain; object-position:center" width="" height="45">
                            <p style='font-size: 14px;'>LAYERED WITH COMPOSITE MATERIALS</p>

                        </div>
                        <div class="productDimensionItems">
                            <img src="Images/Pre database Image/bpa_free_235bf96a-35e5-49e0-9adb-cbbb36da2338.avif" style="object-fit:contain; object-position:center" width="" height="45">
                            <p style='font-size: 14px;'>BPA FREE</p>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>    
        <div class="container" style='border-bottom:1.5px solid #2c2c2c; width:100%; min-height:50dvh; padding-top:100px; padding-bottom:100px;'>

                <h1 style="margin-right:65%; margin-bottom:32px; font-size:36px;">Leave a Review</h1>
                <div class="container Reviews" style="">

                        <div class="reviewColumn">
                            <div class="rating-card">
                                <!--star rating code-->
                                <h3 style="font-size:32px;">Star Rating</h3>
                                <div class="star-rating animated-stars" style='margin-top:1vh;'>
                                    <input type="radio" id="star5" name="rating" value="5">
                                    <label for="star5" class="bi bi-star-fill"></label>
                                    <input type="radio" id="star4" name="rating" value="4">
                                    <label for="star4" class="bi bi-star-fill"></label>
                                    <input type="radio" id="star3" name="rating" value="3">
                                    <label for="star3" class="bi bi-star-fill"></label>
                                    <input type="radio" id="star2" name="rating" value="2">
                                    <label for="star2" class="bi bi-star-fill"></label>
                                    <input type="radio" id="star1" name="rating" value="1">
                                    <label for="star1" class="bi bi-star-fill"></label>
                                </div>
                                <p class="text-muted" style='margin-top:2.5vh;'>Click to rate</p>
                            </div>
                        </div>
                        <script>
                            document.querySelectorAll('.star-rating:not(.readonly) label').forEach(star => {
                                star.addEventListener('click', function() {
                                    this.style.transform = 'scale(1.2)';
                                    setTimeout(() => {
                                        this.style.transform = 'scale(1)';
                                    }, 200);
                                });
                            });
                        </script>
                        <div class="reviewColumn">
                            <div class="input-group">
                                <textarea name="description" type='text' class='descriptionTextArea' placeholder='Enter Review Here...' style='padding: 20px 20px; min-height:25dvh;'></textarea>
                            </div>
                        </div>  
                        
            
                </div>
                <a type ='button' href='#' id = 'addReview' class='btn btn-sixth' style='margin-left:80%;'>Submit</a>
                <script>
                        document.getElementById("addReview").addEventListener("click", function(event) {

                            const ratingNumber = document.querySelector('input[name="rating"]:checked').value;
                            const itemID = <?php echo $itemID; ?>;
                            const userID = <?php echo $_SESSION['userID']; ?>;
                            const reviewContent = document.querySelector('.descriptionTextArea').value;
                            window.location.href = `reviews_logic.php?itemID=${itemID}&userID=${userID}&ratingNumber=${ratingNumber}&reviewContent=${encodeURIComponent(reviewContent)}`;
                        });
                    </script>
            <div class="container userReviews">
                <h1 style="margin-bottom:32px; font-size:32px; margin-right:65%;">User Reviews</h1>
                <?php
                    $stmt = $conn->prepare("SELECT Reviews.*, Users.username
                    FROM Reviews 
                    JOIN Users ON Reviews.userID = Users.userID 
                    WHERE Reviews.itemID = :itemID ORDER BY Reviews.dateReview DESC");
                    $stmt->bindParam(':itemID', $itemID);
                    $stmt->execute();
                    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);    

                    if ($reviews) {
                        foreach ($reviews as $review) {
                            echo "<div class='userReviewCard' style='margin-bottom:24px; padding:16px; border:1px solid #ccc; border-radius:8px;'>";
                            echo "<h4>" . htmlspecialchars($review['username']) . "</h4>";
                            echo "<div class='star-rating-users readonly' style='margin-top:8px;'>";

                            for ($i = 1; $i <= 5; $i++) {

                                
                                if ($i <= $review['ratingNumber']) {
                                    echo "<span class='bi bi-star-fill' style='color: gold;'></span>";
                                } else {
                                    echo "<span class='bi bi-star' style='color: gold;'></span>";
                                }
                            }

                            echo "</div>";
                            echo "<p style='margin-top:8px;'>" . htmlspecialchars($review['reviewContent']) . "</p>";
                            echo "<small class='text-muted'>Reviewed on " . date('F j, Y, g:i a', strtotime($review['dateReview'])) . "</small>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No reviews yet. Be the first to review this product!</p>";
                    }
                ?>
            </div>        
        </div>
    </main>
    

    <!--Bottom of navbar-->
    <div class="navbar-bottom">
    </div>

    <?php include_once('basketModal.php'); ?>

</body>
</html>
