-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2022 at 01:31 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toolhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertisement`
--

CREATE TABLE `advertisement` (
  `advertise_top` varchar(500) NOT NULL,
  `advertise_top_enable` tinyint(1) NOT NULL,
  `advertise_bottom` varchar(500) NOT NULL,
  `advertise_bottom_enable` tinyint(1) NOT NULL,
  `script_tag` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `advertisement`
--

INSERT INTO `advertisement` (`advertise_top`, `advertise_top_enable`, `advertise_bottom`, `advertise_bottom_enable`, `script_tag`) VALUES
('', 0, '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `tools_id` int(11) NOT NULL,
  `tool_title` varchar(100) NOT NULL,
  `topbannerurl` varchar(150) NOT NULL,
  `bannerrighttopurl` varchar(150) NOT NULL,
  `bannerrightbottomurl` varchar(150) NOT NULL,
  `bottombannerurl` varchar(150) NOT NULL,
  `enable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `tools_id`, `tool_title`, `topbannerurl`, `bannerrighttopurl`, `bannerrightbottomurl`, `bottombannerurl`, `enable`) VALUES
(1, -1, 'Tool Hub', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(2, -2, 'Tool Hub', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(3, -3, 'Tool Hub', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(4, 1, 'Article Rewriter', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(5, 2, 'Spinner', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(6, 3, 'Plagiarism Checker', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(7, 4, 'Content Hunter', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(8, 5, 'Text To Speech', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(9, 6, 'Word Count', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(10, 7, 'Minify CSS', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(11, 8, 'Minify JS', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(12, 9, 'Minify HTML', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(13, 10, 'Google Pagespeed', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(14, 11, 'Google Mobilefriendly', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(15, 12, 'Detect Wordpress Theme', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(16, 13, 'Get Http Headers', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(17, 14, 'Check Compression', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(18, 15, 'Check DNS', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(19, 16, 'Get Page Source', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(20, 17, 'Get Website Screenshot', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(21, 18, 'Keyword Suggestion', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(22, 19, 'Keyword Density', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(23, 20, 'Related Keyword', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(24, 21, 'Organic Keyword', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(25, 22, 'Keyword Volume', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(26, 23, 'Keyword Position', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(27, 24, 'Keyword Competitor', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(28, 25, 'Alexa Rank', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(29, 26, 'Moz Rank', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(30, 27, 'Social Shares', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(31, 28, 'Malware Checker', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(32, 29, 'WWW Redirect', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(33, 30, 'Server Status', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(34, 31, 'Check Google Cache', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(35, 32, 'Check Google Index', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(36, 33, 'Website Links Counter', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(37, 34, 'Detect IP Class', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(38, 35, 'Text To Code Ratio', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(39, 36, 'Domain Age', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(40, 37, 'Domain To IP', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(41, 38, 'Domain Availability', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(42, 39, 'Domain Host', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(43, 40, 'Visitor IP', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(44, 41, 'Visitor Location', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(45, 42, 'Check Blacklist', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(46, 43, 'Check Whois', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(47, 44, 'Convert To MD5', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(48, 45, 'Encrypt', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(49, 46, 'Generate Password', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(50, 47, 'Password Strength', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1),
(51, 48, 'Certificate Info', 'https://toolhub.cyou/template/img/BannerTop540x120.png', 'https://toolhub.cyou/template/img/BannerRightTop220x540.png', 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png', 'https://toolhub.cyou/template/img/BannerBottom540x120.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `footer`
--

CREATE TABLE `footer` (
  `id` int(11) NOT NULL,
  `facebook` varchar(150) NOT NULL,
  `twitter` varchar(150) NOT NULL,
  `linkedin` varchar(150) NOT NULL,
  `pinterest` varchar(150) NOT NULL,
  `behance` varchar(150) NOT NULL,
  `dribbble` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `footer`
--

INSERT INTO `footer` (`id`, `facebook`, `twitter`, `linkedin`, `pinterest`, `behance`, `dribbble`) VALUES
(1, 'https://www.facebook.com/toolhub', 'http://twitter.com/toolhub', 'https://www.linkedin.com/in/toolhub', 'https://www.pinterest.com/', 'https://www.behance.net/toolhub', 'https://dribbble.com/shots/toolhub');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settingid` int(11) NOT NULL,
  `tools_id` int(11) NOT NULL,
  `tool_title` varchar(100) NOT NULL,
  `meta_keyword` varchar(250) NOT NULL,
  `meta_description` varchar(250) NOT NULL,
  `tool_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settingid`, `tools_id`, `tool_title`, `meta_keyword`, `meta_description`, `tool_text`) VALUES
(1, -1, 'Tool Hub', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(2, -2, 'Tool Hub', '', 'RnJlZSBTZW8gVG9vbHM=', 'I am currently writing a dissertation about whether Web Designers should know how to code their designs or just be the best designer they can be and I was wondering if I could get your thoughts on on this question and if coding is essential to a Web Designer.'),
(3, -3, 'Tool Hub', '', 'RnJlZSBTZW8gVG9vbHM=', '<strong>How Can We Help? </strong><br>\n\nPlease&nbsp;fill out our contact form.'),
(4, 1, 'Article Rewriter', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(5, 2, 'Spinner', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(6, 3, 'Plagiarism Checker', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(7, 4, 'Content Hunter', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(8, 5, 'Text To Speech', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(9, 6, 'Word Count', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(10, 7, 'Minify CSS', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(11, 8, 'Minify JS', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(12, 9, 'Minify HTML', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(13, 10, 'Google Pagespeed', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(14, 11, 'Google Mobilefriendly', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(15, 12, 'Detect Wordpress Theme', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(16, 13, 'Get Http Headers', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(17, 14, 'Check Compression', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(18, 15, 'Check DNS', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(19, 16, 'Get Page Source', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(20, 17, 'Get Website Screenshot', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(21, 18, 'Keyword Suggestion', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(22, 19, 'Keyword Density', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(23, 20, 'Related Keyword', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(24, 21, 'Organic Keyword', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(25, 22, 'Keyword Volume', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(26, 23, 'Keyword Position', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(27, 24, 'Keyword Competitor', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(28, 25, 'Alexa Rank', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(29, 26, 'Moz Rank', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(30, 27, 'Social Shares', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(31, 28, 'Malware Checker', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(32, 29, 'WWW Redirect', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(33, 30, 'Server Status', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(34, 31, 'Check Google Cache', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(35, 32, 'Check Google Index', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(36, 33, 'Website Links Counter', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(37, 34, 'Detect IP Class', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(38, 35, 'Text To Code Ratio', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(39, 36, 'Domain Age', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(40, 37, 'Domain To IP', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(41, 38, 'Domain Availability', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(42, 39, 'Domain Host', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(43, 40, 'Visitor IP', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(44, 41, 'Visitor Location', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(45, 42, 'Check Blacklist', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(46, 43, 'Check Whois', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(47, 44, 'Convert To MD5', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(48, 45, 'Encrypt', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(49, 46, 'Generate Password', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(50, 47, 'Password Strength', '', 'RnJlZSBTZW8gVG9vbHM=', ''),
(51, 48, 'Certificate Info', '', 'RnJlZSBTZW8gVG9vbHM=', '');

-- --------------------------------------------------------

--
-- Table structure for table `tools`
--

CREATE TABLE `tools` (
  `tool_id` int(11) NOT NULL,
  `tool_name` varchar(30) NOT NULL,
  `tool_description` text NOT NULL,
  `tool_url` varchar(300) NOT NULL,
  `tool_icon` varchar(300) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tools`
--

INSERT INTO `tools` (`tool_id`, `tool_name`, `tool_description`, `tool_url`, `tool_icon`, `status`) VALUES
(1, 'Article Rewriter', '', 'https://toolhub.cyou/article-rewriter', 'https://toolhub.cyou/tool-icons/article_rewriter.png', 1),
(2, 'Spinner', '', 'https://toolhub.cyou/spinner', 'https://toolhub.cyou/tool-icons/spinner.png', 1),
(3, 'Plagiarism Checker', '', 'https://toolhub.cyou/plagiarism-checker', 'https://toolhub.cyou/tool-icons/plagiarism_checker.png', 1),
(4, 'Content Hunter', '', 'https://toolhub.cyou/content-hunter', 'https://toolhub.cyou/tool-icons/content-hunter.png', 0),
(5, 'Text To Speech', '', 'https://toolhub.cyou/texttospeech', 'https://toolhub.cyou/tool-icons/texttospeech.png', 1),
(6, 'Word Count', '', 'https://toolhub.cyou/word-count', 'https://toolhub.cyou/tool-icons/word_counter.png', 1),
(7, 'Minify CSS', '', 'https://toolhub.cyou/minify-css', 'https://toolhub.cyou/tool-icons/minify-css.png', 1),
(8, 'Minify JS', '', 'https://toolhub.cyou/minify-js', 'https://toolhub.cyou/tool-icons/minify-js.png', 1),
(9, 'Minify HTML', '', 'https://toolhub.cyou/minify-html', 'https://toolhub.cyou/tool-icons/minify-html.png', 1),
(10, 'Google Pagespeed', '', 'https://toolhub.cyou/googlepagespeed', 'https://toolhub.cyou/tool-icons/google_pagespeed.png', 1),
(11, 'Google Mobilefriendly', '', 'https://toolhub.cyou/googlemobilefriendly', 'https://toolhub.cyou/tool-icons/webpage_screen_resolution_simulator.png', 1),
(12, 'Detect Wordpress Theme', '', 'https://toolhub.cyou/detectwordpresstheme', 'https://toolhub.cyou/tool-icons/detectwordpresstheme.png', 1),
(13, 'Get Http Headers', '', 'https://toolhub.cyou/gethttpheaders', 'https://toolhub.cyou/tool-icons/gethttpheaders.png', 1),
(14, 'Check Compression', '', 'https://toolhub.cyou/check-compression', 'https://toolhub.cyou/tool-icons/check-compression.png', 1),
(15, 'Check DNS', '', 'https://toolhub.cyou/check-ns', 'https://toolhub.cyou/tool-icons/dns.png', 1),
(16, 'Get Page Source', '', 'https://toolhub.cyou/getpagesource', 'https://toolhub.cyou/tool-icons/source_code.png', 1),
(17, 'Get Website Screenshot', '', 'https://toolhub.cyou/getscreenshot', 'https://toolhub.cyou/tool-icons/website_screenshot_generator.png', 1),
(18, 'Keyword Suggestion', '', 'https://toolhub.cyou/keyword-suggestion', 'https://toolhub.cyou/tool-icons/keywords_suggestion.png', 1),
(19, 'Keyword Density', '', 'https://toolhub.cyou/keyword-density', 'https://toolhub.cyou/tool-icons/keyword_density_checker.png', 1),
(20, 'Related Keyword', '', 'https://toolhub.cyou/related-keyword', 'https://toolhub.cyou/tool-icons/related-keyword.png', 1),
(21, 'Organic Keyword', '', 'https://toolhub.cyou/organic-keyword', 'https://toolhub.cyou/tool-icons/keyword_density_checker.png', 1),
(22, 'Keyword Volume', '', 'https://toolhub.cyou/keyword-volume', 'https://toolhub.cyou/tool-icons/keywords_suggestion.png', 1),
(23, 'Keyword Position', '', 'https://toolhub.cyou/keyword-position', 'https://toolhub.cyou/tool-icons/keyword_position_checker.png', 1),
(24, 'Keyword Competitor', '', 'https://toolhub.cyou/keyword-competitor', 'https://toolhub.cyou/tool-icons/keyword-competitor.png', 1),
(25, 'Alexa Rank', '', 'https://toolhub.cyou/alexa-rank', 'https://toolhub.cyou/tool-icons/alexa.png', 1),
(26, 'Moz Rank', '', 'https://toolhub.cyou/moz-rank', 'https://toolhub.cyou/tool-icons/moz.png', 1),
(27, 'Social Shares', '', 'https://toolhub.cyou/social-shares', 'https://toolhub.cyou/tool-icons/social-shares.png', 1),
(28, 'Malware Checker', '', 'https://toolhub.cyou/malware-checker', 'https://toolhub.cyou/tool-icons/google_malware.png', 1),
(29, 'WWW Redirect', '', 'https://toolhub.cyou/www-redirect', 'https://toolhub.cyou/tool-icons/www_redirect_checker.png', 1),
(30, 'Server Status', '', 'https://toolhub.cyou/serverstatus', 'https://toolhub.cyou/tool-icons/server_status_checker.png', 1),
(31, 'Check Google Cache', '', 'https://toolhub.cyou/checkgooglecache', 'https://toolhub.cyou/tool-icons/google_cache.png', 1),
(32, 'Check Google Index', '', 'https://toolhub.cyou/checkgoogleindex', 'https://toolhub.cyou/tool-icons/google_index_checker.png', 1),
(33, 'Website Links Counter', '', 'https://toolhub.cyou/websitlinkscounter', 'https://toolhub.cyou/tool-icons/links_count_checker.png', 1),
(34, 'Detect IP Class', '', 'https://toolhub.cyou/detectipclass', 'https://toolhub.cyou/tool-icons/class_c_ip.png', 1),
(35, 'Text To Code Ratio', '', 'https://toolhub.cyou/texttocoderatio', 'https://toolhub.cyou/tool-icons/code_to_text.png', 1),
(36, 'Domain Age', '', 'https://toolhub.cyou/domain-age', 'https://toolhub.cyou/tool-icons/domain_age_checker.png', 1),
(37, 'Domain To IP', '', 'https://toolhub.cyou/domaintoip', 'https://toolhub.cyou/tool-icons/reverse_ip_domain.png', 1),
(38, 'Domain Availability', '', 'https://toolhub.cyou/domain-availability', 'https://toolhub.cyou/tool-icons/domain_availability_checker.png', 1),
(39, 'Domain Host', '', 'https://toolhub.cyou/domain-host', 'https://toolhub.cyou/tool-icons/domain_hosting_checker.png', 1),
(40, 'Visitor IP', '', 'https://toolhub.cyou/visitor-ip', 'https://toolhub.cyou/tool-icons/domain_into_IP.png', 1),
(41, 'Visitor Location', '', 'https://toolhub.cyou/visitor-location', 'https://toolhub.cyou/tool-icons/my_IP_address.png', 1),
(42, 'Check Blacklist', '', 'https://toolhub.cyou/check-blacklist', 'https://toolhub.cyou/tool-icons/denied.png', 1),
(43, 'Check Whois', '', 'https://toolhub.cyou/check-whois', 'https://toolhub.cyou/tool-icons/whois_checker.png', 1),
(44, 'Convert To MD5', '', 'https://toolhub.cyou/converttomd5', 'https://toolhub.cyou/tool-icons/online_md5_generator.png', 1),
(45, 'Encrypt', '', 'https://toolhub.cyou/encrypt', 'https://toolhub.cyou/tool-icons/online_md5_generator.png', 1),
(46, 'Generate Password', '', 'https://toolhub.cyou/generate-password', 'https://toolhub.cyou/tool-icons/Generate-Password.png', 1),
(47, 'Password Strength', '', 'https://toolhub.cyou/password-strength', 'https://toolhub.cyou/tool-icons/password-strength.png', 1),
(48, 'Certificate Info', '', 'https://toolhub.cyou/certificate-info', 'https://toolhub.cyou/tool-icons/certificate-info.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_email` varchar(30) NOT NULL,
  `user_password` varchar(30) NOT NULL,
  `user_role` varchar(15) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_role`, `date_created`) VALUES
(1, 'Admin', 'admin@toolhub.cyou', 'Lenovo99@!', 'Super Admin', '2020-10-29 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settingid`);

--
-- Indexes for table `tools`
--
ALTER TABLE `tools`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `footer`
--
ALTER TABLE `footer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `settingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tools`
--
ALTER TABLE `tools`
  MODIFY `tool_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
