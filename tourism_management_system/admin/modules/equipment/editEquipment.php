<?php
//include db config
include("../../../config/config.php");
// Start the session
session_start();

// Check if ID is provided
if (isset($_GET['id'])) {
    $equipmentID = intval($_GET['id']);

    // Another example to retrieve the existing equipment data using prepared statement
    $sql = "SELECT * FROM equipment WHERE equipmentID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $equipmentID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $equipmentName = $row['equipmentName'];
        $equipmentQuantity = $row['equipmentQuantity'];
        $equipmentPrice = $row['equipmentPrice'];
        $equipmentImg = $row['equipmentImg'];
    } else {
        echo "equipment not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle equipment Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipmentName = $_POST['equipmentName'];
    $equipmentQuantity = $_POST['equipmentQuantity'];
    $equipmentPrice = $_POST['equipmentPrice'];

    $uploadDir = '../../../uploads/';
    $equipmentImg = null;

    // Check if a new image is uploaded
    if (isset($_FILES['equipmentImg']) && $_FILES['equipmentImg']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['equipmentImg']['tmp_name'];
        $fileName = basename($_FILES['equipmentImg']['name']);
        $targetPath = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($tmpName, $targetPath)) {
            $image = $fileName;

            // Optional: Delete the old image if necessary
            $sql = "SELECT equipmentImg FROM equipment WHERE equipmentID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $equipmentID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $equipment = mysqli_fetch_assoc($result);

            if ($equipment && $equipment['equipmentImg'] && file_exists($uploadDir . $equipment['equipmentImg'])) {
                unlink($uploadDir . $equipment['equipmentImg']); // Deletes the old image file
            }
            mysqli_stmt_close($stmt);
            echo $equipmentImg;
        }
    }

    if ($image) {
        //directory saved to DB
        $equipmentImg = "uploads/" . $image;
        echo $equipmentImg;
        $sql = "UPDATE equipment SET equipmentName = ?, equipmentQuantity = ?, equipmentPrice = ?, equipmentImg = ? WHERE equipmentID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sidsi", $equipmentName, $equipmentQuantity, $equipmentPrice, $equipmentImg, $equipmentID);
    } else {
        $sql = "UPDATE equipment SET equipmentName = ?, equipmentQuantity = ?, equipmentPrice = ? WHERE equipmentID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sidi", $equipmentName, $equipmentQuantity, $equipmentPrice, $equipmentID);
    }

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo "equipment updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect or display a success message
    header("Location: equipmentList.php");
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
    <title>Equipment Form</title>
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
        <h2 style="text-align: center;">Edit equipment ID : <?= $equipmentID ?></h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="equipmentID" value="<?= isset($equipmentID) ? htmlspecialchars($equipmentID) : 'NONE'; ?>">
                <label for="equipmentName">equipment Name:</label>
                <input type="text" id="equipmentName" name="equipmentName" value="<?= htmlspecialchars($equipmentName) ?>" required><br><br> 
                <label for="equipmentQuantity">Equipment Quantity:</label>
                <input type="text" id="equipmentQuantity" name="equipmentQuantity" value="<?= htmlspecialchars($equipmentQuantity) ?>" required><br><br>
                <label for="equipmentPrice">equipment Price:</label>
                <input type="text" id="equipmentPrice" name="equipmentPrice" value="<?= htmlspecialchars($equipmentPrice) ?>" required><br><br>
                <label for="prod_image">equipment Image:</label><br>
                <img src="<?= BASE_URL . '/' . htmlspecialchars($equipmentImg) ?>" style="width:150px;height:150px;text-align: center;"><br><br>
                <input type="file" id="equipmentImg" name="equipmentImg" accept="image/*"><br><br>
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