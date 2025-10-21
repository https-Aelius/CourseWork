<?php
include_once('connection.php');
session_start();
print_r($_POST);
array_map('htmlspecialchars', $_POST);

echo'start';

//ensuring user doesn't enter an email that is already in use by another account.
$stmt = $conn->prepare("SELECT * FROM Users WHERE userID != :userID AND email = :email");
$stmt->bindParam(':userID', $_SESSION['userID']);
$stmt->bindParam(':email', $_POST['email']);
$stmt->execute();
//checking if email has already been input into database
if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
    $_SESSION['Message1']="<p style = 'color:red;'>Email is Already in Use.</p>";
    header('Location: ../accountPage.php?modal=editDetails');
    echo'email validation';
    exit();
}

//now ensuring user doesn't enter a username that is already in use by another account.
$stmt = $conn->prepare("SELECT * FROM Users WHERE userID != :userID AND username = :username");
$stmt->bindParam(':userID', $_SESSION['userID']);
$stmt->bindParam(':username', $_POST['username']);
$stmt->execute();
//checking if username has already been input into database
if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
    $_SESSION['Message1']="<p style = 'color:red;'>Username is Already in Use.</p>";
    header('Location: ../accountPage.php?modal=editDetails');
    echo'username validation';
    exit();
}


//checking that currentPassword has actually been inputted into the form 
if (!empty($_POST['newPassword']) && empty($_POST['currentPassword'])){
    $_SESSION['Message1']="<p style = 'color:red;'>To enter a new password, you must enter your current password.</p>";
    header('Location: ../accountPage.php?modal=editDetails');
    echo'password input validation';
    exit();
}

//validating the email format
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $_SESSION['Message1'] = "<p style = 'color:red;'>Invalid Email Format</p>";
    header('Location: ../accountPage.php?modal=editDetails');
    echo'email format validation';
    exit();
}

//rest of validation:





try{
    //updating details
    echo'<br>start of try';
    $stmt = $conn->prepare("UPDATE Users
    SET username=:username, forename=:forename, surname=:surname, email=:email, telephone=:telephone, postcode=:postcode, addressLine=:addressLine
    WHERE userID=:userID");
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->bindParam(':forename', $_POST['forename']);
    $stmt->bindParam(':surname', $_POST['surname']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':telephone', $_POST['telephone']);
    $stmt->bindParam(':postcode', $_POST['postcode']);
    $stmt->bindParam(':addressLine', $_POST['addressLine']);
    $stmt->bindParam(':userID', $_SESSION['userID']);
    $stmt->execute();




    //now validating the password section
    //here i am checking if the password section has been left blank or not.


    if(!empty($_POST['newPassword'])){
        //now getting current password from database
        echo'start of newPassword check';
        $stmt = $conn->prepare("SELECT * FROM Users WHERE userID = :userID");
        $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT); //ensuring userID is an integer
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        //verifying the password
        $hashed = $result['password'];
        $attempt=$_POST['currentPassword'];
        var_dump($hashed);
        echo('<br>');
        var_dump($attempt);
        if(password_verify($attempt,$hashed)){
            $stmt=$conn->prepare("UPDATE Users
            SET password=:newPassword
            WHERE userID=:userID");
            echo'<br>password has been verified';

            $newHashed=password_hash($_POST['newPassword'],PASSWORD_DEFAULT);
            $stmt->bindParam(':newPassword',$newHashed);
            //important line!!
            $stmt->bindParam(':userID',$_SESSION['userID']); //binding the password to the userID of the user logged in (their session)
            $stmt->execute();
    }
    //else if they don't match send a message to user
        else{
            $_SESSION['Message1']="<p style = 'color:red;'>Current Password is Incorrect.</p>";
            header('Location: ../accountPage.php?modal=editDetails');
            echo'password is incorrect';
            exit();
        }
    }
    echo'<br>password verification doesnt work at all';
    $conn=null;
    header('Location: accountPage.php');

}
catch (PDOException $e) {
    $conn->rollBack(); //going back if there is an error during transaction
    die('Error: ' . $e->getMessage());
}

?>