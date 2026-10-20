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
        <h2>User Registration</h2>
        <form action="register_action.php" method="post">
            <label for="userName">Username:</label><br>
            <input type="text" id="userName" name="userName" required><br><br>
            
            <label for="userEmail">Email:</label><br>
            <input type="email" id="userEmail" name="userEmail" required><br><br>
            
            <label for="userContact">Contact:</label><br>
            <input type="text" id="userContact" name="userContact" required><br><br>
            
            <label for="userPassword">Password:</label><br>
            <input type="password" id="userPassword" name="userPassword" required><br><br>
            
            <label for="confirmPwd">Confirm Password:</label><br>
            <input type="password" id="confirmPwd" name="confirmPwd" required><br><br>
            
            <input type="submit" value="Register">
            <input type="reset" value="Reset">
        </form>
    </div>
</body>

</html>
