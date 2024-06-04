SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `dp-allobobo_bdd`
--

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

CREATE TABLE IF NOT EXISTS `rdv` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jour` datetime NOT NULL,
  `id_medecin` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `annulation` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
);

--
-- Contenu de la table `rdv`
--

INSERT INTO `rdv` (`id`, `jour`, `id_medecin`, `nom`, `email`, `annulation`) VALUES
(24, '2024-05-27 20:00:00', 1, 'Papa', 'admin@allobobo.fr', '1459620557admin'),
(25, '2024-05-16 19:31:00', 3, 'Manan', 'admin@allobobo.fr', '1459620814admin'),
(26, '2024-08-13 19:45:00', 2, 'Admin', 'admin@allobobo.fr', '1459620814admin'),
(27, '2024-06-02 19:31:00', 1, 'richard', 'richard@allobobo.fr', '1459621349richard'),

(28, '2024-06-01 20:00:00', 1, 'david', 'david@allobobo.fr', '1459620557david'),
(29, '2024-08-13 19:31:00', 3, 'jean', 'jean@allobobo.fr', '1459620814jean'),
(30, '2024-08-13 19:45:00', 2, 'Admin', 'admin@allobobo.fr', '1459620814admin'),
(31, '2024-06-02 19:31:00', 1, 'richard', 'richard@allobobo.fr', '1459621349richard'),

(120, '2024-01-08 19:31:00', 1, 'Marc', 'marc@allobobo.fr', '1459621349marc'),
(121, '2024-01-08 10:30:00', 2, 'Julie', 'julie@allobobo.fr', '1459621349julie'),
(122, '2024-01-08 19:31:00', 1, 'Marie', 'marie@allobobo.fr', '1459621349marie'),
(124, '2024-01-08 19:31:00', 1, 'Aurel', 'aurel@allobobo.fr', '1459621349aurel'),
(125, '2024-06-16 19:31:00', 1, 'Manu', 'manu@allobobo.fr', '1459621349manu'),
(126, '2024-06-16 19:31:00', 1, 'Robert', 'robert@allobobo.fr', '1459621349ro'),
(127, '2024-06-17 19:31:00', 1, 'Serge', 'serge@allobobo.fr', '1459621349serge'),
(128, '2024-06-18 19:31:00', 1, 'Mouloud', 'mouloud@allobobo.fr', '1459621349Mouloud'),
(129, '2024-06-19 19:31:00', 1, 'richard', 'richard@allobobo.fr', '1459612richard'),

(130, '2024-06-20 15:30:00', 1, 'Marc', 'marc@allobobo.fr', '1459621349marc'),
(131, '2024-06-20 10:30:00', 2, 'Julie', 'julie@allobobo.fr', '1459621349julie'),
(132, '2024-06-20 19:31:00', 1, 'Marie', 'marie@allobobo.fr', '1459621349marie'),
(133, '2024-06-16 11:30:00', 2, 'Aurel', 'aurel@allobobo.fr', '1459621349aurel'),
(134, '2024-06-16 11:30:00', 1, 'Manu', 'manu@allobobo.fr', '1459621349manu'),
(135, '2024-06-16 15:30:00', 2, 'Robert', 'robert@allobobo.fr', '1459621349ro'),
(136, '2024-06-21 19:31:00', 1, 'Serge', 'serge@allobobo.fr', '1459621349serge'),
(137, '2024-06-22 19:31:00', 2, 'Mouloud', 'mouloud@allobobo.fr', '1459621349Mouloud'),
(138, '2024-06-23 19:31:00', 1, 'richard', 'richard@allobobo.fr', '1459612richard'),

(139, '2024-06-24 15:30:00', 1, 'Maman', 'admin@allobobo.fr', '1459621349maman'),
(140, '2024-06-24 10:30:00', 2, 'Papa', 'admin@allobobo.fr', '1459621349papa'),
(141, '2024-06-24 19:31:00', 1, 'Marie', 'marie@allobobo.fr', '1459621349marie'),
(142, '2024-06-24 11:30:00', 2, 'Aurel', 'aurel@allobobo.fr', '1459621349aurel'),
(146, '2024-06-25 11:30:00', 1, 'Manu', 'manu@allobobo.fr', '1459621349manu'),
(147, '2024-06-25 15:30:00', 2, 'Robert', 'robert@allobobo.fr', '1459621349ro'),
(148, '2024-06-25 19:31:00', 1, 'Serge', 'serge@allobobo.fr', '1459621349serge'),
(149, '2024-06-26 19:31:00', 2, 'Mouloud', 'mouloud@allobobo.fr', '1459621349Mouloud'),
(150, '2024-06-26 19:31:00', 1, 'richard', 'richard@allobobo.fr', '1459612richard'),

(151, '2024-06-27 10:30:00', 1, 'Maman', 'admin@allobobo.fr', '14594621349maman'),
(152, '2024-06-27 10:30:00', 2, 'Papa', 'admin@allobobo.fr', '14591221349papa'),
(154, '2024-06-27 10:30:00', 3, 'Marie', 'marie@allobobo.fr', '1459621349marie'),
(155, '2024-06-28 11:30:00', 2, 'Aurel', 'aurel@allobobo.fr', '1459621349aurel'),
(156, '2024-06-28 11:30:00', 1, 'Manu', 'manu@allobobo.fr', '1459621349manu'),
(157, '2024-06-28 15:30:00', 2, 'Robert', 'robert@allobobo.fr', '1459621349ro'),
(158, '2024-06-28 16:30:00', 1, 'Serge', 'serge@allobobo.fr', '1459621349serge'),
(159, '2024-06-28 16:30:00', 2, 'Mouloud', 'mouloud@allobobo.fr', '1459621349Mouloud'),
(160, '2024-06-28 19:30:00', 1, 'richard', 'richard@allobobo.fr', '1459612richard')

;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `code` int NOT NULL AUTO_INCREMENT,
  `nom_user` varchar(100) NOT NULL,
  `email_user` varchar(100) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `type_compte` varchar(5) DEFAULT NULL,
  `id_rdv` int DEFAULT NULL,
  PRIMARY KEY (`code`)
);

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`code`, `nom_user`, `email_user`,`type_compte`, `mdp`, `id_rdv`) VALUES

(1, 'Dr Queen', 'queen@allobobo.fr','MDC', 'ab4f63f9ac65152575886860dde480a1', null),
(2, 'Dr Who', 'who@allobobo.fr','MDC', 'ab4f63f9ac65152575886860dde480a1', null),
(3, 'Dr House', 'franck@allobobo.fr','MDC', 'ab4f63f9ac65152575886860dde480a1', null),

(4, 'david', 'david@allobobo.fr','PAT', 'ab4f63f9ac65152575886860dde480a1', null),
(5, 'admin', 'admin@allobobo.fr','ADM', '21232f297a57a5a743894a0e4a801fc3', null),
(6, 'Richard', 'richard@allobobo.fr','PAT', 'ab4f63f9ac65152575886860dde480a1', null),
(7, 'Marc', 'marc@allobobo.fr','PAT', 'ab4f63f9ac65152575886860dde480a1', null),
(8, 'Julie', 'julie@allobobo.fr','PAT', 'ab4f63f9ac65152575886860dde480a1', null),
(9, 'Marie', 'marie@allobobo.fr','PAT', 'ab4f63f9ac65152575886860dde480a1', null),
(10, 'Aurélie', 'aurel@allobobo.fr','PAT', 'ab4f63f9ac65152575886860dde480a1', null),
(11, 'Manu', 'manu@allobobo.fr','PAT', 'ab4f63f9ac65152575886860dde480a1', null),
(12, 'Robert', 'robert@allobobo.fr','PAT', 'ab4f63f9ac65152575886860dde480a1', null),
(13, 'Serge', 'Sjean@allobobo.fr','PAT', 'ab4f63f9ac65152575886860dde480a1', null),
(14, 'Mouloud', 'Mouloud@allobobo.fr','PAT', 'ab4f63f9ac65152575886860dde480a1', null);



--
-- Structure de la table `medecin`
--

CREATE TABLE IF NOT EXISTS `medecin` (
  `id_medecin` int NOT NULL AUTO_INCREMENT,
  `nom_medecin` varchar(100) NOT NULL,
  `email_medecin` varchar(100) NOT NULL,
  `disponibilite` varchar(100) NOT NULL,
  `specialite` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `code_user` int NOT NULL,

  PRIMARY KEY (`id_medecin`)
);

--
-- Contenu de la table `medecin`
--

INSERT INTO `medecin` (`id_medecin`, `nom_medecin`, `email_medecin`, `disponibilite`,`specialite`,`image`, `code_user`) VALUES
(1, 'Dr Queen', 'queen@allobobo.fr', '1','Médecin généraliste','images/m1.png','1'),
(2, 'Dr Who', 'who@allobobo.fr', '1','Cardiologue','images/m2.png','2'),
(3, 'Dr House', 'franck@allobobo.fr', '1','Anesthésiste','images/m3.png','3');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
