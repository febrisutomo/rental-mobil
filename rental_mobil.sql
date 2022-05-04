-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 04, 2022 at 12:51 PM
-- Server version: 5.7.24
-- PHP Version: 8.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental_mobil`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `cekUserMenyewa` (IN `id` INT)   SELECT COUNT(id_transaksi) AS cek FROM tb_transaksi JOIN tb_user ON tb_transaksi.id_user= tb_user.id_user JOIN tb_mobil ON tb_transaksi.id_mobil = tb_mobil.id_mobil WHERE tb_transaksi.id_user = id AND (status = 'dibooking' OR status = 'disewakan')$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `detailLogRental` (IN `id` INT)   SELECT * FROM tb_transaksi JOIN tb_user ON tb_transaksi.id_user= tb_user.id_user JOIN tb_mobil ON tb_transaksi.id_mobil = tb_mobil.id_mobil WHERE (status = 'dikembalikan' OR status = 'dibatalkan') AND id_transaksi =id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `logRental` ()   SELECT * FROM tb_transaksi JOIN tb_user ON tb_transaksi.id_user= tb_user.id_user JOIN tb_mobil ON tb_transaksi.id_mobil = tb_mobil.id_mobil WHERE status = 'dikembalikan' OR status = 'dibatalkan'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `transaksiRental` ()   SELECT id_transaksi, tgl_sewa, tb_transaksi.id_user, nama, nik, alamat, no_hp, tb_transaksi.id_mobil, nama_mobil, transmisi, jml_seat, warna,  durasi, total_harga, tb_transaksi.status FROM tb_transaksi JOIN tb_user ON tb_transaksi.id_user= tb_user.id_user JOIN tb_mobil ON tb_transaksi.id_mobil = tb_mobil.id_mobil WHERE status = 'dibooking' OR status = 'disewakan'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `userActiveRent` (IN `id` INT)   SELECT * FROM tb_transaksi JOIN tb_user ON tb_transaksi.id_user= tb_user.id_user JOIN tb_mobil ON tb_transaksi.id_mobil = tb_mobil.id_mobil WHERE tb_transaksi.id_user = id AND (status = "dibooking" OR status = "disewakan")$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `userLogRent` (IN `id` INT)   SELECT * FROM tb_transaksi JOIN tb_user ON tb_transaksi.id_user= tb_user.id_user JOIN tb_mobil ON tb_transaksi.id_mobil = tb_mobil.id_mobil WHERE tb_transaksi.id_user = id AND status = "dikembalikan" ORDER BY tgl_sewa DESC$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(11) UNSIGNED ZEROFILL NOT NULL,
  `nama` varchar(20) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `nama`, `username`, `password`) VALUES
(00000000001, 'Febri Sutomo', 'admin', '$2y$10$NedAw0uo9mzbDiCXsFqPuOpK7TysssKN6/Fy7xIUjSO4rYzu88iUq'),
(00000000005, 'admin', 'admin123', '$2y$10$47znk2RZHuTFN214Mr3ZAu3eRHYZyFsqCXRJ/pGAfm5yk9To4LnOW');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis`
--

