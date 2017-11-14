-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 02, 2017 at 10:29 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `CSCC01`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignment_id` int(25) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignment_id`, `start_date`, `end_date`) VALUES
(1, '2017-10-18 12:51:00', '2017-11-11 12:51:00'),
(2, '2017-10-29 01:08:00', '2017-10-30 01:08:00'),
(3, '2017-10-18 01:14:00', '2017-11-10 01:14:00'),
(4, '2017-10-24 01:20:00', '2017-11-10 01:20:00'),
(5, '2017-10-27 01:28:00', '2017-11-11 01:28:00'),
(6, '2017-10-19 03:41:00', '2017-11-10 03:41:00'),
(7, '2017-10-10 03:56:00', '2017-11-10 03:57:00'),
(8, '2017-10-29 17:24:00', '2017-10-29 17:24:00'),
(9, '2017-10-29 22:16:00', '2017-10-30 22:16:00'),
(10, '2017-10-30 01:17:00', '2017-10-30 01:16:00'),
(11, '2017-11-05 16:55:00', '2017-11-11 16:55:00'),
(12, '2017-10-30 21:23:00', '2017-10-30 21:50:00'),
(13, '2017-10-30 21:31:00', '2017-10-30 21:31:00'),
(14, '2017-10-30 21:36:00', '2017-10-30 21:36:00'),
(15, '2017-10-30 21:39:00', '2017-10-30 21:40:00'),
(16, '2017-10-30 21:49:00', '2017-10-30 21:49:00'),
(17, '2017-10-30 22:22:00', '2017-10-30 22:22:00'),
(18, '2017-10-24 18:14:00', '2017-10-19 18:14:00'),
(19, '2017-11-01 22:26:00', '2017-11-02 22:26:00'),
(20, '2017-11-01 23:10:00', '2017-11-01 23:10:00'),
(21, '2017-11-01 23:33:00', '2017-10-31 23:33:00'),
(22, '2017-10-11 23:44:00', '2017-10-10 23:44:00'),
(23, '2017-11-08 12:48:00', '2017-11-02 12:48:00'),
(24, '2017-11-01 12:50:00', '2017-11-02 12:50:00'),
(25, '2017-11-04 12:59:00', '2017-02-08 12:59:00'),
(26, '2017-11-01 01:04:00', '2017-11-01 01:04:00'),
(27, '2017-11-23 01:04:00', '2017-11-17 01:04:00'),
(28, '2017-11-07 01:07:00', '2017-11-01 01:07:00'),
(29, '2017-11-13 01:18:00', '2017-11-04 01:18:00'),
(30, '2017-11-08 15:15:00', '2017-11-23 15:15:00'),
(31, '2017-11-02 15:16:00', '2017-11-02 15:16:00'),
(32, '2017-10-30 17:32:00', '2017-11-02 17:32:00'),
(33, '2017-11-01 22:25:00', '2017-12-28 22:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(25) NOT NULL,
  `assignment_id` int(25) NOT NULL,
  `location` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `assignment_id`, `location`) VALUES
