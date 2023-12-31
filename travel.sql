-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2023 at 02:31 AM
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
-- Database: `travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`) VALUES
(1, 'Paris'),
(2, 'Egypt'),
(3, 'Tokyo'),
(4, 'London'),
(5, 'China'),
(6, 'Italy'),
(7, 'Mosco'),
(8, 'Canada'),
(9, 'Kuwayt'),
(10, 'Saudi arabia'),
(11, 'Palastine'),
(12, 'Ukrain'),
(13, 'Mexico'),
(14, 'Spain');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `bio` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `logoImg` varchar(255) NOT NULL,
  `accountBalance` decimal(10,2) NOT NULL,
  `flightId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `password`, `email`, `tel`, `bio`, `address`, `location`, `username`, `logoImg`, `accountBalance`, `flightId`) VALUES
(1, 'Etihad', '$2y$10$tPI29pCm3FYow3wb4jIOA.oMk1qEYE5b3VvYGzA.gv6EED2I2Fp1.', 'etihad@gmail.com', '01099338262', 'Welcome', 'Dubai St', 'Abudhabi', 'etihad', 'etihad.png', 200.00, 0),
(2, 'aaasda', '$2y$10$1PSqEDrTLWCBmGhwkz9Be.PKOrEnC69G/nbzQgl2EsSU5SwRxlV2O', 'aaaaa@mm.com', '01001094494', 'asdawswd', 'asdasd', 'asdasd', 'asdasd', 'apolo.png', 0.00, 0),
(3, 'Qatar', '$2y$10$3nFqiHQvGDEVGhoglMUI6e0v3vKQ0MXdWu86pAmmz6gXBBlnX24oW', 'qatar@gmail.com', '01066766459', 'Helloo', 'qatareya', 'qatar', 'qatar', 'Qatar.png', 200.00, 0),
(4, 'Swissair', '$2y$10$LGzbBxICdQnifJDYJuvb4eEx5FP06T5b8QbgQgaUlexa/2fapTB6a', 'swiss@gmail.com', '01145678935', 'swisraa', 'swis', 'swizerland', 'Swiss', 'Swiss.png', 300.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `iternary` varchar(255) NOT NULL,
  `fees` decimal(10,2) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `companyId` int(11) NOT NULL,
  `maxPassengers` int(11) NOT NULL,
  `fromX` varchar(255) NOT NULL,
  `toX` varchar(255) NOT NULL,
  `numPassPending` int(11) NOT NULL,
  `numPassRegistered` int(11) NOT NULL,
  `isCompleted` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`id`, `name`, `iternary`, `fees`, `startTime`, `endTime`, `companyId`, `maxPassengers`, `fromX`, `toX`, `numPassPending`, `numPassRegistered`, `isCompleted`) VALUES
(1, 'France', 'Paris', 200.00, '2023-01-01 13:00:00', '2023-01-01 16:00:00', 1, 100, 'Mosco', 'Paris', 0, 1, 'completed'),
(2, 'Kuwayt', 'saudi arabi', 250.00, '2023-05-01 13:00:00', '2023-05-01 15:00:00', 1, 90, 'Egypt', 'Kuwayt', 0, 0, 'pending'),
(3, 'Canada', 'egypt', 100.00, '2023-02-02 23:00:00', '2023-02-02 01:00:00', 1, 200, 'Egypt', 'Canada', 0, 0, 'pending'),
(5, 'Ukrain', 'London', 5000.00, '2023-01-01 14:00:00', '2023-01-01 17:00:00', 1, 40, 'Spain', 'Ukrain', 0, 0, 'pending'),
(6, 'Mosco', 'spain', 400.00, '2023-03-01 03:00:00', '2023-03-01 06:00:00', 3, 100, 'London', 'Mosco', 0, 0, 'pending'),
(7, 'Canada', 'italy', 200.00, '2023-01-01 17:00:00', '2023-01-01 19:00:00', 3, 100, 'Canada', 'Mexico', 0, 1, 'pending'),
(8, 'Italy', 'Canada', 300.00, '2023-02-04 05:00:00', '2023-02-04 08:00:00', 4, 200, 'China', 'Italy', 0, 1, 'completed'),
(9, 'Paris', 'France', 100.00, '2023-05-01 13:00:00', '2023-05-01 16:00:00', 4, 100, 'Paris', 'Egypt', 0, 0, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `msgtocomp`
--

CREATE TABLE `msgtocomp` (
  `id` int(11) NOT NULL,
  `passengerId` int(11) NOT NULL,
  `passname` varchar(255) NOT NULL,
  `companyId` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `msgtocomp`
--

INSERT INTO `msgtocomp` (`id`, `passengerId`, `passname`, `companyId`, `message`, `status`) VALUES
(1, 1, 'Omar', 1, 'Hello etihad', 'sent from passenger'),
(2, 1, 'Omar', 1, 'hello Omar', 'sent from company'),
(3, 1, 'Omar', 4, 'Hello swiss', 'sent from passenger'),
(4, 1, 'Omar', 4, 'hello yasta', 'sent from company');

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `passportImg` varchar(255) NOT NULL,
  `accountBalance` decimal(10,2) NOT NULL,
  `flightId` int(11) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `passenger`
--

INSERT INTO `passenger` (`id`, `name`, `email`, `password`, `tel`, `photo`, `passportImg`, `accountBalance`, `flightId`, `status`) VALUES
(1, 'Omar', 'omar.sayed8262@gmail.com', '$2y$10$kIRvN/F7cLJovJ9SJYjbyO8qQqFsB4K2G25KcwD5Ef/0Z7I2j43By', '01099338262', 'profile1.png', 'n1.png', 4300.00, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `passengerflight`
--

CREATE TABLE `passengerflight` (
  `id` int(11) NOT NULL,
  `flightId` int(11) NOT NULL,
  `passengerId` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `passengerflight`
--

INSERT INTO `passengerflight` (`id`, `flightId`, `passengerId`, `status`) VALUES
(1, 1, 1, 'registered'),
(3, 8, 1, 'registered'),
(4, 7, 1, 'registered');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `msgtocomp`
--
ALTER TABLE `msgtocomp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passengerflight`
--
ALTER TABLE `passengerflight`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `msgtocomp`
--
ALTER TABLE `msgtocomp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `passengerflight`
--
ALTER TABLE `passengerflight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
