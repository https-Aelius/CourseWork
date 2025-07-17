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

    //password hashing
    $hashPassword = password_hash($pwd, PASSWORD_BCRYPT);

    $sql = 'INSERT INTO Users (username, forename, surname, email, password, role) VALUES (:username, :forename, :surname, :email, :password, :role)';
    $stmt = $conn->prepare($sql);
    $stmt -> bindParam(':username', $_POST['username']);
    $stmt->bindParam(':forename', $_POST['forename']);
    $stmt->bindParam(':surname', $_POST['surname']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':password', $hashPassword);
    $stmt->bindParam(':role', $_POST['role'] ?? '1'); // Default role is '1' if not set
    $stmt->execute();

    $conn->commit(); 

    //redirecting to the login page after successful signup containing the username
    header('Location: login.php= ' . urlencode['username']);
} catch (PDOException $e) {
    $conn->rollBack(); //going back if there is an error during transaction
    die('Error: ' . $e->getMessage());
}

?>