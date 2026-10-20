<?php
//include db config
include("../../../config/config.php");
// Start the session
session_start();

// Query to get transportID and transportName
$sql_cat = "SELECT typeID, typeName FROM cartype";
$resultCat = $conn->query($sql_cat);

// Check if ID is provided
if (isset($_GET['id'])) {
    $transportID = intval($_GET['id']);

    // Another example to retrieve the existing transport data using prepared statement
    $sql = "SELECT * FROM transport WHERE transportID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $transportID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $transportName = $row['transportName'];
        $typeID = $row['typeID'];
        $transportPrice = $row['transportPrice'];
        $transportImg = $row['transportImg'];
    } else {
        echo "transport not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle transport Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transportName = $_POST['transportName'];
    $typeID = $_POST['typeID'];
    $transportPrice = $_POST['transportPrice'];

    $uploadDir = '../../../uploads/';
    $transportImg = null;

    // Check if a new image is uploaded
    if (isset($_FILES['transportImg']) && $_FILES['transportImg']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['transportImg']['tmp_name'];
        $fileName = basename($_FILES['transportImg']['name']);
        $targetPath = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($tmpName, $targetPath)) {
            $image = $fileName;

            // Optional: Delete the old image if necessary
            $sql = "SELECT transportImg FROM transport WHERE transportID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $transportID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $transport = mysqli_fetch_assoc($result);

            if ($transport && $transport['transportImg'] && file_exists($uploadDir . $transport['transportImg'])) {
                unlink($uploadDir . $transport['transportImg']); // Deletes the old image file
            }
            mysqli_stmt_close($stmt);
            echo $transportImg;
        }
    }

    if ($image) {
        //directory saved to DB
        $transportImg = "uploads/" . $image;
        echo $transportImg;
        $sql = "UPDATE transport SET transportName = ?, typeID = ?, transportPrice = ?, transportImg = ? WHERE transportID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sidsi", $transportName, $typeID, $transportPrice, $transportImg, $transportID);
    } else {
        $sql = "UPDATE transport SET transportName = ?, typeID = ?, transportPrice = ? WHERE transportID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sidi", $transportName, $typeID, $transportPrice, $transportID);
    }

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo "transport updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect or display a success message
    header("Location: transportList.php");
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
    <title>Transport Form</title>
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
        <h2 style="text-align: center;">Edit transport ID : <?= $transportID ?></h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="transportID" value="<?= isset($transportID) ? htmlspecialchars($transportID) : 'NONE'; ?>">
                <label for="transportName">Transport Name:</label>
                <input type="text" id="transportName" name="transportName" value="<?= htmlspecialchars($transportName) ?>" required><br><br>
                <label for="typeID">Type:</label><br>
                <select id="typeID" name="typeID" required>
                <option value="">Select type</option>
                    <?php
                    // Check if the query returned results
                    if ($resultCat->num_rows > 0) {
                        // Loop through each row and create an <option> element
                        while($row = $resultCat->fetch_assoc()) {
                            echo '<option value="' . $row['typeID'] . '">' . $row['typeName'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No type found</option>';
                    }
                    ?>
                </select><br><br>
                <label for="transportPrice">Transport Price:</label>
                <input type="text" id="transportPrice" name="transportPrice" value="<?= htmlspecialchars($transportPrice) ?>" required><br><br>
                <label for="prod_image">Transport Image:</label><br>
                <img src="<?= BASE_URL . '/' . htmlspecialchars($transportImg) ?>" style="width:150px;height:150px;text-align: center;"><br><br>
                <input type="file" id="transportImg" name="transportImg" accept="image/*"><br><br>
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