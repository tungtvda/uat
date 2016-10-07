CREATE TABLE IF NOT EXISTS `config` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ConfigName` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ConfigValue` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
