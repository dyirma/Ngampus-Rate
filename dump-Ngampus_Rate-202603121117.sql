-- MySQL dump 10.13  Distrib 9.4.0, for macos15.4 (arm64)
--
-- Host: localhost    Database: Ngampus_Rate
-- ------------------------------------------------------
-- Server version	9.4.0

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-indah123@gmail.com|127.0.0.1','i:2;',1770351968),('laravel-cache-indah123@gmail.com|127.0.0.1:timer','i:1770351968;',1770351968);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Dosen','dosen','Penilaian kinerja dosen oleh mahasiswa.','2026-02-06 04:20:16','2026-02-06 04:36:30'),(2,'Siakad','siakad','Sistem Siakad (Sistem Informasi Akademik) Universitas Sugeng Hartono','2026-02-06 04:23:55','2026-02-06 04:36:14'),(3,'Staff Kampus','staff-kampus','Penilaian Staff Kampus Universitas Sugeng Hartono','2026-02-06 04:34:42','2026-02-06 04:36:24');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dosens`
--

DROP TABLE IF EXISTS `dosens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dosens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dosens_nip_unique` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dosens`
--

LOCK TABLES `dosens` WRITE;
/*!40000 ALTER TABLE `dosens` DISABLE KEYS */;
INSERT INTO `dosens` VALUES (1,'Dr. Anita Suryani, M.Kom','19790101 200501 2 001','2026-02-06 04:20:16','2026-02-06 04:20:16'),(2,'Drs. Bagus Prasetyo, M.M','19780312 200412 1 002','2026-02-06 04:20:16','2026-02-06 04:20:16'),(3,'Ir. Citra Wahyuni, M.T','19810621 200703 2 003','2026-02-06 04:20:16','2026-02-06 04:20:16'),(4,'Rini Lestari, S.H., M.H','19850618 200901 2 004','2026-02-06 04:20:16','2026-02-06 04:20:16'),(5,'Dr. Teguh Santoso, M.Si','19791202 200612 1 005','2026-02-06 04:20:16','2026-02-06 04:20:16'),(6,'Dr. Dwi Pertiwi, M.Keb','19821130 200803 2 006','2026-02-06 04:20:16','2026-02-06 04:20:16');
/*!40000 ALTER TABLE `dosens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jawabans`
--

DROP TABLE IF EXISTS `jawabans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jawabans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `question_id` bigint unsigned NOT NULL,
  `dosen_id` bigint unsigned DEFAULT NULL,
  `nilai_jawaban` int DEFAULT NULL,
  `teks_jawaban` text COLLATE utf8mb4_unicode_ci,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_responden` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program_studi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `angkatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jawabans_user_id_foreign` (`user_id`),
  KEY `jawabans_question_id_foreign` (`question_id`),
  KEY `jawabans_dosen_id_foreign` (`dosen_id`),
  CONSTRAINT `jawabans_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `dosens` (`id`) ON DELETE SET NULL,
  CONSTRAINT `jawabans_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jawabans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jawabans`
--

LOCK TABLES `jawabans` WRITE;
/*!40000 ALTER TABLE `jawabans` DISABLE KEYS */;
INSERT INTO `jawabans` VALUES (1,1,1,3,5,'','Perempuan','mahasiswa','S1 Teknik Informatika','2022','2026-02-06 04:22:30','2026-02-06 04:22:30'),(2,1,2,3,4,'','Perempuan','mahasiswa','S1 Teknik Informatika','2022','2026-02-06 04:22:30','2026-02-06 04:22:30'),(3,1,3,3,5,'','Perempuan','mahasiswa','S1 Teknik Informatika','2022','2026-02-06 04:22:30','2026-02-06 04:22:30'),(4,1,4,3,4,'','Perempuan','mahasiswa','S1 Teknik Informatika','2022','2026-02-06 04:22:30','2026-02-06 04:22:30'),(5,1,5,3,5,'','Perempuan','mahasiswa','S1 Teknik Informatika','2022','2026-02-06 04:22:30','2026-02-06 04:22:30'),(6,1,6,3,5,'','Perempuan','mahasiswa','S1 Teknik Informatika','2022','2026-02-06 04:22:30','2026-02-06 04:22:30'),(7,1,7,3,5,'','Perempuan','mahasiswa','S1 Teknik Informatika','2022','2026-02-06 04:22:30','2026-02-06 04:22:30'),(8,1,8,3,5,'','Perempuan','mahasiswa','S1 Teknik Informatika','2022','2026-02-06 04:22:30','2026-02-06 04:22:30'),(9,1,9,3,5,'','Perempuan','mahasiswa','S1 Teknik Informatika','2022','2026-02-06 04:22:30','2026-02-06 04:22:30'),(10,1,10,3,5,'','Perempuan','mahasiswa','S1 Teknik Informatika','2022','2026-02-06 04:22:30','2026-02-06 04:22:30'),(11,2,20,NULL,5,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:02:58','2026-02-06 07:02:58'),(12,2,21,NULL,5,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:02:58','2026-02-06 07:02:58'),(13,2,22,NULL,5,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:02:58','2026-02-06 07:02:58'),(14,2,23,NULL,5,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:02:58','2026-02-06 07:02:58'),(15,2,24,NULL,5,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:02:58','2026-02-06 07:02:58'),(16,2,1,1,5,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:56:31','2026-02-06 07:56:31'),(17,2,2,1,4,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:56:31','2026-02-06 07:56:31'),(18,2,3,1,3,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:56:31','2026-02-06 07:56:31'),(19,2,4,1,2,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:56:31','2026-02-06 07:56:31'),(20,2,5,1,1,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:56:31','2026-02-06 07:56:31'),(21,2,6,1,1,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:56:31','2026-02-06 07:56:31'),(22,2,7,1,2,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:56:31','2026-02-06 07:56:31'),(23,2,8,1,3,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:56:31','2026-02-06 07:56:31'),(24,2,9,1,4,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:56:31','2026-02-06 07:56:31'),(25,2,10,1,5,'','Laki-laki','staf','S1 Teknik Informatika','2005','2026-02-06 07:56:31','2026-02-06 07:56:31');
/*!40000 ALTER TABLE `jawabans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kuisioners`
--

DROP TABLE IF EXISTS `kuisioners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kuisioners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint unsigned DEFAULT NULL,
  `nama_kuisioner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kuisioners_parent_id_foreign` (`parent_id`),
  CONSTRAINT `kuisioners_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `kuisioners` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kuisioners`
--

LOCK TABLES `kuisioners` WRITE;
/*!40000 ALTER TABLE `kuisioners` DISABLE KEYS */;
/*!40000 ALTER TABLE `kuisioners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_11_24_173739_create_dosens_table',1),(5,'2025_11_24_173744_create_kuisioners_table',1),(6,'2025_11_24_173750_create_pertanyaans_table',1),(7,'2026_01_08_041929_add_parent_id_to_kuisioners_table',1),(8,'2026_01_09_031951_create_categories_table',1),(9,'2026_01_09_032027_create_sub_categories_table',1),(10,'2026_01_09_032051_create_questions_table',1),(11,'2026_01_09_042744_recreate_jawabans_table',1),(12,'2026_01_16_112358_add_profile_fields_to_users_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pertanyaans`
--

DROP TABLE IF EXISTS `pertanyaans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pertanyaans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kuisioner_id` bigint unsigned NOT NULL,
  `teks_pertanyaan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_jawaban` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'likert',
  `opsi_dropdown` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pertanyaans_kuisioner_id_foreign` (`kuisioner_id`),
  CONSTRAINT `pertanyaans_kuisioner_id_foreign` FOREIGN KEY (`kuisioner_id`) REFERENCES `kuisioners` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pertanyaans`
--

LOCK TABLES `pertanyaans` WRITE;
/*!40000 ALTER TABLE `pertanyaans` DISABLE KEYS */;
/*!40000 ALTER TABLE `pertanyaans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sub_category_id` bigint unsigned NOT NULL,
  `teks_pertanyaan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_jawaban` enum('likert','text') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'likert',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_sub_category_id_foreign` (`sub_category_id`),
  CONSTRAINT `questions_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,1,'Sistem SIAKAD mudah diakses dari berbagai perangkat tanpa kendala teknis.','likert','2026-02-06 04:20:16','2026-02-06 04:20:16'),(2,1,'Menu dan navigasi SIAKAD jelas sehingga saya cepat menemukan informasi akademik.','likert','2026-02-06 04:20:16','2026-02-06 04:20:16'),(3,1,'Tampilan antarmuka SIAKAD modern dan nyaman digunakan dalam waktu lama.','likert','2026-02-06 04:20:16','2026-02-06 04:20:16'),(4,1,'Proses pengisian KRS atau administrasi lain di SIAKAD berjalan lancar.','likert','2026-02-06 04:20:16','2026-02-06 04:20:16'),(5,1,'Notifikasi dan pesan yang muncul di SIAKAD mudah dipahami dan membantu.','likert','2026-02-06 04:20:16','2026-02-06 04:20:16'),(6,2,'Saya merasa puas dengan pengalaman belajar di Universitas Sugeng Hartono.','likert','2026-02-06 04:20:16','2026-02-06 04:20:16'),(7,2,'Saya bersedia merekomendasikan kampus ini kepada orang lain.','likert','2026-02-06 04:20:16','2026-02-06 04:20:16'),(8,2,'Lingkungan kampus mendukung pengembangan diri saya.','likert','2026-02-06 04:20:16','2026-02-06 04:20:16'),(9,2,'Program akademik kampus memenuhi harapan saya.','likert','2026-02-06 04:20:16','2026-02-06 04:20:16'),(10,2,'Secara keseluruhan, layanan kampus berjalan sesuai standar yang dijanjikan.','likert','2026-02-06 04:20:16','2026-02-06 04:20:16'),(11,3,'Seberapa cepat waktu pemuatan (loading) halaman saat Anda login ke Siakad?','likert','2026-02-06 04:24:35','2026-02-06 04:32:19'),(12,3,'Apakah Siakad dapat diakses dengan lancar melalui perangkat seluler (smartphone)?','likert','2026-02-06 04:32:27','2026-02-06 04:32:27'),(13,3,'Seberapa sering Anda mengalami kendala teknis (seperti server down) saat periode pengisian KRS?','likert','2026-02-06 04:32:38','2026-02-06 04:32:38'),(14,3,'Bagaimana kemudahan dalam melakukan pemulihan kata sandi (reset password) jika lupa?','likert','2026-02-06 04:32:47','2026-02-06 04:32:47'),(15,3,'Apakah antarmuka (UI) Siakad terlihat modern dan mudah dipahami?','likert','2026-02-06 04:32:55','2026-02-06 04:32:55'),(16,4,'Apakah informasi jadwal perkuliahan yang ditampilkan selalu akurat dan terbaru?','likert','2026-02-06 04:33:18','2026-02-06 04:33:18'),(17,4,'Seberapa mudah proses pengisian KRS secara mandiri di dalam sistem?','likert','2026-02-06 04:33:27','2026-02-06 04:33:27'),(18,4,'Apakah fitur pemantauan nilai (KHS/Transkrip) memberikan rincian yang jelas?','likert','2026-02-06 04:33:37','2026-02-06 04:33:37'),(19,4,'Seberapa membantu fitur grafik perkembangan akademik dalam memantau IPK Anda?','likert','2026-02-06 04:34:00','2026-02-06 04:34:00'),(20,5,'Berapa lama waktu tunggu rata-rata untuk mendapatkan tanda tangan atau legalisir dokumen?','likert','2026-02-06 04:35:10','2026-02-06 04:35:10'),(21,5,'Seberapa cepat staf merespons keluhan yang Anda sampaikan melalui kanal resmi?','likert','2026-02-06 04:35:17','2026-02-06 04:35:17'),(22,5,'Apakah staf memberikan informasi yang konsisten dan tidak simpang siur?','likert','2026-02-06 04:35:24','2026-02-06 04:35:24'),(23,5,'Bagaimana tanggapan staf jika Anda menanyakan kendala yang mendesak di luar jam kerja?','likert','2026-02-06 04:35:31','2026-02-06 04:35:31'),(24,5,'Apakah prosedur birokrasi yang diarahkan oleh staf terasa efektif (tidak berbelit-belit)?\n','likert','2026-02-06 04:35:40','2026-02-06 04:35:40');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('IqVSkPjcFGXSJ4jXcCPAl2n6d9NIqr1EiQ2uKzKa',2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoibkk5REFjOFZaTWp6cFJ6T2I4NDlhQmpadzVERlBXdEgzRGs0bkNNNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9',1770368471);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `nama_sub` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_sub` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_categories_category_id_foreign` (`category_id`),
  CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_categories`
--

LOCK TABLES `sub_categories` WRITE;
/*!40000 ALTER TABLE `sub_categories` DISABLE KEYS */;
INSERT INTO `sub_categories` VALUES (1,1,'Kemudahan Penggunaan','Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)','2026-02-06 04:20:16','2026-02-06 04:20:16'),(2,1,'Kepuasan Keseluruhan','Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)','2026-02-06 04:20:16','2026-02-06 04:20:16'),(3,2,'Aksesibilitas dan Performa',NULL,'2026-02-06 04:24:12','2026-02-06 04:32:09'),(4,2,'Kelengkapan Fitur',NULL,'2026-02-06 04:33:07','2026-02-06 04:33:07'),(5,3,'Responsivitas dan Kecepatan',NULL,'2026-02-06 04:34:55','2026-02-06 04:35:49');
/*!40000 ALTER TABLE `sub_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_responden` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program_studi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `angkatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Indah','indah123@gmail.com','2026-02-06 04:21:15','$2y$12$..H5r1kRgRJ6D79hGZXKeulqucEIjHcFKGrtXW9xvs2SCm5aTzC1.','user','Perempuan','mahasiswa','S1 Teknik Informatika','2022',NULL,'2026-02-06 04:07:00','2026-02-06 04:21:15'),(2,'Administrator Kampus','admin@ngampus.test','2026-02-06 04:21:15','$2y$12$MYFgEKTPI/KW9lbcBGuSpOPTJr5nTQuBVS9au8/1asjaTZvTtU9mO','admin','Laki-laki','staf','S1 Teknik Informatika','2026',NULL,'2026-02-06 04:20:16','2026-02-06 07:56:53'),(3,'Indah','indah12@gmail.com',NULL,'$2y$12$vitG1y1U9wPDNUprI7GbTuVvBoDwSKWsJI6caeMIlKUqqKCEfZhCm','mahasiswa','Perempuan','mahasiswa','S1 Desain Komunikasi Visual','2023',NULL,'2026-02-06 04:26:10','2026-02-06 04:26:10');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'Ngampus_Rate'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-12 11:17:37
