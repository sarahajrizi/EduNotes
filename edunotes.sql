-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 08, 2025 at 09:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edunotes`
--

-- --------------------------------------------------------

--
-- Table structure for table `klasat`
--

CREATE TABLE `klasat` (
  `id` int(11) NOT NULL,
  `emri` varchar(15) NOT NULL,
  `paralelja` varchar(10) NOT NULL,
  `mesuesi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klasat`
--

INSERT INTO `klasat` (`id`, `emri`, `paralelja`, `mesuesi_id`) VALUES
(1, 'Klasa e pare', '1', 7),
(3, 'Klasa e dyte', '1', 5),
(4, 'Klasa e dyte', '2', 8),
(5, 'Klasa e trete', '1', 6),
(6, 'Klasa e katert', '1', 2),
(7, 'Klasa e katert', '2', 9),
(8, 'Klasa e peste', '1', 3),
(10, 'Klasa e peste', '2', 4);

-- --------------------------------------------------------

--
-- Table structure for table `komentet`
--

CREATE TABLE `komentet` (
  `id` int(11) NOT NULL,
  `nxenesi_id` int(11) NOT NULL,
  `mesuesi_id` int(11) NOT NULL,
  `lenda_id` int(11) DEFAULT NULL,
  `pershkrimi` text NOT NULL,
  `lloji_komentit` enum('Përgjithshëm','Sipas lëndës') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komentet`
--

