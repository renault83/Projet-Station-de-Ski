<?php require_once __DIR__ . '/config.php';
$pistes = $pdo->query("SELECT * FROM pistes")->fetchAll(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="style.css">
    <title>Pistes</title>
</head>
<body>

<header>
    <h1>Pistes ouvertes</h1>
</header>

<div class="container">
    <div class="grid">
        <?php foreach ($pistes as $p): ?>
            <div class="card">
                <h3><?= htmlspecialchars($p['nom']) ?></h3>
                <span class="badge badge-<?= $p['difficulte'] ?>">
                    <?= $p['difficulte'] ?>
                </span>
                <p>État :
                    <span class="status-<?= $p['etat'] ?>">
                        <?= $p['etat'] ?>
                    </span>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
