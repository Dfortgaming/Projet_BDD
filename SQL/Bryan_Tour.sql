-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : jeu. 15 oct. 2026 à 15:19
-- Version du serveur : 13.0.2-MariaDB-ubu2604
-- Version de PHP : 8.3.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Bryan_Tour`
--

-- --------------------------------------------------------

--
-- Structure de la table `Circuit`
--

CREATE TABLE `Circuit` (
  `Id_Circuit` int(11) NOT NULL,
  `descriptif` text DEFAULT NULL,
  `pays` varchar(50) NOT NULL,
  `ville_depart` varchar(50) NOT NULL,
  `ville_arrivee` varchar(50) NOT NULL,
  `date_depart` datetime NOT NULL,
  `nbr_places_disponibles` double NOT NULL,
  `duree` smallint(6) NOT NULL,
  `prix_inscription` smallint(6) NOT NULL,
  `nom_circuit` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `Circuit`
--

INSERT INTO `Circuit` (`Id_Circuit`, `descriptif`, `pays`, `ville_depart`, `ville_arrivee`, `date_depart`, `nbr_places_disponibles`, `duree`, `prix_inscription`, `nom_circuit`) VALUES
(1, NULL, 'France ', 'Poërmel', 'Cesson-Sévigné', '2027-10-14 14:13:43', 25, 7, 1000, 'Bryan Tour Breton'),
(2, NULL, 'Etat-Unis', 'Los Angeles', 'Los Angeles', '2027-10-14 14:18:00', 45, 15, 1500, 'Bryan Tour USA'),
(4, NULL, 'Royaume-Uni', 'Whashington', 'Londres', '2027-10-14 14:21:51', 20, 7, 800, 'Bryan Tour UK '),
(6, NULL, 'Chine', 'Hong Kong', 'Pekin', '2027-10-14 14:26:53', 15, 15, 1225, 'Bryan Tour Chine'),
(7, NULL, 'Russie', 'Moscow', 'Moscow', '2027-10-14 14:29:41', 20, 7, 1200, 'Bryan Tour Russie '),
(8, NULL, 'Afrique du sud ', 'Benoni', 'Benoni', '2027-10-14 14:34:10', 20, 15, 1000, 'Bryan Tour Afrique ');

-- --------------------------------------------------------

--
-- Structure de la table `Client`
--

CREATE TABLE `Client` (
  `Id_client` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mot_de_passe` varchar(100) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `Client`
--

