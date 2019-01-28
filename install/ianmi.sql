/*\r\nMySQL Database Backup Tools\r\nServer:127.0.0.1:3306\r\nDatabase:love_ianmi\r\nData:2018-10-25 09:51:47\r\n*/\r\nSET FOREIGN_KEY_CHECKS=0;\r\n-- ----------------------------\r\n-- Table structure for category\r\n-- ----------------------------\r\nDROP TABLE IF EXISTS `category`;\r\nCREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT '0' COMMENT '0 普通，1 论坛',
  `config` text,
  `template` text,
  `path` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT '0',
  `photo` varchar(255) DEFAULT NULL COMMENT '图标',
  `file_id` int(11) DEFAULT '0',
  `bm_id` varchar(500) DEFAULT NULL COMMENT '版主 id',
  `user_add` int(11) DEFAULT '1' COMMENT '开启会员发帖 0关闭 1开启',
  `is_html` int(11) DEFAULT '1' COMMENT '开启html过滤',
  `is_ubb` int(11) DEFAULT '1' COMMENT '启用ubb',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;\r\n-- ----------------------------\r\n-- Records of category\r\n-- ----------------------------\r\nINSERT INTO `category` (`id`,`name`,`title`,`type`,`config`,`template`,`path`,`order`,`photo`,`file_id`,`bm_id`,`user_add`,`is_html`,`is_ubb`) VALUES ('1','','综合论坛','0','','','','0','http://ianmi.com/upload/column/20180909234237_202.png','123','','1','1','1');\r\nINSERT INTO `category` (`id`,`name`,`title`,`type`,`config`,`template`,`path`,`order`,`photo`,`file_id`,`bm_id`,`user_add`,`is_html`,`is_ubb`) VALUES ('2','','源码发布','0','','','','0','http://ianmi.com/upload/column/20180909234155_726.png','124','','1','1','1');\r\nINSERT INTO `category` (`id`,`name`,`title`,`type`,`config`,`template`,`path`,`order`,`photo`,`file_id`,`bm_id`,`user_add`,`is_html`,`is_ubb`) VALUES ('3','','任务求助','0','','','','0','http://ianmi.com/upload/column/20180909234325_411.png','125','','1','1','1');\r\nINSERT INTO `category` (`id`,`name`,`title`,`type`,`config`,`template`,`path`,`order`,`photo`,`file_id`,`bm_id`,`user_add`,`is_html`,`is_ubb`) VALUES ('4','','贴图专区','0','','','','0','http://ianmi.com/upload/column/20180909233702_340.png','127','','1','1','1');\r\n\r\n-- ----------------------------\r\n-- Table structure for code\r\n-- ----------------------------\r\nDROP TABLE IF EXISTS `code`;\r\nCREATE TABLE `code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '唯一字符表示',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` text COMMENT '代码内容',
  `status` int(11) DEFAULT '1' COMMENT '状态 0关闭 1开启',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;\r\n-- ----------------------------\r\n-- Records of code\r\n-- ----------------------------\r\nINSERT INTO `code` (`id`,`name`,`title`,`content`,`status`) VALUES ('1','ad_forum','帖子内容下面','','1');\r\n\r\n-- ----------------------------\r\n-- Table structure for file\r\n-- ----------------------------\r\nDROP TABLE IF EXISTS `file`;\r\nCREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `memo` text,
  `path` varchar(500) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `mine` varchar(255) DEFAULT NULL COMMENT 'mine类型',
  `mark` varchar(255) DEFAULT NULL,
  `read_count` int(11) DEFAULT '0',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `down_count` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0' COMMENT '0 缓存状态 1 正式文件',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;\r\n-- ----------------------------\r\n-- Records of file\r\n-- ----------------------------\r\n\r\n-- ----------------------------\r\n-- Table structure for forum\r\n-- ----------------------------\r\nDROP TABLE IF EXISTS `forum`;\r\nCREATE TABLE `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `context` text,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `log` text COMMENT '[]',
  `read_count` int(11) DEFAULT '0',
  `reply_count` int(11) DEFAULT '0',
  `img_data` varchar(255) DEFAULT NULL,
  `file_data` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;\r\n-- ----------------------------\r\n-- Records of forum\r\n-- ----------------------------\r\n\r\n-- ----------------------------\r\n-- Table structure for forum_mark\r\n-- ----------------------------\r\nDROP TABLE IF EXISTS `forum_mark`;\r\nCREATE TABLE `forum_mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;\r\n-- ----------------------------\r\n-- Records of forum_mark\r\n-- ----------------------------\r\n\r\n-- ----------------------------\r\n-- Table structure for forum_mark_body\r\n-- ----------------------------\r\nDROP TABLE IF EXISTS `forum_mark_body`;\r\nCREATE TABLE `forum_mark_body` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mark_id` int(11) DEFAULT '0',
  `forum_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;\r\n-- ----------------------------\r\n-- Records of forum_mark_body\r\n-- ----------------------------\r\n\r\n-- ----------------------------\r\n-- Table structure for forum_reply\r\n-- ----------------------------\r\nDROP TABLE IF EXISTS `forum_reply`;\r\nCREATE TABLE `forum_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `context` varchar(500) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;\r\n-- ----------------------------\r\n-- Records of forum_reply\r\n-- ----------------------------\r\n\r\n-- ----------------------------\r\n-- Table structure for fourm_buy\r\n-- ----------------------------\r\nDROP TABLE IF EXISTS `fourm_buy`;\r\nCREATE TABLE `fourm_buy` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;\r\n-- ----------------------------\r\n-- Records of fourm_buy\r\n-- ----------------------------\r\n\r\n-- ----------------------------\r\n-- Table structure for friend\r\n-- ----------------------------\r\nDROP TABLE IF EXISTS `friend`;\r\nCREATE TABLE `friend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `care_user_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;\r\n-- ----------------------------\r\n-- Records of friend\r\n-- ----------------------------\r\n\r\n-- ----------------------------\r\n-- Table structure for setting\r\n-- ----------------------------\r\nDROP TABLE IF EXISTS `setting`;\r\nCREATE TABLE `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` text,
  `site_id` int(11) DEFAULT '0' COMMENT '网站id',
  `title` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;\r\n-- ----------------------------\r\n-- Records of setting\r\n-- ----------------------------\r\nINSERT INTO `setting` (`id`,`name`,`value`,`site_id`,`title`,`type`,`update_time`) VALUES ('1','login_reward','1','0','','0','2018-10-24 10:47:51');\r\nINSERT INTO `setting` (`id`,`name`,`value`,`site_id`,`title`,`type`,`update_time`) VALUES ('2','forum_reward','2','0','','0','2018-10-24 10:47:51');\r\nINSERT INTO `setting` (`id`,`name`,`value`,`site_id`,`title`,`type`,`update_time`) VALUES ('3','reply_reward','3','0','','0','2018-10-24 10:47:51');\r\n\r\n-- ----------------------------\r\n-- Table structure for user\r\n-- ----------------------------\r\nDROP TABLE IF EXISTS `user`;\r\nCREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `nickcolor` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `money` int(11) DEFAULT '0',
  `coin` int(11) DEFAULT '0',
  `vip_level` int(11) DEFAULT '0',
  `explain` varchar(500) DEFAULT NULL COMMENT '签名',
  `exp` int(11) DEFAULT '0',
  `addip` varchar(255) DEFAULT NULL,
  `lastip` varchar(255) DEFAULT NULL,
  `sid` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  `last_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '活跃时间',
  `create_ip` varchar(255) DEFAULT NULL,
  `vip_time` datetime DEFAULT NULL COMMENT 'VIP到期时间',
  `lock_time` datetime DEFAULT NULL COMMENT '锁定结束时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户表';

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
