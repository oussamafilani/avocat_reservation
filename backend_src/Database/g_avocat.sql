-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2021 at 03:03 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `g_avocat`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id_appointment` int(11) NOT NULL,
  `date` date NOT NULL,
  `sujet` text COLLATE utf8_bin NOT NULL,
  `id_creneaux` int(11) NOT NULL,
  `id_client` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id_appointment`, `date`, `sujet`, `id_creneaux`, `id_client`) VALUES
(1, '2021-06-16', ' lorem  lorem  lorem  lorem  lorem  lorem  lorem  lorem  lorem  lorem  lorem  lorem  lorem  lorem ', 2, 1),
(2, '2021-06-15', ' lorem  lorem  lorem  lorem  lorem  lorem  lorem  lorem  lorem  lorem  lorem  lorem ', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `nom_client` varchar(25) COLLATE utf8_bin NOT NULL,
  `prenom_client` varchar(25) COLLATE utf8_bin NOT NULL,
  `profession` varchar(25) COLLATE utf8_bin NOT NULL,
  `age_client` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `cin` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id_client`, `nom_client`, `prenom_client`, `profession`, `age_client`, `id_user`, `cin`) VALUES
(1, 'hassan', 'hassan', 'prof', 33, 1, 'HH32346'),
(2, 'Ali', 'Ali', 'actor', 43, 2, 'HH12343'),
(3, 'SALHI', 'SALHI', 'developer', 44, 3, 'HH47578'),
(4, 'ilyas', 'ilyas', 'ceo', 44, 4, 'HH48573');

-- --------------------------------------------------------

--
-- Table structure for table `creneaux`
--

CREATE TABLE `creneaux` (
  `id_creneaux` int(11) NOT NULL,
  `d_hour` time NOT NULL,
  `f_hour` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `creneaux`
--

INSERT INTO `creneaux` (`id_creneaux`, `d_hour`, `f_hour`) VALUES
(1, '10:00:00', '10:30:00'),
(2, '11:00:00', '11:30:00'),
(3, '14:00:00', '14:30:00'),
(4, '15:00:00', '15:30:00'),
(5, '16:00:00', '16:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `token` char(60) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `token`) VALUES
(4, '$2y$10$7bkpeo2ICCNRtAwqxhKgK.szCJTHJHphkXRNx3lOCeUUNoU0jx0QW'),
(1, '$2y$10$NofyYwYDj424JLy7tzNVWudzcH0QAL6RG4aOg/JI41sdcRpEA2a72'),
(2, '$2y$10$ucWh6NMCVfwjJWeOLDVxjOt4JyZNelSdt5uvsljxQl9ryp4uKbXpa'),
(3, '$2y$10$xZsOx18h2AZp2P8xLzSMoOBfJxGGNhjcEHacMVvwXAJyqHn313CES');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id_appointment`),
  ADD KEY `FK_client` (`id_client`),
  ADD KEY `FK_creneaux` (`id_creneaux`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`),
  ADD UNIQUE KEY `cin` (`cin`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `creneaux`
--
ALTER TABLE `creneaux`
  ADD PRIMARY KEY (`id_creneaux`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `token` (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id_appointment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `creneaux`
--
ALTER TABLE `creneaux`
  MODIFY `id_creneaux` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `FK_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `FK_creneaux` FOREIGN KEY (`id_creneaux`) REFERENCES `creneaux` (`id_creneaux`);

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
