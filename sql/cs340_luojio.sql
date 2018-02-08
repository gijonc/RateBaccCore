-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: classmysql.engr.oregonstate.edu:3306
-- Generation Time: Dec 19, 2017 at 12:42 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs340_luojio`
--

-- --------------------------------------------------------

--
-- Table structure for table `ANSWER`
--

CREATE TABLE `ANSWER` (
  `aID` int(11) NOT NULL,
  `answer` text NOT NULL,
  `aTime` date NOT NULL,
  `userID` int(11) NOT NULL,
  `quesID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ANSWER`
--

INSERT INTO `ANSWER` (`aID`, `answer`, `aTime`, `userID`, `quesID`) VALUES
(19, 'some theoretical stuff', '2017-06-13', 3, 20),
(20, 'Yes, it\'s required for all CS major students', '2017-06-15', 3, 22),
(22, 'Mr. Lee', '2017-06-15', 3, 23),
(24, 'Wondering which to take...', '2017-06-15', 22, 25),
(27, 'fgdfgd', '2017-06-16', 3, 33),
(28, 'kkkk', '2017-06-16', 3, 33),
(29, 'klkl', '2017-06-16', 3, 33),
(30, 'I think so', '2017-06-16', 24, 22),
(31, 'fdsf', '2017-06-16', 3, 36),
(32, '201 is micro and 202 is macro', '2017-06-16', 26, 25);

-- --------------------------------------------------------

--
-- Table structure for table `COMMENT`
--

CREATE TABLE `COMMENT` (
  `cmID` int(11) NOT NULL,
  `cmDiff` int(2) NOT NULL,
  `cmRecLv` int(2) NOT NULL,
  `cmText` text,
  `cmInst` varchar(255) DEFAULT NULL,
  `cmTermTook` char(10) NOT NULL,
  `cmYearTook` int(4) NOT NULL,
  `cmTime` date NOT NULL,
  `userID` int(11) NOT NULL,
  `courseID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `COMMENT`
--

INSERT INTO `COMMENT` (`cmID`, `cmDiff`, `cmRecLv`, `cmText`, `cmInst`, `cmTermTook`, `cmYearTook`, `cmTime`, `userID`, `courseID`) VALUES
(12, 4, 9, NULL, 'John', 'winter', 2016, '0000-00-00', 2, 'cs391'),
(16, 8, 7, '', '', 'summer', 2014, '2017-06-08', 4, 'cs391'),
(57, 8, 9, NULL, NULL, 'summer', 2012, '2017-06-08', 6, 'econ201'),
(70, 10, 10, '', '', 'spring', 2014, '2017-06-15', 3, 'anth101'),
(72, 10, 8, NULL, NULL, 'summer', 2015, '2017-06-14', 3, 'film220'),
(73, 8, 7, NULL, NULL, 'spring', 2011, '2017-06-14', 3, 'geo101'),
(74, 4, 3, NULL, NULL, 'summer', 2012, '2017-06-14', 3, 'hdfs201'),
(75, 8, 3, NULL, NULL, 'summer', 2013, '2017-06-14', 3, 'mus108'),
(76, 8, 3, NULL, NULL, 'summer', 2013, '2017-06-14', 3, 'hst101'),
(77, 8, 8, NULL, NULL, 'summer', 2014, '2017-06-14', 4, 'anth101'),
(78, 8, 8, '', '', 'summer', 2016, '2017-06-14', 4, 'hdfs201'),
(79, 10, 8, NULL, NULL, 'summer', 2014, '2017-06-15', 3, 'phl310'),
(80, 6, 7, NULL, NULL, 'winter', 2012, '2017-06-15', 20, 'cs391'),
(81, 10, 5, 'This class is fun', 'Mr. Bean', 'spring', 2012, '2017-06-15', 3, 'cs391'),
(82, 2, 8, NULL, '--', 'spring', 2014, '2017-06-15', 22, 'cs391'),
(91, 10, 10, '', '', 'winter', 2012, '2017-06-16', 23, 'art101'),
(94, 2, 1, 'Very easy', 'Mickey Mouse', 'summer', 2016, '2017-06-16', 26, 'anth101');

