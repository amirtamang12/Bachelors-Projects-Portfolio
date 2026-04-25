-- Adminer 4.8.1 MySQL 8.0.30 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `User` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `User`;

DROP TABLE IF EXISTS `User_account`;
CREATE TABLE `User_account` (
  `Name` varchar(20) NOT NULL,
  `Email` varchar(20) NOT NULL,
  `Password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `User_account` (`Name`, `Email`, `Password`) VALUES
('admin',	'admin@admin.com',	'$2y$10$VMEAmS981yGooqR1L/vYk.GPEX3veCV2fEg7uI7YNyUG.4VPF7DIW'),
('User1',	'user@user.com',	'$2y$10$db.AtAkKOC5tGsE9BZnXFOx3MOAski8DJXdZLRsaTIyne0NPMudSi');

-- 2022-09-25 16:47:13
