<?php
//include db config
include("../../../config/config.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $typeName = $_POST['typeName'];
    $typeDescription = $_POST['typeDescription'];

        $sql = "INSERT INTO cartype (typeName, typeDescription)
        VALUES ('$typeName', '$typeDescription')";
    
        if (mysqli_query($conn, $sql)) {
        echo "<br>New type record created successfully";
        echo "<br><a href='" . ADMIN_BASE_URL . "modules/transport/typeList.php'>Back to Admin Panel</a>";
        } else {
        echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        } else {
        echo "Sorry, there was an error uploading your file.";
    
}
mysqli_close($conn);
?>

