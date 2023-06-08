-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 31 mars 2023 à 14:02
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sta_classe`
--

INSERT INTO `sta_classe` (`idclasse`, `libelle_classe`) VALUES
(1, 'SIO1'),
(2, 'SIO2'),
(3, 'ADMIN');

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
  `mail` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `service` varchar(50) NOT NULL,
  `identreprise` int(11) DEFAULT NULL,
  PRIMARY KEY (`idcontact`),
  KEY `identreprise` (`identreprise`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sta_contact`
--

INSERT INTO `sta_contact` (`idcontact`, `nom`, `prenom`, `tel`, `mail`, `role`, `service`, `identreprise`) VALUES
(8, 'Mallet', 'Emmanuel', '02 38 78 99 52', 'Emmanuel.MALLET@cnfpt.fr ', 'DSI', 'Informatique', 1),
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
(29, 'Maury', 'Gilles', '', 'mauryg@amazon.com', 'cadre niveaux 2 de l\'équipe OpsTechIT', 'OpsTechIT', 67),
(30, 'SORIOT', 'Alexis', '0620401756', 'noc@srmi45.fr', 'Technicien', 'Technique', 68),
(31, 'BOUILLON', 'Ludovic', '', '', '', '', 5),
(32, 'Elhadji Tchiambou', 'Salay', '0609910413', '', 'Gérant', '', 72);

-- --------------------------------------------------------

--
-- Structure de la table `sta_demande`
--

