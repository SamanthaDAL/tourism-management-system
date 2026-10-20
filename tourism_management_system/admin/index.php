<?php
session_start();
include("../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Panel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<header>
<div class="topNav">
<?php include("includes/userNav.php"); ?>
</header>

    <!-- Side Navigation -->
    <?php include 'includes/sideNav.php'; ?>

    <!-- Main Container -->
    <div class="main">
        <h2>Admin Panel Dashboard</h2>
    </div>

     <!-- Login Popup -->
		<div id="login-popup" class="login-popup">
    		<span class="close-btn" onclick="closeLoginPopup()">&times;</span>
    		<h3>Admin Login</h3>
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
            <h3>Admin Registration</h3>
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

    <footer class="footer">
        <p>&copy; 2024 Admin Panel</p>
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
        //Login & Popup
		function openLoginPopup() {
			document.getElementById("login-popup").style.display = "block";
			document.getElementById("overlay").style.display = "block";
		}

		function closeLoginPopup() {
			document.getElementById("login-popup").style.display = "none";
			document.getElementById("overlay").style.display = "none";
		}

        // Dropdown content in sideNav
        const dropdown = document.getElementsByClassName("dropdown-btn");
        for (let i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function () {
                this.classList.toggle("active");
                const dropdownContent = this.nextElementSibling;
                dropdownContent.style.display =
                    dropdownContent.style.display === "block" ? "none" : "block";
            });
        }
    </script>
</body>

</html>
