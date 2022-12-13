-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 08, 2018 at 08:46 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vending_machine`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_days`
--

CREATE TABLE `active_days` (
  `machine_id` INT(11) NOT NULL,
  `day_id`     INT(11) NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cells`
--

CREATE TABLE `cells` (
  `cell_id`            INT(11) NOT NULL,
  `vending_machine_id` INT(11) NOT NULL,
  `cell_row`           INT(11) NOT NULL,
  `cell_column`        INT(11) NOT NULL,
  `combined_cell`      INT(11) NOT NULL,
  `cell_date_created`  DATE    NOT NULL,
  `cell_date_updated`  DATE    NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `day_id` INT(11)                    NOT NULL,
  `days`   VARCHAR(15)
           COLLATE utf8mb4_unicode_ci NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`day_id`, `days`) VALUES
  (1, 'Monday'),
  (2, 'Tuesday'),
  (3, 'Wednesday'),
  (4, 'Thursday'),
  (5, 'Friday'),
  (6, 'Saturday'),
  (7, 'Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id`           INT(11)   NOT NULL,
  `product_type_id`      INT(11)   NOT NULL,
  `product_price`        FLOAT     NOT NULL,
  `product_expire_date`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `product_size`         INT(11)   NOT NULL,
  `cell_id`              INT(11)   NOT NULL,
  `product_date_created` DATETIME  NOT NULL,
  `product_date_updated` DATETIME  NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `product_type_id`   INT(11)                    NOT NULL,
  `product_type_name` VARCHAR(50)
                      COLLATE utf8mb4_unicode_ci NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`product_type_id`, `product_type_name`) VALUES
  (1, 'Cola'),
  (2, 'Chips'),
  (3, 'Snikers');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` INT(11)                    NOT NULL,
  `status`    VARCHAR(15)
              COLLATE utf8mb4_unicode_ci NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status`) VALUES
  (1, 'Active'),
  (2, 'Inactive'),
  (3, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `vending_machines`
--

CREATE TABLE `vending_machines` (
  `vending_machine_id`           INT(11)                    NOT NULL,
  `vending_machine_rows`         INT(11)                    NOT NULL,
  `vending_machine_columns`      INT(11)                    NOT NULL,
  `vending_machine_size`         INT(11)                    NOT NULL,
  `vending_machine_date_created` DATETIME                   NOT NULL,
  `vending_machine_date_updated` DATETIME                   NOT NULL,
  `vending_machine_status_id`    INT(11)                    NOT NULL,
  `vending_machine_desc`         VARCHAR(200)
                                 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vending_machine_name`         VARCHAR(50)
                                 COLLATE utf8mb4_unicode_ci NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cells`
--
ALTER TABLE `cells`
  ADD PRIMARY KEY (`cell_id`),
  ADD KEY `vending_machine_id` (`vending_machine_id`);

--
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`day_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_type` (`product_type_id`),
  ADD KEY `cell_id` (`cell_id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`product_type_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `vending_machines`
--
ALTER TABLE `vending_machines`
  ADD PRIMARY KEY (`vending_machine_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cells`
--
ALTER TABLE `cells`
  MODIFY `cell_id` INT(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `day_id` INT(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` INT(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `product_type_id` INT(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` INT(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `vending_machines`
--
ALTER TABLE `vending_machines`
  MODIFY `vending_machine_id` INT(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cells`
--
ALTER TABLE `cells`
  ADD CONSTRAINT `cells_ibfk_1` FOREIGN KEY (`vending_machine_id`) REFERENCES `vending_machines` (`vending_machine_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_type_id`) REFERENCES `product_types` (`product_type_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`cell_id`) REFERENCES `cells` (`cell_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
