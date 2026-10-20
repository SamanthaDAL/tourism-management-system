<?php
//include db config
include('C:/xampp/htdocs/tourism_management_system/config/config.php');
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
    <title>Activity List</title>
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
        <h2 style="text-align: center;">Manage Activity</h2>
        <div class="rowform">
            <?php
            $sql_activity = "SELECT a.activityID, a.activityName, a.categoryID,
            c.categoryID, c.categoryName
            FROM activity a, category c 
            WHERE a.categoryID = c.categoryID
            ORDER BY a.activityID ASC";
            $result = mysqli_query($conn, $sql_activity);
            $rowcount = mysqli_num_rows($result);
          
            if ($rowcount > 0) {
                // Start the table
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";               
                echo "<th>Activity ID</th>";
                echo "<th>Activity Name</th>";
                echo "<th>Category</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                // Dynamically create html table row based on output data of each row from customer table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";                    
                    echo "<td>" . htmlspecialchars($row["activityID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["activityName"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["categoryName"]) . "</td>";
                    echo "<td>";
                    echo "<a href='editActivity.php?id=" . urlencode($row["activityID"]) . "'>Edit</a> | ";
                    echo "<a href='deleteActivity.php?id=" . urlencode($row["activityID"]) . "' onclick='return confirm(\"Are you sure you want to delete this activity?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</table>";

                // Display row and field counts
                echo "<p>Row Count: $rowcount</p>";
            } else {
                echo "<p>No results found.</p>";
            }

            echo '</div>';
            echo '</div>';
            // Free result set
            mysqli_free_result($result);
            //close connection
            mysqli_close($conn);
            ?>
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