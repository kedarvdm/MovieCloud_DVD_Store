CREATE DATABASE  IF NOT EXISTS `dvdshop_schema` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dvdshop_schema`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: dvdshop_schema
-- ------------------------------------------------------
-- Server version	5.6.21

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `hMy` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(45) NOT NULL,
  PRIMARY KEY (`hMy`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Action'),(2,'Animation'),(3,'Crime'),(4,'Drama'),(5,'Horror'),(6,'Romance'),(7,'Sci-Fi'),(8,'War');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `hMy` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(45) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `address1` varchar(45) DEFAULT NULL,
  `address2` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `zipCode` varchar(10) DEFAULT NULL,
  `birthdate` varchar(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `cellphone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`hMy`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'Kedar','Deshmukh','75 saint alphonsus street','','Boston','Massachussets','United States','02120','1989-11-13 00:00:00','kvdeshmukh1989@gmail.com','6173730168'),(2,'Saurabh','Rao','Apt 0209, 75 Saint Alphonsus Street,','','Boston','Massachusetts','United States','02120','30/11/2014','saurabhrao.007@rediffmail.com','6173730168'),(3,'Abhijeet','Patil','Apt 0209, 75 Saint Alphonsus Street,','','Boston','Massachusetts','United States','02120','02/12/2014','saurabhrao.007@rediffmail.com','6173730168'),(14,'Kedar','Deshmukh','Apt 0209, 75 Saint Alphonsus Street,','','Boston','Massachusetts','United States','02120','13/11/1989','kvdeshmukh1989@gmail.com','6173730168'),(15,'Hardik','Bhatia','Apt 0209, 75 Saint Alphonsus Street,','','Boston','Massachusetts','United States','02120','06/09/1989','saurabhrao.007@rediffmail.com','6173730168');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dvdinfo`
--

DROP TABLE IF EXISTS `dvdinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvdinfo` (
  `hMy` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `cast` varchar(45) DEFAULT NULL,
  `intro` varchar(45) DEFAULT NULL,
  `hCategory` int(11) DEFAULT NULL,
  `releasedate` varchar(45) DEFAULT NULL,
  `imagepath` varchar(45) DEFAULT NULL,
  `price` decimal(18,2) DEFAULT NULL,
  `dateCreated` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`hMy`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvdinfo`
--

LOCK TABLES `dvdinfo` WRITE;
/*!40000 ALTER TABLE `dvdinfo` DISABLE KEYS */;
INSERT INTO `dvdinfo` VALUES (1,'Avengers','RDJ, Chris Evans','It Avengers.',1,'13/11/2009','the avengers.jpg',6.99,'2014-12-09'),(2,'Spiderman','Andrew Garfield','Spidy is back',1,'01/12/2014','Amazing SpiderMan.jpg',5.99,'2014-12-09'),(3,'Snitch','The Rock','Rock',1,'23/12/2014','Snitch.jpg',5.99,'2014-12-09'),(4,'Ironman','RDJ','Tony Stark',1,'13/11/2009','ironman1.jpg',6.99,'2014-12-09'),(5,'Fury','Bradd Pitt','War',8,'12/05/2014','fury.jpg',7.99,'2014-12-09');
/*!40000 ALTER TABLE `dvdinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dvdinventory`
--

DROP TABLE IF EXISTS `dvdinventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvdinventory` (
  `hMy` int(11) NOT NULL AUTO_INCREMENT,
  `hDvdInfo` int(11) NOT NULL,
  `availability` int(11) NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`hMy`),
  KEY `hDvdInfo_idx` (`hDvdInfo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvdinventory`
--

LOCK TABLES `dvdinventory` WRITE;
/*!40000 ALTER TABLE `dvdinventory` DISABLE KEYS */;
INSERT INTO `dvdinventory` VALUES (1,1,40,'2014-12-09 00:00:00'),(2,2,16,'2014-12-09 00:00:00'),(3,3,23,'2014-12-09 00:00:00'),(4,4,59,'2014-12-09 00:00:00'),(5,5,24,'2014-12-09 00:00:00');
/*!40000 ALTER TABLE `dvdinventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderitems`
--

DROP TABLE IF EXISTS `orderitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderitems` (
  `hMy` int(11) NOT NULL AUTO_INCREMENT,
  `hOrder` int(11) DEFAULT NULL,
  `hDvd` int(11) DEFAULT NULL,
  `itemprice` decimal(18,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `totalprice` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`hMy`),
  KEY `hOrder_idx` (`hOrder`),
  KEY `hDvd_idx` (`hDvd`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderitems`
--

LOCK TABLES `orderitems` WRITE;
/*!40000 ALTER TABLE `orderitems` DISABLE KEYS */;
INSERT INTO `orderitems` VALUES (1,1,1,6.99,NULL,NULL),(2,1,2,5.99,NULL,NULL),(3,2,3,5.99,NULL,NULL),(4,3,4,6.99,NULL,NULL),(5,3,3,5.99,NULL,NULL),(6,3,5,7.99,NULL,NULL),(7,4,2,5.99,NULL,NULL),(8,5,2,5.99,NULL,NULL),(9,6,1,6.99,NULL,NULL),(10,7,1,6.99,NULL,NULL);
/*!40000 ALTER TABLE `orderitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `hMy` int(11) NOT NULL AUTO_INCREMENT,
  `hCustomer` int(11) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `ordertotal` decimal(18,2) DEFAULT NULL,
  `orderstatus` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`hMy`),
  KEY `hCustomer_idx` (`hCustomer`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,5,'2014-12-10 00:00:00',12.98,'Shipped'),(2,5,'2014-12-10 00:00:00',5.99,NULL),(3,5,'2014-12-10 00:00:00',20.97,NULL),(4,5,'2014-12-10 00:00:00',5.99,NULL),(5,5,'2014-12-10 00:00:00',5.99,NULL),(6,5,'2014-12-10 00:00:00',6.99,NULL),(7,6,'2014-12-10 00:00:00',6.99,NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `useraccount`
--

DROP TABLE IF EXISTS `useraccount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `useraccount` (
  `hMy` int(11) NOT NULL AUTO_INCREMENT,
  `hCustomer` int(11) NOT NULL,
  `userName` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  PRIMARY KEY (`hMy`),
  KEY `hMy_idx` (`hCustomer`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `useraccount`
--

LOCK TABLES `useraccount` WRITE;
/*!40000 ALTER TABLE `useraccount` DISABLE KEYS */;
INSERT INTO `useraccount` VALUES (1,1,'admin','admin'),(2,2,'srbh','srbh'),(3,3,'abpatil','abpatil'),(5,14,'kedarvdm','Tracer123'),(6,15,'hardik','hardik');
/*!40000 ALTER TABLE `useraccount` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-10 10:54:39
