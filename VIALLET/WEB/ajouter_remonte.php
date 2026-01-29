<?php require 'securite.php';
if($_POST){$pdo->prepare("INSERT INTO remontes(nom,etat) VALUES (?, 'ferme')")->execute([$_POST['nom']]);}
?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="style.css"></head><body>
<header><h1>Ajouter remontée</h1></header>
<div class="container"><form method="post" class="card">
<input name="nom" placeholder="Nom">
<button>Ajouter</button>
</form></div></body></html>