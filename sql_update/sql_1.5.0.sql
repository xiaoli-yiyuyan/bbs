ALTER TABLE `forum_mark` ADD `user_id` int(11) DEFAULT '0' COMMENT '添加的会员的ID';
ALTER TABLE `forum_mark` ADD `status` tinyint(3) DEFAULT '0' COMMENT '0审核中 1审核通过';

INSERT INTO `setting` (`name`, `value`, `title`)VALUES ('component', 'default', '组件标识');
