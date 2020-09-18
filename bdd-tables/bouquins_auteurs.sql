-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 sep. 2020 à 16:00
-- Version du serveur :  10.4.13-MariaDB
-- Version de PHP : 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bouquins`
--

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

CREATE TABLE `auteur` (
  `id_auteur` int(11) UNSIGNED NOT NULL,
  `description_auteur` text NOT NULL,
  `nom_auteur` varchar(300) NOT NULL,
  `url_photo_auteur` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `auteur`
--

INSERT INTO `auteur` (`id_auteur`, `description_auteur`, `nom_auteur`, `url_photo_auteur`) VALUES
(1, 'John Ronald Reuel Tolkien, plus connu sous la forme J. R. R. Tolkien, est un écrivain, poète, philologue, essayiste et professeur d’université britannique, né le 3 janvier 1892 à Bloemfontein (État libre d’Orange) et mort le 2 septembre 1973 à Bournemouth (Royaume-Uni). Il est principalement connu pour ses romans Le Hobbit et Le Seigneur des anneaux.', 'J. R. R. Tolkien', 'jrrtolkien.jpg'),
(2, 'Dan Simmons, né le 4 avril 1948 à Peoria (Illinois), est un écrivain américain connu principalement pour ses romans de science-fiction, d’horreur et policiers. Ses livres sont publiés dans 27 pays.', 'Dan Simmons', 'dansimmons.jpg'),
(3, 'Robert Jordan est le nom de plume d’un auteur américain de fantasy. De son vrai nom James Oliver Rigney, Jr., il est né le 17 octobre 1948 à Charleston (Caroline du Sud) et mort le 16 septembre 2007.', 'Robert Jordan', 'robertjordan.jpg'),
(4, 'Raymond Elias Feist, né en 23 décembre 19451 à Los Angeles en Californie, est un écrivain américain de fantasy.', 'Raymond Elias Feist', 'raymondeliasfeist.jpg'),
(5, 'Jean-Philippe Jaworski, né en 1969, est un écrivain français de fantasy. Il est également l’auteur de plusieurs jeux de rôles.', 'Jean-Philippe Jaworski', 'jeanphilippejaworski.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`id_auteur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `auteur`
--
ALTER TABLE `auteur`
  MODIFY `id_auteur` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