CREATE TABLE `tb_jenis` (
  `id_jenis` int(11) NOT NULL,
  `nama_jenis` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_jenis`
--

INSERT INTO `tb_jenis` (`id_jenis`, `nama_jenis`) VALUES
(1, 'Sedan'),
(2, 'SUV'),
(3, 'MPV');

-- --------------------------------------------------------

--
-- Table structure for table `tb_mobil`
--

CREATE TABLE `tb_mobil` (
  `id_mobil` int(3) UNSIGNED ZEROFILL NOT NULL,
  `nama_mobil` varchar(30) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `transmisi` enum('Manual','Otomatis') NOT NULL,
  `jml_seat` int(2) NOT NULL,
  `warna` varchar(20) NOT NULL,
  `gambar` varchar(50) NOT NULL DEFAULT 'car.png',
  `harga` int(11) NOT NULL,
  `status_mobil` enum('tersedia','dibooking','disewa') NOT NULL DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_mobil`
--

INSERT INTO `tb_mobil` (`id_mobil`, `nama_mobil`, `id_jenis`, `transmisi`, `jml_seat`, `warna`, `gambar`, `harga`, `status_mobil`) VALUES
(001, 'Honda Civic', 1, 'Manual', 5, 'Putih', '60978a9dd1b4f.png', 950, 'tersedia'),
(002, 'Toyota Avanza', 3, 'Otomatis', 7, 'Hitam', 'avanza.png', 350, 'tersedia'),
(003, 'Honda Jazz', 1, 'Otomatis', 5, 'Silver', '60915f68b9266.png', 500, 'tersedia'),
(007, 'Mitsubishi Xpander', 3, 'Manual', 7, 'Putih', '60a1c355471a0.png', 400, 'tersedia'),
(008, 'Mitsubishi Pajero', 2, 'Manual', 7, 'Silver', '60a1c3ab8f2b9.png', 800, 'dibooking'),
(009, 'Honda CR-V', 2, 'Manual', 7, 'Putih', '60a1c4b0da071.png', 400, 'tersedia'),
(010, 'Toyota Alphard', 3, 'Otomatis', 7, 'Putih', '60a1c532bd227.png', 1200, 'tersedia'),
(011, 'Suzuki Ertiga', 3, 'Manual', 7, 'Putih', '60a1c5af713b6.jpeg', 350, 'tersedia'),
(012, 'Nobis sapiente error', 2, 'Manual', 37, 'Magnam incididunt ip', 'car.png', 34, 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id_transaksi` int(3) UNSIGNED ZEROFILL NOT NULL,
  `id_user` int(3) UNSIGNED ZEROFILL NOT NULL,
  `id_mobil` int(3) UNSIGNED ZEROFILL NOT NULL,
  `tgl_sewa` timestamp NOT NULL,
  `durasi` int(11) NOT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `tgl_kembali` timestamp NULL DEFAULT NULL,
  `denda` int(20) DEFAULT NULL,
  `status` enum('dibooking','disewakan','dikembalikan','dibatalkan') NOT NULL DEFAULT 'dibooking'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id_transaksi`, `id_user`, `id_mobil`, `tgl_sewa`, `durasi`, `total_harga`, `tgl_kembali`, `denda`, `status`) VALUES
(012, 001, 001, '2021-05-04 01:16:00', 2, 300, '2021-05-09 06:16:00', 100, 'dikembalikan'),
(014, 001, 003, '2021-05-04 01:16:00', 3, 400, '2021-05-22 13:54:10', 2960, 'dikembalikan'),
(016, 001, 002, '2021-05-04 01:16:00', 2, 400, '2021-05-22 15:39:49', 4460, 'dikembalikan'),
(017, 001, 003, '2020-06-05 11:13:18', 3, 400, '2021-05-05 08:31:14', NULL, 'dikembalikan'),
(025, 004, 001, '2021-05-14 14:17:00', 2, 1900, '2021-05-14 14:27:14', NULL, 'dikembalikan'),
(026, 004, 002, '2021-05-15 15:21:00', 2, 700, '2021-05-14 16:32:26', NULL, 'dikembalikan'),
(027, 004, 007, '2021-05-16 14:27:00', 2, 800, '2021-05-22 15:39:38', 3140, 'dikembalikan'),
(028, 004, 001, '2021-05-21 16:33:00', 4, 3800, '2021-05-22 15:39:35', 1663, 'dikembalikan'),
(029, 004, 002, '2021-05-05 17:18:00', 1, 350, '2021-05-22 15:39:52', 6895, 'dikembalikan'),
(030, 004, 007, '2021-05-04 17:23:00', 1, 400, '2021-05-14 17:20:45', NULL, 'dikembalikan'),
(031, 004, 002, '2021-05-06 15:25:00', 1, 350, '2021-05-22 15:06:25', 6913, 'dikembalikan'),
(032, 010, 010, '2021-05-18 07:31:00', 3, 3600, '2021-05-17 01:39:39', NULL, 'dikembalikan'),
(033, 004, 009, '2021-05-17 01:32:00', 2, 800, '2021-05-20 18:21:47', NULL, 'dikembalikan'),
(034, 010, 003, '2021-05-21 03:42:00', 5, 2500, '2021-05-22 13:52:45', 850, 'dibatalkan'),
(035, 010, 008, '2021-05-19 06:50:00', 3, 2400, '2021-05-22 13:36:24', NULL, 'dikembalikan'),
(036, 010, 001, '2021-05-21 07:18:00', 2, 1900, '2021-05-24 04:45:26', 998, 'dikembalikan'),
(037, 004, 003, '2021-05-21 14:46:00', 3, 1500, '2021-05-22 03:46:25', 0, 'dikembalikan'),
(038, 004, 001, '2021-05-21 05:45:00', 3, 2850, '2021-05-22 15:52:47', 1568, 'dibatalkan'),
(039, 004, 007, '2021-05-24 05:00:03', 2, 800, '2021-05-24 04:36:27', 0, 'dikembalikan'),
(040, 001, 009, '2021-05-20 03:09:00', 4, 1600, '2021-05-22 03:43:25', NULL, 'dikembalikan'),
(041, 001, 010, '2021-05-21 01:51:00', 1, 1200, '2021-05-22 15:52:50', 2040, 'dibatalkan'),
(042, 004, 002, '2021-05-24 01:00:00', 3, 1050, '2021-05-22 15:52:53', 613, 'dibatalkan'),
(043, 004, 002, '2021-05-24 05:42:19', 3, 1050, '2021-05-22 15:39:27', 2695, 'dibatalkan'),
(044, 004, 002, '2021-05-24 03:29:22', 3, 1050, '2021-05-24 04:01:55', 0, 'dikembalikan'),
(045, 004, 009, '2021-05-16 15:54:00', 3, 1200, '2021-05-22 15:54:58', 3120, 'dikembalikan'),
(046, 004, 001, '2021-05-23 05:59:00', 3, 2850, NULL, NULL, 'dibatalkan'),
(047, 004, 002, '2021-05-23 20:17:00', 2, 700, NULL, NULL, 'dibatalkan'),
(048, 004, 003, '2021-05-22 19:56:00', 2, 1000, NULL, NULL, 'dibatalkan'),
(049, 012, 010, '2021-05-23 20:27:00', 3, 3600, NULL, NULL, 'dibatalkan'),
(050, 012, 003, '2021-05-22 21:00:00', 1, 500, NULL, NULL, 'dibatalkan'),
(051, 012, 002, '2021-05-23 17:01:00', 2, 700, NULL, NULL, 'dibatalkan'),
(052, 012, 002, '2021-05-23 16:06:00', 3, 1050, NULL, NULL, 'dibatalkan'),
(053, 012, 003, '2021-05-24 18:34:00', 2, 1000, NULL, NULL, 'dibatalkan'),
(054, 012, 002, '2021-05-24 18:35:00', 2, 700, '2021-05-24 04:36:20', 0, 'dikembalikan'),
(055, 012, 003, '2021-05-22 18:41:00', 2, 1000, '2021-05-23 16:42:11', 550, 'dikembalikan'),
(056, 012, 007, '2021-05-22 18:42:00', 1, 400, '2021-05-24 04:39:55', 180, 'dikembalikan'),
(057, 012, 002, '2021-05-23 22:36:00', 3, 1050, '2021-05-24 04:36:39', 0, 'dikembalikan'),
(058, 012, 007, '2021-05-23 23:40:00', 2, 800, '2021-05-24 04:40:01', 0, 'dikembalikan'),
(059, 012, 003, '2021-05-22 22:41:00', 1, 500, NULL, NULL, 'disewakan'),
(060, 012, 001, '2021-05-18 23:46:00', 1, 950, '2021-05-24 04:40:16', 4750, 'dikembalikan'),
(061, 012, 003, '2021-05-20 23:49:00', 1, 500, '2021-05-24 04:40:08', 1300, 'dikembalikan'),
(062, 012, 008, '2021-05-20 18:50:00', 1, 800, '2021-05-24 04:39:50', 2280, 'dikembalikan'),
(063, 012, 002, '2021-05-22 23:50:00', 1, 350, NULL, NULL, 'dibatalkan'),
(064, 012, 001, '2021-05-21 01:00:00', 1, 950, '2021-05-24 04:39:41', 2423, 'dikembalikan'),
(065, 010, 002, '2021-05-25 07:47:00', 2, 700, NULL, NULL, 'dibatalkan'),
(066, 010, 001, '2021-05-24 05:23:00', 3, 2850, NULL, NULL, 'dibatalkan'),
(067, 004, 008, '2021-07-11 12:24:00', 5, 4000, NULL, NULL, 'dibooking'),
(068, 010, 001, '2021-09-26 23:46:00', 2, 1900, NULL, NULL, 'dibatalkan');

--
-- Triggers `tb_transaksi`
--
DELIMITER $$
CREATE TRIGGER `dibooking` AFTER INSERT ON `tb_transaksi` FOR EACH ROW UPDATE tb_mobil SET status_mobil = "dibooking" WHERE id_mobil = new.id_mobil
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `dibooking2` AFTER UPDATE ON `tb_transaksi` FOR EACH ROW UPDATE tb_mobil SET status_mobil = "dibooking" WHERE id_mobil = new.id_mobil AND new.status="dibooking"
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `disewa` AFTER UPDATE ON `tb_transaksi` FOR EACH ROW UPDATE tb_mobil SET status_mobil = "disewa" WHERE id_mobil = new.id_mobil AND new.status="disewakan"
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tersedia` AFTER UPDATE ON `tb_transaksi` FOR EACH ROW UPDATE tb_mobil SET status_mobil = "tersedia" WHERE id_mobil = new.id_mobil AND (new.status="dikembalikan" OR new.status="dibatalkan")
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(3) UNSIGNED ZEROFILL NOT NULL,
  `nama` varchar(20) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama`, `alamat`, `nik`, `foto`, `no_hp`, `email`, `password`) VALUES
