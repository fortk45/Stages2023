-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 07 avr. 2023 à 11:44
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `stages`
--

-- --------------------------------------------------------

--
-- Structure de la table `sta_classe`
--

DROP TABLE IF EXISTS `sta_classe`;
CREATE TABLE IF NOT EXISTS `sta_classe` (
  `idclasse` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_classe` varchar(50) NOT NULL,
  PRIMARY KEY (`idclasse`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sta_classe`
--

INSERT INTO `sta_classe` (`idclasse`, `libelle_classe`) VALUES
(1, 'SIO1'),
(2, 'SIO2'),
(3, 'ADMIN'),
(4, 'ARCHIVE');

-- --------------------------------------------------------

--
-- Structure de la table `sta_contact`
--

DROP TABLE IF EXISTS `sta_contact`;
CREATE TABLE IF NOT EXISTS `sta_contact` (
  `idcontact` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `service` varchar(50) NOT NULL,
  `identreprise` int(11) NOT NULL,
  PRIMARY KEY (`idcontact`),
  KEY `sta_contact_sta_entreprise_FK` (`identreprise`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sta_contact`
--

INSERT INTO `sta_contact` (`idcontact`, `nom`, `prenom`, `tel`, `mail`, `role`, `service`, `identreprise`) VALUES
(9, 'JLAIEL', 'Nabil', '0616331265', 'contact@totaleaccessibilite.fr', 'Dirigeant', 'Direction', 16),
(10, 'BERTHOU', 'Mégane', '0494615527', 'mberthou@varhabitat.com', 'DRH', 'RH', 12),
(11, 'PINTO', 'Philippe', '0623642906', 'cides.sarl@gmail.com', 'Gérant', 'Gérant', 14),
(12, 'Ribeiro', 'Carlos', '0238398725', 'sarlribeiro@hotmail.fr', 'Chef Entreprise', 'Peinture et Décoration', 10),
(13, 'ROUSSEAU', 'Rose', '0613644297', 'rose.rousseau@sfr.fr', 'Membre', 'Responsable', 17),
(14, 'Negrini', 'Sébastien', '0238417979', 'sebastien.negrini@socamaine.fr', 'Responsable du service informatique', 'Informatique', 4),
(15, 'Marechal', 'Vanessa', '+33 (0)2 38 46 59 26', 'vanessa.marechal@allcircuits.com', 'Gestionnaire Formation', 'RH', 11),
(17, 'Diaz', 'Marion', '01 76 47 09 50', 'mdiaz@umanis.com', 'Responsable Ressources Humaines', 'RH', 9),
(18, 'Alves', 'Lydie', '02 38 45 07 55', 'lydie.alves@gfi.fr', 'Responsable Ressources Humaines', 'RH', 6),
(19, 'Jouin', 'Olivier', '0238427961             ', 'olivier.jouin@recia.fr', 'Directeur', 'Direction', 2),
(20, 'Potier', 'Lydie', '0000000000', 'lydie@movida-mail.com', 'Secrétaire', 'Service', 8),
(21, 'PAILLOU', 'Jean-François ', 'inconnue', 'jean-francois.paillou@mail.nidec.com', 'Responsable du Bureau d\\\'Etudes Electronique', 'Bureau d\\\'Etudes Electronique', 5),
(23, 'Caillon-Jimenez', 'Cécilia', '0238604233', 'cecilia.CAILLON-JIMENEZ@mail.nidec.com', 'RH', 'RH', 5),
(24, 'Esteves', 'Thomas', '0238463614', 'thomas.esteves@allcircuits.com', 'Superviseur', 'Maintenance', 11),
(25, 'Geslin', 'Nicolas', '', 'nicolas.geslin@socgen.com', 'Développeur Web', 'RDD', 64),
(26, 'Roger', 'Adrien', '', '', '', '', 65),
(27, 'Geslin', 'Nicolas', '', 'nicolas.geslin@socgen.com', 'Service Line Manager', 'GTS', 64),
(28, 'WILLIATTE', 'Dimitri', '', '', 'Resp service informatique ', 'Service informatique ', 66),
(30, 'SORIOT', 'Alexis', '0620401756', 'noc@srmi45.fr', 'Technicien', 'Technique', 68),
(31, 'BOUILLON', 'Ludovic', '', '', '', '', 5);

-- --------------------------------------------------------

--
-- Structure de la table `sta_demande`
--

DROP TABLE IF EXISTS `sta_demande`;
CREATE TABLE IF NOT EXISTS `sta_demande` (
  `iddemande` int(11) NOT NULL AUTO_INCREMENT,
  `date_demande` date NOT NULL,
  `raisonRefus` varchar(250) DEFAULT NULL,
  `idetudiant` int(11) NOT NULL,
  `idetat` int(11) NOT NULL,
  `idcontact` int(11) NOT NULL,
  `idperiode` int(11) NOT NULL,
  PRIMARY KEY (`iddemande`),
  KEY `sta_demande_sta_contact1_FK` (`idcontact`),
  KEY `sta_demande_sta_etat0_FK` (`idetat`),
  KEY `sta_demande_sta_etudiant_FK` (`idetudiant`),
  KEY `sta_demande_sta_periode2_FK` (`idperiode`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sta_entreprise`
--

DROP TABLE IF EXISTS `sta_entreprise`;
CREATE TABLE IF NOT EXISTS `sta_entreprise` (
  `identreprise` int(11) NOT NULL AUTO_INCREMENT,
  `SIRET` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `Mail` varchar(50) NOT NULL,
  `cpville` varchar(50) NOT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `codeNAF` int(11) NOT NULL,
  PRIMARY KEY (`identreprise`),
  KEY `sta_entreprise_sta_naf_FK` (`codeNAF`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sta_entreprise`
--

INSERT INTO `sta_entreprise` (`identreprise`, `SIRET`, `nom`, `tel`, `Mail`, `cpville`, `ville`, `codeNAF`) VALUES
(2, '18450311800020', 'GIP Recia', '02 38 42 79 60', 'contact@recia.fr', '45232', NULL, 74),
(4, '325 184 596 00014', 'OLIVET DISTRIBUTION', '0238417979', 'drh.olivet@socamaine.fr', '45232', NULL, 43),
(5, '33856725800011', 'Leroy Somer', 'inconnue', 'jean-francois.paillou@mail.nidec.com', '45284', NULL, 26),
(6, '38536571300457', 'Gfi Informatique', '01 44 04 50 00', 'cedric.menindes@gfi.fr', '45234', NULL, 55),
(8, '39886810900040', 'Movida Production', '0238772266', 'contact@movida-prod.com', '45234', NULL, 52),
(9, '40325953400028', 'Umanis', '01 76 47 09 50', 'info@umanis.com', '45234', NULL, 55),
(10, '42164873400026', 'SARL RIBEIRO', '02 38 39 87 25', 'sarlribeiro@hotmail.fr', '45095', NULL, 72),
(11, '44177234000028', 'MSL CIRCUITS', '02 38 46 35 00', 'contact.commercial@mslcircuits.com', '45203', NULL, 25),
(12, '47990473200019', 'VAR HABITAT', '0494615500', 'drh@varhabitat.com', '83144', NULL, 68),
(13, '549 501 203 00083', 'DEGREANE', '04 98 16 31 63', 'inconnue', '83049', NULL, 1),
(14, '79907443000023', 'CIDES', '0623642906', 'cides.sarl@gmail.com', '31216', NULL, 32),
(15, '80752653800010', 'CODI ONE', '08 90 10 93 74 ', 'direction@codi-one.fr', '45234', NULL, 53),
(16, '82033907500013', 'Totale Accessibilité', '0616331265', 'contact@totaleaccessibilite.fr', '45290', NULL, 40),
(17, '83896928500017', 'M.A.M MA PETITE ENFANCE', '06 13 64 42 97', 'mapetiteenfance@aol.fr', '45146', NULL, 84),
(64, '55212022240043', 'Société Générale', '', '', '45000', 'Orléans', 57),
(65, '314397696', 'Hutchinson', '', '', '45120', 'CHÂLETTE SUR LOING', 55),
(66, '21860183900010', 'Mairie ORMES', '0238708520', '', '45140', 'Ormes', 74),
(68, '53004680400023', 'SRMI', '', 'noc@srmi45.fr', '45160', 'Olivet', 56),
(69, '', 'CNSO(Centre National de Soutien Opérationnel)', '', '', '45000', 'Orléans', 74),
(73, '39254968900033', 'SVI - PROSIS', '0247710044', 'contact@svi-prosis.com', '37300', 'Joué Les Tours ', 43);

-- --------------------------------------------------------

--
-- Structure de la table `sta_etat`
--

DROP TABLE IF EXISTS `sta_etat`;
CREATE TABLE IF NOT EXISTS `sta_etat` (
  `idetat` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_etat` varchar(50) NOT NULL,
  PRIMARY KEY (`idetat`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sta_etat`
--

INSERT INTO `sta_etat` (`idetat`, `libelle_etat`) VALUES
(4, 'Validé'),
(5, 'En cours'),
(6, 'Refusé'),
(7, 'Effectué');

-- --------------------------------------------------------

--
-- Structure de la table `sta_etudiant`
--

DROP TABLE IF EXISTS `sta_etudiant`;
CREATE TABLE IF NOT EXISTS `sta_etudiant` (
  `idetudiant` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `idclasse` int(11) NOT NULL,
  `option` varchar(60) DEFAULT NULL,
  `dateCreationCompte` date DEFAULT NULL,
  `attestStage` varchar(50) DEFAULT NULL,
  `convention` varchar(50) DEFAULT NULL,
  `eval` varchar(50) DEFAULT NULL,
  `anneePro` year(4) DEFAULT NULL,
  `failed_login` int(11) NOT NULL,
  PRIMARY KEY (`idetudiant`),
  KEY `sta_etudiant_sta_classe_FK` (`idclasse`)
) ENGINE=InnoDB AUTO_INCREMENT=1509 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sta_etudiant`
--

INSERT INTO `sta_etudiant` (`idetudiant`, `email`, `nom`, `prenom`, `photo`, `mdp`, `idclasse`, `option`, `dateCreationCompte`, `attestStage`, `convention`, `eval`, `anneePro`, `failed_login`) VALUES
(1498, 'nope@test.fr', 'cau', 'antoine', '1498_profile.jpg', '1a1dc91c907325c69271ddf0c944bc72', 1, 'SISR', '2023-01-25', '1498_cau_profile.jpg', '0', '1498_cau_profile.jpg', 2023, 0),
(1503, 'kefort@stpbb.org', 'koneko', 'dxd', 'membres.png', '1a1dc91c907325c69271ddf0c944bc72', 2, 'SLAM', '2023-01-26', NULL, '1', NULL, 2023, 2),
(1508, 'admin@admin.fr', 'admin', 'admin', 'membres.png', '1a1dc91c907325c69271ddf0c944bc72', 3, 'SLAM', '2023-02-01', NULL, NULL, '1508_admin_epreuves bts.png', 2023, 4);

-- --------------------------------------------------------

--
-- Structure de la table `sta_naf`
--

DROP TABLE IF EXISTS `sta_naf`;
CREATE TABLE IF NOT EXISTS `sta_naf` (
  `code_naf` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_naf` char(50) NOT NULL,
  PRIMARY KEY (`code_naf`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sta_naf`
--

INSERT INTO `sta_naf` (`code_naf`, `libelle_naf`) VALUES
(1, 'Culture et production animale \r\nchasse et services'),
(2, 'Sylviculture et exploitation \r\nforestière'),
(3, 'Pêche et aquaculture'),
(4, 'Extraction houille et lignite'),
(5, 'Extraction d\'hydrocarbures'),
(6, 'Extraction de minerais\r\nmétalliques'),
(7, 'Autres industries extractives'),
(8, 'Serv soutien aux ind ext'),
(9, 'Industries alimentaires'),
(10, 'Fabrication de boissons'),
(11, 'Fabrication produits à base de tabac'),
(12, 'Fabrication de textile'),
(13, 'Industrie de l\'habillement'),
(14, 'Industrie du cuir et de la chaussure'),
(15, 'Travail du bois et fab. d\'art. en \r\nbois et en liè'),
(16, 'Industrie du papier et carton'),
(17, 'Imprimerie et reproduction \r\nd\'enregistrements'),
(18, 'Cokéfaction et raffinage'),
(19, 'Industrie chimique'),
(20, 'Industrie pharmaceutique'),
(21, 'Fab. de pdts en caoutchouc et \r\nen plastique'),
(22, 'Fab. d\'autres produits minéraux \r\nnon métalliques'),
(23, 'Metallurgie'),
(24, 'Fab. de produits métalliques \r\nsauf des machines e'),
(25, 'Fab. produits informatiques \r\nélectroniques et opt'),
(26, 'Fabrication d\'équipements \r\nélectriques'),
(27, 'Fabrication de machines et \r\néquipements n.c.a'),
(28, 'Industrie auto'),
(29, 'Fabrication d\'autres matériels \r\nde transport'),
(30, 'Fabrication de meubles'),
(31, 'Autres industries \r\nmanufacturières'),
(32, 'Réparation et installation de \r\nmachines et d\'équi'),
(33, 'Production et distribution \r\nd\'électricité, de gaz'),
(34, 'Captage trait. dist. Eau'),
(35, 'Collecte trait. eaux usées'),
(36, 'Collecte traitement élimination \r\ndes déchets récu'),
(37, 'Dépollut° gestion déchets'),
(38, 'Construction de bâtiments'),
(39, 'Génie civil'),
(40, 'Travaux de construction \r\nspécialisés'),
(41, 'Commerce réparation \r\nd\'automobiles et motocycles'),
(42, 'Commerce de gros\r\nsauf des automobiles et des \r\nmo'),
(43, 'Commerce de détail\r\nsauf des automobiles et des \r\n'),
(44, 'Transports terrestres et \r\ntransport par conduites'),
(45, 'Transports par eau'),
(46, 'Transports aériens'),
(47, 'Entreposage et services \r\nauxiliaires des transpor'),
(48, 'Activité de poste et courrier'),
(49, 'Hébergement'),
(50, 'Restauration'),
(51, 'Edition'),
(52, 'Production de films vidéo \r\nprogramme télévision \r'),
(53, 'Programmation et diffusion'),
(54, 'Télécommunications'),
(55, 'Programmation conseil et \r\nautres act. informatiqu'),
(56, 'Services d\'information'),
(57, 'Act. des services financiers hors \r\nassurance et c'),
(58, 'Assurance'),
(59, 'Activités auxiliaires de services \r\nfinanciers et'),
(60, 'Activités immobilières'),
(61, 'Act. juridiques comptables'),
(62, 'Act. des sièges sociaux conseil \r\nde gestion'),
(63, 'Architecture et ingénierie \r\ncontrôle et analyses\r'),
(64, 'Recherche développement \r\nscientifique'),
(65, 'Publicité, études de marché'),
(66, 'Autres act. spécialisées \r\nscientifiques et techni'),
(67, 'Vétérinaires'),
(68, 'Activité de location et location-\r\nbail'),
(69, 'Activités liées à l\'emploi'),
(70, 'Agences de voyages et activités \r\nconnexes'),
(71, 'Enquêtes et sécurité'),
(72, 'Services relatifs aux bât. \r\naménagement paysager'),
(73, 'Activités administratives et \r\nautres act. de sout'),
(74, 'Administration publique et \r\ndéfense\r\nSécurité soc'),
(75, 'Enseignement'),
(76, 'Activités pour la santé humaine'),
(77, 'Hébergement médico-social et \r\nsocial'),
(78, 'Action sociale sans \r\nhébergement'),
(79, 'Activités créatives artistiques et \r\nde spectacle'),
(80, 'Bibliothèques archives musée et \r\nautres activités'),
(81, 'Activités sportives récréatives et \r\nde loisirs'),
(82, 'Activités des organisations \r\nassociatives'),
(83, 'Réparation d\'ordinateurs et de \r\nbiens personnels'),
(84, 'Autres services personnels'),
(85, 'Activités des ménages'),
(86, 'Act. ind. des ménages'),
(87, 'Org. extraterritoriaux');

-- --------------------------------------------------------

--
-- Structure de la table `sta_periode`
--

DROP TABLE IF EXISTS `sta_periode`;
CREATE TABLE IF NOT EXISTS `sta_periode` (
  `idperiode` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `idclasse` int(11) NOT NULL,
  PRIMARY KEY (`idperiode`),
  KEY `sta_periode_sta_classe_FK` (`idclasse`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sta_periode`
--

INSERT INTO `sta_periode` (`idperiode`, `date_debut`, `date_fin`, `idclasse`) VALUES
(1, '2023-02-04', '2023-02-25', 1),
(10, '2023-02-11', '2023-02-25', 2);

-- --------------------------------------------------------

--
-- Structure de la table `sta_reset`
--

DROP TABLE IF EXISTS `sta_reset`;
CREATE TABLE IF NOT EXISTS `sta_reset` (
  `id_token` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(60) NOT NULL,
  `idetudiant` int(11) NOT NULL,
  PRIMARY KEY (`id_token`),
  KEY `sta_reset_sta_etudiant_FK` (`idetudiant`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sta_ticket`
--

DROP TABLE IF EXISTS `sta_ticket`;
CREATE TABLE IF NOT EXISTS `sta_ticket` (
  `id_ticket` int(11) NOT NULL AUTO_INCREMENT,
  `motif_ticket` varchar(255) NOT NULL,
  `date_ticket` date NOT NULL,
  `statut` varchar(50) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  PRIMARY KEY (`id_ticket`),
  KEY `sta_ticket_sta_etudiant_FK` (`id_etudiant`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sta_ticket`
--

INSERT INTO `sta_ticket` (`id_ticket`, `motif_ticket`, `date_ticket`, `statut`, `id_etudiant`) VALUES
(3, 'machin', '2023-02-03', 'Résolu', 1498),
(4, 'un long message comme ça ça te va ????', '2023-02-03', 'Résolu', 1498);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `sta_contact`
--
ALTER TABLE `sta_contact`
  ADD CONSTRAINT `sta_contact_sta_entreprise_FK` FOREIGN KEY (`identreprise`) REFERENCES `sta_entreprise` (`identreprise`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sta_demande`
--
ALTER TABLE `sta_demande`
  ADD CONSTRAINT `sta_demande_sta_contact1_FK` FOREIGN KEY (`idcontact`) REFERENCES `sta_contact` (`idcontact`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sta_demande_sta_etat0_FK` FOREIGN KEY (`idetat`) REFERENCES `sta_etat` (`idetat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sta_demande_sta_etudiant_FK` FOREIGN KEY (`idetudiant`) REFERENCES `sta_etudiant` (`idetudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sta_demande_sta_periode2_FK` FOREIGN KEY (`idperiode`) REFERENCES `sta_periode` (`idperiode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sta_entreprise`
--
ALTER TABLE `sta_entreprise`
  ADD CONSTRAINT `sta_entreprise_sta_naf_FK` FOREIGN KEY (`codeNAF`) REFERENCES `sta_naf` (`code_naf`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sta_etudiant`
--
ALTER TABLE `sta_etudiant`
  ADD CONSTRAINT `sta_etudiant_sta_classe_FK` FOREIGN KEY (`idclasse`) REFERENCES `sta_classe` (`idclasse`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sta_periode`
--
ALTER TABLE `sta_periode`
  ADD CONSTRAINT `sta_periode_sta_classe_FK` FOREIGN KEY (`idclasse`) REFERENCES `sta_classe` (`idclasse`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sta_reset`
--
ALTER TABLE `sta_reset`
  ADD CONSTRAINT `sta_reset_sta_etudiant_FK` FOREIGN KEY (`idetudiant`) REFERENCES `sta_etudiant` (`idetudiant`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sta_ticket`
--
ALTER TABLE `sta_ticket`
  ADD CONSTRAINT `sta_ticket_sta_etudiant_FK` FOREIGN KEY (`id_etudiant`) REFERENCES `sta_etudiant` (`idetudiant`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
