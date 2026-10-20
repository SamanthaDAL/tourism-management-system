<?php
//include db config
include("../../../config/config.php");
// Start the session
session_start();

// Check if ID is provided
if (isset($_GET['id'])) {
    $tourID = intval($_GET['id']);

    // Another example to retrieve the existing tour data using prepared statement
    $sql = "SELECT * FROM tour WHERE tourID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $tourID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $tourName = $row['tourName'];
        $tourContact = $row['tourContact'];
        $tourRating = $row['tourRating'];
        $tourPrice = $row['tourPrice'];
        $tourImg = $row['tourImg'];
    } else {
        echo "tour not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle tour Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tourName = $_POST['tourName'];
    $tourContact = $_POST['tourContact'];
    $tourRating = $_POST['tourRating'];
    $tourPrice = $_POST['tourPrice'];

    $uploadDir = '../../../uploads/';
    $tourImg = null;

    // Check if a new image is uploaded
    if (isset($_FILES['tourImg']) && $_FILES['tourImg']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['tourImg']['tmp_name'];
        $fileName = basename($_FILES['tourImg']['name']);
        $targetPath = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($tmpName, $targetPath)) {
            $image = $fileName;

            // Optional: Delete the old image if necessary
            $sql = "SELECT tourImg FROM tour WHERE tourID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $tourID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $tour = mysqli_fetch_assoc($result);

            if ($tour && $tour['tourImg'] && file_exists($uploadDir . $tour['tourImg'])) {
                unlink($uploadDir . $tour['tourImg']); // Deletes the old image file
            }
            mysqli_stmt_close($stmt);
            echo $tourImg;
        }
    }

    if ($image) {
        //directory saved to DB
        $tourImg = "uploads/" . $image;
        echo $tourImg;
        $sql = "UPDATE tour SET tourName = ?, tourContact = ?, tourRating = ?, tourPrice = ?, tourImg = ? WHERE tourID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssidsi", $tourName, $tourContact, $tourRating, $tourPrice, $tourImg, $tourID);
    } else {
        $sql = "UPDATE tour SET tourName = ?, tourContact = ?, tourRating = ?, tourPrice = ? WHERE tourID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssidi", $tourName, $tourContact, $tourRating, $tourPrice, $tourID);
    }

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo "tour updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect or display a success message
    header("Location: tourList.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Tour Form</title>
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
        <h2 style="text-align: center;">Edit tour ID : <?= $tourID ?></h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="tourID" value="<?= isset($tourID) ? htmlspecialchars($tourID) : 'NONE'; ?>">
                <label for="tourName">Tour Name:</label>
                <input type="text" id="tourName" name="tourName" value="<?= htmlspecialchars($tourName) ?>" required><br><br>
                <label for="tourContact">Tour Contact:</label>
                <input type="text" id="tourContact" name="tourContact" value="<?= htmlspecialchars($tourContact) ?>" required><br><br>
                <label for="tourRating">Tour Rating:</label>
                <input type="text" id="tourRating" name="tourRating" value="<?= htmlspecialchars($tourRating) ?>" required><br><br>
                <label for="tourPrice">Tour Price:</label>
                <input type="text" id="tourPrice" name="tourPrice" value="<?= htmlspecialchars($tourPrice) ?>" required><br><br>
                <label for="prod_image">tour Image:</label><br>
                <img src="<?= BASE_URL . '/' . htmlspecialchars($tourImg) ?>" style="width:150px;height:150px;text-align: center;"><br><br>
                <input type="file" id="tourImg" name="tourImg" accept="image/*"><br><br>
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