<?php
require 'config.php';

/* Sécurité */
if (!isset($_SESSION['directeur'])) {
    header('Location: login.php');
    exit;
}

/* Statistiques */
$nbPistes    = $pdo->query("SELECT COUNT(*) FROM pistes")->fetchColumn();
$nbRemontees = $pdo->query("SELECT COUNT(*) FROM remontes")->fetchColumn();
$nbReleves   = $pdo->query("SELECT COUNT(*) FROM meteo")->fetchColumn();

/* États initiaux */
$pistes = $pdo->query("
    SELECT nom, etat
    FROM pistes
    ORDER BY nom
")->fetchAll(PDO::FETCH_ASSOC);

$remontees = $pdo->query("
    SELECT nom, etat
    FROM remontes
    ORDER BY nom
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Administration — SDS1</title>

<style>
body { margin:0; font-family:Arial,sans-serif; background:#f1f5f9; }
header { background:#020617; color:#fff; padding:18px 30px; }
.admin-menu { background:#0f172a; padding:12px 30px; display:flex; }
.admin-menu a { color:#e5e7eb; text-decoration:none; margin-right:25px; font-weight:bold; }
.admin-menu .logout { margin-left:auto; background:#7f1d1d; padding:8px 12px; border-radius:6px; }
main { padding:30px; }
.dashboard { display:grid; grid-template-columns:repeat(auto-fit,minmax(320px,1fr)); gap:20px; }
.card { background:#fff; padding:20px; border-radius:6px; }
.status-ouvert { color:green; font-weight:bold; }
.status-ferme { color:red; font-weight:bold; }
.status-evac { color:orange; font-weight:bold; }
footer { text-align:center; padding:15px; color:#555; }
</style>
</head>

<body>

<header>
    <h1>Administration — Station de ski</h1>
</header>

<nav class="admin-menu">
    <a href="admin.php">🏠 Tableau de bord</a>
    <a href="admin_pistes.php">🎿 Pistes</a>
    <a href="admin_remontees.php">🚠 Remontées</a>
    <a href="admin_meteo.php">🌤️ Météo</a>
    <a href="logout.php" class="logout">⛔ Déconnexion</a>
</nav>

<main>
    <h2>Tableau de bord</h2>

    <div class="dashboard">

        <!-- Pistes -->
        <div class="card">
            <h2>Pistes (<?= $nbPistes ?>)</h2>
            <div id="liste-pistes">
                <?php foreach ($pistes as $p): ?>
                    <p data-nom="<?= htmlspecialchars($p['nom'], ENT_QUOTES) ?>">
                        <?= htmlspecialchars($p['nom']) ?> —
                        <span class="<?= $p['etat'] === 'ouvert' ? 'status-ouvert' : 'status-ferme' ?>">
                            <?= $p['etat'] === 'ouvert' ? 'Ouverte' : 'Fermée' ?>
                        </span>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Remontées -->
        <div class="card">
            <h2>Remontées (<?= $nbRemontees ?>)</h2>
            <div id="liste-remontees">
                <?php foreach ($remontees as $r): ?>
                    <p data-nom="<?= htmlspecialchars($r['nom'], ENT_QUOTES) ?>">
                        <?= htmlspecialchars($r['nom']) ?> —
                        <span class="<?=
                            $r['etat'] === 'ouvert' ? 'status-ouvert' :
                            ($r['etat'] === 'en_evacuation' ? 'status-evac' : 'status-ferme')
                        ?>">
                            <?= $r['etat'] === 'ouvert'
                                ? 'Ouverte'
                                : ($r['etat'] === 'en_evacuation' ? 'Évacuation' : 'Fermée') ?>
                        </span>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Météo -->
        <div class="card">
            <h2>Météo</h2>
            <p><?= $nbReleves ?> relevés enregistrés</p>
        </div>

    </div>
</main>

<footer>
    © <?= date('Y') ?> Projet SDS1 VIALLET
</footer>

<script>
const API_PISTES    = 'pistes_live.php';
const API_REMONTEES = 'remontees_live.php';

/* ===== PISTES ===== */
async function refreshPistes() {
    try {
        const res = await fetch(API_PISTES, { cache: 'no-store' });
        const data = await res.json();
        const box = document.getElementById('liste-pistes');

        data.forEach(p => {
            const row = box.querySelector(`p[data-nom="${CSS.escape(p.nom)}"]`);
            if (!row) return;

            const span = row.querySelector('span');
            if (p.etat === 'ouvert') {
                span.textContent = 'Ouverte';
                span.className = 'status-ouvert';
            } else {
                span.textContent = 'Fermée';
                span.className = 'status-ferme';
            }
        });
    } catch (e) {
        console.error('Erreur pistes', e);
    }
}

/* ===== REMONTÉES ===== */
async function refreshRemontees() {
    try {
        const res = await fetch(API_REMONTEES, { cache: 'no-store' });
        const data = await res.json();
        const box = document.getElementById('liste-remontees');

        data.forEach(r => {
            const row = box.querySelector(`p[data-nom="${CSS.escape(r.nom)}"]`);
            if (!row) return;

            const span = row.querySelector('span');
            if (r.etat === 'ouvert') {
                span.textContent = 'Ouverte';
                span.className = 'status-ouvert';
            } else if (r.etat === 'en_evacuation') {
                span.textContent = 'Évacuation';
                span.className = 'status-evac';
            } else {
                span.textContent = 'Fermée';
                span.className = 'status-ferme';
            }
        });
    } catch (e) {
        console.error('Erreur remontées', e);
    }
}

/* Rafraîchissement temps réel */
setInterval(refreshPistes, 1000);
setInterval(refreshRemontees, 1000);
</script>

</body>
</html>
