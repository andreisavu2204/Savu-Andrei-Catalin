<?php
$name = $_POST['name'] ?? 'Anonim';
$message = $_POST['message'] ?? '';

echo "<h1>Mulțumim, " . htmlspecialchars($name) . "!</h1>";
echo "<p>Ai trimis următorul mesaj:</p>";
echo "<blockquote>" . nl2br(htmlspecialchars($message)) . "</blockquote>";

echo '<p><a href="main.html">Trimite alt mesaj</a></p>';
?>
