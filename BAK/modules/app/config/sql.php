CREATE TABLE IF NOT EXISTS `app` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(10) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PublicKey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `SecretKey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `IPAddress` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Enabled` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;