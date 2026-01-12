<?php
session_start();
require 'db.php';

// Verifică dacă utilizatorul este logat
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit;
}

// Selectează task-urile din baza de date
$stmt = $pdo->prepare("SELECT Description, DueDate FROM Tasks ORDER BY DueDate ASC");
$stmt->execute();
$tasks = $stmt->fetchAll();

// Trimite datele către calendar.html ca JSON (pentru fetch/ajax)
header('Content-Type: application/json');
echo json_encode($tasks);
exit;
?>
