# Host: localhost  (Version: 5.5.53)
# Date: 2018-10-26 10:05:29
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "code"
#

CREATE TABLE `code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '唯一字符表示',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` text COMMENT '代码内容',
  `status` int(11) DEFAULT '1' COMMENT '状态 0关闭 1开启',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "code"
#

INSERT INTO `code` VALUES (1,'ad_forum','帖子内容下面',NULL,1);
