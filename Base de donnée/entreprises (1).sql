-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 18 mai 2024 à 10:13
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `entreprises`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id`, `email`, `mot_de_passe`, `date_creation`) VALUES
(6, 'admin@gmail.com', 'Admin', '2024-04-29 08:24:01');

-- --------------------------------------------------------

--
-- Structure de la table `code`
--

CREATE TABLE `code` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `code`
--

INSERT INTO `code` (`id`, `code`, `id_utilisateur`, `expiration`) VALUES
(11, '318066', 5, NULL),
(12, '888573', 5, NULL),
(13, '570868', 5, NULL),
(14, '977244', 5, NULL),
(15, '970087', 5, NULL),
(16, '295666', 27, NULL),
(17, '882867', 27, NULL),
(18, '314697', 27, NULL),
(19, '658213', 27, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `commentaire` text NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_publication` int(11) NOT NULL,
  `activer-le` timestamp NOT NULL DEFAULT current_timestamp(),
  `supprimer-le` timestamp NULL DEFAULT NULL,
  `creer-le` timestamp NOT NULL DEFAULT current_timestamp(),
  `mit-a-jour-le` timestamp NOT NULL DEFAULT current_timestamp(),
  `auteur_commentaire` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `commentaire`, `id_utilisateur`, `id_publication`, `activer-le`, `supprimer-le`, `creer-le`, `mit-a-jour-le`, `auteur_commentaire`) VALUES
(42, 'ertyh', 27, 48, '2024-05-10 11:37:19', NULL, '2024-05-10 11:37:19', '2024-05-10 11:37:19', 'maxime');

-- --------------------------------------------------------

--
-- Structure de la table `like`
--

CREATE TABLE `like` (
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_publication` int(11) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_publication` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `id_utilisateur`, `id_publication`, `date`) VALUES
(127, 27, 48, '2024-05-10 11:37:13');

-- --------------------------------------------------------

--
-- Structure de la table `publication`
--

CREATE TABLE `publication` (
  `id` int(11) NOT NULL,
  `publication` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `activer-le` timestamp NULL DEFAULT NULL,
  `supprimer-le` timestamp NULL DEFAULT NULL,
  `creer-le` timestamp NOT NULL DEFAULT current_timestamp(),
  `mit-a-jour-le` timestamp NOT NULL DEFAULT current_timestamp(),
  `nom_auteur` varchar(256) NOT NULL,
  `prenom_auteur` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `publication`
--

INSERT INTO `publication` (`id`, `publication`, `image`, `id_utilisateur`, `activer-le`, `supprimer-le`, `creer-le`, `mit-a-jour-le`, `nom_auteur`, `prenom_auteur`) VALUES
(48, 'pauldn', 'uploads/je veux l\'image de la nature éclairé par les rayon.jpg', 27, NULL, NULL, '2024-05-10 11:37:09', '2024-05-10 11:37:09', 'maxime', '');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenoms` varchar(255) NOT NULL,
  `sexe` varchar(1) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot-de-passe` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `activer-le` timestamp NULL DEFAULT NULL,
  `supprimer-le` timestamp NULL DEFAULT NULL,
  `creer-le` timestamp NOT NULL DEFAULT current_timestamp(),
  `mit-a-jour-le` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenoms`, `sexe`, `email`, `mot-de-passe`, `avatar`, `activer-le`, `supprimer-le`, `creer-le`, `mit-a-jour-le`) VALUES
(26, 'Lalya', 'isidore', 'M', 'lalyaisidore@gmail.com', '330088d6863a1793c2dcd320afa4186816939b6e', NULL, NULL, NULL, '2024-05-02 11:34:33', '2024-05-02 11:34:33'),
(27, 'maxime', 'paul', 'M', 'dossoumaxime888@gmail.com', '330088d6863a1793c2dcd320afa4186816939b6e', NULL, NULL, NULL, '2024-05-10 11:36:34', '2024-05-10 11:36:34');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `code`
--
ALTER TABLE `code`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_publication` (`id_publication`);

--
-- Index pour la table `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_publication` (`id_publication`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_publication` (`id_publication`);

--
-- Index pour la table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `code`
--
ALTER TABLE `code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `like`
--
ALTER TABLE `like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT pour la table `publication`
--
ALTER TABLE `publication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `like`
--
ALTER TABLE `like`
  ADD CONSTRAINT `like_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `like_ibfk_2` FOREIGN KEY (`id_publication`) REFERENCES `publication` (`id`);

DELIMITER $$
--
-- Évènements
--
CREATE DEFINER=`root`@`localhost` EVENT `vide_table_code` ON SCHEDULE EVERY 10 MINUTE STARTS '2024-05-03 09:23:08' ON COMPLETION NOT PRESERVE ENABLE DO TRUNCATE TABLE code$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
