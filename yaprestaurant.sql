-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 11:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yaprestaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `no_ic` varchar(12) NOT NULL,
  `first_name` varchar(12) DEFAULT NULL,
  `last_name` varchar(12) DEFAULT NULL,
  `hp_no` varchar(20) DEFAULT NULL,
  `guest_count` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`no_ic`, `first_name`, `last_name`, `hp_no`, `guest_count`) VALUES
('060812100360', 'Ivy', 'Tan', '0168122316', '3'),
('111111111111', 'Justin', 'Tan', '0131111111', '4'),
('123456789012', 'John ', 'Doe', '0123456789', '2'),
('222222222222', 'Yen', 'Yuee', '0142222222', '6'),
('987654321098', 'Jane ', 'Smith', '0119876543', '1');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `no_ic` varchar(12) NOT NULL,
  `table_id` varchar(20) NOT NULL,
  `date_of_reservation` date NOT NULL,
  `time_of_reservation` time NOT NULL,
  `guest_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`no_ic`, `table_id`, `date_of_reservation`, `time_of_reservation`, `guest_count`) VALUES
('111111111111', '014', '2024-11-30', '01:00:00', 4),
('123456789012', '007', '2024-11-27', '07:00:00', 2),
('222222222222', '019', '2024-11-30', '07:00:00', 6),
('987654321098', '008', '2024-12-07', '09:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `yap_table`
--

CREATE TABLE `yap_table` (
  `table_id` varchar(6) NOT NULL,
  `table_capacity` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `yap_table`
--

INSERT INTO `yap_table` (`table_id`, `table_capacity`) VALUES
('001', '2'),
('002', '2'),
('003', '2'),
('004', '2'),
('005', '2'),
('006', '2'),
('007', '2'),
('008', '2'),
('009', '4'),
('010', '4'),
('011', '4'),
('012', '4'),
('013', '4'),
('014', '4'),
('015', '5'),
('016', '5'),
('017', '5'),
('018', '6'),
('019', '6'),
('020', '6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`no_ic`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`no_ic`,`table_id`,`date_of_reservation`,`time_of_reservation`),
  ADD KEY `table_id` (`table_id`);

--
-- Indexes for table `yap_table`
--
ALTER TABLE `yap_table`
  ADD PRIMARY KEY (`table_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`no_ic`) REFERENCES `customer` (`no_ic`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`table_id`) REFERENCES `yap_table` (`table_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
