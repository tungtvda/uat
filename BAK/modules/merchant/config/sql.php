CREATE TABLE IF NOT EXISTS `merchant` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `GenderID` int(2) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CompanyRegNo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `DOB` date NOT NULL,
  `NRIC` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Passport` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Nationality` int(10) NOT NULL,
  `Username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CookieHash` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `PhoneNo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `FaxNo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `MobileNo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Prompt` int(2) NOT NULL,
  `PromptStage` int(2) NOT NULL,
  `Enabled` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
