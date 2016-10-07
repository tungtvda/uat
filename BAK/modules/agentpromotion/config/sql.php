CREATE TABLE IF NOT EXISTS `agent_promotion` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `AgentID` int(11) NOT NULL,
  `Title` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Position` int(10) NOT NULL,
  `First` int(2) NOT NULL,
  `Enabled` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;