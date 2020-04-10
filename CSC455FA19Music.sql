-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2020 at 12:20 PM
-- Server version: 8.0.19
-- PHP Version: 7.2.24-0ubuntu0.18.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `CSC455FA19Music`
--

-- --------------------------------------------------------

--
-- Table structure for table `Album`
--

CREATE TABLE `Album` (
  `album_ID` int NOT NULL,
  `artist_ID` int DEFAULT NULL,
  `release_Date` date DEFAULT NULL,
  `record_Label` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Album`
--

INSERT INTO `Album` (`album_ID`, `artist_ID`, `release_Date`, `record_Label`) VALUES
(5000001, 7000001, '2012-07-12', 'Def Jam'),
(5000002, 7000001, '2016-08-20', 'Boys Don\'t Cry'),
(5000003, 7000002, '2013-05-14', 'XL'),
(5000004, 7000003, '2018-11-30', 'Tan Cressida'),
(5000005, 7000004, '2018-10-26', 'Mad Love'),
(5000006, 7000005, '2015-03-16', 'Top Dawg'),
(5000007, 7000006, '2019-05-17', 'Method'),
(5000008, 7000007, '2016-03-04', 'Dreamville'),
(5000010, 7000009, '2019-10-25', 'GOOD'),
(5000011, 7000015, '2019-08-16', '300 Entertainment'),
(5000020, 7000007, '2014-04-29', 'Dreamville'),
(5000021, 7000007, '2018-08-24', 'Dreamville'),
(5000022, 7000002, '2008-01-29', 'XL'),
(5000023, 7000002, '2019-05-03', 'Spring Snow'),
(5000024, 7000003, '2013-08-20', 'Tan Cressida'),
(5000025, 7000004, '2016-08-19', 'Mad Love'),
(5000026, 7000004, '2019-11-15', 'Mad Love'),
(5000027, 7000005, '2011-07-02', 'Top Dawg'),
(5000028, 7000009, '2016-02-14', 'GOOD'),
(5000029, 7000005, '2017-04-14', 'Top Dawg'),
(5000030, 7000008, '2010-06-15', 'Young Money'),
(5000031, 7000008, '2018-06-29', 'Young Money'),
(5000032, 7000009, '2004-02-10', 'Roc-A-Fella'),
(5000033, 7000010, '2019-07-26', 'YBN'),
(5000034, 7000011, '2011-09-27', 'Roc Nation'),
(5000035, 7000011, '2018-04-20', 'Dreamville'),
(5000036, 7000012, '2013-10-08', 'GOOD'),
(5000037, 7000012, '2018-05-25', 'GOOD'),
(5000038, 7000014, '2013-11-19', 'Elektra Records'),
(5000039, 7000014, '2018-04-06', 'Elektra Records'),
(5000040, 7000011, '2016-12-09', 'Dreamville'),
(5000041, 7000009, '2013-06-18', 'Def Jam'),
(5000042, 7000003, '2019-11-01', 'Tan Cressida');

--
-- Triggers `Album`
--
DELIMITER $$
CREATE TRIGGER `updateLatestAlbum` AFTER INSERT ON `Album` FOR EACH ROW IF NEW.release_Date >= (SELECT MAX(release_Date) FROM Album WHERE NEW.artist_ID = artist_ID) THEN
	UPDATE Artist
    SET latest_Album = NEW.album_ID
    WHERE artist_ID = NEW.artist_ID;
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Album_Contributors`
--

CREATE TABLE `Album_Contributors` (
  `album_ID` int NOT NULL,
  `artist_ID` int NOT NULL,
  `album_Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Album_Contributors`
--

INSERT INTO `Album_Contributors` (`album_ID`, `artist_ID`, `album_Name`) VALUES
(5000001, 7000001, 'Channel Orange'),
(5000002, 7000001, 'Blonde'),
(5000003, 7000002, 'Modern Vampires of the City'),
(5000004, 7000003, 'Some Rap Songs'),
(5000005, 7000004, 'Love Me Now?'),
(5000006, 7000005, 'To Pimp a Butterfly'),
(5000007, 7000006, 'Nothing Great About Britain'),
(5000008, 7000007, 'Too High To Riot'),
(5000010, 7000009, 'Jesus Is King'),
(5000011, 7000015, 'So Much Fun'),
(5000020, 7000007, 'Last Winter'),
(5000021, 7000007, 'Milky Way'),
(5000022, 7000002, 'Vampire Weekend'),
(5000023, 7000002, 'Father of the Bride'),
(5000024, 7000003, 'Doris'),
(5000025, 7000004, 'I Told You'),
(5000026, 7000004, 'Chixtape 5'),
(5000027, 7000005, 'Section.80'),
(5000028, 7000009, 'The Life of Pablo'),
(5000029, 7000005, 'Damn.'),
(5000030, 7000008, 'Thank Me Later'),
(5000031, 7000008, 'Scorpion'),
(5000032, 7000009, 'The College Dropout'),
(5000033, 7000010, 'The Lost Boy'),
(5000034, 7000011, 'Cole Word: The Sideline Story'),
(5000035, 7000011, 'KOD'),
(5000036, 7000012, 'My Name Is My Name'),
(5000037, 7000012, 'Daytona'),
(5000038, 7000014, 'Seven + Mary'),
(5000039, 7000014, 'How to: Friend, Love, Freefall'),
(5000040, 7000011, '4 Your Eyez Only'),
(5000041, 7000009, 'Yeezus'),
(5000042, 7000003, 'Feet of Clay');

-- --------------------------------------------------------

--
-- Table structure for table `Album_Rating`
--

CREATE TABLE `Album_Rating` (
  `reviewer_ID` int NOT NULL,
  `album_ID` int NOT NULL,
  `album_Score` int DEFAULT NULL,
  `review_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Album_Rating`
--

INSERT INTO `Album_Rating` (`reviewer_ID`, `album_ID`, `album_Score`) VALUES
(1000001, 5000001, 7),
(1000001, 5000003, 8),
(1000001, 5000005, 5),
(1000001, 5000006, 9),
(1000001, 5000007, 6),
(1000001, 5000010, 3),
(1000001, 5000028, 8),
(1000001, 5000040, 10),
(1000002, 5000001, 8),
(1000002, 5000002, 9),
(1000002, 5000004, 8),
(1000002, 5000006, 9),
(1000002, 5000010, 5),
(1000003, 5000001, 7),
(1000003, 5000002, 8),
(1000003, 5000003, 7),
(1000003, 5000004, 8),
(1000003, 5000006, 10),
(1000003, 5000007, 8),
(1000003, 5000008, 5),
(1000003, 5000011, 7),
(1000003, 5000023, 6),
(1000003, 5000024, 6),
(1000003, 5000027, 8),
(1000003, 5000029, 7),
(1000003, 5000031, 4),
(1000003, 5000033, 7),
(1000003, 5000034, 6),
(1000003, 5000035, 5),
(1000003, 5000037, 8),
(1000003, 5000040, 6),
(1000004, 5000001, 7),
(1000004, 5000004, 7),
(1000004, 5000005, 6),
(1000004, 5000006, 9),
(1000004, 5000010, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Album_Type`
--

CREATE TABLE `Album_Type` (
  `genre_ID` int NOT NULL,
  `album_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Album_Type`
--

INSERT INTO `Album_Type` (`genre_ID`, `album_ID`) VALUES
(1, 5000003),
(2, 5000006),
(3, 5000007),
(5, 5000010),
(2, 5000028),
(2, 5000029),
(2, 5000030),
(2, 5000031),
(2, 5000032),
(2, 5000033),
(2, 5000034),
(2, 5000035),
(2, 5000036),
(2, 5000037),
(7, 5000038),
(7, 5000039),
(2, 5000040),
(2, 5000041),
(2, 5000042);

-- --------------------------------------------------------

--
-- Table structure for table `Artist`
--

CREATE TABLE `Artist` (
  `artist_ID` int NOT NULL,
  `debut_Album` int DEFAULT NULL,
  `latest_Album` int DEFAULT NULL,
  `artist_Name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Artist`
--

INSERT INTO `Artist` (`artist_ID`, `debut_Album`, `latest_Album`, `artist_Name`) VALUES
(7000001, 5000001, 5000002, 'Frank Ocean'),
(7000002, 5000022, 5000023, 'Vampire Weekend'),
(7000003, 5000024, 5000042, 'Earl Sweatshirt'),
(7000004, 5000025, 5000026, 'Tory Lanez'),
(7000005, 5000027, 5000029, 'Kendrick Lamar'),
(7000006, 5000007, 5000007, 'Slowthai'),
(7000007, 5000020, 5000021, 'Bas'),
(7000008, 5000030, 5000031, 'Drake'),
(7000009, 5000032, 5000010, 'Kanye West'),
(7000010, 5000033, 5000033, 'YBN Cordae'),
(7000011, 5000034, 5000035, 'J. Cole'),
(7000012, 5000036, 5000037, 'Pusha T'),
(7000014, 5000038, 5000039, 'Rainbow Kitten Surprise'),
(7000015, 5000011, 5000011, 'Young Thug');

-- --------------------------------------------------------

--
-- Table structure for table `Genre`
--

CREATE TABLE `Genre` (
  `genre_ID` int NOT NULL,
  `genre_Name` varchar(50) DEFAULT NULL,
  `genre_Desc` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Genre`
--

INSERT INTO `Genre` (`genre_ID`, `genre_Name`, `genre_Desc`) VALUES
(0, 'Other', 'Miscellaneous genre.'),
(1, 'Indie Pop Rock', 'Mostly upbeat rock music with heavy focus on melody and lyrical storytelling'),
(2, 'Modern Hip Hop', 'Hip hop music, also known as rap music, is a style of music which came into existence in the United States during the mid- 1970s, and became a large part of modern pop culture during the 1980s. It consists of two main components: rapping ( MCing) and DJing ( production and scratching).'),
(3, 'Grime', 'Style of hip hop that comes from the UK. Heavily influenced by American trap music.'),
(4, 'Country', 'Country music, also known as country and western, and hillbilly music, is a genre of popular music that originated in the Southern United States in the early 1920s. It takes its roots from genres such as American folk music and blues.'),
(5, 'Gospel', 'Songs with a focus in Christian religious teachings and vocal choirs'),
(6, 'Ambient', 'Music that is intended to function as background noise.'),
(7, 'Indie Folk', 'Music recorded by smaller bands that have heavy lyrics and melodies most associated with folk songs.');

-- --------------------------------------------------------

--
-- Table structure for table `Reviewer`
--

CREATE TABLE `Reviewer` (
  `reviewer_ID` int NOT NULL,
  `reviewer_FName` char(20) DEFAULT NULL,
  `reviewer_LName` char(20) DEFAULT NULL,
  `reviewer_DOB` date NOT NULL,
  `reviewer_Email` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Reviewer`
--

INSERT INTO `Reviewer` (`reviewer_ID`, `reviewer_FName`, `reviewer_LName`, `reviewer_DOB`, `reviewer_Email`) VALUES
(1000001, 'Payton', 'Weatherspoon', '1999-03-13', 'paytonweatherspoon@gmail.com'),
(1000002, 'Aidan', 'Shene', '1999-06-21', 'aidanshene@gmail.com'),
(1000003, 'Anthony', 'Fantano', '1985-10-28', 'anthony@theneedledrop.com'),
(1000004, 'Alex', 'Bolsoy', '1998-12-23', 'abolsoy@gmail.com'),
(1000005, 'John', 'Smith', '1999-12-31', 'email@email.com'),
(1000006, 'John', 'Smith', '1999-12-31', 'email@email.com'),
(1000007, 'John', 'Smith', '1212-12-12', 'email@email.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Album`
--
ALTER TABLE `Album`
  ADD PRIMARY KEY (`album_ID`),
  ADD KEY `artist_ID` (`artist_ID`),
  ADD KEY `artist_ID_2` (`artist_ID`),
  ADD KEY `artist_ID_3` (`artist_ID`);

--
-- Indexes for table `Album_Contributors`
--
ALTER TABLE `Album_Contributors`
  ADD PRIMARY KEY (`album_ID`,`artist_ID`),
  ADD KEY `Album_Contributors_ibfk_2` (`artist_ID`);

--
-- Indexes for table `Album_Rating`
--
ALTER TABLE `Album_Rating`
  ADD PRIMARY KEY (`reviewer_ID`,`album_ID`),
  ADD KEY `Album_Rating_ibfk_2` (`album_ID`);

--
-- Indexes for table `Album_Type`
--
ALTER TABLE `Album_Type`
  ADD PRIMARY KEY (`genre_ID`,`album_ID`),
  ADD KEY `Album FK` (`album_ID`);

--
-- Indexes for table `Artist`
--
ALTER TABLE `Artist`
  ADD PRIMARY KEY (`artist_ID`),
  ADD KEY `debut_Album` (`debut_Album`),
  ADD KEY `Artist_ibfk_2` (`latest_Album`);

--
-- Indexes for table `Genre`
--
ALTER TABLE `Genre`
  ADD PRIMARY KEY (`genre_ID`);

--
-- Indexes for table `Reviewer`
--
ALTER TABLE `Reviewer`
  ADD PRIMARY KEY (`reviewer_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Album`
--
ALTER TABLE `Album`
  ADD CONSTRAINT `Artist Foreign Key` FOREIGN KEY (`artist_ID`) REFERENCES `Artist` (`artist_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Album_Contributors`
--
ALTER TABLE `Album_Contributors`
  ADD CONSTRAINT `Album_Contributors_ibfk_1` FOREIGN KEY (`album_ID`) REFERENCES `Album` (`album_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Album_Contributors_ibfk_2` FOREIGN KEY (`artist_ID`) REFERENCES `Artist` (`artist_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Album_Rating`
--
ALTER TABLE `Album_Rating`
  ADD CONSTRAINT `Album_Rating_ibfk_1` FOREIGN KEY (`reviewer_ID`) REFERENCES `Reviewer` (`reviewer_ID`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `Album_Rating_ibfk_2` FOREIGN KEY (`album_ID`) REFERENCES `Album` (`album_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Album_Type`
--
ALTER TABLE `Album_Type`
  ADD CONSTRAINT `Album FK` FOREIGN KEY (`album_ID`) REFERENCES `Album` (`album_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Genre FK` FOREIGN KEY (`genre_ID`) REFERENCES `Genre` (`genre_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Artist`
--
ALTER TABLE `Artist`
  ADD CONSTRAINT `Artist_ibfk_1` FOREIGN KEY (`debut_Album`) REFERENCES `Album` (`album_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Artist_ibfk_2` FOREIGN KEY (`latest_Album`) REFERENCES `Album` (`album_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
