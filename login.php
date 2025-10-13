<?php
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === 'admin' && $password === '1234') {
    echo "<h1>Autentificare reușită!</h1>";
} else {
    echo "<h1>Utilizator sau parolă greșită.</h1>";
}
echo '<p><a href="document.html">Înapoi</a></p>';
?>
