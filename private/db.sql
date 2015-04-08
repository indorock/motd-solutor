-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 21, 2015 at 04:12 PM
-- Server version: 5.5.40-0+wheezy1
-- PHP Version: 5.5.19-1~dotdeb.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `acl_actions`
--

CREATE TABLE IF NOT EXISTS `acl_actions` (
  `id` int(11) NOT NULL,
  `object` varchar(100) NOT NULL,
  `read` int(10) NOT NULL,
  `update` int(10) NOT NULL,
  `create` int(10) NOT NULL,
  `delete` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

INSERT INTO `acl_actions` (`id`, `object`, `read`, `update`, `create`, `delete`) VALUES
(1, '__default__', 511, 7, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `acl_roles`
--

CREATE TABLE IF NOT EXISTS `acl_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `level` int(10) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

INSERT INTO `acl_roles` (`id`, `name`, `level`, `active`, `description`) VALUES
(1, 'administrator', 1, 1, 'full access'),
(2, 'moderator', 2, 0, NULL),
(3, 'editor', 4, 0, NULL),
(4, 'author', 8, 0, NULL),
(5, 'author2', 16, 0, ''),
(6, 'author3', 32, 0, ''),
(7, 'apiuser', 64, 1, 'reserved for user id 77'),
(8, 'couponissuer', 128, 1, 'full access to coupons, readonly for the rest'),
(9, 'backenduser', 256, 1, 'readonly access to backend'),
(10, 'siteuser', 512, 1, 'no access to backend');

-- --------------------------------------------------------

--
-- Table structure for table `cms_page`
--

CREATE TABLE IF NOT EXISTS `cms_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `page` varchar(255) NOT NULL,
  `mobile_fwd` varchar(128) DEFAULT NULL,
  `is_smarty` int(11) NOT NULL,
  `is_main` int(11) NOT NULL DEFAULT '0',
  `is_simple` tinyint(4) NOT NULL DEFAULT '0',
  `tpl` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE IF NOT EXISTS `form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

-- --
-- Table structure for table `form_autocomplete`
--

CREATE TABLE IF NOT EXISTS `form_autocomplete` (
  `model` varchar(255) CHARACTER SET latin1 NOT NULL,
  `field` varchar(255) CHARACTER SET latin1 NOT NULL,
  `handler` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `lookup` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`model`,`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `frm_lists`
--

CREATE TABLE IF NOT EXISTS `frm_lists` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `active` int(11) NOT NULL DEFAULT '1',
  `name` varchar(32) NOT NULL,
  `label` varchar(50) DEFAULT NULL,
  `template` varchar(255) NOT NULL DEFAULT '',
  `model` varchar(255) NOT NULL,
  `parent_model` varchar(255) DEFAULT NULL,
  `actions` varchar(255) NOT NULL DEFAULT 'CW_Model_MDM_Actions_List',
  `list` varchar(255) NOT NULL DEFAULT 'CW_Model_MDM_Lists_DB',
  `fields` text NOT NULL,
  `filter` text NOT NULL,
  `sort` varchar(255) NOT NULL DEFAULT '',
  `sql` text NOT NULL,
  `joins` text NOT NULL,
  `group_by` text NOT NULL,
  `comment` text NOT NULL,
  `rawsql` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='meta lists' AUTO_INCREMENT=2 ;

INSERT INTO `frm_lists` (`id`, `active`, `name`, `label`, `template`, `model`, `parent_model`, `actions`, `list`, `fields`, `filter`, `sort`, `sql`, `joins`, `group_by`, `comment`, `rawsql`) VALUES
(1, 1, 'translations', NULL, '', 'motd/model/translate', NULL, 'Motd_Model_Actions_Translate', 'motd/model/lists/translate', 'translate.id, translate.lang, translate.ns, translate.txt, translate.val', '', '', '', '', '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role` bigint(20) NOT NULL,
  `active` smallint(1) NOT NULL DEFAULT '1',
  `perm` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=4;

INSERT INTO `permissions` (`id`, `role`, `active`, `perm`, `level`) VALUES
(1, 1, 1, 'user', 1),
(2, 2, 1, 'marketing user', 2),
(3, 10, 1, 'backend', 4);

-- --------------------------------------------------------


--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `NAME` varchar(255) NOT NULL,
  `VALUE` text NOT NULL,
  `DESCRIPTION` text NOT NULL,
  PRIMARY KEY (`NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


-- --------------------------------------------------------

--
-- Table structure for table `translate`
--

CREATE TABLE IF NOT EXISTS `translate` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lang` varchar(2) NOT NULL,
  `ns` varchar(32) NOT NULL,
  `txt` text NOT NULL,
  `val` text NOT NULL,
  `autoadd` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`,`ns`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `role` bigint(20) NOT NULL DEFAULT '1',
  `acl_role` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(64) NOT NULL,
  `email` varchar(180) NOT NULL,
  `code` varchar(80) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `salt` varchar(5) DEFAULT NULL,
  `reset_key` varchar(40) NOT NULL,
  `reset_created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_test` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `name` (`name`),
  KEY `email` (`email`),
  KEY `is_test` (`is_test`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=2 ;

INSERT INTO `user` (`id`, `active`, `role`, `acl_role`, `created_at`, `update_at`, `name`, `email`, `code`, `password`, `salt`, `reset_key`, `reset_created_at`, `is_test`) VALUES
(1, 1, 10, 'administrator', '2014-07-21 12:45:56', '0000-00-00 00:00:00', 'mark', 'mark@bsolut.com', NULL, '45b615a3fded47032a20eb056050a6b5b3c55425', 'fe1bc', '', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE IF NOT EXISTS `user_data` (
  `user_id` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE IF NOT EXISTS `user_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` bigint(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` int(10) unsigned NOT NULL,
  `fail` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE IF NOT EXISTS `campaign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `emailtemplates`
--

CREATE TABLE IF NOT EXISTS `emailtemplates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `ord` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `template` varchar(30) DEFAULT NULL,
  `langpre` varchar(30) DEFAULT NULL,
  `variants` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),

) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;

--
-- Dumping data for table `emailtemplates`
--

INSERT INTO `emailtemplates` (`id`, `name`, `ord`, `active`, `template`, `langpre`, `variants`) VALUES
(1, 'doi', 100, 1, 'generic', NULL, ''),
(2, 'doi_confirm', 101, 1, 'doi_confirm', 'doiconfirm', '');

