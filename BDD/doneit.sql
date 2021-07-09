-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 15 juin 2021 à 10:14
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `doneit`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`) VALUES
(1, 'Ordinateur portable'),
(2, 'Ordinateur'),
(3, 'Smartphone'),
(4, 'Téléphone fixe'),
(5, 'Tablette'),
(6, 'Télévision'),
(7, 'Imprimante'),
(8, 'Scanner'),
(9, 'Ecran d\'ordinateur'),
(10, 'Appareil photo'),
(11, 'Caméra'),
(12, 'Smartwatch'),
(13, 'Machine à laver'),
(14, 'Réfrigérateur'),
(15, 'Enceinte'),
(26, 'Caméra'),
(27, 'Smartwatch'),
(28, 'Machine à laver'),
(29, 'Réfrigérateur'),
(30, 'Enceinte');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `num_Commande` int(16) NOT NULL AUTO_INCREMENT,
  `email_Client` varchar(50) NOT NULL,
  `email_reparateur` varchar(75) NOT NULL DEFAULT '0',
  `adresse` varchar(75) NOT NULL,
  `categorie` varchar(55) NOT NULL,
  `panne` varchar(255) NOT NULL,
  `marque` varchar(55) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_retrait` varchar(10) NOT NULL,
  `etat` int(1) NOT NULL DEFAULT '0' COMMENT '0 = Pas pris en charge',
  `date_creation` varchar(10) NOT NULL,
  PRIMARY KEY (`num_Commande`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`num_Commande`, `email_Client`, `email_reparateur`, `adresse`, `categorie`, `panne`, `marque`, `reference`, `description`, `date_retrait`, `etat`, `date_creation`) VALUES
(45, 'julien59155@gmail.com', '0', '', 'Smartphone', '', 'HONOR', '6X', 'Ecran cassé', '', 1, '27/03/2021'),
(44, 'julien59155@gmail.com', '0', '', 'Ordinateur portable', '', 'Lenovo', 'Yoga', 'Ne s\'allume plus', '', 0, '27/03/2021'),
(46, 'julien59155@gmail.com', '0', '', 'Ordinateur', '', 'qsffqs', 'adzdzad', 'cassé', '', 0, '16/04/2021'),
(47, 'julien59155@gmail.com', '0', '', 'Machine à laver', '', '', '', '', '', 0, '14/06/2021');

-- --------------------------------------------------------

--
-- Structure de la table `commande_images`
--

DROP TABLE IF EXISTS `commande_images`;
CREATE TABLE IF NOT EXISTS `commande_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `type` int(1) NOT NULL COMMENT '0 = Photo, 1 = Devis, 2 = Facture',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande_images`
--

INSERT INTO `commande_images` (`id`, `code`, `id_commande`, `nom`, `type`) VALUES
(60, 'b1c93d8b5c83dde07096cca6b993a5ce', 45, 'calculBesoinConversion.PNG', 0),
(58, '881a2561fa59d7beb7751b4fb44a15a2', 44, 'bug.PNG', 0),
(59, 'a217b4d5dc4a522c5dd4870083124c96', 45, 'calculatrice.PNG', 0),
(57, 'a1c3b30655b3c06ff86c821ee406b0c7', 44, 'ajoutchiffre.PNG', 0),
(56, 'f350e204fecc6125d896506c973000f9', 44, 'ac007ce67389ef1b52c429f0617d35285b0a90a8_00.jpg', 0),
(61, 'db4c7718c8897d37a0ab52c233e6f164', 46, 'logoJLPNG.png', 0),
(68, '38d815b04b429bde4ea57856b33b6250', 46, 'glpi2.PNG', 0),
(69, 'c9f3c0bcc0f6fa14e483d8b5caa1ed4a', 46, 'IlYrJo.jpg', 0),
(72, '0aed823cdd8cdfbdd0bb1fd8cc30ad7d', 45, 'Article.pdf', 1),
(73, '2f0a6b070b27ac2b96dd2d9f2885ba53', 45, 'Article.pdf', 2);

