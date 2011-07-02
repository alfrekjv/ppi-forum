--
-- MySQL 5.1.51
-- Thu, 04 Nov 2010 17:19:18 +0000
--

CREATE TABLE `question` (
   `id` int(11) not null auto_increment,
   `user_id` int(11),
   `notify_user` tinyint(4),
   `title` varchar(255),
   `content` text,
   `is_answered` tinyint(4),
   `is_accepted` tinyint(4),
   `created_date` datetime,
   `views` int(11),
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- [Table `question` is empty]

CREATE TABLE `users` (
   `id` int(11) not null auto_increment,
   `role_id` int(11) not null,
   `created` int(25) not null,
   `first_name` varchar(255) not null,
   `last_name` varchar(255) not null,
   `email` varchar(255) not null,
   `password` varchar(255) not null,
   `username` varchar(255) not null,
   `active` int(1) not null default '1',
   `activation_code` varchar(255) not null,
   `points` int(11),
   `questions_asked` int(11),
   `answers_given` int(11),
   `answers_accepted` int(11),
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

INSERT INTO `users` (`id`, `role_id`, `created`, `first_name`, `last_name`, `email`, `password`, `username`, `active`, `activation_code`, `points`, `questions_asked`, `answers_given`, `answers_accepted`) VALUES 
('1', '2', '1288887447', 'Paul', 'Dragoonis', 'dragoonis@gmail.com', '07f464ed4e8c7cd67470c95e2cb08c03b4f3d8e3abe6cd3f26a2', 'dragoonis', '1', 'MTI4ODg4NzQ0Nw==', '', '', '', '');