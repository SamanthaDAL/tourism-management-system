<?php
//include db config
include("../../../config/config.php");
// Start the session
session_start();

// Check if ID is provided
if (isset($_GET['id'])) {
    $accommodationID = intval($_GET['id']);

    // Another example to retrieve the existing accommodation data using prepared statement
    $sql = "SELECT * FROM accommodation WHERE accommodationID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $accommodationID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $accommodationName = $row['accommodationName'];
        $accommodationDescription = $row['accommodationDescription'];
        $accommodationLocation = $row['accommodationLocation'];
        $accommodationPrice = $row['accommodationPrice'];
        $accommodationRating = $row['accommodationRating'];
        $accommodationImg = $row['accommodationImg'];
    } else {
        echo "accommodation not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle accommodation Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accommodationName = $_POST['accommodationName'];
    $accommodationDescription = $_POST['accommodationDescription'];
    $accommodationLocation = $_POST['accommodationLocation'];
    $accommodationPrice = $_POST['accommodationPrice'];
    $accommodationRating = $_POST['accommodationRating'];
    $uploadDir = '../../../uploads/';
    $accommodationImg = null;

    // Check if a new image is uploaded
    if (isset($_FILES['accommodationImg']) && $_FILES['accommodationImg']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['accommodationImg']['tmp_name'];
        $fileName = basename($_FILES['accommodationImg']['name']);
        $targetPath = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($tmpName, $targetPath)) {
            $image = $fileName;

            // Optional: Delete the old image if necessary
            $sql = "SELECT accommodationImg FROM accommodation WHERE accommodationID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $accommodationID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $accommodation = mysqli_fetch_assoc($result);

            if ($accommodation && $accommodation['accommodationImg'] && file_exists($uploadDir . $accommodation['accommodationImg'])) {
                unlink($uploadDir . $accommodation['accommodationImg']); // Deletes the old image file
            }
            mysqli_stmt_close($stmt);
            echo $accommodationImg;
        }
    }

    if ($image) {
        //directory saved to DB
        $accommodationImg = "uploads/" . $image;
        echo $accommodationImg;
        $sql = "UPDATE accommodation SET accommodationName = ?, accommodationDescription = ?, accommodationLocation = ?, accommodationPrice = ?, accommodationRating = ?, accommodationImg = ? WHERE accommodationID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssdisi", $accommodationName, $accommodationDescription, $accommodationLocation, $accommodationPrice, $accommodationRating, $accommodationImg, $accommodationID);
    } else {
        $sql = "UPDATE accommodation SET accommodationName = ?, accommodationDescription = ?, accommodationLocation = ?, accommodationPrice = ?, accommodationRating = ? WHERE accommodationID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssdii", $accommodationName, $accommodationDescription, $accommodationLocation, $accommodationPrice, $accommodationRating, $accommodationID);
    }

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo "accommodation updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect or display a success message
    header("Location: accommodationList.php");
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
    <title>Accommodation Form</title>
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
        <h2 style="text-align: center;">Edit accommodation ID : <?= $accommodationID ?></h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="accommodationID" value="<?= isset($accommodationID) ? htmlspecialchars($accommodationID) : 'NONE'; ?>">
                <label for="accommodationName">Accommodation Name:</label>
                <input type="text" id="accommodationName" name="accommodationName" value="<?= htmlspecialchars($accommodationName) ?>" required><br><br>
                <label for="accommodationDescription">Accommodation Description:</label>
                <input type="text" id="accommodationDescription" name="accommodationDescription" value="<?= htmlspecialchars($accommodationDescription) ?>" required><br><br>
                <label for="accommodationLocation">Accommodation Location:</label>
                <input type="text" id="accommodationLocation" name="accommodationLocation" value="<?= htmlspecialchars($accommodationLocation) ?>" required><br><br>
                <label for="accommodationPrice">Accommodation Price:</label>
                <input type="text" id="accommodationPrice" name="accommodationPrice" value="<?= htmlspecialchars($accommodationPrice) ?>" required><br><br>
                <label for="accommodationRating">Accommodation Rating:</label>
                <input type="text" id="accommodationRating" name="accommodationRating" value="<?= htmlspecialchars($accommodationRating) ?>" required><br><br>
                <label for="prod_image">Accommodation Image:</label><br>
                <img src="<?= BASE_URL . '/' . htmlspecialchars($accommodationImg) ?>" style="width:150px;height:150px;text-align: center;"><br><br>
                <input type="file" id="accommodationImg" name="accommodationImg" accept="image/*"><br><br>
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