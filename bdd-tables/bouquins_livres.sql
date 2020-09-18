-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 sep. 2020 à 16:01
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
-- Structure de la table `livre`
--

CREATE TABLE `livre` (
  `id_livre` int(11) UNSIGNED NOT NULL,
  `date_ajout` timestamp NOT NULL DEFAULT current_timestamp(),
  `description_livre` varchar(2000) NOT NULL,
  `est_emprunte_livre` tinyint(1) NOT NULL DEFAULT 0,
  `titre_livre` varchar(300) NOT NULL,
  `url_couverture_livre` varchar(2000) NOT NULL,
  `id_utilisateur_livre` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`id_livre`, `date_ajout`, `description_livre`, `est_emprunte_livre`, `titre_livre`, `url_couverture_livre`, `id_utilisateur_livre`) VALUES
(1, '2020-09-04 08:14:12', 'Le Seigneur des anneaux (The Lord of the Rings) est un roman en trois volumes de J. R. R. Tolkien paru en 1954 et 1955. Prenant place dans le monde de fiction de la Terre du Milieu, il suit la quête du hobbit Frodon Sacquet, qui doit détruire l’ Anneau unique afin que celui-ci ne tombe pas entre les mains de Sauron, le Seigneur des ténèbres.', 0, 'Le Seigneur des anneaux', 'leSeigneurDesAnneaux.jpg', 21),
(2, '2020-09-04 08:14:13', 'Hypérion raconte le cheminement géographique et intérieur des sept pèlerins choisis par l’Hégémonie pour rencontrer le Gritche. Pendant cette traversée de l’espace et des étendues hostiles de la planète Hypérion, chaque pèlerin raconte son histoire à ses compagnons.', 0, 'Hyperion 1', 'hyperion1.jpg', 21),
(3, '2020-09-04 08:14:13', 'Hypérion raconte le cheminement géographique et intérieur des sept pèlerins choisis par l’Hégémonie pour rencontrer le Gritche. Pendant cette traversée de l’espace et des étendues hostiles de la planète Hypérion, chaque pèlerin raconte son histoire à ses compagnons.', 0, 'Hyperion 2', 'hyperion1.jpg', 21),
(4, '2020-09-04 08:14:13', 'La Roue du temps (titre original : The Wheel of Time) est une série de romans de fantasy écrits par l’écrivain américain Robert Jordan. Le premier volume est paru en 1990 chez l’éditeur Tor Books. L’auteur est décédé en 2007 sans avoir achevé la série, mais il a laissé assez de notes pour qu’un autre écrivain puisse terminer son œuvre.', 0, 'La Roue du Temps - L’Œil du monde', 'larouedutemps1.jpg', 21),
(5, '2020-09-04 08:14:13', 'La Roue du temps (titre original : The Wheel of Time) est une série de romans de fantasy écrits par l’écrivain américain Robert Jordan. Le premier volume est paru en 1990 chez l’éditeur Tor Books. L’auteur est décédé en 2007 sans avoir achevé la série, mais il a laissé assez de notes pour qu’un autre écrivain puisse terminer son œuvre.', 0, 'La Roue du Temps - La Grande Quête', 'larouedutemps2.jpg', 21),
(6, '2020-09-04 08:14:13', 'La Roue du temps (titre original : The Wheel of Time) est une série de romans de fantasy écrits par l’écrivain américain Robert Jordan. Le premier volume est paru en 1990 chez l’éditeur Tor Books. L’auteur est décédé en 2007 sans avoir achevé la série, mais il a laissé assez de notes pour qu’un autre écrivain puisse terminer son œuvre.', 0, 'La Roue du Temps - Le Dragon réincarné', 'larouedutemps3.jpg', 21),
(7, '2020-09-04 08:14:13', 'La Roue du temps (titre original : The Wheel of Time) est une série de romans de fantasy écrits par l’écrivain américain Robert Jordan. Le premier volume est paru en 1990 chez l’éditeur Tor Books. L’auteur est décédé en 2007 sans avoir achevé la série, mais il a laissé assez de notes pour qu’un autre écrivain puisse terminer son œuvre.', 0, 'La Roue du Temps - Un lever de ténèbres', 'larouedutemps4.jpg', 21),
(8, '2020-09-04 08:14:13', 'Les Chroniques de Krondor (titre original : The Riftwar Cycle) est une saga de fantasy de l’écrivain Raymond E. Feist, dont la parution a commencé en 1982. Elle est composée de nombreux cycles, tournant autour de l’univers de Midkemia et de guerres dimensionnelles liées à des portails nommés les failles.', 0, 'Les Chroniques de Krondor - Pug l’apprenti', 'krondormagicien1.jpg', 21),
(9, '2020-09-04 08:14:13', 'Les Chroniques de Krondor (titre original : The Riftwar Cycle) est une saga de fantasy de l’écrivain Raymond E. Feist, dont la parution a commencé en 1982. Elle est composée de nombreux cycles, tournant autour de l’univers de Midkemia et de guerres dimensionnelles liées à des portails nommés les failles.', 0, 'Les Chroniques de Krondor - Milamber le mage', 'krondormagicien2.jpg', 21),
(10, '2020-09-04 08:14:13', 'Les Chroniques de Krondor (titre original : The Riftwar Cycle) est une saga de fantasy de l’écrivain Raymond E. Feist, dont la parution a commencé en 1982. Elle est composée de nombreux cycles, tournant autour de l’univers de Midkemia et de guerres dimensionnelles liées à des portails nommés les failles.', 0, 'Les Chroniques de Krondor - Silverthorn', 'krondormagicien3.jpg', 21),
(11, '2020-09-04 08:14:13', 'Les Chroniques de Krondor (titre original : The Riftwar Cycle) est une saga de fantasy de l’écrivain Raymond E. Feist, dont la parution a commencé en 1982. Elle est composée de nombreux cycles, tournant autour de l’univers de Midkemia et de guerres dimensionnelles liées à des portails nommés les failles.', 0, 'Les Chroniques de Krondor - Ténèbres sur Sethanon', 'krondormagicien4.jpg', 21),
(12, '2020-09-04 08:14:13', 'Né du rêve d’un conquérant, le Vieux Royaume n’est plus que le souvenir de sa grandeur passée. Une poussière de fiefs, de bourgs et de cités a fleuri parmi ses ruines, une société féodale et chamarrée où des héros nobles ou humbles, brutaux ou érudits, se dressent contre leur destin.', 0, 'Janua Vera', 'januavera.jpg', 21),
(13, '2020-09-04 08:14:13', 'Ce livre se déroule dans le Vieux Royaume, un univers de fantasy où la magie est présente et puissante, et qui puise largement son inspiration dans le roman de cape et d’épée et le roman historique (Renaissance italienne). On y retrouve le personnage de Benvenuto Gesufal, déjà présent dans le recueil de nouvelles Janua Vera', 0, 'Gagner la guerre', 'gagnerlaguerre.jpg', 21),
(14, '2020-09-04 08:14:14', 'Je m’appelle Bellovèse, fils de Sacrovèse, fils de Belinos. Pendant la Guerre des Sangliers, mon oncle Ambigat a tué mon père. Entre beaux-frères, ce sont des choses qui arrivent. Surtout quand il s’agit de rois de tribus rivales… Ma mère, mon frère et moi, nous avons été exilés au fond du royaume biturige. Parce que nous étions de son sang, parce qu’il n’est guère glorieux de tuer des enfants, Ambigat nous a épargnés.', 0, 'Même pas mort', 'memepasmort.jpg', 21),
(15, '2020-09-04 08:14:14', 'ans la Celtique ravagée par la guerre, le mystère plane sur le sort du haut roi. Ambigat est-il mort ? Est-il encore en vie ? L’incertitude excite les convoitises et ajoute au désordre. Par loyauté et par ambition, Bellovèse se lance à la recherche du roi caché. À travers les contrées écumées par des bandes féroces, mais aussi à travers la géographie des rêves et des oracles, il remonte la piste du souverain.', 0, 'Chasse royale', 'chasseroyale.jpg', 21);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`id_livre`),
  ADD KEY `proprietaire` (`id_utilisateur_livre`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `livre`
--
ALTER TABLE `livre`
  MODIFY `id_livre` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `livre_ibfk_1` FOREIGN KEY (`id_utilisateur_livre`) REFERENCES `utilisateur` (`id_utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
