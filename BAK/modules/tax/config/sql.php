CREATE TABLE IF NOT EXISTS `tax` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `RegionID` int(11) NOT NULL,
  `Name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Amount` decimal(19,2) NOT NULL,
  `Enabled` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
