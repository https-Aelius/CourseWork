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
header('Location: mainPage.php');
?>