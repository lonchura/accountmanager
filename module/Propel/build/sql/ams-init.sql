-- MySQL dump 10.13  Distrib 5.5.28, for Linux (x86_64)
--
-- Host: localhost    Database: account_manager
-- ------------------------------------------------------
-- Server version	5.5.28-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `user_id` int(4) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_U_1` (`user_id`,`identifier`),
  KEY `account_I_1` (`create_time`),
  KEY `account_I_2` (`update_time`),
  CONSTRAINT `account_FK_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='账号表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (1,1,'常用测试密码','111111','2014-04-09 23:23:13','2014-04-09 23:23:13');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `pid` int(4) DEFAULT NULL,
  `child_count` int(2) NOT NULL,
  `user_id` int(4) NOT NULL,
  `name` varchar(45) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_I_1` (`create_time`),
  KEY `category_I_2` (`update_time`),
  KEY `category_FI_1` (`pid`),
  KEY `category_FI_2` (`user_id`),
  CONSTRAINT `category_FK_1` FOREIGN KEY (`pid`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_FK_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='资源类别表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (-1,NULL,3,1,'分类','2014-04-09 23:26:33','2014-04-09 23:31:39'),(3,-1,1,1,'网站','2014-04-09 23:26:53','2014-04-09 23:27:07'),(4,3,0,1,'ninth.not-bad.org','2014-04-09 23:27:07','2014-04-09 23:27:07'),(5,-1,1,1,'信用卡','2014-04-09 23:28:58','2014-04-09 23:29:09'),(6,5,0,1,'工商','2014-04-09 23:29:09','2014-04-09 23:29:09'),(7,-1,1,1,'项目','2014-04-09 23:31:39','2014-04-09 23:31:50'),(8,7,0,1,'账户管理系统','2014-04-09 23:31:50','2014-04-09 23:31:50');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource`
--

DROP TABLE IF EXISTS `resource`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `category_id` int(4) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`,`category_id`),
  KEY `resource_I_1` (`create_time`),
  KEY `resource_I_2` (`update_time`),
  KEY `resource_FI_1` (`category_id`),
  CONSTRAINT `resource_FK_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='资源表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource`
--

LOCK TABLES `resource` WRITE;
/*!40000 ALTER TABLE `resource` DISABLE KEYS */;
INSERT INTO `resource` VALUES (1,4,'管理员账户','<span style=\"color: rgb(0, 0, 0);\">各种</span><font color=\"#ff0000\">管理员</font>账户','2014-04-09 23:27:41','2014-04-09 23:27:41'),(2,6,'卡号6223************','<font face=\"tahoma, arial, verdana, sans-serif\">卡号6223************</font>','2014-04-09 23:30:38','2014-04-09 23:30:38'),(3,8,'Mysql','<b>Mysql</b><div>IP: <span style=\"white-space:pre\">	</span>127.0.0.1</div><div>Port: <span style=\"white-space:pre\">	</span>3306</div>','2014-04-09 23:32:55','2014-04-09 23:32:55');
/*!40000 ALTER TABLE `resource` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_account`
--

DROP TABLE IF EXISTS `resource_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_account` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `resource_id` int(4) NOT NULL,
  `account_id` int(3) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resource_account_U_1` (`resource_id`,`account_id`,`identity`),
  KEY `resource_account_I_1` (`create_time`),
  KEY `resource_account_I_2` (`update_time`),
  KEY `resource_account_FI_2` (`account_id`),
  CONSTRAINT `resource_account_FK_1` FOREIGN KEY (`resource_id`) REFERENCES `resource` (`id`),
  CONSTRAINT `resource_account_FK_2` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='资源账号关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_account`
--

LOCK TABLES `resource_account` WRITE;
/*!40000 ALTER TABLE `resource_account` DISABLE KEYS */;
INSERT INTO `resource_account` VALUES (1,1,1,'test','2014-04-09 23:27:59','2014-04-09 23:27:59'),(2,1,1,'demo','2014-04-09 23:28:20','2014-04-09 23:28:20'),(3,2,1,'xxx@xxx.com','2014-04-09 23:31:10','2014-04-09 23:31:10'),(4,3,1,'root','2014-04-09 23:33:31','2014-04-09 23:33:31');
/*!40000 ALTER TABLE `resource_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_U_1` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='角色';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (2,'普通用户','2014-04-09 23:10:12','2014-04-09 23:10:12');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `id` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `data` varchar(21000) DEFAULT NULL,
  PRIMARY KEY (`id`,`name`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='session';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `nickname` varchar(25) NOT NULL,
  `role_id` int(3) NOT NULL,
  `password` varchar(60) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_U_1` (`name`),
  KEY `user_FI_1` (`role_id`),
  CONSTRAINT `user_FK_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'demo','测试账户',2,'$2y$09$RmFxM3NJRjN4M1dBMzNNPOdTT9cpYqvTd0ISSbOgQ53GxCB6aysu6','2014-04-09 23:11:55','2014-04-09 23:22:24');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-09 23:39:55
