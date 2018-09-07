<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.dono.ls
 * @since      1.0.0
 *
 * @package    Studiumpay
 * @subpackage Studiumpay/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Studiumpay
 * @subpackage Studiumpay/public
 * @author     Jakub Kułaga <kuba.kulaga.sv7@gmail.com>
 */
class Studiumpay_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Formidable/Form    $form
	 */
	private $form;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var
	 */
	private $przelewy24;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->form = new SP_Form_Decorator();
		$this->przelewy24 = new Przelewy24\Przelewy24();
		exit(1);
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/studiumpay-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/studiumpay-public.js', array( 'jquery' ), $this->version, false );
	}

	public function handle_payment_form(){
		$this->form->handle();
	}

	public function render_payment_form(){
		$this->form->render();
	}
}
