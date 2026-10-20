<div class="usernav">

    <!-- Logo -->
    <div class="logo-container">
        <a href="<?php echo ADMIN_BASE_URL; ?>">
        <img src="<?php echo ADMIN_BASE_URL; ?>img/logo.png" alt="Logo" class="logo">
        </a>
    </div>
   <!-- User Links -->
<div class="user-links">
    <?php if (isset($_SESSION["UID"])) { ?>
        <span>Welcome,<br><b><?php echo $_SESSION["userName"]; ?></b></span>
        <a href="<?php echo ADMIN_BASE_URL; ?>userAuth/logout.php" class="logout-button" title="Logout">
            <i class="fa fa-sign-out" style="font-size:24px;" alt="Logout"></i>
        </a>
    <?php } else { ?>
        <a href="javascript:void(0);" onclick="openLoginPopup()" class="logout-button">
            <i class="fa fa-sign-in" style="font-size:24px;" title="Login"></i>
        </a>
    <?php } ?>
</div>

</div>