CREATE TABLE `users` (
   `id` int(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   `username` varchar(100) NOT NULL,
   `email` varchar(100) NOT NULL,
   `role` enum('Author','Admin') DEFAULT NULL,
   `password` varchar(100) NOT NULL,
   `firstname` varchar(100) NOT NULL,
   `lastname` varchar(100) NOT NULL,
   `middlename` varchar(100),
   `nickname` varchar(100),
   `address1` varchar(100),
   `address2` varchar(100),
   `city` varchar(100),
   `state` varchar(2),
   `zipcode` varchar(5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;