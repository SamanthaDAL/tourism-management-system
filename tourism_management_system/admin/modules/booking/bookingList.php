<?php
// Include database configuration
include("../../../config/config.php");

// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Booking List</title>
</head>
<body>
<header>
<div class="topNav">
<?php include("C:/xampp/htdocs/tourism_management_system/admin/includes/usernav.php"); ?>
</header>

<?php include '../../includes/sideNav.php'; ?>

<div class="main">
    <h2 style="text-align: center;">Manage Booking</h2>
    <div class="rowform4">
        <?php
        $sql_booking = "
            SELECT 
                b.bookingID, 
                b.bookerID, 
                u.userID, 
                u.userName AS bookerName, 
                b.bookingAmount, 
                b.bookingDate
            FROM booking b
            LEFT JOIN user u ON b.bookerID = u.userID
            ORDER BY b.bookingID ASC";

        $result = mysqli_query($conn, $sql_booking);

        if (!$result) {
            echo "<p>Error executing query: " . mysqli_error($conn) . "</p>";
        } else {
            $rowcount = mysqli_num_rows($result);

            if ($rowcount > 0) {
                // Start the table
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";
                echo "<th>Booking ID</th>";
                echo "<th>Booker Name</th>";
                echo "<th>Activity</th>";
                echo "<th>Equipment</th>";
                echo "<th>Accommodation</th>";
                echo "<th>Transport</th>";
                echo "<th>Tour</th>";
                echo "<th>Booking Amount</th>";
                echo "<th>Booking Date</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                // Loop through each booking record
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["bookingID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bookerName"]) . "</td>";

                    // Activity ID
                    echo "<td>";
                        echo "<br><a href='viewActivity.php?id=" . urlencode($row["bookingID"]) . "'>View</a>";
                    echo "</td>";

                    // Equipment ID
                    echo "<td>";
                        echo "<br><a href='viewEquipment.php?id=" . urlencode($row["bookingID"]) . "'>View</a>";
                    echo "</td>";

                    // Accommodation ID
                    echo "<td>";
                        echo "<br><a href='viewAccommodation.php?id=" . urlencode($row["bookingID"]) . "'>View</a>";
                    echo "</td>";

                    // Transport ID
                    echo "<td>";
                        echo "<br><a href='viewTransport.php?id=" . urlencode($row["bookingID"]) . "'>View</a>";
                    echo "</td>";

                    // Tour ID
                    echo "<td>";
                        echo "<br><a href='viewTour.php?id=" . urlencode($row["bookingID"]) . "'>View</a>";
                    echo "</td>";

                    // Booking Amount and Date
                    echo "<td>" . htmlspecialchars($row["bookingAmount"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bookingDate"]) . "</td>";

                    // Actions
                    echo "<td>";
                    echo "<a href='deleteBooking.php?id=" . urlencode($row["bookingID"]) . "' onclick='return confirm(\"Are you sure you want to delete this booking?\");'>Delete</a>";
                    echo "</td>";

                    echo "</tr>";
                }

                echo "</table>";
                echo "<p>Row Count: $rowcount</p>";
            } else {
                echo "<p>No results found.</p>";
            }
        }

        // Free result set and close connection
        if ($result) {
            mysqli_free_result($result);
        }
        mysqli_close($conn);
        ?>
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
