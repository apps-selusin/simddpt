-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 19, 2018 at 09:46 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_simddpt`
--

-- --------------------------------------------------------

--
-- Table structure for table `t00_provinsi`
--

CREATE TABLE `t00_provinsi` (
  `id` int(11) NOT NULL,
  `Nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t00_provinsi`
--

INSERT INTO `t00_provinsi` (`id`, `Nama`) VALUES
(1, 'Jawa Timur');

-- --------------------------------------------------------

--
-- Table structure for table `t01_kabupatenkota`
--

CREATE TABLE `t01_kabupatenkota` (
  `id` int(11) NOT NULL,
  `provinsi_id` int(11) NOT NULL,
  `Nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t01_kabupatenkota`
--

INSERT INTO `t01_kabupatenkota` (`id`, `provinsi_id`, `Nama`) VALUES
(1, 1, 'Kota Surabaya'),
(2, 1, 'Kabupaten Sidoarjo');

-- --------------------------------------------------------

--
-- Table structure for table `t02_kecamatan`
--

CREATE TABLE `t02_kecamatan` (
  `id` int(11) NOT NULL,
  `provinsi_id` int(11) NOT NULL,
  `kabupatenkota_id` int(11) NOT NULL,
  `Nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t02_kecamatan`
--

INSERT INTO `t02_kecamatan` (`id`, `provinsi_id`, `kabupatenkota_id`, `Nama`) VALUES
(1, 1, 1, 'Tegalsari'),
(2, 1, 1, 'Simokerto'),
(3, 1, 1, 'Genteng'),
(4, 1, 1, 'Bubutan'),
(5, 1, 1, 'Gubeng'),
(6, 1, 1, 'Gunung Anyar'),
(7, 1, 1, 'Sukolilo'),
(8, 1, 1, 'Tambaksari'),
(9, 1, 1, 'Mulyorejo'),
(10, 1, 1, 'Rungkut'),
(11, 1, 1, 'Tenggilis Mejoyo'),
(12, 1, 1, 'Benowo'),
(13, 1, 1, 'Pakal'),
(14, 1, 1, 'Asemrowo'),
(15, 1, 1, 'Sukomanunggal'),
(16, 1, 1, 'Tandes'),
(17, 1, 1, 'Sambikerep'),
(18, 1, 1, 'Lakarsantri'),
(19, 1, 1, 'Bulak'),
(20, 1, 1, 'Kenjeran'),
(21, 1, 1, 'Semampir'),
(22, 1, 1, 'Pabean Cantian'),
(23, 1, 1, 'Krembangan'),
(24, 1, 1, 'Wonokromo'),
(25, 1, 1, 'Wonocolo'),
(26, 1, 1, 'Wiyung'),
(27, 1, 1, 'Karang Pilang'),
(28, 1, 1, 'Jambangan'),
(29, 1, 1, 'Gayungan'),
(30, 1, 1, 'Dukuh Pakis'),
(31, 1, 1, 'Sawahan');

-- --------------------------------------------------------

--
-- Table structure for table `t03_kelurahan`
--

CREATE TABLE `t03_kelurahan` (
  `id` int(11) NOT NULL,
  `provinsi_id` int(11) NOT NULL,
  `kabupatenkota_id` int(11) NOT NULL,
  `kecamatan_id` int(11) NOT NULL,
  `Nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t03_kelurahan`
--

INSERT INTO `t03_kelurahan` (`id`, `provinsi_id`, `kabupatenkota_id`, `kecamatan_id`, `Nama`) VALUES
(1, 1, 1, 4, 'Alun-Alun Contong '),
(2, 1, 1, 4, 'Bubutan'),
(3, 1, 1, 4, 'Gundih'),
(4, 1, 1, 4, 'Jepara'),
(5, 1, 1, 4, 'Tembok Dukuh'),
(6, 1, 1, 3, 'Embong Kaliasin'),
(7, 1, 1, 3, 'Genteng'),
(8, 1, 1, 3, 'Kapasari'),
(9, 1, 1, 3, 'Ketabang'),
(10, 1, 1, 3, 'Peneleh'),
(11, 1, 1, 2, 'Kapasan'),
(12, 1, 1, 2, 'Sidodadi'),
(13, 1, 1, 2, 'Simokerto'),
(14, 1, 1, 2, 'Simolawang'),
(15, 1, 1, 2, 'Tambak Rejo'),
(16, 1, 1, 1, 'Dr. Soetomo'),
(17, 1, 1, 1, 'Kedungdoro'),
(18, 1, 1, 1, 'Keputran'),
(19, 1, 1, 1, 'Tegalsari'),
(20, 1, 1, 1, 'Wonorejo'),
(21, 1, 1, 19, 'Bulak'),
(22, 1, 1, 19, 'Kedung Cowek'),
(23, 1, 1, 19, 'Kenjeran'),
(24, 1, 1, 19, 'Sukolilo Baru'),
(25, 1, 1, 20, 'Bulak Banteng'),
(26, 1, 1, 20, 'Sidotopo Wetan'),
(27, 1, 1, 20, 'Tambak Wedi'),
(28, 1, 1, 20, 'Tanah Kali Kedinding'),
(29, 1, 1, 23, 'Dupak'),
(30, 1, 1, 23, 'Kemayoran'),
(31, 1, 1, 23, 'Krembangan Selatan'),
(32, 1, 1, 23, 'Morokrembangan'),
(33, 1, 1, 23, 'Perak Barat'),
(34, 1, 1, 22, 'Bongkaran'),
(35, 1, 1, 22, 'Krembangan Utara'),
(36, 1, 1, 22, 'Nyamplungan'),
(37, 1, 1, 22, 'Perak Timur'),
(38, 1, 1, 22, 'Perak Utara'),
(39, 1, 1, 21, 'Ampel'),
(40, 1, 1, 21, 'Pegirian'),
(41, 1, 1, 21, 'Sidotopo'),
(42, 1, 1, 21, 'Ujung'),
(43, 1, 1, 21, 'Wonokusumo'),
(44, 1, 1, 30, 'Dukuh Kupang'),
(45, 1, 1, 30, 'Dukuh Pakis'),
(46, 1, 1, 30, 'Gunung Sari'),
(47, 1, 1, 30, 'Pradah Kali Kendal'),
(48, 1, 1, 29, 'Dukuh Menanggal'),
(49, 1, 1, 29, 'Gayungan'),
(50, 1, 1, 29, 'Ketintang'),
(51, 1, 1, 29, 'Menanggal'),
(52, 1, 1, 28, 'Jambangan'),
(53, 1, 1, 28, 'Karah'),
(54, 1, 1, 28, 'Kebonsari'),
(55, 1, 1, 28, 'Pagesangan'),
(56, 1, 1, 27, 'Karangpilang'),
(57, 1, 1, 27, 'Kebraon'),
(58, 1, 1, 27, 'Kedurus'),
(59, 1, 1, 27, 'Waru Gunung'),
(60, 1, 1, 31, 'Banyu Urip'),
(61, 1, 1, 31, 'Kupang Krajan'),
(62, 1, 1, 31, 'Pakis'),
(63, 1, 1, 31, 'Petemon'),
(64, 1, 1, 31, 'Putat Jaya'),
(65, 1, 1, 31, 'Sawahan'),
(66, 1, 1, 26, 'Babatan'),
(67, 1, 1, 26, 'Balas Klumprik'),
(68, 1, 1, 26, 'Jajar Tunggal'),
(69, 1, 1, 26, 'Wiyung'),
(70, 1, 1, 25, 'Bendul Merisi'),
(71, 1, 1, 25, 'Jemur Wonosari'),
(72, 1, 1, 25, 'Margorejo'),
(73, 1, 1, 25, 'Sidosermo'),
(74, 1, 1, 25, 'Siwalankerto'),
(75, 1, 1, 24, 'Darmo'),
(76, 1, 1, 24, 'Jagir'),
(77, 1, 1, 24, 'Ngagel'),
(78, 1, 1, 24, 'Ngagel Rejo'),
(79, 1, 1, 24, 'Sawunggaling'),
(80, 1, 1, 24, 'Wonokromo'),
(81, 1, 1, 5, 'Airlangga'),
(82, 1, 1, 5, 'Baratajaya'),
(83, 1, 1, 5, 'Gubeng'),
(84, 1, 1, 5, 'Kertajaya'),
(85, 1, 1, 5, 'Mojo'),
(86, 1, 1, 5, 'Pucang Sewu'),
(87, 1, 1, 6, 'Gunung Anyar'),
(88, 1, 1, 6, 'Gunung Anyar Tambak'),
(89, 1, 1, 6, 'Rungkut Menanggal'),
(90, 1, 1, 6, 'Rungkut Tengah'),
(91, 1, 1, 9, 'Dukuh Sutorejo'),
(92, 1, 1, 9, 'Kalijudan'),
(93, 1, 1, 9, 'Kalisari'),
(94, 1, 1, 9, 'Kejawan Putih Tambak'),
(95, 1, 1, 9, 'Manyar Sabrangan'),
(96, 1, 1, 9, 'Mulyorejo'),
(97, 1, 1, 10, 'Kalirungkut'),
(98, 1, 1, 10, 'Kedung Baruk'),
(99, 1, 1, 10, 'Medoan Ayu'),
(100, 1, 1, 10, 'Penjaringansari'),
(101, 1, 1, 10, 'Rungkut Kidul'),
(102, 1, 1, 10, 'Wonorejo'),
(103, 1, 1, 7, 'Gebang Putih'),
(104, 1, 1, 7, 'Keputih'),
(105, 1, 1, 7, 'Klampis Ngasem'),
(106, 1, 1, 7, 'Medokan Semampir'),
(107, 1, 1, 7, 'Menur Pumpungan'),
(108, 1, 1, 7, 'Nginden Jangkungan'),
(109, 1, 1, 7, 'Semolowaru'),
(110, 1, 1, 8, 'Gading'),
(111, 1, 1, 8, 'Dukuh Setro'),
(112, 1, 1, 8, 'Kapas Madya'),
(113, 1, 1, 8, 'Pacarkeling'),
(114, 1, 1, 8, 'Pacarkembang'),
(115, 1, 1, 8, 'Ploso'),
(116, 1, 1, 8, 'Rangkah'),
(117, 1, 1, 8, 'Tambaksari'),
(118, 1, 1, 11, 'Kendangsari'),
(119, 1, 1, 11, 'Kutisari'),
(120, 1, 1, 11, 'Panjang Jiwo'),
(121, 1, 1, 11, 'Tenggilis Mejoyo'),
(122, 1, 1, 14, 'Asemrowo'),
(123, 1, 1, 14, 'Genting Kalianak'),
(124, 1, 1, 14, 'Tambak Sarioso'),
(125, 1, 1, 12, 'Kandangan'),
(126, 1, 1, 12, 'Romokalisari'),
(127, 1, 1, 12, 'Sememi'),
(128, 1, 1, 12, 'Tambak Oso Wilangun'),
(129, 1, 1, 18, 'Bangkingan'),
(130, 1, 1, 18, 'Jeruk'),
(131, 1, 1, 18, 'Lakarsantri'),
(132, 1, 1, 18, 'Lidah Kulon'),
(133, 1, 1, 18, 'Lidah Wetan'),
(134, 1, 1, 18, 'Sumur Welut'),
(135, 1, 1, 13, 'Babat Jerawat'),
(136, 1, 1, 13, 'Benowo'),
(137, 1, 1, 13, 'Pakal'),
(138, 1, 1, 13, 'Sumber Rejo'),
(139, 1, 1, 17, 'Bringin'),
(140, 1, 1, 17, 'Lontar'),
(141, 1, 1, 17, 'Made'),
(142, 1, 1, 17, 'Sambikerep'),
(143, 1, 1, 15, 'Putat Gede'),
(144, 1, 1, 15, 'Simomulyo'),
(145, 1, 1, 15, 'Simomulyo Baru'),
(146, 1, 1, 15, 'Sonokwijenan'),
(147, 1, 1, 15, 'Sukomanunggal'),
(148, 1, 1, 15, 'Tanjung Sari'),
(149, 1, 1, 16, 'Balongsari'),
(150, 1, 1, 16, 'Banjar Sugihan'),
(151, 1, 1, 16, 'Karangpoh'),
(152, 1, 1, 16, 'Manukan Kulon'),
(153, 1, 1, 16, 'Manukan Wetan'),
(154, 1, 1, 16, 'Tandes');

-- --------------------------------------------------------

--
-- Table structure for table `t94_log`
--

CREATE TABLE `t94_log` (
  `id` int(11) NOT NULL,
  `index_` tinyint(4) NOT NULL,
  `subj_` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t94_log`
