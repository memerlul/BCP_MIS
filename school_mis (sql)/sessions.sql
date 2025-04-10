-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 12:47 PM
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
-- Database: `school_mis`
--

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `username`, `user_agent`, `ip_address`, `created_at`) VALUES
('0dhmhkg6bph6676kn4k4ml33rs', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 06:53:22'),
('0f95p8irui999a0c2gb4n9klv5', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-06 14:47:57'),
('2b285qjrq5v2gdtbar0ubn3djo', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 07:51:03'),
('2nea1dpq9ga9qqvuq840vdhd15', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-06 14:34:04'),
('3794mgf45sl0tu7mhjou8n95to', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 07:04:56'),
('3de01pajs23drnuq97eemha3vk', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 06:20:58'),
('7reeetkk1s450vhfsk7oqlbprm', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 06:07:00'),
('804nuci1cn2ljfn7v3kep29i3c', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 07:51:55'),
('8oj1o2qpf35njckg8gahqucp1r', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 06:34:44'),
('8qhcqn23mntfsd0jti0olpdt5k', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 06:05:10'),
('8rapmvi3q5k55cnn6q1a3cke5h', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 07:15:29'),
('9cbmcds460p83pussmm8itl5iv', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-06 14:49:07'),
('boc2qb8lnmtib7nchfoi6m4q4m', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-06 15:17:49'),
('bvht9e8m3cmrrcf5ic61d9ecp2', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 06:19:56'),
('cjj4l1micqe4hrpml2cgseder8', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 07:00:56'),
('dfas27jlqg4cb3v9srt0nl0meh', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-06 14:54:28'),
('fklbuajg0jdai8169915ek7cgm', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 08:27:49'),
('g08op7e1uk5qhbio1ujf18mfru', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 07:24:58'),
('gbdcmcin3qqi20ks97ctg0gjbq', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-06 15:09:54'),
('gmad3l9m2a5uacve2nl4flumq8', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-06 14:29:51'),
('hprtl8t0g674l197or75q99sto', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 06:05:52'),
('k62i685kin4ut90ffum1gfdbrh', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 06:37:58'),
('khn4e51809m2u55hk44b3tt7a9', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 08:27:11'),
('l2l2hm8mkhil8ijgh6el8brk8p', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 07:14:50'),
('le8nf52g6j6p8vkdn8a3o80b9s', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 09:09:35'),
('lnqsej9d1cmkbo7khe6bs0fk9r', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 06:46:48'),
('o8c7oauqdamho78vs0239v8nho', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 08:02:54'),
('oem9uufdo583gmeatom74v78eq', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 07:13:51'),
('pu60ndu0bu00jgb49e5nvslr5f', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 06:19:14'),
('qc49v3htl8n4h99tp7sdm5d46g', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-06 15:03:03'),
('qvm3al65vdvmtomajfmtmr4bi2', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-06 14:44:25'),
('r47lrm4aeb4kmp6i7427vvl1ds', 'ilovekimchi', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 06:44:50'),
('s74cn0q5osvfs2ta1v68a179bd', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 06:50:28'),
('se9c8ckom20lvqut8fhsulfqdm', 'ilovekimchi', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 06:45:21'),
('tm6ca7rhmtij9eqjuemumr27ik', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-06 14:32:30'),
('uvt6ooeskmurn1mb81oeroan19', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 07:29:03'),
('vicrjcpqlfdj29onm2a0bp67gb', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-07 07:28:05'),
('vuho5kbil7r5pcp3fga5ta6urh', 'gabgesleich', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '::1', '2025-04-06 14:34:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `username` (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
