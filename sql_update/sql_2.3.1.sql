ALTER TABLE `user` ADD `uuid` varchar(255) COMMENT '唯一识别码';
UPDATE `user` SET `uuid` = `sid`;