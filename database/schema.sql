-- Main portal schema export
-- Generated: 2026-04-24T09:40:46+00:00
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

-- Table: categories
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_name` (`category_name`),
  KEY `idx_categories_sort_name` (`sort_order`,`category_name`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: games
DROP TABLE IF EXISTS `games`;
CREATE TABLE `games` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `game_url` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `game_url_hash` binary(32) GENERATED ALWAYS AS (unhex(sha2(`game_url`,256))) STORED,
  `image_url` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `clicks` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_games_game_url_hash` (`game_url_hash`),
  KEY `idx_games_game_url` (`game_url`(255))
) ENGINE=InnoDB AUTO_INCREMENT=22762 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: game_category
DROP TABLE IF EXISTS `game_category`;
CREATE TABLE `game_category` (
  `game_id` int unsigned NOT NULL,
  `category_id` int unsigned NOT NULL,
  PRIMARY KEY (`game_id`,`category_id`),
  KEY `idx_category_game` (`category_id`,`game_id`),
  CONSTRAINT `fk_gc_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_gc_game` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: click_stats
DROP TABLE IF EXISTS `click_stats`;
CREATE TABLE `click_stats` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int unsigned NOT NULL,
  `game_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_agent` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `referrer` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `clicked_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SET FOREIGN_KEY_CHECKS=1;
