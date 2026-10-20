<?php
include('C:/xampp/htdocs/tourism_management_system/config/config.php');
// Start the session
session_start();
// Query to get userID and userName
$sql = "SELECT userID, userName FROM user";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
  <title>Blog Form</title>
</head>
<body>
<header>
<div class="topNav">
<?php include("C:/xampp/htdocs/tourism_management_system/admin/includes/usernav.php"); ?>
</header>

  <?php include '../../includes/sideNav.php'; ?>
  <div class="main">
    <h2>Create Blog</h2>

    <form action="insertBlog.php" method="POST"
enctype="multipart/form-data">
<label for="blogEntry">Blog Entry:</label><br>
<input type="text" id="blogEntry" name="blogEntry"><br><br>

<label for="createdBy">Created By:</label><br>
<select id = "createdBy" name="createdBy" required>
<option value="">Select User</option>
    <?php
    // Check if the query returned results
    if ($result->num_rows > 0) {
        // Loop through each row and create an <option> element
        while($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['userID'] . '">' . $row['userName'] . '</option>';
        }
    } else {
        echo '<option value="">No users found</option>';
    }
    ?>
</select><br><br>

<label for="updatedDate">Updated Date:</label><br>
<input type="date" id="updatedDate" name="updatedDate"
required><br><br>

<!-- Blog Image -->
<label for="blogImg">Blog Image:</label><br>
<input type="file" id="blogImg" name="blogImg"
accept="image/*"><br><br>
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
