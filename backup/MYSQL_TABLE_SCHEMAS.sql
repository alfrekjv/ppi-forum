-- --------------------------------------------------------

--
-- Table structure for table `qa_users`
--

CREATE TABLE IF NOT EXISTS `qa_users` (
    `id`                    bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `email`                 varchar(200)        NOT NULL DEFAULT '',
    `username`              varchar(100)        NOT NULL DEFAULT '',
    `password`              varchar(100)        NOT NULL DEFAULT '',
    `logins`                int(11) unsigned    NOT NULL DEFAULT '0',
    `last_login`            int(11) unsigned    NOT NULL DEFAULT '0',
    
    `website`               varchar(100)        NOT NULL DEFAULT '',
    `display_name`          varchar(100)        NOT NULL DEFAULT '',
    `location`              varchar(100)        NOT NULL DEFAULT '',
    `birthday`              date                NOT NULL DEFAULT '0000-00-00',
    `description`           text                NOT NULL,
    
    -- Calculated Values
    `activation_key`        varchar(100)        NOT NULL DEFAULT '',
    `last_activity_date`    datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `last_ip_address`       varchar(100)        NOT NULL DEFAULT '',
    `last_user_agent`       varchar(200)        NOT NULL DEFAULT '',
    `reputation_score`      int(11)             NOT NULL DEFAULT '0',
    `question_count`        int(11) unsigned    NOT NULL DEFAULT '0',
    `answer_count`          int(11) unsigned    NOT NULL DEFAULT '0',
    `up_vote_casted`        int(11) unsigned    NOT NULL DEFAULT '0',
    `down_vote_casted`      int(11) unsigned    NOT NULL DEFAULT '0',
    `badge_count`           int(11) unsigned    NOT NULL DEFAULT '0',
    `post_followed`         int(11) unsigned    NOT NULL DEFAULT '0',
    `profile_view_count`    int(11) unsigned    NOT NULL DEFAULT '0' COMMENT 'number of times viewed by others',
    
    -- Package Foot
    `date_created`          datetime        NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`            varchar(200)    NOT NULL DEFAULT '',
    `date_modified`         datetime        NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`           varchar(200)    NOT NULL DEFAULT '',
    `is_deleted`            tinyint         NOT NULL DEFAULT '0',
    
    PRIMARY KEY  (`id`),
    KEY `username` (`username`),
    KEY `email` (`email`)
);



-- --------------------------------------------------------

--
-- Table structure for table `qa_user_metas`
--

