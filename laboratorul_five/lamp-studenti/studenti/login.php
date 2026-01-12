<?php

session_start();

// // Dacă utilizatorul este deja logat, îl trimitem la management.html
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $redirect_to = $_GET['redirect'] ?? '';
    if (in_array($redirect_to, ['standard', 'plus', 'max'])) {
        $package_page = $redirect_to . '_package.html';
        header("Location: $package_page");
    } else {
        header("Location: management.html");
    }
    exit;
}

// 1. Include conexiunea la baza de date
require 'db.php'; // Am schimbat din 'db_config.php' în 'db.php'

// ... restul codului tău de login (care a fost deja validat) ...
// Asigură-te că $redirect_to este setat corect (ex: 'main.html')
// ...

//session_start();

// 1. Include conexiunea la baza de date
//require 'db_config.php'; 

// Preluăm și VALIDĂM datele din formular
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$redirect_to = $_GET['redirect'] ?? $_POST['redirect'] ?? '';

// 2. Verificare simplă (anti-blank)
if (empty($username) || empty($password)) {
    header("Location: login.html"); // Redirecționează înapoi la formular cu parametru de eroare
    exit;
}

// 3. Pregătirea interogării (SQL Injection Protection)
$stmt = $pdo->prepare("SELECT UserID, Password, Type FROM Users WHERE Username = ?");

// 4. Executarea interogării
$stmt->execute([$username]);
$user = $stmt->fetch(); // Extrage rândul utilizatorului

// 5. Verificarea rezultatului
if ($user) {
    // Rândul există, verificăm parola
    $stored_hash = $user['Password'];
    
    // !!! FOARTE IMPORTANT: Verificarea Hash-ului !!!
    if ($password==$stored_hash) {
        
        // --- LOGARE REUȘITĂ ---
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['username'] = $username;

        
        // Verificăm dacă este admin și setăm o variabilă de sesiune
       // $_SESSION['is_admin'] = (bool)$user['is_admin']; 
        
        // Redirecționăm utilizatorul în funcție de redirect
        if (in_array($redirect_to, ['standard', 'plus', 'max'])) {
            $package_page = $redirect_to . '_package.html';
            header("Location: $package_page");
        } else {
            header("Location: management.html");
        }
        exit;
        
    } else {
        // Parolă incorectă
        header("Location: login.html"); // Redirecționează cu parametru de eroare
        exit;
    }
} else {
    // Utilizatorul nu există
    header("Location: login.html"); // Redirecționează cu parametru de eroare
    exit;
}
?>