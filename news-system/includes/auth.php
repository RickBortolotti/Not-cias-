<?php
session_start();

function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /admin/login.php');
        exit;
    }
}
?>
