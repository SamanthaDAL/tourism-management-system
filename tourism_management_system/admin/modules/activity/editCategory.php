<?php
// Include db config
include("../../../config/config.php");
// Start the session
session_start();

// Check if ID is provided
if (isset($_GET['id'])) {
    $categoryID = intval($_GET['id']);

    // Retrieve the existing category data using prepared statement
    $sql = "SELECT * FROM category WHERE categoryID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $categoryID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $categoryName = $row['categoryName'];
        // Ensure categoryDescription is set; default to empty string if not found
        $categoryDesc = isset($row['categoryDescription']) ? $row['categoryDescription'] : ''; 
    } else {
        echo "Category not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle category update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST['categoryName'];
    // Check if categoryDescription is provided, else set it to NULL
    $categoryDescription = isset($_POST['categoryDescription']) ? $_POST['categoryDescription'] : NULL;

    // Prepare and execute the update query
    $sql = "UPDATE category SET categoryName = ?, categoryDescription = ? WHERE categoryID = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters: "ssi" - two strings and one integer
    mysqli_stmt_bind_param($stmt, "ssi", $categoryName, $categoryDescription, $categoryID);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect after successful update
        header("Location: categoryList.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Category Form</title>
</head>
<body>
<header>
<div class="topNav">
<?php include("C:/xampp/htdocs/tourism_management_system/admin/includes/usernav.php"); ?>
</header>

<?php
include '../../includes/sideNav.php';
?>

<div class="main">
    <h2 style="text-align: center;">Edit Category ID: <?= htmlspecialchars($categoryID) ?></h2>
    <div class="rowform">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="categoryID" value="<?= htmlspecialchars($categoryID) ?>">
            <label for="categoryName">Category Name:</label>
            <input type="text" id="categoryName" name="categoryName" value="<?= htmlspecialchars($categoryName) ?>" required><br><br>
            <label for="categoryDesc">Category Description:</label>
            <input type="text" id="categoryDescription" name="categoryDescription" value="<?= htmlspecialchars($categoryDesc) ?>" required><br><br>
            <button type="submit">Update</button>
        </form>
    </div>
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
