-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: College
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.24.04.1

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
-- Table structure for table `cours`
--

DROP TABLE IF EXISTS `cours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cours` (
  `id` int NOT NULL AUTO_INCREMENT,
  `enseignant_id` int NOT NULL,
  `matiere` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `classe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debut` datetime NOT NULL,
  `fin` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FDCA8C9CE455FCC0` (`enseignant_id`),
  CONSTRAINT `FK_FDCA8C9CE455FCC0` FOREIGN KEY (`enseignant_id`) REFERENCES `utilisateur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cours`
--

LOCK TABLES `cours` WRITE;
/*!40000 ALTER TABLE `cours` DISABLE KEYS */;
/*!40000 ALTER TABLE `cours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20250323102154','2025-03-29 13:27:40',56),('DoctrineMigrations\\Version20250323125907','2025-03-29 13:27:40',34),('DoctrineMigrations\\Version20250325150838','2025-03-29 13:27:40',22),('DoctrineMigrations\\Version20250327200240','2025-03-29 13:27:40',37),('DoctrineMigrations\\Version20250328101717','2025-03-30 17:16:14',89),('DoctrineMigrations\\Version20250328230820','2025-03-29 13:27:40',174),('DoctrineMigrations\\Version20250329132838','2025-03-29 13:28:55',50),('DoctrineMigrations\\Version20250329141521','2025-03-29 14:15:39',43),('DoctrineMigrations\\Version20250329203830','2025-03-29 20:38:49',25),('DoctrineMigrations\\Version20250329222132','2025-03-29 22:21:49',143),('DoctrineMigrations\\Version20250330182628','2025-04-01 18:34:23',90),('DoctrineMigrations\\Version20250330231849','2025-04-01 18:34:23',57),('DoctrineMigrations\\Version20250331132510','2025-04-01 18:34:23',18),('DoctrineMigrations\\Version20250331143529','2025-04-01 18:34:23',36),('DoctrineMigrations\\Version20250331204947','2025-04-01 18:34:23',117),('DoctrineMigrations\\Version20250401072933','2025-04-01 07:29:43',25),('DoctrineMigrations\\Version20250401092822','2025-04-01 09:28:35',77),('DoctrineMigrations\\Version20250401153308','2025-04-01 18:34:23',328);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imprimante`
--

DROP TABLE IF EXISTS `imprimante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imprimante` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identifiant_unique` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modele` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `niveau_batterie` int DEFAULT NULL,
  `niveau_encre` int DEFAULT NULL,
  `derniere_interaction` datetime DEFAULT NULL,
  `salle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4DF2C3AA545B2B13` (`identifiant_unique`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imprimante`
--

LOCK TABLES `imprimante` WRITE;
/*!40000 ALTER TABLE `imprimante` DISABLE KEYS */;
INSERT INTO `imprimante` VALUES (2,'t','a','t','Fonctionnel',4,2,NULL,'f');
/*!40000 ALTER TABLE `imprimante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livre`
--

DROP TABLE IF EXISTS `livre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `livre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_auteur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_auteur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_publication` date NOT NULL,
  `genre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disponible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livre`
--

LOCK TABLES `livre` WRITE;
/*!40000 ALTER TABLE `livre` DISABLE KEYS */;
INSERT INTO `livre` VALUES (3,'b','b','b','0222-02-22','Science-fiction',0),(4,'bbbbbbb','c','c','2002-02-02','Science-fiction',1),(6,'d','d','d','1111-11-18','Essai',1),(7,'f','f','f','2222-02-22','Policier',1);
/*!40000 ALTER TABLE `livre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `entree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dessert` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordinateur`
--

DROP TABLE IF EXISTS `ordinateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordinateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_serie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `localisation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_achat` date DEFAULT NULL,
  `derniere_maintenance` date DEFAULT NULL,
  `est_en_service` tinyint(1) NOT NULL,
  `niveau_batterie` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8712E8DB565B809` (`numero_serie`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordinateur`
--

LOCK TABLES `ordinateur` WRITE;
/*!40000 ALTER TABLE `ordinateur` DISABLE KEYS */;
INSERT INTO `ordinateur` VALUES (7,'aa','aa','FEFEZVZEVZ55','Disponible','dd','1111-11-18','1111-11-18',1,NULL),(10,'f','f','KJNFEFQC','Indisponible','f','2222-02-22',NULL,1,NULL);
/*!40000 ALTER TABLE `ordinateur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_42C84955A76ED395` (`user_id`),
  CONSTRAINT `FK_42C84955A76ED395` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_livre`
--

DROP TABLE IF EXISTS `reservation_livre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation_livre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `livre_id` int NOT NULL,
  `date_emprunt` date NOT NULL,
  `date_retour` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EF1C9F3EFB88E14F` (`utilisateur_id`),
  KEY `IDX_EF1C9F3E37D925CB` (`livre_id`),
  CONSTRAINT `FK_EF1C9F3E37D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`),
  CONSTRAINT `FK_EF1C9F3EFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_livre`
--

LOCK TABLES `reservation_livre` WRITE;
/*!40000 ALTER TABLE `reservation_livre` DISABLE KEYS */;
INSERT INTO `reservation_livre` VALUES (11,2,3,'2025-04-01','2025-04-02');
/*!40000 ALTER TABLE `reservation_livre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_ordinateur`
--

DROP TABLE IF EXISTS `reservation_ordinateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation_ordinateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ordinateur_id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `date_reservation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E7B8216F828317CA` (`ordinateur_id`),
  KEY `IDX_E7B8216FFB88E14F` (`utilisateur_id`),
  CONSTRAINT `FK_E7B8216F828317CA` FOREIGN KEY (`ordinateur_id`) REFERENCES `ordinateur` (`id`),
  CONSTRAINT `FK_E7B8216FFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_ordinateur`
--

LOCK TABLES `reservation_ordinateur` WRITE;
/*!40000 ALTER TABLE `reservation_ordinateur` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation_ordinateur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_trottinette`
--

DROP TABLE IF EXISTS `reservation_trottinette`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation_trottinette` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trottinette_id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `date_reservation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_88394465F6798F43` (`trottinette_id`),
  KEY `IDX_88394465FB88E14F` (`utilisateur_id`),
  CONSTRAINT `FK_88394465F6798F43` FOREIGN KEY (`trottinette_id`) REFERENCES `trottinette` (`id`),
  CONSTRAINT `FK_88394465FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_trottinette`
--

LOCK TABLES `reservation_trottinette` WRITE;
/*!40000 ALTER TABLE `reservation_trottinette` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation_trottinette` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_velo`
--

DROP TABLE IF EXISTS `reservation_velo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation_velo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `velo_id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `date_reservation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2370BC9DEC6AC5BD` (`velo_id`),
  KEY `IDX_2370BC9DFB88E14F` (`utilisateur_id`),
  CONSTRAINT `FK_2370BC9DEC6AC5BD` FOREIGN KEY (`velo_id`) REFERENCES `velo` (`id`),
  CONSTRAINT `FK_2370BC9DFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_velo`
--

LOCK TABLES `reservation_velo` WRITE;
/*!40000 ALTER TABLE `reservation_velo` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation_velo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thermostat`
--

DROP TABLE IF EXISTS `thermostat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `thermostat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identifiant_unique` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `temperature_actuelle` double DEFAULT NULL,
  `temperature_cible` double DEFAULT NULL,
  `mode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `connectivite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `niveau_batterie` int DEFAULT NULL,
  `derniere_interaction` datetime DEFAULT NULL,
  `salle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B69BDDD0545B2B13` (`identifiant_unique`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thermostat`
--

LOCK TABLES `thermostat` WRITE;
/*!40000 ALTER TABLE `thermostat` DISABLE KEYS */;
INSERT INTO `thermostat` VALUES (2,'v','v',85,56,'Chauffage','Ethernet',74,NULL,'v');
/*!40000 ALTER TABLE `thermostat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trottinette`
--

DROP TABLE IF EXISTS `trottinette`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trottinette` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identifiant_unique` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveau_batterie` int DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `derniere_interaction` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_44559939545B2B13` (`identifiant_unique`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trottinette`
--

LOCK TABLES `trottinette` WRITE;
/*!40000 ALTER TABLE `trottinette` DISABLE KEYS */;
INSERT INTO `trottinette` VALUES (1,'a','a','a',44,'En maintenance','4444-04-04 00:00:00');
/*!40000 ALTER TABLE `trottinette` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_cours`
--

DROP TABLE IF EXISTS `user_cours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_cours` (
  `utilisateur_id` int NOT NULL,
  `cours_id` int NOT NULL,
  PRIMARY KEY (`utilisateur_id`,`cours_id`),
  KEY `IDX_1F0877C4FB88E14F` (`utilisateur_id`),
  KEY `IDX_1F0877C47ECF78B0` (`cours_id`),
  CONSTRAINT `FK_1F0877C47ECF78B0` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_1F0877C4FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_cours`
--

LOCK TABLES `user_cours` WRITE;
/*!40000 ALTER TABLE `user_cours` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_cours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int NOT NULL,
  `sexe` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `niveau` int NOT NULL,
  `points` int NOT NULL,
  `valide` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `classe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matiere` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES (2,'test@test.com','[]','$2y$13$Gw2ND9u1iPAPVX17YY2wEupBbxzvw6B4w3ZYB83.h3rMLNE2ytmry','c','a',1,'Homme','Administration',NULL,3,1,'Oui',NULL,NULL),(4,'a@gmail.com','[]','$2y$13$opQr8x6A5Szxaj4vBT.Sye8r3Rye7B9EMtV5/DbH7tw8l.QIIM5Lm','a','a',2,'Homme','Enseignant',NULL,3,50,'Oui',NULL,NULL),(5,'b@gmail.com','[]','$2y$13$7tD2CQtG.33r./61ITPMVeKtoxqy8KtvfQzyJwlyqLNsgQVjXT.8e','b','b',3,'Homme','Eleve',NULL,1,0,'non',NULL,NULL);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `velo`
--

DROP TABLE IF EXISTS `velo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `velo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identifiant_unique` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveau_batterie` int DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `derniere_interaction` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_354971F5545B2B13` (`identifiant_unique`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `velo`
--

LOCK TABLES `velo` WRITE;
/*!40000 ALTER TABLE `velo` DISABLE KEYS */;
INSERT INTO `velo` VALUES (2,'a','a','a',84,'Disponible','2020-01-23 00:00:00');
/*!40000 ALTER TABLE `velo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-02 10:55:04
