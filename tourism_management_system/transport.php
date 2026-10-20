<?php
//include db config
session_start();
include("config/config.php");

// Check for category filter
if (isset($_GET['cat']) && ($_GET['cat'] != '0')) {
    $typeID = $_GET['cat'];
    // Query to fetch activities and their category description
    $sql_transport = "
        SELECT 
            transport.*, 
            cartype.typeDescription 
        FROM 
            transport
        LEFT JOIN 
            cartype 
        ON 
            transport.typeID = cartype.typeID 
        WHERE 
            transport.typeID = $typeID";
} else {
    // Fetch all activities and their category description
    $sql_transport = "
        SELECT 
            transport.*, 
            cartype.typeDescription 
        FROM 
            transport 
        LEFT JOIN 
            cartype 
        ON 
            transport.typeID = cartype.typeID";
}

$result = mysqli_query($conn, $sql_transport);
$rowcount = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Transportation Booking Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .transport-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin: 20px;
        }

        .transport-card {
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            background-color: #fff;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .transport-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .transport-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .transport-card h3 {
            font-size: 1.2em;
            margin: 10px 0;
            color: #333;
        }

        .transport-card p {
            font-size: 0.9em;
            color: #666;
            margin: 0 10px 10px;
        }
    </style>
</head>

<body>
<header></header>

<!-- User Nav section-->
<?php include("includes/userNav.php"); ?>

<div class="container">
    <!-- Navigation Menu -->
    <?php
    include("includes/topNav.php");
    include("userAuth/modalForm.php");
    ?>
    <main>
        <h2 style="text-align: center;">Transportation Booking</h2>
        <div class="section">
            <table border="1" align="center">
                <tr>
                    <?php
                    // Fetch categories from the database
                    $sql_cartype = "SELECT * FROM cartype";
                    $result_cartype = mysqli_query($conn, $sql_cartype);

                    // Display the "All" category first
                    echo '<td><a href="transport.php?cat=0" style="text-decoration: none;">All</a></td>';

                    // Loop through each category
                    if (mysqli_num_rows($result_cartype) > 0) {
                        while ($cartype = mysqli_fetch_assoc($result_cartype)) {
                            echo '<td><a href="transport.php?cat=' . $cartype['typeID'] . '" style="text-decoration: none;">' . htmlspecialchars($cartype['typeName']) . '</a></td>';
                        }
                    } else {
                        echo '<td>No categories available</td>';
                    }

                    // Free result set
                    mysqli_free_result($result_cartype);
                    ?>
                </tr>
            </table>
        </div>

        <div class="transport-container">
            <?php
            if ($rowcount > 0) {
                // Fetch all transports into an array to determine the last 5 transports
                $allTransports = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $allTransports[] = $row;
                }

                // Loop through transports and generate HTML
                foreach ($allTransports as $index => $row) {

                    echo '<div class="transport-card">';
                    echo '<img src="' . htmlspecialchars($row["transportImg"]) . '" alt="' . htmlspecialchars($row["transportName"]) . '">';
                    echo '<h3>' . htmlspecialchars($row["transportName"]) . '</h3>';
                    echo '<p>' . htmlspecialchars($row["typeDescription"]) . '</p>';
                    echo '<p> Transport ID : ' . htmlspecialchars($row["transportID"]) . '</p>';
                    echo '<p> RM ' . number_format($row["transportPrice"], 2) . ' per person</p>';
                    echo '<form method="post" action="cart_action.php?action=add&id=' . htmlspecialchars($row['transportID']) . '&category=transport">
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="999"/>
                    <button type="submit"><i class="fa fa-shopping-cart" style="font-size:20px"></i></button>
                    </form>';
                    echo '</form>';
                    echo '<br></div>';
                }
            } else {
                echo "No transport found.";
            }
            // Free result set
            mysqli_free_result($result);
            // Close connection
            mysqli_close($conn);
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
