<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'directeur') {
    header("Location: login.php");
    exit;
}

// Ajouter une piste
if (isset($_POST['add_piste'])) {
    $stmt = $pdo->prepare("INSERT INTO pistes (nom,niveau,longueur) VALUES (?,?,?)");
    $stmt->execute([$_POST['nom'], $_POST['niveau'], $_POST['longueur']]);
}

// Ajouter une remontée
if (isset($_POST['add_remontes'])) {
    $stmt = $pdo->prepare("INSERT INTO remontes (nom,type,capacite) VALUES (?,?,?)");
    $stmt->execute([$_POST['nom'], $_POST['type'], $_POST['capacite']]);
}

// Modifier état piste
if (isset($_POST['update_piste'])) {
    $stmt = $pdo->prepare("UPDATE pistes SET etat=? WHERE id=?");
    $stmt->execute([$_POST['etat'], $_POST['id']]);
}

// Modifier état remontée
if (isset($_POST['update_remonte'])) {
    $stmt = $pdo->prepare("UPDATE remontes SET etat=? WHERE id=?");
    $stmt->execute([$_POST['etat'], $_POST['id']]);
}

// Supprimer piste/remontée
if (isset($_GET['delete_piste'])) {
    $stmt = $pdo->prepare("DELETE FROM pistes WHERE id=?");
    $stmt->execute([$_GET['delete_piste']]);
}
if (isset($_GET['delete_remontee'])) {
    $stmt = $pdo->prepare("DELETE FROM remontes WHERE id=?");
    $stmt->execute([$_GET['delete_remontee']]);
}

$pistes = $pdo->query("SELECT * FROM pistes")->fetchAll();
$remontes = $pdo->query("SELECT * FROM remontes")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Directeur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Bienvenue Directeur <?php echo htmlspecialchars($_SESSION['username']); ?> !</h1>
    <a href="logout.php">Déconnexion</a>

    <h2>Pistes de ski</h2>
    <form method="post">
        Nom: <input type="text" name="nom" required>
        Niveau: 
        <select name="niveau">
            <option value="vert">Vert</option>
            <option value="bleu">Bleu</option>
            <option value="rouge">Rouge</option>
            <option value="noir">Noir</option>
        </select>
        Longueur (m): <input type="number" name="longueur" required>
        <button type="submit" name="add_piste">Ajouter</button>
    </form>
    <ul>
        <?php foreach($pistes as $piste): ?>
            <li>
                <?php echo "{$piste['nom']} - {$piste['niveau']} - {$piste['longueur']}m - État: {$piste['etat']}"; ?>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $piste['id']; ?>">
                    <select name="etat">
                        <option value="ouverte" <?php if($piste['etat']=='ouverte') echo 'selected'; ?>>Ouverte</option>
                        <option value="fermée" <?php if($piste['etat']=='fermée') echo 'selected'; ?>>Fermée</option>
                        <option value="entretien" <?php if($piste['etat']=='entretien') echo 'selected'; ?>>En entretien</option>
                    </select>
                    <button type="submit" name="update_piste">Modifier État</button>
                </form>
                <a href="?delete_piste=<?php echo $piste['id']; ?>">Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Remontées mécaniques</h2>
    <form method="post">
        Nom: <input type="text" name="nom" required>
        Type: 
        <select name="type">
            <option value="télésiège">Télésiège</option>
            <option value="téléski">Téléski</option>
            <option value="téléphérique">Téléphérique</option>
        </select>
        Capacité: <input type="number" name="capacite" required>
        <button type="submit" name="add_remontee">Ajouter</button>
    </form>
    <ul>
        <?php foreach($remontees as $remontee): ?>
            <li>
                <?php echo "{$remontee['nom']} - {$remontee['type']} - {$remontee['capacite']} pers - État: {$remontee['etat']}"; ?>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $remontee['id']; ?>">
                    <select name="etat">
                        <option value="ouverte" <?php if($remontee['etat']=='ouverte') echo 'selected'; ?>>Ouverte</option>
                        <option value="fermée" <?php if($remontee['etat']=='fermée') echo 'selected'; ?>>Fermée</option>
                        <option value="maintenance" <?php if($remontee['etat']=='maintenance') echo 'selected'; ?>>Maintenance</option>
                    </select>
                    <button type="submit" name="update_remontee">Modifier État</button>
                </form>
                <a href="?delete_remontee=<?php echo $remontee['id']; ?>">Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
