CREATE TABLE IF NOT EXISTS `petermeter_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_datum` datetime NOT NULL,
  `commentaar` VARCHAR(256) default NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `petermeter_attendees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `naam` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;