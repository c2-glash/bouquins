-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 sep. 2020 à 18:54
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
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_photo` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `auteur`
--

INSERT INTO `auteur` (`id`, `nom`, `prenom`, `description`, `url_photo`) VALUES
(1, 'Tolkien', 'J. R. R.', 'John Ronald Reuel Tolkien, plus connu sous la forme J. R. R. Tolkien, est un écrivain, poète, philologue, essayiste et professeur d’université britannique, né le 3 janvier 1892 à Bloemfontein (État libre d’Orange) et mort le 2 septembre 1973 à Bournemouth (Royaume-Uni). Il est principalement connu pour ses romans Le Hobbit et Le Seigneur des anneaux.', 'jrrtolkien.jpg'),
(2, 'Simmons', 'Dan', 'Dan Simmons, né le 4 avril 1948 à Peoria (Illinois), est un écrivain américain connu principalement pour ses romans de science-fiction, d’horreur et policiers. Ses livres sont publiés dans 27 pays.', 'dansimmons.jpg'),
(3, 'Jordan', 'Robert', 'Robert Jordan est le nom de plume d’un auteur américain de fantasy. De son vrai nom James Oliver Rigney, Jr., il est né le 17 octobre 1948 à Charleston (Caroline du Sud) et mort le 16 septembre 2007.', 'robertjordan.jpg'),
(4, 'Feist', 'Raymond Elias', 'Raymond Elias Feist, né en 23 décembre 19451 à Los Angeles en Californie, est un écrivain américain de fantasy.', 'raymondeliasfeist.jpg'),
(5, 'Jaworski', 'Jean-Philippe', 'Jean-Philippe Jaworski, né en 1969, est un écrivain français de fantasy. Il est également l’auteur de plusieurs jeux de rôles.', 'jeanphilippejaworski.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `auteur_livre`
--

CREATE TABLE `auteur_livre` (
  `auteur_id` int(11) NOT NULL,
  `livre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `auteur_livre`
--

INSERT INTO `auteur_livre` (`auteur_id`, `livre_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`, `description`) VALUES
(1, 'Fantasy', 'La fantasy est un genre littéraire présentant un ou plusieurs éléments surnaturels qui relèvent souvent du mythe et qui sont souvent incarnés par l’irruption ou l’utilisation de la magie.'),
(2, 'Science-fiction', 'La science-fiction est un genre narratif, principalement littéraire (littérature et bande dessinée), cinématographique et vidéo-ludique. Comme son nom l’indique, elle consiste à raconter des fictions reposant sur des progrès scientifiques et techniques obtenus dans un futur plus ou moins lointain.');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_livre`
--

CREATE TABLE `categorie_livre` (
  `categorie_id` int(11) NOT NULL,
  `livre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20200918151048', '2020-09-18 17:15:57', 9462);

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

CREATE TABLE `livre` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_couverture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL,
  `est_emprunte` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`id`, `titre`, `description`, `url_couverture`, `date_ajout`, `est_emprunte`) VALUES
