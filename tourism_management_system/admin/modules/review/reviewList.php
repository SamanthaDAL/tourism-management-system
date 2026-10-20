<?php
// Include DB config
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
    <title>Review List</title>
</head>

<body>
<header>
    <div class="topNav">
        <?php include("C:/xampp/htdocs/tourism_management_system/admin/includes/usernav.php"); ?>
    </div>
</header>

<?php
include '../../includes/sideNav.php';
?>

<div class="main">
    <h2 style="text-align: center;">Manage Review</h2>
    <div class="rowform4">
        <?php
        // Query to fetch review data including the image column
        $sql_review = "SELECT r.reviewID, r.bookingID, r.reviewText, r.reviewRating, r.reviewBy, 
                              u.userID, u.userName, r.reviewDate, r.reviewImage
                       FROM review r
                       JOIN user u ON r.reviewBy = u.userID
                       ORDER BY r.reviewID ASC";

        $result = mysqli_query($conn, $sql_review);
        $rowcount = mysqli_num_rows($result);

        if ($rowcount > 0) {
            // Start the table
            echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
            echo "<tr>";               
            echo "<th>Review ID</th>";
            echo "<th>Booking ID</th>";
            echo "<th>Review Text</th>";
            echo "<th>Rating</th>";
            echo "<th>Review By</th>";
            echo "<th>Review Date</th>";
            echo "<th>Review Image</th>";
            echo "<th>Actions</th>";
            echo "</tr>";

            // Dynamically create rows for each review
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";                    
                echo "<td>" . htmlspecialchars($row["reviewID"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["bookingID"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["reviewText"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["reviewRating"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["userName"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["reviewDate"]) . "</td>";
                echo "<td>";
                
                // Check if image exists and display it
                if (!empty($row["reviewImage"])) {
                    $imagePath = "/tourism_management_system/" . htmlspecialchars($row["reviewImage"]);
                    echo "<img src='" . $imagePath . "' alt='Review Image' width='100' height='100'>";
                } else {
                    // Placeholder if no image is available
                    echo "No Image";
                }
                
                echo "</td>";
                echo "<td>";
                echo "<a href='deleteReview.php?id=" . urlencode($row["reviewID"]) . "' 
                      onclick='return confirm(\"Are you sure you want to delete this review?\");'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<p>Row Count: $rowcount</p>";
        } else {
            echo "<p>No results found.</p>";
        }

        // Free result set and close connection
        mysqli_free_result($result);
        mysqli_close($conn);
        ?>
    </div>
</div>

<p><a href="<?php echo ADMIN_BASE_URL; ?>">Admin Page</a></p>

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

        //Dropdown content in sideNav
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
