<?php
session_start();
if(isset($_SESSION['userID'])){
    unset($_SESSION['userID']);
    unset($_SESSION['role']);
}
header("Location: mainPage.php")
?>