-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2026 at 03:38 PM
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
-- Database: `tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodation`
--

CREATE TABLE `accommodation` (
  `accommodationID` int(11) NOT NULL,
  `accommodationName` varchar(100) NOT NULL,
  `accommodationDescription` varchar(200) NOT NULL,
  `accommodationLocation` text NOT NULL,
  `accommodationPrice` decimal(8,2) NOT NULL,
  `accommodationRating` int(11) NOT NULL,
  `accommodationImg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodation`
--

INSERT INTO `accommodation` (`accommodationID`, `accommodationName`, `accommodationDescription`, `accommodationLocation`, `accommodationPrice`, `accommodationRating`, `accommodationImg`) VALUES
(1, 'OYO Home 90737 Disan Baang Kiulu', 'Family Room with Private Bathroom, 2 guests', '1, Kampung Kiulu, 89208 Ranau, Sabah', 41.00, 9, 'uploads/acc1.webp'),
(2, 'OYO HOME 90751 Jasura Lodge Kiulu', 'Family Room with Private Bathroom, 2 guests', 'Jalan. Kiulu - Pukak Kg. Poturidon, 89257 Tamparuli, Sabah', 53.00, 10, 'uploads/acc2.webp'),
(3, 'Borneo Tree House', 'Family Room with Private Bathroom, 2 guests', 'Borneo Tree House, Jalan Kampung Tebobon, Kampung Ratau, 88450 Kota Kinabalu, Sabah', 61.00, 8, 'uploads/acc3.webp');

-- --------------------------------------------------------

--
-- Table structure for table `accommodationbookingdetails`
--

CREATE TABLE `accommodationbookingdetails` (
  `accBookID` int(11) NOT NULL,
  `bookingID` int(11) NOT NULL,
  `accommodationID` int(11) NOT NULL,
  `accQuantity` int(11) NOT NULL,
  `accAmount` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodationbookingdetails`
--

INSERT INTO `accommodationbookingdetails` (`accBookID`, `bookingID`, `accommodationID`, `accQuantity`, `accAmount`) VALUES
(6, 7, 2, 1, 53.00);

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activityID` int(11) NOT NULL,
  `activityName` varchar(100) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `activityPrice` decimal(8,2) NOT NULL,
  `min_quantity` int(11) NOT NULL DEFAULT 1,
  `max_quantity` int(11) NOT NULL DEFAULT 10,
  `activityImg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activityID`, `activityName`, `categoryID`, `activityPrice`, `min_quantity`, `max_quantity`, `activityImg`) VALUES
(1, 'Adult Rafter (I have a group of 2 - 3 Pax)', 1, 230.00, 2, 3, 'uploads/rafting grade1.png'),
(2, 'Adult Rafter (I have a group of 2 - 3 Pax)', 2, 280.00, 2, 3, 'uploads/rafting grade2.webp'),
(3, 'Adult Rafter (I have a group of 4 - 9 Pax)', 1, 220.00, 4, 9, 'uploads/rafting grade1.png'),
(4, 'Adult Rafter (I have a group of 4 - 9 Pax)', 2, 270.00, 4, 9, 'uploads/rafting grade2.webp'),
(5, 'Adult Rafter (I have a group of 10 - 19 Pax)', 1, 210.00, 10, 19, 'uploads/rafting grade1.png'),
(6, 'Adult Rafter (I have a group of 10 - 19 Pax)', 2, 260.00, 10, 19, 'uploads/rafting grade2.webp'),
(7, 'Adult Rafter (I have a group of 20 Pax & Above)', 1, 200.00, 20, 100, 'uploads/rafting grade1.png'),
(8, 'Adult Rafter (I have a group of 20 Pax & Above)', 2, 250.00, 20, 100, 'uploads/rafting grade2.webp'),
(9, 'Adult Rafter (I am a Single Traveller)', 1, 255.00, 1, 1, 'uploads/rafting grade1.png'),
(10, 'Adult Rafter (I am a Single Traveller)', 2, 305.00, 1, 1, 'uploads/rafting grade2.webp'),
(11, 'Adult Non-Rafter (I am accompanying a group of Rafters)', 3, 100.00, 1, 100, 'uploads/non rafter.jpeg'),
(12, 'Child Rafter (5 - 11 years old - I am accompanying a group of Adult Rafters)', 1, 120.00, 1, 100, 'uploads/rafting grade1.png'),
(13, 'Child Non-Rafter (3 - 11 years old - I am accompanying a group of Adult Rafters)', 3, 80.00, 1, 100, 'uploads/non rafter.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `activitybookingdetails`
--

CREATE TABLE `activitybookingdetails` (
  `actBookID` int(11) NOT NULL,
  `bookingID` int(11) NOT NULL,
  `activityID` int(11) NOT NULL,
  `actQuantity` int(11) NOT NULL,
  `actAmount` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activitybookingdetails`
--

INSERT INTO `activitybookingdetails` (`actBookID`, `bookingID`, `activityID`, `actQuantity`, `actAmount`) VALUES
(7, 7, 6, 14, 3640.00);

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blogID` int(11) NOT NULL,
  `blogEntry` text NOT NULL,
  `createdBy` int(11) NOT NULL,
  `updatedDate` date NOT NULL,
  `blogImg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blogID`, `blogEntry`, `createdBy`, `updatedDate`, `blogImg`) VALUES
(10, 'Kiulu Trip Awesome! - booking ID 7', 9, '2026-10-20', 'uploads/kiuluTrip.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingID` int(11) NOT NULL,
  `bookerID` int(11) NOT NULL,
  `bookingAmount` decimal(8,2) NOT NULL,
  `bookingDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingID`, `bookerID`, `bookingAmount`, `bookingDate`) VALUES
(7, 9, 4263.00, '2026-10-20 21:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `cartype`
--

CREATE TABLE `cartype` (
  `typeID` int(11) NOT NULL,
  `typeName` varchar(100) NOT NULL,
  `typeDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cartype`
--

INSERT INTO `cartype` (`typeID`, `typeName`, `typeDescription`) VALUES
(1, '5 seaters', '5 passengers and 1 driver'),
(2, '7 seaters', '8 passengers and 1 driver'),
(3, 'van', '15 passengers and 1 driver');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryID` int(11) NOT NULL,
  `categoryName` varchar(100) NOT NULL,
  `categoryDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `categoryName`, `categoryDescription`) VALUES
(1, 'Grade 1', 'Floating down the river in a tube.'),
(2, 'Grade 2', 'Straightforward rapids with wide-open channels.'),
(3, 'Non-Rafter', 'Just accompanying a group of rafters.');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `equipmentID` int(11) NOT NULL,
  `equipmentName` varchar(100) NOT NULL,
  `equipmentQuantity` int(11) NOT NULL,
  `equipmentPrice` decimal(8,2) NOT NULL,
  `equipmentImg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipmentID`, `equipmentName`, `equipmentQuantity`, `equipmentPrice`, `equipmentImg`) VALUES
(1, 'Raft', 94, 20.00, 'uploads/raft.jpg'),
(2, 'Paddle', 485, 5.00, 'uploads/paddle.jpg'),
(3, 'Helmet', 234, 5.00, 'uploads/helmet.jpg'),
(4, 'Life Jacket', 235, 5.00, 'uploads/life jacket.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `equipmentbookingdetails`
--

CREATE TABLE `equipmentbookingdetails` (
  `equBookID` int(11) NOT NULL,
  `bookingID` int(11) NOT NULL,
  `equipmentID` int(11) NOT NULL,
  `equQuantity` int(11) NOT NULL,
  `equAmount` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipmentbookingdetails`
--

INSERT INTO `equipmentbookingdetails` (`equBookID`, `bookingID`, `equipmentID`, `equQuantity`, `equAmount`) VALUES
(9, 7, 4, 14, 70.00),
(10, 7, 3, 14, 70.00),
(11, 7, 2, 14, 70.00),
(12, 7, 1, 2, 40.00);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewID` int(11) NOT NULL,
  `bookingID` int(11) NOT NULL,
  `reviewText` text NOT NULL,
  `reviewRating` int(11) NOT NULL,
  `reviewBy` int(11) NOT NULL,
  `reviewDate` date NOT NULL,
  `reviewImage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`reviewID`, `bookingID`, `reviewText`, `reviewRating`, `reviewBy`, `reviewDate`, `reviewImage`) VALUES
(15, 7, 'awesome!', 5, 9, '2026-10-20', 'uploads/kiuluTrip.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

CREATE TABLE `tour` (
  `tourID` int(11) NOT NULL,
  `tourName` varchar(100) NOT NULL,
  `tourContact` varchar(100) NOT NULL,
  `tourRating` int(11) NOT NULL,
  `tourPrice` decimal(8,2) NOT NULL,
  `tourImg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour`
--

INSERT INTO `tour` (`tourID`, `tourName`, `tourContact`, `tourRating`, `tourPrice`, `tourImg`) VALUES
(1, 'ABK-AWR01', '013-808 2266', 10, 50.00, 'uploads/tour.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tourbookingdetails`
--

CREATE TABLE `tourbookingdetails` (
  `tourBookID` int(11) NOT NULL,
  `bookingID` int(11) NOT NULL,
  `tourID` int(11) NOT NULL,
  `tourQuantity` int(11) NOT NULL,
  `tourAmount` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `transportID` int(11) NOT NULL,
  `transportName` varchar(100) NOT NULL,
  `typeID` int(11) NOT NULL,
  `transportPrice` decimal(8,2) NOT NULL,
  `transportImg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`transportID`, `transportName`, `typeID`, `transportPrice`, `transportImg`) VALUES
(1, 'Perodua Viva 1.0', 1, 110.00, 'uploads/perodua-viva-001.png'),
(2, 'Toyota Avanza', 2, 220.00, 'uploads/2018-Toyota-Avanza-X-Introduced-in-Malaysia-1.jpg'),
(3, 'Toyota Hiace', 3, 300.00, 'uploads/toyota hiace.jpg'),
(4, 'Perodua Axia 1.0', 1, 120.00, 'uploads/2014_Perodua_Axia_SE_in_Cyberjaya,_Malaysia_(01).jpg'),
(5, 'Proton Exora', 2, 230.00, 'uploads/proton-exora-color-763914.avif'),
(6, 'Nissan Urvan', 3, 320.00, 'uploads/URVAN-2.5-MT-13S-4DR-Microbus-H-R-DX.jpg'),
(7, 'Perodua Myvi 1.3', 1, 140.00, 'uploads/myvi.jpg'),
(8, 'Toyota Vios', 1, 250.00, 'uploads/Vios-Baru-2023-Red.png'),
(9, 'Toyota Wish', 2, 350.00, 'uploads/Toyota_Wish_in_Hong_Kong.jpg'),
(10, 'Proton Saga FLX 1.3', 1, 140.00, 'uploads/PROTON-Saga-FLX-5068_1.jpg'),
(11, 'Toyota Innova', 2, 280.00, 'uploads/toyota-my-innova-overview-1200x1200.jpg'),
(12, 'Toyota Hilux', 2, 350.00, 'uploads/hilux.jpg'),
(13, 'Perodua Alza 1.5', 2, 200.00, 'uploads/alza.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transportbookingdetails`
--

CREATE TABLE `transportbookingdetails` (
  `traBookID` int(11) NOT NULL,
  `bookingID` int(11) NOT NULL,
  `transportID` int(11) NOT NULL,
  `traQuantity` int(11) NOT NULL,
  `traAmount` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transportbookingdetails`
--

INSERT INTO `transportbookingdetails` (`traBookID`, `bookingID`, `transportID`, `traQuantity`, `traAmount`) VALUES
(6, 7, 6, 1, 320.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userContact` varchar(100) NOT NULL,
  `userPassword` varchar(100) NOT NULL,
  `registerDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `userRole` int(11) NOT NULL DEFAULT 2 COMMENT '1 - System Admin, 2 - Normal User	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `userName`, `userEmail`, `userContact`, `userPassword`, `registerDate`, `userRole`) VALUES
(9, 'user1', 'user1@email.com', '0123456789', '$2y$10$4BVb/w00BOgowWtgzqKquOFLLYOfKSiwAyIouSOS0lVivQRQITjcS', '2026-10-20 13:04:23', 2),
(10, 'admin1', 'admin1@email.com', '0198765432', '$2y$10$CN9oxP0tdoFwy4441uyzc.UdXrMwzLyBW5h0hxpCU8MJGwY0Drtza', '2026-10-20 13:10:40', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodation`
--
ALTER TABLE `accommodation`
  ADD PRIMARY KEY (`accommodationID`);

--
-- Indexes for table `accommodationbookingdetails`
--
ALTER TABLE `accommodationbookingdetails`
  ADD PRIMARY KEY (`accBookID`),
  ADD KEY `accBook` (`accommodationID`),
  ADD KEY `accommodation` (`bookingID`);

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activityID`),
  ADD KEY `category` (`categoryID`);

--
-- Indexes for table `activitybookingdetails`
--
ALTER TABLE `activitybookingdetails`
  ADD PRIMARY KEY (`actBookID`),
  ADD KEY `actBook` (`activityID`),
  ADD KEY `activity` (`bookingID`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blogID`),
  ADD KEY `blog` (`createdBy`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `booker` (`bookerID`);

--
-- Indexes for table `cartype`
--
ALTER TABLE `cartype`
  ADD PRIMARY KEY (`typeID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equipmentID`);

--
-- Indexes for table `equipmentbookingdetails`
--
ALTER TABLE `equipmentbookingdetails`
  ADD PRIMARY KEY (`equBookID`),
  ADD KEY `equBook` (`equipmentID`),
  ADD KEY `equipment` (`bookingID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reviewID`),
  ADD KEY `review` (`reviewBy`),
  ADD KEY `book` (`bookingID`);

--
-- Indexes for table `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`tourID`);

--
-- Indexes for table `tourbookingdetails`
--
ALTER TABLE `tourbookingdetails`
  ADD PRIMARY KEY (`tourBookID`),
  ADD KEY `tourBook` (`tourID`),
  ADD KEY `tour` (`bookingID`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`transportID`),
  ADD KEY `carType` (`typeID`);

--
-- Indexes for table `transportbookingdetails`
--
ALTER TABLE `transportbookingdetails`
  ADD PRIMARY KEY (`traBookID`),
  ADD KEY `traBook` (`transportID`),
  ADD KEY `transport` (`bookingID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accommodation`
--
ALTER TABLE `accommodation`
  MODIFY `accommodationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `accommodationbookingdetails`
--
ALTER TABLE `accommodationbookingdetails`
  MODIFY `accBookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `activitybookingdetails`
--
ALTER TABLE `activitybookingdetails`
  MODIFY `actBookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cartype`
--
ALTER TABLE `cartype`
  MODIFY `typeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `equipmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `equipmentbookingdetails`
--
ALTER TABLE `equipmentbookingdetails`
  MODIFY `equBookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tour`
--
ALTER TABLE `tour`
  MODIFY `tourID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tourbookingdetails`
--
ALTER TABLE `tourbookingdetails`
  MODIFY `tourBookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `transportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transportbookingdetails`
--
ALTER TABLE `transportbookingdetails`
  MODIFY `traBookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accommodationbookingdetails`
--
ALTER TABLE `accommodationbookingdetails`
  ADD CONSTRAINT `accBook` FOREIGN KEY (`accommodationID`) REFERENCES `accommodation` (`accommodationID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accommodation` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `category` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activitybookingdetails`
--
ALTER TABLE `activitybookingdetails`
  ADD CONSTRAINT `actBook` FOREIGN KEY (`activityID`) REFERENCES `activity` (`activityID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog` FOREIGN KEY (`createdBy`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booker` FOREIGN KEY (`bookerID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `equipmentbookingdetails`
--
ALTER TABLE `equipmentbookingdetails`
  ADD CONSTRAINT `equBook` FOREIGN KEY (`equipmentID`) REFERENCES `equipment` (`equipmentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `equipment` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `book` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review` FOREIGN KEY (`reviewBy`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tourbookingdetails`
--
ALTER TABLE `tourbookingdetails`
  ADD CONSTRAINT `tour` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tourBook` FOREIGN KEY (`tourID`) REFERENCES `tour` (`tourID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transport`
--
ALTER TABLE `transport`
  ADD CONSTRAINT `carType` FOREIGN KEY (`typeID`) REFERENCES `cartype` (`typeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transportbookingdetails`
--
ALTER TABLE `transportbookingdetails`
  ADD CONSTRAINT `traBook` FOREIGN KEY (`transportID`) REFERENCES `transport` (`transportID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transport` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
