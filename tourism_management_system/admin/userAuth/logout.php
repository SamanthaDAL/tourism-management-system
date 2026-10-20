<?php
session_start();
include('C:/xampp/htdocs/tourism_management_system/config/config.php');

if(isset($_SESSION["UID"])){
	echo '<script type="text/javascript">		
			alert("Logout successful!");
	</script>';
	unset($_SESSION["UID"]);
	unset($_SESSION["userName"]);	
	echo '<script type="text/javascript">
			window.location.href = "' . ADMIN_BASE_URL . 'index.php";
    </script>';
	//header('Location: ' . BASE_URL . 'index.php');
}	
?>