-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 27 avr. 2021 à 13:55
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `platypus`
--

-- --------------------------------------------------------

--
-- Structure de la table `chat_messages`
--

DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `time` varchar(10) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user`, `time`, `message`) VALUES
(6, 5, '26-04-21', 'test depuis le navigateur'),
(5, 5, '26-04-21', 'test depuis le navigateur'),
(4, 5, '26-04-21', 'test depuis le navigateur'),
(7, 5, '26-04-21', 'test depuis le navigateur'),
(8, 5, '26-04-21', 'test depuis le navigateur'),
(9, 5, '26-04-21', 'test depuis le navigateur'),
(10, 5, '26-04-21', 'eee'),
(11, 5, '26-04-21', 'test'),
(12, 5, '26-04-21', 'test2'),
(13, 5, '26-04-21', 'test3'),
(14, 5, '26-04-21', 'pb'),
(15, 5, '26-04-21', 'test4'),
(16, 5, '26-04-21', 'test4'),
(17, 5, '26-04-21', 'test5'),
(18, 5, '26-04-21', 'test6'),
(19, 5, '26-04-21', 'eee'),
(20, 5, '26-04-21', 'ee'),
(21, 5, '26-04-21', 'eeeee'),
(22, 5, '26-04-21', 'ttt'),
(23, 5, '26-04-21', 'eee'),
(24, 5, '26-04-21', 'leleld'),
(25, 5, '26-04-21', 'dhdhsb '),
(26, 5, '26-04-21', 'qqqq'),
(27, 5, '26-04-21', 'eeeee'),
(28, 5, '26-04-21', 'onglet 2'),
(29, 5, '26-04-21', 'onglet 1'),
(30, 5, '27-04-21', 'r'),
(31, 5, '27-04-21', 'Marc'),
(32, 5, '27-04-21', 'apres overflow'),
(33, 5, '27-04-21', 'apres overflow2'),
(34, 5, '27-04-21', 'ee'),
(35, 5, '27-04-21', 'eeee'),
(36, 5, '27-04-21', 'test'),
(37, 5, '27-04-21', 'test'),
(38, 5, '27-04-21', 'eee'),
(39, 5, '27-04-21', 'eee'),
(40, 5, '27-04-21', 'eee'),
(41, 5, '27-04-21', 'test'),
(42, 5, '27-04-21', 'test'),
(43, 5, '27-04-21', 'test'),
(44, 5, '27-04-21', 'eee'),
(45, 5, '27-04-21', 'eeee'),
(46, 5, '27-04-21', 'ee'),
(47, 5, '27-04-21', 'eee'),
(48, 5, '27-04-21', 'eee'),
(49, 5, '27-04-21', 'eee'),
(50, 5, '27-04-21', 'eee'),
(51, 5, '27-04-21', 'eee'),
(52, 5, '27-04-21', 'ee'),
(53, 5, '27-04-21', 'ee'),
(54, 5, '27-04-21', 'ee');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(5, 'MarcJus', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
