CREATE TABLE IF NOT EXISTS `poi` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TypeID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Address` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `MapX` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `MapY` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Enabled` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
