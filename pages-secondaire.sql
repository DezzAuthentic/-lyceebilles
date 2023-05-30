-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 25 Septembre 2018 à 00:11
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `pages_secondaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `affectations`
--

CREATE TABLE `affectations` (
  `id` int(11) NOT NULL,
  `eleve_id` int(11) NOT NULL,
  `groupe_id` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `annees`
--

CREATE TABLE `annees` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `professeur_ouverture` date DEFAULT NULL,
  `administration_ouverture` date DEFAULT NULL,
  `inscription_ouverture` date DEFAULT NULL,
  `classe_ouverture` date DEFAULT NULL,
  `debut` int(11) DEFAULT NULL,
  `fin` int(11) DEFAULT NULL,
  `etablissement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `annees`
--

INSERT INTO `annees` (`id`, `nom`, `professeur_ouverture`, `administration_ouverture`, `inscription_ouverture`, `classe_ouverture`, `debut`, `fin`, `etablissement_id`) VALUES
(1, '2018-2019', '2018-09-01', '2018-08-21', '2018-07-02', '2018-09-24', 3, 11, 1),
(2, '2016-2017', '2018-06-26', '2018-06-25', '2018-06-27', '2018-07-25', 3, 11, 1);

-- --------------------------------------------------------

--
-- Structure de la table `annee_bulletins`
--

