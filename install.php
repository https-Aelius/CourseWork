
<?php
include_once("connection.php");
//User (logged on) Table
$stmt = $conn->prepare("
    DROP TABLE IF EXISTS Users; 
    CREATE TABLE Users (
            userID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(300) NOT NULL,
            forename TINYTEXT NOT NULL,
            surname TINYTEXT NOT NULL,
            email VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(300) NOT NULL,
            role TINYINT(1) DEFAULT 1,
            telephone VARCHAR(11) NOT NULL,
            postcode VARCHAR(7) NOT NULL,
            addressLine VARCHAR(20) NOT NULL,
            cardNo VARCHAR(16) NOT NULL,
            cardName VARCHAR(60) NOT NULL,
            cardExpiry CHAR(5) NOT NULL,
            cardCVC CHAR(4) NOT NULL
    )    
");
$stmt->execute();
$stmt->closeCursor();
echo ("<br>Users Table is Created");

//products table
$stmt=$conn->prepare("
        DROP TABLE IF EXISTS Products;
        CREATE TABLE Products  (
            itemID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            description VARCHAR(1000) NOT NULL,
            productImage VARCHAR(100) NOT NULL,
            dimensionImage VARCHAR(100) NOT NULL,
            soldOut BOOL NOT NULL,
            price FLOAT(4,2) NOT NULL,
            quant VARCHAR(50) NOT NULL,
            type VARCHAR(50) NOT NULL,
            itemSold VARCHAR(50) NOT NULL            
        )
");
$stmt->execute();
$stmt->closeCursor();
echo("<br>Products Table is Created");
//basket table
$stmt=$conn->prepare("
        DROP TABLE IF EXISTS Basket;
        CREATE TABLE Basket (
            basketID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            orderDate DATETIME NOT NULL,
            itemID INT(6) NOT NULL,
            quantBasket INT(6) NOT NULL
        )
");
$stmt->execute();
$stmt->closeCursor();
echo("<br>Basket Table is created");
//order table
$stmt=$conn->prepare("
        DROP TABLE IF EXISTS Orders;
        CREATE TABLE Orders (
            deliveryID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            userID INT(6) NOT NULL,
            basketID INT(6) NOT NULL
        )
");
$stmt->execute();
$stmt->closeCursor();
echo("<br>Order table created");
//review table
$stmt=$conn->prepare("
        DROP TABLE IF EXISTS Reviews;
        CREATE TABLE Reviews (
            reviewID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            userID INT(6) NOT NULL,
            reviewContent VARCHAR(1000) NOT NULL,
            itemID INT(6) NOT NULL,
            ratingNumber CHAR(2) NOT NULL,
            dateReview DATETIME NOT NULL
        )
");
$stmt->execute();
$stmt->closeCursor();
echo("<br>Review table completed");
//types of product table
/* $stmt=$conn->prepare("
        DROP TABLE IF EXISTS Types;
        CREATE TABLE Types (
            type TINYTEXT NOT NULL
        )
");
$stmt->execute();
$stmt->closeCursor();
echo("<br>Types table completed"); */
?>
