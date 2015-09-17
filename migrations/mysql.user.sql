#Пользователи
CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '1',
  `created` TIMESTAMP NOT NULL,
  `updated` TIMESTAMP NOT NULL,
  `last_login` TIMESTAMP NOT NULL,
  `mail` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  `access_token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
#Админ
INSERT INTO `user` VALUES (DEFAULT, 1, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(), 0, 'admin@localhost', 'Admin',
                           '$2y$13$V2N8ZfXueCpk.vUha98.6ulRIvbIEikx4k8tErIm7wDdly8o4JbUC', 'admin',
                           'jenqRbLqghdwCsr6Ia9gOK_KCFTTIxEu', 'admin-token');
