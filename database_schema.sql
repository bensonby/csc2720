CREATE TABLE IF NOT EXISTS users (
id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(10) NOT NULL,
password VARCHAR(32) NOT NULL,
is_admin INTEGER NOT NULL DEFAULT 0
);
INSERT INTO users VALUES ('', 'user1',  'e58c4a0dcfacb433b62efaa52be54cc8', 0),
                         ('', 'user2',  'e58c4a0dcfacb433b62efaa52be54cc8', 0),
                         ('', 'admin1', 'e58c4a0dcfacb433b62efaa52be54cc8', 1),
                         ('', 'admin2', 'e58c4a0dcfacb433b62efaa52be54cc8', 1);

CREATE TABLE IF NOT EXISTS products (
id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(50) NOT NULL,
description VARCHAR(1024) NOT NULL,
price DOUBLE NOT NULL
);
INSERT INTO products VALUES (1, 't-shirt', 'T-shirt', 10),
                            (2, 'cup', 'Cup', 20), 
                            (3, 'cap', 'Cap', 30);
-- t-shirt: image, size, color, image location, image size
-- cup: image, size, color, handle style
-- hat: image, size, color, text

CREATE TABLE IF NOT EXISTS orders (
id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
user_id INTEGER NOT NULL,
status VARCHAR(15) NOT NULL, -- incomplete, completed
time TIMESTAMP NOT NULL,
name VARCHAR(50),
address VARCHAR(100),
email VARCHAR(256),
phone VARCHAR(20),
price DOUBLE NOT NULL
);

CREATE TABLE IF NOT EXISTS order_products (
id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
order_id INTEGER NOT NULL,
cus_product_id INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS cus_products (
id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
product_id INTEGER NOT NULL,
quantity INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS attrs (
id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
cus_product_id INTEGER NOT NULL,
attr_name VARCHAR(20) NOT NULL,
attr_value VARCHAR(250) NOT NULL
);

CREATE TABLE IF NOT EXISTS images(
id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
path VARCHAR(100) NOT NULL,  
owner INTEGER NOT NULL -- 0: company, others: user_id
)
