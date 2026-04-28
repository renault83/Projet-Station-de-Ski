<?php
require '../config.php';

$alerte = $pdo->query("
    SELECT niveau, message 
    FROM alerte 
    ORDER BY date_maj DESC 
    LIMIT 1
")->fetch(PDO::FETCH_ASSOC);

echo json_encode($alerte);


// APIs