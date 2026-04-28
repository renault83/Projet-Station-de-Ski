<?php
require '../config.php';

// Récupérer le dernier seuil d'alerte
$alerte = $pdo->query("SELECT niveau, message FROM alerte ORDER BY date_maj DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

if ($alerte) {
    $response = [
        'niveau' => $alerte['niveau'],
        'message' => $alerte['message']
    ];
} else {
    $response = [
        'niveau' => '0',
        'message' => 'Aucune alerte'
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
