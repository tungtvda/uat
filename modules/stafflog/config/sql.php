CREATE TABLE IF NOT EXISTS `staff_log` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DateLogged` datetime NOT NULL,
  `IP` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `UserID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `User` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
