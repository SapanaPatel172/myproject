-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2024 at 07:52 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myprojectdata`
--

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `module` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `module`) VALUES
(41, 'home'),
(42, 'news'),
(43, 'rollmanagement'),
(44, 'users');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(50) DEFAULT NULL,
  `mod_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `permission_name`, `mod_id`) VALUES
(5, 'home_create', 41),
(6, 'home_update', 41),
(7, 'home_view', 41),
(8, 'home_delete', 41),
(9, 'news_create', 42),
(10, 'news_update', 42),
(11, 'news_view', 42),
(12, 'news_delete', 42),
(13, 'rollmanagement_create', 43),
(14, 'rollmanagement_update', 43),
(15, 'rollmanagement_view', 43),
(16, 'rollmanagement_delete', 43),
(17, 'users_create', 44),
(18, 'users_update', 44),
(19, 'users_view', 44),
(20, 'users_delete', 44);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(3, 'admin'),
(32, 'frenchaise'),
(16, 'manager'),
(35, 'submanager'),
(33, 'superadmin'),
(4, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(4, 9),
(4, 10),
(4, 11),
(4, 12),
(4, 15),
(4, 19),
(16, 5),
(16, 6),
(16, 7),
(16, 8),
(16, 9),
(16, 10),
(16, 11),
(16, 12),
(16, 13),
(16, 14),
(16, 15),
(16, 17),
(16, 18),
(16, 19),
(32, 5),
(32, 6),
(32, 7),
(32, 8),
(32, 9),
(32, 10),
(32, 11),
(32, 12),
(32, 15),
(32, 19),
(33, 5),
(33, 6),
(33, 7),
(33, 8),
(33, 9),
(33, 10),
(33, 11),
(33, 12),
(33, 13),
(33, 14),
(33, 15),
(33, 16),
(33, 17),
(33, 18),
(33, 19),
(33, 20),
(35, 5),
(35, 6),
(35, 7),
(35, 8),
(35, 9),
(35, 10),
(35, 11),
(35, 12),
(35, 15),
(35, 19);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'auto increment',
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL COMMENT 'enter unique email',
  `password` varchar(200) NOT NULL,
  `mobile` varchar(200) NOT NULL,
  `avatarimg` varchar(200) NOT NULL,
  `token` varchar(200) NOT NULL,
  `token_timestamp` timestamp(6) NULL DEFAULT NULL ON UPDATE current_timestamp(6),
  `varify` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `mobile`, `avatarimg`, `token`, `token_timestamp`, `varify`) VALUES
(75, 'hina', 'hina@gmail.com', '$2y$10$ELNSlRBhmhlrEWBIkKPkpeOjIfQ3tCGc5ucSL2l6E6uj8ScLcE9Cu', '1234567890', '../../image/1706516674_Images-09.png', '35a3aabaa524e5786199eeb88be59a1d', '2024-02-05 05:51:03.876393', '2024-01-20 07:27:02.000000'),
(96, 'mayra', 'mayra@gmail.com', '$2y$10$kZjT8Kwkofdd3JsWkq9Cv.uBy0l5L//9Z6GzfD7GAZXewa7eD7KP.', '9999999992', '../../image/1706940403_Images-06.png', 'b158f1266245a5c2f0e090824bc7f9f6', '2024-02-03 09:05:38.336881', '2024-01-30 10:47:51.000000'),
(101, 'sapana', 'sapana@gmail.com', '$2y$10$mAaIn6i5KVEAU.kfApmpMex.N3ruh82Krq/MOLGuozfNuRRZ4MsU.', '9999999999', '../../image/1706959158_Images-10.png', 'baf2f813dbf0863028dea5d4a3f0193c', '2024-02-03 11:19:18.192102', '2024-02-03 07:01:02.000000'),
(111, 'tina', 'tina@gmail.com', '$2y$10$6XJQ1Bexje7i7vPlKpwe1egTiyMz2o9RZ4HOoFoVmWLqbP729TzlS', '', '', 'edba6a077f302c9b128f8d7b819d0311', '2024-02-03 09:14:44.373004', '2024-02-03 09:13:31.000000'),
(112, 'meena', 'meena@gmail.com', '$2y$10$3l75/4x/MlgvXmq5xzv8iePVISx0EfYOPH4C/h0gG7lCZRUQRoYeC', '', '', '', '2024-02-05 05:10:13.046614', '2024-02-05 05:08:41.000000'),
(113, 'sima', 'sima@gmail.com', '$2y$10$r9zF6K1jcR8Fy8TwqjbzyO/leX7sVFHbwVqXUGia5wgGHuqKm5Gzi', '', '', '', '2024-02-05 06:51:08.547825', '2024-02-05 06:51:08.000000');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(75, 32),
(96, 3),
(101, 3),
(111, 4),
(112, 16),
(113, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `module` (`module`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD UNIQUE KEY `permission_name` (`permission_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'auto increment', AUTO_INCREMENT=114;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
