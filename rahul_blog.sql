-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2015 at 07:28 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rahul_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
`art_id` int(11) NOT NULL,
  `writer` varchar(30) NOT NULL,
  `topic` text NOT NULL,
  `content_type` varchar(20) NOT NULL,
  `image` text NOT NULL,
  `content` text NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`art_id`, `writer`, `topic`, `content_type`, `image`, `content`, `views`, `date`) VALUES
(1, 'rahul', 'How to have one night stand?', 'poem', 'images/avrillavig_8qnpj2r7.jpg', '1. get a girl.</br>2. call her to your room.</br>3. now, do it moron. ', 23, '2015-01-23 12:43:41'),
(2, 'ravi', 'How to kick the ass of a jerk?', 'ghazal', 'images/pankaj-udhas-ghazal-concert-stolen-moments-cochin-kochi-jt-p.jpg', '1. play soccer to prepare yourself.2. walk quietly behind that jerk.3. assemble your power and bang!', 5, '2015-01-23 12:47:38'),
(4, 'rahul', 'Advantages of E-commerce', 'poem', 'images/19asha190.jpg', '1. Easy to access <br>2. so many choices<br>3. cash on delivery option', 9, '2015-01-23 19:15:10'),
(6, 'rahul', 'Girlfriend', 'poem', 'images/avril_lavigne4990.jpg', '1. find an attractive girl.<br> 2. Impress Her.<br> 3. What are you waiting for? My advise? ', 0, '2015-02-05 23:54:33');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE IF NOT EXISTS `blog_comments` (
`comm_id` int(11) NOT NULL,
  `art_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `blog_comments`
--

INSERT INTO `blog_comments` (`comm_id`, `art_id`, `name`, `comment`, `date`) VALUES
(3, 1, 'rahul', 'get the hell out of here!', '2015-01-23 18:34:14'),
(10, 1, 'rahul', 'it is rocking!', '2015-01-23 18:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE IF NOT EXISTS `visitors` (
`id` int(11) NOT NULL,
  `visits` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `visits`) VALUES
(1, '73');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
 ADD PRIMARY KEY (`art_id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
 ADD PRIMARY KEY (`comm_id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
MODIFY `art_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
MODIFY `comm_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
