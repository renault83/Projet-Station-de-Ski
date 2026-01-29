<?php require 'config.php';
if($_POST){$pdo->prepare("UPDATE pistes SET etat=? WHERE id_piste=?")->execute([$_POST['etat'],$_POST['id']]);}
$p=$pdo->query("SELECT * FROM pistes")->fetchAll();
?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="style.css"></head><body>
<header><h1>Gestion pistes</h1></header><div class="container">
<?php foreach($p as $x): ?>
<form method="post" class="card">
<?= $x['nom'] ?>
<select name="etat"><option>ouvert</option><option>ferme</option></select>
<input type="hidden" name="id" value="<?= $x['id_piste'] ?>">
<button>OK</button>
</form><?php endforeach; ?>
</div></body></html>
```php
<?php require_once __DIR__ . '/securite.php';
if($_POST){$pdo->prepare("UPDATE pistes SET etat=? WHERE id_piste=?")->execute([$_POST['etat'],$_POST['id']]);}
$p=$pdo->query("SELECT * FROM pistes")->fetchAll();
?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Gestion pistes</h1></header><div class="container">
<?php foreach($p as $x): ?>
<form method="post" class="card">
<?= $x['nom'] ?>
<select name="etat"><option>ouvert</option><option>ferme</option></select>
<input type="hidden" name="id" value="<?= $x['id_piste'] ?>">
<button>OK</button>
</form><?php endforeach; ?>
</div></body></html>