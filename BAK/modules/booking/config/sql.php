CREATE TABLE IF NOT EXISTS `booking` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MemberID` int(11) NOT NULL,
  `ListingID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `MobileNo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Pax` int(11) NOT NULL,
  `Remarks` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `PassCode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Status` int(11) NOT NULL,
  `DateBooked` datetime NOT NULL,
  `DateArrival` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;