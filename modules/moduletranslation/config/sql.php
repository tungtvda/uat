CREATE TABLE IF NOT EXISTS `module_translation` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ModuleID` int(11) NOT NULL,
  `LanguageID` int(11) NOT NULL,
  `RowID` int(10) NOT NULL,
  `Content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;