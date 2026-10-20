<?php
session_start();
include("config/config.php");

// Function to fetch and display details
function fetchDetails($conn, $bookingID, $detailsTable, $mainTable, $columns, $nameField, $type) {
    $sql = "SELECT $columns, $mainTable.$nameField AS Name 
            FROM $detailsTable 
            JOIN $mainTable 
            ON $detailsTable.$type" . "ID = $mainTable." . $type . "ID 
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Order History Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="includes/modalAuth.js"></script>
</head>

<body>
    <header></header>
    <?php include("includes/userNav.php"); ?>
    <div class="container">
        <?php
        include("includes/topNav.php");
        include("userAuth/modalForm.php");

        if (!isset($_SESSION["UID"])) {
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        openLoginPopup();
                    });
                  </script>';
            exit;
        } else {
            $userID = $_SESSION["UID"];
        }
        ?>
        <div class="section">
            <p style="margin: 15px;"><i class="fa fa-shopping-cart" style="font-size:24px"></i> / My Order</p>

            <?php
            $sql = "SELECT bookingID, bookingDate, bookingAmount 
                    FROM booking 
                    WHERE bookerID = '$userID' 
                    ORDER BY bookingID DESC";
            $result1 = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result1) > 0) {
                while ($row1 = mysqli_fetch_assoc($result1)) {
                    $bookingID = $row1["bookingID"];
            ?>
                    <table cellpadding="10" cellspacing="1" id="blogtable3" width="100%" style="margin: 20px auto; border: 1px solid #ccc;">
                        <thead>
                            <tr style="background-color: #f2f2f2;">
                                <th colspan="4">Booking ID: <?php echo $bookingID; ?></th>
                            </tr>
                            <tr>
                                <th>Order Date</th>
                                <th>Total Amount (RM)</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align:left;"><?php echo date("d/m/Y", strtotime($row1["bookingDate"])); ?></td>
                                <td style="text-align:left;"><?php echo number_format($row1["bookingAmount"], 2); ?></td>
                                
                                <?php
                                // Check if the booking has been reviewed
                                $reviewCheckQuery = "SELECT reviewID FROM review WHERE bookingID = '$bookingID' AND reviewBy = '$userID'";
                                $reviewCheckResult = mysqli_query($conn, $reviewCheckQuery);

                                if (mysqli_num_rows($reviewCheckResult) > 0) {
                                    // Booking already reviewed
                                    echo '<td colspan="2" style="text-align:left;"><i class="fa fa-check-circle-o"></i> Reviewed</td>';
                                } else {
                                    // Booking not reviewed yet
                                    echo '<td colspan="2" style="text-align:left;"><a href="review.php?bookingID=' . $bookingID . '"><i class="fa fa-comment"></i> Review Booking</a></td>';
                                }
                                ?>
                            </tr>
                            <tr style="background-color: #f9f9f9;">
                                <th>Type</th>
                                <th>Details</th>
                                <th>Quantity</th>
                                <th>Amount (RM)</th>
                            </tr>

                            <?php
                            // Fetch details from each table
                            // Fetch activity details
                            fetchDetails($conn, $bookingID, "activitybookingdetails", "activity", "activitybookingdetails.activityID AS ID, activitybookingdetails.actQuantity AS Quantity, activitybookingdetails.actAmount AS Amount", "activityName", "Activity");

                            // Fetch equipment details
                            fetchDetails($conn, $bookingID, "equipmentbookingdetails", "equipment", "equipmentbookingdetails.equipmentID AS ID, equipmentbookingdetails.equQuantity AS Quantity, equipmentbookingdetails.equAmount AS Amount", "equipmentName", "Equipment");

                            // Fetch accommodation details
                            fetchDetails($conn, $bookingID, "accommodationbookingdetails", "accommodation", "accommodationbookingdetails.accommodationID AS ID, accommodationbookingdetails.accQuantity AS Quantity, accommodationbookingdetails.accAmount AS Amount", "accommodationName", "Accommodation");

                            // Fetch transport details
                            fetchDetails($conn, $bookingID, "transportbookingdetails", "transport", "transportbookingdetails.transportID AS ID, transportbookingdetails.traQuantity AS Quantity, transportbookingdetails.traAmount AS Amount", "transportName", "Transport");

                            // Fetch tour details
                            fetchDetails($conn, $bookingID, "tourbookingdetails", "tour", "tourbookingdetails.tourID AS ID, tourbookingdetails.tourQuantity AS Quantity, tourbookingdetails.tourAmount AS Amount", "tourName", "Tour");

                            ?>
                        </tbody>
                    </table>
            <?php
                }
                mysqli_free_result($result1);
            } else {
                echo "<p style='margin: 15px;'>Your Order is Empty</p>";
            }
            mysqli_close($conn);
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
