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

  public function trnRegister($data, $courses){
    $this->parseForTrnRegister($data, $courses);
    $this->addRequestConstants($data);
    $this->setGetawayObject($data);

    $this->repository->saveOrder($data);

    $res = $this->przelewy24->trnRegister(false);
    var_dump($res);
    exit('register');
  }

  private function parseForTrnRegister($data, $products){
    $id = 1;
    $s = array_filter($products, function($value){
      return (in_array((int)$value['id'], array_keys($data['productId_quantity'])));
    });

    var_dump(in_array(2, array_keys($data['productId_quantity'])));

    // foreach ($data['productId_quantity'] as $productId => $quantity) {
    //   if ($value > 0) {
    //     $parsedData['p24_name_' . $id] = $key;
    //     $parsedData['p24_quantity_' . $id] = intval((string) $value);
    //     $parsedData['p24_price_' . $id] = intval((string)$this->products[$key]) * 100;
    //     $id++;
    //   }
    // }

    exit('parse for register');

    $parsedData['p24_client'] = $data['client_name'] . ' ' . $data['client_surname'];
    unset($data['client_name']);
    unset($data['client_surname']);

    unset($data['regimen_agreement']);

    $data['p24_amount'] *= 100;

    return array_merge($parsedData, array_diff_key($data, $this->products));


  }

}
