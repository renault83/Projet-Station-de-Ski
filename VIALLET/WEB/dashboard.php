<?php
require 'config.php';
require 'securite.php';
$nbPistes = $pdo->query("SELECT COUNT(*) FROM pistes")->fetchColumn();
$nbRemontes = $pdo->query("SELECT COUNT(*) FROM remontes")->fetchColumn();
$nbPistesOuvertes = $pdo->query("SELECT COUNT(*) FROM pistes WHERE etat='ouvert'")->fetchColumn();
$nbRemontesOuvertes = $pdo->query("SELECT COUNT(*) FROM remontes WHERE etat='ouvert'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Directeur</title>

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>🎿 Dashboard Directeur</h1>
</header>

<div class="container">

    <!-- Cartes statistiques -->
    <section class="dashboard-grid">
        <div class="dashboard-card">
            <h3>Total pistes</h3>
            <div class="dashboard-number"><?= $nbPistes ?></div>
            <span><?= $nbPistesOuvertes ?> ouvertes</span>
        </div>

        <div class="dashboard-card">
            <h3>Total remontées</h3>
            <div class="dashboard-number"><?= $nbRemontes ?></div>
            <span><?= $nbRemontesOuvertes ?> ouvertes</span>
        </div>
    </section>

    <!-- Actions -->
    <section class="dashboard-actions">
        <a href="gerer_pistes.php" class="action-card">🏂 Gérer les pistes</a>
        <a href="gerer_remontes.php" class="action-card">🚠 Gérer les remontées</a>
        <a href="ajouter_piste.php" class="action-card">➕ Ajouter une piste</a>
        <a href="ajouter_remonte.php" class="action-card">➕ Ajouter une remontée</a>
    </section>

</div>

</body>
</html>