INSERT INTO `komentet` (`id`, `nxenesi_id`, `mesuesi_id`, `lenda_id`, `pershkrimi`, `lloji_komentit`) VALUES
(1, 1, 2, NULL, 'Nxënësi ka treguar përkushtim të vazhdueshëm gjatë gjithë periudhës mësimore.', 'Përgjithshëm'),
(2, 2, 9, NULL, 'Tregon interes dhe kuriozitet në lëndë të ndryshme.', 'Përgjithshëm'),
(3, 3, 9, NULL, 'Është shembull për bashkëmoshatarët në sjellje dhe respekt.', 'Përgjithshëm'),
(4, 4, 2, NULL, 'Tregon përgjegjësi dhe vetëdije në përmbushjen e detyrave.', 'Përgjithshëm'),
(5, 5, 2, NULL, 'Po përparon në mënyrë graduale dhe me durim.', 'Përgjithshëm'),
(6, 6, 9, NULL, 'Duhet të përqendrohet më shumë gjatë orëve mësimore.', 'Përgjithshëm'),
(7, 7, 2, NULL, 'Është i përkushtuar dhe dëshmon dëshirë për të mësuar.', 'Përgjithshëm'),
(8, 8, 9, NULL, 'Ka nevojë për më shumë angazhim në detyrat shtëpiake po ashtu duhet të përqendrohet më shumë gjatë orëve mësimore.', 'Përgjithshëm'),
(9, 9, 2, NULL, 'Nxënësi ka treguar përkushtim të vazhdueshëm gjatë gjithë periudhës mësimore.', 'Përgjithshëm'),
(10, 10, 9, NULL, 'Ka aftësi të mira por shpesh mungon përqendrimi.', 'Përgjithshëm'),
(11, 11, 2, NULL, 'Duhet të punojë më shumë', 'Përgjithshëm'),
(12, 12, 9, NULL, 'Është e përkushtuar dhe dëshmon dëshirë për të mësuar.', 'Përgjithshëm'),
(13, 13, 2, NULL, 'Tregon kreativitet dhe mendim kritik në diskutime.', 'Përgjithshëm'),
(14, 14, 9, NULL, 'Tregon interes dhe kuriozitet në lëndë të ndryshme.', 'Përgjithshëm'),
(15, 15, 2, NULL, 'Është shembull për bashkëmoshatarët në sjellje dhe respekt. Ka një qasje shumë pozitive ndaj mësimit.\r\n\r\n', 'Përgjithshëm'),
(16, 16, 9, NULL, 'Ka bërë përpjekje të mira për të përmirësuar veten.', 'Përgjithshëm'),
(17, 17, 2, NULL, 'Ka një sjellje të mirë, por duhet më shumë fokus në mësime.\r\n\r\n', 'Përgjithshëm'),
(18, 18, 9, NULL, 'Duhet të punojë më shumë për të përmirësuar dhe Duhet të përqendrohet më shumë gjatë orëve mësimore.', 'Përgjithshëm'),
(19, 19, 2, NULL, 'Ka nevojë për më shumë vetëbesim në paraqitjet në klasë.', 'Përgjithshëm'),
(20, 20, 9, NULL, 'Po përparon në mënyrë graduale dhe me durim.', 'Përgjithshëm'),
(21, 21, 2, NULL, 'Ka nevojë për më shumë angazhim në detyrat shtëpiake.\r\n\r\n', 'Përgjithshëm'),
(22, 22, 9, NULL, 'Nxënësi ka treguar përkushtim të vazhdueshëm gjatë gjithë periudhës mësimore.\r\n\r\n', 'Përgjithshëm'),
(23, 23, 2, NULL, 'Ka përmirësuar ndjeshëm sjelljen dhe pjesëmarrjen në orë.\r\n\r\n', 'Përgjithshëm'),
(24, 1, 2, 1, 'Punon me kujdes, është i përqendruar dhe e kryen çdo detyrë me sukses.\r\n\r\n', 'Sipas lëndës'),
(25, 1, 2, 2, 'Është ndër nxënësit më të përgatitur në këtë fushë.\r\n\r\n', 'Sipas lëndës'),
(26, 1, 2, 3, 'Është ndër nxënësit më të përgatitur në këtë fushë.\r\n\r\n', 'Sipas lëndës'),
(27, 1, 2, 4, 'Mund të arrijë rezultate edhe më të larta me më shumë përqendrim.\r\n\r\n', 'Sipas lëndës'),
(28, 1, 2, 5, 'Ka nivel të mirë të të kuptuarit, por ka hapësirë për avancim.\r\n\r\n', 'Sipas lëndës'),
(29, 1, 2, 6, 'Tregon aftësi të shkëlqyera në këtë lëndë dhe angazhim të vazhdueshëm.\r\n\r\n', 'Sipas lëndës'),
(30, 1, 2, 7, 'Jep shembull pozitiv me punën, sjelljen dhe rezultatet e tij.', 'Sipas lëndës'),
(31, 1, 2, 8, 'Jep shembull pozitiv me punën, sjelljen dhe rezultatet e ti', 'Sipas lëndës'),
(32, 6, 9, 4, 'Tregon angazhim të pjesshëm dhe ka nevojë për përqendrim më të madh.\r\n\r\n', 'Sipas lëndës'),
(33, 6, 9, NULL, 'Ka bërë përpjekje, por ende ka vështirësi në zbatimin praktik të njohurive.\r\n\r\n', 'Përgjithshëm'),
(34, 8, 9, 4, 'Duhet të punojë më shumë për të përvetësuar konceptet bazë.\r\n\r\n', 'Sipas lëndës'),
(35, 8, 9, 5, 'Pjesëmarrja në klasë është mesatare; sugjerohet më shumë aktivizim.\r\n\r\n', 'Sipas lëndës'),
(36, 8, 9, 8, 'Nevojitet përkushtim më i madh brenda dhe jashtë klasës.\r\n\r\n', 'Sipas lëndës'),
(37, 9, 2, 4, 'Sugjerohet bashkëpunim më i ngushtë me prindërit për përmirësim.\r\n\r\n', 'Sipas lëndës'),
(38, 10, 9, 4, 'Sugjerohet bashkëpunim më i ngushtë me prindërit për përmirësim.\n\n', 'Sipas lëndës'),
(39, 11, 2, 4, 'Nevojitet përkushtim më i madh brenda dhe jashtë klasës.\r\n\r\n', 'Sipas lëndës'),
(40, 16, 9, 4, 'Ka bërë përpjekje, por ende ka vështirësi në zbatimin praktik të njohurive.', 'Sipas lëndës'),
(41, 16, 9, 8, 'Tregon angazhim të pjesshëm dhe ka nevojë për përqendrim më të madh.\r\n\r\n', 'Sipas lëndës'),
(42, 17, 2, 4, 'Nxënësi ka nevojë për ndihmë shtesë dhe mbështetje të vazhdueshme në këtë lëndë.\r\n\r\n', 'Sipas lëndës'),
(43, 17, 2, 5, 'Tregon angazhim të pjesshëm dhe ka nevojë për përqendrim më të madh.\r\n\r\n', 'Sipas lëndës'),
(44, 18, 9, 4, 'Tregon angazhim të pjesshëm dhe ka nevojë për përqendrim më të madh.\r\n\r\n', 'Sipas lëndës'),
(45, 21, 2, 4, 'Nevojitet përkushtim më i madh brenda dhe jashtë klasës.', 'Sipas lëndës'),
(46, 21, 2, 5, 'Duhet të punojë më shumë për të përvetësuar konceptet bazë.', 'Sipas lëndës'),
(47, 21, 2, 8, 'Tregon angazhim të pjesshëm dhe ka nevojë për përqendrim më të madh.', 'Sipas lëndës'),
(52, 23, 2, 1, 'Tregon aftësi të shkëlqyera në këtë lëndë dhe angazhim të vazhdueshëm.', 'Sipas lëndës'),
(54, 4, 2, 2, 'Është ndër nxënësit më të përgatitur në këtë fushë.', 'Sipas lëndës'),
(56, 4, 2, 1, 'Punon me kujdes, është i përqendruar dhe e kryen çdo detyrë me sukses.', 'Sipas lëndës');

