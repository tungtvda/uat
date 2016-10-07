CREATE TABLE IF NOT EXISTS `bank_info` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ResellerID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ImageURL` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;