<?php require_once __DIR__ . '/config.php';
$m = $pdo->query("SELECT * FROM meteo ORDER BY timestamp DESC LIMIT 1")->fetch();
?>
<!DOCTYPE html><html><head>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="style.css"></head><body>
<header><h1>Météo</h1></header>
<div class="container"><div class="card">
<p>Température : <?= $m['temperature'] ?> °C</p>
<p>Vent : <?= $m['vitesse_vent'] ?> km/h</p>
<p>Neige : <?= $m['epaisseur_neige'] ?> cm</p>
</div></div></body></html>