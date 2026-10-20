<?php
session_start();
include("config/config.php");

// Check login
if (!isset($_SESSION["UID"])) {
    header("location:userAuth/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Checkout Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <header></header>
    <?php
    include("includes/userNav.php");
    ?>
    <div class="container">
        <?php
        include("includes/topNav.php");
        ?>
        <p style="margin: 15px;"><i class="fa fa-shopping-cart" style="font-size:24px"></i> / Checkout Information</p>
        <div class="section">
            <?php
            if (!empty($_GET["price"])) {
                $order_amt = $_GET["price"];
                $order_status = 1; // 1= New, 2=Process, 3= Completed

                // Insert into booking table
                $sql = "INSERT INTO booking (bookerID, bookingAmount)
                        VALUES ('" . $_SESSION["UID"] . "','" . $order_amt . "')";

                if (mysqli_query($conn, $sql)) {
                    echo "<p>&nbsp;&nbsp;&nbsp;&nbsp; New booking record has the booking ID: " . mysqli_insert_id($conn) . "</p>";
                    $booking_id = mysqli_insert_id($conn);
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }

                // Insert into category-specific booking detail tables
                foreach ($_SESSION["cart_item"] as $item) {
                    switch ($item["category"]) {
                        case "activity":
                            $sql2 = "INSERT INTO activitybookingdetails (bookingID, activityID, actQuantity, actAmount)
                                     VALUES ('" . $booking_id . "','" . $item["serviceID"] . "','" . $item["quantity"] . "','" . ($item["quantity"] * $item["price"]) . "')";
                            break;
                        case "equipment":
                            $sql2 = "INSERT INTO equipmentbookingdetails (bookingID, equipmentID, equQuantity, equAmount)
                                     VALUES ('" . $booking_id . "','" . $item["serviceID"] . "','" . $item["quantity"] . "','" . ($item["quantity"] * $item["price"]) . "')";
                            break;
                        case "accommodation":
                            $sql2 = "INSERT INTO accommodationbookingdetails (bookingID, accommodationID, accQuantity, accAmount)
                                     VALUES ('" . $booking_id . "','" . $item["serviceID"] . "','" . $item["quantity"] . "','" . ($item["quantity"] * $item["price"]) . "')";
                            break;
                        case "transport":
                            $sql2 = "INSERT INTO transportbookingdetails (bookingID, transportID, traQuantity, traAmount)
                                     VALUES ('" . $booking_id . "','" . $item["serviceID"] . "','" . $item["quantity"] . "','" . ($item["quantity"] * $item["price"]) . "')";
                            break;
                        case "tour":
                            $sql2 = "INSERT INTO tourbookingdetails (bookingID, tourID, tourQuantity, tourAmount)
                                     VALUES ('" . $booking_id . "','" . $item["serviceID"] . "','" . $item["quantity"] . "','" . ($item["quantity"] * $item["price"]) . "')";
                            break;
                        default:
                            continue 2; // Skip if category is invalid
                    }

                    if (mysqli_query($conn, $sql2)) {
                        echo "<p>&nbsp;&nbsp;&nbsp;&nbsp; Booking detail record for " . ucfirst($item["category"]) . " has been added.</p><br>";
                    } else {
                        echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
                    }

                    // Update the quantity of each item in its respective table
                    $update_sql = "";
                    switch ($item["category"]) {
                        case "equipment":
                            $update_sql = "UPDATE equipment SET equipmentQuantity = equipmentQuantity - " . $item["quantity"] . " WHERE equipmentID = " . $item["serviceID"];
                            break;
                    }

                    if ($update_sql != "" && !mysqli_query($conn, $update_sql)) {
                        echo "Error updating item quantity: " . mysqli_error($conn);
                    }
                }
            }
            mysqli_close($conn);
            unset($_SESSION["cart_item"]); // Unset cart
            ?>
        </div>
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
