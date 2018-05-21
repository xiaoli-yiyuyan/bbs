# Host: localhost  (Version: 5.5.47)
# Date: 2018-04-04 16:07:40
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "app"
#

DROP TABLE IF EXISTS `app`;
CREATE TABLE `app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `sid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT '0' COMMENT '0 普通，1 论坛',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (2,'聊天室',0),(3,'论坛栏目',1);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;


DROP TABLE IF EXISTS `chat`;
CREATE TABLE `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT '0',
  `touserid` int(11) DEFAULT '0',
  `content` varchar(5000) DEFAULT NULL,
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `appid` int(11) DEFAULT '0',
  `classid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=211 DEFAULT CHARSET=utf8;


/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
INSERT INTO `chat` VALUES (190,16,0,'??','2017-09-07 15:22:10',0,2),(191,16,0,'[表情:不要]','2017-09-07 15:22:27',0,2),(192,16,0,'打开机速度很快就','2017-09-07 15:22:59',0,2),(193,16,0,'青蛙多撒所多','2017-09-07 15:23:10',0,2),(194,16,0,'王企鹅奥多所撒','2017-09-07 15:23:13',0,2),(195,16,0,'玩的啊收到','2017-09-07 15:23:15',0,2),(196,16,0,'的','2017-09-07 15:23:16',0,2),(197,16,0,'收到','2017-09-07 15:23:17',0,2),(198,16,0,'阿萨德','2017-09-07 15:23:20',0,2),(199,16,0,'二','2017-09-07 15:24:04',0,2),(200,16,0,'123阿尔大厦','2017-09-07 15:24:12',0,2),(201,16,0,'[@:youxia]阿达','2017-09-07 15:24:18',0,2),(202,1,0,'[表情:抱抱][表情:抱抱][表情:抱抱][表情:奋斗]','2018-04-02 18:10:17',0,2),(203,1,0,'111','2018-04-03 11:09:26',0,2),(204,1,0,'...','2018-04-03 11:09:37',0,2),(205,1,0,'111','2018-04-04 11:04:46',0,2),(206,1,0,'5445','2018-04-04 11:54:24',0,2),(207,1,0,'，开会开会','2018-04-04 11:54:33',0,2),(208,1,0,'51515','2018-04-04 11:55:17',0,2),(209,1,0,'fghjl','2018-04-04 11:55:56',0,2),(210,1,0,'...','2018-04-04 13:36:29',0,2);
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;

#
# Structure for table "collect_nav"
#

DROP TABLE IF EXISTS `collect_nav`;
CREATE TABLE `collect_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `userid` int(11) DEFAULT '0',
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "collect_nav"
#

/*!40000 ALTER TABLE `collect_nav` DISABLE KEYS */;
/*!40000 ALTER TABLE `collect_nav` ENABLE KEYS */;

#
# Structure for table "forum"
#

DROP TABLE IF EXISTS `forum`;
CREATE TABLE `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `context` text,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '0',
  `log` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "forum"
#

/*!40000 ALTER TABLE `forum` DISABLE KEYS */;
INSERT INTO `forum` VALUES (1,2,1,'sfrsdfds',NULL,'2018-03-30 15:27:44',0,NULL),(2,2,1,'lijl',NULL,'2018-03-30 15:28:17',0,NULL),(3,2,1,'lijl','kugk','2018-03-30 15:30:18',0,NULL);
/*!40000 ALTER TABLE `forum` ENABLE KEYS */;

#
# Structure for table "forum_mark"
#

DROP TABLE IF EXISTS `forum_mark`;
CREATE TABLE `forum_mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "forum_mark"
#

/*!40000 ALTER TABLE `forum_mark` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_mark` ENABLE KEYS */;

#
# Structure for table "forum_mark_body"
#

DROP TABLE IF EXISTS `forum_mark_body`;
CREATE TABLE `forum_mark_body` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mark_id` int(11) DEFAULT '0',
  `forum_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "forum_mark_body"
#

/*!40000 ALTER TABLE `forum_mark_body` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_mark_body` ENABLE KEYS */;

#
# Structure for table "forum_reply"
#

DROP TABLE IF EXISTS `forum_reply`;
CREATE TABLE `forum_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `content` varchar(255) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "forum_reply"
#

/*!40000 ALTER TABLE `forum_reply` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_reply` ENABLE KEYS */;

#
# Structure for table "novel"
#

