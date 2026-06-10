<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/helpers.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mini Inventory Management System</title>
    <link rel="stylesheet" href="/mini_inventory_management_system/assets/css/style.css">
</head>
<body>
<div class="layout">
