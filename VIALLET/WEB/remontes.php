<?php require 'config.php'; $r=$pdo->query("SELECT * FROM remontes")->fetchAll(); ?>
<!DOCTYPE html><html><head>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="style.css"></head><body>
<header><h1>Remontées</h1></header><div class="container">
<?php foreach($r as $x): ?>
<div class="card"><h3><?= $x['nom'] ?></h3>
<p class="status-<?= $x['etat'] ?>"><?= $x['etat'] ?></p></div>
<?php endforeach; ?>
</div></body></html>