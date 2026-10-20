<?php
//include db config
include("../../../config/config.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $activityID = intval($_GET['id']);
    // Delete the activity record
    $sql = "DELETE FROM activity WHERE activityID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $activityID);

    if (mysqli_stmt_execute($stmt)) {
        echo "activity Id $activityID deleted successfully!";
        echo "<br><a href='" . ADMIN_BASE_URL . "modules/acrivity/activityList.php'>Back to Admin Panel</a>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
