<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$pistes = $pdo->query("SELECT * FROM pistes")->fetchAll();
$remontees = $pdo->query("SELECT * FROM remontees")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Station de Ski - Tableau de bord</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> !</h1>
    <a href="logout.php">Déconnexion</a>

    <h2>Pistes de ski</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Nom</th>
            <th>Niveau</th>
            <th>Longueur (m)</th>
            <th>État</th>
        </tr>
        <?php foreach($pistes as $piste): ?>
            <tr>
                <td><?php echo htmlspecialchars($piste['nom']); ?></td>
                <td><?php echo htmlspecialchars($piste['niveau']); ?></td>
                <td><?php echo htmlspecialchars($piste['longueur']); ?></td>
                <td>
                    <?php 
                        if($piste['etat'] == 'ouverte') echo '🟢 Ouverte';
                        elseif($piste['etat'] == 'fermée') echo '🔴 Fermée';
                        else echo '🟡 En entretien';
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Remontées mécaniques</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Nom</th>
            <th>Type</th>
            <th>Capacité</th>
            <th>État</th>
        </tr>
        <?php foreach($remontees as $remontee): ?>
            <tr>
                <td><?php echo htmlspecialchars($remontee['nom']); ?></td>
                <td><?php echo htmlspecialchars($remontee['type']); ?></td>
                <td><?php echo htmlspecialchars($remontee['capacite']); ?></td>
                <td>
                    <?php 
                        if($remontee['etat'] == 'ouverte') echo '🟢 Ouverte';
                        elseif($remontee['etat'] == 'fermée') echo '🔴 Fermée';
                        else echo '🟡 Maintenance';
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
