/*
  Run this script on a database named "trading_post" to create the database for the Trading Post
*/

DROP TABLE IF EXISTS listing;
DROP TABLE IF EXISTS `account`;

CREATE TABLE `account`(
	accountID	INT(11) AUTO_INCREMENT NOT NULL,
    `name`		VARCHAR(255),
    `password`	VARCHAR(60), # length of PHP hashed password
    lastIPAddress	VARCHAR(15), # IPv4
    
    CONSTRAINT account_PK PRIMARY KEY (accountID)    
);

CREATE TABLE listing (
	listingID	INT(11) AUTO_INCREMENT NOT NULL,
    accountID	INT(11),
    `date`		DATE,
    title		VARCHAR(255),
    description	VARCHAR(1000),
    quantity	INT(11),
    price		DOUBLE(11,2),
    barter		INT(11),
    image		VARCHAR(1000),
    
    CONSTRAINT listing_PK PRIMARY KEY (listingID),
    CONSTRAINT listing_FK FOREIGN KEY (accountID) REFERENCES `account`(accountID)
);