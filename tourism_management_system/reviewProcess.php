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
            <div class="rowform2">
            <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize inputs
    $bookingID = htmlspecialchars($_POST['bookingID']);
    $email = htmlspecialchars($_POST['email']);
    $reviewText = htmlspecialchars($_POST['reviewText']);
    $reviewRating = (int)htmlspecialchars($_POST['reviewRating']);
    $reviewDate = htmlspecialchars($_POST['orderdate']);
    $actType = htmlspecialchars($_POST['actType']);
    
    // Handle uploaded image
    $reviewImage = null;
    if (isset($_FILES['reviewImage']) && $_FILES['reviewImage']['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES['reviewImage']['name']);
        $uploadDir = "uploads/";
        $targetFilePath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['reviewImage']['tmp_name'], $targetFilePath)) {
            $reviewImage = $targetFilePath;
        }
    }
    
    // Retrieve user ID based on email
    $stmtUser = $conn->prepare("SELECT userID FROM user WHERE userEmail = ?");
    $stmtUser->bind_param("s", $email);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    if ($resultUser->num_rows > 0) {
        $rowUser = $resultUser->fetch_assoc();
        $userID = $rowUser['userID'];

        // Insert review into the review table
        $stmtReview = $conn->prepare("
            INSERT INTO review (bookingID, reviewText, reviewRating, reviewBy, reviewDate, reviewImage) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmtReview->bind_param("isisss", $bookingID, $reviewText, $reviewRating, $userID, $reviewDate, $reviewImage);

        if ($stmtReview->execute()) {
            echo "<tr>";
            echo "<h2>Thank You for Your Review</h2>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Order Date:</strong> " . date("d/m/Y", strtotime($reviewDate)) . "</p>";
            echo "<p><strong>Activity Type:</strong> $actType</p>";
            echo "<p><strong>Review:</strong> $reviewText</p>";
            echo "<p><strong>Rating:</strong> $reviewRating</p>";
            echo "<p><strong>Uploaded Image:</strong></p>";

            if ($reviewImage) {
                echo "<p><img src='$reviewImage' alt='Review Image' style='max-width:300px;'></p>";
            }
            echo "</tr>";
            
            echo "<tr>";
            // Display order details similar to `my_order.php`
            echo "<h3>Order Details</h3>";
            echo "<table cellpadding='10' cellspacing='1' width='100%' style='margin: 20px auto; border: 1px solid #ccc;'>";
            echo "<thead>
                    <tr style='background-color: #f2f2f2;'>
                        <th style='text-align:left;'>Type</th>
                        <th style='text-align:left;'>Details</th>
                        <th style='text-align:left;'>Quantity</th>
                        <th style='text-align:left;'>Amount (RM)</th>
                    </tr>
                  </thead>";
            echo "<tbody>";

            // Helper function to fetch and display details
            function fetchOrderDetails($conn, $bookingID, $detailsTable, $mainTable, $columns, $nameField, $type) {
                $sql = "SELECT $columns, $mainTable.$nameField AS Name 
                        FROM $detailsTable 
                        JOIN $mainTable 
                        ON $detailsTable." . $type . "ID = $mainTable." . $type . "ID 
                        WHERE bookingID = '$bookingID'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td style='text-align:left;'>$type</td>
                                <td style='text-align:left;'>{$row['Name']}</td>
                                <td style='text-align:left;'>{$row['Quantity']}</td>
                                <td style='text-align:left;'>" . number_format($row['Amount'], 2) . "</td>
                              </tr>";
                    }
                }
            }

            // Fetch details from each table
            fetchOrderDetails($conn, $bookingID, "activitybookingdetails", "activity", "activitybookingdetails.activityID AS ID, activitybookingdetails.actQuantity AS Quantity, activitybookingdetails.actAmount AS Amount", "activityName", "Activity");
            fetchOrderDetails($conn, $bookingID, "equipmentbookingdetails", "equipment", "equipmentbookingdetails.equipmentID AS ID, equipmentbookingdetails.equQuantity AS Quantity, equipmentbookingdetails.equAmount AS Amount", "equipmentName", "Equipment");
            fetchOrderDetails($conn, $bookingID, "accommodationbookingdetails", "accommodation", "accommodationbookingdetails.accommodationID AS ID, accommodationbookingdetails.accQuantity AS Quantity, accommodationbookingdetails.accAmount AS Amount", "accommodationName", "Accommodation");
            fetchOrderDetails($conn, $bookingID, "transportbookingdetails", "transport", "transportbookingdetails.transportID AS ID, transportbookingdetails.traQuantity AS Quantity, transportbookingdetails.traAmount AS Amount", "transportName", "Transport");
            fetchOrderDetails($conn, $bookingID, "tourbookingdetails", "tour", "tourbookingdetails.tourID AS ID, tourbookingdetails.tourQuantity AS Quantity, tourbookingdetails.tourAmount AS Amount", "tourName", "Tour");

            echo "</tbody>";
            echo "</tr>";
            echo "</table>";
        } else {
            echo "<h2>Error submitting your review. Please try again later.</h2>";
        }

        $stmtReview->close();
    } else {
        echo "<h2>Error: Email not found in the system.</h2>";
    }

    $stmtUser->close();
    $conn->close();
}
?>
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