(001, 'Andi Saputra', 'Banyumas', '330210002082001', '60aa6f8ab926d.jpg', '085870005102', 'andi@gmail.com', '$2y$10$NedAw0uo9mzbDiCXsFqPuOpK7TysssKN6/Fy7xIUjSO4rYzu88iUq'),
(004, 'Budi Karyadi', 'Purbalingga', '330210002081992', '60aa6fdfb6fe6.jpg', '081236757274', 'budi@gmail.com', '$2y$10$NedAw0uo9mzbDiCXsFqPuOpK7TysssKN6/Fy7xIUjSO4rYzu88iUq'),
(010, 'Alex Hunter', 'Purwokerto', '330210040021986', '60aa6f49f3774.jpg', '085452324345', 'alex@gmail.com', '$2y$10$MQAskNYAqhVzK4ZIeDuT7.rCUm6H9vgwOrB2SJl8dRq.SubwLdQFu'),
(012, 'Isabella', 'Bandung', '3302283467263748', '60aa7119dfb8e.jpg', '085874722255', 'isabella@gmail.com', '$2y$10$OSuYduanfvJcd97Eoz1oge/s3Qf4UyV1Vm.aXMQavVu3fJKbprLQ2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `tb_mobil`
--
ALTER TABLE `tb_mobil`
  ADD PRIMARY KEY (`id_mobil`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_mobil`
--
ALTER TABLE `tb_mobil`
  MODIFY `id_mobil` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id_transaksi` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
