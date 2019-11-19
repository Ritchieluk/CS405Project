use TOYS_ORDERS;
drop table PEOPLE;
drop table INVENTORY;

create table PEOPLE (
    PERSON_ID INT PRIMARY KEY,
    PERSON_TYPE INT,
    USERNAME VARCHAR(100),
    PW VARCHAR(100)
);

create table INVENTORY (
    INVENTORY_ID INT PRIMARY KEY,
    AMOUNT INT,
    PRICE FLOAT,
    USERNAME VARCHAR(100)
);

create table ORDERS (
    ORDER_ID INT,
    INVENTORY_ID INT,
    PERSON_ID INT,
    ORDER_STATUS VARCHAR(100),
    QUANTITY INT,

    primary key (ORDER_ID, INVENTORY_ID)
);

create table PROMOTIONS (
    PROMOTION_ID INT PRIMARY KEY,
    INVENTORY_ID INT,
    AMOUNT INT
);
