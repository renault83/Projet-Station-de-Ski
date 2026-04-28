<?php
require 'config.php'; // contient la connexion $pdo

try {
    // Préparer et exécuter la requête
    $stmt = $pdo->query("SELECT * FROM `users` WHERE 1");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC); // récupérer tous les résultats
} catch (PDOException $e) {
    die("Erreur SQL : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Liste des utilisateurs</h2>

    <?php if ($users): ?>
        <table>
            <tr>
                <?php 
                // Afficher les noms des colonnes dynamiquement
                foreach (array_keys($users[0]) as $col) {
                    echo "<th>" . htmlspecialchars($col) . "</th>";
                }
                ?>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <?php foreach ($user as $value): ?>
                        <td><?php echo htmlspecialchars($value); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucun utilisateur trouvé.</p>
    <?php endif; ?>
</body>
</html>