--
-- Triggers `COMMENT`
--
DELIMITER $$
CREATE TRIGGER `autoUpdate_COMMENT_delete` AFTER DELETE ON `COMMENT` FOR EACH ROW BEGIN    
	UPDATE COURSE 
    SET COURSE.diff = (SELECT AVG(COMMENT.cmDiff) 
                       FROM COMMENT 
                       WHERE COURSE.cID = COMMENT.courseID),
    COURSE.RecLv = (SELECT AVG(COMMENT.cmRecLv) 
                       FROM COMMENT 
                       WHERE COURSE.cID = COMMENT.courseID); 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `autoUpdate_COMMENT_update` AFTER UPDATE ON `COMMENT` FOR EACH ROW BEGIN    
	UPDATE COURSE 
    SET COURSE.diff = (SELECT AVG(COMMENT.cmDiff) 
                       FROM COMMENT 
                       WHERE COURSE.cID = COMMENT.courseID),
    COURSE.RecLv = (SELECT AVG(COMMENT.cmRecLv) 
                       FROM COMMENT 
                       WHERE COURSE.cID = COMMENT.courseID); 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `autoUpdate_COURSE_insert` AFTER INSERT ON `COMMENT` FOR EACH ROW BEGIN    
	UPDATE COURSE 
    SET COURSE.diff = (SELECT AVG(COMMENT.cmDiff) 
                       FROM COMMENT 
                       WHERE COURSE.cID = COMMENT.courseID),
    COURSE.RecLv = (SELECT AVG(COMMENT.cmRecLv) 
                       FROM COMMENT 
                       WHERE COURSE.cID = COMMENT.courseID); 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `COURSE`
--

