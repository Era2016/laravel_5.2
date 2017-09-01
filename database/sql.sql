/*数据库设计*/
CREATE TABLE IF NOT EXISTS `t_permission` (
  `id` int(11) NOT NULL auto_increment,
  `title` char(64) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `Title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `t_role_permission` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `assignment_date` int(11) NOT NULL,
  PRIMARY KEY  (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `t_role` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(128) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `t_user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `assignment_date` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;