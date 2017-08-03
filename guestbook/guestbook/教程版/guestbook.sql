CREATE TABLE `guestbook` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `nickname` char(16) NOT NULL default '',
  `email` varchar(60) default NULL,
  `content` text NOT NULL,
  `createtime` int(10) unsigned NOT NULL default '0',
  `reply` text,
  `replytime` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;