CREATE TABLE IF NOT EXISTS `qa_user_metas` (
    `id`                    bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id`               bigint(20)          NOT NULL DEFAULT '0',
    `meta_key`              varchar(100)        NOT NULL DEFAULT '',
    `meta_value`            varchar(100)        NOT NULL DEFAULT '',
    
    -- Package Foot
    `date_created`          datetime        NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`            varchar(200)    NOT NULL DEFAULT '',
    `date_modified`         datetime        NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`           varchar(200)    NOT NULL DEFAULT '',
    `is_deleted`            tinyint         NOT NULL DEFAULT '0',
    
    PRIMARY KEY  (`id`),
    KEY `user_id` (`user_id`),
    KEY `meta_key` (`meta_key`)
);



-- --------------------------------------------------------

--
-- Table structure for table `qa_roles`
--

CREATE TABLE IF NOT EXISTS `qa_roles` (
    `id`                int(11) unsigned    NOT NULL AUTO_INCREMENT,
    `name`              varchar(32)         NOT NULL,
    `description`       varchar(255)        NOT NULL,
    
    PRIMARY KEY  (`id`),
    UNIQUE KEY `name` (`name`)
);


 
-- --------------------------------------------------------

--
-- Table structure for table `qa_roles_users`
--

CREATE TABLE IF NOT EXISTS `qa_roles_users` (
    `user_id`       bigint(20) unsigned NOT NULL,
    `role_id`       int(11) unsigned    NOT NULL,
    
    PRIMARY KEY  (`user_id`,`role_id`),
    KEY `fk_role_id` (`role_id`)
);



-- --------------------------------------------------------

--
-- Table structure for table `qa_posts`
--

CREATE TABLE IF NOT EXISTS `qa_posts` (
    `id`                    bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id`               bigint(20) unsigned NOT NULL DEFAULT '0',
    `title`                 text                NOT NULL,
    `slug`                  varchar(200)        NOT NULL DEFAULT '',
    `content`               longtext            NOT NULL,
    `status`                varchar(20)         NOT NULL DEFAULT 'publish'  COMMENT 'publish|closed|bounty(only applicable to questions)|accepted(only applicable to answers)|answered(only application to questions)',
    `parent_id`             bigint(20) unsigned NOT NULL DEFAULT '0'        COMMENT 'Parent question of an answer, or Parent of a comment',
    `type`                  varchar(20)         NOT NULL DEFAULT ''         COMMENT 'question|answer|comment',
    `mode`                  varchar(20)         NOT NULL DEFAULT 'normal'   COMMENT 'normal|wiki|discussion',
    
    -- Calculated Values
    `up_vote_count`         int(11)             NOT NULL DEFAULT '0',
    `down_vote_count`       int(11)             NOT NULL DEFAULT '0',
    `view_count`            int(11)             NOT NULL DEFAULT '0',
    `answer_count`          int(11)             NOT NULL DEFAULT '0'        COMMENT 'only applicable to questions',
    `comment_count`         int(11)             NOT NULL DEFAULT '0'        COMMENT 'only applicable to questions and answers',
    `follow_count`          int(11)             NOT NULL DEFAULT '0'        COMMENT 'only applicable to questions',    
    `last_activity_date`    datetime            NOT NULL DEFAULT '0000-00-00 00:00:00'  COMMENT 'Only applicable to questions',
    
    -- Package Foot
    `date_created`          datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`            varchar(200)        NOT NULL DEFAULT '',
    `date_modified`         datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`           varchar(200)        NOT NULL DEFAULT '',
    `is_deleted`            tinyint             NOT NULL DEFAULT '0',
    
    PRIMARY KEY (`id`),
    KEY `slug` (`slug`),
    KEY `type_status_date` (`type`,`status`,`date_created`,`id`),
    KEY `parent_id` (`parent_id`)
);



-- --------------------------------------------------------

--
-- Table structure for table `qa_post_metas`
--

CREATE TABLE IF NOT EXISTS `qa_post_metas` (
    `id`                    bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `post_id`               bigint(20)          NOT NULL DEFAULT '0',
    `meta_key`              varchar(100)        NOT NULL DEFAULT '',
    `meta_value`            varchar(100)        NOT NULL DEFAULT '',
    
    -- Package Foot
    `date_created`          datetime        NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`            varchar(200)    NOT NULL DEFAULT '',
    `date_modified`         datetime        NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`           varchar(200)    NOT NULL DEFAULT '',
    `is_deleted`            tinyint         NOT NULL DEFAULT '0',
    
    PRIMARY KEY  (`id`),
    KEY `post_id` (`post_id`),
    KEY `meta_key` (`meta_key`)
);



-- --------------------------------------------------------

--
-- Table structure for table `qa_activities`
--
-- Syntax:
--      {user_id} {action} {object_type} {object_id}
--
-- Examples:
--      User 37 create  post 366 (a question)
--      User 19 create  post 368 (an answer to question 366)
--      User 37 modify  post 366
--      User 56 view    post 366
--      User 66 create  post 377 (a comment to answer 368)
--      User 37 view    user 66 ('s profile)
--      User 66 vote_up     post 366
--      User 66 vote_down   post 368
--

CREATE TABLE IF NOT EXISTS `qa_activities` (
    `id`                    bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id`               bigint(20) unsigned NOT NULL DEFAULT '0',
    `action_key`            varchar(20)         NOT NULL DEFAULT '' COMMENT 'create|modify|view|vote_up|vote_down|flag|follow|answer-accepted',
    `object_type`           varchar(20)         NOT NULL DEFAULT '' COMMENT 'post|user',
    `object_id`             bigint(20) unsigned NOT NULL DEFAULT '0',

    -- Package Foot
    `date_created`          datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`            varchar(200)        NOT NULL DEFAULT '',
    `date_modified`         datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`           varchar(200)        NOT NULL DEFAULT '',
    `is_deleted`            tinyint             NOT NULL DEFAULT '0',
    
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`)
);



