-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2022 at 10:32 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kksh`
--
CREATE DATABASE IF NOT EXISTS `kksh` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `kksh`;

-- --------------------------------------------------------

--
-- Table structure for table `klasa`
--

DROP TABLE IF EXISTS `klasa`;
CREATE TABLE `klasa` (
  `ID` int(11) NOT NULL,
  `Qyteti` int(11) NOT NULL,
  `Kapaciteti` int(11) NOT NULL,
  `Emri` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `klasa`
--

INSERT INTO `klasa` (`ID`, `Qyteti`, `Kapaciteti`, `Emri`) VALUES
(43, 52, 10, 'n3FzGzLH'),
(44, 52, 10, 'n3FzGzLE'),
(45, 52, 10, 'n3FzGzLF'),
(46, 52, 10, 'n3FzGzLC');

-- --------------------------------------------------------

--
-- Table structure for table `kursantet`
--

DROP TABLE IF EXISTS `kursantet`;
CREATE TABLE `kursantet` (
  `PersonalId` varchar(100) NOT NULL,
  `Emri` varchar(250) NOT NULL,
  `Mbiemri` varchar(250) NOT NULL,
  `Atesia` varchar(250) NOT NULL,
  `Datelindja` date NOT NULL,
  `Vendbanimi` varchar(300) NOT NULL,
  `Amza` varchar(150) NOT NULL,
  `Datakursit` date NOT NULL,
  `Telefoni` int(10) NOT NULL,
  `Dega` varchar(200) NOT NULL,
  `Orari` varchar(15) NOT NULL,
  `NrSerisDeshmis` varchar(250) NOT NULL,
  `Statusi` varchar(10) NOT NULL,
  `ID` int(11) NOT NULL,
  `Email` varchar(300) NOT NULL,
  `BankPayment` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kursantet`
--

