-- phpMyAdmin SQL Dump

-- version 5.1.1deb5ubuntu1

-- https://www.phpmyadmin.net/

--

-- Host: localhost:3306

-- Generation Time: Nov 27, 2022 at 09:14 AM

-- Server version: 8.0.31-0ubuntu0.22.04.1

-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */

;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */

;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */

;

/*!40101 SET NAMES utf8mb4 */

;

--

-- Database: `gudang`

--

-- --------------------------------------------------------

--

-- Table structure for table `barang`

--

CREATE TABLE
    `barang` (
        `id_barang` char(7) NOT NULL,
        `nama_barang` varchar(128) NOT NULL,
        `stok` int NOT NULL,
        `id_satuan` int NOT NULL,
        `id_jenis` int NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--

-- Dumping data for table `barang`

--

INSERT INTO
    `barang` (
        `id_barang`,
        `nama_barang`,
        `stok`,
        `id_satuan`,
        `id_jenis`
    )
VALUES (
        'B000001',
        'Citatos Rasa New',
        0,
        1,
        1
    ), (
        'B000002',
        'Biskuit Roma',
        0,
        3,
        1
    ), (
        'B000003',
        'Garry Salut',
        0,
        1,
        2
    ), ('B000004', 'Teh Kotak', 0, 2, 2), ('B000005', 'Susu Milo', 0, 2, 2);

-- --------------------------------------------------------

--

-- Table structure for table `barang_keluar`

--

CREATE TABLE
    `barang_keluar` (
        `id_bkeluar` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        `id_user` int NOT NULL,
        `id_barang` char(7) NOT NULL,
        `jumlah_keluar` int NOT NULL,
        `tanggal_keluar` date NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--

-- Table structure for table `barang_masuk`

--

CREATE TABLE
    `barang_masuk` (
        `id_bmasuk` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        `id_supplier` int NOT NULL,
        `id_user` int NOT NULL,
        `barang_id` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        `jumlah_masuk` int NOT NULL,
        `tanggal_masuk` date NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--

-- Dumping data for table `barang_masuk`

--

INSERT INTO
    `barang_masuk` (
        `id_bmasuk`,
        `id_supplier`,
        `id_user`,
        `barang_id`,
        `jumlah_masuk`,
        `tanggal_masuk`
    )
VALUES (
        'T-BM-20111100001',
        1,
        1,
        'B000001',
        5,
        '2022-11-26'
    );

-- --------------------------------------------------------

--

-- Table structure for table `jenis`

--

CREATE TABLE
    `jenis` (
        `id` int NOT NULL,
        `nama_jenis` varchar(128) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--

-- Dumping data for table `jenis`

--

INSERT INTO
    `jenis` (`id`, `nama_jenis`)
VALUES (1, 'Snack'), (2, 'Minuman');

-- --------------------------------------------------------

--

-- Table structure for table `satuan`

--

CREATE TABLE
    `satuan` (
        `id` int NOT NULL,
        `nama_satuan` varchar(128) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--

-- Dumping data for table `satuan`

--

INSERT INTO
    `satuan` (`id`, `nama_satuan`)
VALUES (1, 'Pack'), (2, 'Botol'), (3, 'Unit');

-- --------------------------------------------------------

--

-- Table structure for table `suplier`

--

CREATE TABLE
    `suplier` (
        `id` int NOT NULL,
        `nama_supplier` varchar(128) NOT NULL,
        `nohp` varchar(128) NOT NULL,
        `alamat` varchar(225) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--

-- Dumping data for table `suplier`

--

INSERT INTO
    `suplier` (
        `id`,
        `nama_supplier`,
        `nohp`,
        `alamat`
    )
VALUES (
        1,
        'Sandi Maulidika',
        '087801751656',
        'Palembang, Muara Enim'
    );

-- --------------------------------------------------------

--

-- Table structure for table `user`

--

CREATE TABLE
    `user` (
        `id` int NOT NULL,
        `name` varchar(128) NOT NULL,
        `email` varchar(128) NOT NULL,
        `role` enum('gudang', 'admin') NOT NULL,
        `image` varchar(128) NOT NULL,
        `password` varchar(225) NOT NULL,
        `date_created` int NOT NULL,
        `last_change_pw` int NOT NULL,
        `is_active` tinyint(1) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--

-- Dumping data for table `user`

--

INSERT INTO
    `user` (
        `id`,
        `name`,
        `email`,
        `role`,
        `image`,
        `password`,
        `date_created`,
        `last_change_pw`,
        `is_active`
    )
VALUES (
        1,
        'Sandi Maulidika',
        'sandimaulidika@gmail.com',
        'admin',
        'SanSan.jpg',
        '$2y$10$L8tdxLF2Ol76VWGz3AObEeosDlOIhNPfVbY0K0ft/bOI0kBIb5b9.',
        1661189930,
        1661189930,
        1
    );

--

-- Indexes for dumped tables

--

--

-- Indexes for table `barang`

--

ALTER TABLE `barang`
ADD
    PRIMARY KEY (`id_barang`),
ADD
    KEY `id_jenis` (`id_jenis`),
ADD
    KEY `id_satuan` (`id_satuan`);

--

-- Indexes for table `barang_keluar`

--

ALTER TABLE `barang_keluar`
ADD
    PRIMARY KEY (`id_bkeluar`),
ADD
    KEY `id_user` (`id_user`),
ADD
    KEY `id_barang` (`id_barang`);

--

-- Indexes for table `barang_masuk`

--

ALTER TABLE `barang_masuk`
ADD
    PRIMARY KEY (`id_bmasuk`),
ADD
    KEY `id_supplier` (`id_supplier`),
ADD
    KEY `id_user` (`id_user`),
ADD
    KEY `id_barang` (`barang_id`);

--

-- Indexes for table `jenis`

--

ALTER TABLE `jenis` ADD PRIMARY KEY (`id`);

--

-- Indexes for table `satuan`

--

ALTER TABLE `satuan` ADD PRIMARY KEY (`id`);

--

-- Indexes for table `suplier`

--

ALTER TABLE `suplier` ADD PRIMARY KEY (`id`);

--

-- Indexes for table `user`

--

ALTER TABLE `user` ADD PRIMARY KEY (`id`);

--

-- AUTO_INCREMENT for dumped tables

--

--

-- AUTO_INCREMENT for table `jenis`

--

ALTER TABLE
    `jenis` MODIFY `id` int NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--

-- AUTO_INCREMENT for table `satuan`

--

ALTER TABLE
    `satuan` MODIFY `id` int NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 5;

--

-- AUTO_INCREMENT for table `suplier`

--

ALTER TABLE
    `suplier` MODIFY `id` int NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 9;

--

-- AUTO_INCREMENT for table `user`

--

ALTER TABLE
    `user` MODIFY `id` int NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 8;

--

-- Constraints for dumped tables

--

--

-- Constraints for table `barang`

--

ALTER TABLE `barang`
ADD
    CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
    CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`id_jenis`) REFERENCES `jenis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--

-- Constraints for table `barang_keluar`

--

ALTER TABLE `barang_keluar`
ADD
    CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
    CONSTRAINT `barang_keluar_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--

-- Constraints for table `barang_masuk`

--

ALTER TABLE `barang_masuk`
ADD
    CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
    CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `suplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
    CONSTRAINT `barang_masuk_ibfk_3` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */

;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */

;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */

;