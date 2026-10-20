<?php
include('C:/xampp/htdocs/tourism_management_system/config/config.php');
?>
<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" type="text/css" href="newstyle.css">
</head>
<body>
<?php

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input
    $userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']);
    $userPassword = mysqli_real_escape_string($conn, $_POST['newPassword']);
    $confirmPwd = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    // Validate passwords match
    if ($userPassword !== $confirmPwd) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
        echo "<script>window.location.href = 'reset_password.php';</script>";
        exit;
    }

    // Check if the email exists in the database
    $checkEmailQuery = "SELECT * FROM user WHERE userEmail = '$userEmail'";
    $result = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('Email does not exist. Please try again.');</script>";
        echo "<script>window.location.href = 'reset_password.php';</script>";
        exit;
    }

    // Hash the password for security
    $hashedPwd = password_hash($userPassword, PASSWORD_DEFAULT);

    // Use prepared statements to avoid SQL injection
    $updateQuery = $conn->prepare("UPDATE user SET userPassword = ? WHERE userEmail = ?");
    $updateQuery->bind_param("ss", $hashedPwd, $userEmail);

    if ($updateQuery->execute()) {
        echo "<script>alert('Password reset successful!');</script>";
        echo "<script>window.location.href = '../index.php';</script>";
    } else {
        echo "<script>alert('Error: Could not reset password.');</script>";
        echo "<script>window.location.href = 'reset_password.php';</script>";
    }
}
mysqli_close($conn);
?>
</body>
</html>