(1, 'Le Seigneur des anneaux', 'Le Seigneur des anneaux (The Lord of the Rings) est un roman en trois volumes de J. R. R. Tolkien paru en 1954 et 1955. Prenant place dans le monde de fiction de la Terre du Milieu, il suit la quête du hobbit Frodon Sacquet, qui doit détruire l’ Anneau unique afin que celui-ci ne tombe pas entre les mains de Sauron, le Seigneur des ténèbres.', 'leSeigneurDesAnneaux.jpg', '2020-09-04 08:14:12', 0),
(2, 'Hyperion 1', 'Hypérion raconte le cheminement géographique et intérieur des sept pèlerins choisis par l’Hégémonie pour rencontrer le Gritche. Pendant cette traversée de l’espace et des étendues hostiles de la planète Hypérion, chaque pèlerin raconte son histoire à ses compagnons.', 'hyperion1.jpg', '2020-09-04 08:14:13', 0),
(3, 'Hyperion 2', 'Hypérion raconte le cheminement géographique et intérieur des sept pèlerins choisis par l’Hégémonie pour rencontrer le Gritche. Pendant cette traversée de l’espace et des étendues hostiles de la planète Hypérion, chaque pèlerin raconte son histoire à ses compagnons.', 'hyperion1.jpg', '2020-09-04 08:14:13', 0),
(4, 'La Roue du Temps - L’Œil du monde', 'La Roue du temps (titre original : The Wheel of Time) est une série de romans de fantasy écrits par l’écrivain américain Robert Jordan. Le premier volume est paru en 1990 chez l’éditeur Tor Books. L’auteur est décédé en 2007 sans avoir achevé la série, mais il a laissé assez de notes pour qu’un autre écrivain puisse terminer son œuvre.', 'larouedutemps1.jpg', '2020-09-04 08:14:13', 0),
(5, 'La Roue du Temps - La Grande Quête', 'La Roue du temps (titre original : The Wheel of Time) est une série de romans de fantasy écrits par l’écrivain américain Robert Jordan. Le premier volume est paru en 1990 chez l’éditeur Tor Books. L’auteur est décédé en 2007 sans avoir achevé la série, mais il a laissé assez de notes pour qu’un autre écrivain puisse terminer son œuvre.', 'larouedutemps2.jpg', '2020-09-04 08:14:13', 0),
(6, 'La Roue du Temps - Le Dragon réincarné', 'La Roue du temps (titre original : The Wheel of Time) est une série de romans de fantasy écrits par l’écrivain américain Robert Jordan. Le premier volume est paru en 1990 chez l’éditeur Tor Books. L’auteur est décédé en 2007 sans avoir achevé la série, mais il a laissé assez de notes pour qu’un autre écrivain puisse terminer son œuvre.', 'larouedutemps3.jpg', '2020-09-04 08:14:13', 0),
(7, 'La Roue du Temps - Un lever de ténèbres', 'La Roue du temps (titre original : The Wheel of Time) est une série de romans de fantasy écrits par l’écrivain américain Robert Jordan. Le premier volume est paru en 1990 chez l’éditeur Tor Books. L’auteur est décédé en 2007 sans avoir achevé la série, mais il a laissé assez de notes pour qu’un autre écrivain puisse terminer son œuvre.', 'larouedutemps4.jpg', '2020-09-04 08:14:13', 0),
(8, 'Les Chroniques de Krondor - Pug l’apprenti', 'Les Chroniques de Krondor (titre original : The Riftwar Cycle) est une saga de fantasy de l’écrivain Raymond E. Feist, dont la parution a commencé en 1982. Elle est composée de nombreux cycles, tournant autour de l’univers de Midkemia et de guerres dimensionnelles liées à des portails nommés les failles.', 'krondormagicien1.jpg', '2020-09-04 08:14:13', 0),
(9, 'Les Chroniques de Krondor - Milamber le mage', 'Les Chroniques de Krondor (titre original : The Riftwar Cycle) est une saga de fantasy de l’écrivain Raymond E. Feist, dont la parution a commencé en 1982. Elle est composée de nombreux cycles, tournant autour de l’univers de Midkemia et de guerres dimensionnelles liées à des portails nommés les failles.', 'krondormagicien2.jpg', '2020-09-04 08:14:13', 0),
(10, 'Les Chroniques de Krondor - Silverthorn', 'Les Chroniques de Krondor (titre original : The Riftwar Cycle) est une saga de fantasy de l’écrivain Raymond E. Feist, dont la parution a commencé en 1982. Elle est composée de nombreux cycles, tournant autour de l’univers de Midkemia et de guerres dimensionnelles liées à des portails nommés les failles.', 'krondormagicien3.jpg', '2020-09-04 08:14:13', 0),
(11, 'Les Chroniques de Krondor - Ténèbres sur Sethanon', 'Les Chroniques de Krondor (titre original : The Riftwar Cycle) est une saga de fantasy de l’écrivain Raymond E. Feist, dont la parution a commencé en 1982. Elle est composée de nombreux cycles, tournant autour de l’univers de Midkemia et de guerres dimensionnelles liées à des portails nommés les failles.', 'krondormagicien4.jpg', '2020-09-04 08:14:13', 0),
(12, 'Janua Vera', 'Né du rêve d’un conquérant, le Vieux Royaume n’est plus que le souvenir de sa grandeur passée. Une poussière de fiefs, de bourgs et de cités a fleuri parmi ses ruines, une société féodale et chamarrée où des héros nobles ou humbles, brutaux ou érudits, se dressent contre leur destin.', 'januavera.jpg', '2020-09-04 08:14:13', 0),
(13, 'Gagner la guerre', 'Ce livre se déroule dans le Vieux Royaume, un univers de fantasy où la magie est présente et puissante, et qui puise largement son inspiration dans le roman de cape et d’épée et le roman historique (Renaissance italienne). On y retrouve le personnage de Benvenuto Gesufal, déjà présent dans le recueil de nouvelles Janua Vera', 'gagnerlaguerre.jpg', '2020-09-04 08:14:13', 0),
(14, 'Même pas mort', 'Je m’appelle Bellovèse, fils de Sacrovèse, fils de Belinos. Pendant la Guerre des Sangliers, mon oncle Ambigat a tué mon père. Entre beaux-frères, ce sont des choses qui arrivent. Surtout quand il s’agit de rois de tribus rivales… Ma mère, mon frère et moi, nous avons été exilés au fond du royaume biturige. Parce que nous étions de son sang, parce qu’il n’est guère glorieux de tuer des enfants, Ambigat nous a épargnés.', 'memepasmort.jpg', '2020-09-04 08:14:14', 0),
(15, 'Chasse royale', 'ans la Celtique ravagée par la guerre, le mystère plane sur le sort du haut roi. Ambigat est-il mort ? Est-il encore en vie ? L’incertitude excite les convoitises et ajoute au désordre. Par loyauté et par ambition, Bellovèse se lance à la recherche du roi caché. À travers les contrées écumées par des bandes féroces, mais aussi à travers la géographie des rêves et des oracles, il remonte la piste du souverain.', 'chasseroyale.jpg', '2020-09-04 08:14:14', 0);

