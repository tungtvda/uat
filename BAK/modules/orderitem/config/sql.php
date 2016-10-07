CREATE TABLE IF NOT EXISTS `order_item` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `Price` decimal(10,0) NOT NULL,
  `Quantity` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
