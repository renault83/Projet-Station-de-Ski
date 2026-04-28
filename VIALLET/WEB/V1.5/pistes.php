<?php
require 'config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Pistes</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
<h1><a href="index.html" class="logo">Station de ski</a></h1>
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
  <h2>État des pistes</h2>

  <table>
    <thead>
      <tr>
        <th>Nom</th>
        <th>Difficulté</th>
        <th>État</th>
      </tr>
    </thead>
    <tbody id="pistes-body">
      <!-- rempli dynamiquement -->
    </tbody>
  </table>
</main>

<script>
function chargerPistes() {
    fetch('pistes_live.php')
        .then(res => res.json())
        .then(data => {
            let html = '';
            data.forEach(p => {
                html += `
                <tr>
                    <td>${p.nom}</td>
                    <td>${p.difficulte.charAt(0).toUpperCase() + p.difficulte.slice(1)}</td>
                    <td>
                        <strong style="color:${p.etat === 'ouvert' ? 'green' : 'red'}">
                            ${p.etat === 'ouvert' ? 'Ouverte' : 'Fermée'}
                        </strong>
                    </td>
                </tr>`;
            });
            document.getElementById('pistes-body').innerHTML = html;
        });
}

/* chargement initial */
chargerPistes();

/* actualisation toutes les 10 secondes */
setInterval(chargerPistes, 10);
</script>

</body>
</html>
