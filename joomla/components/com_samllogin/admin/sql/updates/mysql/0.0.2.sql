CREATE TABLE IF NOT EXISTS `#__LoginTokens` (
    `token` VARCHAR(63) NOT NULL,
    `user_id` INT NOT NULL UNIQUE,
    `exp` TIMESTAMP NOT NULL,
    PRIMARY KEY (`token`),
    FOREIGN KEY (`user_id`) REFERENCES `#__users`(id)
);
