<?php
require '../config.php';

/* Sécurité */
if (!isset($_SESSION['directeur'])) {
    header('Location: login.php');
    exit;
}

/* Récupération du dernier niveau d'alerte */
$alerte = $pdo->query("SELECT niveau, message FROM alerte ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

/* Gestion du formulaire */
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $niveau = $_POST['niveau'];
    $message = '';

    if ($niveau === '0') $message = 'Aucune alerte. Bonne condition';
    elseif ($niveau === '1') $message = 'Vigilance légère';
    elseif ($niveau === '2') $message = 'Vigilance modérée';
    elseif ($niveau === '3') $message = isset($_POST['message_personnel']) 
    ? trim($_POST['message_personnel']) 
    : '';
        

 /* Peux etre utiliser a partir de php 7, wamp ne supporte pas */       
 /* $message = trim($_POST['message_personnel'] ?? ''); */

    if ($message !== '') {
        $stmt = $pdo->prepare("INSERT INTO alerte (niveau, message) VALUES (?, ?)");
        $stmt->execute([$niveau, $message]);
        $success = 'Seuil d’alerte mis à jour avec succès.';
        $alerte = ['niveau' => $niveau, 'message' => $message];
    } else {
        $success = 'Veuillez saisir un message pour le niveau 3.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Administration — Seuil d'alerte</title>
<style>
body { font-family: Arial, sans-serif; background:#f1f5f9; margin:0; padding:0; }
header { background:#020617; color:#fff; padding:18px 30px; }
.admin-menu { background:#0f172a; padding:12px 30px; display:flex; }
.admin-menu a { color:#e5e7eb; text-decoration:none; margin-right:25px; font-weight:bold; }
.admin-menu .logout { margin-left:auto; background:#7f1d1d; padding:8px 12px; border-radius:6px; }
main { padding:30px; }
.card { background:#fff; padding:20px; border-radius:6px; max-width:500px; margin:auto; }
.success { color:green; margin-bottom:15px; font-weight:bold; }
label { display:block; margin-top:10px; font-weight:bold; }
.radio-group { margin-top:10px; }
.radio-group input { margin-right:5px; }
textarea { width:100%; padding:8px; margin-top:5px; border-radius:4px; border:1px solid #ccc; resize:vertical; display:block; }
button { margin-top:15px; padding:10px 15px; background:#0f172a; color:#fff; border:none; border-radius:6px; cursor:pointer; font-weight:bold; }
#message_auto { font-weight:bold; margin-top:10px; }
</style>
</head>
<body>

<header>
<h1>Administration — Seuil d'alerte</h1>
</header>

<nav class="admin-menu">
<a href="admin.php">🏠 Tableau de bord</a>
<a href="admin_alerte.php">⚠️ Seuil d'alerte</a>
<a href="../page_login/logout.php" class="logout">⛔ Déconnexion</a>
</nav>

<main>
<div class="card">
<h2>Modifier le seuil d'alerte</h2>

<?php if ($success): ?>
<p class="success"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<form method="POST" id="form_alerte">
<div class="radio-group">

<label>
<input type="radio" name="niveau" value="0" <?= ($alerte['niveau']=='0')?'checked':'' ?>>
Niveau 0 — Aucune alerte
</label>

<label>
<input type="radio" name="niveau" value="1" <?= ($alerte['niveau']=='1')?'checked':'' ?>>
Niveau 1 — Vigilance légère
</label>

<label>
<input type="radio" name="niveau" value="2" <?= ($alerte['niveau']=='2')?'checked':'' ?>>
Niveau 2 — Vigilance modérée
</label>

<label>
<input type="radio" name="niveau" value="3" <?= ($alerte['niveau']=='3')?'checked':'' ?>>
Niveau 3 — Alerte maximale
</label>

</div>

<div id="message_personnel_container" style="display:none; margin-top:10px;">
<label for="message_personnel">Message personnalisé</label>
<textarea id="message_personnel" name="message_personnel" rows="3"><?= ($alerte['niveau']=='3') ? htmlspecialchars($alerte['message']) : '' ?></textarea>
</div>

<p id="message_auto"></p>

<button type="submit">Enregistrer</button>
</form>
</div>
</main>

<script>
const radios = document.querySelectorAll('input[name="niveau"]');
const messageContainer = document.getElementById('message_personnel_container');
const messageAuto = document.getElementById('message_auto');

function updateMessage() {
    const niveau = document.querySelector('input[name="niveau"]:checked').value;

    if (niveau === '0') {
        messageContainer.style.display = 'none';
        messageAuto.textContent = 'Aucune alerte. Bonne condition';
    } 
    else if (niveau === '1') {
        messageContainer.style.display = 'none';
        messageAuto.textContent = 'Vigilance légère';
    } 
    else if (niveau === '2') {
        messageContainer.style.display = 'none';
        messageAuto.textContent = 'Vigilance modérée';
    } 
    else if (niveau === '3') {
        messageContainer.style.display = 'block';
        messageAuto.textContent = '';
    }
}

// Initialisation
updateMessage();

// Changement du niveau
radios.forEach(radio => radio.addEventListener('change', updateMessage));
</script>

</body>
</html>
