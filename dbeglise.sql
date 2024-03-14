-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 14 mars 2024 à 15:36
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dbeglise`
--

-- --------------------------------------------------------

--
-- Structure de la table `eglise`
--

CREATE TABLE `eglise` (
  `ideglise` int(10) NOT NULL,
  `designeglise` varchar(50) NOT NULL,
  `soldeeglise` int(50) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `eglise`
--

INSERT INTO `eglise` (`ideglise`, `designeglise`, `soldeeglise`) VALUES
(43, 'Episcopal Church of Madagascar', 20420),
(44, 'FLM CATHEDRAL', 102480),
(45, 'Fiangonana Pentekotista Mitambatra ', 5000),
(60, 'EKAR Toliara', 9600),
(62, 'Eglise 2', 87000),
(63, 'Eglise 3', 0),
(64, 'Eglise 4', 100000),
(67, 'Eglise 8', 24944),
(68, 'Eglise 9', 39651),
(70, 'Eglise 11', 127101),
(74, 'église 12', 94762),
(75, 'église 14', 247774),
(76, 'église 1', 12055);

-- --------------------------------------------------------

--
-- Structure de la table `entre`
--

CREATE TABLE `entre` (
  `identre` int(10) NOT NULL,
  `motifentre` varchar(50) NOT NULL,
  `montantentre` int(50) NOT NULL,
  `ideglise` int(10) NOT NULL,
  `dateentre` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `entre`
--

INSERT INTO `entre` (`identre`, `motifentre`, `montantentre`, `ideglise`, `dateentre`) VALUES
(62, 'dons aux orphelins', 50000, 43, '2024-02-25'),
(63, 'dons aux sans-abris', 60000, 44, '2024-02-25'),
(71, 'opérations pizza', 80000, 44, '2024-02-25'),
(73, 'rakitra', 12000, 60, '2024-02-26'),
(75, 'rakitra noely', 658000, 62, '2024-02-26'),
(78, 'dons', 10000, 68, '2024-02-26'),
(79, 'rakitra', 2500, 70, '2024-02-26'),
(81, 'rakitra', 250001, 70, '2024-02-29'),
(82, 'rakitra', 25000, 67, '2024-02-29'),
(83, 'récolte de fonds', 120000, 64, '2024-02-29'),
(84, 'recette du bal de charité', 2540032, 68, '2024-02-29'),
(86, 'rakitra', 2547880, 44, '2024-03-03'),
(88, 'rakitra', 100254, 74, '2024-03-07');

-- --------------------------------------------------------

--
-- Structure de la table `sortie`
--

CREATE TABLE `sortie` (
  `idsortie` int(10) NOT NULL,
  `motifsortie` varchar(50) NOT NULL,
  `montantsortie` int(50) NOT NULL,
  `ideglise` int(10) NOT NULL,
  `datesortie` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sortie`
--

INSERT INTO `sortie` (`idsortie`, `motifsortie`, `montantsortie`, `ideglise`, `datesortie`) VALUES
(1, 'décorations', 1200, 43, '2024-02-25'),
(2, 'dons', 35000, 44, '2024-02-25'),
(5, 'dons aux pauvres', 25400, 44, '2024-02-25'),
(16, 'rénovations', 2400, 60, '2024-02-26'),
(24, 'nettoyage', 71000, 62, '2024-02-26'),
(25, 'plomberie', 20000, 44, '2024-02-27'),
(26, 'rénovation', 2540000, 44, '2024-03-03'),
(27, 'nettoyage', 2500356, 68, '2024-03-03'),
(28, 'dons', 254, 70, '2024-03-03'),
(30, 'dons', 125400, 70, '2024-03-06'),
(37, 'test', 2874, 75, '2024-03-14'),
(38, 'test', 24, 75, '2024-03-14');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `eglise`
--
ALTER TABLE `eglise`
  ADD PRIMARY KEY (`ideglise`);

--
-- Index pour la table `entre`
--
ALTER TABLE `entre`
  ADD PRIMARY KEY (`identre`),
  ADD KEY `ideglise` (`ideglise`);

--
-- Index pour la table `sortie`
--
ALTER TABLE `sortie`
  ADD PRIMARY KEY (`idsortie`),
  ADD KEY `ideglise2` (`ideglise`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `eglise`
--
ALTER TABLE `eglise`
  MODIFY `ideglise` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT pour la table `entre`
--
ALTER TABLE `entre`
  MODIFY `identre` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT pour la table `sortie`
--
ALTER TABLE `sortie`
  MODIFY `idsortie` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `entre`
--
ALTER TABLE `entre`
  ADD CONSTRAINT `ideglise` FOREIGN KEY (`ideglise`) REFERENCES `eglise` (`ideglise`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sortie`
--
ALTER TABLE `sortie`
  ADD CONSTRAINT `ideglise2` FOREIGN KEY (`ideglise`) REFERENCES `eglise` (`ideglise`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
