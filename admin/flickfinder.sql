-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2025 at 06:15 PM
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
-- Database: `flickfinder`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `pwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `uname`, `pwd`) VALUES
(1, 'somosreedey54321@gmail.com', 'somosreedey100#N'),
(2, 'soumitakarmakar082@gmail.com', 'karmakar04'),
(3, 'Mousumipaul238@Gmail.com', 'Mou3458');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movies_flick`
--

CREATE TABLE `movies_flick` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `trailer_url` varchar(255) DEFAULT NULL,
  `poster_path` varchar(255) DEFAULT NULL,
  `actors` text DEFAULT NULL,
  `director` varchar(255) DEFAULT NULL,
  `Writers` varchar(255) DEFAULT NULL,
  `imdb_rating` decimal(3,1) DEFAULT NULL CHECK (`imdb_rating` >= 0.0 and `imdb_rating` <= 10.0),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies_flick`
--

INSERT INTO `movies_flick` (`movie_id`, `title`, `description`, `release_year`, `genre`, `video_url`, `trailer_url`, `poster_path`, `actors`, `director`, `Writers`, `imdb_rating`, `created_at`) VALUES
(1, 'Red One', 'After Santa Claus is kidnapped, the North Pole\'s Head of Security must team up with a notorious hacker in a globe-trotting, action-packed mission to save Christmas.', 2024, 'Action, Adventure, Comedy, Fantasy, Mystery', 'https://drive.google.com/file/d/1SdSr5tEcMH2lEhY5NJrtXfE6--zwkPE5/preview', 'https://youtu.be/RkOSeUyigWI', 'https://m.media-amazon.com/images/M/MV5BZmFkMjE4NjQtZTVmZS00MDZjLWE2ZmEtZTkzODljNjhlNWUxXkEyXkFqcGc@._V1_.jpg', ' Dwayne Johnson, Chris Evans,  Lucy Liu', ' Jake Kasdan', '\nChris Morgan, Hiram Garcia', 6.4, '2025-01-05 09:54:13'),
(2, 'Hi Nanna', 'A single father begins to narrate the story of the missing mother to his child and nothing remains the same.', 2023, 'Drama, Family, Romance ', 'https://drive.google.com/file/d/1zBXkJq8LmvlGsonDYamkPBrZNP4qoTF1/preview', 'https://youtu.be/80T1qoy9RSY', 'https://assets-in.bmscdn.com/iedb/movies/images/mobile/thumbnail/xlarge/hi-nanna-et00364503-1701678655.jpg', ' Nani, Mrunal Thakur, Kiara Khanna ', 'Shouryuv', 'Vamshi Bommena, Nagendra Kasi, Shouryuv', 8.2, '2025-01-06 09:27:35'),
(3, 'Deadpool & Wolverine', 'Deadpool is offered a place in the Marvel Cinematic Universe by the Time Variance Authority, but instead recruits a variant of Wolverine to save his universe from extinction.', 2024, 'Action, Adventure, Comedy, Sci-fi', 'https://drive.google.com/file/d/1PAtg6qb03cQrsBfCwSvirioUOnrg25er/preview', 'https://youtu.be/ea94nqoxnVQ', 'https://m.media-amazon.com/images/M/MV5BZTk5ODY0MmQtMzA3Ni00NGY1LThiYzItZThiNjFiNDM4MTM3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', 'Ryan Reynolds, Hugh Jackman, Emma Corrin', 'Shawn Levy', 'Ryan Reynolds, Rhett Reese, Paul Wernick', 7.6, '2025-01-06 09:50:36'),
(4, 'Annabelle', 'A couple begins to experience terrifying supernatural occurrences involving a vintage doll shortly after their home is invaded by satanic cultists.', 2014, 'Horror, Thriller, Mystery', 'https://drive.google.com/file/d/1G4Cz6eSLKqwnnFWjQIfUi1OOi9-VsTS3/preview', 'https://youtu.be/paFgQNPGlsg', 'https://m.media-amazon.com/images/M/MV5BNjkyMDU5ZWQtZDhkOC00ZWFjLWIyM2MtZWFhMDUzNjdlNzU2XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', 'Ward Horton, Annabelle Wallis, Alfre Woodard', 'John R. Leonetti', 'Gary Dauberman', 5.5, '2025-01-06 10:04:23'),
(5, 'Dune: Part Two', 'Paul Atreides unites with the Fremen while on a warpath of revenge against the conspirators who destroyed his family. Facing a choice between the love of his life and the fate of the universe, he endeavors to prevent a terrible future.', 2024, 'Action, Adventure, Drama, Sci-fi', 'https://drive.google.com/file/d/1hJc4oPMUsdge2GHA3H0xbpW71HdIV-cI/preview', 'https://youtu.be/NQ7pfqxYPj0', 'https://m.media-amazon.com/images/M/MV5BNTc0YmQxMjEtODI5MC00NjFiLTlkMWUtOGQ5NjFmYWUyZGJhXkEyXkFqcGc@._V1_.jpg', 'Timothée Chalamet, Zendaya, Rebecca Ferguson', 'Denis Villeneuve', 'Denis Villeneuve, Jon Spaihts, Frank Herbert', 8.5, '2025-01-06 10:12:11'),
(6, 'Immaculate', 'Cecilia, a woman of devout faith, is warmly welcomed to the picture-perfect Italian countryside where she is offered a new role at an illustrious convent. But it becomes clear to Cecilia that her new home harbors dark and horrifying secrets.', 2024, 'Horror, Thriller', 'https://drive.google.com/file/d/1VlgRgJoBTHVuY1SjxMUi9jOW01YJUuEy/preview', 'https://youtu.be/P9BVzFiY1ao', 'https://m.media-amazon.com/images/M/MV5BMWEzYjYyMjQtNTJjYi00ZDQ5LWE4N2MtNWY2ZTgxODNhYWM4XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', ' Sydney Sweeney, Álvaro Morte, Simona Tabasco', 'Michael Mohan', 'Andrew Lobel', 5.8, '2025-01-06 10:21:11'),
(7, 'Pushpa: The Rise - Part 1', 'A labourer rises through the ranks of a red sandalwood smuggling syndicate, making some powerful enemies in the process.', 2021, 'Action, Crime, Drama, Thriller', 'https://drive.google.com/file/d/10-tWLdwErS0fwI076xmipFV8Ck5Ii86U/preview', 'https://youtu.be/pKctjlxbFDQ', 'https://m.media-amazon.com/images/M/MV5BOWE4YWEyNjYtMWFiNC00M2IzLWE3ZGMtMjQ0ZGEyOWI1YjAzXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', ' Allu Arjun, Fahadh Faasil, Rashmika Mandanna', 'Sukumar', 'Sukumar, Srikanth Vissa, Hussain Sha Kiran', 7.6, '2025-01-06 12:04:21'),
(8, 'Pushpa: The Rule - Part 2', 'Pushpa struggles to sustain his sandalwood smuggling business in the face of tough opposition from the police.', 2024, 'Action, Crime, Drama, Thriller', 'https://drive.google.com/file/d/1ACCN-7MDziZo6ywJgaH6KIUnItSqOcyC/preview', 'https://youtu.be/1kVK0MZlbI4', 'https://m.media-amazon.com/images/M/MV5BZjllNTdiM2QtYjQ0Ni00ZGM1LWFlYmUtNWY0YjMzYWIxOTYxXkEyXkFqcGc@._V1_QL75_UX480_.jpg', 'Allu Arjun, Rashmika Mandanna, Fahadh Faasil', 'Sukumar', 'A.R. Prabhav, Rajendra Sapre, Sukumar', 6.4, '2025-01-06 12:11:48');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tvshows_flick`
--

