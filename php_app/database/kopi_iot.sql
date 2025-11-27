-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2025 at 05:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kopi_iot`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `id_pengirim` int(11) DEFAULT NULL,
  `id_penerima` int(11) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `id_pengirim`, `id_penerima`, `pesan`, `created_at`) VALUES
(1, 3, 1, 'halo', '2025-11-21 03:38:13'),
(2, 1, 3, 'haihai', '2025-11-21 03:38:23'),
(3, 1, 3, 'ajdkasdjdakddjad', '2025-11-21 03:40:03'),
(4, 1, 3, 'uoieoi3213u1i2o3', '2025-11-21 03:40:08'),
(5, 3, 1, 'hello world', '2025-11-21 03:43:03'),
(6, 3, 1, '', '2025-11-21 06:01:26'),
(7, 3, 1, '', '2025-11-21 06:01:26'),
(8, 3, 1, '', '2025-11-21 06:01:27'),
(9, 3, 1, '', '2025-11-21 06:01:27'),
(10, 3, 1, 'kajsdhashdkajsdhashdkajsdhashdkajsdhashdkajsdhashdkajsdhashdkajsdhashdkajsdhashdkajsdhashdkajsdhashdkajsdhashd', '2025-11-21 06:01:58'),
(11, 3, 1, 'Halo bang aku mau beli     boleh gak', '2025-11-21 06:31:26'),
(12, 3, 1, 'he setan', '2025-11-21 07:32:57'),
(13, 3, 1, 'naufal homo', '2025-11-21 07:33:22'),
(14, 3, 1, 'haha', '2025-11-21 07:38:41'),
(15, 3, 1, 'aksjksad', '2025-11-21 07:38:42'),
(16, 3, 1, 'asldjaksljdalksjdkjsadjoepqw akdkljq', '2025-11-21 07:38:47'),
(17, 3, 1, 'hello', '2025-11-21 07:46:52'),
(18, 3, 1, 'woiiii', '2025-11-21 07:46:57'),
(19, 3, 1, 'gua mau beli', '2025-11-21 07:47:04'),
(20, 1, 3, 'gak boleh', '2025-11-21 07:55:12'),
(21, 3, 1, 'yang bener aja bang', '2025-11-21 07:57:03'),
(22, 1, 3, 'hehe', '2025-11-21 07:57:13'),
(23, 1, 3, 'woi bang', '2025-11-21 07:59:10'),
(24, 1, 3, 'aku mau beli 1000000', '2025-11-21 07:59:19'),
(25, 1, 3, 'bisa gak', '2025-11-21 07:59:21'),
(26, 3, 1, 'lah', '2025-11-21 07:59:24'),
(27, 3, 1, 'gabisa bro', '2025-11-21 07:59:26'),
(28, 1, 3, 'lawak 😹', '2025-11-21 08:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `waktu_pesanan` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Selesai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_toko`, `id_user`, `waktu_pesanan`, `status`) VALUES
(1, 1, 2, '2025-11-21 02:44:44', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `sensor`
--

CREATE TABLE `sensor` (
  `id_sensor` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `suhu` float DEFAULT NULL,
  `kelembapan` float DEFAULT NULL,
  `volume` float DEFAULT NULL,
  `selesai` int(11) NOT NULL DEFAULT 0,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `prediksi_selesai` varchar(50) DEFAULT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Not Ready','Ready','Empty') NOT NULL DEFAULT 'Not Ready'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sensor`
--

INSERT INTO `sensor` (`id_sensor`, `id_toko`, `suhu`, `kelembapan`, `volume`, `selesai`, `lat`, `lng`, `prediksi_selesai`, `waktu_update`, `status`) VALUES
(1, 1, 28, 60, 10, 0, -7.46711636, 112.72517, '14', '2025-11-20 07:34:06', 'Not Ready'),
(9, 4, NULL, NULL, NULL, 0, -7.466725288204164, 112.72518753997248, NULL, '2025-11-27 02:21:31', 'Empty');

-- --------------------------------------------------------

--
-- Table structure for table `sensor_log`
--

CREATE TABLE `sensor_log` (
  `id_log` int(11) NOT NULL,
  `id_sensor` int(11) NOT NULL,
  `suhu` float NOT NULL,
  `kelembapan` float NOT NULL,
  `volume` float NOT NULL,
  `selesai` int(11) NOT NULL,
  `prediksi_selesai` varchar(50) NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `id_toko` int(11) NOT NULL,
  `id_penjual` int(11) NOT NULL,
  `nama_toko` varchar(50) NOT NULL,
  `deskripsi_toko` text NOT NULL,
  `alamat` text NOT NULL,
  `gambar_toko` varchar(100) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `status_toko` enum('Aktif','Tidak Aktif') NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id_toko`, `id_penjual`, `nama_toko`, `deskripsi_toko`, `alamat`, `gambar_toko`, `lat`, `lng`, `status_toko`) VALUES
(1, 4, 'Kafe Telkom', 'Warkop Warung Kopi adalah warkop yang menjual berbagai macam minuman kopi antar dunia.', 'Jl. Sekardangan Pecantingan Sidoarjo', 'kafe-1.png', -7.466667187804611, 112.72518523989727, 'Aktif'),
(2, 5, 'KAFE WAR', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla et ex vel velit ultrices dignissim ullamcorper sed risus. Nam molestie.', 'Jl. Raya Sedati No. 15', 'kafe-2.jpg', -7.466667187804611, 112.72518523989727, 'Aktif'),
(3, 5, 'WARKOP LINGKAR TIMUR', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam porta dui quis mi auctor hendrerit. Pellentesque libero libero, vulputate quis ligula eu, rutrum laoreet enim.', 'Jalan Veteran, Buduran, Sidoarjo', 'kafe-3.jpg', -7.466667187804611, 112.72518523989727, 'Aktif'),
(4, 7, 'Warkop Gacor', 'gacor kang', 'Jl. Pecantingan, Sekardangan Indah, Sekardangan', '1764210091_penjual.jpeg', -7.466725288204164, 112.72518753997248, 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('driver','penjual','pembeli','admin') NOT NULL DEFAULT 'pembeli'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `role`) VALUES
(1, 'Es Teh Anget', 'estehanget', 'estehanget', 'admin'),
(2, 'Naufal Rafa', 'naufalrafa', 'naufalrafa', 'driver'),
(3, 'Jahfal', 'jahfalazhar', 'jahfalazhar', 'pembeli'),
(4, 'Pak Tani', 'paktani', 'paktani', 'penjual'),
(5, 'Budianto', 'budibudi', 'budibudi', 'penjual'),
(6, 'Saqa Pandega', 'kopihitam', 'kopihitam', 'pembeli'),
(7, 'Gacor Kang', 'gacor', 'gacor', 'penjual');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_penyedia` (`id_toko`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `sensor`
--
ALTER TABLE `sensor`
  ADD PRIMARY KEY (`id_sensor`),
  ADD KEY `sensor_ibfk_1` (`id_toko`);

--
-- Indexes for table `sensor_log`
--
ALTER TABLE `sensor_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_sensor` (`id_sensor`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id_toko`),
  ADD KEY `penyedia_ibfk_1` (`id_penjual`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sensor`
--
ALTER TABLE `sensor`
  MODIFY `id_sensor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sensor_log`
--
ALTER TABLE `sensor_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id_toko`),
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `sensor`
--
ALTER TABLE `sensor`
  ADD CONSTRAINT `sensor_ibfk_1` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id_toko`);

--
-- Constraints for table `sensor_log`
--
ALTER TABLE `sensor_log`
  ADD CONSTRAINT `sensor_log_ibfk_1` FOREIGN KEY (`id_sensor`) REFERENCES `sensor` (`id_sensor`);

--
-- Constraints for table `toko`
--
ALTER TABLE `toko`
  ADD CONSTRAINT `toko_ibfk_1` FOREIGN KEY (`id_penjual`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
