<?php
require 'config.php';

function getMeteo($pdo) {
    $stmt = $pdo->query(
        "SELECT temperature, vitesse_vent, humidite, epaisseur_neige, timestamp
         FROM meteo
         ORDER BY timestamp DESC
         LIMIT 1"
    );

    return $stmt->fetch();
}
