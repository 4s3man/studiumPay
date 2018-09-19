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
		$this->form = new Studiumpay_Form_Decorator();
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
			$saveClientData = false;
			$data = $this->form->getDataForPaymentRequest();

			if ('1' === $data['data_save_agreement']) {
					$saveClientData = true;
					unset($data['data_save_agreement']);
			}

			$data = $this->przelewy24->addRequestConstants($data);

			$this->przelewy24->setGetawayObject($data);
			$this->przelewy24->trnRegister();


			//todo zrobić
			// $this->repository->saveOrder($data);

			//
			// //todo zrobić
			// $this->przelewy24->sendPaymentRequest();
		});

		//zrobić weryfikacje w return, zdebugować a potem dać ją tu
		if (isset($_GET['ok']) && '2' === $_GET['ok']) {

			exit('weryfikacja');
		}

		//powrót po transakcji
		if (isset($_GET['ok']) && '1' === $_GET['ok']) {

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
}
