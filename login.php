<?php
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$redirect_to = $_POST['redirect'] ?? 'management.html';

// Exemplu de utilizatori (într-un proiect real folosești DB)
$valid_users = [
    'admin' => '1234',
    'user' => 'password'
];

if(isset($valid_users[$username]) && $valid_users[$username] === $password){
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;

    header("Location: $redirect_to");
    exit;
} else {
    echo "<h1 style='text-align:center;'>Login eșuat</h1>";
    echo "<p style='text-align:center;'>Username sau parolă greșită.</p>";
    echo '<p style="text-align:center;"><a href="login.html" class="arcade-button">Înapoi</a></p>';
}
?>
