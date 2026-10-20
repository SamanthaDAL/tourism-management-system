<?php
//include db config
include("../../../config/config.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $tourID = intval($_GET['id']);
    // Delete the tour record
    $sql = "DELETE FROM tour WHERE tourID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $tourID);

    if (mysqli_stmt_execute($stmt)) {
        echo "tour Id $tourID deleted successfully!";
        echo "<br><a href='" . ADMIN_BASE_URL . "modules/tour/tourList.php'>Back to Admin Panel</a>";
} else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
