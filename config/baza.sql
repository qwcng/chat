-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 28, 2025 at 08:52 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat_app`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `chat_themes`
--

CREATE TABLE `chat_themes` (
  `id` int(11) NOT NULL,
  `theme` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `friends`
--

CREATE TABLE `friends` (
  `user1` int(11) NOT NULL,
  `user2` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`user1`, `user2`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'accepted', '2025-02-24 17:47:13', '2025-02-24 17:52:06'),
(1, 5, 'accepted', '2025-03-13 16:58:24', '2025-03-14 17:04:38'),
(4, 1, 'accepted', '2025-02-24 18:18:01', '2025-03-14 19:28:02'),
(6, 1, 'accepted', '2025-05-28 15:35:37', '2025-05-28 15:42:52');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `sent_at`) VALUES
(338, 3, 1, 'no siema centralny', '2025-05-28 18:10:40'),
(339, 1, 3, 'siema yeat', '2025-05-28 18:11:00'),
(340, 3, 1, 'test wiadomosci', '2025-05-28 18:11:25'),
(341, 1, 5, 'ZzZ', '2025-05-28 18:16:51'),
(342, 1, 6, 'spychoKoparkaaaaaaaa', '2025-05-28 18:17:02');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `themes`
--

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `background` varchar(255) NOT NULL,
  `colors` text NOT NULL DEFAULT '["#E4E6EB", "#0084FF"]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `background`, `colors`) VALUES
(1, 'default', 'bg.jpg', '[\"#E4E6EB\", \"#0084FF\"]'),
(2, 'lake', 'bg2.jpg', '[\"#E4E6EB\", \"#0084FF\"]'),
(3, 'lake2', 'b4.jpg', '[\"#E4E6EB\", \"#0084FF\"]'),
(4, 'forest', 'bg4.jpg', '[\"#E4E6EB\", \"#0084FF\"]'),
(5, 'domek', '1.jpg', '[\'#bdbdbd\',\'#989898\']'),
(10, 'lake2', 'eyeem_105200848-jpg-738128282.jpg', '[\'#d7dadd\',\'#3d78df\']');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'default.png',
  `status` enum('online','offline') DEFAULT 'offline',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `theme` int(11) NOT NULL DEFAULT 1,
  `bio` text NOT NULL DEFAULT 'No bio yet'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_picture`, `status`, `created_at`, `theme`, `bio`) VALUES
(1, 'Centralny cee', '1', '$2y$10$fHG3SQmE5sRBQnQSR/ZYYOEy2KbKp3Ieu5nryAvpuWGFiIpk81de.', 'central.jpg', 'online', '2025-02-22 14:56:00', 10, ''),
(3, 'yeat', '3', '$2y$10$MZXv80Ofx2yButN756Fd/OB9pIwM0Qn6iq/Jr0liV1jb/A.C.kg.6', 'kanye.jpg', 'online', '2025-02-23 13:34:17', 8, 'No bio yet'),
(4, 'Kostka', '4', '$2y$10$v4nNhIEVsVHyuLrufGnFYeaCKv0HTG9Jo5rn8/Z8AUSVxneS97qJm', 'default.png', 'offline', '2025-02-23 14:09:36', 2, 'No bio yet'),
(5, 'NEMMSPANIE', '5', '$2y$10$dMWqRPgAVFv5blgfsnDEz.n6Wix354aK5yZE1SNmcAnAcJb8V2EKK', 'nemzzz.jpg', 'online', '2025-02-23 14:19:42', 2, 'No bio yet'),
(6, 'spychokoparka', '6', '$2y$10$ag7m1RnWogjrz.YN7lQYgOhjH0HY1FpXA4mgExeBZtLeO6zSsKsuq', 'koparka.png', 'offline', '2025-05-28 15:33:40', 1, 'No bio yet');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `chat_themes`
--
ALTER TABLE `chat_themes`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`user1`,`user2`),
  ADD KEY `user2` (`user2`);

--
-- Indeksy dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indeksy dla tabeli `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_themes`
--
ALTER TABLE `chat_themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user1`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`user2`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
