<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BottleLeak & Co.</title>
    <link rel="stylesheet" href="styles.css">
    <link rel='stylesheet' href='mainPageCss.css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="mainPageJS.js" defer></script>
    <script src="product-slider.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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

    <!--Body of the website-->
    <main>
        <div class="TopPage" style='padding-top:20px;'>
            <section class="carousel next">
                <div class="list">
                    <article class="item other_1"> <!--Laker Bottle-->
                        <?php
                            include_once('connection.php');
                            $stmt = $conn->prepare("SELECT * FROM Products WHERE itemID = 29");
                            $stmt->execute();
                            $product = $stmt->fetch(PDO::FETCH_ASSOC);
                            $itemID=$product['itemID'];
                            $price=$product['price'];
                            $productImage=$product['productImage'];

                        ?>
                        <div class="main-content"
                        style="background-color: #FDB927;"> 
                            <div class="content">
                                <h2>A Revolutionary Bottle</h2>
                                <p class = 'price'>$ <?php echo $price; ?></p>
                                <p class="description">A bottle in collaboration with the Lakers</p>
                                <button class="addToCart">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                        <figure class = 'image'>
                        <!--Enter Image-->
                            <img src="Images/<?php echo $productImage; ?>" alt="" style=''>
                            <figcaption>A Laker Bottle</figcaption>
                        </figure>
                    </article>
                    <article class="item active"> <!--Bull Bottle-->
                        <?php
                            include_once('connection.php');
                            $stmt = $conn->prepare("SELECT * FROM Products WHERE itemID = 26");
                            $stmt->execute();
                            $product = $stmt->fetch(PDO::FETCH_ASSOC);
                            $itemID=$product['itemID'];
                            $price=$product['price'];
                            $productImage=$product['productImage'];

                            ?>
                        <div class="main-content"
                        style="background-color: #eeee;"> 
                            <div class="content">
                                <h2>A Revolutionary Bottle</h2>
                                <p class = 'price'>$ <?php echo $price; ?></p>
                                <p class="description">A bottle in collaboration with the Bulls</p>
                                <button class="addToCart">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                        <figure class = 'image'>
                            <!--Enter Image-->
                            <img src="Images/<?php echo $productImage; ?>" alt="" style='background:none;'>
                            <figcaption>A Bull Bottle</figcaption>
                        </figure>
                    </article>
                    <article class="item other_2"> <!--Maverick Bottle-->
                        <?php
                            include_once('connection.php');
                            $stmt = $conn->prepare("SELECT * FROM Products WHERE itemID = 30");
                            $stmt->execute();
                            $product = $stmt->fetch(PDO::FETCH_ASSOC);
                            $itemID=$product['itemID'];
                            $price=$product['price'];
                            $productImage=$product['productImage'];

                                ?>
                        <div class="main-content"
                        style="background-color: #B8C4CA;"> 
                            <div class="content">
                                <h2>A Revolutionary Bottle</h2>
                                <p class = 'price'>$ <?php echo $price; ?></p>
                                <p class="description">A bottle in collaboration with the Mavs</p>
                                <button class="addToCart">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                        <figure class = 'image'>
                            <!--Enter Image-->
                            <img src="Images/<?php echo $productImage; ?>" alt="" style='background:none;'>
                            <figcaption>A Maverick Bottle</figcaption>
                        </figure>
                    </article>
                </div>
                <div class="arrows">
                    <button id = 'prev'><</button>
                    <button id="next">></button>
                    </div>
                </div>
            </section>
        </div>
        <div class="mainPage" style='margin-bottom:200px;'>
            <div class="product" style="padding:0;">
                <h2 class="product-category">In Collaboration with Crayon Shin Chan</h2>
            </div>
            <div class="product" style='height:100%;'>
                
                <div class="container" style='height:80%;'>
                    <button class="pre-btn" style="background: linear-gradient(270deg, rgba(255, 255, 255, 0) 0%, #fff 100%);"><</button>

                    <button class="nxt-btn">></button>
                </div>
                <div class="product-container" style="min-height:60vh;">
                    <!--Start while statement for php-->  
                    <?php
                        include_once('connection.php');
                        $stmt = $conn->prepare("SELECT * FROM Products WHERE itemID BETWEEN 31 AND 36");
                        $stmt->execute();
                        if($stmt->rowCount()>0){
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                $itemID=$row['itemID'];
                                $name=$row['name'];
                                $price=$row['price'];
                                $productImage=$row['productImage'];
                                $productName=$row['name'];
                                $discountRate=$row['discountRate'];
                                if($discountRate>0){
                                    $actualPrice= $price - ($price * ($discountRate/100));
                                } else {
                                    $actualPrice = $price;
                                }
                                echo("
                                
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

                                    ");
                                }
                                

                            }
                        }


                    ?>  
                
                    
                    <div class="product-card">
                        <div class="product-image">
                            <span class="discount-tag">50% off</span>
                            <img src="" class="product-thumb" alt="">
                            <button class="card-btn">add to wishlist</button>
                        </div>
                        <div class="product-info">
                            <h2 class="product-brand">brand</h2>
                            <p class="product-short-description">description.......</p>
                            <span class="price">$20</span><span class="actual-price">$40</span>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="product-image">
                            <span class="discount-tag">50% off</span>
                            <img src="" class="product-thumb" alt="">
                            <button class="card-btn">add to wishlist</button>
                        </div>
                        <div class="product-info">
                            <h2 class="product-brand">brand</h2>
                            <p class="product-short-description">description.......</p>
                            <span class="price">$20</span><span class="actual-price">$40</span>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="product-image">
                            <span class="discount-tag">50% off</span>
                            <img src="" class="product-thumb" alt="">
                            <button class="card-btn">add to wishlist</button>
                        </div>
                        <div class="product-info">
                            <h2 class="product-brand">brand</h2>
                            <p class="product-short-description">description.......</p>
                            <span class="price">$20</span><span class="actual-price">$40</span>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="product-image">
                            <span class="discount-tag">50% off</span>
                            <img src="" class="product-thumb" alt="">
                            <button class="card-btn">add to wishlist</button>
                        </div>
                        <div class="product-info">
                            <h2 class="product-brand">askdaksldladkasdkl</h2>
                            <p class="product-short-description">description.......</p>
                            <span class="price">$20</span><span class="actual-price">$40</span>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="product-image">
                            <span class="discount-tag">50% off</span>
                            <img src="" class="product-thumb" alt="">
                            <button class="card-btn">add to wishlist</button>
                        </div>
                        <div class="product-info">
                            <h2 class="product-brand">Scrolled</h2>
                            <p class="product-short-description">description.......</p>
                            <span class="price">$20</span><span class="actual-price">$40</span>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="product-image">
                            <span class="discount-tag">50% off</span>
                            <img src="" class="product-thumb" alt="">
                            <button class="card-btn">add to wishlist</button>
                        </div>
                        <div class="product-info">
                            <h2 class="product-brand">brand</h2>
                            <p class="product-short-description">description.......</p>
                            <span class="price">$20</span><span class="actual-price">$40</span>
                        </div>
                    </div>
                    
                </div>




            </div>
        </div>
    </main>

    <!--Bottom of navbar-->
    <div class="navbar-bottom">
    </div>
</body>
</html>