INSERT INTO `kursantet` (`PersonalId`, `Emri`, `Mbiemri`, `Atesia`, `Datelindja`, `Vendbanimi`, `Amza`, `Datakursit`, `Telefoni`, `Dega`, `Orari`, `NrSerisDeshmis`, `Statusi`, `ID`, `Email`, `BankPayment`) VALUES
('niUlX2Wwmd9G', 'lXN2AQ==', 'mWh4Bz/qzZlq', 'k2hgAQ==', '1998-12-12', 'h3V5Bynj', '5CQ/UWuxgdM0', '2022-03-09', 685746356, '52', '9:00 - 13:00', '4SslUGq2ldM0', 'perfunduar', 29, 'uV15AyDugoRxI224eQ==', '098767567'),
('niUlUWu+m9w1Fg==', 'hnh2ATLnzYpi', 'nHJqADI=', 'nHw=', '1998-10-13', 'gHRgCT3j', '5CQ/WGq2gds6', '2022-03-09', 685398980, '52', '9:00 - 13:00', '5CQiUWO/', 'perfunduar', 30, '', ''),
('niUrUGq+ldM6Fg==', 'gHhhHA==', 'gHhhHA==', 'gHhhHA==', '1212-12-12', 'gHRgCT3j', '', '2022-03-09', 685958598, '52', '9:00 - 13:00', '', 'pabere', 34, '', ''),
('4CgkX2s=', 's2t6Cjno', 'smt1Cjvo', 'snp6Ag==', '1212-12-12', 't3pkSDHu', '', '2022-03-09', 4567, '52', '9:00 - 13:00', '', 'pabere', 38, '', ''),
('vHd5AjvhyoNp', 'snp6DzXiy4M=', 'vHd4ADTgy4NpLiu+cw==', 'snp6Ajvhyow=', '1111-12-19', 's3V4Bj6q', '', '2022-03-12', 5678, '52', '9:00 - 13:00', '', 'pabere', 39, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `organizimkursantesh1`
--

DROP TABLE IF EXISTS `organizimkursantesh1`;
CREATE TABLE `organizimkursantesh1` (
  `ID` int(11) NOT NULL,
  `idkursi` int(11) NOT NULL,
  `idkursanti` varchar(100) NOT NULL,
  `statusi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organizimkursantesh1`
--

INSERT INTO `organizimkursantesh1` (`ID`, `idkursi`, `idkursanti`, `statusi`) VALUES
(29, 48, 'niUlX2Wwmd9G', 'Perfunduar'),
(30, 51, 'niUlUWu+m9w1Fg==', 'Perfunduar'),
(31, 53, 'pmlrHTrp2ZI=', 'pabere'),
(32, 52, 'oCgkX2u/nNI7IQ==', 'pabere'),
(33, 52, 'uyUlUGS+m9M0LQ==', 'pabere'),
(34, 46, 'niUrUGq+ldM6Fg==', 'pabere'),
(35, 0, 'niQrUWq/ldJJ', 'pabere'),
(36, 0, 'snp6Ajg=', 'pabere'),
(37, 47, 'snp6Ajjq', 'pabere'),
(38, 49, '4CgkX2s=', 'pabere'),
(39, 51, 'vHd5AjvhyoNp', 'pabere');

-- --------------------------------------------------------

--
-- Table structure for table `programijavor`
--

DROP TABLE IF EXISTS `programijavor`;
CREATE TABLE `programijavor` (
  `idkursi` int(11) NOT NULL,
  `idklase` int(11) NOT NULL,
  `idinstruktori` varchar(100) NOT NULL,
  `orari` varchar(25) DEFAULT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `programijavor`
--

INSERT INTO `programijavor` (`idkursi`, `idklase`, `idinstruktori`, `orari`, `data`) VALUES
(46, 43, 'nC4mXWWxmt43Fg==', '9:00 - 13:00', '2022-03-09'),
(47, 44, 'nC4mXWWxmt43Fg==', '17:00 -21:00', '2022-03-08'),
(48, 45, 'nC4mXWWxmt43Fg==', '13:00 - 17:00', '2022-03-04'),
(49, 43, 'nC4mXWWxmt43Fg==', '17:00 -21:00', '2022-03-10'),
(50, 47, 'nyUrUGSwm902Cw==', '9:00 - 13:00', '2022-03-09'),
(51, 45, 'nC4mXWWxmt43Fg==', '9:00 - 13:00', '2022-03-12'),
(52, 45, 'nioqX2Wwmd43AQ==', '9:00 - 13:00', '2022-03-09'),
(53, 45, 'nioqX2Wwmd43AQ==', '9:00 - 13:00', '2022-03-11'),
(54, 44, 'nyUrUGSwm902Cw==', '9:00 - 13:00', '2022-03-11');

-- --------------------------------------------------------

--
-- Table structure for table `qyteti`
--

DROP TABLE IF EXISTS `qyteti`;
CREATE TABLE `qyteti` (
  `IDQyteti` int(11) NOT NULL,
  `EmriDeges` varchar(250) NOT NULL,
  `Adresa` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `qyteti`
--

INSERT INTO `qyteti` (`IDQyteti`, `EmriDeges`, `Adresa`) VALUES
(52, 'gHRgCT1FBw==', 'https://goo.gl/maps/2w3bP8tTjHoBSS4V9'),
(53, 'kGhgGpAt3w==', 'https://goo.gl/maps/gkiQTAgi4VievLBW6');

-- --------------------------------------------------------

--
-- Table structure for table `staf`
--

DROP TABLE IF EXISTS `staf`;
CREATE TABLE `staf` (
  `ID` varchar(100) NOT NULL,
  `Emri` varchar(100) NOT NULL,
  `Mbiemri` varchar(100) NOT NULL,
  `Username` varchar(250) NOT NULL,
  `Password` varchar(250) NOT NULL,
  `Roli` varchar(250) NOT NULL,
  `Degakupunon` varchar(250) NOT NULL,
  `Telefoni` int(10) NOT NULL,
  `UniqueId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staf`
--

INSERT INTO `staf` (`ID`, `Emri`, `Mbiemri`, `Username`, `Password`, `Roli`, `Degakupunon`, `Telefoni`, `UniqueId`) VALUES
('nCsnXGC0n982chE=', 'h3x7DA==', 'lmhhADo=', 'h39nGzvv', 'gHhhHGK0n98=', 'l3J8Djr0wZ5mNw==', 'gHRgCT1FBw==', 685747367, 1),
('nCUlUWu2ldM0Fg==', 'l297GyfvzYU=', 'l2hgCTI=', 'l35nGjI=', 'gHhhHGK0n98=', 'lXl/AT3iyYxm', 'gHRgCT1FBw==', 688787987, 2),
('niUjWmOznN8xFg==', 'hnh2ATLo', 'nHJqADI=', 'pnV9EDvn', 'gHhhHGK0n98=', 'lXl/AT0=', 'gHRgCT1FBw==', 685308860, 3),
('nCoqXmSwm902AQ==', 'lXN2AQ==', 'mWh4Bz/qzZlq', 'tXBnAjw=', 'gHhhHGK0n98=', 'nXNiHSfj3g==', 'gHRgCT1FBw==', 684737284, 4),
('nC4mXWWxmt43Fg==', 'mXhgASfn', 'h3VzHDI=', 'mXV9EDvn', 'gHhhHGK0n98=', 'nXNhHCHzx59sNg==', 'gHRgCT1FBw==', 675645634, 8),
('nyUrUGSwm902Cw==', 'kGhgGiDvnQ==', 'kGhgGiDvjIZhLSa0ZwQ=', 'sGhgGiDv', 'gHhhHGK0n98=', 'nXNhHCHzx59sNg==', 'gHRgCT1FBw==', 698787987, 9),
('nioqX2Wwmd43AQ==', 'oHhhHCb1yZk=', 'oHhhHCb1yZk=', 'oGhhDSE=', 'gHhhHGK0n98=', 'l3J8Djr0wZ5mNw==', 'kGhgGpAt3w==', 7654, 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `klasa`
--
ALTER TABLE `klasa`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `kursantet`
--
ALTER TABLE `kursantet`
  ADD PRIMARY KEY (`ID`) USING BTREE;

--
-- Indexes for table `organizimkursantesh1`
--
ALTER TABLE `organizimkursantesh1`
  ADD PRIMARY KEY (`ID`) USING BTREE;

--
-- Indexes for table `programijavor`
--
ALTER TABLE `programijavor`
  ADD PRIMARY KEY (`idkursi`),
  ADD KEY `idklase` (`idklase`),
  ADD KEY `idinstruktori` (`idinstruktori`);

--
-- Indexes for table `qyteti`
--
ALTER TABLE `qyteti`
  ADD PRIMARY KEY (`IDQyteti`);

--
-- Indexes for table `staf`
--
ALTER TABLE `staf`
  ADD PRIMARY KEY (`UniqueId`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `klasa`
--
ALTER TABLE `klasa`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `kursantet`
--
ALTER TABLE `kursantet`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `organizimkursantesh1`
--
ALTER TABLE `organizimkursantesh1`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `programijavor`
--
ALTER TABLE `programijavor`
  MODIFY `idkursi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `qyteti`
--
ALTER TABLE `qyteti`
  MODIFY `IDQyteti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `staf`
--
ALTER TABLE `staf`
  MODIFY `UniqueId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