CREATE TABLE `annee_bulletins` (
  `id` int(10) UNSIGNED NOT NULL,
  `affectations_id` int(11) NOT NULL,
  `moyenne` float DEFAULT NULL,
  `appreciation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `coefficients`
--

CREATE TABLE `coefficients` (
  `id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL,
  `niveau_id` int(11) NOT NULL,
  `serie_id` int(11) DEFAULT NULL,
  `coef` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `coefficients`
--

INSERT INTO `coefficients` (`id`, `matiere_id`, `niveau_id`, `serie_id`, `coef`) VALUES
(1, 1, 1, NULL, 3),
(4, 1, 5, 1, 2),
(5, 1, 2, NULL, 2),
(6, 2, 2, NULL, 1),
(7, 3, 2, NULL, 4),
(8, 1, 5, 2, 2),
(10, 3, 1, NULL, 4),
(11, 2, 1, NULL, 2),
(12, 1, 3, NULL, 2),
(13, 2, 5, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `compositions`
--

CREATE TABLE `compositions` (
  `id` int(11) NOT NULL,
  `cours_id` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `configurations`
--

CREATE TABLE `configurations` (
  `id` int(11) NOT NULL,
  `professeur_acces` int(11) DEFAULT NULL,
  `eleve_acces` int(11) DEFAULT NULL,
  `tuteur_acces` int(11) DEFAULT NULL,
  `notification_email` int(11) DEFAULT NULL,
  `notification_sms` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `configurations`
--

INSERT INTO `configurations` (`id`, `professeur_acces`, `eleve_acces`, `tuteur_acces`, `notification_email`, `notification_sms`) VALUES
(1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id` int(11) NOT NULL,
  `groupe_id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL,
  `professeur_id` int(11) NOT NULL,
  `volume` int(11) DEFAULT NULL,
  `volume_effectue` int(11) DEFAULT NULL,
  `contenu` text,
  `pj` varchar(225) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `demandes`
--

CREATE TABLE `demandes` (
  `id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `texte` text,
  `etat` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `tuteur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `devoirs`
--

CREATE TABLE `devoirs` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `description` text,
  `cours_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `devoir_notes`
--

CREATE TABLE `devoir_notes` (
  `id` int(11) NOT NULL,
  `note` float DEFAULT NULL,
  `appreciation` text,
  `devoir_id` int(11) NOT NULL,
  `eleve_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `edt`
--

CREATE TABLE `edt` (
  `id` int(11) NOT NULL,
  `jour` varchar(10) DEFAULT NULL,
  `debut` int(11) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `salle_id` int(11) DEFAULT NULL,
  `cours_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `eleves`
--

CREATE TABLE `eleves` (
  `id` int(11) NOT NULL,
  `matricule` varchar(20) DEFAULT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `genre` varchar(1) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `tuteur_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pays_naissance` int(11) DEFAULT NULL,
  `nationalite` int(11) DEFAULT NULL,
  `Religion` varchar(15) DEFAULT NULL,
  `cours_religion` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `etablissement_id` int(11) NOT NULL,
  `pere` varchar(45) DEFAULT NULL,
  `mere` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `eleves`
--

INSERT INTO `eleves` (`id`, `matricule`, `nom`, `prenom`, `genre`, `date_naissance`, `lieu_naissance`, `telephone`, `adresse`, `tuteur_id`, `user_id`, `pays_naissance`, `nationalite`, `Religion`, `cours_religion`, `photo`, `etablissement_id`, `pere`, `mere`) VALUES
(1, NULL, 'Fall', 'Abdoulaye', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(3, NULL, 'Diawara', 'Alassane junior', NULL, '2004-09-01', 'Dakar', NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `employes`
--

CREATE TABLE `employes` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `fonction` varchar(45) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `etablissement_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `employes`
--

INSERT INTO `employes` (`id`, `nom`, `prenom`, `telephone`, `adresse`, `fonction`, `date_debut`, `user_id`, `photo`, `etablissement_id`) VALUES
(1, 'Fall', 'Macoumba', '00221774598303', '95 cité papa gueye thiaroye', NULL, NULL, 2, '/documents/administration/photos/1.png', 1),
(6, 'Ndiaye', 'Youssoupha', NULL, NULL, NULL, NULL, 7, NULL, 1),
(7, 'SADY', 'Mouhamed', NULL, NULL, NULL, NULL, 8, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `emprunts`
--

CREATE TABLE `emprunts` (
  `id` int(11) NOT NULL,
  `date_emprunt` date DEFAULT NULL,
  `date_retour` date DEFAULT NULL,
  `etat` varchar(45) DEFAULT NULL,
  `commentaires` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `ouvrage_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `engagements`
--

CREATE TABLE `engagements` (
  `id` int(11) NOT NULL,
  `frais_id` int(11) NOT NULL,
  `inscription_id` int(11) NOT NULL,
  `debut` int(11) NOT NULL,
  `fin` int(11) NOT NULL,
  `reduction` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `engagements`
--

INSERT INTO `engagements` (`id`, `frais_id`, `inscription_id`, `debut`, `fin`, `reduction`) VALUES
(5, 8, 5, 3, 11, NULL),
(6, 9, 5, 3, 11, NULL),
(7, 7, 6, 3, 11, 10),
(8, 10, 6, 3, 11, 10);

-- --------------------------------------------------------

--
-- Structure de la table `enseignees`
--

CREATE TABLE `enseignees` (
  `id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL,
  `professeur_id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `etablissements`
--

CREATE TABLE `etablissements` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `couverture` varchar(255) DEFAULT NULL,
  `configuration_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `annee_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `etablissements`
--

INSERT INTO `etablissements` (`id`, `nom`, `adresse`, `tel`, `email`, `logo`, `couverture`, `configuration_id`, `admin_id`, `annee_id`) VALUES
(1, 'Lycée Billes', 'niakhirate', '00221774598303', 'contact@billes.com', '/documents/etablissements/logos/1.png', NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

CREATE TABLE `evenements` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `debut` varchar(5) DEFAULT NULL,
  `fin` varchar(5) DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `couleur` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `exercices`
--

CREATE TABLE `exercices` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `contenu` text,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `a_rendre` timestamp NULL DEFAULT NULL,
  `pj` varchar(255) DEFAULT NULL,
  `seance_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE `factures` (
  `id` int(11) NOT NULL,
  `montant` int(11) DEFAULT NULL,
  `paye` int(11) DEFAULT NULL,
  `restant` int(11) DEFAULT NULL,
  `mois_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `inscription_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `factures`
--

INSERT INTO `factures` (`id`, `montant`, `paye`, `restant`, `mois_id`, `date`, `inscription_id`, `type_id`) VALUES
(29, 45000, 20000, 25000, NULL, '2018-09-23 17:47:22', 5, 2),
(30, 60000, 25000, 35000, 3, '2018-09-23 17:47:22', 5, 3),
(31, 60000, 0, 60000, 4, '2018-09-23 17:47:22', 5, 3),
(32, 60000, 0, 60000, 5, '2018-09-23 17:47:22', 5, 3),
(33, 60000, 0, 60000, 6, '2018-09-23 17:47:22', 5, 3),
(34, 60000, 0, 60000, 7, '2018-09-23 17:47:22', 5, 3),
(35, 60000, 0, 60000, 8, '2018-09-23 17:47:22', 5, 3),
(36, 60000, 0, 60000, 9, '2018-09-23 17:47:22', 5, 3),
(37, 60000, 0, 60000, 10, '2018-09-23 17:47:22', 5, 3),
(38, 60000, 0, 60000, 11, '2018-09-23 17:47:22', 5, 3),
(39, 40000, 0, 40000, 3, '2018-09-23 17:47:23', 5, 4),
(40, 40000, 0, 40000, 4, '2018-09-23 17:47:23', 5, 4),
(41, 40000, 0, 40000, 5, '2018-09-23 17:47:23', 5, 4),
(42, 40000, 0, 40000, 6, '2018-09-23 17:47:23', 5, 4),
(43, 40000, 0, 40000, 7, '2018-09-23 17:47:23', 5, 4),
(44, 40000, 0, 40000, 8, '2018-09-23 17:47:23', 5, 4),
(45, 40000, 0, 40000, 9, '2018-09-23 17:47:23', 5, 4),
(46, 40000, 0, 40000, 10, '2018-09-23 17:47:23', 5, 4),
(47, 40000, 0, 40000, 11, '2018-09-23 17:47:23', 5, 4),
(48, 25000, 0, 25000, 3, '2018-09-23 17:47:23', 5, 5),
(49, 25000, 0, 25000, 4, '2018-09-23 17:47:23', 5, 5),
(50, 25000, 0, 25000, 5, '2018-09-23 17:47:23', 5, 5),
(51, 25000, 0, 25000, 6, '2018-09-23 17:47:23', 5, 5),
(52, 25000, 0, 25000, 7, '2018-09-23 17:47:23', 5, 5),
(53, 25000, 0, 25000, 8, '2018-09-23 17:47:23', 5, 5),
(54, 25000, 0, 25000, 9, '2018-09-23 17:47:23', 5, 5),
(55, 25000, 0, 25000, 10, '2018-09-23 17:47:23', 5, 5),
(56, 25000, 0, 25000, 11, '2018-09-23 17:47:23', 5, 5),
(57, 40500, 0, 40500, NULL, '2018-09-24 11:42:10', 6, 2),
(58, 54000, 0, 54000, 3, '2018-09-24 11:42:10', 6, 3),
(59, 54000, 0, 54000, 4, '2018-09-24 11:42:10', 6, 3),
(60, 54000, 0, 54000, 5, '2018-09-24 11:42:10', 6, 3),
(61, 54000, 0, 54000, 6, '2018-09-24 11:42:10', 6, 3),
(62, 54000, 0, 54000, 7, '2018-09-24 11:42:10', 6, 3),
(63, 54000, 0, 54000, 8, '2018-09-24 11:42:10', 6, 3),
(64, 54000, 0, 54000, 9, '2018-09-24 11:42:10', 6, 3),
(65, 54000, 0, 54000, 10, '2018-09-24 11:42:10', 6, 3),
(66, 54000, 0, 54000, 11, '2018-09-24 11:42:10', 6, 3),
(67, 67500, 0, 67500, 3, '2018-09-24 11:42:11', 6, 4),
(68, 67500, 0, 67500, 4, '2018-09-24 11:42:11', 6, 4),
(69, 67500, 0, 67500, 5, '2018-09-24 11:42:11', 6, 4),
(70, 67500, 0, 67500, 6, '2018-09-24 11:42:11', 6, 4),
(71, 67500, 0, 67500, 7, '2018-09-24 11:42:11', 6, 4),
(72, 67500, 0, 67500, 8, '2018-09-24 11:42:11', 6, 4),
(73, 67500, 0, 67500, 9, '2018-09-24 11:42:11', 6, 4),
(74, 67500, 0, 67500, 10, '2018-09-24 11:42:11', 6, 4),
(75, 67500, 0, 67500, 11, '2018-09-24 11:42:11', 6, 4),
(76, 18000, 0, 18000, 3, '2018-09-24 11:42:11', 6, 5),
(77, 18000, 0, 18000, 4, '2018-09-24 11:42:11', 6, 5),
(78, 18000, 0, 18000, 5, '2018-09-24 11:42:11', 6, 5),
(79, 18000, 0, 18000, 6, '2018-09-24 11:42:11', 6, 5),
(80, 18000, 0, 18000, 7, '2018-09-24 11:42:11', 6, 5),
(81, 18000, 0, 18000, 8, '2018-09-24 11:42:11', 6, 5),
(82, 18000, 0, 18000, 9, '2018-09-24 11:42:12', 6, 5),
(83, 18000, 0, 18000, 10, '2018-09-24 11:42:12', 6, 5),
(84, 18000, 0, 18000, 11, '2018-09-24 11:42:12', 6, 5);

-- --------------------------------------------------------

--
-- Structure de la table `frais`
--

CREATE TABLE `frais` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `montant` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `niveau_id` int(11) NOT NULL,
  `serie_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `frais`
--

INSERT INTO `frais` (`id`, `nom`, `montant`, `type_id`, `niveau_id`, `serie_id`) VALUES
(1, 'Inscription', 40000, 2, 1, NULL),
(2, 'Tenue', 5000, 2, 1, NULL),
(3, 'Inscription', 50000, 2, 2, NULL),
(4, 'Inscription', 60000, 2, 5, 1),
(5, 'Inscription', 65000, 2, 5, 2),
(6, 'Scolarité', 60000, 3, 1, NULL),
(7, 'Pension', 75000, 4, 1, NULL),
(8, 'Demi-pension', 40000, 4, 1, NULL),
(9, 'Transport ligne 1', 25000, 5, 1, NULL),
(10, 'Transport ligne 2', 20000, 5, 1, NULL),
(11, 'Transport ligne 3', 50000, 5, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

CREATE TABLE `groupes` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `description` text,
  `promotion_id` int(11) NOT NULL,
  `effectif` int(11) DEFAULT NULL,
  `salle_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `groupes`
--

INSERT INTO `groupes` (`id`, `nom`, `description`, `promotion_id`, `effectif`, `salle_id`) VALUES
(1, 'SIXIEME A', 'classe de sixième A', 1, NULL, NULL),
(2, 'CINQUIEME A', 'classe de cinquieme A', 3, NULL, NULL),
(3, 'SECONDE S1 A', NULL, 5, NULL, NULL),
(4, 'SIXIEME B', NULL, 1, NULL, NULL),
(6, 'SIXIEME C', NULL, 1, NULL, NULL),
(7, 'CINQUIEME B', NULL, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

CREATE TABLE `inscriptions` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `etat` varchar(30) DEFAULT NULL,
  `eleve_id` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `inscriptions`
--

INSERT INTO `inscriptions` (`id`, `date`, `etat`, `eleve_id`, `promotion_id`) VALUES
(5, '2018-09-23', 'validé', 1, 1),
(6, '2018-09-24', 'validé', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

CREATE TABLE `matieres` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `description` text,
  `etablissement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `matieres`
--

INSERT INTO `matieres` (`id`, `nom`, `description`, `etablissement_id`) VALUES
(1, 'Français', '...', 1),
(2, 'Anglais', '...', 1),
(3, 'Mathématiques', '...', 1);

-- --------------------------------------------------------

--
-- Structure de la table `mois`
--

CREATE TABLE `mois` (
  `id` int(11) NOT NULL,
  `nom` varchar(10) DEFAULT NULL,
  `ordre` int(11) DEFAULT NULL,
  `code` varchar(2) DEFAULT NULL,
  `etablissement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `mois`
--

INSERT INTO `mois` (`id`, `nom`, `ordre`, `code`, `etablissement_id`) VALUES
(1, 'Août', 1, NULL, 1),
(2, 'Semptembre', 2, NULL, 1),
(3, 'Octobre', 3, NULL, 1),
(4, 'Novembre', 4, NULL, 1),
(5, 'Décembre', 5, NULL, 1),
(6, 'Janvier', 6, NULL, 1),
(7, 'Février', 7, NULL, 1),
(8, 'Mars', 8, NULL, 1),
(9, 'Avril', 9, NULL, 1),
(10, 'Mai', 10, NULL, 1),
(11, 'Juin', 11, NULL, 1),
(12, 'Juillet', 12, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `niveaux`
--

CREATE TABLE `niveaux` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `ordre` int(11) DEFAULT NULL,
  `etablissement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `niveaux`
--

INSERT INTO `niveaux` (`id`, `nom`, `ordre`, `etablissement_id`) VALUES
(1, 'SIXIEME', 1, 1),
(2, 'CINQUIEME', 2, 1),
(3, 'QUATRIEME', 3, 1),
(4, 'TROISIEME', 4, 1),
(5, 'SECONDE', 5, 1),
(6, 'PREMIERE', 6, 1),
(7, 'TERMINALE', 7, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ouvrages`
--

CREATE TABLE `ouvrages` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `resume` text,
  `quantite` int(11) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `pj` varchar(255) DEFAULT NULL,
  `en_pret` int(11) DEFAULT NULL,
  `rangement` varchar(45) DEFAULT NULL,
  `ouvrage_categorie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ouvrage_categories`
--

CREATE TABLE `ouvrage_categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `periodes`
--

CREATE TABLE `periodes` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `debut` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  `annee_id` int(11) NOT NULL,
  `statut` varchar(10) DEFAULT 'actif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `periode_bulletins`
--

CREATE TABLE `periode_bulletins` (
  `id` int(11) NOT NULL,
  `periode_id` int(11) NOT NULL,
  `affectation_id` int(11) NOT NULL,
  `moyenne` float DEFAULT NULL,
  `appreciation` varchar(255) DEFAULT NULL,
  `moyenne_classe` float DEFAULT NULL,
  `meilleure_moyenne` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `periode_bulletin_lignes`
--

CREATE TABLE `periode_bulletin_lignes` (
  `id` int(11) NOT NULL,
  `periode_bulletin_id` int(11) NOT NULL,
  `cours_id` int(11) NOT NULL,
  `note` float DEFAULT NULL,
  `composition_note` float DEFAULT NULL,
  `coef` int(11) DEFAULT NULL,
  `appreciation` varchar(255) DEFAULT NULL,
  `moyenne_classe` float DEFAULT NULL,
  `meilleure_moyenne` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `presences`
--

CREATE TABLE `presences` (
  `id` int(10) UNSIGNED NOT NULL,
  `seance_id` int(11) NOT NULL,
  `eleve_id` int(11) NOT NULL,
  `type` varchar(10) DEFAULT NULL,
  `motif` text,
  `justifie` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `professeurs`
--

CREATE TABLE `professeurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `genre` varchar(1) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `etat` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `etablissement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `annee_id` int(11) NOT NULL,
  `niveau_id` int(11) NOT NULL,
  `serie_id` int(11) DEFAULT NULL,
  `moyenne_test` float DEFAULT NULL,
  `effectif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `promotions`
--

INSERT INTO `promotions` (`id`, `nom`, `annee_id`, `niveau_id`, `serie_id`, `moyenne_test`, `effectif`) VALUES
(1, 'SIXIEME', 1, 1, NULL, NULL, NULL),
(3, 'CINQUIEME', 1, 2, NULL, NULL, NULL),
(5, 'SECONDE S1', 1, 5, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reglements`
--

CREATE TABLE `reglements` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `montant` int(11) DEFAULT NULL,
  `moyen` varchar(45) DEFAULT NULL,
  `facture_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `reglements`
--

INSERT INTO `reglements` (`id`, `date`, `montant`, `moyen`, `facture_id`, `user_id`) VALUES
(1, '2018-09-24 22:03:13', 10000, 'Especes', 30, 2),
(2, '2018-09-24 22:03:47', 15000, 'Chèque', 30, 2),
(3, '2018-09-24 22:04:05', 20000, 'Virement', 29, 2);

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE `salles` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `pavillon` varchar(45) DEFAULT NULL,
  `etage` varchar(45) DEFAULT NULL,
  `capacite` int(11) DEFAULT NULL,
  `etablissement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `salles`
--

INSERT INTO `salles` (`id`, `nom`, `pavillon`, `etage`, `capacite`, `etablissement_id`) VALUES
(1, 'Afrique', 'Vert', '1', 25, 1),
(2, 'Europe', 'Jaune', '1', 30, 1);

-- --------------------------------------------------------

--
-- Structure de la table `seances`
--

CREATE TABLE `seances` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `debut` int(11) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `contenu` text,
  `etat` varchar(10) DEFAULT NULL,
  `cours_id` int(11) NOT NULL,
  `salle_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `series`
--

CREATE TABLE `series` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `description` text,
  `etablissement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='	';

--
-- Contenu de la table `series`
--

INSERT INTO `series` (`id`, `nom`, `description`, `etablissement_id`) VALUES
(1, 'Scientifique 1', 'Dominantes: Mathématiques, Sciences Physiques...', 1),
(2, 'Scientifique 2', 'Dominantes: Mathématiques, Sciences de la Vie et de la Terre', 1),
(6, 'Gestion', '.........', 1),
(7, 'Litteraire 1', '...', 1),
(8, 'Littéraire 2', '...', 1);

-- --------------------------------------------------------

--
-- Structure de la table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `description` text,
  `appreciation` varchar(255) DEFAULT NULL,
  `note` float DEFAULT NULL,
  `matiere_id` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL,
  `eleve_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tuteurs`
--

CREATE TABLE `tuteurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `entreprise` varchar(45) DEFAULT NULL,
  `fonction` varchar(45) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nationalite` int(11) DEFAULT NULL,
  `situation_matrimoniale` varchar(20) DEFAULT NULL,
  `etat` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `etablissement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tuteurs`
--

INSERT INTO `tuteurs` (`id`, `nom`, `prenom`, `telephone`, `adresse`, `entreprise`, `fonction`, `date_naissance`, `user_id`, `nationalite`, `situation_matrimoniale`, `etat`, `photo`, `etablissement_id`) VALUES
(1, 'Fall', 'Macoumba', '+221774598303', 'Thiaroye', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, 'Sene', 'Alioune Badara', '+221770000000', 'Colobane', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(4, 'Sady', 'Mouhamed', '771210404', 'Sacré coeur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(6, 'Diawara', 'Alassane', '+2210000000', 'Mermoz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `recurrence` int(11) DEFAULT NULL,
  `obligatoire` int(11) DEFAULT NULL,
  `etablissement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `types`
--

INSERT INTO `types` (`id`, `nom`, `recurrence`, `obligatoire`, `etablissement_id`) VALUES
(2, 'Inscription', 0, 1, 1),
(3, 'Scolarité', 1, 1, 1),
(4, 'Internat', 1, 0, 1),
(5, 'Transport', 1, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profil` varchar(10) DEFAULT NULL,
  `creatime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `etat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `profil`, `creatime`, `etat`) VALUES
(2, 'test@test.com', '$2y$10$SYaQ3kFCXANcT8LDL2NCiuzVqjOQilgjWaDWOnMNNcp6TOJGkY.nm', 'admin', '2018-06-25 17:59:02', 1),
(7, 'test2@test.com', '$2y$10$AY08MWg6nSqi/yIJSreVPeu3fH8U7jrtkMCDg1J/bdzxKUqCumbP.', 'comptable', '2018-07-06 11:40:03', 0),
(8, 'test3@test.com', '$2y$10$8TM2KOkFOhPjIn27N45LDek26ptQ9.AFE6KaBlb6OvyAYFmnlBkKu', 'comptable', '2018-08-03 15:53:04', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `affectations`
--
ALTER TABLE `affectations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_affectations_eleves1_idx` (`eleve_id`),
  ADD KEY `fk_affectations_classes1_idx` (`groupe_id`);

--
-- Index pour la table `annees`
--
ALTER TABLE `annees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_annees_etablissements1_idx` (`etablissement_id`);

--
-- Index pour la table `annee_bulletins`
--
ALTER TABLE `annee_bulletins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_annee_bulletins_affectations1_idx` (`affectations_id`);

--
-- Index pour la table `coefficients`
--
ALTER TABLE `coefficients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_coefficients_niveaux1_idx` (`niveau_id`),
  ADD KEY `fk_coefficients_series1_idx` (`serie_id`),
  ADD KEY `fk_coefficients_matieres1_idx` (`matiere_id`);

--
-- Index pour la table `compositions`
--
ALTER TABLE `compositions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compositions_cours1_idx` (`cours_id`);

--
-- Index pour la table `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cours_classes1_idx` (`groupe_id`),
  ADD KEY `fk_cours_matieres1_idx` (`matiere_id`),
  ADD KEY `fk_cours_professeurs1_idx` (`professeur_id`);

--
-- Index pour la table `demandes`
--
ALTER TABLE `demandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_demandes_tuteurs1_idx` (`tuteur_id`);

--
-- Index pour la table `devoirs`
--
ALTER TABLE `devoirs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_devoirs_cours1_idx` (`cours_id`);

--
-- Index pour la table `devoir_notes`
--
ALTER TABLE `devoir_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_devoir_notes_devoirs1_idx` (`devoir_id`),
  ADD KEY `fk_devoir_notes_eleves1_idx` (`eleve_id`);

--
-- Index pour la table `edt`
--
ALTER TABLE `edt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_edt_salles1_idx` (`salle_id`),
  ADD KEY `fk_edt_cours1_idx` (`cours_id`);

--
-- Index pour la table `eleves`
--
ALTER TABLE `eleves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_eleves_parents1_idx` (`tuteur_id`),
  ADD KEY `fk_eleves_users1_idx` (`user_id`),
  ADD KEY `fk_eleves_etablissements1_idx` (`etablissement_id`);

--
-- Index pour la table `employes`
--
ALTER TABLE `employes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employes_users1_idx` (`user_id`),
  ADD KEY `fk_employes_etablissements1_idx` (`etablissement_id`);

--
-- Index pour la table `emprunts`
--
ALTER TABLE `emprunts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_emprunts_users1_idx` (`user_id`),
  ADD KEY `fk_emprunts_ouvrages1_idx` (`ouvrage_id`);

--
-- Index pour la table `engagements`
--
ALTER TABLE `engagements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_engagements_frais1_idx` (`frais_id`),
  ADD KEY `fk_engagements_mois1_idx` (`debut`),
  ADD KEY `fk_engagements_inscriptions1_idx` (`inscription_id`),
  ADD KEY `fk_engagements_mois2_idx` (`fin`);

--
-- Index pour la table `enseignees`
--
ALTER TABLE `enseignees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_enseignees_matieres1_idx` (`matiere_id`),
  ADD KEY `fk_enseignees_professeurs1_idx` (`professeur_id`);

--
-- Index pour la table `etablissements`
--
ALTER TABLE `etablissements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_etablissements_configurations1_idx` (`configuration_id`),
  ADD KEY `fk_etablissements_employes1_idx` (`admin_id`),
  ADD KEY `fk_etablissements_annees1_idx` (`annee_id`);

--
-- Index pour la table `evenements`
--
ALTER TABLE `evenements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `exercices`
--
ALTER TABLE `exercices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_exercices_seances1_idx` (`seance_id`);

--
-- Index pour la table `factures`
--
ALTER TABLE `factures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_factures_mois1_idx` (`mois_id`),
  ADD KEY `fk_factures_inscriptions1_idx` (`inscription_id`),
  ADD KEY `fk_factures_types1_idx` (`type_id`);

--
-- Index pour la table `frais`
--
ALTER TABLE `frais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_frais_types1_idx` (`type_id`),
  ADD KEY `fk_frais_niveaux1_idx` (`niveau_id`),
  ADD KEY `fk_frais_series1_idx` (`serie_id`);

--
-- Index pour la table `groupes`
--
ALTER TABLE `groupes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_classes_promotions1_idx` (`promotion_id`);

--
-- Index pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_inscriptions_eleves1_idx` (`eleve_id`),
  ADD KEY `fk_inscriptions_promotions1_idx` (`promotion_id`);

--
-- Index pour la table `matieres`
--
ALTER TABLE `matieres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_matieres_etablissements1_idx` (`etablissement_id`);

--
-- Index pour la table `mois`
--
ALTER TABLE `mois`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ordre_UNIQUE` (`ordre`),
  ADD KEY `fk_mois_etablissements1_idx` (`etablissement_id`);

--
-- Index pour la table `niveaux`
--
ALTER TABLE `niveaux`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_niveaux_etablissements1_idx` (`etablissement_id`);

--
-- Index pour la table `ouvrages`
--
ALTER TABLE `ouvrages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ouvrages_ouvrage_categories1_idx` (`ouvrage_categorie_id`);

--
-- Index pour la table `ouvrage_categories`
--
ALTER TABLE `ouvrage_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `periodes`
--
ALTER TABLE `periodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_periodes_annees1_idx` (`annee_id`);

--
-- Index pour la table `periode_bulletins`
--
ALTER TABLE `periode_bulletins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_semestre_bulletins_periodes1_idx` (`periode_id`),
  ADD KEY `fk_semestre_bulletins_affectations1_idx` (`affectation_id`);

--
-- Index pour la table `periode_bulletin_lignes`
--
ALTER TABLE `periode_bulletin_lignes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_semestre_bulletin_lignes_semestre_bulletins1_idx` (`periode_bulletin_id`),
  ADD KEY `fk_semestre_bulletin_lignes_cours1_idx` (`cours_id`);

--
-- Index pour la table `presences`
--
ALTER TABLE `presences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_presences_seances1_idx` (`seance_id`),
  ADD KEY `fk_presences_eleves1_idx` (`eleve_id`);

--
-- Index pour la table `professeurs`
--
ALTER TABLE `professeurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_professeurs_users1_idx` (`user_id`),
  ADD KEY `fk_professeurs_etablissements1_idx` (`etablissement_id`);

--
-- Index pour la table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_promotions_annees_idx` (`annee_id`),
  ADD KEY `fk_promotions_niveaux1_idx` (`niveau_id`),
  ADD KEY `fk_promotions_series1_idx` (`serie_id`);

--
-- Index pour la table `reglements`
--
ALTER TABLE `reglements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reglements_factures1_idx` (`facture_id`),
  ADD KEY `fk_reglements_users1_idx` (`user_id`);

--
-- Index pour la table `salles`
--
ALTER TABLE `salles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_salles_etablissements1_idx` (`etablissement_id`);

--
-- Index pour la table `seances`
--
ALTER TABLE `seances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_seances_cours1_idx` (`cours_id`),
  ADD KEY `fk_seances_salles1_idx` (`salle_id`);

--
-- Index pour la table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_series_etablissements1_idx` (`etablissement_id`);

--
-- Index pour la table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tests_matieres1_idx` (`matiere_id`),
  ADD KEY `fk_tests_promotions1_idx` (`promotion_id`),
  ADD KEY `fk_tests_eleves1_idx` (`eleve_id`);

--
-- Index pour la table `tuteurs`
--
ALTER TABLE `tuteurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tuteurs_users1_idx` (`user_id`),
  ADD KEY `fk_tuteurs_etablissements1_idx` (`etablissement_id`);

--
-- Index pour la table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_types_etablissements1_idx` (`etablissement_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `creatime_UNIQUE` (`creatime`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `affectations`
--
ALTER TABLE `affectations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `annees`
--
ALTER TABLE `annees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `coefficients`
--
ALTER TABLE `coefficients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `compositions`
--
ALTER TABLE `compositions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `demandes`
--
ALTER TABLE `demandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `devoirs`
--
ALTER TABLE `devoirs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `devoir_notes`
--
ALTER TABLE `devoir_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `edt`
--
ALTER TABLE `edt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `eleves`
--
ALTER TABLE `eleves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `employes`
--
ALTER TABLE `employes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `emprunts`
--
ALTER TABLE `emprunts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `engagements`
--
ALTER TABLE `engagements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `enseignees`
--
ALTER TABLE `enseignees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `etablissements`
--
ALTER TABLE `etablissements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `evenements`
--
ALTER TABLE `evenements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `exercices`
--
ALTER TABLE `exercices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT pour la table `frais`
--
ALTER TABLE `frais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `groupes`
--
ALTER TABLE `groupes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `matieres`
--
ALTER TABLE `matieres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `mois`
--
ALTER TABLE `mois`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `niveaux`
--
ALTER TABLE `niveaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `ouvrages`
--
ALTER TABLE `ouvrages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ouvrage_categories`
--
ALTER TABLE `ouvrage_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `periodes`
--
ALTER TABLE `periodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `periode_bulletins`
--
ALTER TABLE `periode_bulletins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `professeurs`
--
ALTER TABLE `professeurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `reglements`
--
ALTER TABLE `reglements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `salles`
--
ALTER TABLE `salles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `seances`
--
ALTER TABLE `seances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tuteurs`
--
ALTER TABLE `tuteurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `affectations`
--
ALTER TABLE `affectations`
  ADD CONSTRAINT `fk_affectations_classes1` FOREIGN KEY (`groupe_id`) REFERENCES `groupes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_affectations_eleves1` FOREIGN KEY (`eleve_id`) REFERENCES `eleves` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `annees`
--
ALTER TABLE `annees`
  ADD CONSTRAINT `fk_annees_etablissements1` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `annee_bulletins`
--
ALTER TABLE `annee_bulletins`
  ADD CONSTRAINT `fk_annee_bulletins_affectations1` FOREIGN KEY (`affectations_id`) REFERENCES `affectations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `coefficients`
--
ALTER TABLE `coefficients`
  ADD CONSTRAINT `fk_coefficients_matieres1` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_coefficients_niveaux1` FOREIGN KEY (`niveau_id`) REFERENCES `niveaux` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_coefficients_series1` FOREIGN KEY (`serie_id`) REFERENCES `series` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `compositions`
--
ALTER TABLE `compositions`
  ADD CONSTRAINT `fk_compositions_cours1` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `fk_cours_classes1` FOREIGN KEY (`groupe_id`) REFERENCES `groupes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cours_matieres1` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cours_professeurs1` FOREIGN KEY (`professeur_id`) REFERENCES `professeurs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `demandes`
--
ALTER TABLE `demandes`
  ADD CONSTRAINT `fk_demandes_tuteurs1` FOREIGN KEY (`tuteur_id`) REFERENCES `tuteurs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `devoirs`
--
ALTER TABLE `devoirs`
  ADD CONSTRAINT `fk_devoirs_cours1` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `devoir_notes`
--
ALTER TABLE `devoir_notes`
  ADD CONSTRAINT `fk_devoir_notes_devoirs1` FOREIGN KEY (`devoir_id`) REFERENCES `devoirs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_devoir_notes_eleves1` FOREIGN KEY (`eleve_id`) REFERENCES `eleves` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `edt`
--
ALTER TABLE `edt`
  ADD CONSTRAINT `fk_edt_cours1` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_edt_salles1` FOREIGN KEY (`salle_id`) REFERENCES `salles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `eleves`
--
ALTER TABLE `eleves`
  ADD CONSTRAINT `fk_eleves_etablissements1` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_eleves_parents1` FOREIGN KEY (`tuteur_id`) REFERENCES `tuteurs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_eleves_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `employes`
--
ALTER TABLE `employes`
  ADD CONSTRAINT `fk_employes_etablissements1` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_employes_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `emprunts`
--
ALTER TABLE `emprunts`
  ADD CONSTRAINT `fk_emprunts_ouvrages1` FOREIGN KEY (`ouvrage_id`) REFERENCES `ouvrages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_emprunts_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `engagements`
--
ALTER TABLE `engagements`
  ADD CONSTRAINT `fk_engagements_frais1` FOREIGN KEY (`frais_id`) REFERENCES `frais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_engagements_inscriptions1` FOREIGN KEY (`inscription_id`) REFERENCES `inscriptions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_engagements_mois1` FOREIGN KEY (`debut`) REFERENCES `mois` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_engagements_mois2` FOREIGN KEY (`fin`) REFERENCES `mois` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `enseignees`
--
ALTER TABLE `enseignees`
  ADD CONSTRAINT `fk_enseignees_matieres1` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_enseignees_professeurs1` FOREIGN KEY (`professeur_id`) REFERENCES `professeurs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `etablissements`
--
ALTER TABLE `etablissements`
  ADD CONSTRAINT `fk_etablissements_annees1` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_etablissements_configurations1` FOREIGN KEY (`configuration_id`) REFERENCES `configurations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_etablissements_employes1` FOREIGN KEY (`admin_id`) REFERENCES `employes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `exercices`
--
ALTER TABLE `exercices`
  ADD CONSTRAINT `fk_exercices_seances1` FOREIGN KEY (`seance_id`) REFERENCES `seances` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `factures`
--
ALTER TABLE `factures`
  ADD CONSTRAINT `fk_factures_inscriptions1` FOREIGN KEY (`inscription_id`) REFERENCES `inscriptions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factures_mois1` FOREIGN KEY (`mois_id`) REFERENCES `mois` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factures_types1` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `frais`
--
ALTER TABLE `frais`
  ADD CONSTRAINT `fk_frais_niveaux1` FOREIGN KEY (`niveau_id`) REFERENCES `niveaux` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_frais_series1` FOREIGN KEY (`serie_id`) REFERENCES `series` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_frais_types1` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `groupes`
--
ALTER TABLE `groupes`
  ADD CONSTRAINT `fk_classes_promotions1` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `fk_inscriptions_eleves1` FOREIGN KEY (`eleve_id`) REFERENCES `eleves` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscriptions_promotions1` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `matieres`
--
ALTER TABLE `matieres`
  ADD CONSTRAINT `fk_matieres_etablissements1` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `mois`
--
ALTER TABLE `mois`
  ADD CONSTRAINT `fk_mois_etablissements1` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `niveaux`
--
ALTER TABLE `niveaux`
  ADD CONSTRAINT `fk_niveaux_etablissements1` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `ouvrages`
--
ALTER TABLE `ouvrages`
  ADD CONSTRAINT `fk_ouvrages_ouvrage_categories1` FOREIGN KEY (`ouvrage_categorie_id`) REFERENCES `ouvrage_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `periodes`
--
ALTER TABLE `periodes`
  ADD CONSTRAINT `fk_periodes_annees1` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `periode_bulletins`
--
ALTER TABLE `periode_bulletins`
  ADD CONSTRAINT `fk_semestre_bulletins_affectations1` FOREIGN KEY (`affectation_id`) REFERENCES `affectations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_semestre_bulletins_periodes1` FOREIGN KEY (`periode_id`) REFERENCES `periodes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `periode_bulletin_lignes`
--
ALTER TABLE `periode_bulletin_lignes`
  ADD CONSTRAINT `fk_semestre_bulletin_lignes_cours1` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_semestre_bulletin_lignes_semestre_bulletins1` FOREIGN KEY (`periode_bulletin_id`) REFERENCES `periode_bulletins` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `presences`
--
ALTER TABLE `presences`
  ADD CONSTRAINT `fk_presences_eleves1` FOREIGN KEY (`eleve_id`) REFERENCES `eleves` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_presences_seances1` FOREIGN KEY (`seance_id`) REFERENCES `seances` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `professeurs`
--
ALTER TABLE `professeurs`
  ADD CONSTRAINT `fk_professeurs_etablissements1` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_professeurs_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `fk_promotions_annees` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_promotions_niveaux1` FOREIGN KEY (`niveau_id`) REFERENCES `niveaux` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_promotions_series1` FOREIGN KEY (`serie_id`) REFERENCES `series` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `reglements`
--
ALTER TABLE `reglements`
  ADD CONSTRAINT `fk_reglements_factures1` FOREIGN KEY (`facture_id`) REFERENCES `factures` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reglements_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `salles`
--
ALTER TABLE `salles`
  ADD CONSTRAINT `fk_salles_etablissements1` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `seances`
--
ALTER TABLE `seances`
  ADD CONSTRAINT `fk_seances_cours1` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_seances_salles1` FOREIGN KEY (`salle_id`) REFERENCES `salles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `series`
--
ALTER TABLE `series`
  ADD CONSTRAINT `fk_series_etablissements1` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `fk_tests_eleves1` FOREIGN KEY (`eleve_id`) REFERENCES `eleves` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tests_matieres1` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tests_promotions1` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `tuteurs`
--
ALTER TABLE `tuteurs`
  ADD CONSTRAINT `fk_tuteurs_etablissements1` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tuteurs_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Contraintes pour la table `types`
--
ALTER TABLE `types`
  ADD CONSTRAINT `fk_types_etablissements1` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
