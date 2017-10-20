-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 20 oct. 2017 à 10:13
-- Version du serveur :  10.1.22-MariaDB
-- Version de PHP :  7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `annonceo`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `id_annonce` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description_courte` varchar(255) NOT NULL,
  `description_longue` text NOT NULL,
  `prix` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `pays` varchar(50) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `membre_id` int(3) NOT NULL,
  `photo_id` int(3) NOT NULL,
  `categorie_id` int(3) NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `titre`, `description_courte`, `description_longue`, `prix`, `photo`, `pays`, `ville`, `adresse`, `cp`, `membre_id`, `photo_id`, `categorie_id`, `date_enregistrement`) VALUES
(18, 'Peinture', 'Description courte', 'Description Longue', 23, 'http://localhost/annonceo/photo/1508397956_1508251729_ile_du_pacifique-37109.jpg', 'france', 'paris', 'Cherche pas !', 92230, 0, 0, 2, '2017-10-19 09:25:56'),
(19, 'dfghyjukiolm', 'defrtghyujlomp', 'sdfgthjyum', 458, 'http://localhost/annonceo/photo/1508398038_1508323375_Vente-chaude-font-b-Halloween-b-font-Party-Cosplay-Hip-Hop-Masque-De-Danse-font-b.jpg', 'france', 'paris', 'ertyuiop', 12345, 0, 0, 3, '2017-10-19 09:27:18'),
(20, 'Frappe', 'Du shit', 'Du shit je t\'ai dis !', 100, 'http://localhost/annonceo/photo/1508398105_1508250688_vegetaV2.jpg', 'france', 'paris', 'j\'suis pas une balance !', 75000, 0, 0, 10, '2017-10-19 09:28:25'),
(21, 'Frappe', 'fghjkl', 'rtyhujik', 23, 'http://localhost/annonceo/photo/1508400732_logo_v2.png', 'france', 'paris', 'rtyuiop', 12344, 0, 0, 11, '2017-10-19 10:12:12'),
(22, 'qfnjsdnjsdsq', 'dsnfjdnfndj', 'dsjbfjdfjksd', 56, 'http://localhost/annonceo/photo/1508403125_logo_head.png', 'france', 'paris', 'HSDQKLFHJSDHFHSDJK', 16237, 0, 0, 0, '2017-10-19 10:52:05'),
(23, 'voiture', 'belle', 'rouge', 2500, 'http://localhost/annonceo/photo/1508406763_logo_head.png', 'france', 'paris', '11 allée st exupery', 92390, 0, 0, 2, '2017-10-19 11:52:43'),
(24, 'dfghjklmù', 'zertyuiopfghj', 'dfrtgyhjukilopm', 254, 'http://localhost/annonceo/photo/1508409302_soucoupe01.png', 'france', 'paris', 'edfrghjklghjklfgh', 1234, 0, 0, 2, '2017-10-19 12:35:02'),
(25, 'asasaasa', 'lrpglhlepgmp', 'glog;keokgh,erog', 89, 'http://localhost/annonceo/photo/1508409330_pat01.png', 'france', 'paris', 'ertyujkiolpm', 1234, 0, 0, 11, '2017-10-19 12:35:30'),
(26, 'Robot de cuisine', 'petit robot ', 'petit robot de cuisine argenté en très bonne état', 50, 'http://localhost/annonceo/photo/1508411520_darty_univers_petite_cusine_03.jpg', 'france', 'paris', '11 allée st exupery', 92390, 0, 0, 11, '2017-10-19 13:12:00'),
(27, '^dfbqeherherger', 'grgrgrzgzgrergrgr', 'rgrgrgrgrgrgrgrg', 23, 'http://localhost/annonceo/photo/1508487152_1508251729_ile_du_pacifique-37109.jpg', 'france', 'paris', 'dzdzzdzdzdzdzdz', 1234, 0, 0, 0, '2017-10-20 10:12:32');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(3) NOT NULL,
  `titre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `titre`) VALUES
