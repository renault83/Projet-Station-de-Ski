<?php require 'config.php';
if($_POST){$pdo->prepare("UPDATE remontes SET etat=? WHERE id_remonte=?")->execute([$_POST['etat'],$_POST['id']]);}
$p=$pdo->query("SELECT * FROM remontes")->fetchAll();
?>

<!DOCTYPE html><html><head><link rel="stylesheet" href="style.css"></head><body>
<header><h1>Gestion remontées</h1></header><div class="container">
<?php foreach($r as $x): ?>
<form method="post" class="card">
<?= $x['nom'] ?>
<select name="etat"><option>ouvert</option><option>ferme</option><option>en_evacuation</option></select>
<input type="hidden" name="id" value="<?= $x['id_remonte'] ?>">
<button>OK</button>
</form><?php endforeach; ?>
</div></body></html>
```php
<?php require 'securite.php';
if($_POST){$pdo->prepare("UPDATE remontes SET etat=? WHERE id_remonte=?")->execute([$_POST['etat'],$_POST['id']]);}
$r=$pdo->query("SELECT * FROM remontes")->fetchAll();
?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Gestion remontées</h1></header><div class="container">
<?php foreach($r as $x): ?>
<form method="post" class="card">
<?= $x['nom'] ?>
<select name="etat"><option>ouvert</option><option>ferme</option><option>en_evacuation</option></select>
<input type="hidden" name="id" value="<?= $x['id_remonte'] ?>">
<button>OK</button>
</form><?php endforeach; ?>
</div></body></html>