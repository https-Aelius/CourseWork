<?php
include_once("connection.php");

if (isset($_POST['itemID'])) {
    $itemID = $_POST['itemID'];
    //this will console log the itemID received from the AJAX request
    error_log("1st Received itemID: " . $_POST['itemID']);

    // fetching the data based on itemID
    $stmt = $conn->prepare("SELECT * FROM Products WHERE itemID = :itemID");
    $stmt->bindParam(':itemID', $itemID, PDO::PARAM_INT);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);

    error_log("2nd Received itemID: " . $_POST['itemID']);



    header('Content-Type: application/json'); // tell browser its in JSON 

    if ($row) {
        // Return row directly as JSON
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Product not found"]);
    }
} else {
    echo json_encode(["error" => "No itemID provided"]);
}



?>