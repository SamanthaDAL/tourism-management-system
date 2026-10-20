<?php
//include db config
session_start();
include("config/config.php");

// Check for category filter
if (isset($_GET['cat']) && ($_GET['cat'] != '0')) {
    $categoryID = $_GET['cat'];
    // Query to fetch activities and their category description
    $sql_activity = "
        SELECT 
            activity.*, 
            category.categoryDescription 
        FROM 
            activity 
        LEFT JOIN 
            category 
        ON 
            activity.categoryID = category.categoryID 
        WHERE 
            activity.categoryID = $categoryID";
} else {
    // Fetch all activities and their category description
    $sql_activity = "
        SELECT 
            activity.*, 
            category.categoryDescription 
        FROM 
            activity 
        LEFT JOIN 
            category 
        ON 
            activity.categoryID = category.categoryID";
}

$result = mysqli_query($conn, $sql_activity);
$rowcount = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Activity Booking Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .activity-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin: 20px;
        }

        .activity-card {
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            background-color: #fff;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .activity-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .activity-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .activity-card h3 {
            font-size: 1.2em;
            margin: 10px 0;
            color: #333;
        }

        .activity-card p {
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
        <h2 style="text-align: center;">Activity Booking</h2>
        <div class="section">
            <table border="1" align="center">
                <tr>
                    <?php
                    // Fetch categories from the database
                    $sql_categories = "SELECT * FROM category";
                    $result_categories = mysqli_query($conn, $sql_categories);

                    // Display the "All" category first
                    echo '<td><a href="activity.php?cat=0" style="text-decoration: none;">All</a></td>';

                    // Loop through each category
                    if (mysqli_num_rows($result_categories) > 0) {
                        while ($category = mysqli_fetch_assoc($result_categories)) {
                            echo '<td><a href="activity.php?cat=' . $category['categoryID'] . '" style="text-decoration: none;">' . htmlspecialchars($category['categoryName']) . '</a></td>';
                        }
                    } else {
                        echo '<td>No categories available</td>';
                    }

                    // Free result set
                    mysqli_free_result($result_categories);
                    ?>
                </tr>
            </table>
        </div>

        <div class="activity-container">
            <?php
            if ($rowcount > 0) {
                // Fetch all activitys into an array to determine the last 5 activitys
                $allActivitys = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $allActivitys[] = $row;
                }

                // Loop through activitys and generate HTML
                foreach ($allActivitys as $index => $row) {
                    $minQuantity = $row["min_quantity"] ?? 1; // Default to 1 if min_quantity is not set
                    $maxQuantity = $row["max_quantity"] ?? 10; // Default to 10 if max_quantity is not set

                    echo '<div class="activity-card">';
                    echo '<img src="' . htmlspecialchars($row["activityImg"]) . '" alt="' . htmlspecialchars($row["activityName"]) . '">';
                    echo '<h3>' . htmlspecialchars($row["activityName"]) . '</h3>';
                    echo '<p>' . htmlspecialchars($row["categoryDescription"]) . '</p>';
                    echo '<p> Activity ID : ' . htmlspecialchars($row["activityID"]) . '</p>';
                    echo '<p> RM ' . number_format($row["activityPrice"], 2) . ' per person</p>';

                    echo '<form method="post" action="cart_action.php?action=add&id=' . htmlspecialchars($row['activityID']) . '&category=activity">';

             
                        echo '<input 
                                type="number"
                                id="quantity" 
                                name="quantity" 
                                value="' . $minQuantity . '" 
                                min="' . $minQuantity . '" 
                                max="' . $maxQuantity . '" 
                                required 
                              />';
                  

                    echo '<button type="submit"><i class="fa fa-shopping-cart" style="font-size:20px"></i></button>';
                    echo '</form>';
                    echo '<br></div>';
                }
            } else {
                echo "No activity found.";
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
