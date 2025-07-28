<?php
include_once('connection.php');
session_start();
print_r($_POST);

//sanitizing the input
$_POST = array_map('htmlspecialchars', $_POST);

//validating the email format
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    die('Invalid Email Format');
}

//removing whitespace (trimming) and verifying the passwords match
$pwd = trim($_POST['password']);
$confirmPassword = trim($_POST['confirm']);
if ($pwd !== $confirmPassword){
    die('Passwords do not match');
}

try{
    $conn-> beginTransaction();

    $sql = 'INSERT INTO Users (userID,  username, forename, surname, email, password, role) VALUES (null, :username, :forename, :surname, :email, :password, 1)';
    $stmt = $conn->prepare($sql);


    $hashPassword = password_hash($_POST['passwd'], PASSWORD_DEFAULT);
    $stmt -> bindParam(':username', $_POST['username']);
    $stmt->bindParam(':forename', $_POST['forename']);
    $stmt->bindParam(':surname', $_POST['surname']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':password', $hashPassword);
    $stmt->execute();

    $conn->commit(); 
    echo"hellowwww";
    //redirecting to the login page after successful signup containing the username
    header('Location: login.php');
} catch (PDOException $e) {
    $conn->rollBack(); //going back if there is an error during transaction
    die('Error: ' . $e->getMessage());
}


?>