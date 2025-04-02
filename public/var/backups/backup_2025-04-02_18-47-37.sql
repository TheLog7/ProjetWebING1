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
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20250323102154','2025-03-25 16:07:12',60),('DoctrineMigrations\\Version20250323125907','2025-03-25 16:07:12',40),('DoctrineMigrations\\Version20250325150838','2025-03-30 20:37:59',22),('DoctrineMigrations\\Version20250327200240','2025-03-30 20:38:00',17),('DoctrineMigrations\\Version20250328101717','2025-03-30 20:38:00',104),('DoctrineMigrations\\Version20250328230820','2025-03-30 20:38:00',187),('DoctrineMigrations\\Version20250329132838','2025-03-30 20:38:00',40),('DoctrineMigrations\\Version20250329141521','2025-03-30 20:38:00',43),('DoctrineMigrations\\Version20250329203830','2025-03-30 20:38:00',28),('DoctrineMigrations\\Version20250329222132','2025-03-30 20:38:00',174),('DoctrineMigrations\\Version20250330182628','2025-04-02 15:28:42',119),('DoctrineMigrations\\Version20250330231849','2025-04-02 15:28:43',80),('DoctrineMigrations\\Version20250331132510','2025-04-02 15:28:43',25),('DoctrineMigrations\\Version20250331133313','2025-04-02 15:28:43',184),('DoctrineMigrations\\Version20250331143529','2025-04-02 15:28:43',48),('DoctrineMigrations\\Version20250331204947','2025-04-02 15:28:43',167),('DoctrineMigrations\\Version20250401072933','2025-04-02 15:28:43',32),('DoctrineMigrations\\Version20250401092822','2025-04-02 15:28:43',74),('DoctrineMigrations\\Version20250401153308','2025-04-02 15:28:43',505);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imprimante`
--

LOCK TABLES `imprimante` WRITE;
/*!40000 ALTER TABLE `imprimante` DISABLE KEYS */;
/*!40000 ALTER TABLE `imprimante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jeux`
--

DROP TABLE IF EXISTS `jeux`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jeux` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_places` int NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jeux`
--

LOCK TABLES `jeux` WRITE;
/*!40000 ALTER TABLE `jeux` DISABLE KEYS */;
/*!40000 ALTER TABLE `jeux` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livre`
--

LOCK TABLES `livre` WRITE;
/*!40000 ALTER TABLE `livre` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordinateur`
--

LOCK TABLES `ordinateur` WRITE;
/*!40000 ALTER TABLE `ordinateur` DISABLE KEYS */;
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
-- Table structure for table `reservation_jeux`
--

DROP TABLE IF EXISTS `reservation_jeux`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation_jeux` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `jeux_id` int NOT NULL,
  `start_time` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  `nb_joueurs` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_216C7865FB88E14F` (`utilisateur_id`),
  KEY `IDX_216C7865EC2AA9D2` (`jeux_id`),
  CONSTRAINT `FK_216C7865EC2AA9D2` FOREIGN KEY (`jeux_id`) REFERENCES `jeux` (`id`),
  CONSTRAINT `FK_216C7865FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_jeux`
--

LOCK TABLES `reservation_jeux` WRITE;
/*!40000 ALTER TABLE `reservation_jeux` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation_jeux` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_livre`
--

LOCK TABLES `reservation_livre` WRITE;
/*!40000 ALTER TABLE `reservation_livre` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thermostat`
--

LOCK TABLES `thermostat` WRITE;
/*!40000 ALTER TABLE `thermostat` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trottinette`
--

LOCK TABLES `trottinette` WRITE;
/*!40000 ALTER TABLE `trottinette` DISABLE KEYS */;
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
  `classe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matiere` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valide` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES (1,'ghilasbougdal05@gmail.com','[]','$2y$13$Q.VXGW8BPLKi/MSiHv8jeOGU78GZHMDpNYSbuYbpBAO5cNWtDRWEa','bougdal','ghilas',20,'Homme','Utilisateur','67e2d55e3ff02.jpg',0,0,NULL,NULL,'0'),(2,'azerty@gmail.com','[]','$2y$13$8CRSgvUBfxs9qIGlgzGRROwaSTpQWvJYjeoZHBBrhmjxHxLtVzYO6','Azerty','uiop',25,'Homme','Administrateur','67e2e22384679.jpg',0,0,NULL,NULL,'0'),(3,'ghilasdz16@gmail.com','[]','$2y$13$trV8aJ9mrxDNWGBE8eN4zeagTbsML99OOrF9kOsSpL2.nrs04DKiy','Bougdal','Ghilas',20,'Homme','Eleve','67ea554e669b3.jpg',1,0,NULL,NULL,'0'),(4,'admin@gmail.com','[]','$2y$13$XHGiQCwLXEx3LNNa3BrUtOIu0kF0tMDW9ifPTullv0UVeVLnf2DmO','ad','min',20,'Homme','Administration','67ed49a8701ce.jpg',1,0,NULL,NULL,'0'),(5,'admin123@gmail.com','[]','$2y$13$AaKJAWISR8isQxUyL/q7meFBHm5Yu.Pk9QTFAejaFCrP206a3fMzG','admins','sdsd',20,'Homme','Administration','67ed612ddeee6.jpg',3,0,NULL,NULL,'non');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `velo`
--

LOCK TABLES `velo` WRITE;
/*!40000 ALTER TABLE `velo` DISABLE KEYS */;
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

-- Dump completed on 2025-04-02 20:47:37
