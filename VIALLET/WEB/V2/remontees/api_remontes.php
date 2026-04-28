<?php
require '../config.php';

header('Content-Type: application/json');

$stmt = $pdo->query(
    "SELECT 
        nom,
        DATE_FORMAT(heure_ouverture, '%H:%i') AS heure_ouverture,
        DATE_FORMAT(heure_fermeture, '%H:%i') AS heure_fermeture,
        etat
     FROM remontes
     ORDER BY nom"
);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
