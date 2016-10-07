CREATE TABLE IF NOT EXISTS `region` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Country` int(11) NOT NULL,
  `State` int(11) NOT NULL,
  `Enabled` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