-- --------------------------------------------------------

--
-- Structure de la table `livre_categorie`
--

CREATE TABLE `livre_categorie` (
  `livre_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `auteur_livre`
--
ALTER TABLE `auteur_livre`
  ADD PRIMARY KEY (`auteur_id`,`livre_id`),
  ADD KEY `IDX_A6DFA5E060BB6FE6` (`auteur_id`),
  ADD KEY `IDX_A6DFA5E037D925CB` (`livre_id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorie_livre`
--
ALTER TABLE `categorie_livre`
  ADD PRIMARY KEY (`categorie_id`,`livre_id`),
  ADD KEY `IDX_591BA249BCF5E72D` (`categorie_id`),
  ADD KEY `IDX_591BA24937D925CB` (`livre_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `livre_categorie`
--
ALTER TABLE `livre_categorie`
  ADD PRIMARY KEY (`livre_id`,`categorie_id`),
  ADD KEY `IDX_E61B069E37D925CB` (`livre_id`),
  ADD KEY `IDX_E61B069EBCF5E72D` (`categorie_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `auteur`
--
ALTER TABLE `auteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `livre`
--
ALTER TABLE `livre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `auteur_livre`
--
ALTER TABLE `auteur_livre`
  ADD CONSTRAINT `FK_A6DFA5E037D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A6DFA5E060BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `auteur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `categorie_livre`
--
ALTER TABLE `categorie_livre`
  ADD CONSTRAINT `FK_591BA24937D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_591BA249BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `livre_categorie`
--
ALTER TABLE `livre_categorie`
  ADD CONSTRAINT `FK_E61B069E37D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E61B069EBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
