<?php
require 'config.php';

/* Sécurité */
if (!isset($_SESSION['directeur'])) {
    header('Location: login.php');
    exit;
}

/* Changement d'état */
if (isset($_GET['toggle'])) {
    $stmt = $pdo->prepare(
        "UPDATE pistes
         SET etat = IF(etat='ouvert','ferme','ouvert')
         WHERE id_piste = ?"
    );
    $stmt->execute([$_GET['toggle']]);
    header('Location: admin_pistes.php');
    exit;
}

/* Suppression */
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM pistes WHERE id_piste = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: admin_pistes.php');
    exit;
}

/* Ajout */
if (!empty($_POST)) {
    $stmt = $pdo->prepare(
        "INSERT INTO pistes (nom, difficulte, etat)
         VALUES (?, ?, ?)"
    );
    $stmt->execute([
        $_POST['nom'],
        $_POST['difficulte'],
        $_POST['etat']
    ]);
}

/* Récupération */
$pistes = $pdo->query("SELECT * FROM pistes ORDER BY nom")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des pistes</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f8;
    padding: 30px;
}

h1 { margin-bottom: 5px; }

a { text-decoration: none; }

form, table {
    background: white;
    padding: 20px;
    margin-bottom: 30px;
    border-radius: 6px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

th {
    background: #e2e8f0;
    text-align: left;
}

.status-ouvert {
    color: green;
    font-weight: bold;
}

.status-ferme {
    color: red;
    font-weight: bold;
}

.actions a {
    margin-right: 10px;
    font-weight: bold;
}

.btn-toggle {
    padding: 6px 12px;
    border-radius: 20px;
    color: white;
    font-size: 14px;
}

.btn-open {
    background: green;
}

.btn-close {
    background: #d32f2f;
}

.btn-delete {
    color: red;
}
</style>
</head>

<body>

<h1>Gestion des pistes</h1>
<p><a href="admin.php">← Retour administration</a></p>

<!-- Ajout piste -->
<form method="post">
    <h2>Ajouter une piste</h2>

    <input name="nom" placeholder="Nom de la piste" required>

    <select name="difficulte" required>
        <option value="">Difficulté</option>
        <option value="verte">Verte</option>
        <option value="bleue">Bleue</option>
        <option value="rouge">Rouge</option>
        <option value="noire">Noire</option>
    </select>

    <select name="etat">
        <option value="ouvert">Ouverte</option>
        <option value="ferme">Fermée</option>
    </select>

    <button>Ajouter</button>
</form>

<!-- Liste pistes -->
<table>
<tr>
    <th>Nom</th>
    <th>Difficulté</th>
    <th>État</th>
    <th>Actions</th>
</tr>

<?php foreach ($pistes as $piste): ?>
<tr>
    <td><?= htmlspecialchars($piste['nom']) ?></td>
    <td><?= ucfirst($piste['difficulte']) ?></td>
    <td>
        <?php if ($piste['etat'] === 'ouvert'): ?>
            <span class="status-ouvert">Ouverte</span>
        <?php else: ?>
            <span class="status-ferme">Fermée</span>
        <?php endif; ?>
    </td>
    <td class="actions">
        <a class="btn-toggle <?= $piste['etat']==='ouvert' ? 'btn-close' : 'btn-open' ?>"
           href="?toggle=<?= $piste['id_piste'] ?>">
           <?= $piste['etat']==='ouvert' ? 'Fermer' : 'Ouvrir' ?>
        </a>

        <a class="btn-delete"
           href="?delete=<?= $piste['id_piste'] ?>"
           onclick="return confirm('Supprimer cette piste ?')">
           Supprimer
        </a>
    </td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
