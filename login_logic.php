<?php
include_once("connection.php");
session_start();
print_r($_POST);
print('<br>');
$is_invalid = true;

$_POST = array_map('htmlspecialchars', $_POST);

$username = trim($_POST['username']);
$password = trim($_POST['password']);

$stmt = $conn->prepare('SELECT * FROM Users WHERE username = :username');
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user){
    echo('User Found <br>');
    echo($user['password'].'<br>');
    echo'<br>';
    echo $password;
    echo('<br>');

    if (password_verify($password, $user['password'])) {
        echo 'Logging on...<br>';
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $is_invalid=false;
        header('location: mainPage.php'); //change this once mainPage is finished
    } else{
        echo "Invalid Password";
    }
} else{
    echo "User not found";
}
?>