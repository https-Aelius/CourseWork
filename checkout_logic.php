<?php
session_start();
include_once("connection.php"); 

require __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$stripe_secret_key=$_ENV['STRIPE_SECRET_KEY']; //put in private API key here

\Stripe\Stripe::setApiKey($stripe_secret_key);

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/Coursework4School/addOrder_logic.php", 
    "cancel_url" => "http://localhost/Coursework4School/errorPage.php",
    "line_items" => [
        [
            "quantity" => "1", //only need 1 quantity since total has already been calculated
            "price_data" => [
                //use lower case for currency code
                "currency" => "usd", //company is based in Chicago (specified through ISO code)
                //unit amount is in cents
                "unit_amount" => $_SESSION["toPayCents"],
                "product_data" => [
                    "name" => "HydraPeak Products"
                ]

                
            ]
        ]
    ]
]);
http_response_code(303);
header("location: ". $checkout_session->url); 



?>