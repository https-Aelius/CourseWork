<?php
include_once('connection.php');
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
        <div class="innerContainer">
            <h4>Home / Account </h4>
            <h1>Login</h1>
        </div>
        <div class="loginContainer">
            <div class="imgColumn">
                <img src = 'premium_photo-1664527305901-db3d4e724d15.avif'>
            </div>
            <div class = "loginColumn">
                <form action = "login_logic.php" method = "POST">
                    <div class="loginForm">
                        <label class = 'loginInputs'>
                            <span>
                                USERNAME OR EMAIL
                                <span class = "required">*</span>
                                <?php
                                session_start();
                                if (isset($_SESSION['Message2'])){
                                    echo($_SESSION['Message2']);
                                    unset($_SESSION['Message2']);
                                }
                            ?>
                            </span>
                            
                            <input type = "text" name = 'logInUser' placeholder = '' value = "<?php echo $username?>" required><br>
                        </label>
                        <label class = 'loginInputs'>
                            <span>
                                PASSWORD
                                <span class = "required">*</span>
                                <?php
                                session_start();
                                if (isset($_SESSION['Message1'])){
                                    echo($_SESSION['Message1']);
                                    unset($_SESSION['Message1']);
                                }
                                ?>
                            </span>
                           
                            <input type = "password" name = 'password' placeholder = '' required><br>
                        </label>

                    </div>
                    <div class="belowLoginForm">
                        <button type = "submit" class = 'btn btn-sixth' style = 'margin-top:32px;' id = 'loginButton'>Login</button>
                    </div>
                    <div class="otherLinks">
                        <a href='signup.php' class = 'loginSimpleLink'>Sign Up</a>
                    </div>
                    
                </form>
            </div>

        </div>
        
    </main>

    <!--Bottom of navbar-->
    <div class="navbar-bottom">
    </div>

        

    <?php include_once('basketModal.php'); ?>    
</body>
</html>
