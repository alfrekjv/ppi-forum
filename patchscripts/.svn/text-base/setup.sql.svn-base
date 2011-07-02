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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;