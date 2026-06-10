<?php
session_start();
session_destroy();
header("Location: /mini_inventory_management_system/auth/login.php");
exit;
?>
