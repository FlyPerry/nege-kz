<?php
DB::query(Database::INSERT,'DROP TABLE IF EXISTS `pages`;')
    ->execute();
DB::query(Database::INSERT,"
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title_ru` varchar(600) NOT NULL,
  `title_kz` varchar(600) DEFAULT NULL,
  `title_en` varchar(600) DEFAULT NULL,
  `link` varchar(500) DEFAULT NULL,
  `description_ru` mediumtext,
  `description_kz` mediumtext,
  `description_en` mediumtext,
  `sef` varchar(700) DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `position` int(11) DEFAULT '0',
  `updated` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


")->execute();
