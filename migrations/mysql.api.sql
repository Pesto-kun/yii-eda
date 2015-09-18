#Таблица последнего доступа пользователя к апи
CREATE TABLE `api_user_access` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `last_access` TIMESTAMP,
  `session_id` varchar(255),
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
ALTER TABLE `api_user_access`
  ADD CONSTRAINT `api_access_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `user` (`id`)
  ON DELETE CASCADE;

#Таблица привязки пользователя к ресторану
CREATE TABLE `api_user_restaurant` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `restaurant_id` int(11) UNSIGNED NOT NULL,
  UNIQUE KEY (`user_id`, `restaurant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
ALTER TABLE `api_user_restaurant`
  ADD CONSTRAINT `api_user_restaurant_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `user` (`id`)
  ON DELETE CASCADE;
ALTER TABLE `api_user_restaurant`
  ADD CONSTRAINT `api_user_restaurant_restaurant`
  FOREIGN KEY (`restaurant_id`)
  REFERENCES `restaurant` (`id`)
  ON DELETE CASCADE;