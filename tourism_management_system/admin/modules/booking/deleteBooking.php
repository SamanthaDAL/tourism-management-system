<?php
//include db config
include("../../../config/config.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $bookingID = intval($_GET['id']);
    // Delete the booking record
    $sql = "DELETE FROM booking WHERE bookingID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $bookingID);

    if (mysqli_stmt_execute($stmt)) {
        echo "booking Id $bookingID deleted successfully!";
        echo "<br><a href='" . ADMIN_BASE_URL . "modules/booking/bookingList.php'>Back to Admin Panel</a>";
} else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
