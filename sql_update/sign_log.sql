# Host: localhost  (Version: 5.5.53)
# Date: 2018-11-02 16:44:07
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "sign_log"
#

CREATE TABLE `sign_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `time` int(11) DEFAULT '0' COMMENT '连续签到次数',
  `content` varchar(255) DEFAULT '',
  `coin` int(11) DEFAULT '0',
  `exp` int(11) DEFAULT '0',
  `memo` varchar(255) DEFAULT '',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "sign_log"
#

