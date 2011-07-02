--
-- MySQL 5.1.51
-- Fri, 05 Nov 2010 04:41:07 +0000
--

CREATE TABLE `answer` (
   `id` int(11) not null auto_increment,
   `question_id` int(11),
   `user_id` int(11),
   `answer` text,
   `votes` int(11),
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

INSERT INTO `answer` (`id`, `question_id`, `user_id`, `answer`, `votes`) VALUES 
('1', '1', '1', 'this is my reply', '0');