INSERT INTO `Client` (`Id_client`, `nom`, `prenom`, `telephone`, `email`, `mot_de_passe`, `admin`) VALUES
(1, 'Epsi', 'Dewi', '0612345678', 'test@test.fr', 'root', 0),
(2, 'Mae', 'Maemae', '0612345678', 'test2@test.fr', 'root', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Etape`
--

CREATE TABLE `Etape` (
  `Id_Etape` int(11) NOT NULL,
  `date_etape` date NOT NULL,
  `duree` tinyint(4) NOT NULL,
  `Id_Lieu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `Etape`
--

INSERT INTO `Etape` (`Id_Etape`, `date_etape`, `duree`, `Id_Lieu`) VALUES
(1, '2027-10-15', 1, 52),
(2, '2027-10-16', 2, 41),
(3, '2027-10-17', 1, 43),
(4, '2027-10-18', 1, 42),
(5, '2027-10-19', 1, 53),
(6, '2027-10-17', 5, 44),
(7, '2026-10-19', 2, 45),
(8, '2027-10-17', 5, 54),
(9, '2026-10-21', 5, 55),
(10, '2027-10-16', 5, 56),
(12, '2027-10-17', 5, 46),
(13, '2026-10-19', 5, 47),
(14, '2027-10-18', 2, 50),
(15, '2026-10-21', 5, 51),
(16, '2027-10-17', 7, 48),
(17, '2026-10-19', 2, 49);

-- --------------------------------------------------------

--
-- Structure de la table `Lieu`
--

CREATE TABLE `Lieu` (
  `Id_Lieu` int(11) NOT NULL,
  `prix_visite` decimal(5,2) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `descriptif` text DEFAULT NULL,
  `label` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `Lieu`
--

INSERT INTO `Lieu` (`Id_Lieu`, `prix_visite`, `ville`, `descriptif`, `label`) VALUES
(41, 0.00, 'Ploërmel', 'Lycée La Mennais - Les origines bretonnes de Bryan', 'Historique'),
(42, 5.00, 'Cesson-Sévigné', 'Campus EPSI - Le lieu d\'études du développeur Bryan', 'High-Tech'),
(43, 25.00, 'Cesson-Sévigné', 'Appartement du Bryan Originel', 'Historique'),
(44, 15.00, 'Albuquerque', 'Lieux de tournage de Breaking Bad (Bryan Cranston)', 'Cinéma'),
(45, 12.00, 'Canoga Park', 'Ville de naissance de l\'acteur Bryan Cranston', 'Historique'),
(46, 10.00, 'Johannesbourg', 'Primiere école de rugby de Bryan Habana', 'Historique'),
(47, 20.00, 'Johannesbourg', 'Stade de rugby des Golden Lions', 'Historique'),
(48, 0.00, ' NewCastle', 'College de Bryan Ferry', 'Historique'),
(49, 35.00, 'Londres', ' Odre de l\'empire Britanique', 'Historique'),
(50, 0.00, 'Hong Kong', 'Lieux de tournage de Enter the Fat Dragon', 'Cinéma'),
(51, 5.00, 'Hong Kong', 'Université De Bryan Leung', 'Historique'),
(52, 0.00, 'Vannes', 'Lieu de naissance de Bryan ', 'Historique'),
(53, 15.00, 'Bruz', 'Tasty Crousty , nourriture préféré de Bryan ', 'Nourriture '),
(54, 15.00, 'Los Angeles', 'Lieux de tournage de Malcolm ', 'Cinéma'),
(55, 15.00, 'North bay ', 'Lieux de tournage de Everything’s Going to Be Great', 'Cinéma'),
(56, 20.00, 'Los Angeles', 'Lieux de tournage de The Disaster Artist', 'Cinéma');

-- --------------------------------------------------------

--
-- Structure de la table `Ordre_de_passage`
--

CREATE TABLE `Ordre_de_passage` (
  `Id_Etape` int(11) NOT NULL,
  `Id_Circuit` int(11) NOT NULL,
  `ordre` tinyint(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `Ordre_de_passage`
--

INSERT INTO `Ordre_de_passage` (`Id_Etape`, `Id_Circuit`, `ordre`) VALUES
(1, 1, NULL),
(2, 1, NULL),
(3, 1, NULL),
(4, 1, NULL),
(5, 1, NULL),
(6, 2, NULL),
(7, 2, NULL),
(8, 2, NULL),
(9, 2, NULL),
(10, 2, NULL),
(12, 8, NULL),
(13, 8, NULL),
(14, 6, NULL),
(15, 6, NULL),
(16, 4, NULL),
(17, 4, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Photos`
--

CREATE TABLE `Photos` (
  `Id_Photos` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `legende` varchar(50) DEFAULT NULL,
  `photo` text DEFAULT NULL,
  `Id_Lieu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Reservation`
--

CREATE TABLE `Reservation` (
  `Id_client` int(11) NOT NULL,
  `Id_Circuit` int(11) NOT NULL,
  `status` enum('En cours','Validé','Annulé') NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `date_mise_a_jour` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `Reservation`
--

INSERT INTO `Reservation` (`Id_client`, `Id_Circuit`, `status`, `date_creation`, `date_mise_a_jour`) VALUES
(1, 1, 'En cours', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Circuit`
--
ALTER TABLE `Circuit`
  ADD PRIMARY KEY (`Id_Circuit`);

--
-- Index pour la table `Client`
--
ALTER TABLE `Client`
  ADD PRIMARY KEY (`Id_client`);

--
-- Index pour la table `Etape`
--
ALTER TABLE `Etape`
  ADD PRIMARY KEY (`Id_Etape`),
  ADD KEY `Id_Lieu` (`Id_Lieu`);

--
-- Index pour la table `Lieu`
--
ALTER TABLE `Lieu`
  ADD PRIMARY KEY (`Id_Lieu`),
  ADD KEY `ville` (`ville`) USING BTREE;

--
-- Index pour la table `Ordre_de_passage`
--
ALTER TABLE `Ordre_de_passage`
  ADD PRIMARY KEY (`Id_Etape`,`Id_Circuit`),
  ADD KEY `Id_Circuit` (`Id_Circuit`);

--
-- Index pour la table `Photos`
--
ALTER TABLE `Photos`
  ADD PRIMARY KEY (`Id_Photos`),
  ADD KEY `Id_Lieu` (`Id_Lieu`);

--
-- Index pour la table `Reservation`
--
ALTER TABLE `Reservation`
  ADD PRIMARY KEY (`Id_client`,`Id_Circuit`),
  ADD KEY `Id_Circuit` (`Id_Circuit`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Circuit`
--
ALTER TABLE `Circuit`
  MODIFY `Id_Circuit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `Client`
--
ALTER TABLE `Client`
  MODIFY `Id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `Etape`
--
ALTER TABLE `Etape`
  MODIFY `Id_Etape` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `Lieu`
--
ALTER TABLE `Lieu`
  MODIFY `Id_Lieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `Photos`
--
ALTER TABLE `Photos`
  MODIFY `Id_Photos` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Etape`
--
ALTER TABLE `Etape`
  ADD CONSTRAINT `1` FOREIGN KEY (`Id_Lieu`) REFERENCES `Lieu` (`Id_Lieu`);

--
-- Contraintes pour la table `Ordre_de_passage`
--
ALTER TABLE `Ordre_de_passage`
  ADD CONSTRAINT `1` FOREIGN KEY (`Id_Etape`) REFERENCES `Etape` (`Id_Etape`),
  ADD CONSTRAINT `2` FOREIGN KEY (`Id_Circuit`) REFERENCES `Circuit` (`Id_Circuit`);

--
-- Contraintes pour la table `Photos`
--
ALTER TABLE `Photos`
  ADD CONSTRAINT `1` FOREIGN KEY (`Id_Lieu`) REFERENCES `Lieu` (`Id_Lieu`);

--
-- Contraintes pour la table `Reservation`
--
ALTER TABLE `Reservation`
  ADD CONSTRAINT `1` FOREIGN KEY (`Id_client`) REFERENCES `Client` (`Id_client`),
  ADD CONSTRAINT `2` FOREIGN KEY (`Id_Circuit`) REFERENCES `Circuit` (`Id_Circuit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
