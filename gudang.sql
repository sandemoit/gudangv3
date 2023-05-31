-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 31 Bulan Mei 2023 pada 12.05
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gudang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` char(7) NOT NULL,
  `nama_barang` varchar(128) NOT NULL,
  `stok` int NOT NULL,
  `harga` varchar(128) NOT NULL,
  `id_satuan` int NOT NULL,
  `id_jenis` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `stok`, `harga`, `id_satuan`, `id_jenis`) VALUES
('B000001', 'Citatos Rasa New', 2, '50000', 1, 1),
('B000002', 'Biskuit Roma', 30, '50000', 3, 1),
('B000003', 'Garry Salut', 57, '50000', 1, 2),
('B000004', 'Teh Kotak', 90, '50000', 2, 2),
('B000005', 'Susu Milo', 66, '50000', 2, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_bkeluar` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_user` int NOT NULL,
  `barang_id` char(7) NOT NULL,
  `jumlah_keluar` int NOT NULL,
  `tanggal_keluar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_bkeluar`, `id_user`, `barang_id`, `jumlah_keluar`, `tanggal_keluar`) VALUES
('T-BK-110420230001', 1, 'B000002', 10, '2023-04-11'),
('T-BK-120420230001', 1, 'B000001', 48, '2023-04-12'),
('T-BK-120420230002', 19, 'B000003', 13, '2023-04-12'),
('T-BK-130420230001', 1, 'B000005', 34, '2023-04-13');

--
-- Trigger `barang_keluar`
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
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_bmasuk` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_supplier` int NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `jumlah_masuk` int NOT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_bmasuk`, `id_supplier`, `id_user`, `barang_id`, `jumlah_masuk`, `tanggal_masuk`) VALUES
('T-BM-110420230001', 1, 'Sandi Maulidika', 'B000001', 50, '2023-04-11'),
('T-BM-110420230003', 1, 'Sandi Maulidika', 'B000005', 100, '2023-04-11'),
('T-BM-110420230004', 2, 'Sandi Maulidika', 'B000002', 40, '2023-04-11'),
('T-BM-110420230005', 1, 'Sandi Maulidika', 'B000004', 90, '2023-04-11'),
('T-BM-110420230006', 2, 'Sandi Maulidika', 'B000003', 70, '2023-04-11');

--
-- Trigger `barang_masuk`
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
-- Struktur dari tabel `jenis`
--

CREATE TABLE `jenis` (
  `id` int NOT NULL,
  `nama_jenis` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `jenis`
--

INSERT INTO `jenis` (`id`, `nama_jenis`) VALUES
(1, 'Snack'),
(2, 'Minuman');

-- --------------------------------------------------------

--
-- Struktur dari tabel `last_login`
--

CREATE TABLE `last_login` (
  `id` int NOT NULL,
  `browser` varchar(100) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Gudang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan`
--

CREATE TABLE `satuan` (
  `id` int NOT NULL,
  `nama_satuan` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `satuan`
--

INSERT INTO `satuan` (`id`, `nama_satuan`) VALUES
(1, 'Pack'),
(2, 'Botol'),
(3, 'Unit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `setting`
--

INSERT INTO `setting` (`id`, `nama_aplikasi`, `nama_perusahaan`, `alamat`, `image`, `notelpon`, `email`, `low_stok`) VALUES
(1, 'Aplikasi Pengadaan Barang', 'PT. SANDEMO INDO TEKNOLOGI', 'Palembang, Ulu 2 NO 76', '436b05b78d11b87924589ce1cad6998f.png', '087801751656', 'infosandemo@gmail.com', '3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suplier`
--

CREATE TABLE `suplier` (
  `id` int NOT NULL,
  `nama_supplier` varchar(128) NOT NULL,
  `nohp` varchar(128) NOT NULL,
  `alamat` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `suplier`
--

INSERT INTO `suplier` (`id`, `nama_supplier`, `nohp`, `alamat`) VALUES
(1, 'Sandi Maulidika', '087801751656', 'Jambi'),
(2, 'Voni', '087801751633', 'Bandung'),
(10, 'Rian', '081271838821', 'Jakarta Selatan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `role`, `image`, `nohp`, `password`, `date_created`, `last_change_pw`, `is_active`) VALUES
(1, 'Sandi Maulidika', 'sandimaulidika@gmail.com', 'admin', 'default.jpg', '081271838892', '$2y$10$jPtj2JoIn0oH8jaq2txH1.OWH.KsRVZ6OXOLD4IDjKfQM9UO5Wqa2', 1661189930, 1670397987, 1),
(18, 'Administrators', 'admin@gmail.com', 'admin', 'default.jpg', '', '$2y$10$0z4o4Ky//pZDC1oBAkGPFO0uh069t0MK/1q35FpfHWp2Qsf6qOeTa', 1681284332, 0, 1),
(19, 'Voni', 'voni@gmail.com', 'gudang', 'default.jpg', '', '$2y$10$4Y7oaxu0L66c.ZuqytG6h.p/PbSgaF1wqK..aFwvn/BRb7N1da0xu', 1681284644, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_jenis` (`id_jenis`),
  ADD KEY `id_satuan` (`id_satuan`);

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_bkeluar`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_barang` (`barang_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_bmasuk`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_barang` (`barang_id`);

--
-- Indeks untuk tabel `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `last_login`
--
ALTER TABLE `last_login`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `suplier`
--
ALTER TABLE `suplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `last_login`
--
ALTER TABLE `last_login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `suplier`
--
ALTER TABLE `suplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`id_jenis`) REFERENCES `jenis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_keluar_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `suplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_3` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
