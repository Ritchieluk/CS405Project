use TOYS_ORDERS;

INSERT INTO INVENTORY (AMOUNT, PRICE, PRODUCT_NAME, PRODUCT_DESC)
VALUES (40, 7.99, 'Big Boi Transformer', 'This big ol boi can transform into the biggest of trucks, the largest of cars, and only the most gargantuan of vehicles. Buyer beware. It may or may not be cursed to also transform your life.');

INSERT INTO INVENTORY (AMOUNT, PRICE, PRODUCT_NAME, PRODUCT_DESC)
VALUES (20, 12.99, 'Polly Hot Pocket', 'This adorable little doll is also the perfect microwavable treat. Just pop it in the microwave and then stick it in your mouth pocket');

INSERT INTO INVENTORY (AMOUNT, PRICE, PRODUCT_NAME, PRODUCT_DESC)
VALUES (20, 89.99, 'A Singular Lego Brick', 'Add this extremely brick to your collection. Guaranteed to destroy your feet, your social life, and your pocketbook or your money back.');

INSERT INTO INVENTORY (AMOUNT, PRICE, PRODUCT_NAME, PRODUCT_DESC)
VALUES (30, 2.99, 'Ben 10 Omnitrix', '100% not FDA approved. But we somehow got it to work, just all the DNA is faulty and WILL cause dogs in a 1 mile radius to become feral');

INSERT INTO INVENTORY (AMOUNT, PRICE, PRODUCT_NAME, PRODUCT_DESC)
VALUES (23, 37.99, 'Barbies Barbecue Backyard By the Backyardigans', 'BYOB, working grill and raw steak (we promise) included.');

INSERT INTO INVENTORY (AMOUNT, PRICE, PRODUCT_NAME, PRODUCT_DESC)
VALUES (17, 75.99, 'Difficult-Bake Oven', 'Your parents will end up doing it for you. They will get frustrated. They will get divorced. It will be your fault.');

INSERT INTO INVENTORY (AMOUNT, PRICE, PRODUCT_NAME, PRODUCT_DESC)
VALUES (29, 27.99, 'Duplos, but Actually Kinda Cool TBH', 'You lowkey want to buy this, but can your social image afford being associated with Duplos?');

INSERT INTO INVENTORY (AMOUNT, PRICE, PRODUCT_NAME, PRODUCT_DESC)
VALUES (30, 27.99, 'An Actual Hunting Knife', 'We''re one of those stores that has a hunting section in the back for some reason. Perfect gift for your grandaughter.');

INSERT INTO INVENTORY (AMOUNT, PRICE, PRODUCT_NAME, PRODUCT_DESC)
VALUES (27, 8.99, 'Pokemon Greeting Cards', 'For when you need the perfect card to tell someone: I''m leaving you.');

INSERT INTO INVENTORY (AMOUNT, PRICE, PRODUCT_NAME, PRODUCT_DESC)
VALUES (11, 7.99, 'MASSIVE Wheels', 'The perfect toy for any child who wants to absolutely obliterate the other kids and their puny big wheels. With MASSIVE Wheels your child will turn his enemies into a fine pulp');

insert into PEOPLE (PERSON_TYPE, USERNAME, PW) VALUES (1, 'user', 'pw');
insert into PEOPLE (PERSON_TYPE, USERNAME, PW) values (1, 'guy', 'pw');
insert into PEOPLE (PERSON_TYPE, USERNAME, PW) VALUES (2, 'employee', 'pw');
insert into PEOPLE (PERSON_TYPE, USERNAME, PW) VALUES (3, 'manager', 'pw');

insert into ORDERS values (1, 1, 1, 'pending', 1);
insert into ORDERS values (1, 2, 1, 'pending', 1);
insert into ORDERS values (2, 4, 4, 'shipped', 3);
insert into ORDERS values (3, 6, 1, 'completed', 2);

insert into PROMOTIONS (INVENTORY_ID, AMOUNT) values (1, 10);
insert into PROMOTIONS (INVENTORY_ID, AMOUNT) values (5, 18);
insert into PROMOTIONS (INVENTORY_ID, AMOUNT) values (8, 69);

insert into CART values (2, 1, 1);
insert into CART values (3, 2, 2);
insert into CART values (8, 15, 1);
