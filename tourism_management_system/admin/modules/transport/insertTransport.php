<?php
//include db config
include("../../../config/config.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transportName = $_POST['transportName'];
    $typeID = $_POST['typeID'];
    $transportPrice = $_POST['transportPrice'];

    // Handle image upload
    $target_dir = "../../../uploads/";
    $target_path = "uploads/";
    $target_file = $target_dir . basename($_FILES["transportImg"]["name"]);
    $target_fileDB = $target_path . basename($_FILES["transportImg"]["name"]);
    $upload_ok = 1;
   
    // Check if image file is an actual image
    $check = getimagesize($_FILES["transportImg"]["tmp_name"]);
    if ($check !== false) {
        $upload_ok = 1;
    } else {
        echo "File is not an image.";
        $upload_ok = 0;
    }

    // Move uploaded file to target directory
    if ($upload_ok && move_uploaded_file($_FILES["transportImg"]["tmp_name"], $target_file)) {
     
        $sql = "INSERT INTO transport (transportName, typeID, transportPrice, transportImg)
        VALUES ('$transportName', '$typeID' , '$transportPrice', '$target_fileDB')";
    
        if (mysqli_query($conn, $sql)) {
        echo "<br>New transport record created successfully";
        echo "<br><a href='" . ADMIN_BASE_URL . "modules/transport/transportList.php'>Back to Admin Panel</a>";
        } else {
        echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
mysqli_close($conn);
?>

