<!DOCTYPE html>
<html lang = "en">
    <head>
    <meta charset="UTF-8">
    <?php
        include_once("connection.php");
        $stmt = $conn->prepare("SELECT * FROM Products WHERE itemID = 23");
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $productImage=$row['productImage'];
            $dimensionImage=$row['dimensionImage'];
            $name=$row['name'];
            $itemID=$row['itemID'];
        }
    ?>
    </head>

        <body>
            <h1>Test Page</h1>
            <p>asdkljasjkfnkaljgnaslkf</p>
            <?php
            echo('<img src="' . $productImage . '" alt="Product Image">');
            
            ?>
            <img src="Images/<?php echo $productImage; ?>" alt="Product Image" style='max-height:50vh; max-width:50vh;'>
            <img src="Images/<?php echo $dimensionImage; ?>" alt="Dimension Image" style='max-height:50vh; max-width:50vh;'>
            <p><?php echo $name; ?></p>
            <p><?php echo $itemID; ?></p>
        </body>
    
</html>