CREATE TABLE IF NOT EXISTS `page` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryID` int(11) NOT NULL,
  `Title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `MetaKeyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Heading` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FriendlyURL` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `TemplateID` int(11) NOT NULL,
  `DatePosted` date NOT NULL,
  `Status` int(11) NOT NULL,
  `Enabled` int(2) NOT NULL DEFAULT '0',
  `LastUpdated` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
