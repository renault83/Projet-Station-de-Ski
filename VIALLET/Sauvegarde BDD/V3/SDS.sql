-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 30 avr. 2026 à 08:14
-- Version du serveur : 11.8.3-MariaDB-0+deb13u1 from Debian
-- Version de PHP : 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `SDS`
--

-- --------------------------------------------------------

--
-- Structure de la table `alerte`
--

CREATE TABLE `alerte` (
  `id` int(11) NOT NULL,
  `niveau` enum('1','2','3') NOT NULL,
  `message` varchar(255) NOT NULL,
  `date_maj` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `badges`
--

CREATE TABLE `badges` (
  `id_badge` varchar(50) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `type_forfait` enum('enfant','adulte') NOT NULL,
  `periode` enum('matin','apres-midi','journee','6jours') NOT NULL,
  `date_debut_validite` datetime DEFAULT NULL,
  `date_fin_validite` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `badges`
--

INSERT INTO `badges` (`id_badge`, `id_client`, `type_forfait`, `periode`, `date_debut_validite`, `date_fin_validite`) VALUES
('0E6A46A8', 5, 'adulte', 'matin', '2026-02-01 00:00:00', '2026-03-21 00:00:00'),
('B2CBA003', 8, 'adulte', 'matin', '2026-02-04 00:00:00', '2026-03-04 00:00:00'),
('B2F0A703', 6, 'adulte', 'matin', '2026-05-15 00:00:00', '2026-02-06 00:00:00'),
('C2161403', 7, 'adulte', 'matin', '2026-03-31 00:00:00', '2026-04-01 00:00:00'),
('C2356E03', 10, 'adulte', 'matin', '2026-04-28 00:00:00', '2026-04-29 00:00:00'),
('C2567A03', 8, 'adulte', 'matin', '2026-04-02 00:00:00', '2026-04-04 00:00:00'),
('C28C5403', 9, 'adulte', 'matin', '2026-04-28 00:00:00', '2026-04-29 00:00:00'),
('RFID_001', 1, 'adulte', 'journee', '2026-02-01 09:00:00', '2026-02-01 17:00:00'),
('RFID_002', 2, 'enfant', '6jours', '2026-02-01 09:00:00', '2026-02-06 17:00:00'),
('RFID_ECHEC', NULL, 'adulte', 'matin', '2025-01-01 00:00:00', '2025-01-01 12:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `date_naissance` date NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id_client`, `nom`, `prenom`, `email`, `code_postal`, `ville`, `date_naissance`, `photo_path`) VALUES
(1, 'Durand', 'Marie', 'marie.durand@email.com', '83510', 'Lorgues', '1995-05-15', NULL),
(2, 'Martin', 'Lucas', 'lucas.m@email.com', '83000', 'Toulon', '2015-10-20', NULL),
(3, 'Dupont', 'Jean', 'jean.dupont@email.com', '75001', 'Paris', '1980-01-01', NULL),
(4, 'sollily', 'mathis', 'mathis.sollily@lycee-lorgues.fr', '83510', 'zebi', '2026-02-05', NULL),
(5, 'test', 'test', 'testeseesdfsdf', '83350', 'test', '2003-05-01', NULL),
(6, 'PK', 'Erwan', 'feskjfeskjfeskj', '83550', 'Vidauban', '2002-12-17', NULL),
(7, 'paf', 'paf', 'dfghdfhbn', '83340', 'hdfh', '2000-04-15', NULL),
(8, 'fsfsf', 'sfsdf', 'fdsf', '8555', 'sdfsf', '2000-01-02', NULL),
(9, 'thom', 'dfgdfg', 'dgfdfg', '8888', 'fgdfg', '0200-08-08', NULL),
(10, 'Martin', 'Marie', 'marie.Martin@email.com', '83340', 'le luc', '2000-04-15', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `historique_acces`
--

CREATE TABLE `historique_acces` (
  `id_acces` int(11) NOT NULL,
  `id_badge` varchar(50) DEFAULT NULL,
  `id_remonte` int(11) DEFAULT NULL,
  `date_heure_passage` datetime DEFAULT current_timestamp(),
  `statut_passage` enum('autorise','refuse','forcage_manuel') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `historique_acces`
--

INSERT INTO `historique_acces` (`id_acces`, `id_badge`, `id_remonte`, `date_heure_passage`, `statut_passage`) VALUES
(1, 'RFID_001', 1, '2026-01-15 15:26:19', 'autorise'),
(2, 'RFID_ECHEC', 2, '2026-01-15 15:26:19', 'refuse');

-- --------------------------------------------------------

--
-- Structure de la table `identifiants`
--

CREATE TABLE `identifiants` (
  `id_employe` int(11) NOT NULL,
  `identifiant` varchar(50) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('directeur','caissier','controleur','technicien') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `identifiants`
--

INSERT INTO `identifiants` (`id_employe`, `identifiant`, `mot_de_passe`, `role`) VALUES
(1, 'admin_dir', 'directeur2026', 'directeur'),
(2, 'caisse_01', 'caisse123', 'caissier'),
(3, 'secu_piste', 'controle456', 'controleur'),
(4, 'tech_edison', 'meteo789', 'technicien'),
(5, 'takumi', '4AGE', 'directeur');

-- --------------------------------------------------------

--
-- Structure de la table `informations`
--

CREATE TABLE `informations` (
  `id_info` int(11) NOT NULL,
  `id_remonte` int(11) DEFAULT NULL,
  `message_flash` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `informations`
--

INSERT INTO `informations` (`id_info`, `id_remonte`, `message_flash`) VALUES
(1, 1, 'Bienvenue à la station - Ski fluide ce matin'),
(2, 2, 'Attention : Rafales de vent au sommet');

-- --------------------------------------------------------

--
-- Structure de la table `meteo`
--

CREATE TABLE `meteo` (
  `id_releve` int(11) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `temperature` decimal(4,2) DEFAULT NULL,
  `humidite` decimal(5,2) DEFAULT NULL,
  `pression` decimal(6,2) DEFAULT NULL,
  `vitesse_vent` decimal(5,2) DEFAULT NULL,
  `direction_vent` int(11) DEFAULT NULL,
  `epaisseur_neige` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `meteo`
--

INSERT INTO `meteo` (`id_releve`, `timestamp`, `temperature`, `humidite`, `pression`, `vitesse_vent`, `direction_vent`, `epaisseur_neige`) VALUES
(1, '2026-01-15 15:26:19', -2.50, 65.00, 1012.00, 15.50, 270, 120.50),
(2, '2026-01-15 15:26:19', -5.00, 80.00, 1005.00, 85.00, 315, 145.00);

-- --------------------------------------------------------

--
-- Structure de la table `pistes`
--

CREATE TABLE `pistes` (
  `id_piste` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `difficulte` enum('verte','bleue','rouge','noire') DEFAULT NULL,
  `etat` enum('ouvert','ferme') DEFAULT 'ouvert'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `pistes`
--

INSERT INTO `pistes` (`id_piste`, `nom`, `difficulte`, `etat`) VALUES
(1, 'La Combe', 'bleue', 'ouvert'),
(2, 'Le Mur', 'noire', 'ouvert'),
(3, 'Les Marmottes', 'verte', 'ouvert'),
(4, '83 Imp. Farriou Le Cannet-des-Maures', 'bleue', 'ferme'),
(10, '1734 Avenue Fred Scamaroni 83300 draguignan', 'rouge', 'ferme');

-- --------------------------------------------------------

--
-- Structure de la table `remontes`
--

CREATE TABLE `remontes` (
  `id_remonte` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `heure_ouverture` time DEFAULT NULL,
  `heure_fermeture` time DEFAULT NULL,
  `etat` enum('ouvert','ferme','en_evacuation') DEFAULT 'ferme'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `remontes`
--

INSERT INTO `remontes` (`id_remonte`, `nom`, `heure_ouverture`, `heure_fermeture`, `etat`) VALUES
(1, 'SAPIN', '09:00:00', '17:00:00', 'ouvert'),
(2, 'CRETE DES BANS', '09:15:00', '16:10:00', 'ferme'),
(3, 'CY-698-RS', '10:50:00', '15:20:00', 'ouvert'),
(4, 'DY-686-QA', '12:20:00', '12:10:00', 'ouvert');

-- --------------------------------------------------------

--
-- Structure de la table `seuils_alerte`
--

CREATE TABLE `seuils_alerte` (
  `id_seuil` int(11) NOT NULL,
  `couleur` enum('orange','rouge') NOT NULL,
  `valeur_kmh` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `seuils_alerte`
--

INSERT INTO `seuils_alerte` (`id_seuil`, `couleur`, `valeur_kmh`) VALUES
(1, 'orange', 50.00),
(2, 'rouge', 80.00);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `alerte`
--
ALTER TABLE `alerte`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id_badge`),
  ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `historique_acces`
--
ALTER TABLE `historique_acces`
  ADD PRIMARY KEY (`id_acces`),
  ADD KEY `id_badge` (`id_badge`),
  ADD KEY `id_remonte` (`id_remonte`);

--
-- Index pour la table `identifiants`
--
ALTER TABLE `identifiants`
  ADD PRIMARY KEY (`id_employe`),
  ADD UNIQUE KEY `identifiant` (`identifiant`);

--
-- Index pour la table `informations`
--
ALTER TABLE `informations`
  ADD PRIMARY KEY (`id_info`),
  ADD KEY `id_remonte` (`id_remonte`);

--
-- Index pour la table `meteo`
--
ALTER TABLE `meteo`
  ADD PRIMARY KEY (`id_releve`);

--
-- Index pour la table `pistes`
--
ALTER TABLE `pistes`
  ADD PRIMARY KEY (`id_piste`);

--
-- Index pour la table `remontes`
--
ALTER TABLE `remontes`
  ADD PRIMARY KEY (`id_remonte`);

--
-- Index pour la table `seuils_alerte`
--
ALTER TABLE `seuils_alerte`
  ADD PRIMARY KEY (`id_seuil`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `alerte`
--
ALTER TABLE `alerte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=369;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `historique_acces`
--
ALTER TABLE `historique_acces`
  MODIFY `id_acces` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `identifiants`
--
ALTER TABLE `identifiants`
  MODIFY `id_employe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `informations`
--
ALTER TABLE `informations`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `meteo`
--
ALTER TABLE `meteo`
  MODIFY `id_releve` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `pistes`
--
ALTER TABLE `pistes`
  MODIFY `id_piste` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `remontes`
--
ALTER TABLE `remontes`
  MODIFY `id_remonte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `seuils_alerte`
--
ALTER TABLE `seuils_alerte`
  MODIFY `id_seuil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
