<?php
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Adăugăm logica de redirecționare după tipul de pachet dorit
$redirect_to = 'management.html'; // Destinația default

if (isset($_POST['redirect']) && $_POST['redirect'] === 'standard') {
    $redirect_to = 'standard_package.html';
}
// Puteți adăuga și pentru celelalte pachete:
// else if (isset($_POST['redirect']) && $_POST['redirect'] === 'plus') { $redirect_to = 'plus_package.html'; }
// else if (isset($_POST['redirect']) && $_POST['redirect'] === 'max') { $redirect_to = 'max_package.html'; }


if ($username === 'admin' && $password === '1234') {
    // Redirecționare către pagina de pachet dorită
    header("Location: $redirect_to");
    exit;
} else {
    // În caz de eșec
    echo "<h1>Login Rezultat</h1>";
    echo "<h1>Utilizator sau parolă greșită.</h1>";
    echo '<p style="text-align: center;"><a href="document.html" class="arcade-button">Înapoi</a></p>';
}
?>