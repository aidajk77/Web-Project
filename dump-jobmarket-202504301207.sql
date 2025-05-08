-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: jobmarket
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applications` (
  `application_id` int NOT NULL AUTO_INCREMENT,
  `job_id` int NOT NULL,
  `user_id` int NOT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `status` enum('submitted','reviewed','rejected') NOT NULL,
  `date_applied` date NOT NULL,
  PRIMARY KEY (`application_id`),
  KEY `job_id` (`job_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`),
  CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applications`
--

LOCK TABLES `applications` WRITE;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
INSERT INTO `applications` VALUES (1,1,1,'resume_john.pdf','submitted','2025-03-16'),(2,2,2,'resume_jane.pdf','reviewed','2025-03-22'),(3,3,1,'resume_john.pdf','rejected','2025-04-02');
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `company_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `description` text,
  `website` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'TechCorp','New York, NY','Leading tech company','https://techcorp.example.com','techcorp.png','hr@techcorp.com'),(2,'MarketMasters','San Francisco, CA','Top marketing agency','https://marketmasters.example.com','marketmasters.png','contact@marketmasters.com');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobcategories`
--

DROP TABLE IF EXISTS `jobcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobcategories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobcategories`
--

LOCK TABLES `jobcategories` WRITE;
/*!40000 ALTER TABLE `jobcategories` DISABLE KEYS */;
INSERT INTO `jobcategories` VALUES (1,'Software Engineering'),(2,'Design'),(3,'Marketing'),(4,'Data Science');
/*!40000 ALTER TABLE `jobcategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobcategorymapping`
--

DROP TABLE IF EXISTS `jobcategorymapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobcategorymapping` (
  `job_category_id` int NOT NULL AUTO_INCREMENT,
  `job_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`job_category_id`),
  KEY `job_id` (`job_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `jobcategorymapping_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`),
  CONSTRAINT `jobcategorymapping_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `jobcategories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobcategorymapping`
--

LOCK TABLES `jobcategorymapping` WRITE;
/*!40000 ALTER TABLE `jobcategorymapping` DISABLE KEYS */;
INSERT INTO `jobcategorymapping` VALUES (1,1,1),(2,2,2),(3,3,3),(4,4,4),(5,4,1);
/*!40000 ALTER TABLE `jobcategorymapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `job_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `salary_range` varchar(50) DEFAULT NULL,
  `job_type` enum('full-time','part-time','freelance') NOT NULL,
  `company_id` int NOT NULL,
  `date_posted` date NOT NULL,
  `deadline` date DEFAULT NULL,
  `status` enum('open','closed','expired') NOT NULL DEFAULT 'open',
  PRIMARY KEY (`job_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1,'Frontend Developer','Build modern interfaces using React.','Sarajevo','1000-1500','full-time',1,'2025-04-01','2025-05-01','open'),(2,'Backend Developer','Develop REST APIs with Node.js.','Mostar','1200-1700','full-time',2,'2025-03-28','2025-04-30','open'),(3,'Graphic Designer','Design banners and visuals.','Tuzla','800-1100','part-time',3,'2025-04-02','2025-05-15','open'),(4,'Data Analyst','Analyze large datasets and produce reports.','Banja Luka','1300-1800','freelance',1,'2025-03-20','2025-04-20','closed'),(5,'Marketing Manager','Lead the digital marketing strategy.','Zenica','1400-1900','full-time',2,'2025-04-01','2025-04-25','open');
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `savedjobs`
--

DROP TABLE IF EXISTS `savedjobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `savedjobs` (
  `saved_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `job_id` int NOT NULL,
  `date_saved` date NOT NULL,
  PRIMARY KEY (`saved_id`),
  KEY `user_id` (`user_id`),
  KEY `job_id` (`job_id`),
  CONSTRAINT `savedjobs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `savedjobs_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `savedjobs`
--

LOCK TABLES `savedjobs` WRITE;
/*!40000 ALTER TABLE `savedjobs` DISABLE KEYS */;
INSERT INTO `savedjobs` VALUES (1,2,1,'2025-03-18'),(2,1,2,'2025-03-21'),(3,2,3,'2025-04-03');
/*!40000 ALTER TABLE `savedjobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `role` enum('job seeker','employer') NOT NULL,
  `date_joined` date NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `users_companies_FK` (`company_id`),
  CONSTRAINT `users_companies_FK` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'John Doe','john.doe@example.com','password123','555-1234','job seeker','2025-01-10','john.png',NULL),(2,'Jane Smith','jane.smith@example.com','securepass!','555-5678','job seeker','2025-02-05','jane.png',NULL),(3,'Alice Johnson','alice.j@techcorp.com','recruiter1','555-0001','employer','2025-01-15','alice.png',1),(4,'Bob Brown','bob.b@marketmasters.com','recruiter2','555-0002','employer','2025-02-01','bob.png',2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'jobmarket'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-30 12:07:33
