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
    <main style="background-color:#fff;">
        <div class="topSection" style="margin-bottom:10vh;">
            <div class="container" style='min-height:auto; padding-top:0vh; width:100%;'>
                <div class="innerContainer" style="min-height:auto; border-top:0; border-bottom:0;">
                    <ul class="breadcrumb" style='margin-bottom:16px; background-color:#fff !important;'>
                        <li><a href="mainPage.php" style='text-decoration:none; color:#2c2c2c;'>Home</a></li>
                        <li><a href="waterBottleSec.php" style='text-decoration:none; color:#2c2c2c;'>Support Page</a></li>
                    </ul>
                    <div class="main_column_heading" style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 12px; border:none;">
                        <div class="column" style="display: flex; align-items: flex-end; gap:32px;">
                            <h1  style=" line-height:1.1; margin-bottom:1.5vh; color:#2c2c2c;">Contact Us</h1>
                            
                        </div>        
                    
                    </div>
                    <div class="second_column_heading" style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom:1px solid #2c2c2c;">
                        <div class="column" style="display: flex; align-items: flex-end; gap:32px;">
                            <p style="margin-left:24.5px;">Have a question? Feel free to send us an email or text.</p>
                            
                        </div>        
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-us-card-section">
            <div class="support-us-grid">
                <div class="support-us-column">
                    <div class="flex-auto">
                        <div class="content-card">
                            <div style="margin-top:0; margin-bottom:.5rem;">
                                <br>
                                <h5 style="font-size: 22px; line-height: 1; color:#000; font-weight:500; letter-spacing:0.36px;">Warranty</h5>
                                <br>
                                <p class="about-us-text">
                                    Our products come with a one-year warranty that covers manufacturing defects and workmanship issues. 
                                </p>
                                <br>
                                <p class="about-us-text">
                                If you encounter any problems with your purchase within this period, reach out to:
                                </p>
                                <br>
                                <p class="about-us-text">
                                    <a class="email-link" href="mailto:CONTACT@HYDRAPEAK.COM">
                                        CONTACT@HYDRAPEAK.COM
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="support-us-column">
                    <div class="flex-auto">
                        <div class="content-card">
                            <div style="margin-top:0; margin-bottom:.5rem;">
                                <br>
                                <h5 style="font-size: 22px; line-height: 1; color:#000; font-weight:500; letter-spacing:0.36px;">Warranty</h5>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="support-us-column">
                    <div class="flex-auto">
                        <div class="content-card">
                            <div style="margin-top:0; margin-bottom:.5rem;">
                                <br>
                                <h5 style="font-size: 22px; line-height: 1; color:#000; font-weight:500; letter-spacing:0.36px;">Warranty</h5>
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
