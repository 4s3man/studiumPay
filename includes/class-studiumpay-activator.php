<?php

/**
 * Fired during plugin activation
 *
 * @link       www.dono.ls
 * @since      1.0.0
 *
 * @package    Studiumpay
 * @subpackage Studiumpay/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Studiumpay
 * @subpackage Studiumpay/includes
 * @author     Jakub Kułaga <kuba.kulaga.sv7@gmail.com>
 */
class Studiumpay_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		$sql_purchasers = 'CREATE TABLE IF NOT EXISTS `wordpress`.`wp_studiumpay_purchaser` (
		  `id` INT(11) NOT NULL,
		  `name` VARCHAR(45) NOT NULL,
		  `surname` VARCHAR(45) NOT NULL,
		  `email` VARCHAR(45) NOT NULL,
		  `current_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `valid` TINYINT(1) NOT NULL DEFAULT 0,
		  `language` VARCHAR(45) NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE INDEX `email_UNIQUE` (`email` ASC)) '. $charset_collate .';';


			$sql_orders = 'CREATE TABLE IF NOT EXISTS `wordpress`.`wp_studiumpay_order` (
			  `id` INT(11) NOT NULL,
			  `purchaser_id` INT(11) NOT NULL,
			  `amount` INT(11) NOT NULL,
			  `crc` VARCHAR(60) NOT NULL,
			  `current_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `valid` TINYINT(1) NOT NULL DEFAULT 0,
			  PRIMARY KEY (`id`)) '. $charset_collate .';';

			$sql_details = 'CREATE TABLE IF NOT EXISTS `wordpress`.`wp_studiumpay_detail` (
			  `id` INT(11) NOT NULL AUTO_INCREMENT,
			  `event_id` INT(11) NOT NULL,
			  `order_id` INT(11) NOT NULL,
			  `quantity` INT(11) NOT NULL,
			  `valid` TINYINT(1) NOT NULL DEFAULT 0,
			  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)) '. $charset_collate .';';

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql_purchasers);
		dbDelta($sql_orders);
		dbDelta($sql_details);
	}
}
