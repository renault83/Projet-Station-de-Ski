<?php
$host = "192.168.3.2";
$dbname = "SDS"; 
$user_bdd = "root";
$pass_bdd = "1234";

try {
    $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user_bdd, $pass_bdd);
    
    // On nettoie le numéro du badge reçu (pour enlever les espaces invisibles)
    $badge_saisi = trim($_POST['numero_badge']);

    // Requête JOIN pour récupérer les infos du badge ET du client associé
    $sql = "SELECT clients.nom, clients.prenom, badges.type_forfait, badges.date_fin_validite 
            FROM badges 
            INNER JOIN clients ON badges.id_client = clients.id_client 
            WHERE badges.id_badge = :badge";

    $requete = $bdd->prepare($sql);
    $requete->execute(['badge' => $badge_saisi]);
    $resultat = $requete->fetch();

    if ($resultat) {
        // On vérifie si la date d'aujourd'hui est inférieure à la date de fin de validité
        $date_fin = strtotime($resultat['date_fin_validite']);
        $maintenant = time();

        if ($date_fin >= $maintenant) {
            // Le forfait est valide
            echo "OK|" . $resultat['nom'] . "|" . $resultat['prenom'] . "|" . $resultat['type_forfait'];
        } else {
            // Le forfait existe mais est expiré
            echo "EXPIRE|" . $resultat['nom'] . "|" . $resultat['prenom'] . "|Forfait expiré";
        }
    } else {
        // Badge introuvable dans la table
        echo "NOK|Inconnu|---|---";
    }

} catch (Exception $erreur) {
    echo "ERR|Erreur base de données|---|---";
}
?>