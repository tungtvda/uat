CREATE TABLE IF NOT EXISTS `order` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Subtotal` float(44,2) NOT NULL,
  `Discounts` float(44,2) NOT NULL,
  `Charges` float(44,2) NOT NULL,
  `Shipping` float(44,2) NOT NULL,
  `Tax` float(44,2) NOT NULL,
  `Total` float(44,2) NOT NULL,
  `OrderDate` date NOT NULL,
  `DeliveryMethod` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Remarks` longtext COLLATE utf8_unicode_ci NOT NULL,
  `PaymentMethod` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(3) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
