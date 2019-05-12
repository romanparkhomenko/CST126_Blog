CREATE TABLE `comments` (
   `id` int(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   `user_id` int(11) DEFAULT NULL,
   `post_id` int(11) NOT NULL,
   `body` text NOT NULL,
   `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8