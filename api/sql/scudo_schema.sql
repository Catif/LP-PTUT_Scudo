-- Adminer 4.8.1 MySQL 5.5.5-10.11.2-MariaDB-1:10.11.2+maria~ubu2204 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `authorization`;
CREATE TABLE `authorization` (
  `token` varchar(36) NOT NULL,
  `id_user` varchar(36) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`token`),
  KEY `FK_Authorization_User_idx` (`id_user`),
  CONSTRAINT `FK_Authorization_User` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id_comment` varchar(36) NOT NULL,
  `id_user` varchar(36) NOT NULL,
  `id_resource` varchar(36) NOT NULL,
  `content` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `FK_Comment_User_idx` (`id_user`),
  KEY `FK_Comment_Resource_idx` (`id_resource`),
  CONSTRAINT `FK_Comment_Resource` FOREIGN KEY (`id_resource`) REFERENCES `resource` (`id_resource`),
  CONSTRAINT `FK_Comment_User` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `conversation`;
CREATE TABLE `conversation` (
  `id_conversation` varchar(36) NOT NULL,
  `id_sender` varchar(36) NOT NULL,
  `id_recipient` varchar(36) NOT NULL,
  `is_established` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_conversation`),
  KEY `FK_Conversation_User_Sender_idx` (`id_sender`),
  KEY `FK_Conversation_User_Recipient_idx` (`id_recipient`),
  CONSTRAINT `FK_Conversation_User_Recipient` FOREIGN KEY (`id_recipient`) REFERENCES `user` (`id_user`),
  CONSTRAINT `FK_Conversation_User_Sender` FOREIGN KEY (`id_sender`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `id_group` varchar(36) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id_message` varchar(36) NOT NULL,
  `id_user` varchar(36) NOT NULL,
  `id_conversation` varchar(36) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_message`),
  KEY `FK_Message_User_idx` (`id_user`),
  KEY `FK_Message_Conversation_idx` (`id_conversation`),
  CONSTRAINT `FK_Message_Conversation` FOREIGN KEY (`id_conversation`) REFERENCES `conversation` (`id_conversation`),
  CONSTRAINT `FK_Message_User` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `resource`;
CREATE TABLE `resource` (
  `id_resource` varchar(36) NOT NULL,
  `id_user` varchar(36) NOT NULL,
  `filename` varchar(250) DEFAULT NULL,
  `title` varchar(250) NOT NULL,
  `text` varchar(500) NOT NULL,
  `longitude` decimal(65,0) DEFAULT NULL,
  `latitude` decimal(65,0) DEFAULT NULL,
  `type` varchar(250) NOT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_resource`),
  KEY `FK_Resource_User_idx` (`id_user`),
  CONSTRAINT `FK_Resource_User` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `resource_group`;
CREATE TABLE `resource_group` (
  `id_resource` varchar(36) NOT NULL,
  `id_group` varchar(36) NOT NULL,
  KEY `FK_Resource-Group_Resource_idx` (`id_resource`),
  KEY `FK_Resource-Group_Group_idx` (`id_group`),
  CONSTRAINT `FK_Resource-Group_Group` FOREIGN KEY (`id_group`) REFERENCES `group` (`id_group`),
  CONSTRAINT `FK_Resource-Group_Resource` FOREIGN KEY (`id_resource`) REFERENCES `resource` (`id_resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` varchar(36) NOT NULL,
  `fullname` varchar(250) DEFAULT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `biography` varchar(1000) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `role` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `user_follow`;
CREATE TABLE `user_follow` (
  `id_user` varchar(36) NOT NULL,
  `id_user_followed` varchar(36) NOT NULL,
  KEY `FK_User-Follow_User_idx` (`id_user`),
  KEY `FK_User-Follow_User2_idx` (`id_user_followed`),
  CONSTRAINT `FK_User-Follow_User` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  CONSTRAINT `FK_User-Follow_User2` FOREIGN KEY (`id_user_followed`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `id_user` varchar(36) NOT NULL,
  `id_group` varchar(36) NOT NULL,
  `role` varchar(250) NOT NULL,
  KEY `FK_User-Group_User_idx` (`id_user`),
  KEY `FK_User-Group_Group_idx` (`id_group`),
  CONSTRAINT `FK_User-Group_Group` FOREIGN KEY (`id_group`) REFERENCES `group` (`id_group`),
  CONSTRAINT `FK_User-Group_User` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2023-04-11 11:03:27
