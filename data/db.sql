
-- -----------------------------------------------------
-- Table `wordpress`.`wp_studiumpay_purchasers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wordpress`.`wp_studiumpay_purchasers` (
  `name` VARCHAR(60) NOT NULL,
  `email` VARCHAR(320) NOT NULL,
  `surname` VARCHAR(60) NOT NULL,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` INT(11) NOT NULL,
  `valid` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`));

-- -----------------------------------------------------
-- Table `wordpress`.`wp_studiumpay_orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wordpress`.`wp_studiumpay_orders` (
  `id` INT(11) NOT NULL,
  `order` VARCHAR(500) NOT NULL,
  `valid` TINYINT(1) NOT NULL DEFAULT 0,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`));
