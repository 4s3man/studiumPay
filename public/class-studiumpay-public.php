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
	 * The payment form
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Studiumpay_Form_Decorator    $form
	 */
	private $form;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var			 Studiumpay_Przelewy24_Decorator
	 */
	private $przelewy24;

	/**
	 * The plugin repository
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var			 Studiumpay_Repository
	 */
	private $repository;

	//todo podać to z tribe_events
	private $products = [
		[ 'id' => 1, 'post_name' => 'a', 'cost' => 100  ],
		[ 'id' => 2, 'post_name' => 'b', 'cost' => 100  ],
		[ 'id' => 3, 'post_name' => 'c', 'cost' => 100  ],
		[ 'id' => 4, 'post_name' => 'd', 'cost' => 100  ],
	];

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
		$this->form = new Studiumpay_Form_Decorator($this->products);
		$this->przelewy24 = new Studiumpay_Przelewy24_Decorator();
		$this->repository = new Studiumpay_Repository();
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

	/**
	 * Handle payment form
	 *
	 * @since    1.0.0
	 */
	public function handle_payment_form(){
		$this->form->handle(function () {
			$data = $this->form->getValues();

			$saveClientData = $this->clientPermitted($data) ? true : false;
			unset($data['data_save_agreement']);

			$this->repository->saveOrder($data);
			
			// $this->przelewy24->trnRegister($data, $this->products);




			//todo zrobić
			// $this->repository->saveOrder($data);

			//
			// //todo zrobić
			// $this->przelewy24->sendPaymentRequest();
			exit('form handle');
		});


		//powrót po transakcji
		if (isset($_GET['ok']) && '1' === $_GET['ok']) {
			var_dump($_POST);

			exit('po zakończeniu transakcji');
		}

		//todo zrobić coś z tym tak żeby było ok
		// session_regenerate_id();
	}

	/**
	 * Render payment form
	 *
	 * @since    1.0.0
	 */
	public function render_payment_form(){
		$this->form->render();
	}

	private function clientPermitted($data){
		return isset($data['data_save_agreement']) && 1 === intval((string)$data['data_save_agreement']);
	}
}
