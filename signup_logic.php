<?php
include_once('connection.php');
session_start();
print_r($_POST);

//sanitizing the input
$_POST = array_map('htmlspecialchars', $_POST);

//validating the email format
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $_SESSION['Message1'] = "<p style = 'color:red;'>Invalid Email Format</p>";
    header('Location: signup.php');
    exit();
}

//removing whitespace (trimming) and verifying the passwords match
$pwd = trim($_POST['password']);
$confirmPassword = trim($_POST['confirm']);
if ($pwd !== $confirmPassword){
    $_SESSION['Message2'] = "<p style = 'color:red;'>Passwords do not match</p>";
    header('Location: signup.php');
    exit();
}

//ensuring only 1 email exists in the database
$email=$_POST['email'];
$stmt = $conn->prepare("SELECT email FROM Users WHERE email = :email;");
$stmt->bindParam(':email', $email);
$stmt->execute();
if ($email == $stmt->fetch(PDO::FETCH_ASSOC)){
    $_SESSION['Message1'] = "<p style = 'color:red;'>Email already exists</p>";
    header('Location: signup.php');
    exit();
}

//ensuring only 1 username exists in the database
$username=$_POST['username'];
$stmt = $conn->prepare("SELECT email FROM Users WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();
if ($username == $stmt->fetch(PDO::FETCH_ASSOC)){
    $_SESSION['Message1'] = "<p style = 'color:red;'>Username already exists</p>";
    header('Location: signup.php');
    exit();
}

 //now ensuring password is over 8 digits and and contain at least one number, one uppercase letter, one lowercase letter
if (strlen($_POST["password"]) < 8){
    $_SESSION['Message2'] = "<p style = 'color:red;'>Password must be at least 8 characters and contain at least one number, one uppercase letter, one lowercase letter.</p>";
    header('Location: signup.php');
    exit();
}

if (!preg_match("#[0-9]+#", $_POST["password"]) || !preg_match("#[A-Z]+#", $_POST["password"]) || !preg_match("#[a-z]+#", $_POST["password"])){
    $_SESSION['Message2'] = "<p style = 'color:red;'>Password must be at least 8 characters and contain at least one number, one uppercase letter and one lowercase letter.</p>";
    header('Location: signup.php');
    exit();
}



try{
    $conn-> beginTransaction();

    $sql = 'INSERT INTO Users (userID,  username, forename, surname, email, password, role, telephone, postcode, addressLine) 
    VALUES (null, :username, :forename, :surname, :email, :password, 1, :telephone, :postcode, :addressLine)';
    $stmt = $conn->prepare($sql);

    $hashPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt -> bindParam(':username', $_POST['username']);
    $stmt->bindParam(':forename', $_POST['forename']);
    $stmt->bindParam(':surname', $_POST['surname']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':password', $hashPassword);
    $stmt->bindParam(':telephone', $_POST['telephone']);
    $stmt->bindParam(':postcode', $_POST['postcode']);
    $stmt->bindParam(':addressLine', $_POST['addressLine']);
    
    $stmt->execute();

    echo"end of sql";

    $conn->commit(); 
    //redirecting to the login page after successful signup containing the username



    header('Location: login.php');
} catch (PDOException $e) {
    $conn->rollBack(); //going back if there is an error during transaction
    die('Error: ' . $e->getMessage());
}


?>