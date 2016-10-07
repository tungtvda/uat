CREATE TABLE IF NOT EXISTS `bank` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Enabled` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;