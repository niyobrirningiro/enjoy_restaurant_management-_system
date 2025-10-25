<?php
// admin_auth.php
session_start();

function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function requireAdminAuth() {
    if (!isAdminLoggedIn()) {
        header("Location: admin_login.php");
        exit();
    }
}

function getAdminData() {
    if (!isAdminLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['admin_id'],
        'username' => $_SESSION['admin_username']
    ];
}
?>