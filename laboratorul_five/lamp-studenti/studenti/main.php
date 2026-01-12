<?php
require 'db.php';
$task = $_POST['task'] ?? '';
$deadline = $_POST['deadline'] ?? '';
header('Content-Type: application/json');
if (!empty($task) && !empty($deadline)) {
	$stmt = $pdo->prepare("INSERT INTO Tasks (Description, DueDate) VALUES (?, ?)");
	$stmt->execute([$task, $deadline]);
	header("Location: main.html?success");
} else {
	header("Location: login.html");
}
?>