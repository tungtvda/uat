CREATE TABLE IF NOT EXISTS `template` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ThemeID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Enabled` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