(1, 1, 'questions/question9.txt'),
(2, 1, 'questions/question9.txt'),
(3, 1, 'questions/question9.txt'),
(4, 1, 'questions/question9.txt'),
(5, 2, 'questions/question9.txt'),
(6, 2, 'questions/question9.txt'),
(7, 2, 'questions/question9.txt'),
(8, 2, 'questions/question9.txt'),
(9, 2, 'questions/question9.txt'),
(10, 2, 'questions/question9.txt'),
(11, 2, 'questions/question9.txt'),
(12, 2, 'questions/question9.txt'),
(13, 4, 'questions/question10.txt'),
(14, 4, 'questions/question9.txt'),
(15, 4, 'questions/question11.txt'),
(16, 4, 'questions/question10.txt'),
(17, 5, 'questions/question12.txt'),
(18, 5, 'questions/question9.txt'),
(19, 5, 'questions/question13.txt'),
(20, 5, 'questions/question12.txt'),
(21, 6, 'questions/question9.txt'),
(22, 6, 'questions/question14.txt'),
(23, 6, 'questions/question14.txt'),
(24, 6, 'questions/question14.txt'),
(25, 6, 'questions/question14.txt'),
(26, 7, 'questions/question15.txt'),
(27, 7, 'questions/question9.txt'),
(28, 7, 'questions/question14.txt'),
(29, 8, 'questions/question16.txt'),
(30, 8, 'questions/question14.txt'),
(31, 8, 'questions/question9.txt'),
(32, 1, 'questions/question1.txt'),
(33, 1, 'questions/question2.txt'),
(34, 1, 'questions/question3.txt'),
(35, 1, 'questions/question4.txt'),
(36, 1, 'questions/question5.txt'),
(37, 1, 'questions/question6.txt'),
(38, 1, 'questions/question7.txt'),
(39, 1, 'questions/question8.txt'),
(40, 1, 'questions/question9.txt'),
(41, 1, 'questions/question10.txt'),
(42, 1, 'questions/question11.txt'),
(43, 1, 'questions/question12.txt'),
(44, 1, 'questions/question13.txt'),
(45, 1, 'questions/question14.txt'),
(46, 1, 'questions/question15.txt'),
(47, 1, 'questions/question16.txt'),
(48, 1, 'questions/question17.txt'),
(49, 9, 'questions/question9.txt'),
(50, 9, 'questions/question10.txt'),
(51, 1, 'questions/question18.txt'),
(52, 9, 'questions/question17.txt'),
(53, 1, 'questions/question19.txt'),
(54, 1, 'questions/question20.txt'),
(55, 10, 'questions/question10.txt'),
(56, 1, 'questions/question21.txt'),
(57, 1, 'questions/question22.txt'),
(58, 1, 'questions/question23.txt'),
(59, 10, 'questions/question17.txt'),
(60, 1, 'questions/question24.txt'),
(61, 11, 'questions/question18.txt'),
(62, 11, 'questions/question19.txt'),
(63, 11, 'questions/question14.txt'),
(64, 12, 'questions/question20.txt'),
(65, 12, 'questions/question17.txt'),
(66, 13, 'questions/question24.txt'),
(67, 15, 'questions/question24.txt'),
(68, 15, 'questions/question9.txt'),
(69, 15, 'questions/question9.txt'),
(70, 17, 'questions/question9.txt'),
(71, 17, 'questions/question10.txt'),
(72, 1, 'questions/question25.txt'),
(73, 19, 'questions/question9.txt'),
(74, 19, 'questions/question9.txt'),
(75, 19, 'questions/question10.txt'),
(76, 19, 'questions/question11.txt'),
(77, 22, 'questions/question9.txt'),
(78, 22, 'questions/question14.txt'),
(79, 22, 'questions/question16.txt'),
(80, 22, 'questions/question1.txt'),
(81, 22, 'questions/question15.txt'),
(82, 22, 'questions/question3.txt'),
(83, 22, 'questions/question9.txt'),
(84, 22, 'questions/question13.txt'),
(85, 22, 'questions/question12.txt'),
(86, 22, 'questions/question4.txt'),
(87, 22, 'questions/question15.txt'),
(88, 22, 'questions/question11.txt'),
(89, 23, 'questions/question2.txt'),
(90, 24, 'questions/question11.txt'),
(91, 24, 'questions/question12.txt'),
(92, 24, 'questions/question12.txt'),
(93, 25, 'questions/question21.txt'),
(94, 25, 'questions/question9.txt'),
(95, 26, 'questions/question11.txt'),
(96, 29, 'questions/question12.txt'),
(97, 29, 'questions/question15.txt'),
(98, 29, 'questions/question10.txt'),
(99, 29, 'questions/question2.txt'),
(100, 1, 'questions/question26.txt'),
(101, 30, 'questions/question14.txt'),
(102, 30, 'questions/question14.txt'),
(103, 30, 'questions/question15.txt'),
(104, 30, 'questions/question10.txt'),
(105, 30, 'questions/question10.txt'),
(106, 30, 'questions/question10.txt'),
(107, 30, 'questions/question16.txt'),
(108, 30, 'questions/question12.txt'),
(109, 30, 'questions/question15.txt'),
(110, 30, 'questions/question1.txt'),
(111, 31, 'questions/question26.txt'),
(112, 31, 'questions/question15.txt'),
(113, 1, 'questions/question27.txt'),
(114, 1, 'questions/question28.txt'),
(115, 32, 'questions/question29.txt'),
(116, 32, 'questions/question29.txt'),
(117, 32, 'questions/question15.txt'),
(118, 32, 'questions/question16.txt'),
(119, 32, 'questions/question10.txt'),
(120, 1, 'questions/question30.txt'),
(121, 33, 'questions/question5.txt'),
(122, 33, 'questions/question13.txt'),
(123, 33, 'questions/question15.txt'),
(124, 33, 'questions/question11.txt'),
(125, 33, 'questions/question15.txt'),
(126, 33, 'questions/question13.txt'),
(127, 33, 'questions/question2.txt'),
(128, 33, 'questions/question16.txt'),
(129, 33, 'questions/question1.txt'),
(130, 33, 'questions/question13.txt'),
(131, 33, 'questions/question3.txt'),
(132, 33, 'questions/question15.txt'),
(133, 33, 'questions/question9.txt'),
(134, 33, 'questions/question3.txt'),
(135, 33, 'questions/question12.txt'),
(136, 33, 'questions/question13.txt'),
(137, 33, 'questions/question12.txt'),
(138, 33, 'questions/question2.txt'),
(139, 33, 'questions/question14.txt'),
(140, 33, 'questions/question10.txt'),
(141, 33, 'questions/question3.txt');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `student_id` int(11) NOT NULL,
  `a1` int(11) NOT NULL,
  `a2` int(11) NOT NULL,
  `a3` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignment_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`student_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
