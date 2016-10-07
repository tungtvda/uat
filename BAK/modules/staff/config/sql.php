CREATE TABLE IF NOT EXISTS `staff` (
  `ID` int(55) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `MobileNo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Profile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Prompt` int(2) NOT NULL,
  `Enabled` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
