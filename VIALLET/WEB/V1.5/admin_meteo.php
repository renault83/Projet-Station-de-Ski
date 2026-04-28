<?php
require 'config.php';

/* Sécurité */
if (!isset($_SESSION['directeur'])) {
    header('Location: login.php');
    exit;
}

/* Récupération des données météo */
$releves = $pdo->query(
    "SELECT * FROM meteo ORDER BY timestamp DESC"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Données météo</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f8;
    padding: 30px;
}

h1 { margin-bottom: 5px; }

a { text-decoration: none; }

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    margin-top: 20px;
    border-radius: 6px;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

th {
    background: #e2e8f0;
}

tr:hover {
    background: #f1f5f9;
}
</style>
</head>

<body>

<h1>Données météo</h1>
<p><a href="admin.php">← Retour administration</a></p>

<table>
<tr>
    <th>Date / Heure</th>
    <th>Température (°C)</th>
    <th>Humidité (%)</th>
    <th>Pression (hPa)</th>
    <th>Vent (km/h)</th>
    <th>Direction (°)</th>
    <th>Neige (cm)</th>
</tr>

<?php foreach ($releves as $r): ?>
<tr>
    <td><?= $r['timestamp'] ?></td>
    <td><?= $r['temperature'] ?></td>
    <td><?= $r['humidite'] ?></td>
    <td><?= $r['pression'] ?></td>
    <td><?= $r['vitesse_vent'] ?></td>
    <td><?= $r['direction_vent'] ?></td>
    <td><?= $r['epaisseur_neige'] ?></td>
</tr>
<?php endforeach; ?>

<?php if (empty($releves)): ?>
<tr>
    <td colspan="7">Aucune donnée météo disponible</td>
</tr>
<?php endif; ?>

</table>

</body>
</html>
