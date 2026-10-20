<?php
// Include database configuration
include("../../../config/config.php");

// Start the session
session_start();

// Check if bookingID is passed via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p>Invalid Booking ID.</p>";
    echo "<a href='bookingList.php'>Back to Booking List</a>";
    exit();
}

$bookingID = $_GET['id'];

// SQL query to retrieve accommodation booking details
$sql_accommodation = "
    SELECT 
        abd.accBookID, 
        a.accommodationName, 
        abd.accQuantity, 
        abd.accAmount
    FROM accommodationbookingdetails abd
    LEFT JOIN accommodation a ON abd.accommodationID = a.accommodationID
    WHERE abd.bookingID = ?";
$stmt = $conn->prepare($sql_accommodation);
$stmt->bind_param("i", $bookingID);
$stmt->execute();
$result = $stmt->get_result();

// Check if query execution was successful
if (!$result) {
    echo "<p>Error executing query: " . $conn->error . "</p>";
    echo "<a href='bookingList.php'>Back to Booking List</a>";
    exit();
}

// Display accommodation details
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Booking Details</title>
</head>
<body>
    <header>
        <div class="topNav">
            <?php include("C:/xampp/htdocs/tourism_management_system/admin/includes/usernav.php"); ?>
        </div>
    </header>

    <?php include '../../includes/sideNav.php'; ?>

    <div class="main">
        <h2 style="text-align: center;">Accommodation Booking Details</h2>
        <div class="rowform3">
            <?php
            if ($result->num_rows > 0) {
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";
                echo "<th>Accommodation Booking ID</th>";
                echo "<th>Accommodation Name</th>";
                echo "<th>Quantity</th>";
                echo "<th>Amount</th>";
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['accBookID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['accommodationName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['accQuantity']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['accAmount']) . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No accommodation bookings found for this Booking ID.</p>";
            }

            // Free result set
            $stmt->close();
            ?>
        </div>
        <!-- Back Button -->
        <div style="text-align: right; margin-top: 20px;">
            <a href="bookingList.php" class="btn">Back to Booking List</a>
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
