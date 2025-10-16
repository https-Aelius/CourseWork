<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <div class="innerContainer">
            <h4>Home / Account / Sign Up </h4>
            <h1>Sign Up</h1>
        </div>
        <div class="signupContainer">

            <form action = "signup_logic.php" method = 'POST'>


                <h3>
                    Name
                </h3>
                <input type = "text" placeholder = "Username" name = "username" required>
                <input type = 'text' placeholder = 'Forename' name = 'forename' required>
                <input type = 'text' placeholder = 'Surname' name ='surname' required>
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
                <input type = 'text' placeholder = 'Email' name = 'email' required>


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
                    <input name = 'password' type = 'password' id = 'password' placeholder = 'Password' required>
                    <i class = 'fa-solid fa-eye' id = 'togglePassword' style = 'cursor: pointer;'></i>
                </div>
                <div class = "passwordContainer">
                    <input name = 'confirm' type = 'password' id='confirmPassword' placeholder='Confirm Password' required>
                    <i class = 'fa-solid fa-eye' id = 'toggleConfirmPassword' style = 'cursor: pointer;'></i>
                </div>
                <br>
                <h3>
                    Contact
                </h3>
                <input type = 'tel' placeholder = 'Telephone' name = 'telephone' required>
                
                <h3>
                    Address
                </h3>
                <input type = 'text' placeholder = 'Postcode' name = 'postcode' required>
                <input type = 'text' placeholder = 'Address Line' name = 'addressLine' required>

                <h3>
                    Payment
                </h3>
                <?php
                    session_start();
                    if (isset($_SESSION['Message3'])){
                        echo($_SESSION['Message3']);
                        unset($_SESSION['Message3']);
                    }
                ?>
                <input type = 'number' placeholder = 'Card Number' name = 'cardNo' required>
                <input type = 'text' placeholder = 'Card Name' name = 'cardName' required>
                <input type = 'text' placeholder = 'Card Expiry (MM/YY)' name = 'cardExpiry' required>
                <input type = 'number' placeholder = 'Card CVC' name = 'cardCVC' required>

                <button type = 'submit' id = 'signUpButton' class = 'btn btn-sixth'>Sign Up</button>
            </form>

        </div>
        
    </main>

    <!--Bottom of navbar-->
    <div class="navbar-bottom">
    </div>
    <?php include_once('basketModal.php'); ?>
</body>
</html>
