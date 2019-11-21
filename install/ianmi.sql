CREATE TABLE `category` (
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
  `bm_id` varchar(500) DEFAULT NULL,
  `user_add` int(11) DEFAULT '1',
  `is_html` int(11) DEFAULT '1',
  `is_ubb` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `category` VALUES (1,'','综合论坛',0,'','','',0,'http://ianmi.com/upload/column/20180909234237_202.png',2047,'',1,1,1),(2,NULL,'源码发布',0,NULL,NULL,NULL,0,'http://ianmi.com/upload/column/20180909234155_726.png',2046,'',1,1,1),(3,NULL,'任务求助',0,NULL,NULL,NULL,0,'http://ianmi.com/upload/column/20180909234325_411.png',2048,'',1,1,1),(4,NULL,'教程中心',0,NULL,NULL,NULL,0,'http://ianmi.com/upload/column/20180909233702_340.png',2044,'',1,1,1);

CREATE TABLE `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT '0',
  `touserid` int(11) DEFAULT '0',
  `content` varchar(5000) DEFAULT NULL,
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `appid` int(11) DEFAULT '0',
  `classid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '唯一字符表示',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` text COMMENT '代码内容',
  `status` int(11) DEFAULT '1' COMMENT '状态 0关闭 1开启',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `code` VALUES (1,'ad_forum','帖子内容下面',NULL,1),(2,'forum_ubb','论坛UBB说明','<style>\r\n.forum_ubb_tips {\r\npadding: .5rem;\r\nline-height: 1.2rem;\r\nbackground: #FFFFFF;\r\n}\r\n.forum_ubb_tips b {\r\ncolor: #025ff0;\r\n}\r\n.forum_ubb_tips i {\r\ncolor: red;\r\n}\r\n.forum_ubb_title {\r\nline-height: 2rem;\r\nfont-size: .8rem;\r\ntext-align: center;\r\nborder-bottom: .05rem solid #EEE;\r\nmargin-bottom: .5rem;\r\n}\r\n</style>\r\n<div class=\"forum_ubb_tips\">\r\n<div class=\"forum_ubb_title\">论坛UBB说明</div>\r\n1、登录可见<br>\r\n 格式：<b>[read_login]</b>内容-登录可见<b>[/read_login]</b><br>\r\n2、回复可见<br>\r\n 格式：<b>[read_reply]</b>内容-回复可见<b>[/read_reply]</b><br>\r\n3、够买可见（<i>一篇帖子最多只能有一个内容够买，多个够买以第一个为基准</i>）<br>\r\n 格式：<b>[read_buy_10]</b>内容-已购买可见<b>[/read_buy_10]</b><br>\r\n</div>',1);

CREATE TABLE `file` (
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE `forum` (
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
  `active_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '活动时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `forum_buy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `money` int(11) DEFAULT '0',
  `coin` int(11) DEFAULT '0',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `forum_mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `forum_mark_body` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mark_id` int(11) DEFAULT '0',
  `forum_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `forum_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `context` varchar(500) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `friend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `care_user_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0' COMMENT '0是系统消息',
  `to_user_id` int(11) DEFAULT '0',
  `content` varchar(500) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `read_time` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '0未读 1已读',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` text,
  `site_id` int(11) DEFAULT '0' COMMENT '网站id',
  `title` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `setting` VALUES (1,'login_reward','1',0,'登录奖励',0,'2019-02-01 13:09:48'),(2,'forum_reward','2',0,'发帖奖励',0,'2019-02-01 13:09:55'),(3,'reply_reward','3',0,'回帖奖励',0,'2019-02-01 13:10:03'),(4,'pagesize','10',0,'默认页数 ',0,'2019-02-01 13:10:13'),(5,'forum_water_mark_status','1',0,'开启图片水印',0,'2019-02-01 13:10:24'),(6,'forum_water_mark_path','/upload/column/20190201113824_865.jpg',0,'水印地址',0,'2019-02-01 13:10:30'),(7,'theme','default',0,'主题',0,'2019-02-01 13:09:39');

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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `nickcolor` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `money` int(11) DEFAULT '0',
  `coin` int(11) DEFAULT '0',
  `vip_level` int(11) DEFAULT '0',
  `explain` varchar(500) DEFAULT '没有签名的签名' COMMENT '签名',
  `exp` int(11) DEFAULT '0',
  `addip` varchar(255) DEFAULT NULL,
  `lastip` varchar(255) DEFAULT NULL,
  `sid` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  `last_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '活跃时间',
  `create_ip` varchar(255) DEFAULT NULL,
  `vip_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT 'VIP到期时间',
  `lock_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '锁定结束时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户表';


ALTER TABLE `forum` ADD `is_top` tinyint(3) DEFAULT '0' COMMENT '0不加顶 1加顶';
ALTER TABLE `forum` ADD `is_cream` tinyint(3) DEFAULT '0' COMMENT '0不精 1加精';


ALTER TABLE `forum_mark` ADD `user_id` int(11) DEFAULT '0' COMMENT '添加的会员的ID';
ALTER TABLE `forum_mark` ADD `status` tinyint(3) DEFAULT '0' COMMENT '0审核中 1审核通过';

INSERT INTO `setting` (`name`, `value`, `title`)VALUES ('component', 'default', '组件标识');

DROP TABLE IF EXISTS `theme`;
CREATE TABLE `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '主题名',
  `name` varchar(255) DEFAULT NULL COMMENT '标识，文件名',
  `status` smallint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `version` varchar(255) DEFAULT NULL COMMENT '版本号',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '克隆时间',
  `update_time` datetime DEFAULT NULL COMMENT '最后一次修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='主题库';

INSERT INTO `setting` (`name`, `value`, `title`) VALUES ('webname','安米软件','网站名');
INSERT INTO `setting` (`name`, `value`, `title`) VALUES ('webdomain','ianmi.com','网站域名');
INSERT INTO `setting` (`name`, `value`, `title`) VALUES ('weblogo','/upload/logo/logo.png?t=1553673587','网站logo');

INSERT INTO `setting` (`name`, `value`, `title`) VALUES ('template','default','模板标识');

ALTER TABLE `category` ADD `is_auto` int(11) DEFAULT '0' COMMENT '是否开启审核';
ALTER TABLE `user` ADD `uuid` varchar(255) COMMENT '唯一识别码';

ALTER TABLE `theme` ADD `self_name` varchar(255) COMMENT '主题原本标识';
ALTER TABLE `theme` ADD `memo` text COMMENT '说明';
ALTER TABLE `theme` ADD `logo_path` varchar(255) DEFAULT '[]' COMMENT '展示图';
INSERT INTO `theme` (`id`, `title`, `self_name`, `name`, `status`, `version`, `memo`, `logo_path`) values (1, '简安米-系统默认', 'default', 'default', 1, '-.-.-', '简安米，一款以极简为理念的html5手机网站模板，且专注于移动端网站建设，专门为移动网站设计。功能强大，内容丰富，人性化的操作模式深受广大网友喜爱。', '[]') ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `title` = VALUES(`title`), `self_name` = VALUES(`self_name`), `name` = VALUES(`name`), `status` = VALUES(`status`), `version` = VALUES(`version`), `memo` = VALUES(`memo`), `logo_path` = VALUES(`logo_path`)