DROP TABLE IF EXISTS `sta_demande`;
CREATE TABLE IF NOT EXISTS `sta_demande` (
  `iddemande` int(11) NOT NULL AUTO_INCREMENT,
  `date_demande` date NOT NULL,
  `idetudiant` int(11) NOT NULL,
  `idetat` int(11) NOT NULL,
  `idcontact` int(11) NOT NULL,
  `idperiode` int(11) NOT NULL,
  `identreprise` int(11) NOT NULL,
  `raisonRefus` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`iddemande`),
  KEY `Demande_Etudiant_FK` (`idetudiant`),
  KEY `Demande_Etat0_FK` (`idetat`),
  KEY `Demande_Periode1_FK` (`idperiode`),
  KEY `Demande_Contact_FK` (`idcontact`),
  KEY `Demande_Entreprise_FK` (`identreprise`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sta_demande`
--

INSERT INTO `sta_demande` (`iddemande`, `date_demande`, `idetudiant`, `idetat`, `idcontact`, `idperiode`, `identreprise`, `raisonRefus`) VALUES
(4, '2023-02-14', 1, 4, 8, 1, 1, NULL),
(5, '2023-02-16', 1, 6, 9, 1, 16, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sta_entreprise`
--

DROP TABLE IF EXISTS `sta_entreprise`;
CREATE TABLE IF NOT EXISTS `sta_entreprise` (
  `identreprise` int(11) NOT NULL AUTO_INCREMENT,
  `SIRET` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `codeNAF` varchar(50) CHARACTER SET utf8 NOT NULL,
  `tel` varchar(50) NOT NULL,
  `Mail` varchar(50) NOT NULL,
  `cpville` varchar(50) NOT NULL,
  `ville` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`identreprise`),
  KEY `Entreprise_NAF_FK` (`codeNAF`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sta_entreprise`
--

INSERT INTO `sta_entreprise` (`identreprise`, `SIRET`, `nom`, `codeNAF`, `tel`, `Mail`, `cpville`, `ville`) VALUES
(1, '18001404502245', 'CNFPT (CENTRE NATIONAL DE LA FONCTION PUBLIQUE TER', '73', '0238789494', 'Emmanuel.MALLET@cnfpt.fr ', '45234', NULL),
(2, '18450311800020', 'GIP Recia', '74', '02 38 42 79 60', 'contact@recia.fr', '45232', NULL),
(4, '325 184 596 00014', 'OLIVET DISTRIBUTION', '43', '0238417979', 'drh.olivet@socamaine.fr', '45232', NULL),
(5, '33856725800011', 'Leroy Somer', '26', 'inconnue', 'jean-francois.paillou@mail.nidec.com', '45284', NULL),
(6, '38536571300457', 'Gfi Informatique', '55', '01 44 04 50 00', 'cedric.menindes@gfi.fr', '45234', NULL),
(8, '39886810900040', 'Movida Production', '52', '0238772266', 'contact@movida-prod.com', '45234', NULL),
(9, '40325953400028', 'Umanis', '55', '01 76 47 09 50', 'info@umanis.com', '45234', NULL),
(10, '42164873400026', 'SARL RIBEIRO', '72', '02 38 39 87 25', 'sarlribeiro@hotmail.fr', '45095', NULL),
(11, '44177234000028', 'MSL CIRCUITS', '25', '02 38 46 35 00', 'contact.commercial@mslcircuits.com', '45203', NULL),
(12, '47990473200019', 'VAR HABITAT', '68', '0494615500', 'drh@varhabitat.com', '83144', NULL),
(13, '549 501 203 00083', 'DEGREANE', '01', '04 98 16 31 63', 'inconnue', '83049', NULL),
(14, '79907443000023', 'CIDES', '32', '0623642906', 'cides.sarl@gmail.com', '31216', NULL),
(15, '80752653800010', 'CODI ONE', '53', '08 90 10 93 74 ', 'direction@codi-one.fr', '45234', NULL),
(16, '82033907500013', 'Totale Accessibilité', '40', '0616331265', 'contact@totaleaccessibilite.fr', '45290', NULL),
(17, '83896928500017', 'M.A.M MA PETITE ENFANCE', '84', '06 13 64 42 97', 'mapetiteenfance@aol.fr', '45146', NULL),
(64, '55212022240043', 'Société Générale', '57', '', '', '45000', 'Orléans'),
(65, '314397696', 'Hutchinson', '55', '', '', '45120', 'CHÂLETTE SUR LOING'),
(66, '21860183900010', 'Mairie ORMES', '74', '0238708520', '', '45140', 'Ormes'),
(67, '42878504200048', 'Amazon', '47', '', '', '45770', 'Saran'),
(68, '53004680400023', 'SRMI', '56', '', 'noc@srmi45.fr', '45160', 'Olivet'),
(69, '', 'CNSO(Centre National de Soutien Opérationnel)', '74', '', '', '45000', 'Orléans'),
(72, '83528546100017', 'Etech services', '55', '0609910413', '', '45140', 'Ormes'),
(73, '39254968900033', 'SVI - PROSIS', '43', '0247710044', 'contact@svi-prosis.com', '37300', 'Joué Les Tours ');

-- --------------------------------------------------------

--
-- Structure de la table `sta_etat`
--

DROP TABLE IF EXISTS `sta_etat`;
CREATE TABLE IF NOT EXISTS `sta_etat` (
  `idetat` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_etat` varchar(50) NOT NULL,
  PRIMARY KEY (`idetat`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

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
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `idclasse` int(11) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 NOT NULL,
  `photo` varchar(50) CHARACTER SET utf8 NOT NULL,
  `mdp` varchar(60) CHARACTER SET utf8 NOT NULL,
  `option` enum('SISR','SLAM','NON DETERMINEE') CHARACTER SET utf8 DEFAULT NULL,
  `dateCreationCompte` date DEFAULT NULL,
  `attestStage` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `convention` varchar(50) DEFAULT NULL,
  `eval` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `anneePro` year(4) DEFAULT NULL,
  `failed_login` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idetudiant`),
  UNIQUE KEY `email` (`email`),
  KEY `FK_classe` (`idclasse`)
) ENGINE=InnoDB AUTO_INCREMENT=1510 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sta_etudiant`
--

INSERT INTO `sta_etudiant` (`idetudiant`, `nom`, `prenom`, `idclasse`, `email`, `photo`, `mdp`, `option`, `dateCreationCompte`, `attestStage`, `convention`, `eval`, `anneePro`, `failed_login`) VALUES
(1, 'testEtu', 'testEtu', 2, 'testEtu@testEtu.fr', '1_profile.jpg', '26e0afab0010d6c5640de19c712042d4', 'SLAM', NULL, NULL, 0, NULL, NULL, 0),
(1498, 'cau', 'antoine', 1, 'nope@test.fr', '1498_profile.jpg', '1a1dc91c907325c69271ddf0c944bc72', 'SISR', '2023-01-25', '1498_cau_profile.jpg', 0, '1498_cau_profile.jpg', 2023, 0),
(1503, 'koneko', 'dxd', 4, 'dxd@dxd.fr', 'membres.png', '4b227089dfaa0df4c025b2b509c2e70c', 'SLAM', '2023-01-26', NULL, 1, NULL, 2023, 1),
(1507, 'deviluke', 'lala', 3, 'lala@lala.fr', '', '63a9f0ea7bb98050796b649e85481845', NULL, NULL, NULL, 0, NULL, NULL, 0),
(1508, 'admin', 'admin', 3, 'admin@admin.fr', 'membres.png', '1a1dc91c907325c69271ddf0c944bc72', 'SLAM', '2023-02-01', NULL, NULL, '1508_admin_epreuves bts.png', 2023, 4);

-- --------------------------------------------------------

--
-- Structure de la table `sta_naf`
--

DROP TABLE IF EXISTS `sta_naf`;
CREATE TABLE IF NOT EXISTS `sta_naf` (
  `code_NAF` int(11) DEFAULT NULL,
  `libelle_NAF` char(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `sta_naf`
--

INSERT INTO `sta_naf` (`code_NAF`, `libelle_NAF`) VALUES
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
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `idclasse` int(10) DEFAULT NULL,
  PRIMARY KEY (`idperiode`),
  KEY `index_periode` (`idclasse`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
  `token` int(11) NOT NULL,
  `idetudiant` int(11) NOT NULL,
  KEY `reset_etudiant` (`idetudiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sta_ticket`
--

DROP TABLE IF EXISTS `sta_ticket`;
CREATE TABLE IF NOT EXISTS `sta_ticket` (
  `id_ticket` int(11) NOT NULL AUTO_INCREMENT,
  `id_etudiant` int(11) NOT NULL,
  `motif_ticket` varchar(255) NOT NULL,
  `date_ticket` date DEFAULT NULL,
  `statut` enum('En attente','Résolu','','') DEFAULT 'En attente',
  PRIMARY KEY (`id_ticket`),
  KEY `id_etudiant` (`id_etudiant`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sta_ticket`
--

INSERT INTO `sta_ticket` (`id_ticket`, `id_etudiant`, `motif_ticket`, `date_ticket`, `statut`) VALUES
(1, 1, 'TestMotifTicket', '2023-01-06', 'Résolu'),
(3, 1498, 'machin', '2023-02-03', 'Résolu'),
(4, 1498, 'un long message comme ça ça te va ????', '2023-02-03', 'Résolu');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_enchanced_program` tinyint(1) NOT NULL DEFAULT '0',
  `authenticity_token` varchar(100) NOT NULL,
  `pin` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `is_enchanced_program`, `authenticity_token`, `pin`) VALUES
(2, 'john', 'doe', 'john.doe@test.com', 'a722c63db8ec8625af6cf71cb8c2d939', 0, 'ef9a481b4b71194edc63aa726f8fad30', '81dc9bdb52d04dc20036dbd8313ed055'),
(3, 'zoe', 'lou', 'zoe.lou@test.com', 'c1572d05424d0ecb2a65ec6a82aeacbf', 0, '2c09dbcfd58c601a005c91bbfc7d1ea2', '674f3c2c1a8a6f90461e8a66fb5550ba');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `sta_contact`
--
ALTER TABLE `sta_contact`
  ADD CONSTRAINT `sta_contact_ibfk_1` FOREIGN KEY (`identreprise`) REFERENCES `sta_entreprise` (`identreprise`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sta_demande`
--
ALTER TABLE `sta_demande`
  ADD CONSTRAINT `FK_contact` FOREIGN KEY (`idcontact`) REFERENCES `sta_contact` (`idcontact`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_entreprise` FOREIGN KEY (`identreprise`) REFERENCES `sta_entreprise` (`identreprise`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_etat` FOREIGN KEY (`idetat`) REFERENCES `sta_etat` (`idetat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_etudiant` FOREIGN KEY (`idetudiant`) REFERENCES `sta_etudiant` (`idetudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_periode` FOREIGN KEY (`idperiode`) REFERENCES `sta_periode` (`idperiode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sta_periode`
--
ALTER TABLE `sta_periode`
  ADD CONSTRAINT `FK_Classe` FOREIGN KEY (`idclasse`) REFERENCES `sta_classe` (`idclasse`);

--
-- Contraintes pour la table `sta_reset`
--
ALTER TABLE `sta_reset`
  ADD CONSTRAINT `reset_etudiant` FOREIGN KEY (`idetudiant`) REFERENCES `sta_etudiant` (`idetudiant`);

--
-- Contraintes pour la table `sta_ticket`
--
ALTER TABLE `sta_ticket`
  ADD CONSTRAINT `sta_ticket_ibfk_1` FOREIGN KEY (`id_etudiant`) REFERENCES `sta_etudiant` (`idetudiant`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
