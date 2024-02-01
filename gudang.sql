-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 01, 2024 at 04:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gudang`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` char(128) NOT NULL,
  `nama_barang` varchar(128) NOT NULL,
  `stok_awal` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `stok` int DEFAULT NULL,
  `id_satuan` int NOT NULL,
  `id_jenis` int NOT NULL,
  `image` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `stok_awal`, `stok`, `id_satuan`, `id_jenis`, `image`, `date_add`, `date_update`) VALUES
('98842512301', 'Kardus', '50', 61, 3, 1, '87b3626282b69629fa535c13894bfa98.jpg', '2024-01-24 23:19:48', '2024-01-24 23:19:48'),
('9884251233', 'Chictato Lite Rasa Rumput Laut 68gram', '0', 0, 1, 1, '4667ab5315f9981c0a519ec6ed1c129c.jpg', '2024-01-24 23:37:13', '2024-01-24 23:55:18'),
('B01284328', 'RICHEESE SIIP KEJU 50 GR', '0', 10, 1, 1, 'b81b6d201927aef3b86dfe09b312638a.jpg', '2024-01-24 23:20:51', '2024-01-24 23:20:51');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_bkeluar` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_user` int NOT NULL,
  `barang_id` char(128) NOT NULL,
  `jumlah_keluar` int NOT NULL,
  `tanggal_keluar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_bkeluar`, `id_user`, `barang_id`, `jumlah_keluar`, `tanggal_keluar`) VALUES
('T-BK-240120240001', 18, '98842512301', 21, '2024-01-24');

--
-- Triggers `barang_keluar`
--
DELIMITER $$
CREATE TRIGGER `barang_keluar_delete` BEFORE DELETE ON `barang_keluar` FOR EACH ROW BEGIN
    UPDATE barang
    SET stok = stok + OLD.jumlah_keluar
    WHERE id_barang = OLD.barang_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_stok_keluar` BEFORE INSERT ON `barang_keluar` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - NEW.jumlah_keluar WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_bmasuk` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_supplier` int NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `barang_id` char(128) NOT NULL,
  `jumlah_masuk` int NOT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_bmasuk`, `id_supplier`, `id_user`, `barang_id`, `jumlah_masuk`, `tanggal_masuk`) VALUES
('T-BM-240120240001', 1, '18', '98842512301', 32, '2024-01-24'),
('T-BM-240120240002', 2, '18', 'B01284328', 10, '2024-01-24');

--
-- Triggers `barang_masuk`
--
DELIMITER $$
CREATE TRIGGER `barang_masuk_delete` AFTER DELETE ON `barang_masuk` FOR EACH ROW BEGIN
    UPDATE barang
    SET stok = stok - OLD.jumlah_masuk
    WHERE id_barang = OLD.barang_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_stok_masuk` BEFORE INSERT ON `barang_masuk` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + NEW.jumlah_masuk WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id` int NOT NULL,
  `nama_jenis` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id`, `nama_jenis`) VALUES
(1, 'Snack'),
(2, 'Minuman'),
(4, 'Roti'),
(5, 'Gandum'),
(6, 'Beras');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id` int NOT NULL,
  `nama_satuan` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id`, `nama_satuan`) VALUES
(1, 'Pack'),
(2, 'Botol'),
(3, 'Unit'),
(5, 'Kilog Gram (KG)'),
(6, 'Karung');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int NOT NULL,
  `nama_aplikasi` varchar(128) NOT NULL,
  `nama_perusahaan` varchar(128) NOT NULL,
  `alamat` text NOT NULL,
  `image` varchar(80) NOT NULL,
  `notelpon` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `low_stok` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `nama_aplikasi`, `nama_perusahaan`, `alamat`, `image`, `notelpon`, `email`, `low_stok`) VALUES
(1, 'Sistem Informasi Gudang', 'PT. SANDEMO INDO TEKNOLOGI', 'Palembang, Ulu 2 NO 76', '65706025d80fa.png', '087801751656', 'infosandemo@gmail.com', '3');

-- --------------------------------------------------------

--
-- Table structure for table `suplier`
--

CREATE TABLE `suplier` (
  `id` int NOT NULL,
  `nama_supplier` varchar(128) NOT NULL,
  `nohp` varchar(128) NOT NULL,
  `alamat` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `suplier`
--

INSERT INTO `suplier` (`id`, `nama_supplier`, `nohp`, `alamat`) VALUES
(1, 'Sandi Maulidika', '087801751656', 'Jambi'),
(2, 'Voni', '087801751633', 'Bandung'),
(10, 'Rian', '081271838821', 'Jakarta Selatan');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `role` enum('gudang','admin') NOT NULL,
  `image` varchar(128) NOT NULL,
  `nohp` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `date_created` int NOT NULL,
  `last_change_pw` int NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `role`, `image`, `nohp`, `password`, `date_created`, `last_change_pw`, `is_active`) VALUES
(1, 'Sandi Maulidika', 'sandimaulidika@gmail.com', 'admin', 'default.jpg', '081271838892', '$2y$10$jPtj2JoIn0oH8jaq2txH1.OWH.KsRVZ6OXOLD4IDjKfQM9UO5Wqa2', 1661189930, 1670397987, 1),
(18, 'Administrators', 'admin@gmail.com', 'admin', 'default.jpg', '', '$2y$10$0z4o4Ky//pZDC1oBAkGPFO0uh069t0MK/1q35FpfHWp2Qsf6qOeTa', 1681284332, 0, 1),
(19, 'Voni', 'voni@gmail.com', 'gudang', 'default.jpg', '', '$2y$10$4Y7oaxu0L66c.ZuqytG6h.p/PbSgaF1wqK..aFwvn/BRb7N1da0xu', 1681284644, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_jenis` (`id_jenis`),
  ADD KEY `id_satuan` (`id_satuan`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_bkeluar`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_barang` (`barang_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_bmasuk`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_barang` (`barang_id`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suplier`
--
ALTER TABLE `suplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suplier`
--
ALTER TABLE `suplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`id_jenis`) REFERENCES `jenis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_keluar_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `suplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_3` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
