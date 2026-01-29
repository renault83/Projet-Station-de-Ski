<?php require_once __DIR__ . '/config.php';
$meteo = $pdo->query("SELECT * FROM meteo ORDER BY timestamp DESC LIMIT 1")->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<title>Station de ski</title>
</head>
<body>
<header>
<h1>Station de ski</h1>
<p>Conditions en temps réel</p>
</header>
<nav>
<a href="index.php">Accueil</a>
<a href="pistes.php">Pistes</a>
<a href="remontes.php">Remontées</a>
<a href="login.php">Directeur</a>
</nav>


<div class="container">
<div class="grid">


<div class="card">
<h2>Météo actuelle</h2>
<div class="weather-main"><?= $meteo['temperature'] ?> °C</div>
<div class="weather-line"><span>Vent</span><span><?= $meteo['vitesse_vent'] ?> km/h</span></div>
<div class="weather-line"><span>Humidité</span><span><?= $meteo['humidite'] ?> %</span></div>
<div class="weather-line"><span>Neige</span><span><?= $meteo['epaisseur_neige'] ?> cm</span></div>
<p><small>Relevé : <?= $meteo['timestamp'] ?></small></p>
</div>


<div class="card">
<h2>Infos station</h2>
<p>✔ Accès aux pistes en direct</p>
<p>✔ Sécurité et météo surveillées</p>
<p>✔ Données mises à jour automatiquement</p>
</div>


</div>
</div>
</body>
</html>
```php
<?php require_once __DIR__ . '/config.php';
$meteo = $pdo->query("SELECT * FROM meteo ORDER BY timestamp DESC LIMIT 1")->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<title>Station de ski</title>
</head>
<body>
<header><h1>Station de ski</h1></header>
<nav>
<a href="index.php">Accueil</a>
<a href="pistes.php">Pistes</a>
<a href="remontes.php">Remontées</a>
<a href="login.php">Directeur</a>
</nav>
<div class="container">


<div class="card">
<h2>Météo actuelle</h2>
<p>Température : <strong><?= $meteo['temperature'] ?> °C</strong></p>
<p>Vent : <strong><?= $meteo['vitesse_vent'] ?> km/h</strong></p>
<p>Humidité : <strong><?= $meteo['humidite'] ?> %</strong></p>
<p>Neige : <strong><?= $meteo['epaisseur_neige'] ?> cm</strong></p>
<p>Relevé du : <?= $meteo['timestamp'] ?></p>
</div>


<div class="card">
<h2>Bienvenue</h2>
<p>Consultez en temps réel la météo, l'état des pistes et des remontées mécaniques.</p>
</div>


</div>
</body>
</body></html>