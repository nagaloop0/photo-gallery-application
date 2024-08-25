CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4


CREATE TABLE `journal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userid` int DEFAULT NULL,
  `content` text,
  `createdtime` datetime DEFAULT NULL,
  `modifiedtime` datetime DEFAULT NULL,
  `title` text,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_journal_userid` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4

CREATE TABLE `photos` (
  `photoid` int NOT NULL AUTO_INCREMENT,
  `journal_id` int DEFAULT NULL,
  `photo_name` varchar(255) DEFAULT NULL,
  `actual_name` varchar(255) DEFAULT NULL,
  `createdtime` datetime DEFAULT NULL,
  PRIMARY KEY (`photoid`),
  KEY `fk_journal_id` (`journal_id`),
  CONSTRAINT `fk_journal_id` FOREIGN KEY (`journal_id`) REFERENCES `journal` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
