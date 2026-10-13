-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 13 oct. 2026 à 13:12
-- Version du serveur : 5.7.24
-- Version de PHP : 8.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ski700`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id_art` int(11) NOT NULL,
  `nom` varchar(40) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `prix` float DEFAULT NULL,
  `url_photo` varchar(300) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_art`, `nom`, `quantite`, `prix`, `url_photo`, `description`) VALUES
(1, 'Volkl Revolt 121 skis 2020', 10, 800, 'images/ski1.jpg', 'Le Revolt 121 est l\'apogée d\'une fantastique coopération entre l\'équipe de freeski et le département Recherche et Développement Völkl Programme : Powder Freestyle, Freestyle Backcountry'),
(2, 'Ski Alpin Volkl Revolt 90', 21, 709, 'images/ski2.webp', 'Le Revolt 90 de Volkl est un ski alpin conçu pour exceller en freestyle. Avec un patin de 90 mm, ce ski versatile convient aux skieurs de niveau intermédiaire à confirmé à la recherche d\'un ski maniable et adaptable à diverses pratiques de ski, que ce soit en snowpark ou sur les pistes.'),
(3, 'Ski Salomon S/Lab Qst Blank - 178', 4, 849.9, 'images/ski3.webp', 'Le S/Lab QST Blank est le plus large de la gamme freeride de chez Salomon. Avec ses 112 mm au patin, il est conçu pour les grosses conditions de neige et offre une excellente flottaison dans la peuf.'),
(4, 'Ski Alpin Qst 106 Black Pink', 7, 719.9, 'images/ski4.webp', 'Le ski Qst 106 Black Pink est développé par Salomon pour maintenir de la vitesse et du contrôle dans les pentes engagées. Il bénéficie d\'une structure capable d’encaisser les variations de neige sans sourciller.'),
(5, 'Ski Alpin Prodigy 2', 3, 639.9, 'images/ski5.webp', 'Le ski Faction Prodigy 2 doit sa réputation à son ADN park, logé dans un twin directionnel freestyle polyvalent. Il sort les gros tricks dès que l\'occasion se présente, sur un kicker naturel au-delà des balises comme sur la moindre aspérité en bordure de piste.'),
(6, 'Ski Alpin Prodigy 1 ', 1, 594.9, 'images/ski6.webp', 'Le ski Faction Prodigy 1 Capsule décline toute la technique du Prodigy 1 sous un design artistique signé Elsa Grace. Ce freestyle all-mountain bispatulé ne cède rien sur le terrain.'),
(7, 'Sea 108 White/Yellow 2027', 13, 749.9, 'images/ski7.avif', 'Le Sea 108 White/Yellow 2027 est un ski freeride de la marque Scott. Les skis Sea font partie d\'une toute nouvelle gamme freeride qui vient compléter l\'offre déjà existante, en apportant cette touche de fun que bon nombre de riders recherchent.'),
(8, 'Atris 2026', 25, 539.9, 'images/ski8.avif', 'L\'Atris 2026 est un ski big mountain pour homme de la marque Blackcrows. Ce modèle large est le ski phare de la gamme big mountain chez Blackcrows. Il se skie avec aisance sur toutes les neiges pour vous ouvrir les portes du gros ski !'),
(9, 'Enforcer 104 2026', 11, 559.9, 'images/ski9.avif', 'L\'Enforcer 104 2026 est un ski freeride pour homme de la marque Nordica. La collection Enforcer n\'a plus rien à prouver. Parfait pour les skieurs de niveau confirmé à expert qui souhaitent avant tout un ski à tout faire, typé freeski, qui en ait sous le patin ! Avec son nouveau shape, son rocker est affiné et augmenté pour encore plus de contrôle sur tous les terrains et surtout à n\'importe quelle vitesse.'),
(10, 'Bent Chetler 120 2026', 4, 499.9, 'images/ski10.avif', 'Le Bent Chetler 120 2026 est un ski freeride de la marque Atomic. Conçu en collaboration avec le skieur Chris Benchetler, ce ski au design unique et recherché est parfait pour skier dans la neige fraîche et sur de vastes étendues immaculées.');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(25) DEFAULT NULL,
  `prenom` varchar(25) DEFAULT NULL,
  `adresse` text,
  `numero` int(11) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `mdp` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id_client`, `nom`, `prenom`, `adresse`, `numero`, `mail`, `mdp`) VALUES
(4, 'Destrade', 'Charles', '45 test', 768686868, 'test@free.fr', '$2y$10$HmS3RBwwZYO7MELXVc9qBeKCrYD/G0e/HLte7KEIS8.yeD7CvTUui'),
(5, 'Miaouu', 'Miaou', '666 rue miaou', 5555555, 'miaou@gmail.com', '$2y$10$0zhCOsj43IKSub5C.oOUXuXI5s1hO/olpctrZZq4TJVaFK5PWyJi.'),
(6, 'zgzegz', 'gzgzgzg', 'zgzgzgzg', 768160162, 'zgzgzgzgz@egege', '$2y$10$m4eEAhuBMgDwSgCvlBT7q.F3FW/3CGTjiHEg8Y7quqtn7589TEXX.');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id_commande` int(11) NOT NULL,
  `id_art` int(11) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `envoi` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id_commande`, `id_art`, `id_client`, `quantite`, `envoi`) VALUES
(1, 6, 4, 1, 0),
(2, 3, 4, 1, 0),
(3, 8, 4, 2, 0),
(4, 8, 4, 1, 0),
(5, 7, 4, 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id_client` int(11) NOT NULL,
  `id_art` int(11) NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  `expiration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id_client`, `id_art`, `quantite`, `expiration`) VALUES
(4, 7, 1, '2026-10-12 08:29:48');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_art`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_art` (`id_art`),
  ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_client`,`id_art`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`id_art`) REFERENCES `article` (`id_art`),
  ADD CONSTRAINT `commandes_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
