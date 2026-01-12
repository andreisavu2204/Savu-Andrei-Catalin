<?php
session_start();

// Dacă nu este logat, redirect la login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit;
}

// Dacă există redirect în URL, duce la pachetul respectiv
$redirect_to = $_GET['redirect'] ?? '';
if (in_array($redirect_to, ['standard', 'plus', 'max'])) {
    $package_page = $redirect_to . '_package.html';
    header("Location: $package_page");
    exit;
}

// Dacă nu există redirect, duce la standard_package.html
header("Location: standard_package.html");
exit;
?>
