-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 27 Janvier 2026 à 10:22
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `station_ski_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `badges`
--

CREATE TABLE IF NOT EXISTS `badges` (
  `id_badge` varchar(50) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `type_forfait` enum('enfant','adulte') NOT NULL,
  `periode` enum('matin','apres-midi','journee','6jours') NOT NULL,
  `date_debut_validite` datetime DEFAULT NULL,
  `date_fin_validite` datetime DEFAULT NULL,
  PRIMARY KEY (`id_badge`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `badges`
--

INSERT INTO `badges` (`id_badge`, `id_client`, `type_forfait`, `periode`, `date_debut_validite`, `date_fin_validite`) VALUES
('RFID_001', 1, 'adulte', 'journee', '2026-02-01 09:00:00', '2026-02-01 17:00:00'),
('RFID_002', 2, 'enfant', '6jours', '2026-02-01 09:00:00', '2026-02-06 17:00:00'),
('RFID_ECHEC', NULL, 'adulte', 'matin', '2025-01-01 00:00:00', '2025-01-01 12:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `date_naissance` date NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`id_client`, `nom`, `prenom`, `email`, `code_postal`, `ville`, `date_naissance`, `photo_path`) VALUES
(1, 'Durand', 'Marie', 'marie.durand@email.com', '83510', 'Lorgues', '1995-05-15', NULL),
(2, 'Martin', 'Lucas', 'lucas.m@email.com', '83000', 'Toulon', '2015-10-20', NULL),
(3, 'Dupont', 'Jean', 'jean.dupont@email.com', '75001', 'Paris', '1980-01-01', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `historique_acces`
--

CREATE TABLE IF NOT EXISTS `historique_acces` (
  `id_acces` int(11) NOT NULL AUTO_INCREMENT,
  `id_badge` varchar(50) DEFAULT NULL,
  `id_remonte` int(11) DEFAULT NULL,
  `date_heure_passage` datetime DEFAULT CURRENT_TIMESTAMP,
  `statut_passage` enum('autorise','refuse','forcage_manuel') NOT NULL,
  PRIMARY KEY (`id_acces`),
  KEY `id_badge` (`id_badge`),
  KEY `id_remonte` (`id_remonte`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `historique_acces`
--

INSERT INTO `historique_acces` (`id_acces`, `id_badge`, `id_remonte`, `date_heure_passage`, `statut_passage`) VALUES
(1, 'RFID_001', 1, '2026-01-15 15:26:19', 'autorise'),
(2, 'RFID_ECHEC', 2, '2026-01-15 15:26:19', 'refuse');

-- --------------------------------------------------------

--
-- Structure de la table `identifiants`
--

CREATE TABLE IF NOT EXISTS `identifiants` (
  `id_employe` int(11) NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(50) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('directeur','caissier','controleur','technicien') NOT NULL,
  PRIMARY KEY (`id_employe`),
  UNIQUE KEY `identifiant` (`identifiant`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `identifiants`
--

INSERT INTO `identifiants` (`id_employe`, `identifiant`, `mot_de_passe`, `role`) VALUES
(1, 'admin_dir', 'directeur2026', 'directeur'),
(2, 'caisse_01', 'caisse123', 'caissier'),
(3, 'secu_piste', 'controle456', 'controleur'),
(4, 'tech_edison', 'meteo789', 'technicien');

-- --------------------------------------------------------

--
-- Structure de la table `informations`
--

CREATE TABLE IF NOT EXISTS `informations` (
  `id_info` int(11) NOT NULL AUTO_INCREMENT,
  `id_remonte` int(11) DEFAULT NULL,
  `message_flash` text,
  PRIMARY KEY (`id_info`),
  KEY `id_remonte` (`id_remonte`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `informations`
--

INSERT INTO `informations` (`id_info`, `id_remonte`, `message_flash`) VALUES
(1, 1, 'Bienvenue à la station - Ski fluide ce matin'),
(2, 2, 'Attention : Rafales de vent au sommet');

-- --------------------------------------------------------

--
-- Structure de la table `meteo`
--

CREATE TABLE IF NOT EXISTS `meteo` (
  `id_releve` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `temperature` decimal(4,2) DEFAULT NULL,
  `humidite` decimal(5,2) DEFAULT NULL,
  `pression` decimal(6,2) DEFAULT NULL,
  `vitesse_vent` decimal(5,2) DEFAULT NULL,
  `direction_vent` int(11) DEFAULT NULL,
  `epaisseur_neige` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id_releve`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `meteo`
--

INSERT INTO `meteo` (`id_releve`, `timestamp`, `temperature`, `humidite`, `pression`, `vitesse_vent`, `direction_vent`, `epaisseur_neige`) VALUES
(1, '2026-01-15 15:26:19', '-2.50', '65.00', '1012.00', '15.50', 270, '120.50'),
(2, '2026-01-15 15:26:19', '-5.00', '80.00', '1005.00', '85.00', 315, '145.00');

-- --------------------------------------------------------

--
-- Structure de la table `pistes`
--

CREATE TABLE IF NOT EXISTS `pistes` (
  `id_piste` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `difficulte` enum('verte','bleue','rouge','noire') DEFAULT NULL,
  `etat` enum('ouvert','ferme') DEFAULT 'ouvert',
  PRIMARY KEY (`id_piste`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `pistes`
--

INSERT INTO `pistes` (`id_piste`, `nom`, `difficulte`, `etat`) VALUES
(1, 'La Combe', 'bleue', 'ouvert'),
(2, 'Le Mur', 'noire', 'ferme'),
(3, 'Les Marmottes', 'verte', 'ouvert');

-- --------------------------------------------------------

--
-- Structure de la table `remontes`
--

CREATE TABLE IF NOT EXISTS `remontes` (
  `id_remonte` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `heure_ouverture` time DEFAULT NULL,
  `heure_fermeture` time DEFAULT NULL,
  `etat` enum('ouvert','ferme','en_evacuation') DEFAULT 'ferme',
  PRIMARY KEY (`id_remonte`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `remontes`
--

INSERT INTO `remontes` (`id_remonte`, `nom`, `heure_ouverture`, `heure_fermeture`, `etat`) VALUES
(1, 'SAPINS', '09:00:00', '17:00:00', 'ouvert'),
(2, 'CRETE DES BANS', '09:15:00', '16:45:00', 'ouvert');

-- --------------------------------------------------------

--
-- Structure de la table `seuils_alerte`
--

CREATE TABLE IF NOT EXISTS `seuils_alerte` (
  `id_seuil` int(11) NOT NULL AUTO_INCREMENT,
  `couleur` enum('orange','rouge') NOT NULL,
  `valeur_kmh` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id_seuil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `seuils_alerte`
--

INSERT INTO `seuils_alerte` (`id_seuil`, `couleur`, `valeur_kmh`) VALUES
(1, 'orange', '50.00'),
(2, 'rouge', '80.00');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `badges`
--
ALTER TABLE `badges`
  ADD CONSTRAINT `badges_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`);

--
-- Contraintes pour la table `historique_acces`
--
ALTER TABLE `historique_acces`
  ADD CONSTRAINT `historique_acces_ibfk_1` FOREIGN KEY (`id_badge`) REFERENCES `badges` (`id_badge`),
  ADD CONSTRAINT `historique_acces_ibfk_2` FOREIGN KEY (`id_remonte`) REFERENCES `remontes` (`id_remonte`);

--
-- Contraintes pour la table `informations`
--
ALTER TABLE `informations`
  ADD CONSTRAINT `informations_ibfk_1` FOREIGN KEY (`id_remonte`) REFERENCES `remontes` (`id_remonte`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
