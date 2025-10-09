<?php
include_once("connection.php");
session_start();

if(isset($_SESSION['userID'])){
    $userID= $_SESSION['userID'];
    echo"<br>UserID: ";
    echo $userID;
}
else{
    echo "Not logged in";
    exit;
}

if(isset($_GET['quantity'])){
    $productQuantity = $_GET['quantity'];
}
else{
    echo'quantity not passed successfully';
}

if (isset($_GET['itemID'])) {
    $itemID = $_GET['itemID'];

    echo"<br>";
    echo $itemID;

    $stmt = $conn->prepare("SELECT * FROM Products WHERE itemID = :itemID");
    $stmt->bindParam(':itemID', $itemID);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $name = $product['name'];
        $description = $product['description'];
        $price = number_format($product['price'], 2);
        $productImage = $product['productImage'];
        $description=$product['description'];
        $dimensionImage=$product['dimensionImage'];
        $quant=$product['quant'];
        $productType=$product['productType'];
        $itemSold=$product['itemSold'];
        $discount = $product['discountRate'];
        $actualPrice = $discount > 0 ? number_format($price - ($price * $discount / 100), 2) : $price;
    } else {
        echo "Product not found!";
        exit;
    }
} else {
    echo "Invalid product ID!";
    exit;
}

echo'<br>start of try statement';

try{
    $sql = 'INSERT INTO Basket (basketID, itemID, quantBasket, userID) 
    VALUES (null, :itemID, :quantBasket, :userID)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':itemID', $_GET['itemID']);
    $stmt->bindParam(':quantBasket', $productQuantity);
    $stmt->bindParam(':userID', $userID);
    
    $stmt->execute();
}
catch (PDOException $e) {
    $conn->rollBack(); //going back if there is an error during transaction
    die('Error: ' . $e->getMessage());
}


?>