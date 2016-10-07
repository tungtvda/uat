CREATE TABLE IF NOT EXISTS `announcement` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Description` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Content` longtext COLLATE utf8_unicode_ci,
  `Enabled` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

