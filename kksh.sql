-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2022 at 12:07 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

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

-- --------------------------------------------------------

--
-- Table structure for table `klasa`
--

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
(43, 52, 12, 'n3FzGzLH'),
(44, 52, 13, 'n3FzGzLE'),
(45, 52, 12, 'n3FzGzLF'),
(46, 52, 12, 'n3FzGzLC'),
(49, 52, 12, 'n3FzGzLD');

-- --------------------------------------------------------

--
-- Table structure for table `kursantet`
--

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
  `BankPayment` varchar(200) NOT NULL,
  `IdKursi` int(11) DEFAULT NULL,
  `DataRregjistrimit` date DEFAULT NULL,
  `Gjinia` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `organizimkursantesh1`
--

CREATE TABLE `organizimkursantesh1` (
  `ID` int(11) NOT NULL,
  `idkursi` int(11) NOT NULL,
  `idkursanti` varchar(100) NOT NULL,
  `statusi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



--
-- Table structure for table `programijavor`
--

CREATE TABLE `programijavor` (
  `idkursi` int(11) NOT NULL,
  `idklase` int(11) NOT NULL,
  `idinstruktori` varchar(100) NOT NULL,
  `orari` varchar(25) DEFAULT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `qyteti`
--

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
('nCsnXGC0n9gwdxE=', 'h3x7DA==', 'lmhhADo=', 'h39nGzvv', 'gHhhHGK0n98=', 'l3J8Djr0wZ5mNw==', 'gHRgCT1FBw==', 685747367, 1),
('nCUlUWu2ldM0Fg==', 'l297GyfvzYU=', 'l2hgCTI=', 'l35nGjI=', 'gHhhHGK0n98=', 'lXl/AT3iyYxm', 'gHRgCT1FBw==', 688787987, 2),
('niUjWmOznN8xFg==', 'hnh2ATLo', 'nHJqADI=', 'pnV9EDvn', 'gHhhHGK0n98=', 'lXl/AT0=', 'gHRgCT1FBw==', 685308860, 3),
('nCoqXmSwm902AQ==', 'lXN2AQ==', 'mWh4Bz/qzZlq', 'tXBnAjw=', 'gHhhHGK0n98=', 'nXNiHSfj3g==', 'gHRgCT1FBw==', 684737284, 4),
('nC4mXWWxmt43Fg==', 'mXhgASfn', 'h3VzHDI=', 'mXV9EDvn', 'gHhhHGK0n98=', 'nXNhHCHzx59sNg==', 'gHRgCT1FBw==', 675645634, 8),
('nyUrUGSwm902Cw==', 'kGhgGiDvnQ==', 'kGhgGiDvjIZhLSa0ZwQ=', 'sGhgGiDv', 'gHhhHGK0n98=', 'nXNhHCHzx59sNg==', 'gHRgCT1FBw==', 698787987, 9);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `kursantet`
--
ALTER TABLE `kursantet`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `organizimkursantesh1`
--
ALTER TABLE `organizimkursantesh1`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `programijavor`
--
ALTER TABLE `programijavor`
  MODIFY `idkursi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `qyteti`
--
ALTER TABLE `qyteti`
  MODIFY `IDQyteti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `staf`
--
ALTER TABLE `staf`
  MODIFY `UniqueId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
