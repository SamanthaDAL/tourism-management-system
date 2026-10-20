<?php
//include db config
include("../../../config/config.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $typeID = intval($_GET['id']);
    // Delete the type record
    $sql = "DELETE FROM cartype WHERE typeID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $typeID);

    if (mysqli_stmt_execute($stmt)) {
        echo "Type Id $typeID deleted successfully!";
        echo "<br><a href='" . ADMIN_BASE_URL . "modules/transport/typeList.php'>Back to Admin Panel</a>";
} else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
