-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2023 at 02:04 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `ACCOUNT_ID` int(11) NOT NULL,
  `ACCOUNT_NAME` varchar(50) NOT NULL,
  `ACCOUNT_HASHEDPASS` varchar(2000) NOT NULL,
  `ACCOUNT_ROLE` varchar(50) NOT NULL,
  `ACCOUNT_EMAIL` varchar(200) NOT NULL,
  `ACCOUNT_TELEPHONE` varchar(20) DEFAULT NULL,
  `ACCOUNT_MOBILE` varchar(20) DEFAULT NULL,
  `ACCOUNT_CREATED` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`ACCOUNT_ID`, `ACCOUNT_NAME`, `ACCOUNT_HASHEDPASS`, `ACCOUNT_ROLE`, `ACCOUNT_EMAIL`, `ACCOUNT_TELEPHONE`, `ACCOUNT_MOBILE`, `ACCOUNT_CREATED`) VALUES
(1, 'admin', '$2y$10$LzESCv9NyvnVrBsmSbaKCuw9sZCTDCGvXMbEweSb/oTHxElseq/ky', 'admin', 'test@testing.org', '0123345324', '013819242', NULL),
(2, 'user', '$2y$10$LzESCv9NyvnVrBsmSbaKCuw9sZCTDCGvXMbEweSb/oTHxElseq/ky', 'user', 'user@testing.org', '0123345324', '013819242', NULL),
(3, 'zfasf', '$2y$10$0BkWY0GH7JOfs8rP5ReghOtLZbamF8JrFHqzRAl6y3JBqX0DQ.rmy', 'user', 'asfasfasf@fasdjifjsd.cisadja', NULL, NULL, NULL),
(4, 'alan', '$2y$10$eCwiSiM9EDXdM9kFUEg1ReI/.t2ynF2JtxLeaxnBVvm04cu4g5fxe', 'user', 'alan@email.alan', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `ADDRESS_ID` int(11) NOT NULL,
  `ADDRESS_FORENAME` varchar(40) NOT NULL,
  `ADDRESS_SURNAME` varchar(40) NOT NULL,
  `ADDRESS_LINE_1` varchar(100) NOT NULL,
  `ADDRESS_LINE_2` varchar(100) DEFAULT NULL,
  `ADDRESS_LINE_3` varchar(100) DEFAULT NULL,
  `ADDRESS_TOWN` varchar(100) DEFAULT NULL,
  `ADDRESS_POSTCODE` varchar(20) NOT NULL,
  `ADDRESS_COUNTRY` varchar(20) NOT NULL,
  `ACCOUNT_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`ADDRESS_ID`, `ADDRESS_FORENAME`, `ADDRESS_SURNAME`, `ADDRESS_LINE_1`, `ADDRESS_LINE_2`, `ADDRESS_LINE_3`, `ADDRESS_TOWN`, `ADDRESS_POSTCODE`, `ADDRESS_COUNTRY`, `ACCOUNT_ID`) VALUES
(1, 'Tess', 'Ting', '10 Test Road', NULL, NULL, NULL, 'MK18 4RP', 'United Kingdom', 1),
(2, 'Tess', 'Ting', '10 Test Road', NULL, NULL, NULL, 'MK18 4RP', 'United Kingdom', 2),
(3, 'David', 'Delahaye', 'This is an address', '', '', 'Blackpool', 'fy3 9rq', 'United Kingdom', 2),
(4, 'Forename', 'Surname', 'line 1', 'line 2', 'line 3', 'town', 'Postcode', 'Country', 2),
(5, 'cris', 'han', 'place', 'place2', 'place3', 'new york', 'NY3 U7T', 'America', 2);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CATEGORY_ID` int(11) NOT NULL,
  `CATEGORY_NAME` varchar(50) NOT NULL,
  `CATEGORY_DESCRIPTION` varchar(2000) DEFAULT NULL,
  `PARENT_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CATEGORY_ID`, `CATEGORY_NAME`, `CATEGORY_DESCRIPTION`, `PARENT_ID`) VALUES