-- --------------------------------------------------------

--
-- Structure de la table `professionnels`
--

DROP TABLE IF EXISTS `professionnels`;
CREATE TABLE IF NOT EXISTS `professionnels` (
  `num_entreprise` int(11) NOT NULL AUTO_INCREMENT,
  `nom_entreprise` varchar(255) DEFAULT NULL,
  `nom` varchar(75) NOT NULL,
  `prenom` varchar(75) NOT NULL,
  `email` varchar(150) NOT NULL,
  `tel` int(10) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `code_postal` varchar(5) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `categorie_materiel` varchar(255) DEFAULT NULL,
  `siret` bigint(14) DEFAULT NULL,
  `contrat_pro` varchar(255) DEFAULT NULL,
  `diplome` varchar(255) DEFAULT NULL,
  `photo_profil` varchar(255) NOT NULL DEFAULT 'pp_pro_default',
  `conditions_utilisation` int(1) NOT NULL DEFAULT '0',
  `newsletter` int(1) NOT NULL DEFAULT '0',
  `etape` int(1) NOT NULL DEFAULT '0',
  `code_provi` int(10) DEFAULT NULL,
  `date_debut_creation` varchar(10) NOT NULL,
  `date_creation` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`num_entreprise`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `professionnels`
--

INSERT INTO `professionnels` (`num_entreprise`, `nom_entreprise`, `nom`, `prenom`, `email`, `tel`, `adresse`, `ville`, `code_postal`, `password`, `categorie_materiel`, `siret`, `contrat_pro`, `diplome`, `photo_profil`, `conditions_utilisation`, `newsletter`, `etape`, `code_provi`, `date_debut_creation`, `date_creation`) VALUES
(5, 'aa', 'LAMBIN', 'Julien', 'julien591551@gmail.com', 750415911, '7 RUE DU MARECHAL FOCH', 'FACHES THUMESNIL', '59155', '$2y$10$k/CiGje8rvMYzq7/AirhNeG.JsJX8ZAracYffDpXbgOF07kiCtrgS', 'Smartphone', 123, 'logo.PNG', 'logoJL - Copie.PNG', 'pp_pro_default', 0, 1, 5, 0, '28/05/2021', '0.002770905492330529'),
(3, NULL, 'LAMBIN', 'Julien', 'minefireclash@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$4fouHWO2K2V5ukqxCsUpteMAW1wWuNtoePmJVdopLnaRJw5jjOXqW', NULL, NULL, NULL, NULL, 'pp_pro_default', 0, 1, 2, NULL, '16/04/2021', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `recuperation`
--

DROP TABLE IF EXISTS `recuperation`;
CREATE TABLE IF NOT EXISTS `recuperation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  `confirme` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `recuperation`
--

INSERT INTO `recuperation` (`id`, `email`, `code`, `confirme`) VALUES
(2, 'julien59155@gmail.com', 69943411, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Num_Client` int(16) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(35) NOT NULL,
  `Prenom` varchar(35) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Tel` int(11) NOT NULL,
  `Adresse` varchar(80) NOT NULL,
  `password` varchar(150) NOT NULL,
  `photo_profil` varchar(13) NOT NULL DEFAULT 'pp_default',
  `date_creation` varchar(10) NOT NULL,
  PRIMARY KEY (`Num_Client`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`Num_Client`, `Nom`, `Prenom`, `Email`, `Tel`, `Adresse`, `password`, `photo_profil`, `date_creation`) VALUES
(21, 'LAMBIN', 'Julien', 'julien59155@gmail.com', 750415911, '7 RUE DU MARECHAL FOCH', '$2y$10$VpGEgJBfbo.5MrBI1OZUKO4W4FRSDTvTQzJC6dovlciuqbqZ9svma', 'pp_21', '26/03/2021');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