-- --------------------------------------------------------

--
-- Table structure for table `qa_reputations`
--
-- Syntax:
--      {user_id} {reputation_value} {post_id}
--
-- Examples:
--      User 37 award rep +10 to post 368 (by vote up)
--

CREATE TABLE IF NOT EXISTS `qa_reputations` (
    `id`                    bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id`               bigint(20) unsigned NOT NULL DEFAULT '0',
    `post_id`               bigint(20) unsigned NOT NULL DEFAULT '0',
    `value`                 int(11)             NOT NULL DEFAULT '0'    COMMENT 'reputation value assigned to this post',
    `blurb`                 text                NOT NULL                COMMENT 'a human readable setence explains this reputation activity',
    
    -- Package Foot
    `date_created`          datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`            varchar(200)        NOT NULL DEFAULT '',
    `date_modified`         datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`           varchar(200)        NOT NULL DEFAULT '',
    `is_deleted`            tinyint             NOT NULL DEFAULT '0',
    
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `post_id` (`post_id`)
);



-- --------------------------------------------------------

--
-- Table structure for table `qa_tags`
--

CREATE TABLE IF NOT EXISTS `qa_tags` (
    `id`                        bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `name`                      varchar(100)        NOT NULL DEFAULT '',
    `slug`                      varchar(100)        NOT NULL DEFAULT '',
    
    -- Calculated Values
    `post_count`                int(11)             NOT NULL DEFAULT '0' COMMENT 'Number of post that uses this tag',
    
    -- Package Foot
    `date_created`              datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`                varchar(200)        NOT NULL DEFAULT '',
    `date_modified`             datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`               varchar(200)        NOT NULL DEFAULT '',
    `is_deleted`                tinyint             NOT NULL DEFAULT '0',
  
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`),
    KEY `name` (`name`)
);



-- --------------------------------------------------------

--
-- Table structure for table `qa_posts_tags`
--

CREATE TABLE IF NOT EXISTS `qa_posts_tags` (
    `post_id`       bigint(20) unsigned NOT NULL,
    `tag_id`       int(11) unsigned    NOT NULL,
    
    PRIMARY KEY  (`post_id`,`tag_id`),
    KEY `fk_tag_id` (`tag_id`)
);



-- --------------------------------------------------------

--
-- Table structure for table `qa_tags_users`
--

CREATE TABLE IF NOT EXISTS `qa_tags_users` (
    `id`                        bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id`                   bigint(20) unsigned NOT NULL DEFAULT '0',
    `tag_id`                    bigint(20) unsigned NOT NULL DEFAULT '0',
    `relation_type`             varchar(200)        NOT NULL DEFAULT ''     COMMENT 'involved|interested|ignored',
    
    -- Calculated Values
    `post_count`                int(11) unsigned    NOT NULL DEFAULT '0'    COMMENT 'Number of posts that this user involved with this tag. Applicable to involved tags',
    
    -- Package Foot
    `date_created`              datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`                varchar(200)        NOT NULL DEFAULT '',
    `date_modified`             datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`               varchar(200)        NOT NULL DEFAULT '',
    `is_deleted`                tinyint             NOT NULL DEFAULT '0',

    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `tag_id` (`tag_id`)
);



-- --------------------------------------------------------

--
-- Table structure for table `qa_settings`
--

CREATE TABLE IF NOT EXISTS `qa_settings` (
    `id`                        bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `name`                      varchar(100)        NOT NULL DEFAULT '',
    `value`                     longtext            NOT NULL,
    `autoload`                  tinyint             NOT NULL DEFAULT '0',
    
    -- Package Foot
    `date_created`              datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by`                varchar(200)        NOT NULL DEFAULT '',
    `date_modified`             datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by`               varchar(200)        NOT NULL DEFAULT '',
    `is_deleted`                tinyint             NOT NULL DEFAULT '0',

    PRIMARY KEY (`id`),
    KEY `name` (`name`)
);

-- --------------------------------------------------------
