<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include_once('connection.php');

try{
    $conn-> beginTransaction();

    $sql = 'INSERT INTO Reviews (reviewID, userID, reviewContent, itemID, ratingNumber, dateReview) 
    VALUES (null, :userID, null, :itemID, :ratingNumber, CURRENT_TIMESTAMP)';
    $stmt = $conn->prepare($sql);
    $stmt -> bindParam(':userID', $_GET['userID']);
    $stmt -> bindParam(':itemID', $_GET['itemID']);
    $stmt -> bindParam(':ratingNumber', $_GET['ratingNumber']);
    $stmt->execute();

    echo"end of sql";

    
    //redirecting to the login page after successful signup containing the username
    $lastID = $conn->lastInsertID();
    if (isset($_GET['reviewContent']) && !empty($_GET['reviewContent'])) {
        $sql2 = 'UPDATE Reviews 
        SET reviewContent = :reviewContent 
        WHERE reviewID = :reviewID';
        $stmt2 = $conn->prepare($sql2);
        $stmt2 -> bindParam(':reviewContent', $_GET['reviewContent']);
        $stmt2 -> bindParam(':reviewID', $lastID);
        $stmt2->execute();
    }

    $conn->commit(); 

    //header('Location: .php');
} catch (PDOException $e) {
    $conn->rollBack(); //going back if there is an error during transaction
    die('Error: ' . $e->getMessage());
}


?>