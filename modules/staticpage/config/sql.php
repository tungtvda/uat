CREATE TABLE IF NOT EXISTS `event` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FriendlyURL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `StartingDate` date DEFAULT NULL,
  `EndingDate` date DEFAULT NULL,
  `Venue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `MapX` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `MapY` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `Description` longtext COLLATE utf8_unicode_ci,
  `Content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `FileURL` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ImageURL` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Enabled` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
