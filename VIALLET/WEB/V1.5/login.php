<?php
require 'config.php';

if ($_POST) {
    $stmt = $pdo->prepare(
        "SELECT * FROM identifiants 
         WHERE identifiant = ? AND mot_de_passe = ? AND role = 'directeur'"
    );
    $stmt->execute([$_POST['login'], $_POST['password']]);

    if ($stmt->fetch()) {
        $_SESSION['directeur'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $erreur = "Identifiants incorrects";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Connexion directeur</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <h1>Station de ski</h1>
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
    <h2>Connexion directeur</h2>

    <form method="post">
        <input name="login" placeholder="Identifiant" required>
        <input name="password" type="password" placeholder="Mot de passe" required>
        <button type="submit">Connexion</button>
    </form>

    <?php if (isset($erreur)): ?>
        <p style="color:red; font-weight:bold;"><?= $erreur ?></p>
    <?php endif; ?>
</main>

</body>
</html>