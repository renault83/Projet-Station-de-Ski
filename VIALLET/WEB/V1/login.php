<?php
session_start();
require 'config.php';

$message = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("
        SELECT id_employe, identifiant, role 
        FROM identifiants 
        WHERE identifiant = ? AND mot_de_passe = ?
    ");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id_employe'];
        $_SESSION['username'] = $user['identifiant'];
        $_SESSION['role'] = $user['role'];

        // Redirection selon le rôle
        switch ($user['role']) {
            case 'directeur':
                header("Location: dashboard_directeur.php");
                break;
            case 'caissier':
                header("Location: dashboard_caissier.php");
                break;
            case 'controleur':
                header("Location: dashboard_controleur.php");
                break;
            case 'technicien':
                header("Location: dashboard_technicien.php");
                break;
            default:
                header("Location: dashboard_utilisateur.php");
        }
        exit;
    } else {
        $message = "Identifiant ou mot de passe incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Station de Ski</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Connexion à la Station de Ski</h2>

    <?php if ($message): ?>
        <p style="color:red;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Identifiant" required><br><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br><br>
        <button type="submit" name="login">Se connecter</button>
    </form>
</body>
</html>
