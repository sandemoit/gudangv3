SET foreign_key_checks = 0;
#
# TABLE STRUCTURE FOR: barang
#

DROP TABLE IF EXISTS `barang`;

CREATE TABLE `barang` (
  `id_barang` char(7) NOT NULL,
  `nama_barang` varchar(128) NOT NULL,
  `stok` int NOT NULL,
  `harga` varchar(128) NOT NULL,
  `id_satuan` int NOT NULL,
  `id_jenis` int NOT NULL,
  PRIMARY KEY (`id_barang`),
  KEY `id_jenis` (`id_jenis`),
  KEY `id_satuan` (`id_satuan`),
  CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`id_jenis`) REFERENCES `jenis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `barang` (`id_barang`, `nama_barang`, `stok`, `harga`, `id_satuan`, `id_jenis`) VALUES ('B000001', 'Citatos Rasa New', 2, '50000', 1, 1);
INSERT INTO `barang` (`id_barang`, `nama_barang`, `stok`, `harga`, `id_satuan`, `id_jenis`) VALUES ('B000002', 'Biskuit Roma', 30, '50000', 3, 1);
INSERT INTO `barang` (`id_barang`, `nama_barang`, `stok`, `harga`, `id_satuan`, `id_jenis`) VALUES ('B000003', 'Garry Salut', 57, '50000', 1, 2);
INSERT INTO `barang` (`id_barang`, `nama_barang`, `stok`, `harga`, `id_satuan`, `id_jenis`) VALUES ('B000004', 'Teh Kotak', 90, '50000', 2, 2);
INSERT INTO `barang` (`id_barang`, `nama_barang`, `stok`, `harga`, `id_satuan`, `id_jenis`) VALUES ('B000005', 'Susu Milo', 100, '50000', 2, 2);


#
# TABLE STRUCTURE FOR: barang_keluar
#

DROP TABLE IF EXISTS `barang_keluar`;

CREATE TABLE `barang_keluar` (
  `id_bkeluar` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_user` int NOT NULL,
  `barang_id` char(7) NOT NULL,
  `jumlah_keluar` int NOT NULL,
  `tanggal_keluar` date NOT NULL,
  PRIMARY KEY (`id_bkeluar`),
  KEY `id_user` (`id_user`),
  KEY `id_barang` (`barang_id`),
  KEY `barang_id` (`barang_id`),
  CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `barang_keluar_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `barang_keluar` (`id_bkeluar`, `id_user`, `barang_id`, `jumlah_keluar`, `tanggal_keluar`) VALUES ('T-BK-110420230001', 1, 'B000002', 10, '2023-04-11');
INSERT INTO `barang_keluar` (`id_bkeluar`, `id_user`, `barang_id`, `jumlah_keluar`, `tanggal_keluar`) VALUES ('T-BK-120420230001', 1, 'B000001', 48, '2023-04-12');
INSERT INTO `barang_keluar` (`id_bkeluar`, `id_user`, `barang_id`, `jumlah_keluar`, `tanggal_keluar`) VALUES ('T-BK-120420230002', 19, 'B000003', 13, '2023-04-12');


#
# TABLE STRUCTURE FOR: barang_masuk
#

DROP TABLE IF EXISTS `barang_masuk`;

CREATE TABLE `barang_masuk` (
  `id_bmasuk` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_supplier` int NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `jumlah_masuk` int NOT NULL,
  `tanggal_masuk` date NOT NULL,
  PRIMARY KEY (`id_bmasuk`),
  KEY `id_supplier` (`id_supplier`),
  KEY `id_barang` (`barang_id`),
  CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `suplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `barang_masuk_ibfk_3` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `barang_masuk` (`id_bmasuk`, `id_supplier`, `id_user`, `barang_id`, `jumlah_masuk`, `tanggal_masuk`) VALUES ('T-BM-110420230001', 1, 'Sandi Maulidika', 'B000001', 50, '2023-04-11');
INSERT INTO `barang_masuk` (`id_bmasuk`, `id_supplier`, `id_user`, `barang_id`, `jumlah_masuk`, `tanggal_masuk`) VALUES ('T-BM-110420230003', 1, 'Sandi Maulidika', 'B000005', 100, '2023-04-11');
INSERT INTO `barang_masuk` (`id_bmasuk`, `id_supplier`, `id_user`, `barang_id`, `jumlah_masuk`, `tanggal_masuk`) VALUES ('T-BM-110420230004', 2, 'Sandi Maulidika', 'B000002', 40, '2023-04-11');
INSERT INTO `barang_masuk` (`id_bmasuk`, `id_supplier`, `id_user`, `barang_id`, `jumlah_masuk`, `tanggal_masuk`) VALUES ('T-BM-110420230005', 1, 'Sandi Maulidika', 'B000004', 90, '2023-04-11');
INSERT INTO `barang_masuk` (`id_bmasuk`, `id_supplier`, `id_user`, `barang_id`, `jumlah_masuk`, `tanggal_masuk`) VALUES ('T-BM-110420230006', 2, 'Sandi Maulidika', 'B000003', 70, '2023-04-11');


#
# TABLE STRUCTURE FOR: jenis
#

DROP TABLE IF EXISTS `jenis`;

CREATE TABLE `jenis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `jenis` (`id`, `nama_jenis`) VALUES (1, 'Snack');
INSERT INTO `jenis` (`id`, `nama_jenis`) VALUES (2, 'Minuman');


