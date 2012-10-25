-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 25 okt 2012 kl 10:20
-- Serverversion: 5.5.24-log
-- PHP-version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `nyblogg`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `description` varchar(130) NOT NULL,
  `imageData` varchar(60) NOT NULL,
  `imageName` varchar(60) NOT NULL,
  `imageID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`imageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `images`
--

INSERT INTO `images` (`description`, `imageData`, `imageName`, `imageID`) VALUES
('', 'ÿØÿà\0JFIF\0\0`\0`\0\0ÿî\0Adobe\0d\0\0\0\0ÿá\rþExif\0\0MM\0*\0\0\0\02\0', '0ab40Lighthouse.jpg', 1),
('', 'ÿØÿà\0JFIF\0\0`\0`\0\0ÿáExif\0\0MM\0*\0\0\0\02\0\0\0\0\0\0\0VGF\0\0\0\0', 'd61bdDesert.jpg', 2),
('', 'ÿØÿà\0JFIF\0\0`\0`\0\0ÿá-Exif\0\0MM\0*\0\0\0\02\0\0\0\0\0\0\0bGF\0\0\0\0', '70e33Jellyfish.jpg', 3),
('', 'ÿØÿà\0JFIF\0\0\0\0\0\0ÿÛ\0C\0\n\n\n\n\r\r#%$""!&', '9b964672023.jpg', 4);

-- --------------------------------------------------------

--
-- Tabellstruktur `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `deleted` bit(1) NOT NULL,
  PRIMARY KEY (`postID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumpning av Data i tabell `posts`
--

INSERT INTO `posts` (`postID`, `content`, `date`, `deleted`) VALUES
(1, 'hej hej', '2012-10-24 09:41:10', b'1'),
(2, 'Hej hej', '2012-10-24 09:41:33', b'1'),
(3, 'Hej hej igen', '2012-10-24 13:27:44', b'1'),
(4, 'Hej dÃ¤r!', '2012-10-24 14:38:52', b'1'),
(5, 'dsadsa', '2012-10-24 14:48:46', b'1'),
(6, 'hej o hej igen.\r\nvilket bra jobbb simon!\r\nheja!', '2012-10-24 21:47:52', b'1'),
(7, 'krussidull', '2012-10-24 21:48:25', b'1'),
(8, 'Hej dÃ¤r', '2012-10-25 10:48:19', b'0');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `email` varchar(50) NOT NULL,
  `admin` bit(1) NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `password` (`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`userID`, `name`, `password`, `email`, `admin`) VALUES
(1, 'Admin', 'dbab702cb567b22b4fcc17809cb9baddc06bcee7b5f870f14aba3ed7b5642afc024c22010ec9e0e779101ce92bc342e7877fd4875774edcdd4ebe944a76e7dda', 'admin@gmail.com', b'1'),
(2, 'User', 'eee8bf275f8bc593e85f6bbbce4c6a4e135e138e8ebd32706efea8456dceed54ad4fa873993afedeb4d0a71248a20d9aed2a90daa72612df08941b73ae81a5f5', 'user@gmail.com', b'0'),
(4, 'Kalle', '35dcfeea7fa40e3ac4408faa2a86b2d4f89e2cead8b3c0bced2a48fdd6a2133abfb3b5f0adc8a55e7c3d87c8b90725092c17e6052255da9f0e424bbc2be0da4d', 'kalle@gmail.com', b'0'),
(5, 'Sara', 'a5aea1e3dc04adb183f3eb2a373b8eebb0aac41d81bba94e8f438b319f21a9df9e35b97d264a9dfad8b7d197e0beac497d73d18dc77af15581435ba4bfc6d925', 'sara', b'0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
