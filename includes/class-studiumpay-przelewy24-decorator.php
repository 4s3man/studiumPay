<?php

if (class_exists('Studiumpay_Przelewy24')) {
  return;
}

use Przelewy24\Przelewy24;

class Studiumpay_Przelewy24_Decorator{

  /**
   * The payment getaway object
   *
   * @since    1.0.0
   * @access   private
   * @var      Przelewy24\Przelewy24    $przelewy24
   */
  public $przelewy24;

  // /**
  //  * Internal data to fill the form
  //  *
  //  * @since    1.0.0
  //  * @access   private
  //  * @var      Przelewy24\Przelewy24    $przelewy24
  //  */
  // private $internalData ;

  /**
   * Object constructor
   *
   * @since    1.0.0
   * @access   public
   */
  public function __construct(){
    $this->przelewy24 = new Przelewy24(64225,64225,'319a865d1bb01efd',true);
  }

  /**
   * Set przelewy24 object
   *
   * @since    1.0.0
   * @param    array    $data       External data from form
   */
  public function setGetawayObject($data){
    $protocol = ( isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' )? "https://":"http://";

    $this->przelewy24->addValue('p24_session_id', md5(session_id().date("YmdHis")));
    $this->przelewy24->addValue('p24_url_return', $protocol.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?ok=1");
    $this->przelewy24->addValue('p24_url_status', $protocol.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?ok=2");

    $this->przelewy24->addValue('p24_country', 'PL');
    $this->przelewy24->addValue('p24_currency', 'PLN');

    $this->przelewy24->addValue('p24_api_version', P24_VERSION);
  }

}
