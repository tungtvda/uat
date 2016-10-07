CREATE TABLE IF NOT EXISTS `listing` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MerchantID` int(11) NOT NULL,
  `TypeID` int(11) NOT NULL,
  `FilterID` int(11) NOT NULL,
  `Name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `ImageURL` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Street1` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Street2` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `City` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Postcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `State` int(255) NOT NULL,
  `Country` int(255) NOT NULL,
  `MapX` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `MapY` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `PhoneNo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Enabled` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
