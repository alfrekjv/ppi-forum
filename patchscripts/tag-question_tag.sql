--
-- MySQL 5.1.51
-- Fri, 05 Nov 2010 04:26:59 +0000
--

CREATE TABLE `badge` (
   `id` int(11) not null auto_increment,
   `title` varchar(45),
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- [Table `badge` is empty]

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=11;

INSERT INTO `question` (`id`, `user_id`, `notify_user`, `title`, `content`, `is_answered`, `is_accepted`, `created_date`, `views`) VALUES 
('3', '1', '', 'Paul\'s Cool Question', 'djiof ps-dfsp\r\nifsdpfi\r\nsospfosj fos hos ufopsi do-fsjodp f\r\nsd fds[p fisokfposjfiop sjiofj sofos jfjkshidf hishf s\r\nfjosjf\r\nsf\r\n iosdjofojdf sfps jpfs \r\nf', '', '', '', ''),
('4', '1', '', 'Web Question', 'dof jspf s-f -s fis fis if\r\nsif-s ifsi pdi podsi f d\r\nsiopdfjiosj spodjfoi sf jsf \r\nsfji osj os fjosjfos josdjfos s\r\nsjidofj so jsofjojsdfos dofsj s jfdos s\r\nos jfdosjiof jsod josf josi jfs\r\nfs josj s#sjs osdfjso s fsjoif sosjf os', '', '', '', ''),
('5', '1', '', 'Paul\'s Cool Question 222', 'odjf iosdjf sdpfsd\r\n[ fd\r\ng jdfpg pdf pgpodf kfg[ gp', '', '', '', ''),
('10', '1', '', 'Paul\'s Cool Question 111', 'dosjf siodfos d spj f-d g\r\ndfpocfkpofk [v \r\nv ovppnvk pvk npv', '', '', '', '');

CREATE TABLE `question_tag` (
   `id` int(11) not null auto_increment,
   `question_id` int(11),
   `tag_id` int(11),
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=7;

INSERT INTO `question_tag` (`id`, `question_id`, `tag_id`) VALUES 
('1', '8', '2'),
('2', '8', '1'),
('3', '9', '3'),
('4', '9', '2'),
('5', '10', '3'),
('6', '10', '2');