<?php
function clean($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function redirect($url) {
    header("Location: " . $url);
    exit;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        redirect("/mini_inventory_management_system/auth/login.php");
    }
}

function current_user_id() {
    return $_SESSION['user_id'] ?? null;
}
?>
