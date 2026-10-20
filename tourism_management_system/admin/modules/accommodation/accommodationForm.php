<?php
include('C:/xampp/htdocs/tourism_management_system/config/config.php');
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
  <title>Accommodation Form</title>
</head>
<body>

<header>
<div class="topNav">
<?php include("C:/xampp/htdocs/tourism_management_system/admin/includes/usernav.php"); ?>
</header>

  <?php include '../../includes/sideNav.php'; ?>
  <div class="main">
    <h2>Create Accommodation</h2>

    <form action="insertaccommodation.php" method="POST"
enctype="multipart/form-data">
<label for="accommodationName">Accommodation Name:</label><br>
<input type="text" id="accommodationName" name="accommodationName"
required><br><br>

<label for="accommodationDescription">Accommodation Description:</label><br>
<input type="text" id="accommodationDescription" name="accommodationDescription"
required><br><br>

<label for="accommodationLocation">Accommodation Location:</label><br>
<input type="text" id="accommodationLocation" name="accommodationLocation"
required><br><br>

<label for="accommodationPrice">Accommodation Price:</label><br>
<input type="number" id="accommodationPrice" name="accommodationPrice"
min="0.01" step="0.01" required><br><br>

<label for="accommodationRating">Rating (0-10):</label>
<input type="range" name="accommodationRating" id="accommodationRating" min="0" max="10" required><br><br>

<!-- Product Image -->
<label for="accommodationImg">Accommodation Image:</label><br>
<input type="file" id="accommodationImg" name="accommodationImg"
accept="image/*" required><br><br>
<button type="submit">Submit</button>
</form>

  </div>
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
