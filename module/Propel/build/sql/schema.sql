
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- account
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `account`;

CREATE TABLE `account`
(
    `id` INTEGER(3) NOT NULL AUTO_INCREMENT,
    `identifier` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255),
    `create_time` DATETIME NOT NULL,
    `update_time` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `account_U_1` (`identifier`),
    INDEX `account_I_1` (`create_time`),
    INDEX `account_I_2` (`update_time`)
) ENGINE=InnoDB COMMENT='账户表';

-- ---------------------------------------------------------------------
-- resource
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `resource`;

CREATE TABLE `resource`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `identifier` VARCHAR(255) NOT NULL,
    `type` TINYINT NOT NULL,
    `name` VARCHAR(128) NOT NULL,
    `description` TEXT,
    `create_time` DATETIME NOT NULL,
    `update_time` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `resource_U_1` (`identifier`),
    INDEX `resource_I_1` (`create_time`),
    INDEX `resource_I_2` (`update_time`)
) ENGINE=InnoDB COMMENT='资源表';

-- ---------------------------------------------------------------------
-- category
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `pid` INTEGER(4),
    `name` VARCHAR(45) NOT NULL,
    `create_time` DATETIME NOT NULL,
    `update_time` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `category_I_1` (`create_time`),
    INDEX `category_I_2` (`update_time`),
    INDEX `category_FI_1` (`pid`),
    CONSTRAINT `category_FK_1`
        FOREIGN KEY (`pid`)
        REFERENCES `category` (`id`)
) ENGINE=InnoDB COMMENT='资源类别表';

-- ---------------------------------------------------------------------
-- resource_account
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `resource_account`;

CREATE TABLE `resource_account`
(
    `resource_id` INTEGER(4) NOT NULL,
    `account_id` INTEGER(3) NOT NULL,
    `description` TEXT,
    `create_time` DATETIME NOT NULL,
    `update_time` DATETIME NOT NULL,
    PRIMARY KEY (`resource_id`,`account_id`),
    INDEX `resource_account_I_1` (`create_time`),
    INDEX `resource_account_I_2` (`update_time`),
    INDEX `resource_account_FI_2` (`account_id`),
    CONSTRAINT `resource_account_FK_1`
        FOREIGN KEY (`resource_id`)
        REFERENCES `resource` (`id`),
    CONSTRAINT `resource_account_FK_2`
        FOREIGN KEY (`account_id`)
        REFERENCES `account` (`id`)
) ENGINE=InnoDB COMMENT='资源账户关联表';

-- ---------------------------------------------------------------------
-- category_resource
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `category_resource`;

CREATE TABLE `category_resource`
(
    `category_id` INTEGER(4) NOT NULL,
    `resource_id` INTEGER(4) NOT NULL,
    `create_time` DATETIME NOT NULL,
    `update_time` DATETIME NOT NULL,
    PRIMARY KEY (`category_id`,`resource_id`),
    INDEX `category_resource_I_1` (`create_time`),
    INDEX `category_resource_I_2` (`update_time`),
    INDEX `category_resource_FI_2` (`resource_id`),
    CONSTRAINT `category_resource_FK_1`
        FOREIGN KEY (`category_id`)
        REFERENCES `category` (`id`),
    CONSTRAINT `category_resource_FK_2`
        FOREIGN KEY (`resource_id`)
        REFERENCES `resource` (`id`)
) ENGINE=InnoDB COMMENT='类别资源关联表';

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` INTEGER(4) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(25) NOT NULL,
    `nickname` VARCHAR(25) NOT NULL,
    `role_id` INTEGER(3) NOT NULL,
    `password` VARCHAR(32) NOT NULL,
    `create_time` DATETIME NOT NULL,
    `update_time` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `user_U_1` (`name`)
) ENGINE=InnoDB COMMENT='用户表';

-- ---------------------------------------------------------------------
-- session
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `session`;

CREATE TABLE `session`
(
    `id` VARCHAR(32) NOT NULL,
    `name` VARCHAR(32) NOT NULL,
    `create_time` DATETIME NOT NULL,
    `update_time` DATETIME NOT NULL,
    `data` VARCHAR(21000),
    PRIMARY KEY (`id`,`name`)
) ENGINE=MEMORY COMMENT='session';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
