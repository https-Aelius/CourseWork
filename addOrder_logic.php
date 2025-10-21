<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("connection.php");
session_start();

if (!isset($_SESSION['userID']) || !isset($_SESSION['toPay'])) {
    die('Error: session variables missing');
    exit();
}
echo ($_SESSION['userID']);
echo ($_SESSION['toPay']);


try{
    $conn->beginTransaction();
    $stmt = $conn->prepare("SELECT * FROM Basket WHERE userID=:userID");
    $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);
    $stmt->execute();
    echo"<br>start of first execute";



    //loop through the basket database based of the userID
    while($basketRow = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo'<br>while loop';
        //fetching the basketID from the basket table
        $basketID = $basketRow['basketID'];
        $itemID = $basketRow['itemID'];


        //now putting into database
        $sql = 'INSERT INTO Orders (deliveryID, userID, itemID, toPay, orderDate) 
        VALUES (null, :userID, :itemID, :toPay, CURRENT_TIMESTAMP)';
        $stmt2 = $conn->prepare($sql);
    
        $stmt2 -> bindParam(':userID', $_SESSION['userID']);
        $stmt2->bindParam(':itemID', $itemID); //using itemID from the basket table
        $stmt2->bindParam(':toPay', $_SESSION['toPay']);
    
        $stmt2 -> execute();
        echo"<br>end of sql";

        $sql2 = 'UPDATE Products SET quant = quant - 1 WHERE itemID = :itemID';
        $stmt3 = $conn->prepare($sql2);
        $stmt3->bindParam(':itemID', $itemID);
        $stmt3->execute();
        echo"<br>end of updating products";


    }
    $conn->commit();

} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    die('Error: ' . $e->getMessage());
}

//now clearing the basket table for the user
try{
    $conn->beginTransaction();
    $stmt3 = $conn->prepare("DELETE FROM Basket WHERE userID=:userID");
    $stmt3->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);
    $stmt3->execute();
    $conn->commit();
} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    die('Error: ' . $e->getMessage());
}
try{
    //now resetting the toPay session variable
    $_SESSION['toPay'] = 0;
    $_SESSION['toPayCents'] = 0;
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}


header("Location: accountPage.php");
?>