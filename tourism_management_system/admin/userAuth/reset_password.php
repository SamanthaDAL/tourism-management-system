<?php
// Include database configuration
include('C:/xampp/htdocs/tourism_management_system/config/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Registration</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/newstyle.css">
</head>

<body>
    <div class="container">
    <h3>Reset Password</h3>
            <form action="reset_password_action.php" method="post">
                <label for="userEmail">Enter your email address:</label><br>
                <input type="email" id="userEmail" name="userEmail" required><br><br>
    			<label for="newPassword">New Password:</label><br>
    			<input type="password" id="newPassword" name="newPassword" required><br><br>
    			<label for="confirmPassword">Confirm Password:</label><br>
    			<input type="password" id="confirmPassword" name="confirmPassword" required><br><br>
                <input type="submit" value="Reset Password">
            </form>
    </div>
</body>

</html>
