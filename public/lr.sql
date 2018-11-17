-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 01, 2013 at 07:05 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lr`
--

-- --------------------------------------------------------

--
-- Table structure for table `expert`
--

CREATE TABLE IF NOT EXISTS `expert` (
  `number` int(50) NOT NULL AUTO_INCREMENT,
  `symptoms` varchar(1034) NOT NULL,
  `diagnose` varchar(1024) NOT NULL,
  `CF` int(11) NOT NULL DEFAULT '0',
  `explanation` mediumtext NOT NULL,
  `marks` int(255) NOT NULL,
  PRIMARY KEY (`number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `expert`
--

INSERT INTO `expert` (`number`, `symptoms`, `diagnose`, `CF`, `explanation`, `marks`) VALUES
(1, 'patient has had a sudden overexertion', 'patient has had an injury', 10, '', 0),
(2, 'patient has had an injury and patient has problem with bending', ' muscle spasm evidence in patient is seen', 13, '', 0),
(3, 'pain appeared immediately after injury and the pain occurs in short lasting courses', 'syndrome is acute', 16, '', 0),
(4, 'pain appeared gradually and the pain occurs in long lasting courses', 'syndrome is chronic', 16, '', 0),
(5, 'pains occur in early morning and pains occur after inactivity and joints are swollen and pain expansion is into pelvic', 'arthritis evidence in patient is seen', 13, '', 0),
(6, 'pain expansion is into buttock and patient senses burning in buttocks', 'sciatica evidence in patient is seen', 13, '', 0),
(7, ' muscles are being weak in legs and blocking occurs on leg joints and patient has the loss of bowel', 'cauda equina evidence in patient is seen', 13, '', 0),
(8, 'patient has had an injury and have shingels', 'then Lyme disease a chronic infection is seen', 13, '', 0),
(9, 'patient is overweight', 'lifestyle is risky', 10, '', 0),
(10, 'patient has to lift heavy frequently', 'lifestyle is risky', 10, '', 0),
(11, 'patient has to sit for long periods', 'lifestyle is risky', 10, '', 0),
(12, 'patient has loss of apetite', 'lifestyle is risky', 10, '', 0),
(13, 'patient suffers from persistent sadness', 'depression evidence in patient is seen', 10, '', 0),
(14, 'patient has unexplained weightloss', 'depression evidence in patient is seen', 10, '', 0),
(16, 'patient had met in accident and has got some changes in walking style', 'the disease is chronic arthritis', 13, '', 0),
(17, 'patient is infected by a cancer', 'disease is tumor', 10, '', 0),
(18, 'patient has any infection history and the pain is associated with fever', 'disease is Osteomyelitis', 10, '', 0),
(19, 'patient suffers from loss of calcium', 'disease is osteoporosis', 10, '', 0),
(20, 'patient has been under long steroid treatment', 'disease is osteoporosis', 10, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `expert_old`
--

CREATE TABLE IF NOT EXISTS `expert_old` (
  `number` int(50) NOT NULL AUTO_INCREMENT,
  `symptoms` varchar(1034) NOT NULL,
  `diagnose` varchar(1024) NOT NULL,
  `CF` int(11) NOT NULL DEFAULT '25',
  `explanation` mediumtext NOT NULL,
  PRIMARY KEY (`number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `expert_old`
--

INSERT INTO `expert_old` (`number`, `symptoms`, `diagnose`, `CF`, `explanation`) VALUES
(1, 'Does the patient has sudden overexection', 'had an injury', 25, ''),
(2, 'patient injury and problem with bending', 'muscle spasm', 25, ''),
(4, 'pain appeared immediately and pain occurs in short lasting courses', 'acute.', 25, ''),
(5, 'pain appeared gradually and pain occurs in long lasting courses', 'chronic', 25, ''),
(6, 'pains occur in early morning and after inactivity and joints are swollen and pain expansion is into pelvic', 'arthritis', 25, ''),
(7, 'pain expansion is into buttock and patient senses burning in buttocks', 'sciatica', 25, ''),
(8, 'muscles are being weak in legs and blocking occurs on leg joints and patient has the loss of bowel', 'cauda equina', 25, ''),
(9, 'patient is overweight', 'lifestyle is risky', 25, ''),
(10, 'patient has to lift heavy frequently', 'lifestyle is risky', 25, ''),
(11, 'patient has to sit for long periods', 'lifestyle is risky', 25, ''),
(12, 'patient suffers from persistent sadness', 'depression', 25, ''),
(13, 'patient has unexplained weightloss', 'depression', 25, ''),
(14, 'muscle spasm evidence in patient is seen and the syndrome is acute', 'acute lumbar strain.', 25, 'disease is acute lumbar strain then the recommendation is seeing a specialist.'),
(15, 'syndrome is chronic and arthritis, and the lifestyle is risky and    patient has old injury history, and patient has got some changes in walking style ', 'chronic arthritis', 25, 'chronic arthritis then the recommendation is seeing a specialist.'),
(16, 'syndrome is chronic and depression', 'depression.', 25, 'The disease is depression then the recommendation is trying to enjoy the life.'),
(17, 'syndrome is chronic and muscle spasm evidence in patient is seen and patient has had an injury and    patient has old injury ', 'chronic low back syndrome', 25, 'the disease is chronic low back syndrome then the recommendation is seeing a specialist.'),
(18, 'infected by a cancer', 'tumor.', 25, 'The disease is tumor then the recommendation is seeing a specialist urgently.'),
(19, 'patient has any infection history  and pain is associated with fever', 'Osteomyelitis', 25, 'the disease is osteomyelitis then the recommendation is seeing a specialist'),
(20, 'syndrome is chronic and muscle spasm, and sciatica evidence, and    cauda equina evidence, and patient has had an injury ', 'herniated lumbarascal disc', 25, 'the disease is herniated lumbarascal disc then the recommendation is seeing a specialist for further test with diagnostic imaging'),
(21, 'patient suffers from loss of calcium', 'osteoporosis', 25, 'the disease is osteoporosis then the recommendation is seeing a specialist.'),
(22, 'patient has been under long steroid treatment', 'osteoporosis.', 25, 'the disease is osteoporosis then the recommendation is seeing a specialist.'),
(23, 'syndrome is chronic and muscle spasm evidence and sciatica evidence and    cauda equina ', 'spinal stenosis', 25, 'if the disease is spinal stenosis then the recommendation is seeing a specialist for further test with diagnostic imaging.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `email` varchar(1024) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `role` varchar(1024) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `active`, `role`) VALUES
('Ram', '5f4dcc3b5aa765d61d8327deb882cf99', 'Ram', 'Gopal Raj', 'ram_prime@fsktm.um.edu.my', 1, 'administrator');
