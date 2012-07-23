# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.20-log
# Server OS:                    Win64
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2012-07-22 22:20:16
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for multido
CREATE DATABASE IF NOT EXISTS `multido` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `multido`;


# Dumping structure for table multido.boards
CREATE TABLE IF NOT EXISTS `boards` (
  `bid` int(10) NOT NULL AUTO_INCREMENT,
  `bname` varchar(40) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`bid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Data exporting was unselected.


# Dumping structure for table multido.box
CREATE TABLE IF NOT EXISTS `box` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rname` varchar(20) DEFAULT NULL,
  `bdate` datetime DEFAULT NULL,
  `fbid` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='these are task square boxes';

# Data exporting was unselected.


# Dumping structure for table multido.box_cont
CREATE TABLE IF NOT EXISTS `box_cont` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `cname` varchar(50) DEFAULT NULL,
  `fkid` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='these are the content of boxes';

# Data exporting was unselected.


# Dumping structure for table multido.box_perm
CREATE TABLE IF NOT EXISTS `box_perm` (
  `pid` int(10) NOT NULL AUTO_INCREMENT,
  `fkuid` int(10) DEFAULT '0',
  `fkbox` int(10) DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Data exporting was unselected.


# Dumping structure for table multido.members
CREATE TABLE IF NOT EXISTS `members` (
  `uid` int(10) NOT NULL AUTO_INCREMENT,
  `uname` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `secret_` varchar(100) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Data exporting was unselected.
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
