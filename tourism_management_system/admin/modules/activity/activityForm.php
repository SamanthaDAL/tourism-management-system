<?php
include('C:/xampp/htdocs/tourism_management_system/config/config.php');
// Start the session
session_start();
// Query to get categoryID and categoryName
$sql = "SELECT categoryID, categoryName FROM category";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
  <title>Activity Form</title>
</head>
<body>
<header>
<div class="topNav">
<?php include("C:/xampp/htdocs/tourism_management_system/admin/includes/usernav.php"); ?>
</header>

  <?php include '../../includes/sideNav.php'; ?>
  <div class="main">
    <h2>Create Activity</h2>

    <form action="insertActivity.php" method="POST"
enctype="multipart/form-data">
<label for="activityName">Activity Name:</label><br>
<input type="text" id="activityName" name="activityName"
required><br><br>

<label for="categoryID">Activity Category:</label><br>
<select id="categoryID" name="categoryID" required>
<option value="">Select Category</option>
    <?php
    // Check if the query returned results
    if ($result->num_rows > 0) {
        // Loop through each row and create an <option> element
        while($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['categoryID'] . '">' . $row['categoryName'] . '</option>';
        }
    } else {
        echo '<option value="">No categorys found</option>';
    }
    ?>
</select><br><br>

<label for="activityPrice">Product Price:</label><br>
<input type="number" id="activityPrice" name="activityPrice"
min="0.01" step="0.01" required><br><br>

<label for="min_quantity">Min Quantity:</label><br>
<input type="number" id="min_quantity" name="min_quantity"
required><br><br>

<label for="max_quantity">Max Quantity:</label><br>
<input type="number" id="max_quantity" name="max_quantity"
required><br><br>

<!-- Product Image -->
<label for="activityImg">Activity Image:</label><br>
<input type="file" id="activityImg" name="activityImg"
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