CREATE TABLE `COURSE` (
  `cID` varchar(20) NOT NULL,
  `creditNum` int(11) NOT NULL,
  `diff` decimal(3,1) DEFAULT '0.0',
  `RecLv` decimal(3,1) DEFAULT '0.0',
  `category` varchar(255) NOT NULL,
  `cDesc` text,
  `cName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `COURSE`
--

INSERT INTO `COURSE` (`cID`, `creditNum`, `diff`, `RecLv`, `category`, `cDesc`, `cName`) VALUES
('anth101', 3, '6.7', '6.3', 'spi', 'Located at the intersection of the humanities and the sciences, anthropology strives for a holistic understanding of the human condition. This course introduces students to the basic concepts, theories and methods of anthropology, including its four main sub-fields: archaeology, biological anthropology, cultural anthropology, and linguistic anthropology. The course is driven by fundamental questions, including: What is culture? How do anthropologists study human populations, both past and present? How can this field help us better understand contemporary human problems?', 'INTRODUCTION TO ANTHROPOLOGY'),
('art101', 4, '10.0', '10.0', 'l&a', 'An introductory lecture course using visual materials with emphasis on methods and motivations that generate the visual experience, both past and present.', 'INTRODUCTION TO THE VISUAL ARTS'),
('cs391', 3, '6.0', '7.2', 'sts', 'In-depth exploration of the social, psychological, political, and ethical issues surrounding the computer industry and the evolving information society.', 'SOCIAL AND ETHICAL ISSUES IN COMPUTER SCIENCE'),
('econ201', 4, '8.0', '9.0', 'spi', 'An introduction to microeconomic principles including the study of price theory, economic scarcity, consumer behavior, production costs, the theory of the firm, market structure, and income distribution. Other selected topics may include market failure, international economics, and public finance. (SS) (Bacc Core Course) PREREQS: MTH 111 or equivalent is recommended.', 'INTRODUCTION TO MICROECONOMICS'),
('film220', 4, '10.0', '8.0', 'dpd', 'A comparative treatment of literary topics in the context of institutional and systematic discrimination. Not offered every year. CROSSLISTED as ENG 220.', 'TOPICS IN DIFFERENCE, POWER, AND DISCRIMINATION'),
('geo101', 4, '8.0', '7.0', 'ps', 'Solid earth processes and materials. Earthquakes, volcanoes, earth structure, rocks, minerals, ores. Solid earth hazard prediction and planning.', 'NATURAL DISASTERS: HOLLYWOOD VERSUS REALITY'),
('hdfs201', 3, '6.0', '5.5', 'spi', 'An introduction to families with application to personal life. Focuses on diversity in family structure, social class, race, gender, work and other social institutions.', 'CONTEMPORARY FAMILIES IN THE U.S.'),
('hst101', 4, '8.0', '3.0', 'wc', 'Provides an awareness and understanding of the Western cultural heritage. Stresses the major ideas and developments that have been of primary importance in shaping the Western tradition. Covers the Ancient World to 1000 A.D. HST 101, HST 102 and HST 103 need not be taken in sequence.', 'HISTORY OF WESTERN CIVILIZATION'),
('mus108', 3, '8.0', '3.0', 'cd', 'Survey of the world\'s music with attention to musical styles and cultural contexts. Included are Oceania, Indonesia, Africa, Asia, Latin America. (See Schedule of Classes for subject being offered.) For non-majors. (NC) (Bacc Core Course) This course is repeatable for a maximum of 18 credits. ', 'MUSIC CULTURES OF THE WORLD'),
('phl310', 4, '10.0', '8.0', 'cgi', 'An introduction to critiques of religion by Nietzsche, Freud, Marx, and other influential thinkers. Examines the nature, scope, and effects of criticisms that challenge the psychological, moral, political, and epistemological foundations of religious belief, practice, and institutions.', 'CRITICS OF RELIGION');

-- --------------------------------------------------------

--
-- Table structure for table `QUESTION`
--

CREATE TABLE `QUESTION` (
  `qID` int(11) NOT NULL,
  `question` text NOT NULL,
  `qTime` date NOT NULL,
  `courseID` varchar(20) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `QUESTION`
--

INSERT INTO `QUESTION` (`qID`, `question`, `qTime`, `courseID`, `userID`) VALUES
(20, 'what is class doing?', '2017-06-13', 'cs391', 1),
(22, 'Is this required for CS major students?', '2017-06-13', 'cs391', 2),
(23, 'Which instructor is recommended for this class?', '2017-06-14', 'anth101', 4),
(24, 'Is this class hard?', '2017-06-15', 'anth101', 3),
(25, 'What is the difference between ECON 201 and 202?', '2017-06-15', 'econ201', 22),
(33, 'fdfd', '2017-06-16', 'art101', 3),
(34, 'll', '2017-06-16', 'art101', 3),
(35, 'is this course easy?', '2017-06-16', 'cs391', 24),
(36, 'dsf', '2017-06-16', 'anth101', 3),
(37, 'Why is it so difficult?', '2017-06-16', 'art101', 26);

--
-- Triggers `QUESTION`
--
DELIMITER $$
CREATE TRIGGER `deleteRelatedAnswers` AFTER DELETE ON `QUESTION` FOR EACH ROW BEGIN
	DELETE FROM ANSWER WHERE ANSWER.quesID = OLD.qID;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `USER`
--

CREATE TABLE `USER` (
  `uID` int(11) NOT NULL,
  `uEmail` varchar(40) NOT NULL,
  `uPswd` varchar(255) NOT NULL,
  `uType` varchar(20) NOT NULL,
  `signup_t` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`uID`, `uEmail`, `uPswd`, `uType`, `signup_t`) VALUES
(1, 'rogersdljc@gmail.com', '123123', 'student', '2017-05-10'),
(2, 'test@osu.edu', 'qweqwe', 'student', '2017-05-10'),
(3, 'admin@osu.edu', 'qweqwe', 'student', '2017-05-10'),
(4, 'number@er.edu', 'werwer', 'student', '0000-00-00'),
(6, 'someone@osu.edu', 'zxczxc', 'student', '2017-05-31'),
(7, 'l@l.ooo', 'zxczxc', 'student', '2017-06-02'),
(8, 'qwe@oo.edu', '123123', 'student', '2017-06-02'),
(11, 'dsfds@wer.com', 'qweqwe', 'student', '2017-06-04'),
(12, 'test@qwe.com', '123123', 'student', '2017-06-04'),
(13, 'qwe@aa.com', '123123', 'student', '2017-06-04'),
(14, 'qwe@asd.com', '123123', 'student', '2017-06-04'),
(15, 'asd@dfg.com', 'qweqwe', 'student', '2017-06-04'),
(18, 'hello@mm.com', '123123', 'Instructor', '2017-06-14'),
(19, 'cvb@bvc.edu', 'qweqwe', 'Student', '2017-06-14'),
(20, 'beaver@osu.edu', 'qweqwe', 'Student', '2017-06-15'),
(21, 'abc@osu.edu', '123123', 'Instructor', '2017-06-15'),
(22, 'xcv@osu.edu', 'qweqwe', 'Instructor', '2017-06-15'),
(23, 'ert@osu.edu', '123123', 'Student', '2017-06-16'),
(24, 'example@osu.edu', 'qweqwe', 'Instructor', '2017-06-16'),
(25, 'jj@gmail.com', 'password', 'Student', '2017-06-16'),
(26, 'ben@osu.edu', 'Abc123', 'Instructor', '2017-06-16'),
(27, 'john@gmail.com', 'Qwe101', 'Student', '2017-06-16'),
(28, 'asd@qqq.com', 'roger8169', 'Instructor', '2017-10-31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ANSWER`
--
ALTER TABLE `ANSWER`
  ADD PRIMARY KEY (`aID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `quesID` (`quesID`);

--
-- Indexes for table `COMMENT`
--
ALTER TABLE `COMMENT`
  ADD PRIMARY KEY (`cmID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `courseID` (`courseID`);

--
-- Indexes for table `COURSE`
--
ALTER TABLE `COURSE`
  ADD PRIMARY KEY (`cID`);

--
-- Indexes for table `QUESTION`
--
ALTER TABLE `QUESTION`
  ADD PRIMARY KEY (`qID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `courseID` (`courseID`);

--
-- Indexes for table `USER`
--
ALTER TABLE `USER`
  ADD PRIMARY KEY (`uID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ANSWER`
--
ALTER TABLE `ANSWER`
  MODIFY `aID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `COMMENT`
--
ALTER TABLE `COMMENT`
  MODIFY `cmID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `QUESTION`
--
ALTER TABLE `QUESTION`
  MODIFY `qID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `USER`
--
ALTER TABLE `USER`
  MODIFY `uID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ANSWER`
--
ALTER TABLE `ANSWER`
  ADD CONSTRAINT `ANSWER_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `USER` (`uID`),
  ADD CONSTRAINT `ANSWER_ibfk_2` FOREIGN KEY (`quesID`) REFERENCES `QUESTION` (`qID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `COMMENT`
--
ALTER TABLE `COMMENT`
  ADD CONSTRAINT `COMMENT_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `USER` (`uID`),
  ADD CONSTRAINT `COMMENT_ibfk_2` FOREIGN KEY (`courseID`) REFERENCES `COURSE` (`cID`);

--
-- Constraints for table `QUESTION`
--
ALTER TABLE `QUESTION`
  ADD CONSTRAINT `QUESTION_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `USER` (`uID`),
  ADD CONSTRAINT `QUESTION_ibfk_2` FOREIGN KEY (`courseID`) REFERENCES `COURSE` (`cID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
