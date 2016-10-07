CREATE TABLE IF NOT EXISTS `transaction` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL,
  `TypeID` int(11) NOT NULL,
  `Amount` decimal(19,2) NOT NULL,
  `PaymentMethod` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `DatePosted` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
