-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2025 at 01:31 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kepegawaian`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_pegawai` (IN `p_nama` VARCHAR(100), IN `p_email` VARCHAR(100), IN `p_no_hp` VARCHAR(15), IN `p_alamat` TEXT, IN `p_tanggal_lahir` DATE, IN `p_id_jabatan` INT)   BEGIN
    INSERT INTO pegawai (nama, email, no_hp, alamat, tanggal_lahir, id_jabatan)
    VALUES (p_nama, p_email, p_no_hp, p_alamat, p_tanggal_lahir, p_id_jabatan);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `gaji` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`, `gaji`) VALUES
(1, 'Manager', 10000000.00),
(2, 'Supervisor', 7500000.00),
(3, 'Staff', 5000000.00),
(4, 'Administrasi', 4500000.00),
(5, 'Keuangan', 6000000.00),
(6, 'HRD', 7000000.00);

--
-- Triggers `jabatan`
--
DELIMITER $$
CREATE TRIGGER `hapus_pegawai_setelah_jabatan_dihapus` AFTER DELETE ON `jabatan` FOR EACH ROW BEGIN
    DELETE FROM pegawai WHERE id_jabatan = OLD.id_jabatan;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `tanggal_lahir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nama`, `email`, `no_hp`, `alamat`, `id_jabatan`, `tanggal_lahir`) VALUES
(6, 'asep surasep', 'asep@gmail.com', '0812120975634', 'Jl. Merdeka No.2, Braga, Kec. Sumur Bandung, Kota Bandung, Jawa Barat 40111\r\n', 3, '1989-07-07'),
(7, 'Adam Husein', 'adamh@gmail.com', '0882734675476', 'Faqra Facing Auberge de Faqra entrance, Faqra, Lebanon\r\n', 1, '1997-06-18'),
(8, 'John Doe', 'john@gmail.com', '0826374625389', '108 Tribute St E, Riverton WA 6148, Australia\r\n', 2, '2002-07-25');

--
-- Triggers `pegawai`
--
DELIMITER $$
CREATE TRIGGER `cek_umur_pegawai` BEFORE INSERT ON `pegawai` FOR EACH ROW BEGIN
    DECLARE umur INT;
    
    SET umur = TIMESTAMPDIFF(YEAR, NEW.tanggal_lahir, CURDATE());
    
    IF umur < 18 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Pegawai harus berusia minimal 18 tahun!';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cek_umur_update` BEFORE UPDATE ON `pegawai` FOR EACH ROW BEGIN
    IF TIMESTAMPDIFF(YEAR, NEW.tanggal_lahir, CURDATE()) < 18 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Pegawai harus berusia minimal 18 tahun!';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pegawai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `role`) VALUES
(2, 'admin', 'admin@gmail.com', '$2y$10$cvU3eTkyjyV55QUtfJWqt.MF241Kk8jtG27osM6/HdzoThQL/cJlG', 'admin'),
(5, 'asep', 'asep@gmail.com', '$2y$10$5LyWBTO5AcU0jSr3XUvDkOu/qqEXmrSs3FYpoNFOY6BmCjqUmklOe', 'pegawai'),
(6, 'Adam Husein', 'adamh@gmail.com', '$2y$10$waZlGbYliiPZ6LBOiCr8tOwTjuQklUcTbbCNNb8w1MwHzERNjuvMq', 'pegawai'),
(7, 'John Doe', 'john@gmail.com', '$2y$10$GbKy8p3gh0KHRF8jVBp4Ge.CoUWv9dpa.7w5mFvTT/33juMGxj7me', 'pegawai');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
