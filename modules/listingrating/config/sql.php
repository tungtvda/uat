CREATE TABLE IF NOT EXISTS `listing_rating` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MemberID` int(11) NOT NULL,
  `ListingID` int(11) NOT NULL,
  `Rating` int(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
