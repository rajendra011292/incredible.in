-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20251103.8b43d270dd
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 07, 2025 at 09:35 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `incredible`
--

-- --------------------------------------------------------

--
-- Table structure for table `journal_entries`
--

CREATE TABLE `journal_entries` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `position_id` int NOT NULL,
  `action_type` enum('open','partial_close','full_close') NOT NULL,
  `size` decimal(15,5) NOT NULL,
  `price` decimal(15,5) NOT NULL,
  `pnl` decimal(15,2) DEFAULT '0.00',
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `setup_id` int NOT NULL,
  `symbol` varchar(20) NOT NULL,
  `sector` varchar(50) DEFAULT NULL,
  `industry` varchar(50) DEFAULT NULL,
  `timeframe` varchar(10) DEFAULT NULL,
  `entry_timeframe` varchar(10) DEFAULT NULL,
  `trend` varchar(20) DEFAULT NULL,
  `emotion` varchar(20) DEFAULT NULL,
  `confidence` tinyint UNSIGNED DEFAULT '50',
  `trade_date` datetime DEFAULT NULL,
  `direction` enum('long','short') NOT NULL,
  `entry_price` decimal(15,5) NOT NULL,
  `stop_loss` decimal(15,5) NOT NULL,
  `take_profit` decimal(15,5) NOT NULL,
  `capital` decimal(15,5) NOT NULL,
  `risk` decimal(15,5) NOT NULL,
  `risk_per_share` decimal(15,5) DEFAULT NULL,
  `risk_per_trade` decimal(15,2) DEFAULT NULL,
  `risk_reward_ratio` decimal(10,2) DEFAULT NULL,
  `capital_used` decimal(15,2) DEFAULT NULL,
  `position_size` decimal(15,5) NOT NULL,
  `notes` text,
  `status` enum('pending','executed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `plan_id` int NOT NULL,
  `symbol` varchar(20) NOT NULL,
  `direction` enum('long','short') NOT NULL,
  `entry_price` decimal(15,5) NOT NULL,
  `current_size` decimal(15,2) DEFAULT '0.00',
  `original_size` decimal(15,2) DEFAULT '0.00',
  `stop_loss` decimal(15,5) NOT NULL,
  `take_profit` decimal(15,5) NOT NULL,
  `status` enum('open','closed') DEFAULT 'open',
  `realized_pnl` decimal(15,2) DEFAULT '0.00',
  `opened_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `closed_at` timestamp NULL DEFAULT NULL,
  `capital` decimal(15,2) DEFAULT '0.00',
  `risk_percentage` decimal(5,2) DEFAULT '0.00',
  `risk_per_share` decimal(15,2) DEFAULT '0.00',
  `trend` varchar(20) DEFAULT 'neutral',
  `emotion` varchar(20) DEFAULT 'neutral',
  `confidence` tinyint UNSIGNED DEFAULT '50',
  `entry_time` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `position_metrics`
--

CREATE TABLE `position_metrics` (
  `id` int NOT NULL,
  `position_id` int NOT NULL,
  `risk_reward_ratio` decimal(10,2) DEFAULT NULL,
  `max_drawdown` decimal(10,2) DEFAULT NULL,
  `volatility` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setups`
--

CREATE TABLE `setups` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `strategy` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `position_id` (`position_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `setup_id` (`setup_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `position_metrics`
--
ALTER TABLE `position_metrics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `position_id` (`position_id`);

--
-- Indexes for table `setups`
--
ALTER TABLE `setups`
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
-- AUTO_INCREMENT for table `journal_entries`
--
ALTER TABLE `journal_entries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `position_metrics`
--
ALTER TABLE `position_metrics`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setups`
--
ALTER TABLE `setups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD CONSTRAINT `journal_entries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_entries_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `plans`
--
ALTER TABLE `plans`
  ADD CONSTRAINT `plans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `plans_ibfk_2` FOREIGN KEY (`setup_id`) REFERENCES `setups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `positions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `positions_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `position_metrics`
--
ALTER TABLE `position_metrics`
  ADD CONSTRAINT `position_metrics_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `setups`
--
ALTER TABLE `setups`
  ADD CONSTRAINT `setups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
