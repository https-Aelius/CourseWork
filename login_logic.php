<?php
include_once("connection.php");
session_start();
print_r($_POST);
print('<br>');
$is_invalid = true;

$_POST = array_map('htmlspecialchars', $_POST);
$email = trim($_POST['logInUser']);
$username = trim($_POST['logInUser']);
$password = trim($_POST['password']);

$stmt = $conn->prepare('SELECT * FROM Users WHERE username = :username');
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare('SELECT * FROM Users WHERE email = :email');
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$logEmail = $stmt->fetch(PDO::FETCH_ASSOC); 

$stmt = $conn->prepare('SELECT * FROM Users WHERE password = :password');
$stmt->bindParam(':password', $dbPassword, PDO::PARAM_STR);
$stmt->execute();
$dbPassword = $stmt->fetch(PDO::FETCH_ASSOC); 



if ($user){
    echo('User Found <br>');
    echo'hashed password of user: ';
    echo($user['password'].'<br>');
    echo'<br>';
    echo'password input: ';
    echo $password;
    echo('<br>');

    if (password_verify($password, $user['password'])) {
        echo 'Logging on...<br>';
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $is_invalid=false;


        //now redirecting the user based on their role
        if ($user['role'] ==1 ){
            //header('Location: mainPage.php');
            exit();

        } elseif ($user['role'] ==2 ){

            //header('Location: adminPage.php');
            exit();


        } else{
            //header('Location: errorPage.php');
            exit();
            echo $user['role'];
            echo 'else';
        }

    } else{
        //header("Location: login.php");
        $_SESSION['Message1'] = "<p style = 'color:red;'>Invalid Password</p>";
        exit();

    }
} 


    

if ($logEmail){
    echo('User Found <br>');
    echo'hashed password';
    echo($logEmail['password'].'<br>');
    echo'<br>';
    echo'password:';
    echo $password;
    echo('<br>');

    if (password_verify($password, $logEmail['password'])) {
        echo 'Logging on...<br>';
        $_SESSION['userID'] = $logEmail['userID'];
        $_SESSION['username'] = $logEmail['username'];
        $_SESSION['role'] = $logEmail['role'];
        $is_invalid=false;

        //now redirecting the user based on their role
        if ($logEmail['role'] ==1 ){
            header('Location: mainPage.php');
            exit();
        } elseif ($logEmail['role'] ==2 ){
            header('Location: adminPage.php');

            exit();
        } else{
            header('Location: errorPage.php');
            exit();
        }

    } else{
        //header("Location: login.php");
        $_SESSION['Message1'] = "<p style = 'color:red;'>Invalid Password</p>";
        exit();
    }
}

else{

    //header('Location: login.php');
    $_SESSION['Message2'] = "<p style = 'color:red;'>User not found</p>";
    exit();
}
?>

