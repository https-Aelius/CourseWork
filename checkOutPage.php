<?php
session_start();
include_once('connection.php');
if ($_SESSION['role'] < 1){
    header('Location: login.php');
}

?>


<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BottleLeak & Co.</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>


    <!-- Initialize the JS-SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=test&buyer-country=US&currency=USD&components=buttons&disable-funding=venmo,paylater,card" 
    data-sdk-integration-source="developer-studio"></script>
    <script src="app.js"></script>

</head>
<body>

    <!--Body of the website-->
    <main>
    <div class="container d-flex justify-content-center mt-5 mb-5">

        <div class="g-3">
        <a href='adminPage.php' class='btn btn-sixth' style='color:#fff; margin-right:50px; width:70%;'><- Back</a>
        </div>    

        <div class="row g-3">

        <div class="col-md-6">  
            
            <span>Payment Method</span>
            <div class="card">

            <div class="accordion" id="accordionExample">
                
                <div class="card">
                <div class="card-header p-0" id="headingTwo">
                    <h2 class="mb-0">
                    <!--below contains the id "paypal-button-container" which refers back to app.js-->
                    <div class="text-left collapsed p-3 rounded-0 border-bottom-custom" id="paypal-button-container" >
                        <div class="d-flex align-items-center justify-content-between">
                            <span style='margin-right:19vh; font-size:18px;'>Paypal</span>

                        </div>
                    </div>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                    <input type="text" class="form-control" placeholder="Paypal email">
                    </div>
                </div>
                </div>

                <div class="card">
                <div class="card-header p-0">
                    <h2 class="mb-0">
                    <button class="btn btn-light btn-block text-left p-3 rounded-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <div class="d-flex align-items-center justify-content-between">

                        <span style='margin-right:19vh;'>Credit card</span>

                            <img src="ma_symbol_opt_73_3x.png" width="30" style='margin-right:1vh;'>
                            <img src="visa-brandmark-blue-1960x622.webp" width="30">


                        
                        </div>
                    </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body payment-card-body">
                    
                    <span class="font-weight-normal card-text">Card Number</span>
                    <div class="input">

                        <i class="fa fa-credit-card"></i>
                        <input type="text" class="form-control" placeholder="0000 0000 0000 0000" value=''>
                        
                    </div> 

                    <div class="row mt-3 mb-3">

                        <div class="col-md-6">

                        <span class="font-weight-normal card-text">Expiry Date</span>
                        <div class="input">

                            <i class="fa fa-calendar"></i>
                            <input type="text" class="form-control" placeholder="MM/YY">
                            
                        </div> 
                        
                        </div>


                        <div class="col-md-6">

                        <span class="font-weight-normal card-text">CVC/CVV</span>
                        <div class="input">

                            <i class="fa fa-lock"></i>
                            <input type="text" class="form-control" placeholder="000">
                            
                        </div> 
                        
                        </div>
                        

                    </div>

                    <span class="text-muted certificate-text"><i class="fa fa-lock"></i> Your transaction is secured with ssl certificate</span>
                    
                    </div>
                </div>
                </div>
                
            </div>
            
            </div>

        </div>

        <div class="col-md-6">
            <span>Products</span>

            <div class="card">

                <div class="d-flex justify-content-between p-3">

                

                <div class="mt-1">
                    <?php
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
                        //keeping count for the price the user has to pay
                        $total = $total + $price;
                        echo"
                        <div class='checkoutItem container-fluid' style='width:80%;'>
                            <div class='row g-3 align-items-start'>

                                <div class='row'>
                                    <label class='form-label fw-semibold' style='margin-bottom:0;'>
                                            Product Name:
                                    </label>
                                </div>
                                $name
                                <div class='row'>
                                    <div class='col-6 col-md-3'>
                                        <label class='form-label fw-semibold'>
                                            Price:
                                        </label>
                                        $price
                                        
                                    </div>
                                    <div class='col-6 col-md-3'>
                                        <label class='form-label fw-semibold'>
                                            Quantity
                                        </label>
                                        $productQuantity
                                </div>
                            </div>
                            </div>
                        </div>
                        ";
                    }
                } ?>
                </div>
                
                </div>

                <hr class="mt-0 line">

                <div class="p-3">

                <div class="d-flex justify-content-between mb-2">

                    <span>Total:</span>
                    
                    <span>$<?php echo (number_format($total,2)); 
                    //above is price before tax
                    ?></span>
                    
                </div>

                <div class="d-flex justify-content-between">

                    <span>Sales tax <i class="fa fa-clock-o"></i></span>
                    <span>-10.25%</span>
                    
                </div>
                

                </div>

                <hr class="mt-0 line">


                <div class="p-3 d-flex justify-content-between">

                <div class="d-flex flex-column">

                    <span>To pay:</span>
                    <small></small>
                    
                </div>
                <span>$<?php
                $toPay = $total*1.1025;
                //price after tax
                echo (number_format($toPay,2));
                ?></span>

                

                </div>


                <div class="p-3">

                <button type = 'submit' class = 'btn-seventh' style='margin-left:80%; font-size:18px; width:20%;'>Buy</button>
            <div class="text-center">

            </div>
                
                </div>



                
            </div>
        </div>
        
        </div>


        </div>
    </main>

    <!--Bottom of navbar-->
    <div class="navbar-bottom">
    </div>
</body>
</html>
