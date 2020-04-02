/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `modx_ms2_resource_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modx_ms2_resource_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `resource_id` int(10) unsigned NOT NULL,
  `source` int(10) unsigned DEFAULT '1',
  `parent` int(10) unsigned DEFAULT '0',
  `name` varchar(255) DEFAULT '',
  `alt` varchar(255) DEFAULT '',
  `description` text,
  `add` text,
  `path` varchar(255) DEFAULT '',
  `file` varchar(255) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `createdon` datetime DEFAULT '0000-00-00 00:00:00',
  `createdby` int(10) unsigned DEFAULT '0',
  `rank` smallint(3) unsigned DEFAULT '0',
  `url` varchar(255) DEFAULT '',
  `properties` text,
  `hash` char(40) DEFAULT '',
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `resource_id` (`resource_id`),
  KEY `type` (`type`),
  KEY `parent` (`parent`),
  KEY `hash` (`hash`),
  KEY `active` (`active`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

