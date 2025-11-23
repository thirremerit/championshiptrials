-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 02:08 PM
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
-- Database: `citycare`
--

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('Pending','In Progress','Resolved') NOT NULL DEFAULT 'Pending',
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reported_by` varchar(50) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `lat` decimal(10,7) DEFAULT NULL,
  `lng` decimal(10,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`id`, `title`, `description`, `category`, `location`, `photo`, `status`, `user_id`, `created_at`, `reported_by`, `latitude`, `longitude`, `lat`, `lng`) VALUES
(1, 'pothole', 'its a pothole', 'Pothole', 'street', '', 'Pending', 1, '2025-11-22 10:50:16', NULL, NULL, NULL, NULL, NULL),
(2, 'road damage', 'the road is damaged', 'Road Damage', 'street', '', 'Resolved', 1, '2025-11-22 13:02:06', NULL, NULL, NULL, NULL, NULL),
(3, 'garbage', 'theres to much garbage', 'Trash', 'park', '', 'Pending', 3, '2025-11-22 13:43:42', NULL, NULL, NULL, NULL, NULL),
(4, 'cgn', 'gnf', 'Pothole', 'gcn', '', 'In Progress', 3, '2025-11-22 13:47:20', NULL, NULL, NULL, NULL, NULL),
(5, 'ng ', 'jh', 'Pothole', 'gc', '', 'In Progress', 1, '2025-11-22 13:48:32', NULL, NULL, NULL, NULL, NULL),
(6, 'pothole', 'its a pot hole', 'Pothole', 'street', '', 'Resolved', 5, '2025-11-22 14:08:58', NULL, NULL, NULL, NULL, NULL),
(7, 'pot hole', 'its a pothole', 'Pothole', 'look at the map', '', 'Pending', 3, '2025-11-23 09:58:55', NULL, NULL, NULL, NULL, NULL),
(8, 'btoken light', 'its a broken light', 'Broken Light', 'map', '', 'Pending', 3, '2025-11-23 10:03:08', NULL, NULL, NULL, NULL, NULL),
(9, 'trash', 'its trash', 'Pothole', 'look at the map', NULL, 'Pending', 3, '2025-11-23 10:31:48', NULL, NULL, NULL, NULL, NULL),
(10, 'trash', 'its trash', 'Trash', 'look at the map', NULL, 'Pending', 3, '2025-11-23 10:32:49', NULL, NULL, NULL, NULL, NULL),
(11, 'idk', 'idk', 'Other', 'idk', NULL, 'Pending', 3, '2025-11-23 10:38:47', NULL, NULL, NULL, NULL, NULL),
(12, 'pls', 'pls', 'Other', 'pls', NULL, 'Pending', 3, '2025-11-23 10:40:03', NULL, NULL, NULL, NULL, NULL),
(13, 'pls work', 'pls work', 'Other', 'hopefully on the map', NULL, 'Pending', 3, '2025-11-23 10:43:35', NULL, NULL, NULL, NULL, NULL),
(14, 'hee', 'hee', 'Other', 'hee', NULL, 'Pending', 3, '2025-11-23 10:46:00', NULL, NULL, NULL, NULL, NULL),
(15, 'pothole', 'its a pothole', 'Pothole', 'in new york', NULL, 'Pending', 3, '2025-11-23 10:46:56', NULL, NULL, NULL, NULL, NULL),
(16, 'q', 'q', 'Other', 'q', NULL, 'Pending', 3, '2025-11-23 10:49:43', NULL, NULL, NULL, NULL, NULL),
(17, 'e', 'e', 'Other', 'e', NULL, 'Pending', 3, '2025-11-23 10:52:06', NULL, NULL, NULL, NULL, NULL),
(18, 'qwerty', 'qwerty', 'Pothole', 'qwert', NULL, 'Pending', 3, '2025-11-23 10:53:11', NULL, NULL, NULL, NULL, NULL),
(19, 'opi', 'opi', 'Road Damage', 'opi', NULL, 'Pending', 3, '2025-11-23 10:56:05', NULL, NULL, NULL, NULL, NULL),
(20, 'wert', 'e', 'Pothole', 'e', NULL, 'Pending', 3, '2025-11-23 11:38:32', NULL, NULL, NULL, NULL, NULL),
(21, 'wert', 'wert', 'Other', 'wert', NULL, 'Pending', 3, '2025-11-23 11:40:11', NULL, NULL, NULL, NULL, NULL),
(22, 'poiuytrewq', 'w', 'Pothole', 'w', NULL, 'Pending', 3, '2025-11-23 11:41:22', NULL, NULL, NULL, NULL, NULL),
(23, 'mnb', 'mnb', 'Pothole', 'mnb', NULL, 'Pending', 3, '2025-11-23 11:42:39', NULL, NULL, NULL, NULL, NULL),
(24, 'tire', 'tire', 'Other', 'tire', NULL, 'Pending', 3, '2025-11-23 11:47:27', NULL, NULL, NULL, NULL, NULL),
(25, 'asdf', 'a', 'Pothole', 'a', NULL, 'Pending', 3, '2025-11-23 12:18:50', NULL, NULL, NULL, NULL, NULL),
(26, 'asdfg', 'a', 'Pothole', 'a', NULL, 'Pending', 3, '2025-11-23 12:24:56', NULL, NULL, NULL, NULL, NULL),
(27, 'zxc', 'z', 'Pothole', 'z', NULL, 'Pending', 3, '2025-11-23 12:29:24', NULL, NULL, NULL, 36.6243454, -97.7343750),
(28, 'zxcv', 'z', 'Pothole', 'z', NULL, 'Pending', 3, '2025-11-23 12:30:18', NULL, NULL, NULL, -29.4778612, 130.0781250),
(29, 'zxcvb', 'z', 'Pothole', 'z', NULL, 'Pending', 3, '2025-11-23 12:34:43', NULL, NULL, NULL, 41.3453711, -75.6518555),
(30, 'zxcvbn', 'z', 'Pothole', 'z', NULL, 'Pending', 3, '2025-11-23 12:40:45', NULL, NULL, NULL, 42.6677954, -73.6743164),
(31, 'zxcvbnm', 'z', 'Pothole', 'z', NULL, 'Pending', 3, '2025-11-23 12:41:44', NULL, NULL, NULL, 40.5546023, -74.7344971),
(32, 'asdfghjkl', 'a', 'Pothole', 'a', NULL, 'Pending', 3, '2025-11-23 12:58:22', NULL, NULL, NULL, 47.5820840, -99.8437500);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('citizen','worker') NOT NULL DEFAULT 'citizen',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'dude', 'dude@email.com', '$2y$10$9kxb4H8sQCFDoiB4qjA2DOTxRqiEkRgg0S4lz.nKf2HW2O3WoJCNy', 'citizen', '2025-11-22 10:49:50'),
(2, 'guy', 'guy@email.com', '$2y$10$F5/Q5UjbsuTT3xBmndgSYe03rU5RgQ7pmiQ4jp1i8g/SPrNdwrBBe', 'worker', '2025-11-22 10:54:59'),
(3, 'gov', 'gov@email.com', '$2y$10$1U2i3nT/XTAjBDLv3w0TsOG5LFIgqrIo1c1/29lrL7D1R9GjXzpre', 'worker', '2025-11-22 13:03:04'),
(4, 'uyiugfv', 'scijc@email', '$2y$10$hbjHq9CwPQJOyCHy/SqyH.DVzYse.pkMIgmVeD.Z7NmtSKhikpx12', 'worker', '2025-11-22 13:13:49'),
(5, 'bob', 'bob@gmail.com', '$2y$10$zHzO8FIqvl13tqgc1AMETuUJg.k3x/GqWkOXsXp14Nz.U7GKg.T32', 'citizen', '2025-11-22 14:08:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `issues_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
