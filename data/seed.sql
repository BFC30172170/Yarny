-- DATABASE
DROP DATABASE IF EXISTS ecommerce;
CREATE DATABASE ecommerce;
USE ecommerce;


-- USER
DROP USER IF EXISTS 'ecommadmin'@'localhost';
CREATE USER 'ecommadmin'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON ecommerce.* TO 'ecommadmin'@'localhost';

-- TABLES
CREATE TABLE Product (
    PRODUCT_ID int AUTO_INCREMENT,
    PRODUCT_SLUG varchar(50) NOT NULL,
    PRODUCT_NAME varchar(200) NOT NULL,
    PRODUCT_DESCRIPTION varchar(2000) NULL,
    PRODUCT_PRICE decimal(10,2) NULL,
    PRODUCT_IMG_PATH varchar(2000) NULL,
    CATEGORY_ID int NULL,
    PRODUCT_ACTIVE boolean NOT NULL,
    PRIMARY KEY (PRODUCT_ID)
);

CREATE TABLE Category (
    CATEGORY_ID int AUTO_INCREMENT,
    CATEGORY_NAME varchar(50) NOT NULL,
    CATEGORY_DESCRIPTION varchar(2000) NULL,
    PARENT_ID int NULL, 
    PRIMARY KEY (CATEGORY_ID)
);

CREATE TABLE Tag (
    TAG_ID int AUTO_INCREMENT,
    TAG_NAME varchar(50) NOT NULL,
    TAG_DESCRIPTION varchar(1000) NOT NULL,
    PRIMARY KEY (TAG_ID)
);

CREATE TABLE Product_tag (
    PT_ID int AUTO_INCREMENT,
    PRODUCT_ID int NOT NULL,
    TAG_ID int NOT NULL,
    PRIMARY KEY (PT_ID)
);

CREATE TABLE Sale(
    SALE_ID int AUTO_INCREMENT,
    SALE_CREATED datetime NULL,
    SALE_PROCESSED datetime NULL,
    SALE_DISPATCHED datetime NULL,
    SALE_ESTIMATED_ARRIVAL datetime NULL,
    SALE_STATUS varchar(10) NULL,
    ACCOUNT_ID int NOT NULL,
    ADDRESS_ID int NOT NULL,
    PRIMARY KEY (SALE_ID)
);

CREATE TABLE Sale_row(
    SR_ID int AUTO_INCREMENT,
    SR_ORIG_PRICE decimal(10,2) NOT NULL,
    SR_FINAL_PRICE decimal(10,2) NOT NULL,
    SR_QUANTITY int NOT NULL,
    SALE_ID int NOT NULL,
    PRODUCT_ID int NOT NULL,
    PRIMARY KEY (SR_ID)
);

CREATE TABLE Account(
    ACCOUNT_ID int AUTO_INCREMENT,
    ACCOUNT_NAME varchar(50) NOT NULL,
    ACCOUNT_HASHEDPASS varchar(2000) NOT NULL,
    ACCOUNT_ROLE varchar(50) NOT NULL,
    ACCOUNT_EMAIL varchar(200) NOT NULL,
    ACCOUNT_TELEPHONE varchar(20) NULL,
    ACCOUNT_MOBILE varchar(20) NULL,
    ACCOUNT_CREATED datetime NULL,
    PRIMARY KEY (ACCOUNT_ID)
);

CREATE TABLE Review(
    REVIEW_ID int AUTO_INCREMENT,
    REVIEW_NAME varchar(50) NOT NULL,
    REVIEW_DESCRIPTION varchar(2000) NOT NULL,
    REVIEW_SCORE tinyint NOT NULL,
    REVIEW_CREATED datetime NULL,
    REVIEW_ACTIVE boolean,
    PRODUCT_ID int NOT NULL,
    ACCOUNT_ID int NOT NULL,
    PRIMARY KEY (REVIEW_ID)
);

CREATE TABLE Address(
    ADDRESS_ID int AUTO_INCREMENT,
    ADDRESS_FORENAME varchar(40) NOT NULL,
    ADDRESS_SURNAME varchar(40) NOT NULL,
    ADDRESS_LINE_1 varchar(100) NOT NULL,
    ADDRESS_LINE_2 varchar(100) NULL,
    ADDRESS_LINE_3 varchar(100) NULL,
    ADDRESS_TOWN varchar(100) NULL,
    ADDRESS_POSTCODE varchar(20) NOT NULL,
    ADDRESS_COUNTRY varchar(20) NOT NULL,
    ACCOUNT_ID int NOT NULL,
    PRIMARY KEY (ADDRESS_ID)
);

