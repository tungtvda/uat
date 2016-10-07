CREATE TABLE IF NOT EXISTS `member_favorite` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MemberID` int(11) NOT NULL,
  `ListingID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
