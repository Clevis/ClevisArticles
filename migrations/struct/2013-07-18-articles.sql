
CREATE TABLE `articles` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT 'title of the article',
  `intro` varchar(255) NOT NULL COMMENT 'short intro about the article',
  `text` text NOT NULL COMMENT 'main text',
  `created_at` datetime NOT NULL COMMENT 'when was the article created',
  `created_by_id` int(1) NOT NULL COMMENT 'by whom was the article created',
  `visible` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'is the artice visible',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
