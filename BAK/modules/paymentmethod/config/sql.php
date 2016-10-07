CREATE TABLE IF NOT EXISTS `payment_method` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