-- --------------------------------------------------------

--
-- Table structure for table `lendet`
--

CREATE TABLE `lendet` (
  `id` int(11) NOT NULL,
  `emri` varchar(100) NOT NULL,
  `klasat_aplikuara` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lendet`
--

INSERT INTO `lendet` (`id`, `emri`, `klasat_aplikuara`) VALUES
(1, 'Gjuhë shqipe    ', '1,2,3,4,5'),
(2, 'Edukatë figurative    ', '1,2,3,4,5'),
(3, 'Edukatë muzikore    ', '1,2,3,4,5'),
(4, 'Matematikë   ', '1,2,3,4,5'),
(5, 'Njeriu dhe natyra', '1,2,3,4,5'),
(6, 'Shoqëria dhe mjedisi', '1,2,3,4,5'),
(7, 'Edukatë fizike, sportet dhe shëndeti   ', '1,2,3,4,5'),
(8, 'Shkathtësi për jetë     ', '1,2,3,4,5');

-- --------------------------------------------------------

--
-- Table structure for table `njoftimet`
--

CREATE TABLE `njoftimet` (
  `id` int(11) NOT NULL,
  `titulli` varchar(150) NOT NULL,
  `pershkrimi` text NOT NULL,
  `autori_id` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `njoftimet`
--

INSERT INTO `njoftimet` (`id`, `titulli`, `pershkrimi`, `autori_id`, `data`) VALUES
(1, 'Test në lëndën Gjuhë Shqipe', 'Njoftohen prindërit se fëmijët do kenë test \r\nnesër me datë 03.04.2025 në lëndën “Gjuhë\r\nShqipe”.\r\nJu lutem ti përgadsni për test nga kapitulli 1\r\nderi tek kapitulli i 5 ', 2, '2025-05-08'),
(2, 'Ekskursionit Shkollor', 'Ju njoftojmë se më [06.03.2025], nxënësit\r\ne shkollës do të marrin pjesë në një \r\nekskursion shkollor edukativ, i cili do të \r\norganizohet nga shkolla jonë.\r\nDestinacioni:Parku i Gërmis\r\nKoha e nisjes: ora 09:00 nga oborri i shkollës\r\n', 1, '2025-03-05'),
(3, 'Njoftim për Festë Zyrtare', 'Të nderuar prindër,\r\nJu njoftojmë se me rastin e Ditës së \r\nPavarësisë së Republikës së Kosovës, më 17 \r\nShkurt, nuk do të mbahet mësim në asnjë \r\nklasë të shkollës sonë.\r\nJu urojmë një festë të qetë dhe të \r\ngëzueshme së bashku me familjen tuaj!', 1, '2025-02-16');

-- --------------------------------------------------------

--
-- Table structure for table `notat`
--

CREATE TABLE `notat` (
  `id` int(11) NOT NULL,
  `nxenesi_id` int(11) NOT NULL,
  `lenda_id` int(11) NOT NULL,
  `nota1` float DEFAULT NULL,
  `nota2` float DEFAULT NULL,
  `nota_perfundimtare` float DEFAULT NULL,
  `periudha` enum('Periudha 1','Periudha 2') DEFAULT 'Periudha 1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notat`
--

INSERT INTO `notat` (`id`, `nxenesi_id`, `lenda_id`, `nota1`, `nota2`, `nota_perfundimtare`, `periudha`) VALUES
(1, 1, 1, 5, NULL, NULL, 'Periudha 2'),
(2, 1, 2, 5, NULL, NULL, 'Periudha 2'),
(3, 1, 3, 5, NULL, NULL, 'Periudha 2'),
(4, 1, 4, 4, NULL, NULL, 'Periudha 2'),
(5, 1, 5, 4, NULL, NULL, 'Periudha 2'),
(6, 1, 6, 5, NULL, NULL, 'Periudha 2'),
(7, 1, 7, 5, NULL, NULL, 'Periudha 2'),
(8, 1, 8, 5, NULL, NULL, 'Periudha 2'),
(9, 2, 1, 5, NULL, NULL, 'Periudha 2'),
(10, 2, 2, 5, NULL, NULL, 'Periudha 2'),
(11, 2, 3, 5, NULL, NULL, 'Periudha 2'),
(12, 2, 4, 5, NULL, NULL, 'Periudha 2'),
(13, 2, 5, 5, NULL, NULL, 'Periudha 2'),
(14, 2, 6, 5, NULL, NULL, 'Periudha 2'),
(15, 2, 7, 5, NULL, NULL, 'Periudha 2'),
(16, 2, 8, 5, NULL, NULL, 'Periudha 2'),
(17, 3, 1, 5, NULL, NULL, 'Periudha 2'),
(18, 3, 2, 5, NULL, NULL, 'Periudha 2'),
(19, 3, 3, 5, NULL, NULL, 'Periudha 2'),
(20, 3, 4, 4, NULL, NULL, 'Periudha 2'),
(21, 3, 5, 5, NULL, NULL, 'Periudha 2'),
(22, 3, 6, 5, NULL, NULL, 'Periudha 2'),
(24, 3, 7, 5, NULL, NULL, 'Periudha 2'),
(25, 3, 8, 5, NULL, NULL, 'Periudha 2'),
(26, 4, 1, 5, NULL, NULL, 'Periudha 2'),
(27, 4, 2, 5, NULL, NULL, 'Periudha 2'),
(28, 4, 3, 5, NULL, NULL, 'Periudha 2'),
(29, 4, 4, 5, NULL, NULL, 'Periudha 2'),
(30, 4, 5, 5, NULL, NULL, 'Periudha 2'),
(31, 4, 6, 5, NULL, NULL, 'Periudha 2'),
(32, 4, 7, 5, NULL, NULL, 'Periudha 2'),
(33, 4, 8, 5, NULL, NULL, 'Periudha 2'),
(34, 5, 1, 5, NULL, NULL, 'Periudha 2'),
(35, 5, 2, 5, NULL, NULL, 'Periudha 2'),
(36, 5, 3, 5, NULL, NULL, 'Periudha 2'),
(37, 5, 4, 4, NULL, NULL, 'Periudha 2'),
(38, 5, 5, 4, NULL, NULL, 'Periudha 2'),
(39, 5, 6, 4, NULL, NULL, 'Periudha 2'),
(40, 5, 7, 5, NULL, NULL, 'Periudha 2'),
(41, 5, 8, 4, NULL, NULL, 'Periudha 2'),
(42, 6, 1, 4, NULL, NULL, 'Periudha 2'),
(43, 6, 2, 5, NULL, NULL, 'Periudha 2'),
(44, 6, 3, 5, NULL, NULL, 'Periudha 2'),
(45, 6, 4, 3, NULL, NULL, 'Periudha 2'),
(46, 6, 5, 3, NULL, NULL, 'Periudha 2'),
(47, 6, 6, 4, NULL, NULL, 'Periudha 2'),
(48, 6, 7, 5, NULL, NULL, 'Periudha 2'),
(49, 6, 8, 4, NULL, NULL, 'Periudha 2'),
(50, 7, 1, 5, NULL, NULL, 'Periudha 2'),
(51, 7, 2, 5, NULL, NULL, 'Periudha 2'),
(52, 7, 3, 5, NULL, NULL, 'Periudha 2'),
(53, 7, 4, 4, NULL, NULL, 'Periudha 2'),
(54, 7, 5, 5, NULL, NULL, 'Periudha 2'),
(55, 7, 6, 5, NULL, NULL, 'Periudha 2'),
(56, 7, 7, 5, NULL, NULL, 'Periudha 2'),
(57, 7, 8, 5, NULL, NULL, 'Periudha 2'),
(58, 8, 1, 4, NULL, NULL, 'Periudha 2'),
(59, 8, 2, 5, NULL, NULL, 'Periudha 2'),
(60, 8, 3, 5, NULL, NULL, 'Periudha 2'),
(61, 8, 4, 3, NULL, NULL, 'Periudha 2'),
(62, 8, 5, 3, NULL, NULL, 'Periudha 2'),
(63, 8, 6, 4, NULL, NULL, 'Periudha 2'),
(64, 8, 7, 5, NULL, NULL, 'Periudha 2'),
(65, 8, 8, 3, NULL, NULL, 'Periudha 2'),
(66, 9, 1, 5, NULL, NULL, 'Periudha 2'),
(67, 9, 2, 5, NULL, NULL, 'Periudha 2'),
(68, 9, 3, 5, NULL, NULL, 'Periudha 2'),
(69, 9, 4, 3, NULL, NULL, 'Periudha 2'),
(70, 9, 5, 5, NULL, NULL, 'Periudha 2'),
(71, 9, 6, 5, NULL, NULL, 'Periudha 2'),
(72, 9, 7, 5, NULL, NULL, 'Periudha 2'),
(73, 9, 8, 5, NULL, NULL, 'Periudha 2'),
(74, 10, 1, 5, NULL, NULL, 'Periudha 2'),
(75, 10, 2, 5, NULL, NULL, 'Periudha 2'),
(76, 10, 3, 5, NULL, NULL, 'Periudha 2'),
(77, 10, 4, 4, NULL, NULL, 'Periudha 2'),
(78, 10, 5, 4, NULL, NULL, 'Periudha 2'),
(79, 10, 6, 4, NULL, NULL, 'Periudha 2'),
(80, 11, 1, 4, NULL, NULL, 'Periudha 2'),
(81, 11, 2, 5, NULL, NULL, 'Periudha 2'),
(82, 11, 3, 5, NULL, NULL, 'Periudha 2'),
(83, 11, 4, 3, NULL, NULL, 'Periudha 2'),
(84, 11, 5, 4, NULL, NULL, 'Periudha 2'),
(85, 11, 6, 4, NULL, NULL, 'Periudha 2'),
(86, 11, 7, 5, NULL, NULL, 'Periudha 2'),
(87, 11, 8, 4, NULL, NULL, 'Periudha 2'),
(88, 12, 1, 5, NULL, NULL, 'Periudha 2'),
(89, 12, 2, 5, NULL, NULL, 'Periudha 2'),
(90, 12, 3, 5, NULL, NULL, 'Periudha 2'),
(91, 12, 4, 5, NULL, NULL, 'Periudha 2'),
(92, 12, 5, 5, NULL, NULL, 'Periudha 2'),
(93, 12, 6, 5, NULL, NULL, 'Periudha 2'),
(94, 12, 7, 5, NULL, NULL, 'Periudha 2'),
(95, 12, 8, 5, NULL, NULL, 'Periudha 2'),
(96, 13, 1, 5, NULL, NULL, 'Periudha 2'),
(97, 13, 2, 5, NULL, NULL, 'Periudha 2'),
(98, 13, 3, 5, NULL, NULL, 'Periudha 2'),
(99, 13, 4, 5, NULL, NULL, 'Periudha 2'),
(100, 13, 5, 5, NULL, NULL, 'Periudha 2'),
(101, 13, 6, 5, NULL, NULL, 'Periudha 2'),
(102, 13, 7, 5, NULL, NULL, 'Periudha 2'),
(103, 13, 8, 5, NULL, NULL, 'Periudha 2'),
(104, 13, 7, 5, NULL, NULL, 'Periudha 2'),
(105, 13, 8, 5, NULL, NULL, 'Periudha 2'),
(106, 14, 1, 5, NULL, NULL, 'Periudha 2'),
(107, 14, 2, 5, NULL, NULL, 'Periudha 2'),
(108, 14, 3, 5, NULL, NULL, 'Periudha 2'),
(109, 14, 4, 5, NULL, NULL, 'Periudha 2'),
(110, 14, 5, 5, NULL, NULL, 'Periudha 2'),
(111, 14, 6, 5, NULL, NULL, 'Periudha 2'),
(112, 14, 7, 5, NULL, NULL, 'Periudha 2'),
(113, 14, 8, 5, NULL, NULL, 'Periudha 2'),
(114, 15, 1, 5, NULL, NULL, 'Periudha 2'),
(115, 15, 2, 5, NULL, NULL, 'Periudha 2'),
(116, 15, 3, 5, NULL, NULL, 'Periudha 2'),
(117, 15, 4, 5, NULL, NULL, 'Periudha 2'),
(118, 15, 5, 5, NULL, NULL, 'Periudha 2'),
(119, 15, 6, 5, NULL, NULL, 'Periudha 2'),
(120, 15, 7, 5, NULL, NULL, 'Periudha 2'),
(121, 15, 8, 5, NULL, NULL, 'Periudha 2'),
(122, 16, 1, 5, NULL, NULL, 'Periudha 2'),
(123, 16, 2, 5, NULL, NULL, 'Periudha 2'),
(124, 16, 3, 5, NULL, NULL, 'Periudha 2'),
(125, 16, 4, 3, NULL, NULL, 'Periudha 2'),
(126, 16, 5, 4, NULL, NULL, 'Periudha 2'),
(127, 16, 6, 4, NULL, NULL, 'Periudha 2'),
(128, 16, 7, 5, NULL, NULL, 'Periudha 2'),
(129, 16, 8, 3, NULL, NULL, 'Periudha 2'),
(130, 17, 1, 4, NULL, NULL, 'Periudha 2'),
(131, 17, 2, 5, NULL, NULL, 'Periudha 2'),
(132, 17, 3, 5, NULL, NULL, 'Periudha 2'),
(133, 17, 4, 2, NULL, NULL, 'Periudha 2'),
(134, 17, 5, 3, NULL, NULL, 'Periudha 2'),
(135, 17, 6, 4, NULL, NULL, 'Periudha 2'),
(136, 17, 7, 5, NULL, NULL, 'Periudha 2'),
(137, 17, 8, 4, NULL, NULL, 'Periudha 2'),
(138, 18, 1, 5, NULL, NULL, 'Periudha 2'),
(139, 18, 2, 5, NULL, NULL, 'Periudha 2'),
(140, 18, 3, 5, NULL, NULL, 'Periudha 2'),
(141, 18, 4, 3, NULL, NULL, 'Periudha 2'),
(142, 18, 5, 4, NULL, NULL, 'Periudha 2'),
(143, 18, 6, 5, NULL, NULL, 'Periudha 2'),
(144, 18, 7, 5, NULL, NULL, 'Periudha 2'),
(145, 18, 8, 4, NULL, NULL, 'Periudha 2'),
(146, 19, 1, 5, NULL, NULL, 'Periudha 2'),
(147, 19, 2, 5, NULL, NULL, 'Periudha 2'),
(148, 19, 3, 5, NULL, NULL, 'Periudha 2'),
(149, 19, 4, 5, NULL, NULL, 'Periudha 2'),
(150, 19, 5, 5, NULL, NULL, 'Periudha 2'),
(151, 19, 6, 5, NULL, NULL, 'Periudha 2'),
(152, 19, 7, 5, NULL, NULL, 'Periudha 2'),
(153, 19, 8, 5, NULL, NULL, 'Periudha 2'),
(154, 20, 1, 5, NULL, NULL, 'Periudha 2'),
(155, 20, 2, 5, NULL, NULL, 'Periudha 2'),
(156, 20, 3, 5, NULL, NULL, 'Periudha 2'),
(157, 20, 4, 4, NULL, NULL, 'Periudha 2'),
(158, 20, 5, 4, NULL, NULL, 'Periudha 2'),
(159, 20, 6, 5, NULL, NULL, 'Periudha 2'),
(160, 20, 7, 5, NULL, NULL, 'Periudha 2'),
(161, 20, 8, 4, NULL, NULL, 'Periudha 2'),
(162, 21, 1, 4, NULL, NULL, 'Periudha 2'),
(163, 21, 2, 5, NULL, NULL, 'Periudha 2'),
(164, 21, 3, 5, NULL, NULL, 'Periudha 2'),
(165, 21, 4, 2, NULL, NULL, 'Periudha 2'),
(166, 21, 5, 3, NULL, NULL, 'Periudha 2'),
(167, 21, 6, 4, NULL, NULL, 'Periudha 2'),
(168, 21, 7, 5, NULL, NULL, 'Periudha 2'),
(169, 21, 8, 3, NULL, NULL, 'Periudha 2'),
(170, 22, 1, 5, NULL, NULL, 'Periudha 2'),
(171, 22, 2, 5, NULL, NULL, 'Periudha 2'),
(172, 22, 3, 5, NULL, NULL, 'Periudha 2'),
(173, 22, 4, 5, NULL, NULL, 'Periudha 2'),
(174, 22, 5, 5, NULL, NULL, 'Periudha 2'),
(175, 22, 6, 5, NULL, NULL, 'Periudha 2'),
(176, 22, 7, 5, NULL, NULL, 'Periudha 2'),
(177, 22, 8, 5, NULL, NULL, 'Periudha 2'),
(179, 23, 2, 5, NULL, NULL, 'Periudha 2'),
(180, 23, 3, 5, NULL, NULL, 'Periudha 2'),
(181, 23, 4, 4, NULL, NULL, 'Periudha 2'),
(182, 23, 5, 5, NULL, NULL, 'Periudha 2'),
(183, 23, 6, 5, NULL, NULL, 'Periudha 2'),
(184, 23, 7, 5, NULL, NULL, 'Periudha 2'),
(185, 23, 8, 5, 5, NULL, 'Periudha 2'),
(186, 10, 7, 5, NULL, NULL, 'Periudha 2'),
(187, 10, 7, 5, NULL, NULL, 'Periudha 2'),
(189, 23, 1, 5, 5, NULL, 'Periudha 2');

-- --------------------------------------------------------

--
-- Table structure for table `nxenesit`
--

CREATE TABLE `nxenesit` (
  `id` int(11) NOT NULL,
  `emri` varchar(100) NOT NULL,
  `mbiemri` varchar(100) NOT NULL,
  `klasa_id` int(11) NOT NULL,
  `prindi_id` int(11) NOT NULL,
  `mesuesi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nxenesit`
--

INSERT INTO `nxenesit` (`id`, `emri`, `mbiemri`, `klasa_id`, `prindi_id`, `mesuesi_id`) VALUES
(1, 'Adem ', 'Morina', 6, 11, 2),
(2, 'Ajla', 'Behrami', 7, 12, 9),
(3, 'Alina', 'Meholli', 7, 13, 9),
(4, 'Almir', 'Osmani', 6, 14, 2),
(5, 'Amar', 'Muja', 6, 15, 2),
(6, 'Anik', 'Osmani', 7, 16, 9),
(7, 'Arbnor', 'Fazliu', 6, 17, 2),
(8, 'Diamant', 'Pllana', 7, 18, 9),
(9, 'Eliesa', 'Osmani', 6, 19, 2),
(10, 'Erdian ', 'Hajrizi', 7, 20, 9),
(11, 'Erina', 'Hasani', 6, 21, 2),
(12, 'Erina', 'Rruka', 7, 22, 9),
(13, 'Erisa', 'Osmani', 6, 23, 2),
(14, 'Kanita', 'Osmani\r\n', 7, 24, 9),
(15, 'Nil', 'Hasani', 6, 25, 2),
(16, 'Orges', 'Mehana', 7, 26, 9),
(17, 'Princ', 'Berisha\r\n', 6, 27, 2),
(18, 'Reina', 'Pllana', 7, 28, 9),
(19, 'Reina', 'Pllana', 6, 29, 2),
(20, 'Rita', 'Zymeri', 7, 30, 9),
(21, 'Rumejsa', 'Behrami', 6, 31, 2),
(22, 'Uerta', 'Hasani', 7, 32, 9),
(23, 'Vlera', 'Muja', 6, 33, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `emri` varchar(100) NOT NULL,
  `mbiemri` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `fjalkalimi` varchar(255) NOT NULL,
  `roli` enum('admin','drejtor','mesues','prind') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `emri`, `mbiemri`, `email`, `fjalkalimi`, `roli`) VALUES
(1, 'Agron', 'Pllana', 'agronpllana@gmail.com', 'Pllana-1234', 'drejtor'),
(2, 'Albana ', 'Pllana', 'albana.pllana@gmail.com', 'albaPllana1', 'mesues'),
(3, 'Nafije ', 'Lahu', 'nafijelahu@gmail.com', 'N1234L56', 'mesues'),
(4, 'Nadire', 'Hajrizi', 'nadirehajrizi@gmail.com', 'nadi@456', 'mesues'),
(5, 'Floresa', 'Berisha', 'floresa.berisha@gmail.com', 'flori@123', 'mesues'),
(6, 'Valdete', 'Berisha', 'valdeteberisha1@gmail.com', 'vali-123.', 'mesues'),
(7, 'Hanife', 'Hyseni', 'hanife-hyseni@gmail.com', 'Hana1997', 'mesues'),
(8, 'Anita', 'Gashi', 'aanitagashi@gmail.com', 'NitaG02', 'mesues'),
(9, 'Arbenita', 'Gashi', 'arbenita.gashi1@gmail.com', 'Gashi.1995', 'mesues'),
(10, 'Sara', 'Hajrizi', 'sarahajrizi44@gmail.com', 'Hajrizi@123.', 'admin'),
(11, 'Vllaznim', 'Morina', 'vllaznimmorina@hotmail.com', 'ademmorina', 'prind'),
(12, 'Mehdi ', 'Behrami', 'mehdibehrami@gmail.com', 'mehdiAjla', 'prind'),
(13, 'Blerim', 'Meholli', 'blerim.meholli@gmail.com', 'bleribleri', 'prind'),
(14, 'Rrahim', 'Osmani', 'rrahim-osmani@gmail.com', 'rrahim-12', 'prind'),
(15, 'Efraim ', 'Muja', 'efraim-muja@gmail.com', 'muja1987', 'prind'),
(16, 'Mergim\r\n', 'Osmani', 'mergimosmani1@gmail.com', 'osmani12', 'prind'),
(17, 'Afrimi', 'Fazliu', 'afrimfazliu@gmail.com', 'nori2017', 'prind'),
(18, 'Imer', 'Pllana', 'imerpllana@outlook.com', 'diamanti13', 'prind'),
(19, 'Shaip', 'Hajrizi', 'shaiphajrizi@gmail.com', 'Erdi2007', 'prind'),
(20, 'Bekim', 'Osmani', 'bekiosmani@gmail.com', 'bekibeki123', 'prind'),
(21, 'Qemajl', 'Hasani', 'qemajl-hasani@outlook.com', 'hasani1984', 'prind'),
(22, 'Brahim', 'Rruka', 'brahimrruka@hotmail.com', 'Rruka.57', 'prind'),
(23, 'Bujar', 'Osmani', 'bujarosmani@gmail.com', 'ErisaEra', 'prind'),
(24, 'Shaban', 'Osmani', 'shabanosmani@gmail.com', 'Kanita-Klea', 'prind'),
(25, 'Blerim', 'Hasani', 'bleri-hasani@gmail.com', 'Bleri785', 'prind'),
(26, 'Selami', 'Mehana', 'sela-mehana@gmail.com', 'Sela@123', 'prind'),
(27, 'Fitim', 'Berisha', 'fitaberisha@gmail.com', 'Princi123.', 'prind'),
(28, 'Artan', 'Pllana', 'artanpllana@gmail.com', 'artan123.', 'prind'),
(29, 'Lulzim', 'Pllana', 'luli-pllana@gmail.com', 'Luli.Pllana', 'prind'),
(30, 'Lutfi', 'Zymeri', 'lutfizymeri17@gmail.com', 'Rita2017', 'prind'),
(31, 'Vedat', 'Behrami', 'vedatbehrami@gmail.com', 'shtitaric2025', 'prind'),
(32, 'Arburim', 'Hasani', 'arbuhimhasani@gmail.com', 'Hasani78', 'prind'),
(33, 'Blerim', 'Muja', 'blerimuja@gmail.com', 'Vlera.123', 'prind');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `klasat`
--
ALTER TABLE `klasat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komentet`
--
ALTER TABLE `komentet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lendet`
--
ALTER TABLE `lendet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `njoftimet`
--
ALTER TABLE `njoftimet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notat`
--
ALTER TABLE `notat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nxenesit`
--
ALTER TABLE `nxenesit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `klasat`
--
ALTER TABLE `klasat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `komentet`
--
ALTER TABLE `komentet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `lendet`
--
ALTER TABLE `lendet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `njoftimet`
--
ALTER TABLE `njoftimet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notat`
--
ALTER TABLE `notat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `nxenesit`
--
ALTER TABLE `nxenesit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
