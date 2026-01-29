<?php require 'config.php';
if($_POST){
$s=$pdo->prepare("SELECT * FROM identifiants WHERE identifiant=? AND mot_de_passe=? AND role='directeur'");
$s->execute([$_POST['login'],$_POST['password']]);
if($s->fetch()){$_SESSION['directeur']=1;header('Location: dashboard.php');}
}
?>
<!DOCTYPE html><html><head>
<link rel="stylesheet" href="style.css"></head><body>
<header><h1>Connexion directeur</h1></header>
<div class="container"><div class="card">
<form method="post">
<input name="login" placeholder="Identifiant">
<input type="password" name="password" placeholder="Mot de passe">
<button>Connexion</button>
</form></div></div></body></html>