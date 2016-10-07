CREATE TABLE IF NOT EXISTS `member_address` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MemberID` int(11) DEFAULT NULL,
  `Title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Street` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Street2` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `City` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `State` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Postcode` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Country` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `PhoneNo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `FaxNo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Enabled` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