--

INSERT INTO `t94_log` (`id`, `index_`, `subj_`) VALUES
(7, 1, 'setup');

-- --------------------------------------------------------

--
-- Table structure for table `t95_logdesc`
--

CREATE TABLE `t95_logdesc` (
  `id` int(11) NOT NULL,
  `log_id` int(11) NOT NULL,
  `date_issued` date NOT NULL,
  `desc_` text NOT NULL,
  `date_solved` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t95_logdesc`
--

INSERT INTO `t95_logdesc` (`id`, `log_id`, `date_issued`, `desc_`, `date_solved`) VALUES
(24, 7, '2018-10-20', 'SETUP - PROVINSI', '2018-10-20'),
(25, 7, '2018-10-20', 'SETUP - KABUPATEN / KOTA', '2018-10-20'),
(26, 7, '2018-10-20', 'SETUP - KECAMATAN', '2018-10-20'),
(27, 7, '2018-10-20', 'SETUP - KELURAHAN', '2018-10-20');

-- --------------------------------------------------------

--
-- Table structure for table `t96_employees`
--

CREATE TABLE `t96_employees` (
  `EmployeeID` int(11) NOT NULL,
  `LastName` varchar(20) DEFAULT NULL,
  `FirstName` varchar(10) DEFAULT NULL,
  `Title` varchar(30) DEFAULT NULL,
  `TitleOfCourtesy` varchar(25) DEFAULT NULL,
  `BirthDate` datetime DEFAULT NULL,
  `HireDate` datetime DEFAULT NULL,
  `Address` varchar(60) DEFAULT NULL,
  `City` varchar(15) DEFAULT NULL,
  `Region` varchar(15) DEFAULT NULL,
  `PostalCode` varchar(10) DEFAULT NULL,
  `Country` varchar(15) DEFAULT NULL,
  `HomePhone` varchar(24) DEFAULT NULL,
  `Extension` varchar(4) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `Notes` longtext,
  `ReportsTo` int(11) DEFAULT NULL,
  `Password` varchar(50) NOT NULL DEFAULT '',
  `UserLevel` int(11) DEFAULT NULL,
  `Username` varchar(20) NOT NULL DEFAULT '',
  `Activated` enum('Y','N') NOT NULL DEFAULT 'N',
  `Profile` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t96_employees`
--

INSERT INTO `t96_employees` (`EmployeeID`, `LastName`, `FirstName`, `Title`, `TitleOfCourtesy`, `BirthDate`, `HireDate`, `Address`, `City`, `Region`, `PostalCode`, `Country`, `HomePhone`, `Extension`, `Email`, `Photo`, `Notes`, `ReportsTo`, `Password`, `UserLevel`, `Username`, `Activated`, `Profile`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '21232f297a57a5a743894a0e4a801fc3', -1, 'admin', 'Y', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t97_userlevels`
--

CREATE TABLE `t97_userlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t97_userlevels`
--

INSERT INTO `t97_userlevels` (`userlevelid`, `userlevelname`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `t98_userlevelpermissions`
--

CREATE TABLE `t98_userlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t98_userlevelpermissions`
--

INSERT INTO `t98_userlevelpermissions` (`userlevelid`, `tablename`, `permission`) VALUES
(-2, '{78A0660C-C398-4292-A50E-2A3C7D765239}cf01_home.php', 8),
(-2, '{78A0660C-C398-4292-A50E-2A3C7D765239}t96_employees', 0),
(-2, '{78A0660C-C398-4292-A50E-2A3C7D765239}t97_userlevels', 0),
(-2, '{78A0660C-C398-4292-A50E-2A3C7D765239}t98_userlevelpermissions', 0),
(-2, '{78A0660C-C398-4292-A50E-2A3C7D765239}t99_audittrail', 0),
(-2, '{85949079-8d99-4464-bac3-cdcac631731f}cf01_home.php', 0),
(-2, '{85949079-8d99-4464-bac3-cdcac631731f}t96_employees', 0),
(-2, '{85949079-8d99-4464-bac3-cdcac631731f}t97_userlevels', 0),
(-2, '{85949079-8d99-4464-bac3-cdcac631731f}t98_userlevelpermissions', 0),
(-2, '{85949079-8d99-4464-bac3-cdcac631731f}t99_audittrail', 0),
(-2, '{9A296957-6EE4-4785-AB71-310FFD71D6FE}cf01_home.php', 8),
(-2, '{9A296957-6EE4-4785-AB71-310FFD71D6FE}t96_employees', 0),
(-2, '{9A296957-6EE4-4785-AB71-310FFD71D6FE}t97_userlevels', 0),
(-2, '{9A296957-6EE4-4785-AB71-310FFD71D6FE}t98_userlevelpermissions', 0),
(-2, '{9A296957-6EE4-4785-AB71-310FFD71D6FE}t99_audittrail', 0),
(0, '{78A0660C-C398-4292-A50E-2A3C7D765239}cf01_home.php', 8),
(0, '{78A0660C-C398-4292-A50E-2A3C7D765239}t96_employees', 0),
(0, '{78A0660C-C398-4292-A50E-2A3C7D765239}t97_userlevels', 0),
(0, '{78A0660C-C398-4292-A50E-2A3C7D765239}t98_userlevelpermissions', 0),
(0, '{78A0660C-C398-4292-A50E-2A3C7D765239}t99_audittrail', 0),
(0, '{85949079-8d99-4464-bac3-cdcac631731f}cf01_home.php', 0),
(0, '{85949079-8d99-4464-bac3-cdcac631731f}t96_employees', 0),
(0, '{85949079-8d99-4464-bac3-cdcac631731f}t97_userlevels', 0),
(0, '{85949079-8d99-4464-bac3-cdcac631731f}t98_userlevelpermissions', 0),
(0, '{85949079-8d99-4464-bac3-cdcac631731f}t99_audittrail', 0),
(0, '{9A296957-6EE4-4785-AB71-310FFD71D6FE}cf01_home.php', 8),
(0, '{9A296957-6EE4-4785-AB71-310FFD71D6FE}t96_employees', 0),
(0, '{9A296957-6EE4-4785-AB71-310FFD71D6FE}t97_userlevels', 0),
(0, '{9A296957-6EE4-4785-AB71-310FFD71D6FE}t98_userlevelpermissions', 0),
(0, '{9A296957-6EE4-4785-AB71-310FFD71D6FE}t99_audittrail', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t99_audittrail`
--

CREATE TABLE `t99_audittrail` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `script` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `keyvalue` longtext,
  `oldvalue` longtext,
  `newvalue` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t99_audittrail`
--

INSERT INTO `t99_audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(1, '2018-10-20 00:47:11', '/simddpt/t00_provinsiadd.php', '1', 'A', 't00_provinsi', 'Nama', '1', '', 'Jawa Timur'),
(2, '2018-10-20 00:47:11', '/simddpt/t00_provinsiadd.php', '1', 'A', 't00_provinsi', 'id', '1', '', '1'),
(3, '2018-10-20 00:49:18', '/simddpt/t01_kabupatenkotaadd.php', '1', 'A', 't01_kabupatenkota', 'provinsi_id', '1', '', '1'),
(4, '2018-10-20 00:49:18', '/simddpt/t01_kabupatenkotaadd.php', '1', 'A', 't01_kabupatenkota', 'Nama', '1', '', 'Kota Surabaya'),
(5, '2018-10-20 00:49:18', '/simddpt/t01_kabupatenkotaadd.php', '1', 'A', 't01_kabupatenkota', 'id', '1', '', '1'),
(6, '2018-10-20 00:49:32', '/simddpt/t01_kabupatenkotaadd.php', '1', 'A', 't01_kabupatenkota', 'provinsi_id', '2', '', '1'),
(7, '2018-10-20 00:49:32', '/simddpt/t01_kabupatenkotaadd.php', '1', 'A', 't01_kabupatenkota', 'Nama', '2', '', 'Kabupaten Sidoarjo'),
(8, '2018-10-20 00:49:32', '/simddpt/t01_kabupatenkotaadd.php', '1', 'A', 't01_kabupatenkota', 'id', '2', '', '2'),
(9, '2018-10-20 01:20:26', '/simddpt/t02_kecamatanadd.php', '1', 'A', 't02_kecamatan', 'provinsi_id', '1', '', '1'),
(10, '2018-10-20 01:20:26', '/simddpt/t02_kecamatanadd.php', '1', 'A', 't02_kecamatan', 'kabupatenkota_id', '1', '', '1'),
(11, '2018-10-20 01:20:26', '/simddpt/t02_kecamatanadd.php', '1', 'A', 't02_kecamatan', 'Nama', '1', '', 'Tegalsari'),
(12, '2018-10-20 01:20:26', '/simddpt/t02_kecamatanadd.php', '1', 'A', 't02_kecamatan', 'id', '1', '', '1'),
(13, '2018-10-20 02:13:33', '/simddpt/t03_kelurahanadd.php', '1', 'A', 't03_kelurahan', 'provinsi_id', '1', '', '1'),
(14, '2018-10-20 02:13:33', '/simddpt/t03_kelurahanadd.php', '1', 'A', 't03_kelurahan', 'kabupatenkota_id', '1', '', '1'),
(15, '2018-10-20 02:13:33', '/simddpt/t03_kelurahanadd.php', '1', 'A', 't03_kelurahan', 'kecamatan_id', '1', '', '4'),
(16, '2018-10-20 02:13:33', '/simddpt/t03_kelurahanadd.php', '1', 'A', 't03_kelurahan', 'Nama', '1', '', 'Alun-Alun Contong'),
(17, '2018-10-20 02:13:33', '/simddpt/t03_kelurahanadd.php', '1', 'A', 't03_kelurahan', 'id', '1', '', '1'),
(18, '2018-10-20 02:23:27', '/simddpt/t94_logadd.php', '1', 'A', 't94_log', 'index_', '7', '', '1'),
(19, '2018-10-20 02:23:27', '/simddpt/t94_logadd.php', '1', 'A', 't94_log', 'subj_', '7', '', 'setup'),
(20, '2018-10-20 02:23:27', '/simddpt/t94_logadd.php', '1', 'A', 't94_log', 'id', '7', '', '7'),
(21, '2018-10-20 02:38:16', '/simddpt/t94_logedit.php', '1', '*** Batch update begin ***', 't95_logdesc', '', '', '', ''),
(22, '2018-10-20 02:38:16', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'log_id', '24', '', '7'),
(23, '2018-10-20 02:38:16', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'desc_', '24', '', 'SETUP - PROVINSI'),
(24, '2018-10-20 02:38:16', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'date_issued', '24', '', '2018-10-20'),
(25, '2018-10-20 02:38:16', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'date_solved', '24', '', '2018-10-20'),
(26, '2018-10-20 02:38:16', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'id', '24', '', '24'),
(27, '2018-10-20 02:38:16', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'log_id', '25', '', '7'),
(28, '2018-10-20 02:38:16', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'desc_', '25', '', 'SETUP - KABUPATEN / KOTA'),
(29, '2018-10-20 02:38:16', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'date_issued', '25', '', '2018-10-20'),
(30, '2018-10-20 02:38:16', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'date_solved', '25', '', '2018-10-20'),
(31, '2018-10-20 02:38:16', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'id', '25', '', '25'),
(32, '2018-10-20 02:38:17', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'log_id', '26', '', '7'),
(33, '2018-10-20 02:38:17', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'desc_', '26', '', 'SETUP - KECAMATAN'),
(34, '2018-10-20 02:38:17', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'date_issued', '26', '', '2018-10-20'),
(35, '2018-10-20 02:38:17', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'date_solved', '26', '', '2018-10-20'),
(36, '2018-10-20 02:38:17', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'id', '26', '', '26'),
(37, '2018-10-20 02:38:17', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'log_id', '27', '', '7'),
(38, '2018-10-20 02:38:17', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'desc_', '27', '', 'SETUP - KELURAHAN'),
(39, '2018-10-20 02:38:17', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'date_issued', '27', '', '2018-10-20'),
(40, '2018-10-20 02:38:17', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'date_solved', '27', '', '2018-10-20'),
(41, '2018-10-20 02:38:17', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'id', '27', '', '27'),
(42, '2018-10-20 02:38:17', '/simddpt/t94_logedit.php', '1', '*** Batch update successful ***', 't95_logdesc', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t00_provinsi`
--
ALTER TABLE `t00_provinsi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t01_kabupatenkota`
--
ALTER TABLE `t01_kabupatenkota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t02_kecamatan`
--
ALTER TABLE `t02_kecamatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t03_kelurahan`
--
ALTER TABLE `t03_kelurahan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t94_log`
--
ALTER TABLE `t94_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t95_logdesc`
--
ALTER TABLE `t95_logdesc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t96_employees`
--
ALTER TABLE `t96_employees`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `t97_userlevels`
--
ALTER TABLE `t97_userlevels`
  ADD PRIMARY KEY (`userlevelid`);

--
-- Indexes for table `t98_userlevelpermissions`
--
ALTER TABLE `t98_userlevelpermissions`
  ADD PRIMARY KEY (`userlevelid`,`tablename`);

--
-- Indexes for table `t99_audittrail`
--
ALTER TABLE `t99_audittrail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t00_provinsi`
--
ALTER TABLE `t00_provinsi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t01_kabupatenkota`
--
ALTER TABLE `t01_kabupatenkota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t02_kecamatan`
--
ALTER TABLE `t02_kecamatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `t03_kelurahan`
--
ALTER TABLE `t03_kelurahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `t94_log`
--
ALTER TABLE `t94_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `t95_logdesc`
--
ALTER TABLE `t95_logdesc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `t96_employees`
--
ALTER TABLE `t96_employees`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t99_audittrail`
--
ALTER TABLE `t99_audittrail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
