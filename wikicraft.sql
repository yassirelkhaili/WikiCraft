-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: wikicraft
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Web developement','Explore the latest in Web Development, covering design, coding, and trends. Stay informed on tools and best practices for creating functional, visually appealing websites and applications that elevate the digital experience.','2024-01-21 12:21:07'),(2,'Data Science','Delve into Data Science, unraveling patterns and extracting insights from complex datasets. Explore machine learning, statistical analysis, and data visualization techniques to make informed decisions and drive innovation.','2024-01-21 12:39:52'),(3,'Mobile Development','Embark on Mobile App Development, crafting seamless digital experiences for iOS and Android. Navigate through app design, coding, and deployment, staying updated on frameworks and trends in the dynamic mobile landscape.','2024-01-21 12:40:10'),(4,'Cloud Computing','Enter the realm of Cloud Computing, where innovations scale effortlessly. Dive into cloud architecture, services, and deployment strategies, navigating a landscape that transforms businesses and accelerates digital growth.','2024-01-21 12:40:59'),(5,'Cybersecurity','Explore Cybersecurity, safeguarding digital frontiers against threats. Dive into the world of ethical hacking, cryptography, and security protocols, ensuring resilient defense mechanisms for the ever-evolving digital landscape.','2024-01-21 12:41:15'),(6,'UI/UX Design','Immerse yourself in UI/UX Design, shaping seamless digital experiences. Explore user-centered design principles, prototyping, and usability testing, creating interfaces that captivate and elevate the overall user journey.','2024-01-21 12:41:41');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tag` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'WebApps'),(2,'PWAs'),(3,'User Experience'),(4,'Mobile Web'),(5,'Offline Web Apps'),(6,'Web Performance'),(7,'Frontend Development'),(8,'Single Codebase'),(9,'Web technologies'),(10,'Machine Learning'),(11,'AI Applications'),(12,'Ethical AI'),(13,'Machine Learning'),(14,'AI Applications'),(15,'Ethical AI'),(16,'tag'),(17,'Machine Learning'),(18,'AI Applications'),(19,'Ethical AI'),(20,'Big Data'),(21,'Machine Learning'),(22,'Data Analysis'),(23,'Data Visualization'),(24,'Predictive Modeling'),(25,'AI');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','author') NOT NULL DEFAULT 'author',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Yassir Elkhaili ','motesyte@mailinator.com','$2y$10$8mbLeXTalZk3fbBYOIfRueGQxoh6ECAgptNYNQjvuAC1eQYGOgAyi','author'),(2,'Tester','admin@gmail.com','$2y$10$hKYbXpASntvyErRbS6Z4wOL.FJZ0pq4I0fSkCnQ.AG5SCyiFeuhmG','admin');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wiki`
--

DROP TABLE IF EXISTS `wiki`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wiki` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `categoryID` int NOT NULL,
  `authorID` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wiki`
--

