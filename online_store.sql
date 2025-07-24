-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 24, 2025 at 10:12 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `order_date`) VALUES
(3, 6, 159.98, '2025-07-22 17:44:05'),
(4, 6, 739.98, '2025-07-22 18:16:41'),
(5, 6, 799.97, '2025-07-22 18:23:33'),
(6, 7, 109.98, '2025-07-22 18:43:20'),
(7, 5, 19.99, '2025-07-22 18:44:15'),
(8, 7, 29.99, '2025-07-22 18:49:04');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(4, 3, 3, 1, 79.99),
(5, 3, 26, 1, 79.99),
(6, 4, 1, 1, 699.99),
(7, 4, 24, 1, 39.99),
(8, 5, 1, 1, 699.99),
(9, 5, 39, 1, 69.99),
(10, 5, 25, 1, 29.99),
(11, 6, 39, 1, 69.99),
(12, 6, 24, 1, 39.99),
(13, 7, 28, 1, 19.99),
(14, 8, 25, 1, 29.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `category`, `stock`) VALUES
(1, 'Dell Inspiron Laptop', '15.6\" FHD, Intel i5, 8GB RAM, 512GB SSD', 699.99, 'assets/images/laptop1.jpg', 'Laptops', 8),
(2, 'Lenovo ThinkPad', '14\" HD, Intel i7, 16GB RAM, 1TB SSD', 999.99, 'assets/images/laptop2.jpg', 'Laptops', 7),
(3, 'Corsair Vengeance RAM', '16GB DDR4 3200MHz', 79.99, 'assets/images/ram.jpg', 'Memories', 24),
(4, 'Nvidia GeForce RTX 3060', '12GB GDDR6 Graphics Card', 329.99, 'assets/images/rtx3060.jpg', 'Graphic Cards', 5),
(5, 'Logitech Mouse', 'Wireless optical mouse', 19.99, 'assets/images/mouse.jpg', 'Accessories', 39),
(6, 'HP Desktop Tower', 'Intel i5, 8GB RAM, 1TB HDD', 599.99, 'assets/images/desktop1.jpg', 'Desktops', 2),
(7, 'Dell Mouse', 'Wireless Dell Mouse', 59.00, 'assets/images/dellmouse.jpg', 'Accessories', 20),
(24, 'Wired Logitech Gaming Mouse', 'High-precision wired gaming mouse with programmable buttons and RGB lighting.', 39.99, 'assets/images/mouse1.jpg', 'Accessories', 23),
(25, 'Wireless Logitech Mouse', 'Wireless optical mouse with fast scrolling and long battery life.', 29.99, 'assets/images/mouse2.jpg', 'Accessories', 28),
(26, 'Apple Magic Mouse', 'Sleek multi-touch wireless mouse designed for Apple devices.', 79.99, 'assets/images/mouse3.jpg', 'Accessories', 17),
(27, 'HyperX Wired Mouse', 'HyperX wired mouse with ergonomic design and customizable DPI.', 34.99, 'assets/images/mouse4.jpg', 'Accessories', 20),
(28, 'Wireless Office Mouse', 'Reliable wireless mouse ideal for everyday office use.', 19.99, 'assets/images/mouse5.jpg', 'Accessories', 39),
(29, 'DELL Laptop', 'Dell laptop with 15.6\" display, Intel Core i5 processor, 8GB RAM, and 256GB SSD.', 649.99, 'assets/images/dell.jpg', 'Laptops', 10),
(30, 'Huawei Laptop', 'Huawei laptop featuring slim design, 14\" FHD display, and fast charging.', 749.99, 'assets/images/huawei.jpg', 'Laptops', 8),
(31, 'ASUS Laptop', 'ASUS laptop with AMD Ryzen 7, 16GB RAM, 512GB SSD, and backlit keyboard.', 849.99, 'assets/images/asus.jpg', 'Laptops', 12),
(32, 'Macbook Pro', 'Apple MacBook Pro with M2 chip, 13\" Retina display, and 512GB SSD.', 1299.99, 'assets/images/macbook.jpg', 'Laptops', 6),
(33, 'Microsoft Surface Hub', 'Microsoft Surface Hub 2, 13.5\" touchscreen, Intel Core i7, 16GB RAM.', 1399.99, 'assets/images/surface.jpg', 'Laptops', 5),
(34, 'XPG DDR5 RAM', 'XPG 16GB DDR5 RAM module, 5200MHz, perfect for gaming and multitasking.', 99.99, 'assets/images/xpg.jpg', 'Memories', 15),
(35, 'SEGATE 1TB RAM', 'Seagate 1TB external portable RAM drive for fast data transfers.', 119.99, 'assets/images/seagate.jpg', 'Memories', 10),
(36, 'HyperX DDR4 RAM', 'HyperX Fury 8GB DDR4 3200MHz RAM with heat spreader.', 44.99, 'assets/images/hyperx.jpg', 'Memories', 20),
(37, 'Transcend RAM', 'Transcend 8GB DDR4 SO-DIMM RAM for laptops and ultrabooks.', 39.99, 'assets/images/transcend.jpg', 'Memories', 14),
(38, 'Apple Magic Keyboard', 'Ultra-thin wireless keyboard designed for Apple devices with a rechargeable battery.', 99.99, 'assets/images/keyboard1.jpg', 'Accessories', 20),
(39, 'Gaming Keyboard', 'RGB mechanical gaming keyboard with programmable keys and anti-ghosting.', 69.99, 'assets/images/keyboard2.jpg', 'Accessories', 16),
(40, 'Wired Keyboard', 'Reliable full-size wired keyboard with comfortable keys and spill-resistant design.', 24.99, 'assets/images/keyboard3.jpg', 'Accessories', 25);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `review_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_admin`) VALUES
(5, 'admin', 'admin@admin.com', '$2y$10$s8fER6.6vIbdwyuXykHOgOb6IX8l5IKeg0iO81QXSgPMadsLl5AjO', 1),
(6, 'User', 'user@user.com', '$2y$10$z/L5xHWbeCaX.VQYJntUKeSxM31CxPFNua8Gn//zsfkrnutgJnaQC', 0),
(7, 'Ben Kam', 'ben@gmail.com', '$2y$10$5H5k7ScVk3PNSfwPTy5DrOK7rA09Fn4/QeT3aC/LPvMVginoBKbCm', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `cart_ibfk_1` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_items_ibfk_1` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `reviews_ibfk_2` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
