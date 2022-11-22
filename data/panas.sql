-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2022 at 05:14 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `panas`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE `auth` (
  `login_id` bigint(20) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `login_email` varchar(30) NOT NULL,
  `generated_code` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`login_id`, `login_time`, `login_email`, `generated_code`, `name`) VALUES
(37, '2022-11-06 04:34:37', 'yosepalmanza@hotmail.com', 193183, ' Yosep Almanza'),
(38, '2022-11-06 17:14:59', 'yosepalmanza@hotmail.com', 516363, ' Yosep Almanza'),
(39, '2022-11-07 03:39:08', 'yosepalmanza@hotmail.com', 330460, ' Yosep Almanza'),
(40, '2022-11-07 03:44:41', 'yosepalmanza@hotmail.com', 235218, ' Yosep Almanza'),
(41, '2022-11-07 03:44:48', 'yosepalmanza@hotmail.com', 405098, ' Yosep Almanza'),
(42, '2022-11-07 03:45:26', 'yosepalmanza@hotmail.com', 959859, ' Yosep Almanza'),
(43, '2022-11-08 03:37:22', 'yosepalmanza@hotmail.com', 347686, ' Yosep Almanza');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_code` int(11) NOT NULL,
  `course_name` varchar(20) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Contains the courses for the database';

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_code`, `course_name`, `added_on`) VALUES
(1, 'Reading', '2022-11-05 17:27:14'),
(2, 'Skills', '2022-11-05 17:27:35'),
(3, 'Writing', '2022-11-05 17:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `meeting_id` bigint(10) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `tutor_id` bigint(20) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `notes` longtext NOT NULL,
  `hour` int(11) NOT NULL,
  `minute` int(11) NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `section` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`meeting_id`, `time`, `date`, `student_id`, `tutor_id`, `completed`, `notes`, `hour`, `minute`, `confirmed`, `section`) VALUES
(52934530, '18:44:00', '2022-11-07', 1, 1, 0, '', 18, 44, 1, 'pm');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `email_confirmed` tinyint(1) NOT NULL DEFAULT 1,
  `confimed_date` date NOT NULL DEFAULT current_timestamp(),
  `member_since` date NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `name`, `email`, `email_confirmed`, `confimed_date`, `member_since`, `is_active`, `last_login`) VALUES
(0, '', '', 1, '2022-11-05', '2022-11-05', 1, '2022-11-06 04:40:38');

-- --------------------------------------------------------

--
-- Table structure for table `teaches`
--

CREATE TABLE `teaches` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(10) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `registered_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `course_code` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='List courses that are available and who teaches what';

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `tutor_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `email_confirmed` tinyint(1) NOT NULL DEFAULT 1,
  `confirmed_date` date NOT NULL DEFAULT current_timestamp(),
  `memeber_since` date NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `available` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`available`)),
  `courses` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`courses`)),
  `meetingdays` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`meetingdays`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='table for tutors';

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`tutor_id`, `name`, `email`, `email_confirmed`, `confirmed_date`, `memeber_since`, `is_active`, `available`, `courses`, `meetingdays`) VALUES
(1, ' Yosep Almanza', 'yosepalmanza@hotmail.com', 1, '2022-11-05', '2022-11-05', 0, '[{\"day\":\"Monday\",\"starthour\":\"04\",\"startminute\":\"00\",\"secstart\":\"PM\",\"endhour\":\"05\",\"endminute\":\"00\",\"secend\":\"PM\"},{\"day\":\"Tuesday\",\"starthour\":\"12\",\"startminute\":\"00\",\"secstart\":\"AM\",\"endhour\":\"05\",\"endminute\":\"00\",\"secend\":\"PM\"}]', '[\"Reading\",\"Skills\"]', '[\"Monday\",\"Tuesday\"]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`login_id`),
  ADD UNIQUE KEY `auth_ak_1` (`login_id`),
  ADD UNIQUE KEY `generated_code` (`generated_code`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_code`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`meeting_id`),
  ADD UNIQUE KEY `meetings_ak_1` (`meeting_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `teaches`
--
ALTER TABLE `teaches`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_id` (`course_id`);

--
-- Indexes for table `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`tutor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth`
--
ALTER TABLE `auth`
  MODIFY `login_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teaches`
--
ALTER TABLE `teaches`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tutors`
--
ALTER TABLE `tutors`
  MODIFY `tutor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
