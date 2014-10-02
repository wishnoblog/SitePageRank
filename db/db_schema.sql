-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Oct 02, 2014 at 04:45 PM
-- Server version: 5.5.34
-- PHP Version: 5.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kuasGoogleInf`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `DataID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '資料ID',
  `SiteID` int(11) NOT NULL,
  `filetime` datetime DEFAULT NULL,
  `robot` tinyint(1) DEFAULT NULL,
  `sitemap` tinyint(1) DEFAULT NULL,
  `GoogleData` bigint(20) DEFAULT NULL COMMENT '取得資料',
  `google_page_rank` int(11) DEFAULT NULL,
  `google_backlink` bigint(20) DEFAULT NULL,
  `alexa_rank` bigint(20) DEFAULT NULL,
  `alexa_rank_tw` bigint(20) DEFAULT NULL,
  `alexa_link` bigint(11) DEFAULT NULL,
  `GooglePlusShares` bigint(20) DEFAULT NULL,
  `TwitterShares` bigint(20) DEFAULT NULL,
  `Facebook` bigint(20) DEFAULT NULL,
  `FB_share_count` bigint(20) DEFAULT NULL,
  `FB_like_count` bigint(20) DEFAULT NULL,
  `FB_comment_count` bigint(20) DEFAULT NULL,
  `FB_commentsbox_count` bigint(20) DEFAULT NULL,
  `FB_click_count` bigint(20) DEFAULT NULL,
  `LinkedInShares` bigint(20) DEFAULT NULL,
  `Time` datetime DEFAULT NULL COMMENT '記錄時間',
  `YY` int(11) NOT NULL COMMENT '年',
  `MM` int(11) NOT NULL COMMENT '月',
  `DD` int(11) NOT NULL COMMENT '日',
  `TaskID` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`DataID`),
  KEY `SiteID` (`SiteID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='資料' AUTO_INCREMENT=936 ;

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT COMMENT '編號',
  `name` varchar(200) NOT NULL COMMENT '群組名稱',
  `description` text COMMENT '說明',
  `type` enum('行政單位','教學單位','計劃網站','其他') NOT NULL DEFAULT '其他' COMMENT '類型',
  PRIMARY KEY (`groupid`),
  UNIQUE KEY `groupid` (`groupid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='網站群組' AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `site_url`
--

CREATE TABLE `site_url` (
  `SiteID` int(11) NOT NULL AUTO_INCREMENT COMMENT '編號',
  `name` varchar(200) NOT NULL COMMENT '單位名稱',
  `site` varchar(400) NOT NULL COMMENT '網址',
  `groupid` int(11) NOT NULL COMMENT '群組',
  `Enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '啟用',
  PRIMARY KEY (`SiteID`),
  UNIQUE KEY `siteid` (`SiteID`),
  KEY `siteid_2` (`SiteID`),
  KEY `site` (`site`(255)),
  KEY `groupid` (`groupid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='各單位網址' AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `TaskID` bigint(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  PRIMARY KEY (`TaskID`),
  UNIQUE KEY `TaskID` (`TaskID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `SiteID` FOREIGN KEY (`SiteID`) REFERENCES `site_url` (`SiteID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `group`
--
ALTER TABLE `group`
  ADD CONSTRAINT `group_ibfk_1` FOREIGN KEY (`groupid`) REFERENCES `group` (`groupid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `site_url`
--
ALTER TABLE `site_url`
  ADD CONSTRAINT `remove Site` FOREIGN KEY (`groupid`) REFERENCES `group` (`groupid`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
