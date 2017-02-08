--
-- MySQL 5.6.12
-- Wed, 08 Feb 2017 10:36:17 +0000
--

CREATE TABLE `conversion` (
   `id` int(11) not null auto_increment,
   `user1` int(11),
   `user2` int(11),
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=4;


CREATE TABLE `friends` (
   `id` int(11) not null auto_increment,
   `user_id` int(11),
   `friend_id` int(11),
   `friend_token` longtext,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;


CREATE TABLE `login_attempts` (
   `id` int(11) not null auto_increment,
   `user_id` int(11),
   `time` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=8;


CREATE TABLE `messages` (
   `id` int(11) not null auto_increment,
   `conv_id` int(11),
   `from_id` int(11),
   `message` longtext,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=8;


CREATE TABLE `users` (
   `id` int(11) not null auto_increment,
   `username` varchar(255),
   `password` varchar(255),
   `phone` varchar(255),
   `email` varchar(255),
   `secret_key` longtext,
   `status` longtext,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=4;
