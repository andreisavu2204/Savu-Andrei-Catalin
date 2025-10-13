<?php
$search = $_GET['search'] ?? '';
$games = ['Pac-Man', 'Street Fighter', 'Mortal Kombat', 'Dance Dance Revolution', 'Air Hockey', 'Time Crisis'];

echo "<h1>Rezultate pentru: <em>" . htmlspecialchars($search) . "</em></h1>";

$found = false;
foreach ($games as $game) {
    if (stripos($game, $search) !== false) {
        echo "<p>✅ Joc găsit: <strong>$game</strong></p>";
        $found = true;
    }
}

if (!$found) {
    echo "<p>❌ Niciun joc găsit.</p>";
}

echo '<p><a href="explore.html">Înapoi la căutare</a></p>';
?>
