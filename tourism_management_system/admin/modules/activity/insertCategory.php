<?php
//include db config
include("../../../config/config.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST['categoryName'];
    $categoryDescription = $_POST['categoryDescription'];

        $sql = "INSERT INTO category (categoryName, categoryDescription)
        VALUES ('$categoryName', '$categoryDescription')";
    
        if (mysqli_query($conn, $sql)) {
        echo "<br>New category record created successfully";
        echo "<br><a href='" . ADMIN_BASE_URL . "modules/activity/categoryList.php'>Back to Admin Panel</a>";
        } else {
        echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        } else {
        echo "Sorry, there was an error uploading your file.";
    
}
mysqli_close($conn);
?>

