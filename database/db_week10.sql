-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 05, 2026 at 07:08 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_week9`
--

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `npm` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `prodi` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `angkatan` varchar(5) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `nama`, `npm`, `prodi`, `angkatan`) VALUES
(1, 'Sandhika Galih', '5240411001', 'Informatika', '2024'),
(2, 'Daniel Baskara Putra', '5240411002', 'Ilmu Komunikasi', '2024'),
(3, 'Brigitta Sriulina Beru', '5240411003', 'Sastra Inggris', '2024'),
(4, 'Akhdiyat Duta Modjo', '5240411004', 'Mekanisasi Pertanian', '2001'),
(5, 'Feby Putri Nilam', '5240411005', 'Ilmu Hubungan Internasional', '2002'),
(6, 'Fiersa Besari', '5230411006', 'Sarjana Sastra', '2002'),
(7, 'Theresia Margaretha Gultom', '5230411007', 'Psikologi', '2023');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(12) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `email`, `password`) VALUES
(1, 'Sosok Admin', 'adminuty', 'admin@mail.com', '$2y$10$fMf7R8S1FUoBqxVKqeE6weqK7sceZ0S/dEFi56WhAQS0Pyfst4.ku'),
(2, 'Sosok Staff', 'staffuty', 'staff@mail.com', '$2y$10$iDO6jI4HGUCXNvkUEmj5kuoO7COztLt7LiN2M0DS260JtQtCNEO/u'),
(3, 'Sosok Member', 'memberuty', 'member@mail.com', '$2y$10$1lqlKCrSGu9AJ3wVJgYSGu6Hs5dcBUrJgKruGy46SpBpVrlpcwLjy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student`
--
ALTER TABLE `student`
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
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