(1, 'Wool', 'All Wool Products', NULL),
(2, 'Needles', 'All Needle Products', NULL),
(3, 'Small Needles', 'Needles that are smaller than normal sized needles', 2);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `MESSAGE_ID` int(11) NOT NULL,
  `MESSAGE_NAME` varchar(40) NOT NULL,
  `MESSAGE_DESCRIPTION` varchar(2000) NOT NULL,
  `MESSAGE_CREATED` datetime DEFAULT NULL,
  `ACCOUNT_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`MESSAGE_ID`, `MESSAGE_NAME`, `MESSAGE_DESCRIPTION`, `MESSAGE_CREATED`, `ACCOUNT_ID`) VALUES
(1, 'OI YOU TWAT, WHERES MY WOOL', 'I ORDERED 3 SUPER CHUNKY YELLOW WOOL, AN', '2023-04-18 13:22:25', 2),
(2, 'ashdusdnasjndjasdnasdm', 'WHERE MY WOOL', '2023-04-18 13:45:11', 1),
(3, 'dasdasd', 'eradsdasdasdasdwoool', '2023-04-18 13:47:05', 2),
(4, 'OI ODOIASOIDOASD', 'orem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas at tortor vel ante egestas congue vel non erat. In mollis pulvinar lacus. Duis eu orci mi. Mauris rutrum elit sed sagittis malesuada. Vestibulum porttitor arcu odio, eget cursus nibh mattis sed. Proin sodales massa in malesuada tincidunt. Sed vel magna id turpis bibendum vehicula sed sed nisi. Suspendisse ut nulla cursus, fringilla nisl eget, imperdiet erat. Pellentesque sed aliquam tellus. Curabitur tincidunt lacus tellus.\n\nSed ultrices vehicula augue et fringilla. Curabitur varius nisi sed sodales ullamcorper. In leo eros, lobortis quis ipsum et, tempor aliquam tortor. Vivamus facilisis nulla convallis neque consectetur, eget rutrum orci hendrerit. Morbi lacinia eleifend cursus. Cras sit amet leo sem. Nullam quis augue vitae metus iaculis tempus. Nullam ullamcorper lacus id mauris condimentum, et lobortis quam suscipit. Aliquam convallis, leo a ultricies vestibulum, risus nisi ornare tortor, nec vulputate elit turpis non nibh. Nunc sed tristique lorem. Mauris ut congue neque. Pellentesque ac tellus id enim auctor congue. Ut magna arcu, sollicitudin a neque sit amet, dictum imperdiet lorem.\n\nMaecenas vitae erat vel ligula placerat tincidunt. Proin porta facilisis diam, a suscipit purus dignissim ac. Nullam nec orci at magna molestie gravida ut at dolor. Praesent at massa quis nisi viverra rutrum. Cras molestie id metus vel venenatis. Praesent ac rutrum est, sed interdum justo. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec porta lacus sed interdum laoreet. Nunc congue non ex sed ultricies. Praesent augue metus, bibendum at enim vitae, pharetra dignissim felis. Nullam sit amet diam nunc. Suspendisse sagittis, justo ac cursus convallis, tellus libero ultrices nulla, nec malesuada nunc enim in metus.\n\nFusce lobortis lectus id leo euismod, ac ullamcorper ipsum efficitur. Etiam nisl turpis, sodales non sem non, facilisis vulputate orci. Pellentesque felis tellus, bibendum sit amet moll', '2023-04-18 13:50:51', 2),
(5, 'bello', 'la boda', '2023-04-18 13:56:39', 2);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `PRODUCT_ID` int(11) NOT NULL,
  `PRODUCT_SLUG` varchar(50) NOT NULL,
  `PRODUCT_NAME` varchar(200) NOT NULL,
  `PRODUCT_DESCRIPTION` varchar(2000) DEFAULT NULL,
  `PRODUCT_PRICE` decimal(10,2) DEFAULT NULL,
  `PRODUCT_IMG_PATH` varchar(2000) DEFAULT NULL,
  `CATEGORY_ID` int(11) DEFAULT NULL,
  `PRODUCT_ACTIVE` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`PRODUCT_ID`, `PRODUCT_SLUG`, `PRODUCT_NAME`, `PRODUCT_DESCRIPTION`, `PRODUCT_PRICE`, `PRODUCT_IMG_PATH`, `CATEGORY_ID`, `PRODUCT_ACTIVE`) VALUES
(1, 'Green Wool', 'Super Chunky Green Wool', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas at tortor vel ante egestas congue vel non erat. In mollis pulvinar lacus. Duis eu orci mi. Mauris rutrum elit sed sagittis malesuada. Vestibulum porttitor arcu odio, eget cursus nibh mattis sed. Proin sodales massa in malesuada tincidunt. Sed vel magna id turpis bibendum vehicula sed sed nisi. Suspendisse ut nulla cursus, fringilla nisl eget, imperdiet erat. Pellentesque sed aliquam tellus. Curabitur tincidunt lacus tellus.\n\nSed ultrices vehicula augue et fringilla. Curabitur varius nisi sed sodales ullamcorper. In leo eros, lobortis quis ipsum et, tempor aliquam tortor. Vivamus facilisis nulla convallis neque consectetur, eget rutrum orci hendrerit. Morbi lacinia eleifend cursus. Cras sit amet leo sem. Nullam quis augue vitae metus iaculis tempus. Nullam ullamcorper lacus id mauris condimentum, et lobortis quam suscipit. Aliquam convallis, leo a ultricies vestibulum, risus nisi ornare tortor, nec vulputate elit turpis non nibh. Nunc sed tristique lorem. Mauris ut congue neque. Pellentesque ac tellus id enim auctor congue. Ut magna arcu, sollicitudin a neque sit amet, dictum imperdiet lorem.', '1.99', 'https://media.istockphoto.com/id/918294950/photo/clew-of-green-thread-for-knitting-isolated-on-white-background.jpg?b=1&s=170667a&w=0&k=20&c=V8rU9H67ebDB3Cs1d4ShLkRaZ7apUaoip8RjkSH3cBs=', 1, 1),
(2, 'Blue Wool', 'Super Chunky Blue Wool', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas at tortor vel ante egestas congue vel non erat. In mollis pulvinar lacus. Duis eu orci mi. Mauris rutrum elit sed sagittis malesuada. Vestibulum porttitor arcu odio, eget cursus nibh mattis sed. Proin sodales massa in malesuada tincidunt. Sed vel magna id turpis bibendum vehicula sed sed nisi. Suspendisse ut nulla cursus, fringilla nisl eget, imperdiet erat. Pellentesque sed aliquam tellus. Curabitur tincidunt lacus tellus.\n\nSed ultrices vehicula augue et fringilla. Curabitur varius nisi sed sodales ullamcorper. In leo eros, lobortis quis ipsum et, tempor aliquam tortor. Vivamus facilisis nulla convallis neque consectetur, eget rutrum orci hendrerit. Morbi lacinia eleifend cursus. Cras sit amet leo sem. Nullam quis augue vitae metus iaculis tempus. Nullam ullamcorper lacus id mauris condimentum, et lobortis quam suscipit. Aliquam convallis, leo a ultricies vestibulum, risus nisi ornare tortor, nec vulputate elit turpis non nibh. Nunc sed tristique lorem. Mauris ut congue neque. Pellentesque ac tellus id enim auctor congue. Ut magna arcu, sollicitudin a neque sit amet, dictum imperdiet lorem.', '2.99', 'https://www.hibiscus-plc.co.uk/wp-content/uploads/2017/01/blue-wool-scale-2.jpg', 1, 1),
(3, 'Yellow Wool', 'Super Chunky Yellow Wool', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas at tortor vel ante egestas congue vel non erat. In mollis pulvinar lacus. Duis eu orci mi. Mauris rutrum elit sed sagittis malesuada. Vestibulum porttitor arcu odio, eget cursus nibh mattis sed. Proin sodales massa in malesuada tincidunt. Sed vel magna id turpis bibendum vehicula sed sed nisi. Suspendisse ut nulla cursus, fringilla nisl eget, imperdiet erat. Pellentesque sed aliquam tellus. Curabitur tincidunt lacus tellus.\n\nSed ultrices vehicula augue et fringilla. Curabitur varius nisi sed sodales ullamcorper. In leo eros, lobortis quis ipsum et, tempor aliquam tortor. Vivamus facilisis nulla convallis neque consectetur, eget rutrum orci hendrerit. Morbi lacinia eleifend cursus. Cras sit amet leo sem. Nullam quis augue vitae metus iaculis tempus. Nullam ullamcorper lacus id mauris condimentum, et lobortis quam suscipit. Aliquam convallis, leo a ultricies vestibulum, risus nisi ornare tortor, nec vulputate elit turpis non nibh. Nunc sed tristique lorem. Mauris ut congue neque. Pellentesque ac tellus id enim auctor congue. Ut magna arcu, sollicitudin a neque sit amet, dictum imperdiet lorem.', '0.99', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQExfU05wJ5bgvDbWx81J1fhvjHEs5SHm-ffnRR84L2U4RpeQCWvp8RGw9ggk0ZyRiv98c:https://www.woolwarehouse.co.uk/media/catalog/product/cache/1/image/330x220/9df78eab33525d08d6e5fb8d27136e95/r/h/rh_9809670_08217_0.jpg&usqp=CAU', 1, 1),
(4, 'Knitting needles', '9mm Bamboo Knitting needles', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas at tortor vel ante egestas congue vel non erat. In mollis pulvinar lacus. Duis eu orci mi. Mauris rutrum elit sed sagittis malesuada. Vestibulum porttitor arcu odio, eget cursus nibh mattis sed. Proin sodales massa in malesuada tincidunt. Sed vel magna id turpis bibendum vehicula sed sed nisi. Suspendisse ut nulla cursus, fringilla nisl eget, imperdiet erat. Pellentesque sed aliquam tellus. Curabitur tincidunt lacus tellus.\n\nSed ultrices vehicula augue et fringilla. Curabitur varius nisi sed sodales ullamcorper. In leo eros, lobortis quis ipsum et, tempor aliquam tortor. Vivamus facilisis nulla convallis neque consectetur, eget rutrum orci hendrerit. Morbi lacinia eleifend cursus. Cras sit amet leo sem. Nullam quis augue vitae metus iaculis tempus. Nullam ullamcorper lacus id mauris condimentum, et lobortis quam suscipit. Aliquam convallis, leo a ultricies vestibulum, risus nisi ornare tortor, nec vulputate elit turpis non nibh. Nunc sed tristique lorem. Mauris ut congue neque. Pellentesque ac tellus id enim auctor congue. Ut magna arcu, sollicitudin a neque sit amet, dictum imperdiet lorem.', '4.99', 'https://images.unsplash.com/photo-1513891270183-1df0366c9f22?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80', 3, 1),
(5, 'Ryan', 'RYan Gosling Outer wool coat', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas at tortor vel ante egestas congue vel non erat. In mollis pulvinar lacus. Duis eu orci mi. Mauris rutrum elit sed sagittis malesuada. Vestibulum porttitor arcu odio, eget cursus nibh mattis sed. Proin sodales massa in malesuada tincidunt. Sed vel magna id turpis bibendum vehicula sed sed nisi. Suspendisse ut nulla cursus, fringilla nisl eget, imperdiet erat. Pellentesque sed aliquam tellus. Curabitur tincidunt lacus tellus.\n\nSed ultrices vehicula augue et fringilla. Curabitur varius nisi sed sodales ullamcorper. In leo eros, lobortis quis ipsum et, tempor aliquam tortor. Vivamus facilisis nulla convallis neque consectetur, eget rutrum orci hendrerit. Morbi lacinia eleifend cursus. Cras sit amet leo sem. Nullam quis augue vitae metus iaculis tempus. Nullam ullamcorper lacus id mauris condimentum, et lobortis quam suscipit. Aliquam convallis, leo a ultricies vestibulum, risus nisi ornare tortor, nec vulputate elit turpis non nibh. Nunc sed tristique lorem. Mauris ut congue neque. Pellentesque ac tellus id enim auctor congue. Ut magna arcu, sollicitudin a neque sit amet, dictum imperdiet lorem.', '10.00', '/images/Ryan+Gosling+Outerwear+Wool+Coat+afLg0lv520hl.jpg', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_tag`
--

