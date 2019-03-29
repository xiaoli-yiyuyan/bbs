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

