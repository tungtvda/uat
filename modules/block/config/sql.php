CREATE TABLE IF NOT EXISTS `block` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `AreaID` int(11) NOT NULL,
  `TypeID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `Position` int(11) NOT NULL,
  `Enabled` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

