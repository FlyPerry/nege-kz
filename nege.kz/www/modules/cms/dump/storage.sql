/*
Navicat MySQL Data Transfer

Source Server         : kenny
Source Server Version : 50167
Source Host           : kenny:3306
Source Database       : agmp

Target Server Type    : MYSQL
Target Server Version : 50167
File Encoding         : 65001

Date: 2013-05-24 16:32:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `storages`
-- ----------------------------
DROP TABLE IF EXISTS `storages`;
CREATE TABLE `storages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `type` varchar(25) DEFAULT NULL,
  `links` int(11) NOT NULL DEFAULT '0' COMMENT 'Колличество ссылок на этот файл из внешних таблиц. Забота об этом счетчики висит на плечах программиста.',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `original_name` varchar(200) DEFAULT NULL,
  `dir` varchar(200) DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `tags` text,
  `is_new` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`,`name`) USING BTREE,
  KEY `key_2` (`key`) USING BTREE,
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Storage';
