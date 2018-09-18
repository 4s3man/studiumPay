-- -----------------------------------------------------
-- Table `wordpress`.`wp_studiumpay_purchasers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wordpress`.`wp_studiumpay_purchasers` (
  `name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(320) NOT NULL,
  `surname` VARCHAR(45) NOT NULL,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `validation` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `wordpress`.`wp_studiumpay_orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wordpress`.`wp_studiumpay_orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `quantity` INT(11) NOT NULL,
  `tribe_event_post_id` INT(11) NOT NULL,
  `validation` TINYINT(1) NOT NULL DEFAULT 0,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `purchaser_id` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`));
