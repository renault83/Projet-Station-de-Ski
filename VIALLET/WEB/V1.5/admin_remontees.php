<?php
require 'config.php';

/* Sécurité */
if (!isset($_SESSION['directeur'])) {
    header('Location: login.php');
    exit;
}

/* =========================
   Mise à jour (état + horaires)
   ========================= */
if (
    isset(
        $_POST['id_remonte'],
        $_POST['etat'],
        $_POST['heure_ouverture'],
        $_POST['heure_fermeture']
    )
) {
    $stmt = $pdo->prepare(
        "UPDATE remontes
         SET etat = ?, heure_ouverture = ?, heure_fermeture = ?
         WHERE id_remonte = ?"
    );
    $stmt->execute([
        $_POST['etat'],
        $_POST['heure_ouverture'],
        $_POST['heure_fermeture'],
        $_POST['id_remonte']
    ]);
    header('Location: admin_remontees.php');
    exit;
}

/* =========================
   Suppression
   ========================= */
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare(
        "DELETE FROM remontes WHERE id_remonte = ?"
    );
    $stmt->execute([$_GET['delete']]);
    header('Location: admin_remontees.php');
    exit;
}

/* =========================
   Ajout
   ========================= */
if (isset($_POST['ajout'])) {
    $stmt = $pdo->prepare(
        "INSERT INTO remontes (nom, heure_ouverture, heure_fermeture, etat)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->execute([
        $_POST['nom'],
        $_POST['heure_ouverture'],
        $_POST['heure_fermeture'],
        $_POST['etat']
    ]);
}

/* =========================
   Récupération
   ========================= */
$remontees = $pdo->query(
    "SELECT * FROM remontes ORDER BY nom"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des remontées</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f8;
    padding: 30px;
}

h1 { margin-bottom: 10px; }

a { text-decoration: none; }

/* Cartes */
form, table {
    background: white;
    padding: 20px;
    margin-bottom: 30px;
    border-radius: 8px;
}

/* Tableau */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

th {
    background: #e2e8f0;
}

/* États */
.status-ouvert { color: green; font-weight: bold; }
.status-ferme { color: red; font-weight: bold; }
.status-evac { color: orange; font-weight: bold; }

/* Inputs */
input, select {
    padding: 7px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

/* Boutons */
button {
    padding: 7px 14px;
    border-radius: 6px;
    border: none;
    font-weight: bold;
    cursor: pointer;
}

.btn-primary {
    background: #2563eb;
    color: white;
}

.btn-primary:hover {
    background: #1d4ed8;
}

.btn-success {
    background: #16a34a;
    color: white;
}

.btn-success:hover {
    background: #15803d;
}

.actions a {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    background: #dc2626;
    color: white;
    font-weight: bold;
}

.actions a:hover {
    background: #b91c1c;
}
</style>
</head>

<body>

<h1>Gestion des remontées</h1>
<p><a href="admin.php">← Retour administration</a></p>

<!-- =========================
     Ajout remontée
     ========================= -->
<form method="post">
    <h2>Ajouter une remontée</h2>

    <input name="nom" placeholder="Nom" required>
    <input type="time" name="heure_ouverture" required>
    <input type="time" name="heure_fermeture" required>

    <select name="etat">
        <option value="ouvert">Ouverte</option>
        <option value="ferme">Fermée</option>
        <option value="en_evacuation">Évacuation</option>
    </select>

    <button class="btn-primary" name="ajout" value="1">Ajouter</button>
</form>

<!-- =========================
     Tableau remontées
     ========================= -->
<table>
<tr>
    <th>Nom</th>
    <th>Ouverture</th>
    <th>Fermeture</th>
    <th>État</th>
    <th>Modifier</th>
    <th>Action</th>
</tr>

<?php foreach ($remontees as $r): ?>
<tr>
<form method="post">
    <td><?= htmlspecialchars($r['nom']) ?></td>

    <td>
        <input type="time"
               name="heure_ouverture"
               value="<?= $r['heure_ouverture'] ?>"
               required>
    </td>

    <td>
        <input type="time"
               name="heure_fermeture"
               value="<?= $r['heure_fermeture'] ?>"
               required>
    </td>

    <td>
        <?php
        if ($r['etat'] === 'ouvert')
            echo '<span class="status-ouvert">Ouverte</span>';
        elseif ($r['etat'] === 'ferme')
            echo '<span class="status-ferme">Fermée</span>';
        else
            echo '<span class="status-evac">Évacuation</span>';
        ?>
    </td>

    <td>
        <input type="hidden" name="id_remonte" value="<?= $r['id_remonte'] ?>">

        <select name="etat">
            <option value="ouvert" <?= $r['etat']=='ouvert'?'selected':'' ?>>Ouverte</option>
            <option value="ferme" <?= $r['etat']=='ferme'?'selected':'' ?>>Fermée</option>
            <option value="en_evacuation" <?= $r['etat']=='en_evacuation'?'selected':'' ?>>Évacuation</option>
        </select>

        <button class="btn-success">OK</button>
    </td>

    <td class="actions">
        <a href="?delete=<?= $r['id_remonte'] ?>"
           onclick="return confirm('Supprimer cette remontée ?')">
           Supprimer
        </a>
    </td>
</form>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
