CREATE TABLE IF NOT EXISTS `message` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ContactNo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Subject` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Message` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `DatePosted` datetime NOT NULL,
  `Status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
