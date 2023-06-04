-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 04 juin 2023 à 21:12
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ece_in`
--

-- --------------------------------------------------------

--
-- Structure de la table `ami`
--

DROP TABLE IF EXISTS `ami`;
CREATE TABLE IF NOT EXISTS `ami` (
  `ID_user1` int NOT NULL,
  `ID_user2` int NOT NULL,
  PRIMARY KEY (`ID_user1`,`ID_user2`),
  KEY `Ami_fk1` (`ID_user2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ami`
--

INSERT INTO `ami` (`ID_user1`, `ID_user2`) VALUES
(1, 2),
(1, 11),
(2, 4);

-- --------------------------------------------------------

--
-- Structure de la table `conversation`
--

DROP TABLE IF EXISTS `conversation`;
CREATE TABLE IF NOT EXISTS `conversation` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `photo` text,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `conversation`
--

INSERT INTO `conversation` (`ID`, `nom`, `photo`) VALUES
(1, 'conv1', 'img/profile-picture-default.png'),
(2, 'conv2', 'img/connection.jpg'),
(3, 'azerty', 'img/1e4fc3ad57cd8df4bb8cafd1d4213dd2.png'),
(4, 'test final', 'img/293fe18ecdb11ccaef879d92e507e7aa.png');

-- --------------------------------------------------------

--
-- Structure de la table `discuter`
--

DROP TABLE IF EXISTS `discuter`;
CREATE TABLE IF NOT EXISTS `discuter` (
  `ID_user` int NOT NULL,
  `ID_conv` int NOT NULL,
  PRIMARY KEY (`ID_user`,`ID_conv`),
  KEY `Discuter_fk1` (`ID_conv`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `discuter`
--

INSERT INTO `discuter` (`ID_user`, `ID_conv`) VALUES
(1, 1),
(1, 2),
(1, 4),
(2, 1),
(2, 3),
(2, 4),
(4, 2),
(4, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `emploi`
--

DROP TABLE IF EXISTS `emploi`;
CREATE TABLE IF NOT EXISTS `emploi` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `lieu` text NOT NULL,
  `entreprise` text NOT NULL,
  `duree` text NOT NULL,
  `type` text NOT NULL,
  `remuneration` int NOT NULL,
  `photo` text,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `emploi`
--

INSERT INTO `emploi` (`ID`, `nom`, `lieu`, `entreprise`, `duree`, `type`, `remuneration`, `photo`) VALUES
(1, 'Chargé(e) de communication digitale', 'Paris, FR', 'bibi', 'sans limitation de durée', 'CDI', 1600, 'img/digitale_emploi.jpeg'),
(2, 'Professeur de mathématiques et science', 'Campus ECE Paris - FR', 'ECE', 'Temps partiel', 'CDD', 2900, 'img/enseignant_emploi.jpg'),
(3, 'Jobs développeur', 'la Défense - Paris FR', 'Société Générale', 'Contrat à durée indéterminée', 'CDI', 2201, 'img/programmer_emploi.jpg'),
(4, 'dompteur de vélociraptor', 'Commune de Saint-Pierre-sur-Dives -Normandie FR', 'Domination', 'contrat à durée indéterminé', 'CDI', 4300, 'img/dompteur_emploi.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `texte` text NOT NULL,
  `date` timestamp NOT NULL,
  `lieu` text,
  `photo` text NOT NULL,
  `auteur` int NOT NULL,
  `type` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `event`
--

INSERT INTO `event` (`ID`, `nom`, `texte`, `date`, `lieu`, `photo`, `auteur`, `type`) VALUES
(1, 'none', 'Dans le cadre de la prochaine Journée Portes Ouvertes du samedi 4 mars 2023, nous sommes toujours à la recherche d’étudiants pour participer à cet événement.', '2023-06-02 17:54:04', 'E1 - Campus Omnes Education - Paris FR', 'img/jpo_event.jpeg', 5, 1),
(2, 'none', 'J\'organise une soirée magique dans un bar enchanté, où les convives plongeront dans un univers de musique envoûtante, de cocktails divins et de rencontres inattendues, pour une expérience nocturne mémorable qui repousse les limites de la fête. Préparez-vous à être transporté dans un monde parallèle où la danse, le rire et les instants de folie se mêlent dans une ambiance électrisante.', '2023-06-01 22:00:00', 'Le Calbar - 82 Rue de Charenton - Paris FR', 'img/cocktail_event.jpg', 2, 2),
(3, 'none', 'Cet event ne doit pas apparaitre', '2023-06-03 13:33:04', 'Cet event ne doit pas apparaitre', '', 3, 2),
(4, 'none', 'Nous recherchons des étudiants passionnés par l\'informatique pour rejoindre notre entreprise en tant que stagiaires. Vous aurez l\'opportunité de travailler sur des projets stimulants, d\'acquérir une expérience pratique et de développer vos compétences dans un environnement dynamique et innovant.', '2023-06-03 13:33:56', 'La Défense - Paris FR', 'img/stage_event.png', 6, 4),
(5, 'none', '\"Venez découvrir notre association dédiée aux jeux vidéo lors de notre événement étudiant ! Nous sommes à la recherche de passionnés souhaitant rejoindre notre équipe et partager ensemble notre amour pour le gaming.\"', '2023-06-03 13:45:46', 'E1 - Campus Omnes Education - Paris FR', '', 4, 3);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `texte` text,
  `photo` text,
  `discussion` int NOT NULL,
  `auteur` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `Message_fk0` (`discussion`),
  KEY `Message_fk1` (`auteur`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`ID`, `texte`, `photo`, `discussion`, `auteur`, `date`) VALUES
(1, 'test', NULL, 1, 1, '2023-05-31 15:43:13'),
(2, 'coucou', NULL, 1, 2, '2023-05-31 15:43:13'),
(3, 'test img', 'img/programmer_emploi.jpg', 1, 2, '2023-05-31 17:40:27'),
(4, NULL, 'img/programmer_emploi.jpg', 2, 4, '2023-05-31 17:40:27'),
(5, 'test img', 'img/programmer_emploi.jpg', 2, 1, '2023-05-31 17:40:27'),
(6, 'test img', 'img/programmer_emploi.jpg', 1, 1, '2023-05-31 17:40:27'),
(7, 'test img', '', 1, 1, '2023-05-31 17:40:27'),
(8, 'coucou', NULL, 1, 2, '2023-05-31 15:43:13'),
(9, 'a', NULL, 1, 1, '2023-06-01 08:28:21'),
(10, 'haha', NULL, 1, 1, '2023-06-01 08:35:16'),
(11, 'haha', NULL, 1, 1, '2023-06-01 08:35:18'),
(12, '', 'img/programmer_emploi.jpg', 1, 1, '2023-06-01 08:36:15'),
(13, 'test suppr message apres envoi', NULL, 1, 1, '2023-06-01 13:11:15'),
(14, 'test', NULL, 1, 1, '2023-06-01 13:13:15'),
(15, 'test', 'img/c2392d2c47b36ed1f7f573f656431b7b.png', 1, 1, '2023-06-01 13:14:35'),
(16, '', 'img/8bfc73308768eb12cbb06b1f26496ae8.png', 4, 1, '2023-06-01 13:27:31'),
(17, 'logo', 'img/1090389c4ed0d4210796bec5e62034e8.png', 4, 1, '2023-06-01 13:28:37'),
(18, 'logo', 'img/f4a5e850edb41509156cd1fbd3bffc2e.png', 4, 1, '2023-06-01 13:29:24'),
(19, 'az', NULL, 1, 2, '2023-06-01 15:31:09'),
(20, 'tatatatatata1111', 'img/0fc67f12852f4fd6236cb26e8c7b2ee5.jpg', 4, 1, '2023-06-04 20:33:32');

-- --------------------------------------------------------

--
-- Structure de la table `participation`
--

DROP TABLE IF EXISTS `participation`;
CREATE TABLE IF NOT EXISTS `participation` (
  `ID_user` int NOT NULL,
  `ID_event` int NOT NULL,
  PRIMARY KEY (`ID_user`,`ID_event`),
  KEY `Participation_fk1` (`ID_event`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `participation`
--

INSERT INTO `participation` (`ID_user`, `ID_event`) VALUES
(1, 2),
(1, 5);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `texte` text,
  `photo` text,
  `like` int NOT NULL DEFAULT '0',
  `publique` int NOT NULL,
  `comment` int DEFAULT NULL,
  `auteur` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `Post_fk0` (`comment`),
  KEY `Post_fk1` (`auteur`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`ID`, `texte`, `photo`, `like`, `publique`, `comment`, `auteur`, `date`) VALUES
(9, 'mon poste !', NULL, 0, 2, NULL, 1, '2023-06-04 21:10:56'),
(8, 'ma photo :', 'img/87db906a673ee308418aa294ffd4f0fd.jpg', 0, 2, NULL, 1, '2023-06-04 21:09:42');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Pseudo` text NOT NULL,
  `Nom` text NOT NULL,
  `Email` text NOT NULL,
  `MDP` text NOT NULL,
  `Admin` tinyint(1) NOT NULL DEFAULT '0',
  `PDP` text,
  `Banniere` text,
  `Statut` text,
  `Emploi` text,
  `Last_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID`, `Pseudo`, `Nom`, `Email`, `MDP`, `Admin`, `PDP`, `Banniere`, `Statut`, `Emploi`, `Last_log`) VALUES
