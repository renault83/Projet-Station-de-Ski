<?php
require 'config.php';

$m = $pdo->query(
    "SELECT temperature, vitesse_vent, humidite, epaisseur_neige, timestamp
     FROM meteo
     ORDER BY timestamp DESC
     LIMIT 1"
)->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Météo</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
<h1><a href="index.html" class="logo">Station de ski</a></h1>
  <nav>
    <a href="index.html">Accueil</a>
    <a href="pistes.php">🎿Pistes</a>
    <a href="remontes.php">🚠Remontées</a>
    <a href="meteo.php">🌤️Météo</a>
    <a href="webcams.php">Webcams</a>
  </nav>
  <a href="login.php">Connexion</a>
</header>

<main>
  <h2>Conditions météo actuelles</h2>

  <?php if ($m): ?>
    <ul>
      <li>🌡️ Température : <?= $m['temperature'] ?> °C</li>
      <li>💨 Vent : <?= $m['vitesse_vent'] ?> km/h</li>
      <li>💧 Humidité : <?= $m['humidite'] ?> %</li>
      <li>❄️ Neige : <?= $m['epaisseur_neige'] ?> cm</li>
      <li>🕒 Relevé du : <?= date('d/m/Y H:i', strtotime($m['timestamp'])) ?></li>
    </ul>
  <?php else: ?>
    <p>Aucune donnée météo disponible.</p>
  <?php endif; ?>
</main>

</body>
</html>
