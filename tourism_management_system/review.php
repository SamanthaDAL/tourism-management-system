<?php
//include db config
session_start();
include("config/config.php");

$bookingID = isset($_GET['bookingID']) ? htmlspecialchars($_GET['bookingID']) : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Review Page</title>
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
  <?php include("includes/topNav.php"); include("userAuth/modalForm.php"); ?>
  <main>
    <h2 style="text-align: center;">Review</h2>
    <div class="rowform">
    <form action="reviewProcess.php" method="post" name="reviewForm" enctype="multipart/form-data">
    <!-- Hidden input to send bookingID -->
    <input type="hidden" name="bookingID" value="<?php echo $bookingID; ?>">
    
    <p>Booking ID: <strong><?php echo $bookingID; ?></strong></p>
    <p>Email : <input type="email" name="email" id="email" required></p>
    <p>Order date : <input type="date" id="orderdate" name="orderdate" required></p>
    <p>Activity type : 
        <input type="radio" name="actType" value="Morning" id="Morning" checked>
        <label for="Morning"> Morning</label>
        <input type="radio" name="actType" value="Afternoon" id="Afternoon">
        <label for="Afternoon"> Afternoon</label>
    </p>
    <p>Review: <br><textarea id="reviewText" name="reviewText" rows="4" cols="50" required></textarea></p>
    <p>
        <label for="reviewRating">Rating (1-5):</label>
        <input type="range" name="reviewRating" id="reviewRating" min="1" max="5">
    </p>
    <p>Upload an Image: <input type="file" name="reviewImage" id="reviewImage" accept="image/*"></p>
    <input type="submit" value="Submit">
    <input type="reset" value="Reset">
</form>
        
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
