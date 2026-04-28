<?php
session_start();

// Supprimer toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Déconnexion</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f8;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.box {
    background: white;
    padding: 40px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

a {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background: #2c7be5;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

a:hover {
    background: #1a5dc9;
}
</style>
</head>
<body>

<div class="box">
    <h1>Vous êtes déconnecté</h1>
    <p>Votre session a été fermée avec succès.</p>
    <a href="../index.html">Retour à l'accueil</a>
</div>

</body>
</html>
