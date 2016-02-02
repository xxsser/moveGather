CREATE DATABASE `caiji_cswanda`;

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for gether_info
-- ----------------------------
DROP TABLE IF EXISTS `gether_info`;
CREATE TABLE `gether_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `remote_page_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  'part' varchar(255) NOT NULL DEFAULT '',
  `category` VARCHAR(255) NOT NULL DEFAULT '',
  `cover` varchar(255) NOT NULL DEFAULT '',
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `add_time` int(14) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `remote_page_name` (`remote_page_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=638863 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for video_info
-- ----------------------------
DROP TABLE IF EXISTS `video_info`;
CREATE TABLE `video_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vid` int(10) unsigned NOT NULL,
  `frame_url` varchar(255) NOT NULL,
  `add_time` int(15) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19910 DEFAULT CHARSET=utf8;
