<?php
//include db config
include("../../../config/config.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tourName = $_POST['tourName'];
    $tourContact = $_POST['tourContact'];
    $tourRating = $_POST['tourRating'];
    $tourPrice = $_POST['tourPrice'];

    // Handle image upload
    $target_dir = "../../../uploads/";
    $target_path = "uploads/";
    $target_file = $target_dir . basename($_FILES["tourImg"]["name"]);
    $target_fileDB = $target_path . basename($_FILES["tourImg"]["name"]);
    $upload_ok = 1;
   
    // Check if image file is an actual image
    $check = getimagesize($_FILES["tourImg"]["tmp_name"]);
    if ($check !== false) {
        $upload_ok = 1;
    } else {
        echo "File is not an image.";
        $upload_ok = 0;
    }

    // Move uploaded file to target directory
    if ($upload_ok && move_uploaded_file($_FILES["tourImg"]["tmp_name"], $target_file)) {
     
        $sql = "INSERT INTO tour (tourName, tourContact, tourRating, tourPrice, tourImg)
        VALUES ('$tourName', '$tourContact', '$tourRating', '$tourPrice', '$target_fileDB')";
    
        if (mysqli_query($conn, $sql)) {
        echo "<br>New tour record created successfully";
        echo "<br><a href='" . ADMIN_BASE_URL . "modules/tour/tourList.php'>Back to Admin Panel</a>";
        } else {
        echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
mysqli_close($conn);
?>

