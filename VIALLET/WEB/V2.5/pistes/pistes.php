<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Pistes</title>
<link rel="icon" type="image/x-icon" href="favicon.svg">
<link rel="stylesheet" href="style.css">

</head>

<body>
<header>
  <h1><a href="index.php" class="logo">Station de ski</a></h1>
  <nav>
    <a href="index.php">Accueil</a>
    <a href="pistes.php">🎿Pistes</a>
    <a href="remontes.php">🚠Remontées</a>
    <a href="meteo.php">🌤️Météo</a>
    <a href="webcams.php">Webcams</a>
  </nav>
  <a href="..page_login/connexion.php">Connexion</a>
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

<!-- JS externe -->
<script src="pistes.js"></script>
</body>
</html>
