INSERT INTO `orders` (`id`, `user_id`, `status`, `time`, `name`, `address`, `email`, `phone`, `price`) VALUES (NULL, '1', 'created', '2010-05-18 19:13:43', NULL, NULL, NULL, NULL, '0.0');

INSERT INTO `orders` (`id`, `user_id`, `status`, `time`, `name`, `address`, `email`, `phone`, `price`) VALUES (NULL, '2', 'created', '2010-05-18 19:15:25', NULL, NULL, NULL, NULL, '0.0');

INSERT INTO `order_products` (`id`, `order_id`, `cus_product_id`) VALUES (NULL, '1', '1');

INSERT INTO `order_products` (`id`, `order_id`, `cus_product_id`) VALUES (NULL, '1', '2');

INSERT INTO `order_products` (`id`, `order_id`, `cus_product_id`) VALUES (NULL, '2', '3');

INSERT INTO `cus_products` (`id`, `product_id`, `quantity`) VALUES (NULL, '1', '2');

INSERT INTO `cus_products` (`id`, `product_id`, `quantity`) VALUES (NULL, '3', '1');

INSERT INTO `cus_products` (`id`, `product_id`, `quantity`) VALUES (NULL, '3', '4');

INSERT INTO `attrs` (`id`, `cus_product_id`, `attr_name`, `attr_value`) VALUES (NULL, '2', 'size', 'Large');

INSERT INTO `attrs` (`id`, `cus_product_id`, `attr_name`, `attr_value`) VALUES (NULL, '2', 'text', 'text on cap');

INSERT INTO `attrs` (`id`, `cus_product_id`, `attr_name`, `attr_value`) VALUES (NULL, '3', 'color', 'Red');
