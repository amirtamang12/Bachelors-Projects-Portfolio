-- Adminer 4.8.1 MySQL 8.1.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `tbl_order`;
CREATE TABLE `tbl_order` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `order_date` date NOT NULL,
  `order_status` varchar(20) NOT NULL,
  `reference_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `expected_delivery_date` date NOT NULL,
  `total_amount` float NOT NULL,
  `number_of_items` int NOT NULL,
  `user_id` int NOT NULL,
  `billing_address` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `billing_username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tbl_order` (`order_id`, `order_date`, `order_status`, `reference_no`, `expected_delivery_date`, `total_amount`, `number_of_items`, `user_id`, `billing_address`, `billing_username`) VALUES
(3,	'2023-09-11',	'Processing',	'',	'2023-09-14',	30000,	1,	1,	'Chabahil',	'Amir Tamang'),
(4,	'2023-09-11',	'Processing',	'',	'2023-09-14',	30000,	1,	1,	'Bouddha',	'Ram Thapa'),
(5,	'2023-09-11',	'Processing',	'',	'2023-09-14',	30000,	1,	1,	'Bouddha',	'Ram Thapa'),
(6,	'2023-09-11',	'Processing',	'',	'2023-09-14',	30000,	1,	1,	'Chabahil',	'Amir Tamang'),
(7,	'2023-09-11',	'Processing',	'',	'2023-09-14',	30000,	1,	1,	'dsvdsvv',	'Bro'),
(8,	'2023-09-11',	'Processing',	'',	'2023-09-14',	30000,	1,	1,	'bgbfbf',	'Amir Tamang'),
(9,	'2023-09-11',	'Processing',	'',	'2023-09-14',	30000,	1,	1,	'bgbfbf',	'Amir Tamang'),
(10,	'2023-09-11',	'Processing',	'',	'2023-09-14',	30000,	1,	1,	'bgbfbf',	'Amir Tamang'),
(11,	'2023-09-11',	'Processing',	'REF16944486719885',	'2023-09-14',	30000,	1,	1,	'jjjjjjjjjjjjjjjjjjjjjjjj',	'vdfvfvfv'),
(12,	'2023-09-12',	'Processing',	'REF16944907579214',	'2023-09-15',	30000,	1,	1,	'fehfedb',	'Amir Tamang'),
(13,	'2023-09-12',	'Processing',	'REF16945164157165',	'2023-09-15',	150000,	1,	1,	'gol',	'Amir Tamang'),
(14,	'2023-09-14',	'Processing',	'REF16946619057085',	'2023-09-17',	15000,	1,	1,	'sddvdv',	'Amir Tamang'),
(15,	'2023-09-14',	'Processing',	'REF16946623707293',	'2023-09-17',	15000,	1,	1,	'sddvdv',	'Amir Tamang'),
(16,	'2023-09-14',	'Processing',	'REF16946624173816',	'2023-09-17',	15000,	1,	1,	'sddvdv',	'Amir Tamang'),
(17,	'2023-09-14',	'Processing',	'REF16946624382611',	'2023-09-17',	15000,	1,	1,	'sddvdv',	'Amir Tamang'),
(18,	'2023-09-14',	'Processing',	'REF16946640711705',	'2023-09-17',	15000,	1,	1,	'sddvdv',	'Amir Tamang'),
(19,	'2023-09-14',	'Processing',	'REF16946641554974',	'2023-09-17',	15000,	1,	1,	'jjjjjjjjjjjjjjj',	'Amir Tamang'),
(20,	'2023-09-14',	'Processing',	'REF16946864085513',	'2023-09-17',	1050,	3,	3,	'Chabahil',	'Wangden Sherpa'),
(21,	'2023-09-14',	'Processing',	'REF16947007316548',	'2023-09-17',	7000,	2,	1,	'dfnrsfhfbhf',	'Bro'),
(22,	'2023-09-14',	'Processing',	'REF16947009243442',	'2023-09-17',	7000,	2,	1,	'dfnrsfhfbhf',	'Amir Tamang'),
(23,	'2023-09-14',	'Processing',	'REF16947009955002',	'2023-09-17',	7000,	2,	1,	'dfnrsfhfbhf',	'Amir Tamang'),
(24,	'2023-09-17',	'Processing',	'REF16949143379094',	'2023-09-20',	30000,	1,	1,	'Chabahil',	'Bro'),
(25,	'2023-09-18',	'Processing',	'REF16950524591787',	'2023-09-21',	0,	0,	1,	'dvdslv,v,',	'Bro'),
(26,	'2023-09-18',	'Processing',	'REF16950525177075',	'2023-09-21',	5000,	1,	1,	'Barcelona',	'Amir Tamang'),
(27,	'2023-09-18',	'Processing',	'REF16950525284604',	'2023-09-21',	5000,	1,	1,	'Barcelona',	'Amir Tamang');

DROP TABLE IF EXISTS `tbl_order_detail`;
CREATE TABLE `tbl_order_detail` (
  `order_detail_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `quantity` int NOT NULL,
  `quantity_price` float NOT NULL,
  `status` int NOT NULL,
  `remarks` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`order_detail_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `tbl_order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tbl_order_detail` (`order_detail_id`, `order_id`, `quantity`, `quantity_price`, `status`, `remarks`) VALUES
(1,	17,	1,	15000,	0,	NULL),
(2,	18,	1,	15000,	0,	NULL),
(3,	19,	1,	15000,	0,	NULL),
(4,	20,	1,	450,	0,	NULL),
(5,	20,	1,	300,	0,	NULL),
(6,	20,	1,	300,	0,	NULL),
(7,	23,	1,	5000,	0,	NULL),
(8,	23,	1,	2000,	0,	NULL),
(9,	24,	1,	30000,	0,	NULL),
(10,	26,	1,	5000,	0,	NULL),
(11,	27,	1,	5000,	0,	NULL);

DROP TABLE IF EXISTS `tbl_payment`;
CREATE TABLE `tbl_payment` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `payment_for` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `amount_paid` float NOT NULL,
  `remarks` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `payment_status` varchar(20) NOT NULL,
  `paid_by` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_payment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tbl_payment` (`payment_id`, `payment_for`, `amount_paid`, `remarks`, `payment_status`, `paid_by`, `user_id`) VALUES