(2, 'Auto-Moto'),
(3, 'Immobilier'),
(10, 'Multimedia'),
(11, 'Collection'),
(12, 'Vetement');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int(3) NOT NULL,
  `membre_id` int(3) NOT NULL,
  `annonce_id` int(3) NOT NULL,
  `commentaire` text NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `membre_id`, `annonce_id`, `commentaire`, `date_enregistrement`) VALUES
(2, 2, 2, ' Je me suis fait arnaquer', '2017-10-19 14:00:42'),
(3, 4, 4, 'C\'est de la merde', '2017-10-19 13:00:00'),
(4, 4, 4, 'C\'est cool', '2017-10-19 13:26:14');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(3) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `statut` int(1) NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `telephone`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(2, 'popu92', '', '  trieod', '  fozofozop', '0123456789', '  foeofroeo@ifkieio.fr', 'm', 0, '0000-00-00 00:00:00'),
(4, 'membre92', '1be0dc66e727b4812a18bfd097c5e82a', 'trieod', 'fozofozop', '0123456789', 'foeofroeo@ifkieio.fr', 'f', 1, '0000-00-00 00:00:00'),
(5, 'yukulele', 'ef60098cf5ef5bf6074bb4b40386fda4', 'tytus', 'tytus', '0123456789', 'tytus@tytus.com', 'm', 1, '0000-00-00 00:00:00'),
(6, 'yoko92', 'a411a4b883bfa799973e29c058541774', 'fefefef', 'fefzefe', '0123456789', 'fefeqfefe@fefefe.com', 'f', 1, '0000-00-00 00:00:00'),
(7, 'chocolat', 'b3853a40dffb80f5479b2908a4cd5fb1', 'azdgeg', 'fegergmv', '0123456789', 'gvblelpghm@foeogffl.fr', 'm', 0, '0000-00-00 00:00:00'),
(8, 'babar', 'dccc2ff2dc93484b76bffbceedb4dc9d', 'jfjfjfj', 'jfjdfjfj', '0123456789', 'dfjfjfj@hkhkhkh.fr', '', 0, '2017-10-18 16:18:02'),
(9, 'riri92i', '893071e0338d5568b2a4e83c3f5fddc7', 'sdfg', 'qsdfgh', '0123456789', 'sdfgbhn@zsedrfgthjkfe.com', '', 0, '2017-10-19 09:37:35'),
(10, 'sara92', 'a6068006f41b662802738c711bc7208a', 'sara', 'fkaier', '0667770157', 'sara.fkaier@hotmail.fr', 'f', 0, '2017-10-19 13:27:29'),
(11, 'Julien24', 'b06cc82a244e37785ac5d5078bd6e2f9', 'mlkjjuy', 'Julien', '0668795141', 'sebastien.miatti@outlook.fr', '', 0, '2017-10-19 13:32:19'),
(12, 'VDKLMJHJKLHBU', '7d0689d8fb527e4100a629ccf5dde506', 'qssfbnn', 'dn', '0123456789', 'dzdzd@zdzdz.fr', '', 0, '2017-10-19 13:32:57'),
(13, 'colosse23', '365fb223bef778e4802d31af15b1dd01', 'Julien', 'Hummm', '0123456789', 'yayayayayay@yuouk.fr', '', 0, '2017-10-19 13:42:51');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id_note` int(3) NOT NULL,
  `membre_id1` int(3) NOT NULL,
  `membre_id2` int(3) NOT NULL,
  `note` int(3) NOT NULL,
  `avis` varchar(255) NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `note`
--

INSERT INTO `note` (`id_note`, `membre_id1`, `membre_id2`, `note`, `avis`, `date_enregistrement`) VALUES
(2, 1, 2, 10, 'Très beau', '2017-10-19 06:00:00'),
(3, 2, 2, 4, ' yeah', '2017-10-19 13:18:58'),
(4, 2, 2, 4, 'cool', '2017-10-19 06:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id_photo` int(3) NOT NULL,
  `photo1` varchar(255) NOT NULL,
  `photo2` varchar(255) NOT NULL,
  `photo3` varchar(255) NOT NULL,
  `photo4` varchar(255) NOT NULL,
  `photo5` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id_annonce`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_note`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id_photo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id_annonce` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id_note` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id_photo` int(3) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
