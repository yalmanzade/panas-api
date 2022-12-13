-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2022 at 05:41 PM
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
  `login_date` date NOT NULL DEFAULT current_timestamp(),
  `login_email` varchar(30) NOT NULL,
  `generated_code` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `login_time` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`login_id`, `login_date`, `login_email`, `generated_code`, `name`, `login_time`) VALUES
(146, '2022-12-12', 'yosepalmanza@hotmail.com', 225035, 'Yosep Almanza', '20:17:45'),
(147, '2022-12-12', 'student1@onlinetutoring.com', 368252, 'Calvin Todd', '20:19:56');

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
(2, 'Skills', '2022-11-05 17:27:35'),
(3, 'Writing', '2022-11-05 17:27:46'),
(15, 'Reading', '2022-12-09 00:40:56');

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
(25118777, '01:17:00', '2022-11-29', 580552, 1, 0, '', 1, 17, 0, 'pm'),
(52934530, '18:44:00', '2022-11-07', 1, 1, 0, '', 18, 44, 1, 'pm'),
(61248518, '10:04:00', '2022-11-30', 1, 21, 0, '', 10, 4, 0, 'am'),
(67786426, '14:20:00', '2022-12-14', 580552, 21, 0, '', 14, 20, 1, 'pm'),
(68397592, '04:15:00', '2022-11-15', 1, 1, 0, '', 4, 15, 0, 'pm'),
(86764057, '10:58:00', '2022-11-30', 1, 21, 0, '', 10, 58, 0, 'am'),
(92923940, '10:04:00', '2022-11-30', 1, 21, 0, '', 10, 4, 0, 'am'),
(97710567, '04:15:00', '2022-11-15', 1, 1, 0, '', 4, 15, 0, 'pm'),
(98801235, '04:21:00', '2022-11-28', 0, 1, 0, '', 4, 21, 0, 'pm');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `email_confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `member_since` date NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `confimed_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `name`, `email`, `email_confirmed`, `member_since`, `is_active`, `last_login`, `confimed_date`, `isAdmin`) VALUES
(0, 'Evan Folsom', 'thecdkid@gmail.com', 1, '2022-11-13', 1, '2022-11-13 07:14:13', NULL, 0),
(444494, 'Calvin Todd 2', 'student3@onlinetutoring.com', 1, '2022-12-08', 1, '2022-12-08 20:12:20', '2022-12-08 14:12:20', 0),
(580552, 'Calvin Todd', 'student1@onlinetutoring.com', 1, '2022-11-24', 1, '2022-11-24 06:15:03', '2022-11-24 00:15:03', 0);

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
  `meetingdays` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`meetingdays`)),
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='table for tutors';

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`tutor_id`, `name`, `email`, `email_confirmed`, `confirmed_date`, `memeber_since`, `is_active`, `available`, `courses`, `meetingdays`, `isAdmin`) VALUES
(1, 'Yosep Almanza', 'yosepalmanza@hotmail.com', 1, '2022-11-05', '2022-11-05', 0, '[{\"day\":\"Monday\",\"starthour\":\"04\",\"startminute\":\"00\",\"secstart\":\"PM\",\"endhour\":\"05\",\"endminute\":\"00\",\"secend\":\"PM\"},{\"day\":\"Tuesday\",\"starthour\":\"12\",\"startminute\":\"00\",\"secstart\":\"AM\",\"endhour\":\"05\",\"endminute\":\"00\",\"secend\":\"PM\"}]', '[\"Reading\",\"Skills\"]', '[\"Monday\",\"Tuesday\"]', 1),
(21, ' Peter Griffin', 'tutor1@onlinetutoring.com', 1, '2022-11-26', '2022-11-26', 0, '[{\"day\":\"Wednesday\",\"starthour\":\"10\",\"startminute\":\"00\",\"secstart\":\"AM\",\"endhour\":\"12\",\"endminute\":\"00\",\"secend\":\"AM\"},{\"day\":\"Thursday \",\"starthour\":\"04\",\"startminute\":\"00\",\"secstart\":\"PM\",\"endhour\":\"05\",\"endminute\":\"00\",\"secend\":\"PM\"}]', '[\"Reading\",\"Skills\",\"Writing\"]', '[\" \",\"Wednesday\",\"Thursday \"]', 0),
(29, ' Brian Griffin', 'tutor2@onlinelearning.com', 1, '2022-12-08', '2022-12-08', 0, '[{\"day\":\"Tuesday\",\"starthour\":\"01\",\"startminute\":\"00\",\"secstart\":\"PM\",\"endhour\":\"01\",\"endminute\":\"00\",\"secend\":\"PM\"},{\"day\":\"Wednesday\",\"starthour\":\"01\",\"startminute\":\"00\",\"secstart\":\"PM\",\"endhour\":\"01\",\"endminute\":\"00\",\"secend\":\"PM\"}]', '[\"Skills \",\"Writing \"]', '[\"Tuesday\",\"Wednesday\"]', 0),
(32, ' Brian Griffin', 'tutor2@onlinelearning.com', 1, '2022-12-08', '2022-12-08', 0, '[{\"day\":\"Tuesday\",\"starthour\":\"01\",\"startminute\":\"00\",\"secstart\":\"PM\",\"endhour\":\"01\",\"endminute\":\"00\",\"secend\":\"PM\"},{\"day\":\"Wednesday\",\"starthour\":\"01\",\"startminute\":\"00\",\"secstart\":\"PM\",\"endhour\":\"01\",\"endminute\":\"00\",\"secend\":\"PM\"}]', '[\"Skills \",\"Writing \"]', '[\"Tuesday\",\"Wednesday\"]', 0);

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
  ADD PRIMARY KEY (`course_code`),
  ADD UNIQUE KEY `course_name` (`course_name`);

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
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `student_id` (`student_id`);

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
  MODIFY `login_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `teaches`
--
ALTER TABLE `teaches`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tutors`
--
ALTER TABLE `tutors`
  MODIFY `tutor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
