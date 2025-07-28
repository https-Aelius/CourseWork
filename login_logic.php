<?php
include_once("connection.php");
session_start();
print_r($_POST);
print('<br>');

$_POST = array_map('htmlspecialchars', $_POST);

$username = trim($_POST['username']);
$password = trim($_POST['password']);

$stmt = $conn->prepare('SELECT *FROM Users WHERE username = :username');
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$hash = trim($user['password']); //this line, I have to somehow get the unhashed password from this line!!!!!

if ($user){
    echo('User Found <br>');
    echo($user['password'].'br');
    echo'<br>';
    echo $password;
    echo('<br>');
    if (password_verify($password, $hash)){
        echo 'Logging on...<br>';
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('location: mainPage.php'); /*change this*/

    } else{
        echo "Invalid Password";
    }
} else{
    echo "User not found";
}
?>