
<?php
require '../config.php';

$pistes = $pdo
    ->query("SELECT nom, difficulte, etat FROM pistes ORDER BY nom")
    ->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($pistes);

/*API POUR RAFRAICHIR TOUT SEUL SUR LA PAGE PISTE */
