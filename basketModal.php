<?php
session_start();
include_once('connection.php');
if ($_SESSION['role'] != 1){
    header('Location: login.php');
}
/*
$stmt = $conn->prepare("SELECT * FROM Basket WHERE userID=:userID");
$stmt->bindParam(':userID', $_SESSION['userID']);
$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $itemID = $row['itemID'];
    $productQuantity = $row['quantBasket'];
    $stmt=$conn->prepare("SELECT * FROM Products WHERE itemID=:itemID");
    $stmt->bindParam(':itemID', $itemID);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $productImage=$row['productImage'];
        $name=$row['name'];
        $price=$row['price'];
    }
}*/

//this isn't going to work, I need to put the second SQL into the SQL's first while loop and then echo the productItem Container fluid into the modal as well. 
?>


<div class="modal fade" id='basketModal' role='dialog'>
    <div class="modal-dialog modal-lg">
        <!--Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type = 'button' class='close' data-dismiss='modal'>&times;</button>
                <h4 class = 'modal-title'><?php echo $_SESSION['username'];?>'s Basket</h4>
            </div>
            <div class="modal-body">
                <!--Starting PHP-->

    <?php
    if (!isset($_SESSION['userID'])) {
        echo "<h2>Please log in to view your basket.</h2>";
        exit;
    }
    
    try{
        //fetching the basket details based on the userID
        $stmt = $conn->prepare("SELECT * FROM Basket WHERE userID=:userID");

        $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);

        $stmt->execute();
        //loop through the basket database based of the userID

        while($basketRow = $stmt->fetch(PDO::FETCH_ASSOC)){
            $itemID = $basketRow['itemID'];
            $productQuantity = $basketRow['quantBasket'];
            $basketID = $basketRow['basketID'];

            $count+=1;


            //now fetching the product details based on the itemID from the basket
            $stmt2=$conn->prepare("SELECT * FROM Products WHERE itemID=:itemID");
            $stmt2->bindParam(':itemID', $itemID, PDO::PARAM_INT);
            $stmt2->execute();
            //now looping through products database based on the itemID from the basket
            while($productRow = $stmt2->fetch(PDO::FETCH_ASSOC)){
                $productImage=$productRow['productImage'];
                $name=$productRow['name'];
                $price= number_format($productRow['price'],2);
                echo"
                <div class='productItem container-fluid' style='width:80%;'>
                    <div class='row'>
                        <div class='col-6 col-md-3'>
                            <div class='row'>
                                <label>
                                        Product Name:
                                </label>
                            </div>
                            $name
                        </div>
                        <div class='col-6 col-md-3'>
                            <div class='row'>
                                <label style='margin-top:10px;'>
                                    Product Images:
                                </label>
                            </div>
                            <img src='Images/$productImage' alt='Product Image' style='max-height:20vh; max-width:50vh;'>
                        </div>
                        <div class='col-6 col-md-3'>
                            <label>
                                Price:
                            </label>
                            $price
                            
                        </div>
                        <div class='col-6 col-md-3'>
                            <label>
                                Quantity
                            </label>
                            $productQuantity

                            <a type ='button' href='cartRemoveFunction.php?basketID=$basketID' id = '' class='btn btn-sixth' style='margin-top:17vh;'>Remove Item</a>
                    </div>
                    </div>
                </div>
                ";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }


        ?>
                <!--Ending PHP-->
            </div>
            
            <div class="modal-footer">
            <?php
            if ($count > 0){
                $idPass = $_SESSION['userID'];
                echo"
            <a type='button' href='checkOutPage.php?userID=$idPass' class='btn btn-sixth'>Checkout</a>
            ";
            }
            else{
                echo"<h4>Your basket is empty.</h4>";
            }
            ?>
            </div>
        </div>
    </div>
</div>


    <!--for testing purposes-->
    <?php
    /*
    if (!isset($_SESSION['userID'])) {
        echo "<h2>Please log in to view your basket.</h2>";
        exit;
    }

    try{
        //fetching the basket details based on the userID
        $stmt = $conn->prepare("SELECT * FROM Basket WHERE userID=:userID");

        $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);

        $stmt->execute();
        //loop through the basket database based of the userID

        while($basketRow = $stmt->fetch(PDO::FETCH_ASSOC)){
            $itemID = $basketRow['itemID'];
            $productQuantity = $basketRow['quantBasket'];
            $basketID = $basketRow['basketID'];


            //now fetching the product details based on the itemID from the basket
            $stmt2=$conn->prepare("SELECT * FROM Products WHERE itemID=:itemID");
            $stmt2->bindParam(':itemID', $itemID, PDO::PARAM_INT);
            $stmt2->execute();
            //now looping through products database based on the itemID from the basket
            while($productRow = $stmt2->fetch(PDO::FETCH_ASSOC)){
                $productImage=$productRow['productImage'];
                $name=$productRow['name'];
                $price= number_format($productRow['price'],2);
                echo"
                <div class='productItem container-fluid' style='width:80%;'>
                    <div class='row'>
                        <div class='col-6 col-md-3'>
                            <div class='row'>
                                <label>
                                        Product Name:
                                </label>
                            </div>
                            $name
                        </div>
                        <div class='col-6 col-md-3'>
                            <div class='row'>
                                <label style='margin-top:10px;'>
                                    Product Images:
                                </label>
                            </div>
                            <img src='Images/$productImage' alt='Product Image' style='max-height:20vh; max-width:50vh;'>
                        </div>
                        <div class='col-6 col-md-3'>
                            <label>
                                Price:
                            </label>
                            $price
                            
                        </div>
                        <div class='col-6 col-md-3'>
                            <label>
                                Quantity
                            </label>
                            $productQuantity

                            <a type ='button' href='cartRemoveFunction.php?basketID=$basketID' id = '' class='btn btn-sixth' style='margin-top:17vh;'>Remove Item</a>
                    </div>
                    </div>
                </div>
                ";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

        //this isn't going to work, I need to put the second SQL into the SQL's first while loop and then echo the productItem Container fluid into the modal as well. 
        */?>
    