CREATE TABLE `product_tag` (
  `PT_ID` int(11) NOT NULL,
  `PRODUCT_ID` int(11) NOT NULL,
  `TAG_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_tag`
--

INSERT INTO `product_tag` (`PT_ID`, `PRODUCT_ID`, `TAG_ID`) VALUES
(5, 1, 3),
(6, 2, 2),
(8, 5, 4),
(9, 4, 3),
(10, 4, 4),
(11, 3, 1),
(12, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `REVIEW_ID` int(11) NOT NULL,
  `REVIEW_NAME` varchar(50) NOT NULL,
  `REVIEW_DESCRIPTION` varchar(2000) NOT NULL,
  `REVIEW_SCORE` tinyint(4) NOT NULL,
  `REVIEW_CREATED` datetime DEFAULT NULL,
  `REVIEW_ACTIVE` tinyint(1) DEFAULT NULL,
  `PRODUCT_ID` int(11) NOT NULL,
  `ACCOUNT_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`REVIEW_ID`, `REVIEW_NAME`, `REVIEW_DESCRIPTION`, `REVIEW_SCORE`, `REVIEW_CREATED`, `REVIEW_ACTIVE`, `PRODUCT_ID`, `ACCOUNT_ID`) VALUES
(1, 'dasdafsf', 'asfasfas', 4, '2023-04-18 13:00:30', 1, 4, 1),
(2, 'czxcvadsc', 'ascasczxc', 3, '2023-04-18 13:32:54', 1, 5, 1),
(3, 'dsasd', 'dasdasd', 3, '2023-04-18 13:33:52', 1, 5, 2),
(4, 'wow', 'wowow', 10, '2023-04-18 13:36:36', 1, 5, 1),
(5, 'Review', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas at tortor vel ante egestas congue vel non erat. In mollis pulvinar lacus. Duis eu orci mi. Mauris rutrum elit sed sagittis malesuada. Vestibulum porttitor arcu odio, eget cursus nibh mattis sed. Proin sodales massa in malesuada tincidunt. Sed vel magna id turpis bibendum vehicula sed sed nisi. Suspendisse ut nulla cursus, fringilla nisl eget, imperdiet erat. Pellentesque sed aliquam tellus. Curabitur tincidunt lacus tellus.\n\nSed ultrices vehicula augue et fringilla. Curabitur varius nisi sed sodales ullamcorper. In leo eros, lobortis quis ipsum et, tempor aliquam tortor. Vivamus facilisis nulla convallis neque consectetur, eget rutrum orci hendrerit. Morbi lacinia eleifend cursus. Cras sit amet leo sem. Nullam quis augue vitae metus iaculis tempus. Nullam ullamcorper lacus id mauris condimentum, et lobortis quam suscipit. Aliquam convallis, leo a ultricies vestibulum, risus nisi ornare tortor, nec vulputate elit turpis non nibh. Nunc sed tristique lorem. Mauris ut congue neque. Pellentesque ac tellus id enim auctor congue. Ut magna arcu, sollicitudin a neque sit amet, dictum imperdiet lorem.', 8, '2023-04-18 13:38:37', 1, 3, 1),
(6, 'small', 'too small in my opinion. i prefer average knitting needles', 4, '2023-04-18 13:57:29', 0, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `SALE_ID` int(11) NOT NULL,
  `SALE_CREATED` datetime DEFAULT NULL,
  `SALE_PROCESSED` datetime DEFAULT NULL,
  `SALE_DISPATCHED` datetime DEFAULT NULL,
  `SALE_ESTIMATED_ARRIVAL` datetime DEFAULT NULL,
  `SALE_STATUS` varchar(10) DEFAULT NULL,
  `ACCOUNT_ID` int(11) NOT NULL,
  `ADDRESS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`SALE_ID`, `SALE_CREATED`, `SALE_PROCESSED`, `SALE_DISPATCHED`, `SALE_ESTIMATED_ARRIVAL`, `SALE_STATUS`, `ACCOUNT_ID`, `ADDRESS_ID`) VALUES
(1, NULL, NULL, NULL, NULL, 'created', 2, 2),
(2, '2023-04-18 13:07:08', NULL, NULL, NULL, 'created', 1, 1),
(3, '2023-04-18 13:07:27', NULL, NULL, NULL, 'created', 1, 1),
(4, '2023-04-18 13:07:58', NULL, NULL, NULL, 'created', 1, 1),
(5, '2023-04-18 13:21:33', NULL, NULL, NULL, 'created', 2, 3),
(6, '2023-04-18 13:55:29', NULL, NULL, NULL, 'created', 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `sale_row`
--

CREATE TABLE `sale_row` (
  `SR_ID` int(11) NOT NULL,
  `SR_ORIG_PRICE` decimal(10,2) NOT NULL,
  `SR_FINAL_PRICE` decimal(10,2) NOT NULL,
  `SR_QUANTITY` int(11) NOT NULL,
  `SALE_ID` int(11) NOT NULL,
  `PRODUCT_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_row`
--

INSERT INTO `sale_row` (`SR_ID`, `SR_ORIG_PRICE`, `SR_FINAL_PRICE`, `SR_QUANTITY`, `SALE_ID`, `PRODUCT_ID`) VALUES
(1, '1.99', '1.99', 3, 1, 1),
(2, '2.99', '2.99', 1, 1, 2),
(3, '4.99', '4.99', 3, 2, 4),
(4, '2.99', '2.99', 3, 2, 2),
(5, '0.99', '0.99', 3, 3, 3),
(6, '4.99', '4.99', 6, 4, 4),
(7, '0.99', '0.99', 3, 5, 3),
(8, '10.00', '10.00', 3, 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `TAG_ID` int(11) NOT NULL,
  `TAG_NAME` varchar(50) NOT NULL,
  `TAG_DESCRIPTION` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`TAG_ID`, `TAG_NAME`, `TAG_DESCRIPTION`) VALUES
(1, 'Yellow', 'An Item which is the colour yellow.'),
(2, 'Blue', 'An Item which is the colour blue.'),
(3, 'Green', 'An Item which is the colour green'),
(4, 'Featured', 'Featured items for the carousel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`ACCOUNT_ID`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`ADDRESS_ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CATEGORY_ID`),
  ADD KEY `FK_CATEGORY_PARENT` (`PARENT_ID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`MESSAGE_ID`),
  ADD KEY `FK_MESSAGE_ACCOUNT` (`ACCOUNT_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`PRODUCT_ID`),
  ADD KEY `FK_PRODUCT_CATEGORY` (`CATEGORY_ID`);

--
-- Indexes for table `product_tag`
--
ALTER TABLE `product_tag`
  ADD PRIMARY KEY (`PT_ID`),
  ADD KEY `FK_PT_PRODUCT` (`PRODUCT_ID`),
  ADD KEY `FK_PT_TAG` (`TAG_ID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`REVIEW_ID`),
  ADD KEY `FK_REVIEW_PRODUCT` (`PRODUCT_ID`),
  ADD KEY `FK_REVIEW_ACCOUNT` (`ACCOUNT_ID`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`SALE_ID`),
  ADD KEY `FK_SALE_ACCOUNT` (`ACCOUNT_ID`),
  ADD KEY `FK_SALE_ADDRESS` (`ADDRESS_ID`);

--
-- Indexes for table `sale_row`
--
ALTER TABLE `sale_row`
  ADD PRIMARY KEY (`SR_ID`),
  ADD KEY `FK_SR_SALE` (`SALE_ID`),
  ADD KEY `FK_SR_PRODUCT` (`PRODUCT_ID`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`TAG_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `ACCOUNT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `ADDRESS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `MESSAGE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `PRODUCT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_tag`
--
ALTER TABLE `product_tag`
  MODIFY `PT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `REVIEW_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `SALE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sale_row`
--
ALTER TABLE `sale_row`
  MODIFY `SR_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `TAG_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `FK_CATEGORY_PARENT` FOREIGN KEY (`PARENT_ID`) REFERENCES `category` (`CATEGORY_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_MESSAGE_ACCOUNT` FOREIGN KEY (`ACCOUNT_ID`) REFERENCES `account` (`ACCOUNT_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_PRODUCT_CATEGORY` FOREIGN KEY (`CATEGORY_ID`) REFERENCES `category` (`CATEGORY_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_tag`
--
ALTER TABLE `product_tag`
  ADD CONSTRAINT `FK_PT_PRODUCT` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product` (`PRODUCT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PT_TAG` FOREIGN KEY (`TAG_ID`) REFERENCES `tag` (`TAG_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `FK_REVIEW_ACCOUNT` FOREIGN KEY (`ACCOUNT_ID`) REFERENCES `account` (`ACCOUNT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_REVIEW_PRODUCT` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product` (`PRODUCT_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `FK_SALE_ACCOUNT` FOREIGN KEY (`ACCOUNT_ID`) REFERENCES `account` (`ACCOUNT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SALE_ADDRESS` FOREIGN KEY (`ADDRESS_ID`) REFERENCES `address` (`ADDRESS_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_row`
--
ALTER TABLE `sale_row`
  ADD CONSTRAINT `FK_SR_PRODUCT` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product` (`PRODUCT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SR_SALE` FOREIGN KEY (`SALE_ID`) REFERENCES `sale` (`SALE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
