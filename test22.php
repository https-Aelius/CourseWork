<?php

include_once('connection.php');

print_r($_POST);
if(isset($_POST['search'])){
    $search="%" . $_POST['search'] . "%";
    echo($search);

    $stmt=$conn->prepare("SELECT * FROM Products WHERE name LIKE :search");
    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
    $stmt->execute();
    if($stmt->rowCount()>0){

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $productImage=$row['productImage'];
            $dimensionImage=$row['dimensionImage'];
            $name=$row['name'];
            $itemID=$row['itemID'];
            $description=$row['description'];
            $price=$row['price'];
            $quant=$row['quant'];
            $productType=$row['productType'];
            $itemSold=$row['itemSold'];
            echo "
        
            <div class='productItem container-fluid' style='width:90%;'>
        <div class='row'>
            <div class='col-6' style=''>
                <label>
                    itemID:
                </label>
                $itemID
            </div>
        </div>
        <div class='row'>
            <div class='col-6 col-md-3'>
                <label>
                    Product Name:
                </label>
                $name
            </div>
            <div class='col-6 col-md-3'>
                <div class='row'>
                    <label style='margin-top:10px;'>
                        Product Images:
                    </label>
                </div>
                <img src='Images/$productImage' alt='Product Image' style='max-height:20vh; max-width:50vh;'>
                <img src='Images/$dimensionImage' alt='Dimension Image' style='max-height:20vh; max-width:50vh;'>
            </div>
            <div class='col-6 col-md-3'>
                <label>
                    Product Type:
                </label>
                $productType
            </div>
            <div class='col-6 col-md-3'>
                <label>
                    Price:
                </label>
                $price
            </div>
        </div>
        <div class='row'>
            <div class='col-6 col-md-3'>
                <label>
                    Description:
                </label>
                <p>$description</p>
            </div>
            <div class='col-6 col-md-3'></div>
            <div class='col-6 col-md-3'>
                <label>
                    Quantity:
                </label>
                $quant
            </div>
            <div class='col-6 col-md-3'>
                <label>
                    Number Sold:
                </label>
                $itemSold
            </div>
            <button type='button' 
                    class='btn btn-sixth editBtn' 
                    data-toggle='modal' 
                    data-target='#myModal'
                    data-itemid='$itemID'
                    data-name='$name'
                    data-description='$description'
                    data-price='$price'
                    data-quant='$quant'
                    data-itemSold='$itemSold'
                    data-productType='$productType'
                    data-productImage='$productImage'
                    data-dimensionImage='$dimensionImage'
                    style='margin-left:90%; font-size:18px;'>
                Edit
            </button>
        </div>
    </div>

            ";      }

    } else{
        echo"<p style='color:red; font-size:20px; margin-left:10vh;'>No products found matching your search.</p>";
    }

}
?>


