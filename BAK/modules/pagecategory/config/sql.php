CREATE TABLE IF NOT EXISTS `page_category` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ParentID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Enabled` int(2) NOT NULL DEFAULT '0',
  `Position` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
