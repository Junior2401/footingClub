-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 15 jan. 2024 à 17:01
-- Version du serveur : 5.7.36
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `footing_club`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `code`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'BSKT', 'Basketball', '2024-01-13 13:23:02', NULL),
(2, 'SCCR', 'Soccer', '2024-01-13 13:26:35', NULL),
(3, 'TNNS', 'Tennis', '2024-01-13 13:26:53', NULL),
(4, 'SSWM', 'Swimming', '2024-01-13 13:27:09', NULL),
(5, 'ATHL', 'Athletics', '2024-01-13 13:27:25', NULL),
(6, 'GOLF', 'Golf', '2024-01-13 13:27:49', NULL),
(7, 'VOLY', 'Volleyball', '2024-01-13 13:28:07', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`,`telephone`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id`, `nom`, `prenom`, `email`, `telephone`, `created_at`, `updated_at`) VALUES
(1, 'Dupont', 'Jean', 'jean.dupont@example.com', '111-111-1111', '2024-01-13 13:45:51', NULL),
(2, 'Martin    ', 'Marie', 'marie.martin@example.com', '222-222-2222', '2024-01-13 13:46:52', NULL),
(3, 'Dubois', 'Pierre', 'pierre.dubois@example.com', '333-333-3333', '2024-01-13 13:47:47', NULL),
(4, 'Tremblay', 'Sophie', 'sophie.tremblay@example.com', '444-444-4444', '2024-01-13 13:48:33', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240110203221', '2024-01-10 20:33:27', 130);

-- --------------------------------------------------------

--
-- Structure de la table `educateurs`
--

DROP TABLE IF EXISTS `educateurs`;
CREATE TABLE IF NOT EXISTS `educateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` tinyint(1) NOT NULL,
  `licencie_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `licencie_id` (`licencie_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `educateurs`
--

INSERT INTO `educateurs` (`id`, `email`, `password`, `roles`, `licencie_id`, `created_at`, `updated_at`) VALUES
(1, 'alialissou@gmail.com', '$2y$13$YmfHp4KKtt1eppFnRIHbo.7/2dL.pj3TUtxwqrppwbap3Af4zl9i.', 1, 0, '2024-01-13 13:18:26', '2024-01-15 15:44:45'),
(2, 'antoine.lefevre@example.com', '670b14728ad9902aecba32e22fa4f6bd', 0, 1, '2024-01-13 13:51:51', NULL),
(3, 'elise.girard@example.com', '670b14728ad9902aecba32e22fa4f6bd', 1, 2, '2024-01-13 13:53:23', NULL),
(4, 'thomas.bernard@example.com', '670b14728ad9902aecba32e22fa4f6bd', 0, 3, '2024-01-13 13:54:24', NULL),
(6, 'emma.rousseau@example.com', '670b14728ad9902aecba32e22fa4f6bd', 1, 5, '2024-01-15 08:07:36', NULL),
(7, 'jinadu.adeola@gmail.com', '670b14728ad9902aecba32e22fa4f6bd', 1, 6, '2024-01-15 13:26:59', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `licencies`
--

DROP TABLE IF EXISTS `licencies`;
CREATE TABLE IF NOT EXISTS `licencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `licence` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `categorie_id` (`categorie_id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `licencies`
--

INSERT INTO `licencies` (`id`, `licence`, `nom`, `prenom`, `categorie_id`, `contact_id`, `created_at`, `updated_at`) VALUES
(1, 'WXYZ-5678-ABCD-1234', 'Lefevre', 'Antoine', 6, 1, '2024-01-13 13:51:51', NULL),
(2, 'QRST-9876-EFGH-5678', 'Girard', 'Elise', 2, 2, '2024-01-13 13:53:23', NULL),
(3, 'UVWX-1234-IJKL-5678', 'Bernard', 'Thomas', 3, 3, '2024-01-13 13:54:24', NULL),
(5, 'KCNJXX52518XXF', 'EMMA', 'Rousseau', 3, 3, '2024-01-15 08:07:36', NULL),
(6, 'UVWX-1234-IJKL-5677', 'JINADU', 'Adeola', 7, 4, '2024-01-15 13:26:59', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `mail_contact`
--

DROP TABLE IF EXISTS `mail_contact`;
CREATE TABLE IF NOT EXISTS `mail_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_envoi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mail_contacts`
--

DROP TABLE IF EXISTS `mail_contacts`;
CREATE TABLE IF NOT EXISTS `mail_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateEnvoi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `objet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mail_contacts`
--

INSERT INTO `mail_contacts` (`id`, `dateEnvoi`, `objet`, `message`) VALUES
(1, '2024-01-14 01:04:51', 'Repport de séance', 'Je valide le repport'),
(2, '2024-01-14 01:07:16', 'Partie 1: PHP DAO/MVC', '1)Vous devrez coder les classes categorie, licencié, contact et éducateur.\nVous devrez réaliser une mini application backend en PHP objet avec MVC et DAO qui permet de :\n2)créer/modifier/supprimer une catégorie /lister les categories\n3)créer/modifier/supprimer un licencié /lister les licenciés\n4)créer/modifier/supprimer un licencié /lister les educateurs\n5)créer/modifier/supprimer un contact d\'un licencié\n6)Cette partie de l\'application est accessible via une authentification via email et mot de passe aux seuls éducateurs\nqui sont administrateurs.');

-- --------------------------------------------------------

--
-- Structure de la table `mail_contact_contacts`
--

DROP TABLE IF EXISTS `mail_contact_contacts`;
CREATE TABLE IF NOT EXISTS `mail_contact_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_contact_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mail_edu_id` (`mail_contact_id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `mail_contact_contacts`
--

INSERT INTO `mail_contact_contacts` (`id`, `mail_contact_id`, `contact_id`) VALUES
(1, 1, 1),
(3, 2, 1),
(4, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `mail_edu`
--

DROP TABLE IF EXISTS `mail_edu`;
CREATE TABLE IF NOT EXISTS `mail_edu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateEnvoi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `objet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mail_edu`
--

INSERT INTO `mail_edu` (`id`, `dateEnvoi`, `objet`, `message`) VALUES
(1, '2024-01-13 14:00:55', 'Recommandation', 'À qui de droit,\n\nJe vous écris pour recommander chaleureusement [Nom de votre ami] pour un éventuel stage au sein de [Nom de l\'entreprise]. Je connais [Nom de votre ami] depuis [durée de votre connaissance] et je peux témoigner de ses compétences exceptionnelles ainsi que de sa passion pour [domaine d\'intérêt].\n\n[Nom de votre ami] est une personne hautement motivée, dotée d\'une forte éthique de travail et d\'une volonté d\'apprendre constamment. Son engagement envers [domaine d\'intérêt] est remarquable et a été démontré à travers [mentionnez des projets, expériences pertinentes].\n\nEn plus de ses compétences techniques impressionnantes, [Nom de votre ami] possède d\'excellentes compétences en [compétences spécifiques pertinentes pour le stage], ce qui, je crois, serait un atout précieux pour votre équipe. Sa capacité à [compétences clés] lui permettrait de s\'intégrer harmonieusement dans un environnement professionnel et d\'apporter une contribution significative.\n\nJe suis convaincu que [Nom de votre ami] serait un stagiaire exceptionnel pour votre entreprise, apportant non seulement des compétences solides, mais aussi une attitude positive, un travail assidu et un désir constant d\'apprendre et de contribuer.\n\nJe vous encourage vivement à considérer la candidature de [Nom de votre ami] pour le stage disponible au sein de votre entreprise. Si vous avez besoin de plus d\'informations ou d\'éclaircissements, n\'hésitez pas à me contacter.\n\nJe vous remercie sincèrement pour votre considération.\n\nCordialement,\n\n[Votre nom]\n[Votre poste]\n[Nom de l\'entreprise]\n[Coordonnées]'),
(2, '2024-01-13 14:05:11', 'Rapport de science', 'Partie 2: Symfony\nVous devrez réaliser la partie front end de cette application, à savoir que les éducateurs peuvent se connecter (8) à\ncette application pour :\n1) visualiser la liste des licenciés d\'une catégorie\n2) visualiser la liste des contacts d\'une catégorie\n3) visualiser la liste des mails envoyés aux autres éducateurs/supprimer un mail envoyé\n4) visualiser la liste des mails envoyés aux contacts d\'un ou plusieurs catégories/supprimer un mail envoyé\n5) ecrire un mail aux autres éducateurs6) ecrire un mail aux contacts d\'une ou plusieurs catégories\n7)vous aurez donc besoin à minima en supplément des classes suivantes :\nmailEdu avec comme attributs: date d\'envoi, objet, message, la collection des educateurs auquel ce message était\ndestiné.\nmailContact avec comme attributs: date d\'envoi, objet, message, la collection des licenciés (en fait leur contact)\nauquel ce message était destiné.\nVous devrez implémenter chaque fonctionnalité (de 1 à 8) et pusher sur git (public ou partagé avec\nvirginie.sans@irisa.fr) chaque fonctionnalité au fur et à mesure - prévoyez une branche pour cette partie également.\nUne petite vidéo démo est également demandée pour cette partie.\nDélai max: fin de la premiere semaine de cours de janvier (en tout cas, faites des push réguliers - et les deux\nbinômes feront des push...)\nRappel : on ne vous demande pas d\'etre des intégrateurs css, donc vous pouvez utiliser tous les templates,\nframeworks type bootstrap qui vous facilite les choses....\nModalité de rendu : me prévenir à la lecture du sujet qui est votre binome et l\'adresse de votre git, le reste je le\nrecupere sur git'),
(3, '2024-01-14 00:56:12', 'Repport de séance', 'Validé');

-- --------------------------------------------------------

--
-- Structure de la table `mail_edu_educateurs`
--

DROP TABLE IF EXISTS `mail_edu_educateurs`;
CREATE TABLE IF NOT EXISTS `mail_edu_educateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_edu_id` int(11) NOT NULL,
  `educateur_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mail_edu_id` (`mail_edu_id`),
  KEY `educateur_id` (`educateur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `mail_edu_educateurs`
--

INSERT INTO `mail_edu_educateurs` (`id`, `mail_edu_id`, `educateur_id`) VALUES
(5, 3, 1),
(6, 3, 2);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
