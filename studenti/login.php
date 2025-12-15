<?php
session_start();

// 1. Include conexiunea la baza de date
require 'db_config.php'; 

// Preluăm și VALIDĂM datele din formular
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$redirect_to = $_POST['redirect'] ?? 'management.html';

// 2. Verificare simplă (anti-blank)
if (empty($username) || empty($password)) {
    $_SESSION['login_error'] = "Te rog introdu numele de utilizator și parola.";
    header("Location: index.php"); // Redirecționează înapoi la formular
    exit;
}

// 3. Pregătirea interogării (SQL Injection Protection)
$stmt = $pdo->prepare("SELECT id, password_hash, is_admin FROM users WHERE username = ?");

// 4. Executarea interogării
$stmt->execute([$username]);
$user = $stmt->fetch(); // Extrage rândul utilizatorului

// 5. Verificarea rezultatului
if ($user) {
    // Rândul există, verificăm parola
    $stored_hash = $user['password_hash'];
    
    // !!! FOARTE IMPORTANT: Verificarea Hash-ului !!!
    if (password_verify($password, $stored_hash)) {
        
        // --- LOGARE REUȘITĂ ---
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        
        // Verificăm dacă este admin și setăm o variabilă de sesiune
        $_SESSION['is_admin'] = (bool)$user['is_admin']; 
        
        // Redirecționăm utilizatorul
        header("Location: $redirect_to");
        exit;
        
    } else {
        // Parolă incorectă
        $_SESSION['login_error'] = "Nume de utilizator sau parolă incorectă.";
        header("Location: index.php"); 
        exit;
    }
} else {
    // Utilizatorul nu există
    $_SESSION['login_error'] = "Nume de utilizator sau parolă incorectă.";
    header("Location: index.php"); 
    exit;
}
?>