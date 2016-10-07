CREATE TABLE IF NOT EXISTS `state` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CountryID` int(2) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
