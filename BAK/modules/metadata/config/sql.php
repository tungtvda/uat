CREATE TABLE IF NOT EXISTS `meta_data` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ModuleID` int(11) NOT NULL,
  `Section` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Controller` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Value` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
