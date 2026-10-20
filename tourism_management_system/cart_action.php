<?php
session_start();
include("config/config.php");

if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (!empty($_POST["quantity"])) {
                // Get category and product/service ID
                $category = $_GET["category"];
                $serviceID = $_GET["id"];

                // Dynamically determine the table and column names
                $validCategories = ["activity", "equipment", "accommodation", "transport", "tour"];
                if (in_array($category, $validCategories)) {
                    $tableName = $category; // Use the category as the table name
                    $idColumn = "{$category}ID";
                    $nameColumn = "{$category}Name";
                    $priceColumn = "{$category}Price";

                    // Query to get service details
                    $sql = "SELECT * FROM $tableName WHERE $idColumn = '$serviceID'";
                    $result = mysqli_query($conn, $sql);

                    if ($result && $row = mysqli_fetch_assoc($result)) {
                        // Create a unique identifier for the cart item
                        $itemID = "pid_{$category}_" . $row[$idColumn];
                        $itemArray = array(
                            $itemID => array(
                                'name' => $row[$nameColumn],
                                'category' => $category,
                                'serviceID' => $row[$idColumn],
                                'quantity' => $_POST["quantity"],
                                'price' => $row[$priceColumn]
                            )
                        );

                        // Add or update the cart in the session
                        if (!empty($_SESSION["cart_item"])) {
                            if (array_key_exists($itemID, $_SESSION["cart_item"])) {
                                $_SESSION["cart_item"][$itemID]["quantity"] += $_POST["quantity"];
                            } else {
                                $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                            }
                        } else {
                            $_SESSION["cart_item"] = $itemArray;
                        }
                    } else {
                        echo "Error: Service not found!";
                    }
                } else {
                    echo "Error: Invalid service category!";
                }
            }
            break;

        case "remove":
            if (!empty($_SESSION["cart_item"])) {
                $itemID = "pid_" . $_GET["category"] . "_" . $_GET["id"];
                if (isset($_SESSION["cart_item"][$itemID])) {
                    unset($_SESSION["cart_item"][$itemID]);
                    if (empty($_SESSION["cart_item"])) {
                        unset($_SESSION["cart_item"]);
                    }
                }
            }
            break;

        case "empty":
            unset($_SESSION["cart_item"]);
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Booking Cart</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <header></header>
    <?php include("includes/userNav.php"); ?>
    <div class="container">
        <?php include("includes/topNav.php"); ?>
        <div class="section">
            <?php
            if (isset($_SESSION["cart_item"])) {
                $total_price = 0;
                $categories = ["activity", "equipment", "accommodation", "transport", "tour"];
                foreach ($categories as $category) {
                    $category_total = 0;
                    $has_items = false;
            ?>
                    <h3><?php echo strtoupper($category); ?></h3>
                    <table cellpadding="10" cellspacing="1" width="100%">
                        <tr>
                            <th>Item</th>
                            <th>Item ID</th>
                            <th>Quantity</th>
                            <th>Unit Price (RM)</th>
                            <th>Price (RM)</th>
                            <th>Actions</th>
                        </tr>
                        <?php
                        foreach ($_SESSION["cart_item"] as $item) {
                            if ($item["category"] == $category) {
                                $has_items = true;
                                $item_price = $item["quantity"] * $item["price"];
                                $category_total += $item_price;
                        ?>
                                <tr>
                                    <td><?php echo $item["name"]; ?></td>
                                    <td><?php echo $item["serviceID"]; ?></td>
                                    <td><?php echo $item["quantity"]; ?></td>
                                    <td><?php echo number_format($item["price"], 2); ?></td>
                                    <td><?php echo number_format($item_price, 2); ?></td>
                                    <td>
                                        <a href="cart_action.php?action=remove&category=<?php echo $item["category"]; ?>&id=<?php echo $item["serviceID"]; ?>">
                                            <i class="fa fa-times-circle"></i> Remove
                                        </a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        if ($has_items) {
                            $total_price += $category_total;
                        ?>
                            <tr>
                                <td colspan="4" align="right"><b>Subtotal:</b></td>
                                <td colspan="2"><b><?php echo "RM " . number_format($category_total, 2); ?></b></td>
                            </tr>
                        <?php
                        } else {
                            echo "<tr><td colspan='6'>No items in this category.</td></tr>";
                        }
                        ?>
                    </table>
            <?php
                }
            ?>
                <h3>Total: RM <?php echo number_format($total_price, 2); ?></h3>
				<form method="post" action="checkout.php?price=<?php echo $total_price; ?>">
					<input type="hidden" name="tot_price" value="<?php echo $total_price; ?>">
					<td style="text-align:center;"><button type="submit">Checkout</button></td>
				</form>
                <p><a href="cart_action.php?action=empty"><i class="fa fa-trash"></i> Empty Cart</a></p>
                <p><a href="index.php"><i class="fa fa-cart-plus"></i> Continue Shopping</a></p>
            <?php
            } else {
                echo "<p>Your Cart is Empty</p>";
            }
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