CREATE TABLE `tvshows_flick` (
  `show_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `trailer_url` varchar(255) DEFAULT NULL,
  `poster_path` varchar(255) DEFAULT NULL,
  `actors` text DEFAULT NULL,
  `creator` varchar(255) DEFAULT NULL,
  `imdb_rating` decimal(3,1) DEFAULT NULL CHECK (`imdb_rating` >= 0.0 and `imdb_rating` <= 10.0),
  `seasons` int(11) DEFAULT NULL,
  `episodes` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tvshows_flick`
--

INSERT INTO `tvshows_flick` (`show_id`, `title`, `description`, `release_year`, `genre`, `video_url`, `trailer_url`, `poster_path`, `actors`, `creator`, `imdb_rating`, `seasons`, `episodes`, `created_at`) VALUES
(1, 'Wednesday', 'Follows Wednesday Addams\\\' years as a student, when she attempts to master her emerging psychic ability, thwart a killing spree, and solve the mystery that embroiled her parents.', 2022, 'Comedy, Crime, Fantasy, Mystery', 'https://drive.google.com/file/d/1q4qH-bdc96m1LTrNaLVcQlodM765Md5B/preview', 'https://youtu.be/DwvQLVAxiKY', 'https://m.media-amazon.com/images/M/MV5BY2E1NDI5OWEtODJmYi00Nzg2LWI4MjUtODFiMTU2YWViOTU3XkEyXkFqcGc@._V1_QL75_UX190_CR0,0,190,281_.jpg', ' Jenna Ortega, Hunter Doohan, Emma Myers', ' Alfred Gough, Miles Millar', 8.0, 1, 8, '2025-01-09 09:27:47'),
(2, 'The Summer I Turned Pretty', 'A love triangle between one girl and two brothers. A story about first love, first heartbreak, and the magic of that one perfect summer.', 2022, 'Drama, Romance', 'https://drive.google.com/file/d/1nyFWBoSECrNcwZCMM0unREcslbV3b63u/preview', 'https://youtu.be/FfAueqEab30', 'https://m.media-amazon.com/images/M/MV5BMjY1NDA1YTItMDAxYi00ODcwLWE0MTktMDJhZmJhYjk0MDRjXkEyXkFqcGc@._V1_QL75_UX190_CR0,0,190,281_.jpg', 'Lola Tung, Christopher Briney, Gavin Casalegno', 'Jenny Han', 7.0, 1, 7, '2025-01-09 10:39:20'),
(3, 'Hierarchy', 'The top 0.01% of students control law and order at Jusin High School, but a secretive transfer student chips a crack in their indomitable world.', 2024, 'Korean Drama, Drama, Romance, Thriller', 'https://drive.google.com/file/d/1ZuXNQu1AxpbpsmQaHXvJQuukS1VwlM1I/preview', 'https://youtu.be/3ulvDeIGvhI', 'https://m.media-amazon.com/images/M/MV5BMjgyZWE4NDUtNWVkMC00NjcxLTkxNWEtMGE5Mjc3ZWEwYTcxXkEyXkFqcGc@._V1_.jpg', 'Roh Jeong-eui, Lee Chae-Min, Kim Jae-Won', 'Bae Hyun-jin', 6.0, 1, 7, '2025-01-09 12:38:28'),
(4, 'Adhura', 'A supernatural thriller set in an elite boarding school with a secret so dark, it will shake up the lives of everyone connected to it.', 2023, 'Horror, Thriller', 'https://drive.google.com/file/d/1De5d8-6Oa5cZgqSts5oTYZOfDV2AALZf/preview', 'https://youtu.be/rIPnNOeQrs4', 'https://m.media-amazon.com/images/M/MV5BOWQ1YTM2YzctNTRkNS00MGM5LWE0YzYtMzBhYWI1MTI0YTAyXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', 'Ishwak Singh, Rasika Dugal, Shrenik Arora', 'Ananya Banerjee, Gauravv K. Chawla', 6.0, 1, 7, '2025-01-09 12:44:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Somosree Dey', 'somosreedey54321@gmail.com', '$2y$10$Pd2khMA2Xv5Yy98RHGM6oOOiGsgOir.QwpnPDJNZ2JKXzs6DEGSc6', '2025-01-06 14:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `watchlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `show_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`watchlist_id`, `user_id`, `movie_id`, `added_date`, `show_id`) VALUES
(2, 1, NULL, '2025-01-09 15:01:41', 1),
(3, 1, NULL, '2025-01-09 15:01:53', 2),
(4, 1, NULL, '2025-01-09 15:02:28', 4),
(6, 1, 8, '2025-01-09 15:54:43', NULL),
(7, 1, 3, '2025-01-09 15:54:48', NULL),
(8, 1, 2, '2025-01-09 15:55:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `movies_flick`
--
ALTER TABLE `movies_flick`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `tvshows_flick`
--
ALTER TABLE `tvshows_flick`
  ADD PRIMARY KEY (`show_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`watchlist_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `watchlist_ibfk_3` (`show_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `movies_flick`
--
ALTER TABLE `movies_flick`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tvshows_flick`
--
ALTER TABLE `tvshows_flick`
  MODIFY `show_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `watchlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`);

--
-- Constraints for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD CONSTRAINT `watchlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `watchlist_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies_flick` (`movie_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `watchlist_ibfk_3` FOREIGN KEY (`show_id`) REFERENCES `tvshows_flick` (`show_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
