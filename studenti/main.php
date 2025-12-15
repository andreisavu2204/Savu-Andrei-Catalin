<?php
$name = $_POST['name'] ?? 'Anonim';
$message = $_POST['message'] ?? '';

echo "<h1>Mulțumim, " . htmlspecialchars($name) . "!</h1>";
echo "<p>Ai trimis următorul mesaj:</p>";
echo "<blockquote>" . nl2br(htmlspecialchars($message)) . "</blockquote>";

echo '<p style="text-align: center;"><a href="main.html" class="arcade-button">Trimite alt mesaj</a></p>';
?>