(3,	'German Shephard',	30000,	NULL,	'Completed',	'Amir',	1),
(4,	'pet',	30000,	NULL,	'Completed',	'amir tamng',	1),
(5,	'pet',	30000,	NULL,	'Completed',	'Amir',	1),
(6,	'pet',	30000,	NULL,	'Completed',	'amir tamng',	1),
(7,	'pet',	30000,	NULL,	'Completed',	'amir tamng',	1),
(8,	'pet',	30000,	NULL,	'Completed',	'amir tamng',	1),
(9,	'pet',	15000,	NULL,	'Completed',	'amir tamng',	1),
(10,	'pet',	15000,	NULL,	'Completed',	'Amir',	1),
(11,	'Pet',	1050,	NULL,	'Completed',	'Wangden',	3),
(12,	'Cat and pedigree',	7000,	NULL,	'Completed',	'Amir',	1),
(13,	'Pug ',	500,	NULL,	'Completed',	'Amir',	1);

DROP TABLE IF EXISTS `tbl_pet`;
CREATE TABLE `tbl_pet` (
  `pet_id` int NOT NULL AUTO_INCREMENT,
  `pet_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `pet_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pet_price` float NOT NULL,
  `discount` float DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `pet_category_id` int NOT NULL,
  `pet_images` blob NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`pet_id`),
  KEY `pet_category_id` (`pet_category_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_pet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_pet_ibfk_2` FOREIGN KEY (`pet_category_id`) REFERENCES `tbl_pet_category` (`pet_category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tbl_pet` (`pet_id`, `pet_description`, `pet_name`, `pet_price`, `discount`, `quantity`, `pet_category_id`, `pet_images`, `user_id`) VALUES
(24,	'',	'Pug',	5000,	NULL,	NULL,	1,	'../../pimg/pug.jpg',	1),
(25,	'',	'German Shephard',	30000,	NULL,	NULL,	1,	'../../pimg/German_Shepherd.jpg',	1),
(27,	'',	'Bulldog',	70000,	NULL,	NULL,	1,	'../../pimg/Bulldog.jpg',	1),
(28,	'',	'Husky',	50000,	NULL,	NULL,	1,	'../../pimg/husky.jpg',	1),
(29,	'',	'Golden Retriever',	45000,	NULL,	NULL,	1,	'../../pimg/goldenRetriever.jpg',	1),
(30,	'',	'Cat',	5000,	NULL,	NULL,	2,	'../../pimg/cat1.jpg',	1),
(31,	'',	'Persian Cat',	80000,	NULL,	NULL,	2,	'../../pimg/persian_cat.jpg',	1),
(32,	'',	'Abyssinian ',	70000,	NULL,	NULL,	2,	'../../pimg/abyssinian.jpg',	1),
(33,	'',	'Gold Fish',	200,	NULL,	NULL,	4,	'../../pimg/goldFish.jpg',	1),
(34,	'',	'Koi Fish (1 pair)',	300,	NULL,	NULL,	4,	'../../pimg/koiFish.jpg',	1),
(35,	'',	'Comet Fish',	250,	NULL,	NULL,	4,	'../../pimg/cometFish.jpg',	1),
(36,	'',	'Love Birds (1 pair)',	500,	NULL,	NULL,	5,	'../../pimg/lovebirds.jpg',	1),
(37,	'',	'Canary',	150,	NULL,	NULL,	5,	'../../pimg/canary.jpg',	1),
(39,	'',	'Cocktiel',	500,	NULL,	NULL,	5,	'../../pimg/cockatiel.jpg',	1),
(40,	'',	'Guinea Pig (1 Pair)',	500,	NULL,	NULL,	6,	'../../pimg/GuineaPig.jpg',	1),
(41,	'',	'Rabbit (1 Pair)',	450,	NULL,	NULL,	6,	'../../pimg/rabbit.jpg',	1),
(42,	'',	'Hamster',	600,	NULL,	NULL,	6,	'../../pimg/hamster.jpg',	1),
(43,	'',	'Mouse (1 Pair)',	300,	NULL,	NULL,	6,	'../../pimg/mouse.jpg',	1);

DROP TABLE IF EXISTS `tbl_pet_category`;
CREATE TABLE `tbl_pet_category` (
  `pet_category_id` int NOT NULL AUTO_INCREMENT,
  `pet_category_name` varchar(30) NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`pet_category_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_pet_category_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tbl_pet_category` (`pet_category_id`, `pet_category_name`, `user_id`) VALUES
(1,	'Dog',	1),
(2,	'Cat',	1),
(4,	'Fish',	1),
(5,	'Birds',	1),
(6,	'Small Mammal',	1);

DROP TABLE IF EXISTS `tbl_pet_product`;
CREATE TABLE `tbl_pet_product` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_code` varchar(30) NOT NULL,
  `product_name` varchar(30) NOT NULL,
  `product_detail` varchar(100) NOT NULL,
  `product_category_id` int NOT NULL,
  `product_image` blob NOT NULL,
  `quantity_on_hand` int NOT NULL,
  `retail_price` float NOT NULL,
  `discount` float NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `product_category_id` (`product_category_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_pet_product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_pet_product_ibfk_2` FOREIGN KEY (`product_category_id`) REFERENCES `tbl_pet_product_category` (`product_category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tbl_pet_product` (`product_id`, `product_code`, `product_name`, `product_detail`, `product_category_id`, `product_image`, `quantity_on_hand`, `retail_price`, `discount`, `user_id`) VALUES
(13,	'PT-101',	'LED light up Ball ',	'',	1,	'../../pimg/LedLightUpBall.jpg',	1,	250,	0,	1),
(14,	'PT-102',	'Braided Chew Ball Toy',	'',	1,	'../../pimg/braidedDogChewSingleBallToy.jpg',	1,	400,	0,	1),
(15,	'PT-103',	'Fish Toy',	'',	1,	'../../pimg/FishToy.jpg',	1,	300,	0,	1),
(16,	'PT-104',	'Fish Bowl (10 inches)',	'',	1,	'../../pimg/FishGlassBowl6_8_10Inches.jpg',	1,	600,	0,	1),
(17,	'PF-101',	'Pedigree',	'',	2,	'../../pimg/pedigree.jpeg',	1,	875,	0,	1),
(18,	'PT-102',	'Drools',	'',	2,	'../../pimg/drools.jpeg',	1,	745,	0,	1),
(19,	'PT-103',	'Whiskas',	'',	2,	'../../pimg/wihskas.jpeg',	1,	475,	0,	1),
(20,	'PT-104',	'MewMix',	'',	2,	'../../pimg/meowmix.jpg',	1,	500,	0,	1),
(21,	'PF-105',	'BFB fish food',	'',	2,	'../../pimg/bfbfishfood.jpg',	1,	250,	0,	1),
(22,	'PF-106',	'PetsLife',	'',	2,	'../../pimg/petslife.jpeg',	1,	200,	0,	1),
(23,	'PC-101',	'Pet Harness',	'',	3,	'../../pimg/petHarness.jpeg',	1,	250,	0,	1),
(24,	'PC-103',	'Premium Dog Collar',	'',	3,	'../../pimg/premiumDogCollar.jpg',	1,	1000,	0,	1);

DROP TABLE IF EXISTS `tbl_pet_product_category`;
CREATE TABLE `tbl_pet_product_category` (
  `product_category_id` int NOT NULL AUTO_INCREMENT,
  `product_category_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`product_category_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_pet_product_category_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tbl_pet_product_category` (`product_category_id`, `product_category_name`, `user_id`) VALUES
(1,	'Toys',	1),
(2,	'Foods and Treats',	1),
(3,	'Collars and Leashes',	1);

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `repassword` varchar(30) NOT NULL,
  `reset_token` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `token_expiration` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `tbl_user` (`user_id`, `password`, `repassword`, `reset_token`, `username`, `contact`, `email`, `token_expiration`) VALUES
(1,	'$2y$10$RKRhQAFm3Myh8q5p3/dZy.Plz/kwwyF8ifY4up7xmBJkOQKIawq3K',	'123456',	'dbd015e55812cf179728537ec6f72cfec7007b8b740f6e1a7ea66f947726a642',	'Amir Tamang',	'9823412484',	'amir.yonjan12@gmail.com',	'2023-09-12 10:54:48'),
(2,	'$2y$10$3RCM1Gxp32p8AYJrw7xxjeZ/.2sUtNcIc8gY9XMKvNQqD4gxusdQC',	'654321',	'',	'Siddharth Yonzone',	'98456683123',	'sid@gmail.com',	NULL),
(3,	'$2y$10$18l0.MZKYavO5jX5yTkaRu1PeZPLmLEloXHEn7JjioQlJR0PguAOe',	'wangden123',	NULL,	'Wangden Sherpa',	'9818131580',	'wangdencerpa12345@gmail.com',	NULL);

-- 2023-09-20 02:57:47
