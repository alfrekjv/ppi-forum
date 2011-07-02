-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 26, 2010 at 07:20 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `qanda`
--

--
-- Dumping data for table `qa_activities`
--

INSERT INTO `qa_activities` (`id`, `user_id`, `action_key`, `object_type`, `object_id`, `date_created`, `created_by`, `date_modified`, `modified_by`, `is_deleted`) VALUES
(1, 1, 'view', 'post', 1, '2010-02-27 11:45:00', 'TL', '0000-00-00 00:00:00', '', 0),
(2, 1, 'create', 'post', 1, '2010-02-27 11:44:00', 'activity::track', '0000-00-00 00:00:00', '', 0),
(3, 1, 'create', 'post', 2, '2010-04-26 07:19:42', 'activity::log', '0000-00-00 00:00:00', '', 0);

--
-- Dumping data for table `qa_posts`
--

INSERT INTO `qa_posts` (`id`, `user_id`, `title`, `slug`, `content`, `status`, `parent_id`, `type`, `mode`, `up_vote_count`, `down_vote_count`, `view_count`, `answer_count`, `comment_count`, `follow_count`, `last_activity_date`, `date_created`, `created_by`, `date_modified`, `modified_by`, `is_deleted`) VALUES
(1, 1, 'what made question a question?', 'what-made-question-a-question', 'How do you define a question? is it simply by ending a sentence wtih a question mark?', 'publish', 0, 'question', 'normal', 0, 0, 7, 1, 0, 0, '2010-04-26 07:19:42', '2010-02-27 11:44:00', 'TL', '2010-04-26 07:19:42', 'post::create_answer', 0),
(2, 1, '', '', 'A question is an illocutionary act that has a directive illocutionary point of attempting to get the addressee to supply information.', 'publish', 1, 'answer', 'normal', 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '2010-04-26 07:19:42', 'question::detail', '0000-00-00 00:00:00', '', 0);

--
-- Dumping data for table `qa_posts_tags`
--

INSERT INTO `qa_posts_tags` (`post_id`, `tag_id`) VALUES
(1, 1);

--
-- Dumping data for table `qa_post_metas`
--


--
-- Dumping data for table `qa_reputations`
--


--
-- Dumping data for table `qa_roles`
--

INSERT INTO `qa_roles` (`id`, `name`, `description`) VALUES
(1, 'login', 'Login privileges, granted after account confirmation.'),
(2, 'guest', 'Guest User who don''t have a login account.'),
(3, 'mod', 'Moderator, has higher privileges to normal user but not the access to everything.'),
(4, 'admin', 'Administrative user, has access to everything.'),
(5, 'super', 'Super Administrative user.');

--
-- Dumping data for table `qa_roles_users`
--

INSERT INTO `qa_roles_users` (`user_id`, `role_id`) VALUES
(1, 1);

--
-- Dumping data for table `qa_settings`
--

INSERT INTO `qa_settings` (`id`, `name`, `value`, `autoload`, `date_created`, `created_by`, `date_modified`, `modified_by`, `is_deleted`) VALUES
(1, 'site_name', 'Qanda Demostration Website', 1, '2010-02-27 11:50:00', 'TL', '0000-00-00 00:00:00', '', 0),
(2, 'users_can_register', '1', 0, '2010-04-01 21:48:00', 'TL', '0000-00-00 00:00:00', '', 0),
(3, 'site_description', 'Don''t be shy... ask away!', 1, '2010-04-01 21:48:00', 'TL', '0000-00-00 00:00:00', '', 0),
(4, 'admin_email', 'lorem@ipsum.com', 0, '2010-04-01 21:48:00', 'TL', '0000-00-00 00:00:00', '', 0),
(5, 'current_theme', 'dawn', 1, '2010-04-01 21:48:00', 'TL', '0000-00-00 00:00:00', '', 0),
(6, 'guests_can_question', '1', 0, '2010-04-01 21:48:00', 'TL', '0000-00-00 00:00:00', '', 0),
(7, 'guests_can_answer', '1', 0, '2010-04-01 21:48:00', 'TL', '0000-00-00 00:00:00', '', 0),
(8, 'guests_can_comment', '0', 0, '2010-04-01 21:48:00', 'TL', '0000-00-00 00:00:00', '', 0),
(9, 'date_format', 'd/m/Y', 0, '2010-04-01 21:48:00', 'TL', '0000-00-00 00:00:00', '', 0),
(10, 'time_format', 'g:i a', 0, '2010-04-01 21:48:00', 'TL', '0000-00-00 00:00:00', '', 0),
(11, 'language', 'en', 0, '2010-04-01 21:48:00', 'TL', '0000-00-00 00:00:00', '', 0),
(12, 'database_version', '11', 0, '2010-04-01 21:48:00', 'TL', '0000-00-00 00:00:00', '', 0),
(13, 'show_avatars', '1', 0, '2010-04-01 21:48:00', 'TL', '0000-00-00 00:00:00', '', 0),
(14, 'avatar_rating', 'G', 0, '2010-04-01 21:48:00', 'TL', '0000-00-00 00:00:00', '', 0),
(15, 'timezone_name', 'Australia/Sydney', 0, '2010-04-01 21:48:00', 'TL', '0000-00-00 00:00:00', '', 0),
(16, 'version', '0.2.2', 1, '2010-04-26 16:46:00', 'TL', '2010-05-02 14:38:00', 'TL', 0);

--
-- Dumping data for table `qa_tags`
--

INSERT INTO `qa_tags` (`id`, `name`, `slug`, `post_count`, `date_created`, `created_by`, `date_modified`, `modified_by`, `is_deleted`) VALUES
(1, 'Sample Question', 'sample-question', 6, '2010-02-27 11:49:00', 'TL', '2010-02-27 14:46:58', 'post::create_question', 0);

--
-- Dumping data for table `qa_tags_users`
--

INSERT INTO `qa_tags_users` (`id`, `user_id`, `tag_id`, `relation_type`, `post_count`, `date_created`, `created_by`, `date_modified`, `modified_by`, `is_deleted`) VALUES
(1, 1, 1, 'involved', 4, '2010-02-27 11:49:00', 'TL', '2010-02-27 12:28:07', 'post::create_question', 0);

--
-- Dumping data for table `qa_users`
--

INSERT INTO `qa_users` (`id`, `email`, `username`, `password`, `logins`, `last_login`, `website`, `display_name`, `location`, `birthday`, `description`, `activation_key`, `last_activity_date`, `last_ip_address`, `last_user_agent`, `reputation_score`, `question_count`, `answer_count`, `up_vote_casted`, `down_vote_casted`, `badge_count`, `post_followed`, `profile_view_count`, `date_created`, `created_by`, `date_modified`, `modified_by`, `is_deleted`) VALUES
(1, 'alpha@test.com', 'alpha', 'a99614ecf1f2eccbb60f986095e9be2bc9659390480534aba9', 3, 1272265617, 'http://lorem-ipsum.com/', 'Alpha Ipsum', 'France', '1988-12-01', 'My password is ''alpha''.', 'dummy-activation-key', '2010-04-26 07:19:42', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3 GTB6', 0, 4, 1, 1, 1, 0, 1, 7, '2010-02-27 11:40:00', 'TL', '2010-04-13 13:26:46', 'user::increment_up_vote_casted', 0);

--
-- Dumping data for table `qa_user_metas`
--

