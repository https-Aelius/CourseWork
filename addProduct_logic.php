<?php
array_map('htmlspecialchars', $_POST);
include_once('connection.php');
session_start();


print_r($_POST);

$stmt=$conn->prepare('INSERT INTO
    Products (itemID, name, description, productImage, dimensionImage, soldOut, price, quant, productType, itemSold)
    VALUES (null,:name,:description,null,null,0,:price,:quant,:productType,0)');
    echo'preparing statement';
    $stmt->bindParam(':name', $_POST['title']);
    $stmt->bindParam(':description', $_POST['description']);
    $stmt->bindParam(':price', $_POST['price']);
    $stmt->bindParam(':quant', $_POST['quantity']);
    $stmt->bindParam(':productType', $_POST['productType']);
    try{
        $stmt->execute();
        echo'<br>finished insertion';
    } catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
//for file validation

echo'<br>start of file upload';
$lastID = $conn->lastInsertID();
$filename1= $lastID . '_product';
$filename2= $lastID . '_dimension';

$target_dir='/Applications/XAMPP/xamppfiles/htdocs/Coursework4School/Images/';


//for the first image file (image of the product)

$file1_extension = strtolower(pathinfo($_FILES['fileToUpload1']['name'], PATHINFO_EXTENSION));
$file2_extension = strtolower(pathinfo($_FILES['fileToUpload2']['name'], PATHINFO_EXTENSION));

echo'<br>this is for file extension check';
echo'<br>file 1 extension: ' . $file1_extension;
echo'<br>file 2 extension: ' . $file2_extension;

$target_file1 = $target_dir . $filename1 . '.' . $file1_extension;
$target_file2 = $target_dir . $filename2 . '.' . $file2_extension;

$imageFileType1 = $file1_extension;
$imageFileType2 = $file2_extension;


// Debug file upload information
echo '<br>=== FILE UPLOAD DEBUG ===';
echo '<br>File 1 error code: ' . $_FILES['fileToUpload1']['error'];
echo '<br>File 2 error code: ' . $_FILES['fileToUpload2']['error'];
echo '<br>File 1 name: ' . $_FILES['fileToUpload1']['name'];
echo '<br>File 2 name: ' . $_FILES['fileToUpload2']['name'];
echo '<br>File 1 size: ' . $_FILES['fileToUpload1']['size'];
echo '<br>File 2 size: ' . $_FILES['fileToUpload2']['size'];
echo '<br>Target directory: ' . $target_dir;
echo '<br>Directory exists: ' . (is_dir($target_dir) ? 'YES' : 'NO');
echo '<br>Directory writable: ' . (is_writable($target_dir) ? 'YES' : 'NO');
echo '<br>Target file 1: ' . $target_file1;
echo '<br>Target file 2: ' . $target_file2;

// Check for upload errors
if ($_FILES['fileToUpload1']['error'] !== UPLOAD_ERR_OK || $_FILES['fileToUpload2']['error'] !== UPLOAD_ERR_OK) {
    echo '<br>=== UPLOAD ERROR DETAILS ===';
    echo '<br>File 1 error: ' . $_FILES['fileToUpload1']['error'] . ' - ' . getUploadErrorMessage($_FILES['fileToUpload1']['error']);
    echo '<br>File 2 error: ' . $_FILES['fileToUpload2']['error'] . ' - ' . getUploadErrorMessage($_FILES['fileToUpload2']['error']);
    $_SESSION['Message1'] = "<p style='color:red;'>File upload error occurred.</p>";
    header('Location: addProductPage.php');
    exit();
    echo'<br>file upload error';
}

// Function to get upload error messages
function getUploadErrorMessage($errorCode) {
    switch ($errorCode) {
        case UPLOAD_ERR_OK:
            return 'No error';
        case UPLOAD_ERR_INI_SIZE:
            return 'File exceeds upload_max_filesize directive';
        case UPLOAD_ERR_FORM_SIZE:
            return 'File exceeds MAX_FILE_SIZE directive';
        case UPLOAD_ERR_PARTIAL:
            return 'File was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
}

// Check file sizes (500KB limit)
if ($_FILES['fileToUpload1']['size'] > 5000000 || $_FILES['fileToUpload2']['size'] > 5000000) {
    $_SESSION['Message3'] = "<p style='color:red;'>File size is too large. Maximum size is 5000KB (5MB).</p>";
    header('Location: addProductPage.php');
    exit();
    echo'file size error';
}


// Upload files first
echo '<br>=== STARTING FILE UPLOAD ===';
echo '<br>Attempting to upload file 1 to: ' . $target_file1;
echo '<br>Attempting to upload file 2 to: ' . $target_file2;

// Create directory if it doesn't exist
if (!is_dir($target_dir)) {
    echo '<br>Creating directory: ' . $target_dir;
    mkdir($target_dir, 0755, true);
}

if (move_uploaded_file($_FILES['fileToUpload1']['tmp_name'], $target_file1) && move_uploaded_file($_FILES['fileToUpload2']['tmp_name'], $target_file2)) {
    echo 'Files uploaded successfully!';
    
    // Update database with image filenames after successful upload
    $stmt = $conn->prepare("UPDATE Products SET productImage=:image1, dimensionImage=:image2 WHERE itemID=:itemID");
    $full_filename1 = $filename1 . '.' . $file1_extension;
    $full_filename2 = $filename2 . '.' . $file2_extension;
    $stmt->bindParam(':image1', $full_filename1);
    $stmt->bindParam(':image2', $full_filename2);
    $stmt->bindParam(':itemID', $lastID);
    
    try {
        $stmt->execute();
        echo '<br>Database updated with image filenames';
        
        $_SESSION['Message5'] = "<p style='color:green; font-size:10px;'>Product added successfully! File has been uploaded.</p>";
        header('Location: addProductPage.php');
        exit();
        echo'success';
    } catch(PDOException $e) {
        // If database update fails, remove the uploaded files
        unlink($target_file1);
        unlink($target_file2);
        $_SESSION['Message7'] = "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
        header('Location: addProductPage.php');
        exit();
        echo'database error';
    }
} else {
    $_SESSION['Message8'] = "<p style='color:red;'>There was an error uploading your files.</p>";
    header('Location: addProductPage.php');
    exit();
    echo'file upload error';
}

?>

