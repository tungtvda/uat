CREATE TABLE IF NOT EXISTS `menu_item` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MenuID` int(11) NOT NULL,
  `ParentID` int(11) NOT NULL,
  `Title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LinkURL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Position` int(5) NOT NULL,
  `Enabled` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
