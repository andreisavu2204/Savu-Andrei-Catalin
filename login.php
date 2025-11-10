<?php
session_start();

// Preluăm datele din formular
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$redirect_to = $_POST['redirect'] ?? 'management.html';

// Setăm sesiunea ca fiind logată, indiferent de date
$_SESSION['loggedin'] = true;
$_SESSION['username'] = $username ?: 'Guest';

// Redirecționăm utilizatorul
header("Location: $redirect_to");
exit;
?>
