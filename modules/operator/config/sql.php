CREATE TABLE IF NOT EXISTS `operator` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `AgentID` int(11) NOT NULL,
  `ProfileID` int(2) NOT NULL,
  `Enabled` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;