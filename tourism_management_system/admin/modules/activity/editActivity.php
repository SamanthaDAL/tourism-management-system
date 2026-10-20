<?php
//include db config
include("../../../config/config.php");
// Start the session
session_start();

// Query to get categoryID and categoryName
$sql_cat = "SELECT categoryID, categoryName FROM category";
$resultCat = $conn->query($sql_cat);

// Check if ID is provided
if (isset($_GET['id'])) {
    $activityID = intval($_GET['id']);

    // Another example to retrieve the existing activity data using prepared statement
    $sql = "SELECT * FROM activity WHERE activityID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $activityID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $activityName = $row['activityName'];
        $categoryID = $row['categoryID'];
        $activityPrice = $row['activityPrice'];
        $min_quantity = $row['min_quantity'];
        $max_quantity = $row['max_quantity'];
        $activityImg = $row['activityImg'];
    } else {
        echo "activity not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle activity Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $activityName = $_POST['activityName'];
    $categoryID = $_POST['categoryID'];
    $activityPrice = $_POST['activityPrice'];
    $min_quantity = $_POST['min_quantity'];
    $max_quantity = $_POST['max_quantity'];

    $uploadDir = '../../../uploads/';
    $activityImg = null;

    // Check if a new image is uploaded
    if (isset($_FILES['activityImg']) && $_FILES['activityImg']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['activityImg']['tmp_name'];
        $fileName = basename($_FILES['activityImg']['name']);
        $targetPath = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($tmpName, $targetPath)) {
            $image = $fileName;

            // Optional: Delete the old image if necessary
            $sql = "SELECT activityImg FROM activity WHERE activityID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $activityID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $activity = mysqli_fetch_assoc($result);

            if ($activity && $activity['activityImg'] && file_exists($uploadDir . $activity['activityImg'])) {
                unlink($uploadDir . $activity['activityImg']); // Deletes the old image file
            }
            mysqli_stmt_close($stmt);
            echo $activityImg;
        }
    }

    if ($image) {
        //directory saved to DB
        $activityImg = "uploads/" . $image;
        echo $activityImg;
        $sql = "UPDATE activity SET activityName = ?, categoryID = ?, activityPrice = ?, min_quantity = ?, max_quantity = ?, activityImg = ? WHERE activityID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sidiisi", $activityName, $categoryID, $activityPrice, $min_quantity, $max_quantity, $activityImg, $activityID);
    } else {
        $sql = "UPDATE activity SET activityName = ?, categoryID = ?, activityPrice = ?, min_quantity = ?, max_quantity = ? WHERE activityID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sidiii", $activityName, $categoryID, $activityPrice, $min_quantity, $max_quantity, $activityID);
    }

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo "activity updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect or display a success message
    header("Location: activityList.php");
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
    <title>Activity Form</title>
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
        <h2 style="text-align: center;">Edit activity ID : <?= $activityID ?></h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="activityID" value="<?= isset($activityID) ? htmlspecialchars($activityID) : 'NONE'; ?>">
                <label for="activityName">activity Name:</label>
                <input type="text" id="activityName" name="activityName" value="<?= htmlspecialchars($activityName) ?>" required><br><br>
                <label for="categoryID">activity Category:</label><br>
                <select id="categoryID" name="categoryID" required>
                <option value="">Select Category</option>
                    <?php
                    // Check if the query returned results
                    if ($resultCat->num_rows > 0) {
                        // Loop through each row and create an <option> element
                        while($row = $resultCat->fetch_assoc()) {
                            echo '<option value="' . $row['categoryID'] . '">' . $row['categoryName'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No categorys found</option>';
                    }
                    ?>
                </select><br><br>

                <label for="activityPrice">activity Price:</label>
                <input type="text" id="activityPrice" name="activityPrice" value="<?= htmlspecialchars($activityPrice) ?>" required><br><br>
                <label for="min_quantity">Min Quantity:</label>
                <input type="text" id="min_quantity" name="min_quantity" value="<?= htmlspecialchars($min_quantity) ?>" required><br><br>
                <label for="max_quantity">Max Quantity:</label>
                <input type="text" id="max_quantity" name="max_quantity" value="<?= htmlspecialchars($max_quantity) ?>" required><br><br>
                <label for="prod_image">activity Image:</label><br>
                <img src="<?= BASE_URL . '/' . htmlspecialchars($activityImg) ?>" style="width:150px;height:150px;text-align: center;"><br><br>
                <input type="file" id="activityImg" name="activityImg" accept="image/*"><br><br>
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