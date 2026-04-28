<?php
require '../config.php';

// Récupérer le dernier seuil d'alerte
$alerte = $pdo->query("SELECT niveau, message FROM alerte ORDER BY date_maj DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

// Déterminer la classe et le texte du niveau d'alerte
$alerteClasse = '';
$alerteTexte = '';

if ($alerte) {
    switch ($alerte['niveau']) {
        case '0':
            $alerteClasse = 'alert-0';
            $alerteTexte = '0 — Aucune alerte';
            break;
        case '1':
            $alerteClasse = 'alert-1';
            $alerteTexte = '1 — Vigilance légère';
            break;
        case '2':
            $alerteClasse = 'alert-2';
            $alerteTexte = '2 — Vigilance modérée';
            break;
        case '3':
            $alerteClasse = 'alert-3';
            $alerteTexte = '3 — Alerte maximale';
            break;
    }
}

// Inclure le template HTML
include './index.html';