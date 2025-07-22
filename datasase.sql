-- DROP and CREATE DATABASE
DROP DATABASE IF EXISTS online_store;
CREATE DATABASE online_store;
USE online_store;

-- USERS
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0
);

-- PRODUCTS
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(255),
    category VARCHAR(50),
    stock INT DEFAULT 0
);

-- CART
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- ORDERS
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10,2),
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ORDER ITEMS
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- REVIEWS
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    user_id INT,
    rating INT,
    review TEXT,
    review_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


-- Find and drop the foreign key for order_id
ALTER TABLE order_items DROP FOREIGN KEY order_items_ibfk_1;

-- Re-add it with ON DELETE CASCADE
ALTER TABLE order_items
  ADD CONSTRAINT order_items_ibfk_1
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE;

-- Data
-- Mice (category: Accessories)
INSERT INTO products (name, description, price, image_url, category, stock) VALUES
('Dell Inspiron Laptop', '15.6" FHD, Intel i5, 8GB RAM, 512GB SSD', 699.99, 'assets/images/laptop1.jpg', 'Laptops', 10),
('Lenovo ThinkPad', '14" HD, Intel i7, 16GB RAM, 1TB SSD', 999.99, 'assets/images/laptop2.jpg', 'Laptops', 7),
('Corsair Vengeance RAM', '16GB DDR4 3200MHz', 79.99, 'assets/images/ram.jpg', 'Memories', 25),
('Nvidia GeForce RTX 3060', '12GB GDDR6 Graphics Card', 329.99, 'assets/images/rtx3060.jpg', 'Graphic Cards', 5),
('Logitech Mouse', 'Wireless optical mouse', 19.99, 'assets/images/mouse.jpg', 'Accessories', 40),
('HP Desktop Tower', 'Intel i5, 8GB RAM, 1TB HDD', 599.99, 'assets/images/desktop1.jpg', 'Desktops', 4);

INSERT INTO products (name, description, price, image_url, category, stock) VALUES
('Wired Logitech Gaming Mouse', 'High-precision wired gaming mouse with programmable buttons and RGB lighting.', 39.99, 'assets/images/mouse1.jpg', 'Accessories', 25),
('Wireless Logitech Mouse', 'Wireless optical mouse with fast scrolling and long battery life.', 29.99, 'assets/images/mouse2.jpg', 'Accessories', 30),
('Apple Magic Mouse', 'Sleek multi-touch wireless mouse designed for Apple devices.', 79.99, 'assets/images/mouse3.jpg', 'Accessories', 18),
('HyperX Wired Mouse', 'HyperX wired mouse with ergonomic design and customizable DPI.', 34.99, 'assets/images/mouse4.jpg', 'Accessories', 20),
('Wireless Office Mouse', 'Reliable wireless mouse ideal for everyday office use.', 19.99, 'assets/images/mouse5.jpg', 'Accessories', 40);

-- Laptops (category: Laptops)
INSERT INTO products (name, description, price, image_url, category, stock) VALUES
('DELL Laptop', 'Dell laptop with 15.6" display, Intel Core i5 processor, 8GB RAM, and 256GB SSD.', 649.99, 'assets/images/dell.jpg', 'Laptops', 10),
('Huawei Laptop', 'Huawei laptop featuring slim design, 14" FHD display, and fast charging.', 749.99, 'assets/images/huawei.jpg', 'Laptops', 8),
('ASUS Laptop', 'ASUS laptop with AMD Ryzen 7, 16GB RAM, 512GB SSD, and backlit keyboard.', 849.99, 'assets/images/asus.jpg', 'Laptops', 12),
('Macbook Pro', 'Apple MacBook Pro with M2 chip, 13" Retina display, and 512GB SSD.', 1299.99, 'assets/images/macbook.jpg', 'Laptops', 6),
('Microsoft Surface Hub', 'Microsoft Surface Hub 2, 13.5" touchscreen, Intel Core i7, 16GB RAM.', 1399.99, 'assets/images/surface.jpg', 'Laptops', 5);

-- RAM/Storage (category: Memories)
INSERT INTO products (name, description, price, image_url, category, stock) VALUES
('XPG DDR5 RAM', 'XPG 16GB DDR5 RAM module, 5200MHz, perfect for gaming and multitasking.', 99.99, 'assets/images/xpg.jpg', 'Memories', 15),
('SEGATE 1TB RAM', 'Seagate 1TB external portable RAM drive for fast data transfers.', 119.99, 'assets/images/seagate.jpg', 'Memories', 10),
('HyperX DDR4 RAM', 'HyperX Fury 8GB DDR4 3200MHz RAM with heat spreader.', 44.99, 'assets/images/hyperx.jpg', 'Memories', 20),
('Transcend RAM', 'Transcend 8GB DDR4 SO-DIMM RAM for laptops and ultrabooks.', 39.99, 'assets/images/transcend.jpg', 'Memories', 14);
