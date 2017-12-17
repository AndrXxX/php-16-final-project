-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: garetov
-- ------------------------------------------------------
-- Server version	5.7.20-0ubuntu0.16.04.1

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
-- Table structure for table `php_black_list`
--

DROP TABLE IF EXISTS `php_black_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php_black_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `php_black_list_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php_black_list`
--

LOCK TABLES `php_black_list` WRITE;
/*!40000 ALTER TABLE `php_black_list` DISABLE KEYS */;
INSERT INTO `php_black_list` VALUES (76,'заказать',1,'2017-12-17 18:18:32','2017-12-17 18:18:32'),(77,'купить',1,'2017-12-17 18:18:32','2017-12-17 18:18:32'),(78,'базы',1,'2017-12-17 18:18:32','2017-12-17 18:18:32'),(79,'спам',1,'2017-12-17 18:18:32','2017-12-17 18:18:32'),(80,'купите',1,'2017-12-17 18:18:32','2017-12-17 18:18:32');
/*!40000 ALTER TABLE `php_black_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php_categories`
--

DROP TABLE IF EXISTS `php_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `php_categories_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php_categories`
--

LOCK TABLES `php_categories` WRITE;
/*!40000 ALTER TABLE `php_categories` DISABLE KEYS */;
INSERT INTO `php_categories` VALUES (1,'PHP',1,'2017-12-03 13:00:41','2017-12-03 13:00:43'),(2,'CSS',1,'2017-12-03 13:00:55','2017-12-13 11:54:31'),(3,'HTML',1,'2017-12-03 13:00:55','2017-12-03 13:00:57'),(4,'JS',1,'2017-12-17 18:19:26','2017-12-17 18:19:26');
/*!40000 ALTER TABLE `php_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php_questions`
--

DROP TABLE IF EXISTS `php_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` mediumtext NOT NULL,
  `author` text NOT NULL,
  `author_email` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `answer` mediumtext,
  `state` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `php_questions_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php_questions`
--

LOCK TABLES `php_questions` WRITE;
/*!40000 ALTER TABLE `php_questions` DISABLE KEYS */;
INSERT INTO `php_questions` VALUES (2,'В чем разница между margin и padding?','Геннадий','dsf@fg.tu','2017-12-03 12:20:09','2017-12-17 18:18:00',2,1,'','ожидает ответ'),(8,'Что такое элемент output в HTML 5?','Аскер','sdf@fds.dsf','2017-12-03 21:36:43','2017-12-09 18:56:36',3,1,'','ожидает ответ'),(9,'Какие новые элементы форм введены в HTML 5?','Asdg','sdf@fds.dsf','2017-12-03 21:37:52','2017-12-09 18:56:13',3,1,'В HTML 5 введены десять новых важных элементов форм:\r\n\r\nColor;\r\nDate;\r\nDatetime-local;\r\nEmail;\r\nTime;\r\nUrl;\r\nRange;\r\nTelephone;\r\nNumber;\r\nSearch.','опубликован'),(12,'Как мы можем получить IP-адрес клиента?','Павел','sdf@fds.dsf','2017-12-05 22:20:27','2017-12-09 19:08:03',1,1,'Код $_SERVER[\"REMOTE_ADDR\"]; является самым простым решением','опубликован'),(13,'Почему таблицы стилей CSS называются каскадными?','Андрей','sdf@fds.dsf','2017-12-07 17:31:58','2017-12-09 18:28:07',2,1,'Слово \"каскадные\" говорит о том, что на вывод каждого тега в документе могут оказывать влияние сразу несколько стилевых спецификаций, образующих иерархическую систему. Например, поверх спецификаций, относящихся к конкретному документу, может действовать стилевой файл, общий для всех документов на сервере.','опубликован'),(14,'В чем разница между записью #my и .my?','Андрей','sdf@fds.dsf','2017-12-07 17:32:53','2017-12-09 18:26:24',2,1,'#my - селектор ай-ди,\r\n.my - селектор класса.','опубликован'),(16,'Что такое CSS?','Виктор','andrew1gar@yandex.ru','2017-12-07 17:52:48','2017-12-09 18:28:43',2,1,'Cascading Style Sheets(CSS) - каскадные таблицы стилей, ето формальный язык описания внешнего вида документа, написанного с использованием языка разметки. Таблицы стилей - попытка отделить детали дизайна странички от ее структуры и содержания.','опубликован'),(21,'В чем разница между конструкциями include() и require()?','Джейсон','dsf@fg.tu','2017-12-08 09:09:01','2017-12-09 19:07:15',1,1,'Конструкция include, в отличие от require, позволяет включать файлы в код PHP скрипта во время выполнения сценария.\r\nОтличие include от require также заключается в том, что require выдает Fatal error при невозможности подключения файла по любой причине. include выдаст Warning и продолжит работу.','опубликован'),(25,'Что такое HTML 5?','Джейсон','dsf@fg.tu','2017-12-09 17:14:09','2017-12-09 18:54:28',3,1,'HTML 5 – это новый стандарт HTML, главной целью которого является предоставление любого контента без использования дополнительных плагинов, таких как Flash, Silverlight и т.д. Он содержит всё необходимое для отображения анимации, видео, богатого графического интерфейса и прочего.','опубликован'),(26,'Что такое элемент datalist в HTML 5?','Джейсон','dsf@fg.tu','2017-12-09 17:16:31','2017-12-09 18:55:52',3,1,'Элемент datalist в HTML 5 помогает реализовать функцию автозаполнения в поле для ввода','опубликован'),(27,'Что такое альтернативная таблица стилей?','Петр','dsf@fg.tu','2017-12-09 18:33:46','2017-12-09 18:34:24',2,1,'Альтернативная таблица стилей - это таблица, определяющая стили, которые будут использованы взамен стилей, использующихся по умолчанию. Например, пользователь может сделать выбор, в зависимости от своих предпочтений, если мы заранее подготовим одну таблицу стилей для маленького экрана, а другую &#8211; для слабовидящих (с крупными шрифтами). Альтернативные стили позволяют пользователю сделать выбор наиболее подходящего из них.','опубликован'),(28,'Купите у нас базы','anon','anon@anon.ru','2017-12-09 19:04:13','2017-12-17 18:18:16',3,1,'','заблокирован'),(29,'Каковы основные типы ошибок в PHP и чем они отличаются?','Петр','dsf@fg.tu','2017-12-09 19:09:29','2017-12-09 19:28:02',1,1,'В PHP существует три основных типа ошибок:\r\n\r\nNotices (замечания)\r\nПростые, некритические ошибки, которые произошли во время выполнения сценария. Примером Notices возникновения будет обращение к неопределенной переменной.\r\nWarnings (предупреждения)\r\nБолее серьезные ошибки, чем Notices, однако выполнение сценария не прервется. Примером может быть подключение не существующего файла с помощью include().\r\nFatal (критические)\r\nЭтот тип ошибки вызывает прекращение выполнения сценария. Примером фатальной ошибки будет доступ к свойству несуществующего объекта или require() несуществующего файла.','опубликован'),(30,'Как расшифровывается HTML?','Джейсон','dsf@fg.tu','2017-12-09 19:10:21','2017-12-09 19:13:18',3,1,'Hyper Text Mark-up Language','опубликован'),(31,'Какое расширение должны иметь HTML документы?','Джейсон','dsf@fg.tu','2017-12-09 19:12:24','2017-12-09 19:13:42',3,1,'html','опубликован'),(32,'В чем разница между GET and POST','Джейсон','dsf@fg.tu','2017-12-09 19:27:54','2017-12-09 19:27:54',1,1,'GET отправляет данные как часть URL, в то время как при POST эта информация не показывается, поскольку кодируется в запросе.\r\nGET может обрабатывать максимум 2048 символов, POST не имеет таких ограничений.\r\nGET работает только с ASCII данными, POST не имеет таких ограничений, двоичные данные также допускается.\r\nОбычно GET используется для получения данных, а POST для добавления и обновления.\r\nПонимание основ протокола HTTP очень важно для хорошего старта в качестве разработчика PHP и различия между GET и POST являются неотъемлемой его частью.','опубликован'),(33,'Как включить сообщения об ошибках в PHP?','Джейсон','dsf@fg.tu','2017-12-09 19:28:44','2017-12-09 19:28:44',1,1,'Установите display_errors = on в php.ini или объявите ini_set(\'display_errors\', 1) в вашем сценарии. Затем, добавьте error_reporting(E_ALL) в ваш код, чтобы отобразить все типы сообщений об ошибках во время выполнения скрипта.\r\n\r\nВключение сообщений об ошибках очень важно, особенно в процессе отладки, так как вы можете мгновенно узнать строку, которая производит ошибку, а также убедиться, что сценарий работает правильно.','опубликован'),(34,'Что такое Трейты (Traits)?','Джейсон','dsf@fg.tu','2017-12-09 19:29:09','2017-12-09 19:29:09',1,1,'Трейты представляют собой механизм, который позволяет создавать повторно используемый кода в таких языках, как PHP, где множественное наследование не поддерживается. Трейт не может быть создан сам по себе.','опубликован'),(35,'Что такое геттеры и сеттеры и для чего они нужны?','Джейсон','dsf@fg.tu','2017-12-09 19:29:25','2017-12-09 19:29:25',1,1,'','ожидает ответ'),(46,'Купить базы можно у нас dsfds','Петр','dsf@fg.tu','2017-12-17 18:20:22','2017-12-17 18:20:22',4,1,'','заблокирован'),(47,'Как дела?','Петр','dsf@fg.tu','2017-12-17 18:27:23','2017-12-17 18:27:23',4,1,'','скрыт');
/*!40000 ALTER TABLE `php_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php_users`
--

DROP TABLE IF EXISTS `php_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `password` text NOT NULL,
  `role` tinytext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php_users`
--

LOCK TABLES `php_users` WRITE;
/*!40000 ALTER TABLE `php_users` DISABLE KEYS */;
INSERT INTO `php_users` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3','admin','2017-12-05 21:58:09','2017-12-05 21:58:09');
/*!40000 ALTER TABLE `php_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-17 18:38:33
