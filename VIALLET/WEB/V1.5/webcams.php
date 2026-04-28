<?php
require 'config.php';

$stmt = $pdo->query("
  SELECT 
    p.nom,
    p.etat,
    w.url_webcam,
    w.description
  FROM webcams w
  JOIN pistes p ON p.id_piste = w.id_piste
  ORDER BY p.nom
");

$webcams = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Webcams des pistes</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
<h1><a href="index.html" class="logo">Station de ski</a></h1>
  <nav>
    <a href="index.php">Accueil</a>
    <a href="pistes.php">🎿Pistes</a>
    <a href="remontes.php">🚠Remontées</a>
    <a href="meteo.php">🌤️Météo</a>
    <a href="webcams.php">Webcams</a>
  </nav>
  <a href="login.php">Connexion</a>
</header>

<main>
  <h2>Webcams des pistes</h2>

  <div class="cards">
    <?php foreach ($webcams as $w): ?>
      <div class="card">

        <h3>
          🎿 <?= htmlspecialchars($w['nom']) ?>
          <?php if ($w['etat'] === 'ouvert'): ?>
            <span style="color: green;">(Ouverte)</span>
          <?php else: ?>
            <span style="color: red;">(Fermée)</span>
          <?php endif; ?>
        </h3>

        <p><?= htmlspecialchars($w['description']) ?></p>

        <iframe
          width="100%"
          height="250"
          src="<?= $w['url_webcam'] ?>"
          frameborder="0"
          allowfullscreen>
        </iframe>

      </div>
    <?php endforeach; ?>
  </div>
</main>

</body>
</html>
