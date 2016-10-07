CREATE TABLE IF NOT EXISTS `language` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Display` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `Code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `Enabled` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;