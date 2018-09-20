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

  /**
   * Object constructor
   *
   * @since    1.0.0
   * @access   public
   */
  public function __construct(){
    $this->przelewy24 = new Przelewy24(64225,64225,'319a865d1bb01efd',true);
  }

  public function addRequestConstants(&$data){
    $protocol = ( isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' )? "https://":"http://";

    $data['p24_session_id'] = md5(session_id().date("YmdHis"));
    $data['p24_url_return'] = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?ok=1";
    $data['p24_url_satatus'] = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?ok=2";
    $data['p24_country'] = 'PL';
    $data['p24_currency'] = 'PLN';
    $data['p24_description'] = 'Payment for studiumNVC courses';
    $data['p24_api_version'] = STUDIUMPAY_P24_VERSION;

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

  public function trnRegister($data, $courses){
    $this->parseForTrnRegister($data, $courses);
    $this->addRequestConstants($data);
    $this->setGetawayObject($data);

    $res = $this->przelewy24->trnRegister(false);
  }

  private function parseForTrnRegister($data, $products){
    $products = array_filter($products, function($value) use ($data){
      return in_array((int)$value['id'], array_keys($data['productId_quantity']));
    });

    $parsedData = [];
    $id = 1;
    foreach ($products as $product) {
        $parsedData['p24_name_' . $id] = $product['post_name'];
        $parsedData['p24_quantity_' . $id] = $data['productId_quantity'][$product['id']];
        $parsedData['p24_price_' . $id] = intval((string)$product['cost']) * 100;
        $id++;
    }


    $parsedData['p24_client'] = $data['client_name'] . ' ' . $data['client_surname'];
    unset($data['client_name']);
    unset($data['client_surname']);

    unset($data['regimen_agreement']);

    $data['p24_amount'] *= 100;

    unset($data['productId_quantity']);

    return array_merge($parsedData, $data);
  }
}
