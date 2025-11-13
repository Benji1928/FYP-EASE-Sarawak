-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2025 at 02:38 AM
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
-- Database: `easesarawak`
--

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `id_num` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `social` int(11) NOT NULL,
  `social_num` int(11) NOT NULL,
  `upload` varchar(255) NOT NULL,
  `special` int(11) DEFAULT NULL,
  `special_note` int(11) DEFAULT NULL,
  `order_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`order_details_json`)),
  `promo_code` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `amount` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `service_type`, `first_name`, `last_name`, `id_num`, `email`, `phone`, `social`, `social_num`, `upload`, `special`, `special_note`, `order_details_json`, `promo_code`, `status`, `amount`, `payment_method`, `is_deleted`, `created_date`, `modified_date`) VALUES
(1, 'delivery', 'Aung', 'Htet', '234567890', 'admin1@example.com', 123386340, 2, 123386340, '', NULL, NULL, '{\"service\":\"delivery\",\"origin\":\"Ease Storage Hub @ Plaza Aurora\",\"originAddress\":\"\",\"destination\":\"Pullman Kuching\",\"destinationAddress\":\"\",\"dropoffDate\":\"2025-10-07\",\"dropoffTime\":\"20:20\",\"pickupDate\":\"2025-10-07\",\"pickupTime\":\"20:32\"}', '', 0, 0, '', 0, '2025-10-06 11:25:17', NULL),
(2, 'delivery', 'Aung', 'Htet', '234567890', 'admin1@example.com', 123386340, 1, 123386340, '', NULL, NULL, '{\"service\":\"delivery\",\"origin\":\"Hilton Kuching Hotel\",\"originAddress\":\"\",\"destination\":\"CityOne Megamall\",\"destinationAddress\":\"\",\"dropoffDate\":\"2025-10-07\",\"dropoffTime\":\"21:29\",\"pickupDate\":\"2025-10-08\",\"pickupTime\":\"23:29\"}', '', 0, 0, '', 0, '2025-10-06 11:29:46', NULL),
(3, 'delivery', 'Aung', 'Htet', '2147483647', 'guide1@example.com', 123386340, 1, 123386340, '', NULL, NULL, '{\"service\":\"delivery\",\"origin\":\"Hock Lee Hotel & Residences\",\"originAddress\":\"\",\"destination\":\"Puteri Wing - Riverside Majestic Hotel\",\"destinationAddress\":\"\",\"dropoffDate\":\"2025-10-07\",\"dropoffTime\":\"21:33\",\"pickupDate\":\"2025-10-08\",\"pickupTime\":\"23:33\"}', '', 0, 0, '', 0, '2025-10-06 11:33:41', NULL),
(4, 'storage', 'Aung', 'Htet', '2147483647', 'visitor10@example.com', 123386340, 3, 123386340, '', NULL, NULL, '{\"service\":\"storage\",\"storageLocation\":\"EASE Storage Hub @ Plaza Aurora\",\"quantity\":\"3\",\"dropoffDate\":\"2025-10-06\",\"dropoffTime\":\"20:06\",\"pickupDate\":\"2025-10-06\",\"pickupTime\":\"22:06\"}', '', 0, 0, '', 0, '2025-10-06 11:36:36', NULL),
(5, 'delivery', 'Aung', 'Htet', '0', 'guide1@example.com', 123386340, 1, 123386340, '', NULL, NULL, '{\"service\":\"delivery\",\"origin\":\"Citadines Uplands Kuching\",\"originAddress\":\"\",\"destination\":\"Pullman Kuching\",\"destinationAddress\":\"\",\"dropoffDate\":\"2025-10-11\",\"dropoffTime\":\"18:35\",\"pickupDate\":\"2025-10-11\",\"pickupTime\":\"19:35\"}', '', 0, 0, '', 0, '2025-10-08 08:41:20', NULL),
(6, 'delivery', 'Aung', 'Htet', '0', 'admin1@example.com', 123386340, 3, 123386340, '', NULL, NULL, '{\"service\":\"delivery\",\"origin\":\"Ease Storage Hub @ Plaza Aurora\",\"originAddress\":\"\",\"destination\":\"The Spring Shopping Mall\",\"destinationAddress\":\"\",\"dropoffDate\":\"2025-10-10\",\"dropoffTime\":\"18:41\",\"pickupDate\":\"2025-10-11\",\"pickupTime\":\"20:41\"}', '', 0, 0, '', 0, '2025-10-08 08:43:24', NULL),
(7, 'delivery', 'Aung', 'Htet', '0', 'visitor10@example.com', 123386340, 3, 123386340, '', NULL, NULL, '{\"service\":\"delivery\",\"origin\":\"Citadines Uplands Kuching\",\"originAddress\":\"\",\"destination\":\"Kuching International Airport\",\"destinationAddress\":\"\",\"dropoffDate\":\"2025-10-08\",\"dropoffTime\":\"18:45\",\"pickupDate\":\"2025-10-08\",\"pickupTime\":\"20:44\"}', '', 0, 0, '', 0, '2025-10-08 08:48:49', NULL),
(8, 'delivery', 'Aung', 'Htet', 'MF2000456', 'visitor10@example.com', 123386340, 2, 123386340, '', NULL, NULL, '{\"service\":\"delivery\",\"origin\":\"Grand Margherita Hotel\",\"originAddress\":\"\",\"destination\":\"Kuching International Airport\",\"destinationAddress\":\"\",\"dropoffDate\":\"2025-10-10\",\"dropoffTime\":\"18:54\",\"pickupDate\":\"2025-10-11\",\"pickupTime\":\"20:54\"}', '', 0, 0, '', 0, '2025-10-08 08:55:26', NULL),
(9, 'delivery', 'Zi', 'Yang', 'asdfghjk56789', 'aung.prome@gmail.com', 123386340, 2, 123386340, '', NULL, NULL, '{\"service\":\"delivery\",\"origin\":\"Grand Margherita Hotel\",\"originAddress\":\"\",\"destination\":\"Plaza Merdeka Matang Jaya\",\"destinationAddress\":\"\",\"dropoffDate\":\"2025-10-10\",\"dropoffTime\":\"10:20\",\"pickupDate\":\"2025-10-11\",\"pickupTime\":\"12:20\"}', '', 0, 0, '', 0, '2025-10-09 00:23:02', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
