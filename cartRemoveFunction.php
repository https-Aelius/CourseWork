<?php
session_start();
include_once('connection.php');

if (isset($_GET['basketID'])) {
    $basketID = $_GET['basketID'];
    echo '<br>removing product with basketID:';
    echo $basketID;
    $stmt = $conn->prepare("DELETE FROM Basket WHERE basketID = :basketID");
    $stmt->bindParam(':basketID', $basketID);
    $stmt->execute();
}
if (isset($_SESSION['last_page'])) {
    $redirect = $_SESSION['last_page'];
    unset($_SESSION['last_page']);
    header("Location: $redirect");

} else {
    header("Location: mainPage.php"); // fallback if last_page is not set
}
exit();
?>