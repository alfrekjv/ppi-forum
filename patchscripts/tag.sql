--
-- MySQL 5.1.51
-- Fri, 05 Nov 2010 04:43:03 +0000
--

CREATE TABLE `tag` (
   `id` int(11) not null auto_increment,
   `title` varchar(255),
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=4;

INSERT INTO `tag` (`id`, `title`) VALUES 
('1', 'css'),
('2', 'html'),
('3', 'php');