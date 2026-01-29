<?php require 'securite.php';
if($_POST){$pdo->prepare("INSERT INTO pistes(nom,difficulte,etat) VALUES (?,?, 'ouvert')")->execute([$_POST['nom'],$_POST['difficulte']]);}
?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Ajouter piste</h1></header>
<div class="container"><form method="post" class="card">
<input name="nom" placeholder="Nom">
<select name="difficulte"><option>verte</option><option>bleue</option><option>rouge</option><option>noire</option></select>
<button>Ajouter</button>
</form></div></body></html>