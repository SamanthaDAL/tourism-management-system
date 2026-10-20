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
    <title>Accommodation List</title>
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
        <h2 style="text-align: center;">Manage accommodation</h2>
        <div class="rowform4">
            <?php
            $sql_accommodation = "SELECT a.accommodationID, a.accommodationName, a.accommodationDescription, a.accommodationLocation, a.accommodationPrice, accommodationRating
            FROM accommodation a
            ORDER BY a.accommodationID ASC";
            $result = mysqli_query($conn, $sql_accommodation);
            $rowcount = mysqli_num_rows($result);
          
            if ($rowcount > 0) {
                // Start the table
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";               
                echo "<th>Accommodation ID</th>";
                echo "<th>Accommodation Name</th>";
                echo "<th>Accommodation Description</th>";
                echo "<th>accommodation Location</th>";
                echo "<th>accommodation Price</th>";
                echo "<th>accommodation Rating</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                // Dynamically create html table row based on output data of each row from customer table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";                    
                    echo "<td>" . htmlspecialchars($row["accommodationID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["accommodationName"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["accommodationDescription"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["accommodationLocation"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["accommodationPrice"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["accommodationRating"]) . "</td>";
                    echo "<td>";
                    echo "<a href='editAccommodation.php?id=" . urlencode($row["accommodationID"]) . "'>Edit</a> | ";
                    echo "<a href='deleteAccommodation.php?id=" . urlencode($row["accommodationID"]) . "' onclick='return confirm(\"Are you sure you want to delete this accommodation?\");'>Delete</a>";
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