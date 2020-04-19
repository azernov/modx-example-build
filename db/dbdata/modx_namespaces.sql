
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*!40000 ALTER TABLE `modx_namespaces` DISABLE KEYS */;
REPLACE INTO `modx_namespaces` VALUES ('core','{core_path}','{assets_path}');
REPLACE INTO `modx_namespaces` VALUES ('formit','{core_path}components/formit/','{assets_path}components/formit/');
REPLACE INTO `modx_namespaces` VALUES ('tinymce','{core_path}components/tinymce/','{assets_path}components/tinymce/');
REPLACE INTO `modx_namespaces` VALUES ('translit','{core_path}components/translit/','');
REPLACE INTO `modx_namespaces` VALUES ('breadcrumb','{core_path}components/breadcrumb/','');
REPLACE INTO `modx_namespaces` VALUES ('codemirror','{core_path}components/codemirror/','');
REPLACE INTO `modx_namespaces` VALUES ('pdotools','{core_path}components/pdotools/','');
REPLACE INTO `modx_namespaces` VALUES ('ajaxform','{core_path}components/ajaxform/','');
/*!40000 ALTER TABLE `modx_namespaces` ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

