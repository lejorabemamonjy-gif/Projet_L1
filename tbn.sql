-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 24 août 2026 à 21:08
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tbn`
--

-- --------------------------------------------------------

--
-- Structure de la table `formulaire`
--

DROP TABLE IF EXISTS `formulaire`;
CREATE TABLE IF NOT EXISTS `formulaire` (
  `id_formulaire` int NOT NULL AUTO_INCREMENT,
  `id_reservation` int DEFAULT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `cin` int NOT NULL,
  `numero_telephone` char(10) NOT NULL,
  `contact_urgence` char(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `operateur` enum('MVOLA','ORANGE MONEY','AIRTEL MONEY') DEFAULT NULL,
  `telephone` char(10) DEFAULT NULL,
  `carte_credit` varchar(19) DEFAULT NULL,
  `montant` text NOT NULL,
  PRIMARY KEY (`id_formulaire`),
  UNIQUE KEY `id_reservation` (`id_reservation`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `formulaire`
--

INSERT INTO `formulaire` (`id_formulaire`, `id_reservation`, `nom`, `prenom`, `cin`, `numero_telephone`, `contact_urgence`, `created_at`, `operateur`, `telephone`, `carte_credit`, `montant`) VALUES
(1, NULL, '', '', 0, '', '', '2026-08-24 18:50:16', '', '', '', ''),
(2, NULL, '', '', 0, '', '', '2026-08-24 18:50:58', '', '', '', ''),
(3, NULL, '', '', 0, '', '', '2026-08-24 18:51:40', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id_reservation` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `id_trajet` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `num_place` int DEFAULT NULL,
  `status` enum('active','annulee') DEFAULT 'active',
  `date_reservation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reservation`),
  KEY `fk_reservation_user` (`id_utilisateur`),
  KEY `fk_reservation_trajet` (`id_trajet`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `id_utilisateur`, `id_trajet`, `created_at`, `num_place`, `status`, `date_reservation`) VALUES
(1, 21, 1, '2026-08-24 18:50:24', 3, 'active', '2026-08-24 18:50:24'),
(2, 21, 1, '2026-08-24 18:51:06', 8, 'annulee', '2026-08-24 18:51:06'),
(3, 21, 1, '2026-08-24 18:51:48', 5, 'active', '2026-08-24 18:51:48');

-- --------------------------------------------------------

--
-- Structure de la table `reservation_stat`
--

