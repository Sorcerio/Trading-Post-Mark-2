/*
  Run this script on a database named "trading_post" to create the database for the Trading Post
*/

DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS infraction;
DROP TABLE IF EXISTS listing;
DROP TABLE IF EXISTS `account`;

CREATE TABLE `account`(
	accountID	INT(11) AUTO_INCREMENT NOT NULL,
    `name`		VARCHAR(255),
    `password`	VARCHAR(255), -- Use 60 if using 'PASSWORD_BCRYPT' or 255 if using 'PASSWORD_DEFAULT'
    email    VARCHAR(255),
    lastIPAddress	VARCHAR(15), -- IPv4
    
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
    barter	    TINYINT(1),
    
    CONSTRAINT listing_PK PRIMARY KEY (listingID),
    CONSTRAINT listing_FK FOREIGN KEY (accountID) REFERENCES `account`(accountID)
);

CREATE TABLE image (
    imageID     INT(11) AUTO_INCREMENT NOT NULL,
    listingID   INT(11),
    path        VARCHAR(1000),

    CONSTRAINT image_PK PRIMARY KEY (imageID),
    CONSTRAINT image_FK FOREIGN KEY (listingID) REFERENCES listing(listingID)
);

CREATE TABLE infraction(
    infractionID    INT  AUTO_INCREMENT NOT NULL,
    accountID    INT(11),
    description    VARCHAR(255) DEFAULT NULL,

    CONSTRAINT infraction_PK PRIMARY KEY (infractionID),
    CONSTRAINT infraction_FK FOREIGN KEY (accountID) REFERENCES  `account`(accountID)
)