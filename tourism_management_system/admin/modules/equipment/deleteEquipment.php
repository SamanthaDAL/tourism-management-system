<?php
//include db config
include("../../../config/config.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $equipmentID = intval($_GET['id']);
    // Delete the equipment record
    $sql = "DELETE FROM equipment WHERE equipmentID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $equipmentID);

    if (mysqli_stmt_execute($stmt)) {
        echo "equipment Id $equipmentID deleted successfully!";
        echo "<br><a href='" . ADMIN_BASE_URL . "modules/equipment/equipmentList.php'>Back to Admin Panel</a>";
} else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
