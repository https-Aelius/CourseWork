<?php
array_map('htmlspecialchars', $_POST);
include_once('connection.php');
session_start();
print_r($_POST);

$stmt=$conn->prepare('INSERT INTO
Products (itemID, name, description, productImage, dimensionImage, soldOut, price, quant, type, itemSold)
VALUES (null,:name,:description,:productImage,dimensionImage,0,:price,:quant,:type,0)');

$stmt->bindParam(':name', $_POST['title']);//finish the html first
//for file validation


$target_dir='Applications/XAMPP/htdocs/Coursework4School/Images/';


//for the first image file (image of the product)
$filename1='image_of_product_test';
$target_file1= $target_dir . $filename1.'.'.strtolower(pathinfo($_FILES['fileToUpload1']['name'], PATHINFO_EXTENSION));
$uploadTrue1=1;
$imageFileType1=strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
//now for the second image files (images of the dimensions of the product)
$filename2='image_of_product_dimension';
$target_file2=$target_dir.$filename2.'.'.strtolower(pathinfo($_FILES['fileToUpload2']['name'], PATHINFO_EXTENSION));
$uploadTrue2=1;
$imageFileType2=strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

//checking if file input is image or not
if(isset($_POST['submit'])){
    $check1 = getimagesize($_FILES['fileToUpload1']['tmp_name']);
    $check2=getimagesize($_FILES['fileToUpload2']['tmp_name']);
    if($check1 == true){
        $_SESSION['Message1']="<p style = 'color:red;'>This file is not an image</p>";
        //header('Location: addProductPage.php');
        $uploadTrue1=0;
        exit();
    }
    if($check2 == true){
        $_SESSION['Message2']="<p style = 'color:red;'>This file is not an image</p>";
        //header('Location: addProductPage.php');
        $uploadTrue2=0;
        exit();
    }

}
//checking if image of product exists already or not
if(file_exists($target_file1)){
    $_SESSION['Message3']="<p style = 'color:red;'>Image is already in Database</p>";
    //header('Location: addProductPage.php');
    $uploadTrue1=0;
    exit();
}
if(file_exists($target_file2)){
    $_SESSION['Message4']="<p style = 'color:red;'>Image is already in Database</p>";
    //header('Location: addProductPage.php');
    $uploadTrue2=0;
    exit();
}

//checking the file sizes
if($_FILES['fileToUpload1']['size']>500000){
    $_SESSION['Message5']="<p style = 'color:red;'>File size is too large</p>";
    //header('Location: addProductPage.php');
    $uploadTrue1=0;
    exit();
}

if($_FILES['fileToUpload2']['size']>500000){
    $_SESSION['Message6']="<p style = 'color:red;'>File size is too large</p>";
    //header('Location: addProductPage.php');
    $uploadTrue2=0;
    exit();
}

//checking the formatting of the image
if($imageFileType1 != 'jpg' && $imageFileType1 !='png' && $imageFileType1!='jpeg'){
    $_SESSION['Message7']="<p style = 'color:red;'>Only accept .jpg, .png or .jpeg</p>";
    //header('Location: addProductPage.php');
    $uploadTrue1=0;
    exit();
}
if($imageFileType2 != 'jpg' && $imageFileType2 !='png' && $imageFileType2!='jpeg'){
    $_SESSION['Message8']="<p style = 'color:red;'>Only accept .jpg, .png or .jpeg</p>";
    //header('Location: addProductPage.php');
    $uploadTrue2=0;
    exit();
}

?>