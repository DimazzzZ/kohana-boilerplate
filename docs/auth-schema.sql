CREATE TABLE IF NOT EXISTS `roles` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(32)      NOT NULL,
  `description` VARCHAR(255)     NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

INSERT INTO `roles` (`id`, `name`, `description`)
VALUES (1, 'login', 'Login privileges, granted after account confirmation');
INSERT INTO `roles` (`id`, `name`, `description`) VALUES (2, 'admin', 'Administrative user, has access to everything.');

CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` INT(10) UNSIGNED NOT NULL,
  `role_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`, `role_id`),
  KEY `fk_role_id` (`role_id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email`      VARCHAR(254)     NOT NULL,
  `username`   VARCHAR(32)      NOT NULL DEFAULT '',
  `password`   VARCHAR(64)      NOT NULL,
  `logins`     INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `last_login` INT(10) UNSIGNED,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`    INT(11) UNSIGNED NOT NULL,
  `user_agent` VARCHAR(40)      NOT NULL,
  `token`      VARCHAR(40)      NOT NULL,
  `type`       VARCHAR(100)     NOT NULL,
  `created`    INT(10) UNSIGNED NOT NULL,
  `expires`    INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

ALTER TABLE `roles_users`
ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
  ON DELETE CASCADE,
ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
  ON DELETE CASCADE;

ALTER TABLE `user_tokens`
ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
  ON DELETE CASCADE;