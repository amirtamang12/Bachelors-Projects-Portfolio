-- Adminer 4.8.1 MySQL 8.0.34 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `Auctions`;
CREATE TABLE `Auctions` (
  `AuctionID` int NOT NULL AUTO_INCREMENT,
  `AuctionDate` date DEFAULT NULL,
  `CatalogueNumber` varchar(20) DEFAULT NULL,
  `Description` text,
  `Location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`AuctionID`),
  UNIQUE KEY `CatalogueNumber` (`CatalogueNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `Auctions` (`AuctionID`, `AuctionDate`, `CatalogueNumber`, `Description`, `Location`) VALUES
(1,	'2023-09-20',	'211',	'<p>This is the first test. But Edited.</p>',	'London');

DROP TABLE IF EXISTS `Bids`;
CREATE TABLE `Bids` (
  `BidID` int NOT NULL AUTO_INCREMENT,
  `ItemID` int DEFAULT NULL,
  `UserID` int DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `BidTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` varchar(50) DEFAULT 'Pending',
  PRIMARY KEY (`BidID`),
  KEY `ItemID` (`ItemID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `Bids_ibfk_1` FOREIGN KEY (`ItemID`) REFERENCES `Items` (`ItemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Bids_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `User` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `Bids` (`BidID`, `ItemID`, `UserID`, `Amount`, `BidTime`, `Status`) VALUES
(13,	4,	1,	550.00,	'2023-09-19 15:05:52',	'Sold'),
(14,	4,	1,	600.00,	'2023-09-19 15:11:49',	'Pending'),
(15,	3,	1,	550.00,	'2023-09-19 15:53:41',	'Sold');

DROP TABLE IF EXISTS `Carvings`;
CREATE TABLE `Carvings` (
  `CarvingID` int NOT NULL AUTO_INCREMENT,
  `ItemID` int DEFAULT NULL,
  `MaterialUsed` varchar(50) DEFAULT NULL,
  `HeightInCm` decimal(6,2) DEFAULT NULL,
  `LengthInCm` decimal(6,2) DEFAULT NULL,
  `WidthInCm` decimal(6,2) DEFAULT NULL,
  `ApproxWeightInKg` decimal(6,2) DEFAULT NULL,
  `LotNumber` int DEFAULT NULL,
  PRIMARY KEY (`CarvingID`),
  UNIQUE KEY `ItemID` (`ItemID`),
  CONSTRAINT `Carvings_ibfk_1` FOREIGN KEY (`ItemID`) REFERENCES `Items` (`ItemID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `Carvings` (`CarvingID`, `ItemID`, `MaterialUsed`, `HeightInCm`, `LengthInCm`, `WidthInCm`, `ApproxWeightInKg`, `LotNumber`) VALUES
(3,	3,	'Marble',	20.00,	15.00,	15.00,	10.00,	NULL);

DROP TABLE IF EXISTS `Drawings`;
CREATE TABLE `Drawings` (
  `DrawingID` int NOT NULL AUTO_INCREMENT,
  `ItemID` int DEFAULT NULL,
  `DrawingMedium` varchar(50) DEFAULT NULL,
  `IsFramed` tinyint(1) DEFAULT NULL,
  `HeightInCm` decimal(6,2) DEFAULT NULL,
  `LengthInCm` decimal(6,2) DEFAULT NULL,
  `LotNumber` int DEFAULT NULL,
  PRIMARY KEY (`DrawingID`),
  UNIQUE KEY `ItemID` (`ItemID`),
  CONSTRAINT `Drawings_ibfk_1` FOREIGN KEY (`ItemID`) REFERENCES `Items` (`ItemID`),
  CONSTRAINT `Drawings_ibfk_2` FOREIGN KEY (`ItemID`) REFERENCES `Items` (`ItemID`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Items`;
CREATE TABLE `Items` (
  `ItemID` int NOT NULL AUTO_INCREMENT,
  `LotNumber` int DEFAULT NULL,
  `ArtistName` varchar(255) DEFAULT NULL,
  `YearProduced` int DEFAULT NULL,
  `GeneralSubject` varchar(50) DEFAULT NULL,
  `Description` text,
  `AuctionID` int DEFAULT NULL,
  `EstimatedPrice` decimal(10,2) DEFAULT NULL,
  `ImagePath` blob,
  `Status` varchar(255) NOT NULL DEFAULT 'Available',
  `AuctionDate` date DEFAULT NULL,
  `Location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ItemID`),
  UNIQUE KEY `LotNumber` (`LotNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `Items` (`ItemID`, `LotNumber`, `ArtistName`, `YearProduced`, `GeneralSubject`, `Description`, `AuctionID`, `EstimatedPrice`, `ImagePath`, `Status`, `AuctionDate`, `Location`) VALUES
(3,	22,	'Siddharth Yonzone',	2021,	'Drawings',	'<p>sfsfasd</p>',	1,	500.00,	'assets/img/items/item_65092d23433a1.jpeg',	'Available',	NULL,	NULL),
(4,	222,	'Siddharth Yonzone',	2021,	'Drawings',	'sfsfasd',	1,	500.00,	'assets/img/items/item_65092d23433a1.jpeg',	'Available',	NULL,	NULL),
(5,	311,	'Ram',	2021,	'Painting',	'Seller Listing Test',	NULL,	500.00,	'bus.jpeg',	'Available',	'2023-09-20',	'Paris');

DROP TABLE IF EXISTS `Paintings`;
CREATE TABLE `Paintings` (
  `PaintingID` int NOT NULL AUTO_INCREMENT,
  `ItemID` int DEFAULT NULL,
  `PaintingMedium` varchar(50) DEFAULT NULL,
  `IsFramed` tinyint(1) DEFAULT NULL,
  `HeightInCm` decimal(6,2) DEFAULT NULL,
  `LengthInCm` decimal(6,2) DEFAULT NULL,
  `LotNumber` int DEFAULT NULL,
  PRIMARY KEY (`PaintingID`),
  UNIQUE KEY `ItemID` (`ItemID`),
  CONSTRAINT `Paintings_ibfk_1` FOREIGN KEY (`ItemID`) REFERENCES `Items` (`ItemID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `PhotographicImages`;
CREATE TABLE `PhotographicImages` (
  `PhotoID` int NOT NULL AUTO_INCREMENT,
  `ItemID` int DEFAULT NULL,
  `ImageType` varchar(50) DEFAULT NULL,
  `HeightInCm` decimal(6,2) DEFAULT NULL,
  `LengthInCm` decimal(6,2) DEFAULT NULL,
  `LotNumber` int DEFAULT NULL,
  PRIMARY KEY (`PhotoID`),
  UNIQUE KEY `ItemID` (`ItemID`),
  CONSTRAINT `PhotographicImages_ibfk_1` FOREIGN KEY (`ItemID`) REFERENCES `Items` (`ItemID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Sculptures`;
CREATE TABLE `Sculptures` (
  `SculptureID` int NOT NULL AUTO_INCREMENT,
  `ItemID` int DEFAULT NULL,
  `MaterialUsed` varchar(50) DEFAULT NULL,
  `HeightInCm` decimal(6,2) DEFAULT NULL,
  `LengthInCm` decimal(6,2) DEFAULT NULL,
  `WidthInCm` decimal(6,2) DEFAULT NULL,
  `ApproxWeightInKg` decimal(6,2) DEFAULT NULL,
  `LotNumber` int DEFAULT NULL,
  PRIMARY KEY (`SculptureID`),
  UNIQUE KEY `ItemID` (`ItemID`),
  CONSTRAINT `Sculptures_ibfk_1` FOREIGN KEY (`ItemID`) REFERENCES `Items` (`ItemID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `User`;
CREATE TABLE `User` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `userName` varchar(20) NOT NULL,
  `fullName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `confirmPassword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `userType` varchar(50) NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `User` (`userId`, `userName`, `fullName`, `email`, `password`, `confirmPassword`, `userType`) VALUES
(1,	'sid7',	'Siddharth Tamang',	'sid@gmail.com',	'$2y$10$bJ9lC1dogjHM5tcbwYOLHeef8rnQ6epTgOtcG/CmW5rObfUxizPZG',	'12345',	'admin'),
(2,	'amir1',	'Amir',	'amir@gmail.com',	'$2y$10$cwHW9TG5/XmFOcFfYpvdZuClMCcUHLKdVCOInBGlev9jd3UaZmTmC',	'12345',	'Seller'),
(3,	'ram23',	'Ram',	'ram@ram.com',	'$2y$10$yEule.P7bAIWwmZCAAcDG.egMTEOrXu/j3jK4mRoNSbHA1GjLrpg.',	'12345',	'Buyer'),
(4,	'anish ',	'Anish Shrestha',	'sthanish@gmaill.com',	'$2y$10$Umpl63qD90/iGLOEf/lhPORT72QaFdSHWHxwuxJ74LH4bhbqMDtrq',	'$2y$10$OHK2djFbrk7cQWuEQ9asRe5JkOOR5nWhAhVzMnZf38ydSzDpr8qPq',	'buyer_and_seller');

-- 2023-09-19 17:42:36