DROP TABLE IF EXISTS `reservation_stat`;
CREATE TABLE IF NOT EXISTS `reservation_stat` (
  `id_reservation` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `id_trajet` int DEFAULT NULL,
  `create_at` date DEFAULT NULL,
  `num_place` int DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_reservation` date DEFAULT (curdate()),
  PRIMARY KEY (`id_reservation`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservation_stat`
--

INSERT INTO `reservation_stat` (`id_reservation`, `id_utilisateur`, `id_trajet`, `create_at`, `num_place`, `status`, `date_reservation`) VALUES
(1, 21, 1, NULL, 3, 'active', '2026-08-24'),
(2, 21, 1, NULL, 8, 'annulee', '2026-08-24'),
(3, 21, 1, NULL, 5, 'active', '2026-08-24'),
(4, 20, 1, NULL, 20, 'active', '2026-08-06'),
(5, 20, 1, NULL, 20, 'active', '2026-09-06'),
(6, 20, 1, NULL, 20, 'active', '2026-09-20'),
(7, 20, 1, NULL, 20, 'active', '2026-09-22'),
(8, 20, 1, NULL, 20, 'annulee', '2026-09-22'),
(10, 20, 1, NULL, 20, 'annulee', '2026-07-22'),
(11, 20, 1, NULL, 20, 'annulee', '2026-07-22'),
(12, 20, 1, NULL, 20, 'active', '2026-07-22'),
(13, 20, 1, NULL, 20, 'active', '2026-07-22'),
(14, 20, 1, NULL, 20, 'active', '2026-07-22');

-- --------------------------------------------------------

--
-- Structure de la table `route`
--

DROP TABLE IF EXISTS `route`;
CREATE TABLE IF NOT EXISTS `route` (
  `id_route` int NOT NULL AUTO_INCREMENT,
  `nom_route` varchar(100) DEFAULT NULL,
  `prix` int DEFAULT NULL,
  PRIMARY KEY (`id_route`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `route`
--

INSERT INTO `route` (`id_route`, `nom_route`, `prix`) VALUES
(1, 'TANA-->SAMBAVA', 20000),
(2, 'TANA-->TOAMASINA', 20000);

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

DROP TABLE IF EXISTS `trajet`;
CREATE TABLE IF NOT EXISTS `trajet` (
  `id_trajet` int NOT NULL AUTO_INCREMENT,
  `id_route` int DEFAULT NULL,
  `id_voiture` int DEFAULT NULL,
  `jour` varchar(20) DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `places_disponibles` int DEFAULT NULL,
  `date_depart` datetime DEFAULT NULL,
  PRIMARY KEY (`id_trajet`),
  KEY `fk_trajet_route` (`id_route`),
  KEY `fk_trajet_voiture` (`id_voiture`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `trajet`
--

INSERT INTO `trajet` (`id_trajet`, `id_route`, `id_voiture`, `jour`, `heure`, `places_disponibles`, `date_depart`) VALUES
(1, 1, 1, 'Lundi', '09:00:00', 13, NULL),
(2, 2, 1, 'Lundi', '09:00:00', 18, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `role` enum('client','employe','admin') NOT NULL DEFAULT 'client',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `prenom`, `email`, `password`, `telephone`, `role`, `created_at`, `last_login`) VALUES
(2, 'test', 'TT', 'test@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'admin', '2026-04-27 19:50:48', NULL),
(3, 'j', 'jj', 'jj@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 'employe', '2026-04-28 13:19:40', NULL),
(4, 'j', 'jj', 'j@gmail.com', '123', '0322222222', 'client', '2026-04-28 14:06:12', NULL),
(5, 'gjhhjghj', 'gj', 'g@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 'client', '2026-04-28 14:14:40', NULL),
(8, 'uihuiygyg', 'uguyfyutfuy', 'hugtuyfu@gmail.com', '204da255aea2cd4a75ace6018fad6b4d', NULL, 'employe', '2026-05-08 08:56:23', NULL),
(9, 'hbsudifoigfio', 'kjxfhfoisangkbeo', 'khjbjqwbuau@gmail.com', '03293fcfc65939382f51563fa5457d7b', NULL, 'client', '2026-05-08 09:06:39', NULL),
(10, 'ñklbkhiljbugv', 'piguyfyt', 'mmihiyguy@xn--gmail-xra.com', '03293fcfc65939382f51563fa5457d7b', NULL, 'client', '2026-05-08 09:07:19', NULL),
(11, 'Rabe', 'Le', 'a@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 'client', '2026-05-19 13:51:10', NULL),
(12, 'h', 'i', 'u@gmail.com', '$2y$10$jftMQdo.CBYAKJNvHKHpy.E6dqTbkRIhMPt2oNSYIVXPEQClFUgjy', NULL, 'client', '2026-05-20 06:22:07', NULL),
(21, 'admin', NULL, 'l@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 'admin', '2026-08-24 08:14:16', NULL),
(22, 'Nantenaina', 'Fanirimanantsoa', 't@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 'client', '2026-08-24 09:42:34', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

DROP TABLE IF EXISTS `voiture`;
CREATE TABLE IF NOT EXISTS `voiture` (
  `id_voiture` int NOT NULL AUTO_INCREMENT,
  `matricule` varchar(100) DEFAULT NULL,
  `chauffeur` varchar(100) DEFAULT NULL,
  `copilote` varchar(100) DEFAULT NULL,
  `nbr_place` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_voiture`),
  UNIQUE KEY `matricule` (`matricule`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`id_voiture`, `matricule`, `chauffeur`, `copilote`, `nbr_place`, `created_at`) VALUES
(1, '2025TN', 'RABE', 'RAKOTO', 18, '2026-08-24 18:50:08');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `formulaire`
--
ALTER TABLE `formulaire`
  ADD CONSTRAINT `fk_formulaire_reservation` FOREIGN KEY (`id_reservation`) REFERENCES `reservation` (`id_reservation`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_trajet` FOREIGN KEY (`id_trajet`) REFERENCES `trajet` (`id_trajet`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reservation_user` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD CONSTRAINT `fk_trajet_route` FOREIGN KEY (`id_route`) REFERENCES `route` (`id_route`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_trajet_voiture` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
