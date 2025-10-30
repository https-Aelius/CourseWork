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

    <!--Body of the website-->
    <main style='color: rgba(var(--color-foreground), 0.75); background-color: rgb(var(--color-background));'>
        <div class="banner">
            <div class="banner-media-half-1">
                <img class='banner-image' src="Images/Pre database Image/2024-09-30_09.26.28.jpg">
            </div>
            <div class="banner-media-half-2">
                <img class="banner-image" src="Images/Pre database Image/40-voyager-banner-9.jpg" alt="">
            </div>
        </div>
        <div class="topSection">
            <div class="container" style='min-height:auto; padding-top:0vh; width:100%;'>
                <div class="innerContainer" style="min-height:auto; border-bottom:1px solid #2c2c2c; border-top:0;">
                    <ul class="breadcrumb" style='margin-bottom:16px; line-height:1.1 color: rgba(var(--color-foreground), 0.75) !important; background-color: rgb(var(--color-background)) !important;'>
                        <li><a href="mainPage.php" style='text-decoration:none; color:#2c2c2c;'>Home</a></li>
                        <li><a href="waterBottleSec.php" style='text-decoration:none; color:#2c2c2c;'>About Us</a></li>
                    </ul>
                    <div class="main_column_heading" style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 24px;">
                    <div class="column" style="display: flex; align-items: flex-end; gap:32px;">
                        <h1  style=" line-height:1.1; margin-bottom:1.5vh; color:#2c2c2c;">About Us</h1>
                    </div>        
                    
                    </div>
                </div>
            </div>
        </div>
        <div class="section" style="padding-top: 72px; padding-bottom: 36px;">
            <div style="max-width: var(--page-width); margin: 0 auto; padding: 0 5rem;">
                <div>
                    <div class="about-us-grid" style="margin-bottom: 0; column-gap: 0; row-gap: 0;">
                        <div class="about-image grid__item" style="width:65%; margin-right:10px;">
                            <div style="min-height:100%; position:relative; min-width:100%;">
                                <div style="height: 46rem; width:100%;">
                                    <img class="about-us-inside-image" src="Images/Pre database Image/2024-09-30_09.26.21.jpg" style="min-width:100%;">
                                </div>
                            </div>
                            
                        </div>
                        <div class="about-description" style="margin-left:10px; width:33%;">
                            <div style="padding: 6rem 7rem 7rem;">
                                <h1 class="about-us-title" style="text-align:left; color:#2c2c2c;">
                                    BOTTLELEAK — PURE DESIGN, PURE HYDRATION
                                </h1>
                                <div class="about-us-text">
                                    <p style='font-size:16px;'>At BottleLeak, based in Chicago, we set out to redefine how people stay hydrated. Our mission began with a simple idea — to craft durable, sustainable, and beautifully designed bottles that fit seamlessly into modern life. We studied the challenges of existing products — from leaks to limited durability — and engineered a smarter, eco-conscious solution built for reliability and style.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section" style="padding-bottom: 72px;">
            <div style="max-width: var(--page-width); margin: 0 auto; padding: 0 5rem;">
                <div>
                    
                    <div class="about-us-grid" style="margin-bottom: 0; column-gap: 0; row-gap: 0;">

                        <div class="about-description" style="margin-right:10px; width:33%;">
                            <div style="padding: 6rem 7rem 7rem;">
                                <h1 class="about-us-title" style="text-align:left; color:#2c2c2c;">
                                    OUR COMMITMENT
                                </h1>
                                <div class="about-us-text">
                                    <p style='font-size:16px;'>
                                        We believe that premium performance shouldn’t come at a premium cost. At BottleLeak, we focus on thoughtful design, responsible manufacturing, and direct-to-consumer value to deliver top-quality hydration products without compromise. Each BottleLeak product reflects our dedication to sustainability, innovation, and the customers who inspire us every day.
                                    </p>
                                </div>
                            </div>

                        </div>

                        <div class="about-image grid__item" style="width:65%; margin-left:10px;">
                            <div style="min-height:100%; position:relative; min-width:100%;">
                                <div style="height: 46rem; width:100%;">
                                    <img class="about-us-inside-image" src="Images/Pre database Image/voyager-preview-meta.webp" style="min-width:100%;">
                                </div>
                            </div>
                            
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
