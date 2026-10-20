<?php
//include db config
include("../../../config/config.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $transportID = intval($_GET['id']);
    // Delete the transport record
    $sql = "DELETE FROM transport WHERE transportID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $transportID);

    if (mysqli_stmt_execute($stmt)) {
        echo "transport Id $transportID deleted successfully!";
        echo "<br><a href='" . ADMIN_BASE_URL . "modules/transport/transportList.php'>Back to Admin Panel</a>";
} else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
