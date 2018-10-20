-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 20, 2018 at 06:50 AM
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
(31, 1, 1, 'Sawahan'),
(32, 1, 2, 'Sidoarjo'),
(33, 1, 2, 'Krembung'),
(34, 1, 2, 'Taman'),
(35, 1, 2, 'Balongbendo'),
(36, 1, 2, 'Krian'),
(37, 1, 2, 'Tanggulangin'),
(38, 1, 2, 'Buduran'),
(39, 1, 2, 'Prambon'),
(40, 1, 2, 'Tarik'),
(41, 1, 2, 'Candi'),
(42, 1, 2, 'Porong'),
(43, 1, 2, 'Tulangan'),
(44, 1, 2, 'Gedangan'),
(45, 1, 2, 'Sedati'),
(46, 1, 2, 'Waru'),
(47, 1, 2, 'Jabon'),
(48, 1, 2, 'Sukodono'),
(49, 1, 2, 'Wonoayu');

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
(154, 1, 1, 16, 'Tandes'),
(155, 1, 2, 48, 'Anggaswangi'),
(156, 1, 2, 35, 'Bakalan Wringinpitu'),
(157, 1, 2, 35, 'Bakungpringgodani'),
(158, 1, 2, 35, 'Bakungtemenggungan'),
(159, 1, 2, 33, 'Balanggarut'),
(160, 1, 2, 35, 'Balongbendo'),
(161, 1, 2, 41, 'Balongdowo'),
(162, 1, 2, 41, 'Balonggabus'),
(163, 1, 2, 40, 'Balongmacekan'),
(164, 1, 2, 47, 'Balongtani'),
(165, 1, 2, 44, 'Bangah'),
(166, 1, 2, 48, 'Bangsri'),
(167, 1, 2, 32, 'Banjarbendo'),
(168, 1, 2, 38, 'Banjarkemantran'),
(169, 1, 2, 38, 'Banjarkemantren'),
(170, 1, 2, 45, 'Banjarkemuningtambak'),
(171, 1, 2, 37, 'Banjarpanji'),
(172, 1, 2, 38, 'Banjarsari'),
(173, 1, 2, 37, 'Banjarsari'),
(174, 1, 2, 36, 'Barengkrajan'),
(175, 1, 2, 34, 'Bebekan'),
(176, 1, 2, 49, 'Becirongengor'),
(177, 1, 2, 39, 'Bendotretek'),
(178, 1, 2, 46, 'Berbek'),
(179, 1, 2, 47, 'Besuki'),
(180, 1, 2, 45, 'Betro'),
(181, 1, 2, 41, 'Bligo'),
(182, 1, 2, 32, 'Bluru Kidul'),
(183, 1, 2, 35, 'Bogempinggir'),
(184, 1, 2, 34, 'Bohar'),
(185, 1, 2, 37, 'Boro'),
(186, 1, 2, 34, 'Bringinbendo'),
(187, 1, 2, 38, 'Buduran'),
(188, 1, 2, 39, 'Bulang'),
(189, 1, 2, 45, 'Buncitan'),
(190, 1, 2, 46, 'Bungurasih'),
(191, 1, 2, 41, 'Candi'),
(192, 1, 2, 49, 'Candinegoro'),
(193, 1, 2, 42, 'Candipari'),
(194, 1, 2, 33, 'Cangkring'),
(195, 1, 2, 48, 'Cangkringsari'),
(196, 1, 2, 39, 'Cangkringturi'),
(197, 1, 2, 45, 'Cemandi'),
(198, 1, 2, 32, 'Cemengbakalan'),
(199, 1, 2, 38, 'Damarsi'),
(200, 1, 2, 38, 'Damarsih'),
(201, 1, 2, 47, 'Dukuhsari'),
(202, 1, 2, 38, 'Dukuhtengah'),
(203, 1, 2, 41, 'Durungbanjar'),
(204, 1, 2, 41, 'Durungbedug'),
(205, 1, 2, 38, 'Entalsewu'),
(206, 1, 2, 38, 'Entelsewu'),
(207, 1, 2, 33, 'Gading'),
(208, 1, 2, 35, 'Gadungkepuhsari'),
(209, 1, 2, 39, 'Gampang'),
(210, 1, 2, 36, 'Gamping'),
(211, 1, 2, 40, 'Gampingrowo'),
(212, 1, 2, 37, 'Ganggang Panjang'),
(213, 1, 2, 44, 'Ganting'),
(214, 1, 2, 44, 'Gedangan'),
(215, 1, 2, 40, 'Gedangklutuk'),
(216, 1, 2, 39, 'Gedangrowo'),
(217, 1, 2, 41, 'Gelam'),
(218, 1, 2, 43, 'Gelang'),
(219, 1, 2, 34, 'Geluran'),
(220, 1, 2, 37, 'Gempolsari'),
(221, 1, 2, 44, 'Gemurung'),
(222, 1, 2, 34, 'Gilang'),
(223, 1, 2, 45, 'Gisikcemandi'),
(224, 1, 2, 42, 'Glagaharum'),
(225, 1, 2, 43, 'Grabangan'),
(226, 1, 2, 43, 'Grinting'),
(227, 1, 2, 43, 'Grogol'),
(228, 1, 2, 35, 'Jabaran'),
(229, 1, 2, 41, 'Jambangan'),
(230, 1, 2, 40, 'Janti'),
(231, 1, 2, 43, 'Janti'),
(232, 1, 2, 46, 'Janti'),
(233, 1, 2, 32, 'Jati'),
(234, 1, 2, 39, 'Jatialunalun'),
(235, 1, 2, 36, 'Jatikalang'),
(236, 1, 2, 39, 'Jatikalang'),
(237, 1, 2, 39, 'Jedongcangkring'),
(238, 1, 2, 47, 'Jemirahan'),
(239, 1, 2, 34, 'Jemundo'),
(240, 1, 2, 33, 'Jenggot'),
(241, 1, 2, 36, 'Jerukgamping'),
(242, 1, 2, 35, 'Jeruklegi'),
(243, 1, 2, 43, 'Jiken'),
(244, 1, 2, 49, 'Jimbarankulon'),
(245, 1, 2, 49, 'Jimbaranwetan'),
(246, 1, 2, 48, 'Jogosatru'),
(247, 1, 2, 48, 'Jumputrejo'),
(248, 1, 2, 36, 'Junwangi'),
(249, 1, 2, 39, 'Kajartrengguli'),
(250, 1, 2, 43, 'Kajeksan'),
(251, 1, 2, 45, 'Kalanganyar'),
(252, 1, 2, 37, 'Kalidawir'),
(253, 1, 2, 34, 'Kalijaten'),
(254, 1, 2, 40, 'Kalimati'),
(255, 1, 2, 41, 'Kalipecabean'),
(256, 1, 2, 37, 'Kalisampurno'),
(257, 1, 2, 37, 'Kalitengah'),
(258, 1, 2, 33, 'Kandangan'),
(259, 1, 2, 44, 'Karangbong'),
(260, 1, 2, 49, 'Karangpuri'),
(261, 1, 2, 41, 'Karangtanjung'),
(262, 1, 2, 36, 'Katerungan'),
(263, 1, 2, 42, 'Kebakalan'),
(264, 1, 2, 43, 'Kebaran'),
(265, 1, 2, 44, 'Keboan Anom'),
(266, 1, 2, 44, 'Keboan Sikep'),
(267, 1, 2, 44, 'Keboansikep'),
(268, 1, 2, 47, 'Keboguyang'),
(269, 1, 2, 36, 'Keboharan'),
(270, 1, 2, 42, 'Kebonagung'),
(271, 1, 2, 48, 'Kebonagung'),
(272, 1, 2, 44, 'Kebonanom'),
(273, 1, 2, 41, 'Kebonsari'),
(274, 1, 2, 37, 'Kedensari'),
(275, 1, 2, 40, 'Kedinding'),
(276, 1, 2, 37, 'Kedungbanteng'),
(277, 1, 2, 37, 'Kedungbendo'),
(278, 1, 2, 40, 'Kedungbocok'),
(279, 1, 2, 42, 'Kedungboto'),
(280, 1, 2, 47, 'Kedungcangkring'),
(281, 1, 2, 39, 'Kedungkembar'),
(282, 1, 2, 41, 'Kedungkendo'),
(283, 1, 2, 47, 'Kedungpandan'),
(284, 1, 2, 41, 'Kedungpeluk'),
(285, 1, 2, 33, 'Kedungrawan'),
(286, 1, 2, 47, 'Kedungrejo'),
(287, 1, 2, 46, 'Kedungrejo'),
(288, 1, 2, 42, 'Kedungsolo'),
(289, 1, 2, 39, 'Kedungsugo'),
(290, 1, 2, 35, 'Kedungsukodani'),
(291, 1, 2, 33, 'Kedungsumur'),
(292, 1, 2, 34, 'Kedungturi'),
(293, 1, 2, 39, 'Kedungwonokerto'),
(294, 1, 2, 48, 'Keloposepuluh'),
(295, 1, 2, 35, 'Kemangsen'),
(296, 1, 2, 43, 'Kemantren'),
(297, 1, 2, 32, 'Kemiri'),
(298, 1, 2, 40, 'Kemuning'),
(299, 1, 2, 41, 'Kendalpecabean'),
(300, 1, 2, 40, 'Kendalsewu'),
(301, 1, 2, 43, 'Kenongo'),
(302, 1, 2, 43, 'Kepadangan'),
(303, 1, 2, 43, 'Kepatihan'),
(304, 1, 2, 33, 'Keper'),
(305, 1, 2, 43, 'Kepuhkemiri'),
(306, 1, 2, 46, 'Kepuhkiriman'),
(307, 1, 2, 43, 'Kepunten'),
(308, 1, 2, 33, 'Keret'),
(309, 1, 2, 42, 'Kesambi'),
(310, 1, 2, 44, 'Ketajen'),
(311, 1, 2, 37, 'Ketapang'),
(312, 1, 2, 34, 'Ketegan'),
(313, 1, 2, 37, 'Ketegan'),
(314, 1, 2, 49, 'Ketimang'),
(315, 1, 2, 40, 'Klantingsari'),
(316, 1, 2, 34, 'Kletek'),
(317, 1, 2, 37, 'Kludan'),
(318, 1, 2, 41, 'Klurak'),
(319, 1, 2, 44, 'Kragan'),
(320, 1, 2, 34, 'Kragan'),
(321, 1, 2, 34, 'Kramatjegu'),
(322, 1, 2, 40, 'Kramattemanggung'),
(323, 1, 2, 36, 'Kraton'),
(324, 1, 2, 34, 'Krembangan'),
(325, 1, 2, 33, 'Krembung'),
(326, 1, 2, 47, 'Kupang'),
(327, 1, 2, 46, 'Kureksari'),
(328, 1, 2, 45, 'Kwangsan'),
(329, 1, 2, 42, 'Lajuk'),
(330, 1, 2, 49, 'Lambangan'),
(331, 1, 2, 41, 'Larangan'),
(332, 1, 2, 32, 'Lebo'),
(333, 1, 2, 33, 'Lemujut'),
(334, 1, 2, 48, 'Masangankulon'),
(335, 1, 2, 48, 'Masanganwetan'),
(336, 1, 2, 46, 'Medaeng'),
(337, 1, 2, 43, 'Medalem'),
(338, 1, 2, 40, 'Mergobener'),
(339, 1, 2, 40, 'Mergosari'),
(340, 1, 2, 40, 'Mindugading'),
(341, 1, 2, 40, 'Miriprowo'),
(342, 1, 2, 43, 'Modong'),
(343, 1, 2, 49, 'Mojorangagung'),
(344, 1, 2, 33, 'Mojoruntut'),
(345, 1, 2, 49, 'Mulyodadi'),
(346, 1, 2, 37, 'Ngaban'),
(347, 1, 2, 41, 'Ngampelsari'),
(348, 1, 2, 48, 'Ngaresrejo'),
(349, 1, 2, 34, 'Ngelom'),
(350, 1, 2, 46, 'Ngingas'),
(351, 1, 2, 45, 'Pabean'),
(352, 1, 2, 48, 'Pademonegoro'),
(353, 1, 2, 49, 'Pagerngumbuk'),
(354, 1, 2, 38, 'Pagerwojo'),
(355, 1, 2, 42, 'Pamotan'),
(356, 1, 2, 47, 'Panggreh'),
(357, 1, 2, 43, 'Pangkemiri'),
(358, 1, 2, 48, 'Panjunan'),
(359, 1, 2, 39, 'Pejangkungan'),
(360, 1, 2, 47, 'Pejarakan'),
(361, 1, 2, 48, 'Pekarungan'),
(362, 1, 2, 35, 'Penambangan'),
(363, 1, 2, 37, 'Penatarsewu'),
(364, 1, 2, 45, 'Pepe'),
(365, 1, 2, 47, 'Permisan'),
(366, 1, 2, 34, 'Pertapan Maduretno'),
(367, 1, 2, 42, 'Pesawahan'),
(368, 1, 2, 49, 'Pilang'),
(369, 1, 2, 49, 'Plaosan'),
(370, 1, 2, 33, 'Ploso'),
(371, 1, 2, 49, 'Ploso'),
(372, 1, 2, 42, 'Plumbon'),
(373, 1, 2, 48, 'Plumbungan'),
(374, 1, 2, 36, 'Ponokawan'),
(375, 1, 2, 49, 'Popoh'),
(376, 1, 2, 39, 'Prambon'),
(377, 1, 2, 45, 'Pranti'),
(378, 1, 2, 38, 'Prasung'),
(379, 1, 2, 45, 'Pulungan'),
(380, 1, 2, 44, 'Punggul'),
(381, 1, 2, 37, 'Putat'),
(382, 1, 2, 37, 'Randegan'),
(383, 1, 2, 32, 'Rangka Kidul'),
(384, 1, 2, 33, 'Rejeni'),
(385, 1, 2, 42, 'Reno Kenongo'),
(386, 1, 2, 34, 'Sadang'),
(387, 1, 2, 34, 'Sambibulu'),
(388, 1, 2, 32, 'Sarirogo'),
(389, 1, 2, 44, 'Sawo Tratap'),
(390, 1, 2, 49, 'Sawocangkring'),
(391, 1, 2, 38, 'Sawohan'),
(392, 1, 2, 44, 'Sawotratap'),
(393, 1, 2, 40, 'Sebani'),
(394, 1, 2, 45, 'Sedatiagung'),
(395, 1, 2, 45, 'Sedatigede'),
(396, 1, 2, 36, 'Sedenganmijen'),
(397, 1, 2, 35, 'Seduri'),
(398, 1, 2, 40, 'Segodobancang'),
(399, 1, 2, 45, 'Segorotambak'),
(400, 1, 2, 35, 'Seketi'),
(401, 1, 2, 44, 'Semambang'),
(402, 1, 2, 44, 'Semambung'),
(403, 1, 2, 47, 'Semambung'),
(404, 1, 2, 49, 'Semambung'),
(405, 1, 2, 45, 'Semampir'),
(406, 1, 2, 37, 'Sentul'),
(407, 1, 2, 41, 'Sepande'),
(408, 1, 2, 34, 'Sepanjang'),
(409, 1, 2, 44, 'Seruni'),
(410, 1, 2, 41, 'Sidodadi'),
(411, 1, 2, 34, 'Sidodadi'),
(412, 1, 2, 38, 'Sidokepung'),
(413, 1, 2, 38, 'Sidokerto'),
(414, 1, 2, 36, 'Sidomojo'),
(415, 1, 2, 38, 'Sidomulyo'),
(416, 1, 2, 36, 'Sidomulyo'),
(417, 1, 2, 36, 'Sidorejo'),
(418, 1, 2, 49, 'Simoanginangin'),
(419, 1, 2, 39, 'Simogirang'),
(420, 1, 2, 49, 'Simoketawang'),
(421, 1, 2, 39, 'Simpang'),
(422, 1, 2, 40, 'Singgogalih'),
(423, 1, 2, 35, 'Singkalang'),
(424, 1, 2, 43, 'Singopadu'),
(425, 1, 2, 38, 'Siwalanpanji'),
(426, 1, 2, 44, 'Sruni'),
(427, 1, 2, 43, 'Sudimoro'),
(428, 1, 2, 41, 'Sugihwaras'),
(429, 1, 2, 32, 'Suko'),
(430, 1, 2, 48, 'Sukodono'),
(431, 1, 2, 48, 'Sukolegok'),
(432, 1, 2, 38, 'Sukorejo'),
(433, 1, 2, 49, 'Sumberejo'),
(434, 1, 2, 41, 'Sumokali'),
(435, 1, 2, 35, 'Sumokebangsri'),
(436, 1, 2, 41, 'Sumorame'),
(437, 1, 2, 32, 'Sumput'),
(438, 1, 2, 48, 'Suruh'),
(439, 1, 2, 35, 'Suwaluh'),
(440, 1, 2, 34, 'Taman'),
(441, 1, 2, 45, 'Tambakcemandi'),
(442, 1, 2, 47, 'Tambakkalisogo'),
(443, 1, 2, 46, 'Tambakoso'),
(444, 1, 2, 33, 'Tambakrejo'),
(445, 1, 2, 46, 'Tambaksawah'),
(446, 1, 2, 46, 'Tambaksumur'),
(447, 1, 2, 46, 'Tambarejo'),
(448, 1, 2, 49, 'Tanggul'),
(449, 1, 2, 33, 'Tanjegwagir'),
(450, 1, 2, 40, 'Tarik'),
(451, 1, 2, 34, 'Tawangsari'),
(452, 1, 2, 44, 'Tebel'),
(453, 1, 2, 36, 'Tempel'),
(454, 1, 2, 39, 'Temu'),
(455, 1, 2, 41, 'Tenggulunan'),
(456, 1, 2, 36, 'Terik'),
(457, 1, 2, 36, 'Terungkulon'),
(458, 1, 2, 36, 'Terungwetan'),
(459, 1, 2, 43, 'Tlasih'),
(460, 1, 2, 47, 'Trompoasri'),
(461, 1, 2, 36, 'Tropodo'),
(462, 1, 2, 46, 'Tropodo'),
(463, 1, 2, 34, 'Trosobo'),
(464, 1, 2, 43, 'Tulangan'),
(465, 1, 2, 38, 'Wadungasih'),
(466, 1, 2, 38, 'Wadungasin'),
(467, 1, 2, 46, 'Wadungsari'),
(468, 1, 2, 34, 'Wage'),
(469, 1, 2, 33, 'Wangkal'),
(470, 1, 2, 33, 'Wanomlati'),
(471, 1, 2, 46, 'Waru'),
(472, 1, 2, 35, 'Waruberon'),
(473, 1, 2, 35, 'Watesari'),
(474, 1, 2, 36, 'Watugolong'),
(475, 1, 2, 39, 'Watutulis'),
(476, 1, 2, 33, 'Waung'),
(477, 1, 2, 44, 'Wedi'),
(478, 1, 2, 46, 'Wedoro'),
(479, 1, 2, 41, 'Wedoroklurak'),
(480, 1, 2, 48, 'Wilayut'),
(481, 1, 2, 39, 'Wirobiting'),
(482, 1, 2, 49, 'Wonoayu'),
(483, 1, 2, 34, 'Wonocolo'),
(484, 1, 2, 49, 'Wonokalang'),
(485, 1, 2, 35, 'Wonokarang'),
(486, 1, 2, 49, 'Wonokasihan'),
(487, 1, 2, 35, 'Wonokupang'),
(488, 1, 2, 39, 'Wonoplintahan'),
(489, 1, 2, 42, 'Wunut');

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
(27, 7, '2018-10-20', 'SETUP - KELURAHAN', '2018-10-20'),
(28, 7, '2018-10-20', 'SETUP - DAPIL', NULL),
(29, 7, '2018-10-20', 'SETUP - DPT', NULL),
(30, 7, '2018-10-20', 'SETUP - DAPIL (master) & DPT (detail)', NULL);

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
(42, '2018-10-20 02:38:17', '/simddpt/t94_logedit.php', '1', '*** Batch update successful ***', 't95_logdesc', '', '', '', ''),
(43, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', '*** Batch update begin ***', 't95_logdesc', '', '', '', ''),
(44, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'log_id', '28', '', '7'),
(45, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'desc_', '28', '', 'SETUP - DAPIL'),
(46, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'date_issued', '28', '', '2018-10-20'),
(47, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'date_solved', '28', '', NULL),
(48, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'id', '28', '', '28'),
(49, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'log_id', '29', '', '7'),
(50, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'desc_', '29', '', 'SETUP - DPT'),
(51, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'date_issued', '29', '', '2018-10-20'),
(52, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'date_solved', '29', '', NULL),
(53, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'id', '29', '', '29'),
(54, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'log_id', '30', '', '7'),
(55, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'desc_', '30', '', 'SETUP - DAPIL (master) & DPT (detail)'),
(56, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'date_issued', '30', '', '2018-10-20'),
(57, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'date_solved', '30', '', NULL),
(58, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', 'A', 't95_logdesc', 'id', '30', '', '30'),
(59, '2018-10-20 03:01:21', '/simddpt/t94_logedit.php', '1', '*** Batch update successful ***', 't95_logdesc', '', '', '', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `t03_kelurahan`
--
ALTER TABLE `t03_kelurahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=490;

--
-- AUTO_INCREMENT for table `t94_log`
--
ALTER TABLE `t94_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `t95_logdesc`
--
ALTER TABLE `t95_logdesc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `t96_employees`
--
ALTER TABLE `t96_employees`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t99_audittrail`
--
ALTER TABLE `t99_audittrail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
