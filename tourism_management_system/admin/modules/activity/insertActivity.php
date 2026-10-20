<?php
//include db config
include("../../../config/config.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $activityName = $_POST['activityName'];
    $categoryID = $_POST['categoryID'];
    $activityPrice = $_POST['activityPrice'];
    $min_quantity = $_POST['min_quantity'];
    $max_quantity = $_POST['max_quantity'];

    // Handle image upload
    $target_dir = "../../../uploads/";
    $target_path = "uploads/";
    $target_file = $target_dir . basename($_FILES["activityImg"]["name"]);
    $target_fileDB = $target_path . basename($_FILES["activityImg"]["name"]);
    $upload_ok = 1;
   
    // Check if image file is an actual image
    $check = getimagesize($_FILES["activityImg"]["tmp_name"]);
    if ($check !== false) {
        $upload_ok = 1;
    } else {
        echo "File is not an image.";
        $upload_ok = 0;
    }

    // Move uploaded file to target directory
    if ($upload_ok && move_uploaded_file($_FILES["activityImg"]["tmp_name"], $target_file)) {
     
        $sql = "INSERT INTO activity (activityName, categoryID, activityPrice, min_quantity, max_quantity, activityImg)
        VALUES ('$activityName', '$categoryID' , '$activityPrice', '$min_quantity', '$max_quantity', '$target_fileDB')";
    
        if (mysqli_query($conn, $sql)) {
        echo "<br>New activity record created successfully";
        echo "<br><a href='" . ADMIN_BASE_URL . "modules/activity/activityList.php'>Back to Admin Panel</a>";
        } else {
        echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
mysqli_close($conn);
?>

