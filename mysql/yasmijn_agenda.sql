-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2023 at 07:48 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yasmijn_agenda`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda_appointment`
--

CREATE TABLE `agenda_appointment` (
  `uuid` char(36) COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `agenda_appointment`
--

INSERT INTO `agenda_appointment` (`uuid`, `date`) VALUES
('7318aa05-debb-11ed-b707-549f351d7550', '2023-04-21'),
('c8ac8cdc-74c5-45fa-bcd0-dec2b55b818f', '2023-04-22');

-- --------------------------------------------------------

--
-- Table structure for table `agenda_dates`
--

CREATE TABLE `agenda_dates` (
  `agendaUuid` char(63) COLLATE utf8_bin NOT NULL,
  `dateUuid` char(36) COLLATE utf8_bin NOT NULL,
  `userUuid` char(63) COLLATE utf8_bin NOT NULL,
  `time` time NOT NULL,
  `message` longtext COLLATE utf8_bin NOT NULL,
  `subject` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `agenda_dates`
--

INSERT INTO `agenda_dates` (`agendaUuid`, `dateUuid`, `userUuid`, `time`, `message`, `subject`) VALUES
('29364b83-9131-4f1f-a4bb-448312054284', '7318aa05-debb-11ed-b707-549f351d7550', 'd29a20b6-3a27-4b12-a35a-09b958308eb6', '05:00:00', '<p>? weeken is begonnen</p>', 'Weekend'),
('7701e5ba-7465-41d9-86fd-b6473290a102', '7318aa05-debb-11ed-b707-549f351d7550', 'd29a20b6-3a27-4b12-a35a-09b958308eb6', '08:00:00', '<p>werk dag is is begonnen&nbsp;</p>', 'werken'),
('c148ee3b-b313-43f4-9d81-8d58502ce529', 'c8ac8cdc-74c5-45fa-bcd0-dec2b55b818f', 'd29a20b6-3a27-4b12-a35a-09b958308eb6', '07:01:00', '<p>test</p>', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uuid` char(36) COLLATE utf8_bin NOT NULL,
  `username` varchar(128) COLLATE utf8_bin NOT NULL,
  `password` varchar(256) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uuid`, `username`, `password`) VALUES
('d29a20b6-3a27-4b12-a35a-09b958308eb6', 'admin', '$2y$12$3B7tBuvKfViX4IPkROxQA.QI4jVK0P.tuNoHveZe0u5HHlOhQ3FCS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda_appointment`
--
ALTER TABLE `agenda_appointment`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `agenda_dates`
--
ALTER TABLE `agenda_dates`
  ADD PRIMARY KEY (`agendaUuid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uuid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
