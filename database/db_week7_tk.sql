-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 02, 2026 at 01:44 PM
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
-- Database: `db_week7_tk`
--

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `npm` varchar(11) NOT NULL,
  `divisi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `angkatan` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `nama`, `npm`, `divisi`, `angkatan`) VALUES
(1, 'Sandhika Galih', '5240411001', 'AI Developer', '2024'),
(2, 'Daniel Baskara Putra', '5240411002', 'Bussiness Development', '2024'),
(3, 'Brigitta Sriulina Beru', '5240411003', 'Content Marketing', '2024'),
(4, 'Akhdiyat Duta Modjo', '5240411004', 'Graphic Design', '2001'),
(5, 'Feby Putri Nilam', '5240411005', 'UI/UX', '2002'),
(6, 'Fiersa Besari', '5230411006', 'Frontend Develoepr', '2002'),
(7, 'Theresia Margaretha Gultom', '5230411007', 'Backend Developer', '2023');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`) VALUES
(1, 'Sosok Admin', 'admin@mail.com', '$2y$10$fMf7R8S1FUoBqxVKqeE6weqK7sceZ0S/dEFi56WhAQS0Pyfst4.ku'),
(2, 'Sosok Staff', 'staff@mail.com', '$2y$10$iDO6jI4HGUCXNvkUEmj5kuoO7COztLt7LiN2M0DS260JtQtCNEO/u'),
(3, 'Sosok Member', 'member@mail.com', '$2y$10$1lqlKCrSGu9AJ3wVJgYSGu6Hs5dcBUrJgKruGy46SpBpVrlpcwLjy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `member`
--
ALTER TABLE `member`
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
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
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
