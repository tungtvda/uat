CREATE TABLE IF NOT EXISTS `banner` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ImageURL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `AltTitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Target` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Position` int(5) NOT NULL,
  `Enabled` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