LOCK TABLES `wiki` WRITE;
/*!40000 ALTER TABLE `wiki` DISABLE KEYS */;
INSERT INTO `wiki` VALUES (1,'Progressive Web Apps (PWAs) - Enhancing User Experience','Progressive Web Apps (PWAs) have emerged as a revolutionary approach to web development, offering a seamless user experience across various devices. These applications combine the best features of web and mobile apps, providing reliability, speed, and engaging interactions.\n\nOverview\n\nPWAs leverage modern web capabilities to deliver an app-like experience directly through the browser. Unlike traditional websites, PWAs are designed to work offline, ensuring users can access content even with a poor or no internet connection. This is achieved through the use of service workers, enabling the caching of key resources.\n\nKey Features\n\nOffline Functionality: One of the standout features of PWAs is their ability to function offline. Users can continue interacting with the app, view cached content, and submit form data even when disconnected from the internet.\n\nResponsive Design: PWAs are built with responsive design principles, adapting seamlessly to different screen sizes and orientations. This ensures a consistent and enjoyable experience for users across devices.\n\nApp-Like Navigation: PWAs mimic the navigation and interaction patterns of native mobile apps. Users can add the PWA to their home screen, launch it without opening a browser, and receive push notifications.\n\nAdvantages for Developers\n\nCross-Browser Compatibility: PWAs are designed to work on all major browsers, reducing the need for extensive browser-specific testing. This simplifies the development process and ensures a wider reach for your application.\n\nEnhanced Performance: By leveraging service workers and efficient caching strategies, PWAs deliver faster load times and smoother interactions. This contributes to a positive user experience and can positively impact search engine rankings.\n\nCost-Effective Development: PWAs streamline the development process by allowing developers to create a single codebase that works across different platforms. This reduces development costs associated with maintaining separate codebases for web and mobile apps.\n\nChallenges and Considerations\n\nWhile PWAs offer numerous benefits, developers must consider challenges such as limited access to certain device features (compared to native apps) and potential security concerns related to service workers. It\'s crucial to carefully weigh the pros and cons when deciding to adopt PWA development.\n\nConclusion\n\nProgressive Web Apps have gained popularity for their ability to bridge the gap between web and mobile applications. As technology continues to evolve, PWAs are expected to play a significant role in shaping the future of web development, providing enhanced user experiences and improved performance.',1,1,'2024-01-21 12:31:15','2024-01-21 12:31:15'),(5,'The Impact of Artificial Intelligence on Modern Society','Content:\nArtificial Intelligence (AI) has rapidly transformed the landscape of modern society, offering innovative solutions and reshaping various aspects of our daily lives. This revolutionary technology mimics human intelligence, enabling machines to learn, adapt, and make decisions.\n\nOverview:\nAI applications span a wide range of fields, from healthcare and finance to education and entertainment. Understanding the underlying principles of AI, such as machine learning and neural networks, is crucial for navigating its influence in today\'s interconnected world.\n\nKey Applications:\nAI is prevalent in predictive analytics, personalized recommendations, and autonomous systems. Explore how machine learning algorithms power virtual assistants, chatbots, and image recognition technologies. Discover the ethical considerations and societal implications associated with the growing influence of AI in decision-making processes.\n\nAdvancements in Healthcare:\nIn the healthcare sector, AI contributes to disease diagnosis, drug discovery, and personalized treatment plans. Learn about the integration of AI-driven technologies in medical imaging, patient care, and health management systems, leading to more efficient and accurate healthcare practices.\n\nAI in Finance:\nIn finance, AI algorithms analyze vast datasets to detect fraudulent activities, optimize trading strategies, and enhance customer experiences. Examine the role of AI in risk management, credit scoring, and algorithmic trading, shaping the financial industry\'s digital transformation.\n\nEducational Impact:\nExplore how AI is revolutionizing education through personalized learning experiences, adaptive tutoring systems, and intelligent educational tools. Delve into the potential of AI to cater to individual learning styles and bridge educational gaps, providing a more inclusive and effective learning environment.\n\nChallenges and Ethical Considerations:\nAs AI continues to evolve, challenges related to privacy, bias in algorithms, and job displacement emerge. Investigate ethical considerations surrounding AI, including transparency, accountability, and the responsible development and deployment of intelligent systems.\n\nConclusion:\nThe impact of AI on modern society is profound and multifaceted. As we navigate the transformative effects of this technology, it\'s crucial to foster discussions, ethical frameworks, and regulations that ensure AI benefits humanity as a whole. As AI research and applications advance, the future promises both unprecedented opportunities and the need for responsible stewardship in harnessing the power of artificial intelligence.',1,1,'2024-01-21 14:23:02','2024-01-21 14:23:02'),(6,'Data Science: Unveiling Insights from Big Data','Data Science has emerged as a powerful discipline that extracts meaningful insights from vast datasets, transforming raw information into actionable knowledge. Dive into the foundational components of data science, from statistical analysis and machine learning to data visualization techniques.\n\nExplore the significance of Big Data in driving decision-making processes across various industries. Understand the principles of data cleaning, preprocessing, and feature engineering that lay the groundwork for robust predictive models. Discover how algorithms such as regression, clustering, and neural networks are employed to uncover patterns and trends within complex datasets.\n\nDelve into the interdisciplinary nature of data science, encompassing domains like computer science, mathematics, and domain-specific expertise. Learn about the ethical considerations surrounding data usage, privacy, and the responsible deployment of artificial intelligence.\n\nExplore real-world applications of data science in healthcare, finance, and marketing, showcasing how data-driven insights enhance decision-making and drive innovation. Stay abreast of emerging trends, tools, and methodologies shaping the continuously evolving field of data science.\n\nAs we navigate the era of information abundance, data science stands as a key enabler, unraveling the potential of data and fostering a data-driven future.',2,1,'2024-01-21 14:26:13','2024-01-21 14:26:13');
/*!40000 ALTER TABLE `wiki` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wiki_tags`
--

DROP TABLE IF EXISTS `wiki_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wiki_tags` (
  `wikiID` int NOT NULL,
  `tagID` int NOT NULL,
  PRIMARY KEY (`wikiID`,`tagID`),
  KEY `tagID` (`tagID`),
  CONSTRAINT `wiki_tags_ibfk_1` FOREIGN KEY (`wikiID`) REFERENCES `wiki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `wiki_tags_ibfk_2` FOREIGN KEY (`tagID`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wiki_tags`
--

LOCK TABLES `wiki_tags` WRITE;
/*!40000 ALTER TABLE `wiki_tags` DISABLE KEYS */;
INSERT INTO `wiki_tags` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(5,17),(5,18),(5,19),(6,20),(6,21),(6,22),(6,23),(6,24),(6,25);
/*!40000 ALTER TABLE `wiki_tags` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-21 22:01:58