DROP TABLE IF EXISTS `novel`;
CREATE TABLE `novel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `memo` varchar(1000) DEFAULT NULL,
  `markid` int(11) DEFAULT '0',
  `author` varchar(255) DEFAULT NULL COMMENT '作者',
  `wordcount` varchar(255) DEFAULT NULL,
  `money` varchar(255) DEFAULT '' COMMENT '0免费，<0 购买',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

#
# Data for table "novel"
#

/*!40000 ALTER TABLE `novel` DISABLE KEYS */;
INSERT INTO `novel` VALUES (76,0,'巫师亚伯','http://qidian.qpic.cn/qdbimg/349573/1007994514/180','魔兽践踏，巨龙咆哮，巫师诅咒，魔法璀璨之光照耀知识灯塔！',3,'吃瓜子群众','12.9万',''),(77,0,'爱迪生大多','','阿萨德',0,'阿达','爱迪生','');
/*!40000 ALTER TABLE `novel` ENABLE KEYS */;

#
# Structure for table "novel_chapter"
#

DROP TABLE IF EXISTS `novel_chapter`;
CREATE TABLE `novel_chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT '0',
  `navid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `read` int(11) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `novelid` int(11) DEFAULT '0',
  `money` int(11) DEFAULT '0' COMMENT '0免费 0< 收费',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=374 DEFAULT CHARSET=utf8;

INSERT INTO `novel_chapter` VALUES (25,0,0,'第1章 夜空下的男孩','NovelChapter/76/4_25.txt',NULL,NULL,76,0),(26,0,0,'上架感言','NovelChapter/76/5_26.txt',NULL,NULL,76,0),(27,0,0,'第2章 赫拉迪克方块','NovelChapter/76/6_27.txt',NULL,NULL,76,0),(28,0,0,'第3章 暗影豹','NovelChapter/76/7_28.txt',NULL,NULL,76,0),(29,0,0,'第4章 利堡镇','NovelChapter/76/8_29.txt',NULL,NULL,76,0),(30,0,0,'第5章 艾德蒙拍卖行','NovelChapter/76/9_30.txt',NULL,NULL,76,0),(31,0,0,'第6章 大师级药剂','NovelChapter/76/10_31.txt',NULL,NULL,76,0),(32,0,0,'第7章 父亲的指导','NovelChapter/76/11_32.txt',NULL,NULL,76,0),(33,0,0,'第8章 惊人的决定','NovelChapter/76/12_33.txt',NULL,NULL,76,0),(34,0,0,'第9章 境界连续提升','NovelChapter/76/13_34.txt',NULL,NULL,76,0),(35,0,0,'第10章 出发','NovelChapter/76/14_35.txt',NULL,NULL,76,0),(36,0,0,'第11章 收养','NovelChapter/76/15_36.txt',NULL,NULL,76,0),(37,0,0,'第12章 欢迎舞会','NovelChapter/76/16_37.txt',NULL,NULL,76,0),(38,0,0,'第13章 晨语','NovelChapter/76/17_38.txt',NULL,NULL,76,0),(39,0,0,'第14章 本瑟姆大师','NovelChapter/76/18_39.txt',NULL,NULL,76,0),(40,0,0,'第15章 学习锻造','NovelChapter/76/19_40.txt',NULL,NULL,76,0),(41,0,0,'第16章 顿悟','NovelChapter/76/20_41.txt',NULL,NULL,76,0),(42,0,0,'第17章 百练大剑','NovelChapter/76/21_42.txt',NULL,NULL,76,0),(43,0,0,'第18章 丰收城','NovelChapter/76/22_43.txt',NULL,NULL,76,0),(44,0,0,'第19章 赌局','NovelChapter/76/23_44.txt',NULL,NULL,76,0),(45,0,0,'第20章 再次合成','NovelChapter/76/24_45.txt',NULL,NULL,76,0),(46,0,0,'第21章 无聊的酒会','NovelChapter/76/25_46.txt',NULL,NULL,76,0),(47,0,0,'第22章 袭击','NovelChapter/76/26_47.txt',NULL,NULL,76,0),(48,0,0,'第23章 符文','NovelChapter/76/27_48.txt',NULL,NULL,76,0),(49,0,0,'第24章 冰魔法大剑','NovelChapter/76/28_49.txt',NULL,NULL,76,0),(50,0,0,'第25章 铁匠大师','NovelChapter/76/29_50.txt',NULL,NULL,76,0),(51,0,0,'第26章 再至拍卖行','NovelChapter/76/30_51.txt',NULL,NULL,76,0),(52,0,0,'第27章 狼骑兵','NovelChapter/76/31_52.txt',NULL,NULL,76,0),(53,0,0,'第28章 战前准备','NovelChapter/76/32_53.txt',NULL,NULL,76,0),(54,0,0,'第29章 大型捕兽夹','NovelChapter/76/33_54.txt',NULL,NULL,76,0),(55,0,0,'第30章 狼人西蒙','NovelChapter/76/34_55.txt',NULL,NULL,76,0),(56,0,0,'第31章 兽人技能牌','NovelChapter/76/35_56.txt',NULL,NULL,76,0),(57,0,0,'第32章 亚伯的座狼','NovelChapter/76/36_57.txt',NULL,NULL,76,0),(58,0,0,'第33章 回堡','NovelChapter/76/37_58.txt',NULL,NULL,76,0),(59,0,0,'第34章 复合弓','NovelChapter/76/38_59.txt',NULL,NULL,76,0),(60,0,0,'第35章 初射','NovelChapter/76/39_60.txt',NULL,NULL,76,0),(61,0,0,'第36章 明抢','NovelChapter/76/40_61.txt',NULL,NULL,76,0),(62,0,0,'第37章 送弓','NovelChapter/76/41_62.txt',NULL,NULL,76,0),(63,0,0,'第38章 马修城堡','NovelChapter/76/42_63.txt',NULL,NULL,76,0),(64,0,0,'第39章 骑士秘技','NovelChapter/76/43_64.txt',NULL,NULL,76,0),(65,0,0,'第40章 巫师的消息','NovelChapter/76/44_65.txt',NULL,NULL,76,0),(66,0,0,'第41章 新的符文','NovelChapter/76/45_66.txt',NULL,NULL,76,0),(67,0,0,'第42章 无属性魔法大剑','NovelChapter/76/46_67.txt',NULL,NULL,76,0),(68,0,0,'第43章 震退敌人','NovelChapter/76/47_68.txt',NULL,NULL,76,0),(69,0,0,'第44章 试剑','NovelChapter/76/48_69.txt',NULL,NULL,76,0),(70,0,0,'第45章 大麻烦','NovelChapter/76/49_70.txt',NULL,NULL,76,0),(71,0,0,'第46章 埋伏','NovelChapter/76/50_71.txt',NULL,NULL,76,0),(72,0,0,'第47章 冲击与防御','NovelChapter/76/51_72.txt',NULL,NULL,76,0),(73,0,0,'第48章 骑士团冲锋','NovelChapter/76/52_73.txt',NULL,NULL,76,0),(74,0,0,'第49章 大收获','NovelChapter/76/53_74.txt',NULL,NULL,76,0),(75,0,0,'第50章 变身项链','NovelChapter/76/54_75.txt',NULL,NULL,76,0),(76,0,0,'第51章 重天雀白云','NovelChapter/76/55_76.txt',NULL,NULL,76,0),(77,0,0,'第52章 晋升正式骑士','NovelChapter/76/56_77.txt',NULL,NULL,76,0),(78,0,0,'第53章 飞翔','NovelChapter/76/57_78.txt',NULL,NULL,76,0),(79,0,0,'第54章 淡金色斗气','NovelChapter/76/58_79.txt',NULL,NULL,76,0),(80,0,0,'第55章 力量增幅','NovelChapter/76/59_80.txt',NULL,NULL,76,0),(81,0,0,'第56章 封赏','NovelChapter/76/60_81.txt',NULL,NULL,76,0),(82,0,0,'第57章 修练药剂','NovelChapter/76/61_82.txt',NULL,NULL,76,0),(83,0,0,'第58章 马修城堡密室','NovelChapter/76/62_83.txt',NULL,NULL,76,0),(84,0,0,'第59章 铁陨石','NovelChapter/76/63_84.txt',NULL,NULL,76,0),(85,0,0,'第60章 服用药剂','NovelChapter/76/64_85.txt',NULL,NULL,76,0),(86,0,0,'第61章 超级牛车','NovelChapter/76/65_86.txt',NULL,NULL,76,0),(87,0,0,'第62章 锻打粗坯','NovelChapter/76/66_87.txt',NULL,NULL,76,0),(88,0,0,'第63章 晚宴','NovelChapter/76/67_88.txt',NULL,NULL,76,0),(89,0,0,'第64章 怀亚特王子','NovelChapter/76/68_89.txt',NULL,NULL,76,0),(90,0,0,'第65章 估价','NovelChapter/76/69_90.txt',NULL,NULL,76,0),(91,0,0,'第66章 生日礼物','NovelChapter/76/70_91.txt',NULL,NULL,76,0),(92,0,0,'第67章 土豪马歇尔','NovelChapter/76/71_92.txt',NULL,NULL,76,0),(93,0,0,'第68章 王子的袭杀','NovelChapter/76/72_93.txt',NULL,NULL,76,0),(94,0,0,'第69章 金币骑士的胜利','NovelChapter/76/73_94.txt',NULL,NULL,76,0),(95,0,0,'第70章 追杀','NovelChapter/76/74_95.txt',NULL,NULL,76,0),(96,0,0,'第71章 杀王','NovelChapter/76/75_96.txt',NULL,NULL,76,0),(97,0,0,'第72章 锻造盔甲','NovelChapter/76/76_97.txt',NULL,NULL,76,0),(98,0,0,'第73章 赚金币','NovelChapter/76/77_98.txt',NULL,NULL,76,0),(99,0,0,'第74章 坏消息','NovelChapter/76/78_99.txt',NULL,NULL,76,0),(100,0,0,'第75章 赫拉迪克方块的新功能','NovelChapter/76/79_100.txt',NULL,NULL,76,0),(101,0,0,'第76章 忙碌和中餐','NovelChapter/76/80_101.txt',NULL,NULL,76,0),(102,0,0,'第77章 换装','NovelChapter/76/81_102.txt',NULL,NULL,76,0),(103,0,0,'第78章 伍尔芙来袭','NovelChapter/76/82_103.txt',NULL,NULL,76,0),(104,0,0,'第79章 串杀','NovelChapter/76/83_104.txt',NULL,NULL,76,0),(105,0,0,'第80章 大战','NovelChapter/76/84_105.txt',NULL,NULL,76,0),(106,0,0,'第81章 狼人的秘密据点','NovelChapter/76/85_106.txt',NULL,NULL,76,0),(107,0,0,'第82章 人奸','NovelChapter/76/86_107.txt',NULL,NULL,76,0),(108,0,0,'第83章 空间物品','NovelChapter/76/87_108.txt',NULL,NULL,76,0),(109,0,0,'第84章 收刮','NovelChapter/76/88_109.txt',NULL,NULL,76,0),(110,0,0,'第85章 黑拍','NovelChapter/76/89_110.txt',NULL,NULL,76,0),(111,0,0,'第86章 拍卖精灵','NovelChapter/76/90_111.txt',NULL,NULL,76,0),(112,0,0,'第87章 罗德尼高级骑士','NovelChapter/76/91_112.txt',NULL,NULL,76,0),(113,0,0,'第88章 晋升中级骑士','NovelChapter/76/92_113.txt',NULL,NULL,76,0),(114,0,0,'第89章 调查','NovelChapter/76/93_114.txt',NULL,NULL,76,0),(115,0,0,'第90章 清白的亚伯','NovelChapter/76/94_115.txt',NULL,NULL,76,0),(116,0,0,'第91章 学习','NovelChapter/76/95_116.txt',NULL,NULL,76,0),(117,0,0,'第92章 人情','NovelChapter/76/96_117.txt',NULL,NULL,76,0),(118,0,0,'第93章 准备','NovelChapter/76/97_118.txt',NULL,NULL,76,0),(119,0,0,'第94章 马瓦城','NovelChapter/76/98_119.txt',NULL,NULL,76,0),(120,0,0,'第95章 骑士长的礼物','NovelChapter/76/99_120.txt',NULL,NULL,76,0),(121,0,0,'第96章 抵达刚巴城','NovelChapter/76/100_121.txt',NULL,NULL,76,0),(122,0,0,'第97章 王宫授勋','NovelChapter/76/101_122.txt',NULL,NULL,76,0),(123,0,0,'第98章 回族','NovelChapter/76/102_123.txt',NULL,NULL,76,0),(124,0,0,'第99章 冲阵','NovelChapter/76/103_124.txt',NULL,NULL,76,0),(125,0,0,'第100章 巫师','NovelChapter/76/104_125.txt',NULL,NULL,76,0),(126,0,0,'第101章 伊夫林魔法塔','NovelChapter/76/105_126.txt',NULL,NULL,76,0),(127,0,0,'第102章 巫师初级冥想法','NovelChapter/76/106_127.txt',NULL,NULL,76,0),(128,0,0,'第103章 魔力','NovelChapter/76/107_128.txt',NULL,NULL,76,0),(129,0,0,'第104章 汇报','NovelChapter/76/108_129.txt',NULL,NULL,76,0),(130,0,0,'第105章 冥想','NovelChapter/76/109_130.txt',NULL,NULL,76,0),(131,0,0,'第106章 一级见习巫师','NovelChapter/76/110_131.txt',NULL,NULL,76,0),(132,0,0,'第107章 强大的金色斗气','NovelChapter/76/111_132.txt',NULL,NULL,76,0),(133,0,0,'第108章 闹剧','NovelChapter/76/112_133.txt',NULL,NULL,76,0),(134,0,0,'第109章 贵族仲裁庭','NovelChapter/76/113_134.txt',NULL,NULL,76,0),(135,0,0,'第110章 传送门','NovelChapter/76/114_135.txt',NULL,NULL,76,0),(136,0,0,'第111章 阿卡拉','NovelChapter/76/115_136.txt',NULL,NULL,76,0),(137,0,0,'第112章 鲜血荒地','NovelChapter/76/116_137.txt',NULL,NULL,76,0),(138,0,0,'第113章 时间差异','NovelChapter/76/117_138.txt',NULL,NULL,76,0),(139,0,0,'第114章 锻造','NovelChapter/76/118_139.txt',NULL,NULL,76,0),(140,0,0,'第115章 火弹','NovelChapter/76/119_140.txt',NULL,NULL,76,0),(141,0,0,'第116章 中年巫师','NovelChapter/76/120_141.txt',NULL,NULL,76,0),(142,0,0,'第117章 打算','NovelChapter/76/121_142.txt',NULL,NULL,76,0),(143,0,0,'第118章 赔偿','NovelChapter/76/122_143.txt',NULL,NULL,76,0),(144,0,0,'第119章 大王子的好意','NovelChapter/76/123_144.txt',NULL,NULL,76,0),(145,0,0,'第120章 送上门的斗气','NovelChapter/76/124_145.txt',NULL,NULL,76,0),(146,0,0,'第121章 离开','NovelChapter/76/125_146.txt',NULL,NULL,76,0),(147,0,0,'第122章 莫尔顿魔法塔','NovelChapter/76/126_147.txt',NULL,NULL,76,0),(148,0,0,'第123章 教诲','NovelChapter/76/127_148.txt',NULL,NULL,76,0),(149,0,0,'第124章 属性','NovelChapter/76/128_149.txt',NULL,NULL,76,0),(150,0,0,'第125章 入住','NovelChapter/76/129_150.txt',NULL,NULL,76,0),(151,0,0,'第126章 传送阵','NovelChapter/76/130_151.txt',NULL,NULL,76,0),(152,0,0,'第127章 座狼训练师','NovelChapter/76/131_152.txt',NULL,NULL,76,0),(153,0,0,'第128章 四个月','NovelChapter/76/132_153.txt',NULL,NULL,76,0),(154,0,0,'第129章 黑风初骑','NovelChapter/76/133_154.txt',NULL,NULL,76,0),(155,0,0,'第130章 城门','NovelChapter/76/134_155.txt',NULL,NULL,76,0),(156,0,0,'第131章 带你飞','NovelChapter/76/135_156.txt',NULL,NULL,76,0),(157,0,0,'第132章 小心思','NovelChapter/76/136_157.txt',NULL,NULL,76,0),(158,0,0,'第133章 供奉','NovelChapter/76/134_158.txt',NULL,NULL,76,0),(159,0,0,'第134章 历史','NovelChapter/76/135_159.txt',NULL,NULL,76,0),(160,0,0,'第135章 莫尔顿见闻录','NovelChapter/76/136_160.txt',NULL,NULL,76,0),(161,0,0,'第136章 传送','NovelChapter/76/137_161.txt',NULL,NULL,76,0),(162,0,0,'第137章 卡拉尔城','NovelChapter/76/138_162.txt',NULL,NULL,76,0),(163,0,0,'第138章 合金刻刀','NovelChapter/76/139_163.txt',NULL,NULL,76,0),(164,0,0,'第139章 购买','NovelChapter/76/140_164.txt',NULL,NULL,76,0),(165,0,0,'第140章 黑巫师','NovelChapter/76/141_165.txt',NULL,NULL,76,0),(166,0,0,'第141章 撩阴腿','NovelChapter/76/142_166.txt',NULL,NULL,76,0),(167,0,0,'第142章 回塔','NovelChapter/76/143_167.txt',NULL,NULL,76,0),(168,0,0,'第143章 房契','NovelChapter/76/144_168.txt',NULL,NULL,76,0),(169,0,0,'第144章 伊夫林巫师','NovelChapter/76/145_169.txt',NULL,NULL,76,0),(170,0,0,'第145章 帐篷','NovelChapter/76/146_170.txt',NULL,NULL,76,0),(171,0,0,'第146章 冰封装甲','NovelChapter/76/147_171.txt',NULL,NULL,76,0),(172,0,0,'第147章 坚固防御','NovelChapter/76/148_172.txt',NULL,NULL,76,0),(173,0,0,'第148章 灵魂药剂','NovelChapter/76/149_173.txt',NULL,NULL,76,0),(174,0,0,'第149章 僵尸','NovelChapter/76/150_174.txt',NULL,NULL,76,0),(175,0,0,'第150章 消息','NovelChapter/76/151_175.txt',NULL,NULL,76,0),(176,0,0,'第151章 刺杀','NovelChapter/76/152_176.txt',NULL,NULL,76,0),(177,0,0,'第152章 战斗','NovelChapter/76/153_177.txt',NULL,NULL,76,0),(178,0,0,'第153章 吸收','NovelChapter/76/154_178.txt',NULL,NULL,76,0),(179,0,0,'第154章 高级骑士','NovelChapter/76/155_179.txt',NULL,NULL,76,0),(180,0,0,'第155章 见习法术','NovelChapter/76/156_180.txt',NULL,NULL,76,0),(181,0,0,'第156章 刻刀','NovelChapter/76/157_181.txt',NULL,NULL,76,0),(182,0,0,'第157章 弱小灵魂的新用处','NovelChapter/76/158_182.txt',NULL,NULL,76,0),(183,0,0,'第158章 意外频发的午餐','NovelChapter/76/159_183.txt',NULL,NULL,76,0),(184,0,0,'第159章 金行','NovelChapter/76/160_184.txt',NULL,NULL,76,0),(185,0,0,'第160章 领取供奉','NovelChapter/76/161_185.txt',NULL,NULL,76,0),(186,0,0,'第161章 黑风进入','NovelChapter/76/162_186.txt',NULL,NULL,76,0),(187,0,0,'第162章 黑风初战','NovelChapter/76/163_187.txt',NULL,NULL,76,0),(188,0,0,'第163章 短棍','NovelChapter/76/164_188.txt',NULL,NULL,76,0),(189,0,0,'第164章 再服灵魂药剂','NovelChapter/76/165_189.txt',NULL,NULL,76,0),(190,0,0,'第165章 增强','NovelChapter/76/166_190.txt',NULL,NULL,76,0),(191,0,0,'第166章 学习制作符文牌','NovelChapter/76/167_191.txt',NULL,NULL,76,0),(192,0,0,'第167章 第一次制作','NovelChapter/76/168_192.txt',NULL,NULL,76,0),(193,0,0,'第168章 三级见习巫师','NovelChapter/76/169_193.txt',NULL,NULL,76,0),(194,0,0,'第169章 任务','NovelChapter/76/170_194.txt',NULL,NULL,76,0),(195,0,0,'第170章 物品清单','NovelChapter/76/171_195.txt',NULL,NULL,76,0),(196,0,0,'第171章 祭祀','NovelChapter/76/172_196.txt',NULL,NULL,76,0),(197,0,0,'第172章 刁难','NovelChapter/76/173_197.txt',NULL,NULL,76,0),(198,0,0,'第173章 琼森巫师','NovelChapter/76/174_198.txt',NULL,NULL,76,0),(199,0,0,'第174章 符文笔','NovelChapter/76/175_199.txt',NULL,NULL,76,0),(200,0,0,'第175章 对战测试','NovelChapter/76/176_200.txt',NULL,NULL,76,0),(201,0,0,'第176章 第一次任务','NovelChapter/76/177_201.txt',NULL,NULL,76,0),(202,0,0,'第177章 搏命防御','NovelChapter/76/178_202.txt',NULL,NULL,76,0),(203,0,0,'第178章 巫师之间的战斗','NovelChapter/76/179_203.txt',NULL,NULL,76,0),(204,0,0,'第179章 打断','NovelChapter/76/180_204.txt',NULL,NULL,76,0),(205,0,0,'第180章 战后','NovelChapter/76/181_205.txt',NULL,NULL,76,0),(206,0,0,'第181章 回公会','NovelChapter/76/182_206.txt',NULL,NULL,76,0),(207,0,0,'第182章 急召','NovelChapter/76/183_207.txt',NULL,NULL,76,0),(208,0,0,'第183章 来自基恩公国的报复','NovelChapter/76/184_208.txt',NULL,NULL,76,0),(209,0,0,'第184章 线索','NovelChapter/76/185_209.txt',NULL,NULL,76,0),(210,0,0,'第185章 找到','NovelChapter/76/186_210.txt',NULL,NULL,76,0),(211,0,0,'第186章 袭杀','NovelChapter/76/187_211.txt',NULL,NULL,76,0),(212,0,0,'第187章 感谢','NovelChapter/76/188_212.txt',NULL,NULL,76,0),(213,0,0,'第188章 醉酒晋升','NovelChapter/76/189_213.txt',NULL,NULL,76,0),(214,0,0,'第189章 骷髅复生','NovelChapter/76/190_214.txt',NULL,NULL,76,0),(215,0,0,'第190章 排骨','NovelChapter/76/191_215.txt',NULL,NULL,76,0),(216,0,0,'第191章 逆鳞','NovelChapter/76/192_216.txt',NULL,NULL,76,0),(217,0,0,'第192章 白云黑风的新能力','NovelChapter/76/193_217.txt',NULL,NULL,76,0),(218,0,0,'第193章 新的魔法武器','NovelChapter/76/194_218.txt',NULL,NULL,76,0),(219,0,0,'第194章 新的超级爆炸球','NovelChapter/76/195_219.txt',NULL,NULL,76,0),(220,0,0,'第195章 积分兑换','NovelChapter/76/196_220.txt',NULL,NULL,76,0),(221,0,0,'第196章 再涨实力','NovelChapter/76/197_221.txt',NULL,NULL,76,0),(222,0,0,'第197章 开始报复','NovelChapter/76/198_222.txt',NULL,NULL,76,0),(223,0,0,'第198章 惊天动地','NovelChapter/76/199_223.txt',NULL,NULL,76,0),(224,0,0,'第199章 凶手成替罪羊','NovelChapter/76/200_224.txt',NULL,NULL,76,0),(225,0,0,'第200章 劝离','NovelChapter/76/201_225.txt',NULL,NULL,76,0),(226,0,0,'第201章 传送中的红衣巫师','NovelChapter/76/202_226.txt',NULL,NULL,76,0),(227,0,0,'第202章 高级巫师','NovelChapter/76/203_227.txt',NULL,NULL,76,0),(228,0,0,'第203章 解围','NovelChapter/76/204_228.txt',NULL,NULL,76,0),(229,0,0,'第204章 半日之约','NovelChapter/76/205_229.txt',NULL,NULL,76,0),(230,0,0,'第205章 安排','NovelChapter/76/206_230.txt',NULL,NULL,76,0),(231,0,0,'第206章 决定','NovelChapter/76/207_231.txt',NULL,NULL,76,0),(232,0,0,'第207章 姆根镇','NovelChapter/76/208_232.txt',NULL,NULL,76,0),(233,0,0,'第208章 精灵香水','NovelChapter/76/209_233.txt',NULL,NULL,76,0),(234,0,0,'第209章 炼金','NovelChapter/76/210_234.txt',NULL,NULL,76,0),(235,0,0,'第210章 初炼','NovelChapter/76/211_235.txt',NULL,NULL,76,0),(236,0,0,'第211章 拦截','NovelChapter/76/212_236.txt',NULL,NULL,76,0),(237,0,0,'第212章 卫月城','NovelChapter/76/213_237.txt',NULL,NULL,76,0),(238,0,0,'第213章 再进','NovelChapter/76/214_238.txt',NULL,NULL,76,0),(239,0,0,'第214章 尸体发火','NovelChapter/76/215_239.txt',NULL,NULL,76,0),(240,0,0,'第215章 英勇的排骨','NovelChapter/76/216_240.txt',NULL,NULL,76,0),(241,0,0,'第216章 弗拉维','NovelChapter/76/217_241.txt',NULL,NULL,76,0),(242,0,0,'第217章 排骨二号','NovelChapter/76/218_242.txt',NULL,NULL,76,0),(243,0,0,'第218章 伯尼','NovelChapter/76/219_243.txt',NULL,NULL,76,0),(244,0,0,'第219章 朗姆酒','NovelChapter/76/220_244.txt',NULL,NULL,76,0),(245,0,0,'第220章 交易','NovelChapter/76/221_245.txt',NULL,NULL,76,0),(246,0,0,'第221章 野蛮蜂','NovelChapter/76/222_246.txt',NULL,NULL,76,0),(247,0,0,'第222章 黄金飞骑的死亡','NovelChapter/76/223_247.txt',NULL,NULL,76,0),(248,0,0,'第223章 营地','NovelChapter/76/224_248.txt',NULL,NULL,76,0),(249,0,0,'第224章 捕猎','NovelChapter/76/225_249.txt',NULL,NULL,76,0),(250,0,0,'第225章 新鲜晶核','NovelChapter/76/226_250.txt',NULL,NULL,76,0),(251,0,0,'第226章 洛兰晚餐','NovelChapter/76/227_251.txt',NULL,NULL,76,0),(252,0,0,'第227章 追捕','NovelChapter/76/228_252.txt',NULL,NULL,76,0),(253,0,0,'第228章 晋升骑士长','NovelChapter/76/229_253.txt',NULL,NULL,76,0),(254,0,0,'第229章 发现','NovelChapter/76/230_254.txt',NULL,NULL,76,0),(255,0,0,'第230章 丛林巨蟒','NovelChapter/76/231_255.txt',NULL,NULL,76,0),(256,0,0,'第231章 冰火猿','NovelChapter/76/232_256.txt',NULL,NULL,76,0),(257,0,0,'第232章 拖延','NovelChapter/76/233_257.txt',NULL,NULL,76,0),(258,0,0,'第233章 晶体','NovelChapter/76/234_258.txt',NULL,NULL,76,0),(259,0,0,'第234章 回返','NovelChapter/76/235_259.txt',NULL,NULL,76,0),(260,0,0,'第235章 中级防御法阵','NovelChapter/76/236_260.txt',NULL,NULL,76,0),(261,0,0,'第236章 取消召唤','NovelChapter/76/237_261.txt',NULL,NULL,76,0),(262,0,0,'第237章 渡鸟之爪','NovelChapter/76/238_262.txt',NULL,NULL,76,0),(263,0,0,'第238章 暗金之威','NovelChapter/76/239_263.txt',NULL,NULL,76,0),(264,0,0,'第239章 蓝色戒指','NovelChapter/76/240_264.txt',NULL,NULL,76,0),(265,0,0,'第240章 威压之变','NovelChapter/76/241_265.txt',NULL,NULL,76,0),(266,0,0,'第241章 伯尼的好意','NovelChapter/76/242_266.txt',NULL,NULL,76,0),(267,0,0,'第242章 城防弩','NovelChapter/76/243_267.txt',NULL,NULL,76,0),(268,0,0,'第243章 轰炸灰矮人山谷','NovelChapter/76/244_268.txt',NULL,NULL,76,0),(269,0,0,'第244章 雕像','NovelChapter/76/245_269.txt',NULL,NULL,76,0),(270,0,0,'第245章 精灵之城','NovelChapter/76/246_270.txt',NULL,NULL,76,0),(271,0,0,'第246章 洛兰的家','NovelChapter/76/247_271.txt',NULL,NULL,76,0),(272,0,0,'第247章 身份暴露','NovelChapter/76/248_272.txt',NULL,NULL,76,0),(273,0,0,'第248章 分别的礼物','NovelChapter/76/249_273.txt',NULL,NULL,76,0),(274,0,0,'第249章 女性美容大全','NovelChapter/76/250_274.txt',NULL,NULL,76,0),(275,0,0,'第250 玛拉大师','NovelChapter/76/251_275.txt',NULL,NULL,76,0),(276,0,0,'第251章 亚伯的别墅','NovelChapter/76/252_276.txt',NULL,NULL,76,0),(277,0,0,'第252章 中级炼金师','NovelChapter/76/253_277.txt',NULL,NULL,76,0),(278,0,0,'第253章 拜访','NovelChapter/76/254_278.txt',NULL,NULL,76,0),(279,0,0,'第254章 神奇的改变','NovelChapter/76/255_279.txt',NULL,NULL,76,0),(280,0,0,'第255章 难以入口的小牛肉','NovelChapter/76/256_280.txt',NULL,NULL,76,0),(281,0,0,'第256章 巴哈姆特之吸血鬼的戒指','NovelChapter/76/257_281.txt',NULL,NULL,76,0),(282,0,0,'第257章 强大的沉沦魔军团','NovelChapter/76/258_282.txt',NULL,NULL,76,0),(283,0,0,'第258章 精灵香水的另类用法','NovelChapter/76/259_283.txt',NULL,NULL,76,0),(284,0,0,'第259章 毕须博须','NovelChapter/76/260_284.txt',NULL,NULL,76,0),(285,0,0,'第260章 暗金法杖','NovelChapter/76/261_285.txt',NULL,NULL,76,0),(286,0,0,'第261章 火焰强化','NovelChapter/76/262_286.txt',NULL,NULL,76,0),(287,0,0,'第262章 有孔装备','NovelChapter/76/263_287.txt',NULL,NULL,76,0),(288,0,0,'第263章 装备打孔','NovelChapter/76/264_288.txt',NULL,NULL,76,0),(289,0,0,'第264章 精灵议员','NovelChapter/76/265_289.txt',NULL,NULL,76,0),(290,0,0,'第265章 授勋仪式','NovelChapter/76/266_290.txt',NULL,NULL,76,0),(291,0,0,'第266章 欢迎宴会','NovelChapter/76/267_291.txt',NULL,NULL,76,0),(292,0,0,'第267章 德鲁伊默林(为盟主 暮之星 加更!)','NovelChapter/76/268_292.txt',NULL,NULL,76,0),(293,0,0,'第268章 成为小德的弱小灵魂','NovelChapter/76/269_293.txt',NULL,NULL,76,0),(294,0,0,'第269章 小德的知识','NovelChapter/76/270_294.txt',NULL,NULL,76,0),(295,0,0,'第270章 小德的法术','NovelChapter/76/271_295.txt',NULL,NULL,76,0),(296,0,0,'第271章 蓝吼兔','NovelChapter/76/272_296.txt',NULL,NULL,76,0),(297,0,0,'第272章 荣誉炼金大师','NovelChapter/76/273_297.txt',NULL,NULL,76,0),(298,0,0,'第273章 左右开弓','NovelChapter/76/274_298.txt',NULL,NULL,76,0),(299,0,0,'第274章 卡丽的邀请','NovelChapter/76/275_299.txt',NULL,NULL,76,0),(300,0,0,'第275章 精灵炼金公会','NovelChapter/76/276_300.txt',NULL,NULL,76,0),(301,0,0,'第276章 又一枚大师勋章','NovelChapter/76/277_301.txt',NULL,NULL,76,0),(302,0,0,'第277章 遇刺','NovelChapter/76/278_302.txt',NULL,NULL,76,0),(303,0,0,'第278章 暗精灵','NovelChapter/76/279_303.txt',NULL,NULL,76,0),(304,0,0,'第279章 阵牌','NovelChapter/76/280_304.txt',NULL,NULL,76,0),(305,0,0,'第280章 骷髅骑士','NovelChapter/76/281_305.txt',NULL,NULL,76,0),(306,0,0,'第281章 打造套装','NovelChapter/76/282_306.txt',NULL,NULL,76,0),(307,0,0,'第282章 石块旷野','NovelChapter/76/283_307.txt',NULL,NULL,76,0),(308,0,0,'第283章 骑士战队','NovelChapter/76/284_308.txt',NULL,NULL,76,0),(309,0,0,'第284章 修炼手册','NovelChapter/76/285_309.txt',NULL,NULL,76,0),(310,0,0,'第285章 孕灵','NovelChapter/76/286_310.txt',NULL,NULL,76,0),(311,0,0,'第286章 恶臭乌鸦','NovelChapter/76/287_311.txt',NULL,NULL,76,0),(312,0,0,'第287章 拉卡尼休','NovelChapter/76/288_312.txt',NULL,NULL,76,0),(313,0,0,'第288章 黑风的速度','NovelChapter/76/289_313.txt',NULL,NULL,76,0),(314,0,0,'第289章 幼年蓝吼兔','NovelChapter/76/290_314.txt',NULL,NULL,76,0),(315,0,0,'第290章 地底通道','NovelChapter/76/291_315.txt',NULL,NULL,76,0),(316,0,0,'第291章 地底之战','NovelChapter/76/292_316.txt',NULL,NULL,76,0),(317,0,0,'第292章 地底二层','NovelChapter/76/293_317.txt',NULL,NULL,76,0),(318,0,0,'第293章 腰带的作用','NovelChapter/76/294_318.txt',NULL,NULL,76,0),(319,0,0,'第294章 真正的符文','NovelChapter/76/295_319.txt',NULL,NULL,76,0),(320,0,0,'第295章 回府','NovelChapter/76/296_320.txt',NULL,NULL,76,0),(321,0,0,'第296章 跟踪','NovelChapter/76/297_321.txt',NULL,NULL,76,0),(322,0,0,'第297章 老朋友相遇','NovelChapter/76/298_322.txt',NULL,NULL,76,0),(323,0,0,'第298章 与白云共处','NovelChapter/76/299_323.txt',NULL,NULL,76,0),(324,0,0,'第299章 委托','NovelChapter/76/300_324.txt',NULL,NULL,76,0),(325,0,0,'第300章 莫尔顿晋级','NovelChapter/76/301_325.txt',NULL,NULL,76,0),(326,0,0,'第301章 关心','NovelChapter/76/302_326.txt',NULL,NULL,76,0),(327,0,0,'第302章 特尔符文','NovelChapter/76/303_327.txt',NULL,NULL,76,0),(328,0,0,'第303章 王子的晚会','NovelChapter/76/304_328.txt',NULL,NULL,76,0),(329,0,0,'第304章 交锋','NovelChapter/76/305_329.txt',NULL,NULL,76,0),(330,0,0,'第305章 罗兰小队','NovelChapter/76/306_330.txt',NULL,NULL,76,0),(331,0,0,'第306章 拍品','NovelChapter/76/307_331.txt',NULL,NULL,76,0),(332,0,0,'第307章 亚伯大师的大剑','NovelChapter/76/308_332.txt',NULL,NULL,76,0),(333,0,0,'第308章 拍卖药剂','NovelChapter/76/309_333.txt',NULL,NULL,76,0),(334,0,0,'第309章 威胁','NovelChapter/76/310_334.txt',NULL,NULL,76,0),(335,0,0,'第310章 来访的矮人','NovelChapter/76/311_335.txt',NULL,NULL,76,0),(336,0,0,'第311章 阿尔奇战死','NovelChapter/76/312_336.txt',NULL,NULL,76,0),(337,0,0,'第312章 杀戮','NovelChapter/76/313_337.txt',NULL,NULL,76,0),(338,0,0,'第313章 二十五级骑士长','NovelChapter/76/314_338.txt',NULL,NULL,76,0),(339,0,0,'第314章 失望','NovelChapter/76/315_339.txt',NULL,NULL,76,0),(340,0,0,'第315章 布置','NovelChapter/76/316_340.txt',NULL,NULL,76,0),(341,0,0,'第316章 出发','NovelChapter/76/317_341.txt',NULL,NULL,76,0),(342,0,0,'第317章 灵语者','NovelChapter/76/318_342.txt',NULL,NULL,76,0),(343,0,0,'第318章 厨艺','NovelChapter/76/319_343.txt',NULL,NULL,76,0),(344,0,0,'第319章 挡路的灵兽','NovelChapter/76/320_344.txt',NULL,NULL,76,0),(345,0,0,'第320章 鬼面毒岩蛛','NovelChapter/76/321_345.txt',NULL,NULL,76,0),(346,0,0,'第321章 冒失的莫莉','NovelChapter/76/322_346.txt',NULL,NULL,76,0),(347,0,0,'第322章 潜入','NovelChapter/76/323_347.txt',NULL,NULL,76,0),(348,0,0,'第323章 刺杀','NovelChapter/76/324_348.txt',NULL,NULL,76,0),(349,0,0,'第324章 得手回转','NovelChapter/76/325_349.txt',NULL,NULL,76,0),(350,0,0,'第325章 追查','NovelChapter/76/326_350.txt',NULL,NULL,76,0),(351,0,0,'第326章 黑火岩蟒','NovelChapter/76/327_351.txt',NULL,NULL,76,0),(352,0,0,'第327章 补偿','NovelChapter/76/328_352.txt',NULL,NULL,76,0),(353,0,0,'第328章 龙兽','NovelChapter/76/329_353.txt',NULL,NULL,76,0),(354,0,0,'第329章 撤退','NovelChapter/76/330_354.txt',NULL,NULL,76,0),(355,0,0,'第330章 消耗','NovelChapter/76/331_355.txt',NULL,NULL,76,0),(356,0,0,'第331章 治疗','NovelChapter/76/332_356.txt',NULL,NULL,76,0),(357,0,0,'第332章 制作法杖','NovelChapter/76/333_357.txt',NULL,NULL,76,0),(358,0,0,'第333章 黑火法杖','NovelChapter/76/334_358.txt',NULL,NULL,76,0),(359,0,0,'第334章 龙吟','NovelChapter/76/335_359.txt',NULL,NULL,76,0),(360,0,0,'第335章 双足飞龙','NovelChapter/76/336_360.txt',NULL,NULL,76,0),(361,0,0,'第336章 灵魂锁链','NovelChapter/76/337_361.txt',NULL,NULL,76,0),(362,0,0,'第337章 白色火焰','NovelChapter/76/338_362.txt',NULL,NULL,76,0),(363,0,0,'第338章 收获','NovelChapter/76/339_363.txt',NULL,NULL,76,0),(364,0,0,'第339章 四级巫师','NovelChapter/76/340_364.txt',NULL,NULL,76,0),(365,0,0,'第340章 战利品','NovelChapter/76/341_365.txt',NULL,NULL,76,0),(366,0,0,'第341章 丰收','NovelChapter/76/342_366.txt',NULL,NULL,76,0),(367,0,0,'第342章 树头木拳','NovelChapter/76/343_367.txt',NULL,NULL,76,0),(368,0,0,'第343章 迪卡·凯恩','NovelChapter/76/344_368.txt',NULL,NULL,76,0),(369,0,0,'第344章 委托','NovelChapter/76/345_369.txt',NULL,NULL,76,0),(370,0,0,'第345章 五级巫师','NovelChapter/76/346_370.txt',NULL,NULL,76,0),(371,0,0,'第346章 回营地','NovelChapter/76/347_371.txt',NULL,NULL,76,0),(372,0,0,'第347章 学习','NovelChapter/76/348_372.txt',NULL,NULL,76,0),(373,0,0,'第348章 龙血的作用','NovelChapter/76/349_373.txt',NULL,NULL,76,0);


DROP TABLE IF EXISTS `novel_chapter_pay`;
CREATE TABLE `novel_chapter_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `novel_chapter_id` int(11) DEFAULT '0',
  `userid` int(11) DEFAULT '0',
  `money` int(11) DEFAULT '0',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `novel_collect`;
