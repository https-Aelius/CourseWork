
<?php
$servername = "localhost";
$username= "root";
//$password = "123";
$dbname = "waterbottleshop";
try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username,$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "connected successfully";
        //test + remember to comment out
}
catch(PDOException $e) {
    echo "connection failed: " . $e->getMessage();
    //test
}
?>
