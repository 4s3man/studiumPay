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

  private $repository ;

  /**
   * Object constructor
   *
   * @since    1.0.0
   * @access   public
   */
  public function __construct(){
    $this->przelewy24 = new Przelewy24(64225,64225,'319a865d1bb01efd',true);
    $this->repository = new Studiumpay_Repository();
  }

  public function addRequestConstants(&$data){
    $protocol = ( isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' )? "https://":"http://";

    $data['p24_session_id'] = md5(session_id().date("YmdHis"));
    $data['p24_url_return'] = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?ok=1";
    $data['p24_url_satatus'] = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?ok=2";
    $data['p24_country'] = 'PL';
    $data['p24_currency'] = 'PLN';
    $data['p24_description'] = 'Payment for studiumNVC courses';
    $data['p24_api_version'] = P24_VERSION;

    return $data;
  }

  /**
   * Set przelewy24 object
   *
   * @since    1.0.0
   * @param    array    $data       External data from form
   */
  public function setGetawayObject($data){
    foreach($data as $k=>$v) $this->przelewy24->addValue($k,$v);
  }

  public function trnRegister($data){
    $this->addRequestConstants($data);
    $this->setGetawayObject($data);

    $this->repository->saveOrder($data);

    $res = $this->przelewy24->trnRegister(false);
    var_dump($res);
    exit('register');
  }

}
