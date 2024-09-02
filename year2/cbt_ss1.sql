-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2022 at 03:51 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbt_ss1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `access_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `passport` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `access_code`, `name`, `passport`) VALUES
(1, '09824982', 'Administrator', 'adminImage/admin-min-Desert.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `qus_no` int(11) NOT NULL,
  `ans_image` varchar(155) DEFAULT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `text` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `name`) VALUES
(4, 'SS1');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `lecturers_id` int(11) NOT NULL,
  `subject_id` varchar(20) DEFAULT NULL,
  `course_title` varchar(255) NOT NULL,
  `course_name` varchar(80) NOT NULL,
  `class_id` int(100) NOT NULL,
  `year` int(11) NOT NULL,
  `type` char(1) DEFAULT NULL,
  `exam_time` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `current_students`
--

CREATE TABLE `current_students` (
  `id` int(11) NOT NULL,
  `st_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `time_started` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exam_time`
--

CREATE TABLE `exam_time` (
  `id` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `qus_no` int(11) NOT NULL,
  `text` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `extra` text NOT NULL,
  `img` mediumtext NOT NULL,
  `course_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `registered_exams`
--

CREATE TABLE `registered_exams` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `score` int(11) NOT NULL,
  `overAll` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `institution_name` varchar(250) NOT NULL,
  `institution_logo` varchar(255) NOT NULL,
  `institution_slogan` varchar(255) NOT NULL,
  `exam_instruction` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `institution_name`, `institution_logo`, `institution_slogan`, `exam_instruction`) VALUES
(1, 'HGSSA CBT', 'logo3.png', 'Love & Service', 'exam instruction');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `reg_no` varchar(100) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(225) NOT NULL,
  `profile_pic` varchar(255) NOT NULL DEFAULT 'passport.jpg',
  `gender` varchar(255) NOT NULL DEFAULT 'female',
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `students_ans`
--

CREATE TABLE `students_ans` (
  `id` int(11) NOT NULL,
  `st_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `qus_id` int(11) NOT NULL,
  `qus_no` int(11) NOT NULL,
  `ans_id` int(11) NOT NULL,
  `correct_ans_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `students_old`
--

CREATE TABLE `students_old` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `institution` varchar(100) NOT NULL,
  `reg_no` varchar(100) NOT NULL,
  `email` varchar(225) NOT NULL,
  `profile_pic` varchar(255) NOT NULL DEFAULT 'passport.jpg',
  `gender` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `staff_id` varchar(191) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `current_students`
--
ALTER TABLE `current_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_time`
--
ALTER TABLE `exam_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_exams`
--
ALTER TABLE `registered_exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students_ans`
--
ALTER TABLE `students_ans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students_old`
--
ALTER TABLE `students_old`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `current_students`
--
ALTER TABLE `current_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_time`
--
ALTER TABLE `exam_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registered_exams`
--
ALTER TABLE `registered_exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_ans`
--
ALTER TABLE `students_ans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
