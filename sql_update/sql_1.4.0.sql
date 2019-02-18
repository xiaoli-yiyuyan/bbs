ALTER TABLE `forum` ADD `is_top` tinyint(3) DEFAULT '0' COMMENT '0不加顶 1加顶';
ALTER TABLE `forum` ADD `is_cream` tinyint(3) DEFAULT '0' COMMENT '0不精 1加精';