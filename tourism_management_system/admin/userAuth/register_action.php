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
    $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    $userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']);
    $userContact = mysqli_real_escape_string($conn, $_POST['userContact']);
    $userPassword = mysqli_real_escape_string($conn, $_POST['userPassword']);
    $confirmPwd = mysqli_real_escape_string($conn, $_POST['confirmPwd']);

    // Validate passwords match
    if ($userPassword !== $confirmPwd) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
        echo "<script>window.location.href = 'register.php';</script>";
        exit;
    }

    // Hash the password for security
    $hashedPwd = password_hash($userPassword, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM user WHERE userEmail = '$userEmail'";
    $result = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already exists. Please use a different email.');</script>";
        echo "<script>window.location.href = 'register.php';</script>";
        exit;
    }

    // Insert the new user into the database
    $insertQuery = "INSERT INTO user (userName, userEmail, userContact, userPassword, userRole) VALUES ('$userName', '$userEmail', '$userContact', '$hashedPwd', 1)";

    if (mysqli_query($conn, $insertQuery)) {
        echo "<script>alert('Registration successful!');</script>";
        echo "<script>window.location.href = '../index.php';</script>";
    } else {
        echo "<script>alert('Error: Could not register user.');</script>";
        echo "<script>window.location.href = 'register.php';</script>";
    }
}
mysqli_close($conn);
?>
</body>
</html>