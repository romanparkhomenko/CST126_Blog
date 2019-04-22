CREATE TABLE `post_category` (
   `id` int(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   `post_id` int(4) NOT NULL UNIQUE,
   `topic_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8