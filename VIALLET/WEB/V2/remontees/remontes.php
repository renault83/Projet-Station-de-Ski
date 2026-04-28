<?php
require 'config.php';

/* --- MODE AJAX : renvoie les données en JSON --- */
if (isset($_GET['ajax'])) {
    $stmt = $pdo->query(
        "SELECT 
            nom,
            DATE_FORMAT(heure_ouverture, '%H:%i') AS heure_ouverture,
            DATE_FORMAT(heure_fermeture, '%H:%i') AS heure_fermeture,
            etat
         FROM remontes
         ORDER BY nom"
    );
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Remontées mécaniques</title>
<link rel="icon" type="image/x-icon" href="favicon.svg">

<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <h1><a href="index.php" class="logo">Station de ski</a></h1>
    <nav>
        <a href="../index.html">Accueil</a>
        <a href="pistes.html">🎿 Pistes</a>
        <a href="remontes.html">🚠 Remontées</a>
        <a href="meteo.html">🌤️ Météo</a>
        <a href="webcams.html">Webcams</a>
    </nav>
    <a href="login.php">Connexion</a>
</header>

<main>
    <h2>État des remontées mécaniques</h2>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Ouverture</th>
                <th>Fermeture</th>
                <th>État</th>
            </tr>
        </thead>
        <tbody id="remontees-body">
            <!-- Rempli dynamiquement -->
        </tbody>
    </table>
</main>

<script>
async function chargerRemontees() {
    const response = await fetch('remontes.php?ajax=1');
    const data = await response.json();

    const tbody = document.getElementById('remontees-body');
    tbody.innerHTML = '';

    data.forEach(r => {
        let etatHTML = '';
        if (r.etat === 'ouvert') {
            etatHTML = '<strong style="color: green;">Ouverte</strong>';
        } else if (r.etat === 'ferme') {
            etatHTML = '<strong style="color: red;">Fermée</strong>';
        } else {
            etatHTML = '<strong style="color: orange;">Évacuation</strong>';
        }

        tbody.innerHTML += `
            <tr>
                <td>${r.nom}</td>
                <td>${r.heure_ouverture}</td>
                <td>${r.heure_fermeture}</td>
                <td>${etatHTML}</td>
            </tr>
        `;
    });
}

/* Chargement initial */
chargerRemontees();

/* Actualisation */
setInterval(chargerRemontees, 1000);
</script>

</body>
</html>