CREATE TABLE IF NOT EXISTS `currency` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CountryID` int(11) NOT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ExchangeRate` decimal(19,4) NOT NULL,
  `Main` int(2) NOT NULL,
  `Enabled` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