(1, 'toto', 'toto', 'toto@gmail.fr', '1234', 0, 'img/profile-picture-default.png', 'img/banniere-picture-default.png', NULL, NULL, '2023-06-04 21:10:49'),
(2, 'tata', 'tata', 'tata@gmail.fr', '0000', 0, 'img/profile-picture-default.png', 'img/banniere-picture-default.png', NULL, NULL, '2023-06-04 14:31:48'),
(3, 'admin', 'admin', 'admin@gmail.fr', 'admin', 1, 'img/profile-picture-default.png', 'img/banniere-picture-default.png', NULL, NULL, '2023-06-04 20:34:16'),
(4, 'amis 34', 'lol', 'ami34@gmail.com', '34', 0, 'img/profile-picture-default.png', 'img/banniere-picture-default.png', NULL, NULL, '2023-05-30 13:18:01'),
(5, 'ECE', 'ECE', 'ece@gmail.fr', '0000', 1, 'img/profile-picture-default.png', 'img/banniere-picture-default.png', NULL, NULL, '2023-06-02 17:53:49'),
(6, 'Omnes Education', 'Omnes Education', 'omneseducation@gmail.fr', '0000', 1, 'img/profile-picture-default.png', 'img/banniere-picture-default.png', NULL, NULL, '2023-06-03 13:24:40'),
(41, 'a', 'a', 'aaa@gmail.com', 'aaaaa', 0, 'img/profile-picture-default.png', 'img/banniere-picture-default.png', NULL, NULL, '2023-06-04 21:01:01');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;