-- RELATIONSHIPS
ALTER TABLE Product
  ADD CONSTRAINT `FK_PRODUCT_CATEGORY` FOREIGN KEY (`CATEGORY_ID`) REFERENCES `Category` (`CATEGORY_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Category
  ADD CONSTRAINT `FK_CATEGORY_PARENT` FOREIGN KEY (`PARENT_ID`) REFERENCES `Category` (`CATEGORY_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Product_tag
  ADD CONSTRAINT `FK_PT_PRODUCT` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `Product` (`PRODUCT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PT_TAG` FOREIGN KEY (`TAG_ID`) REFERENCES `Tag` (`TAG_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Sale_row
  ADD CONSTRAINT `FK_SR_SALE` FOREIGN KEY (`SALE_ID`) REFERENCES `SALE` (`SALE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SR_PRODUCT` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `Product` (`PRODUCT_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Sale
  ADD CONSTRAINT `FK_SALE_ACCOUNT` FOREIGN KEY (`ACCOUNT_ID`) REFERENCES `Account` (`ACCOUNT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SALE_ADDRESS` FOREIGN KEY (`ADDRESS_ID`) REFERENCES `Address` (`ADDRESS_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Review
  ADD CONSTRAINT `FK_REVIEW_PRODUCT` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `Product` (`PRODUCT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_REVIEW_ACCOUNT` FOREIGN KEY (`ACCOUNT_ID`) REFERENCES `Account` (`ACCOUNT_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- SEED
INSERT INTO Category (CATEGORY_NAME,CATEGORY_DESCRIPTION,PARENT_ID) VALUES ('Wool', 'All Wool Products', NULL);
INSERT INTO Category (CATEGORY_NAME,CATEGORY_DESCRIPTION,PARENT_ID) VALUES ('Needles', 'All Needle Products', NULL);

INSERT INTO Product (PRODUCT_SLUG,PRODUCT_NAME,PRODUCT_DESCRIPTION,PRODUCT_PRICE,PRODUCT_IMG_PATH,CATEGORY_ID,PRODUCT_ACTIVE) VALUES ('Green Wool', 'Super Chunky Green Wool', 'This is green wool and is very thick. It is good.',1.99,'https://media.istockphoto.com/id/918294950/photo/clew-of-green-thread-for-knitting-isolated-on-white-background.jpg?b=1&s=170667a&w=0&k=20&c=V8rU9H67ebDB3Cs1d4ShLkRaZ7apUaoip8RjkSH3cBs=',1,1);
INSERT INTO Product (PRODUCT_SLUG,PRODUCT_NAME,PRODUCT_DESCRIPTION,PRODUCT_PRICE,PRODUCT_IMG_PATH,CATEGORY_ID,PRODUCT_ACTIVE) VALUES ('Blue Wool', 'Super Chunky Blue Wool', 'This is blue wool and is very thick. It is good.',2.99,'https://www.hibiscus-plc.co.uk/wp-content/uploads/2017/01/blue-wool-scale-2.jpg',1,1);
INSERT INTO Product (PRODUCT_SLUG,PRODUCT_NAME,PRODUCT_DESCRIPTION,PRODUCT_PRICE,PRODUCT_IMG_PATH,CATEGORY_ID,PRODUCT_ACTIVE) VALUES ('Yellow Wool', 'Super Chunky Yellow Wool', 'This is yellow wool and is very thick. It is good.',0.99,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQExfU05wJ5bgvDbWx81J1fhvjHEs5SHm-ffnRR84L2U4RpeQCWvp8RGw9ggk0ZyRiv98c:https://www.woolwarehouse.co.uk/media/catalog/product/cache/1/image/330x220/9df78eab33525d08d6e5fb8d27136e95/r/h/rh_9809670_08217_0.jpg&usqp=CAU',1,1);
INSERT INTO Product (PRODUCT_SLUG,PRODUCT_NAME,PRODUCT_DESCRIPTION,PRODUCT_PRICE,PRODUCT_IMG_PATH,CATEGORY_ID,PRODUCT_ACTIVE) VALUES ('Knitting needles', '9mm Bamboo Knitting needles', 'This is a pair of 9mm Bamboo Knitting needles, they are very nice.',4.99,'https://images.unsplash.com/photo-1513891270183-1df0366c9f22?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80',2,1);

INSERT INTO Tag (TAG_NAME,TAG_DESCRIPTION) VALUES ('Yellow','An Item which is the colour yellow.');
INSERT INTO Tag (TAG_NAME,TAG_DESCRIPTION) VALUES ('Blue','An Item which is the colour blue.');

INSERT INTO Product_tag(PRODUCT_ID,TAG_ID) VALUES (3,1);
INSERT INTO Product_tag(PRODUCT_ID,TAG_ID) VALUES (2,2);

INSERT INTO Account(ACCOUNT_NAME,ACCOUNT_HASHEDPASS,ACCOUNT_ROLE,ACCOUNT_EMAIL,ACCOUNT_TELEPHONE,ACCOUNT_MOBILE) VALUES('test','$2y$10$LzESCv9NyvnVrBsmSbaKCuw9sZCTDCGvXMbEweSb/oTHxElseq/ky','user','test@testing.org','0123345324','013819242');

INSERT INTO Address(ADDRESS_FORENAME,ADDRESS_SURNAME,ADDRESS_LINE_1,ADDRESS_POSTCODE,ADDRESS_COUNTRY,ACCOUNT_ID) VALUES('Tess','Ting','10 Test Road','MK18 4RP','United Kingdom',1);

INSERT INTO Sale(SALE_STATUS,ACCOUNT_ID,ADDRESS_ID) VALUES ('created',1,1);

INSERT INTO Sale_row(SR_ORIG_PRICE,SR_FINAL_PRICE,SR_QUANTITY,SALE_ID,PRODUCT_ID) VALUES (1.99,1.99,3,1,1);
INSERT INTO Sale_row(SR_ORIG_PRICE,SR_FINAL_PRICE,SR_QUANTITY,SALE_ID,PRODUCT_ID) VALUES (2.99,2.99,1,1,2);
