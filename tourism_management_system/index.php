<?php
// Include db config
session_start();
include("config/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kiulu White Water Rafting</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <header></header>
    <!-- User Nav section-->
    <?php include("includes/userNav.php"); ?>
    <!-- Main container for sticky footer -->
    <div class="container">
        <!-- Navigation Menu -->
        <?php include("includes/topNav.php"); ?>

        <!-- Login Popup -->
		<div id="login-popup" class="login-popup">
    		<span class="close-btn" onclick="closeLoginPopup()">&times;</span>
    		<h3>User Login</h3>
    		<form action="userAuth/login_action.php" method="post">
        		<label for="userEmail">User Email:</label><br>
        		<input type="email" id="userEmail" name="userEmail" required><br><br>
        		<label for="userPassword">Password:</label><br>
        		<input type="password" id="userPassword" name="userPassword" required maxlength="50" autocomplete="off"><br><br>
        		<input type="submit" value="Login">
        		<input type="reset" value="Reset"><br>
    		</form>
    		<p>
        		<a href="javascript:void(0);" onclick="openRegPopup();">| Registration </a> | 
        		<a href="javascript:void(0);" onclick="openForgotPasswordPopup();">Forgot Password</a> |
    		</p>
		</div>
        
        <!-- Overlay -->
        <div id="overlay" class="overlay" onclick="closeLoginPopup();"></div>
        <!-- End Login Popup -->

		<!-- Forgot Password Popup -->
        <div id="forgot-password-popup" class="forgot-password-popup">
            <span class="close-btn" onclick="closeForgotPasswordPopup()">&times;</span>
            <h3>Reset Password</h3>
            <form action="userAuth/reset_password_action.php" method="post">
                <label for="userEmail">Enter your email address:</label><br>
                <input type="email" id="userEmail" name="userEmail" required><br><br>
    			<label for="newPassword">New Password:</label><br>
    			<input type="password" id="newPassword" name="newPassword" required><br><br>
    			<label for="confirmPassword">Confirm Password:</label><br>
    			<input type="password" id="confirmPassword" name="confirmPassword" required><br><br>
                <input type="submit" value="Reset Password">
            </form>
        </div>

        <!-- Overlay -->
        <div id="overlay" class="overlay" onclick="closeForgotPasswordPopup()"></div>
        <!-- End Forgot Password Popup -->

        <!-- Registration Popup -->
        <div id="reg-popup" class="reg-popup">
            <span class="close-btn" onclick="closeRegPopup()">&times;</span>
            <h3>User Registration</h3>
            <form action="userAuth/register_action.php" method="post">
                <label for="reguserName">Username:</label><br>
                <input type="text" id="reguserName" name="userName" required><br><br>
                <label for="reguserEmail">User Email:</label><br>
                <input type="email" id="reguserEmail" name="userEmail" required><br><br>
                <label for="reguserContact">Contact:</label><br>
                <input type="text" id="reguserContact" name="userContact" required><br><br>
                <label for="reguserPassword">Password:</label><br>
                <input type="password" id="reguserPassword" name="userPassword" required maxlength="50"><br><br>
                <label for="regconfirmPwd">Confirm Password:</label><br>
                <input type="password" id="regconfirmPwd" name="confirmPwd" required><br><br>
                <input type="submit" value="Register">
                <input type="reset" value="Reset"><br>
            </form>
        </div>
        <!-- Overlay -->
        <div id="overlay" class="overlay" onclick="closeRegPopup()"></div>
        <!-- End Registration Popup -->

        <main>
           <h1 align="center">WELCOME TO<br>Kiulu White Water Rafting</h1>
           <div class="section">
           <table width="1500px" border="1" id="blogtable2">
           <tr>
           <th><img class="image" src="uploads/photo_2025-01-19_16-35-05.jpg" width="375px"></th>
           <th><img class="image" src="uploads/photo_2025-01-19_16-35-09.jpg" width="375px"></th>
           <th><img class="image" src="uploads/photo_2025-01-19_16-35-11.jpg" width="375px"></th>
           <th><img class="image" src="uploads/photo_2025-01-19_16-35-14.jpg" width="375px"></th>
            </tr>
            </table>
            <h3 align="center">Kiulu  river rafting (Grade I - II)</h3>
            <p align="center" text-align="justify">The Kiulu River is a great river for people of all skill levels to enjoy and a scenic day out for beginners and adventurous people of all ages. This trip covers up to 15km of river depending on water levels. During your trip down the river don't forget to keep your eyes open for wildlife on the banks of the river! You can also have a go at body rafting as well as helping the rest of your boat crew navigate the grade 1 to 2 rapids.<br>​The fun filled journey down the river will take about 1 ½ - 2 hours before reaching the ending point where a delicious lunch will be prepared by the riverbank.</p> 
        </div>
        </main>
        
    </div>
    <footer class="footer">
    <p>Copyright &copy; 2024/2025<br>--- Lam Wai Sim BI22110336 --- Anthony Tan Jia Wei BI22160529 ---</p>
</footer>
    <script>
        // JS function for responsive navigation
        function myFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }

        // Menu navigation active state
        document.addEventListener("DOMContentLoaded", function () {
            const navLinks = document.querySelectorAll(".topnav a");
            const currentPath = window.location.pathname;

            navLinks.forEach(link => link.classList.remove("active"));

            navLinks.forEach(link => {
                const linkPath = new URL(link.href).pathname;
                if (linkPath === currentPath) {
                    link.classList.add("active");
                }
            });
        });

        // Login & Registration Popups
        function openLoginPopup() {
            document.getElementById("login-popup").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }

        function closeLoginPopup() {
            document.getElementById("login-popup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }

        function openRegPopup() {
            document.getElementById("reg-popup").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }

        function closeRegPopup() {
            document.getElementById("reg-popup").style.display = "none";
            document.getElementById("login-popup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }

		 // Forgot Password Popup
		 function openForgotPasswordPopup() {
            document.getElementById("forgot-password-popup").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }

        function closeForgotPasswordPopup() {
            document.getElementById("forgot-password-popup").style.display = "none";
            document.getElementById("login-popup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }

    </script>
</body>

</html>