CREATE TABLE `novel_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `novelid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

INSERT INTO `novel_collect` VALUES (39,76,0),(40,76,1);


DROP TABLE IF EXISTS `novel_mark`;
CREATE TABLE `novel_mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

#
# Data for table "novel_mark"
#

/*!40000 ALTER TABLE `novel_mark` DISABLE KEYS */;
INSERT INTO `novel_mark` VALUES (3,'奇幻'),(4,'玄幻'),(5,'武侠'),(6,'仙侠'),(7,'都市'),(8,'现实'),(9,'军事'),(10,'历史'),(11,'游戏'),(12,'体育'),(13,'科幻'),(14,'灵异'),(15,'二次元'),(16,'短篇');
/*!40000 ALTER TABLE `novel_mark` ENABLE KEYS */;


DROP TABLE IF EXISTS `novel_mark_body`;
CREATE TABLE `novel_mark_body` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `markid` int(11) DEFAULT '0',
  `novelid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `markid` (`markid`),
  KEY `novelid` (`novelid`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

#
# Data for table "novel_mark_body"
#

/*!40000 ALTER TABLE `novel_mark_body` DISABLE KEYS */;
INSERT INTO `novel_mark_body` VALUES (74,3,76),(75,4,77),(76,11,77),(77,16,77);
/*!40000 ALTER TABLE `novel_mark_body` ENABLE KEYS */;


DROP TABLE IF EXISTS `novel_pay`;
CREATE TABLE `novel_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `novel_id` int(11) DEFAULT '0',
  `userid` int(11) DEFAULT '0',
  `money` int(11) DEFAULT '0',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user`;
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
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `exp` int(11) DEFAULT '0',
  `lasttime` datetime DEFAULT NULL,
  `addip` varchar(255) DEFAULT NULL,
  `lastip` varchar(255) DEFAULT NULL,
  `sid` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='用户表';

#
# Data for table "user"
#

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'youxia','e10adc3949ba59abbe56e057f20f883e','youxia',NULL,'/public/photo/20180403145610_997.png',0,0,0,'2017-09-07 15:14:13',52,NULL,'127.0.0.1',NULL,'16_gK37NYZt2EA7YcaL','675567585@qq.com'),(17,'ABCDE123','e10adc3949ba59abbe56e057f20f883e','ABCDE123',NULL,'/static/images/photo.jpg',0,0,0,'2018-04-03 13:48:44',0,NULL,'127.0.0.1',NULL,'17_UxqE9eBarVokKz2S','5555@qq.cm');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