#
# TABLE STRUCTURE FOR: last_login
#

DROP TABLE IF EXISTS `last_login`;

CREATE TABLE `last_login` (
  `id` int NOT NULL AUTO_INCREMENT,
  `browser` varchar(100) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

#
# TABLE STRUCTURE FOR: role
#

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `role` (`id`, `role`) VALUES (1, 'Admin');
INSERT INTO `role` (`id`, `role`) VALUES (2, 'Gudang');


#
# TABLE STRUCTURE FOR: satuan
#

DROP TABLE IF EXISTS `satuan`;

CREATE TABLE `satuan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `satuan` (`id`, `nama_satuan`) VALUES (1, 'Pack');
INSERT INTO `satuan` (`id`, `nama_satuan`) VALUES (2, 'Botol');
INSERT INTO `satuan` (`id`, `nama_satuan`) VALUES (3, 'Unit');


#
# TABLE STRUCTURE FOR: setting
#

DROP TABLE IF EXISTS `setting`;

CREATE TABLE `setting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_aplikasi` varchar(128) NOT NULL,
  `nama_perusahaan` varchar(128) NOT NULL,
  `alamat` text NOT NULL,
  `image` varchar(80) NOT NULL,
  `notelpon` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `low_stok` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `setting` (`id`, `nama_aplikasi`, `nama_perusahaan`, `alamat`, `image`, `notelpon`, `email`, `low_stok`) VALUES (1, 'Aplikasi Stok Barang', 'CV. SANDEMO', 'Palembang, Ulu 2 NO 76', '436b05b78d11b87924589ce1cad6998f.png', '087801751656', 'infosandemo@gmail.com', '3');


#
# TABLE STRUCTURE FOR: suplier
#

DROP TABLE IF EXISTS `suplier`;

CREATE TABLE `suplier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(128) NOT NULL,
  `nohp` varchar(128) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `suplier` (`id`, `nama_supplier`, `nohp`, `alamat`) VALUES (1, 'Sandi Maulidika', '087801751656', 'Jambi');
INSERT INTO `suplier` (`id`, `nama_supplier`, `nohp`, `alamat`) VALUES (2, 'Voni', '087801751633', 'Bandung');
INSERT INTO `suplier` (`id`, `nama_supplier`, `nohp`, `alamat`) VALUES (10, 'Rian', '081271838821', 'Jakarta Selatan');


#
# TABLE STRUCTURE FOR: user
#

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `role` enum('gudang','admin') NOT NULL,
  `image` varchar(128) NOT NULL,
  `nohp` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `date_created` int NOT NULL,
  `last_change_pw` int NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `user` (`id`, `name`, `email`, `role`, `image`, `nohp`, `password`, `date_created`, `last_change_pw`, `is_active`) VALUES (1, 'Sandi Maulidika', 'sandimaulidika@gmail.com', 'admin', 'default.jpg', '081271838892', '$2y$10$jPtj2JoIn0oH8jaq2txH1.OWH.KsRVZ6OXOLD4IDjKfQM9UO5Wqa2', 1661189930, 1670397987, 1);
INSERT INTO `user` (`id`, `name`, `email`, `role`, `image`, `nohp`, `password`, `date_created`, `last_change_pw`, `is_active`) VALUES (18, 'Administrators', 'admin@gmail.com', 'admin', 'default.jpg', '', '$2y$10$0z4o4Ky//pZDC1oBAkGPFO0uh069t0MK/1q35FpfHWp2Qsf6qOeTa', 1681284332, 0, 1);
INSERT INTO `user` (`id`, `name`, `email`, `role`, `image`, `nohp`, `password`, `date_created`, `last_change_pw`, `is_active`) VALUES (19, 'Voni', 'voni@gmail.com', 'gudang', 'default.jpg', '', '$2y$10$4Y7oaxu0L66c.ZuqytG6h.p/PbSgaF1wqK..aFwvn/BRb7N1da0xu', 1681284644, 0, 1);


SET foreign_key_checks = 1;
