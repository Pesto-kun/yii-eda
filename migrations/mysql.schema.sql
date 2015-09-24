#Файлы
CREATE TABLE `file` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '1',
  `created` TIMESTAMP NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `filemime` varchar(255) NOT NULL,
  `filesize` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

#Города
CREATE TABLE `city` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

#Тип еды
CREATE TABLE `food_type` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `system_name` varchar(255) NOT NULL,
  `image_id` int(11) UNSIGNED,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
ALTER TABLE `food_type`
    ADD CONSTRAINT `food_type_image`
    FOREIGN KEY (`image_id`)
    REFERENCES `file` (`id`)
    ON DELETE SET NULL;

#Заведение
CREATE TABLE `restaurant` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '1',
  `order_available` int(1) NOT NULL DEFAULT '1',
  `city_id` int(11) UNSIGNED,
  `name` varchar(255) NOT NULL,
  `system_name` varchar(255) NOT NULL,
  `image_id` int(11) UNSIGNED,
  `rating` int(1) UNSIGNED,
  `work_time` varchar(255),
  `delivery_price` decimal(10,2) NOT NULL,
  `delivery_free` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
ALTER TABLE `restaurant`
    ADD CONSTRAINT `restaurant_city`
    FOREIGN KEY (`city_id`)
    REFERENCES `city` (`id`)
    ON DELETE SET NULL;
ALTER TABLE `restaurant`
  ADD CONSTRAINT `restaurant_image`
  FOREIGN KEY (`image_id`)
  REFERENCES `file` (`id`)
  ON DELETE SET NULL;


#Тип заведения
CREATE TABLE `restaurant_type` (
  `food_type_id` int(11) UNSIGNED,
  `restaurant_id` int(11) UNSIGNED,
  UNIQUE KEY (`food_type_id`, `restaurant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
ALTER TABLE `restaurant_type`
  ADD CONSTRAINT `restaurant_type_food_type`
  FOREIGN KEY (`food_type_id`)
  REFERENCES `food_type` (`id`)
  ON DELETE CASCADE;
ALTER TABLE `restaurant_type`
  ADD CONSTRAINT `restaurant_type_restaurant`
  FOREIGN KEY (`restaurant_id`)
  REFERENCES `restaurant` (`id`)
  ON DELETE CASCADE;

#Блюдо
CREATE TABLE `dish` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '1',
  `restaurant_id` int(11) UNSIGNED,
  `food_type_id` int(11) UNSIGNED,
  `name` varchar(255) NOT NULL,
  `image_id` int(11) UNSIGNED,
  `weight` int(11) UNSIGNED,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
ALTER TABLE `dish`
  ADD CONSTRAINT `dish_restaurant`
  FOREIGN KEY (`restaurant_id`)
  REFERENCES `restaurant` (`id`)
  ON DELETE CASCADE;
ALTER TABLE `dish`
  ADD CONSTRAINT `dish_food_type`
  FOREIGN KEY (`food_type_id`)
  REFERENCES `food_type` (`id`)
  ON DELETE SET NULL;

#Заказ
CREATE TABLE `order` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(32) NOT NULL,
  `created` TIMESTAMP NOT NULL,
  `updated` TIMESTAMP NOT NULL,
  `accepted` TIMESTAMP NOT NULL,
  `restaurant_id` int(11) UNSIGNED,
#   `delivery_method` varchar(32) NOT NULL,
#   `delivery_time` TIMESTAMP,
  `delivery_cost` decimal(10,2),
#   `payment_method` varchar(32) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
#   `city` varchar(255),
  `phone` varchar(255),
  `username` varchar(255),
  `street` varchar(255),
  `house` varchar(255),
  `apartment` varchar(255),
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
ALTER TABLE `order`
  ADD CONSTRAINT `order_restaurant`
  FOREIGN KEY (`restaurant_id`)
  REFERENCES `restaurant` (`id`)
  ON DELETE SET NULL;

#Содержимое заказа
CREATE TABLE `order_data` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int(11) UNSIGNED,
  `dish_id` int(11) UNSIGNED,
  `amount` int(11) UNSIGNED,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
ALTER TABLE `order_data`
  ADD CONSTRAINT `order_data_order`
  FOREIGN KEY (`order_id`)
  REFERENCES `order` (`id`)
  ON DELETE CASCADE;
ALTER TABLE `order_data`
  ADD CONSTRAINT `order_data_dish`
  FOREIGN KEY (`dish_id`)
  REFERENCES `dish` (`id`)
  ON DELETE SET NULL;
