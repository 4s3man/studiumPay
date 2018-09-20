<?php

if (class_exists('Studiumpay_Repository')) {
  return;
}

class Studiumpay_Repository{

  public function saveOrder($data){
    global $wpdb;
    list($name, $surname) = explode(' ',$data['p24_client']);

    $wpdb->query('START TRANSACTION');

    $res1 = $wpdb->insert('wp_studiumpay_purchaser', [
      'name' => $name,
      'surname' => $surname,
      'email' => $data['p24_email'],
      'language' => $data['p24_language'],
    ]);
    $purchaser_id = $wpdb->insert_id;

    $res2 = $wpdb->insert('wp_studiumpay_orders', [
      'purchaser_id' => $purchaser_id,
      'amount' => $data['p24_amount'],
      'crc' => '319a865d1bb01efd', //todo to fix from where get this? pass to function? do i need it?
      'language' => $data['p24_language'],
    ]);
    $order_id = $wpdb->insert_id;

    //todo change to store every detail
    $res3 = $wpdb->insert('wp_studiumpay_details', [
      'event_id' => $purchaser_id, //todo or maybe store event name? or pass event name?
      'order_id' => $order_id,
      'quantity' => $data['p24_quantity_1'], //todo change to dynamical variable
    ]);

    $wpdb->query('COMMIT');


    var_dump($data);

    exit('repository');
  }

  // private function stringify(Array $data){
  //   $carry = '';
  //   foreach ($data as $key => $value) {
  //     $carry .= $key.'=';
  //     $carry .= $value;
  //     if (false !== next($data)) {
  //       $carry .= '::';
  //     }
  //   }
  //   return $carry;
  // }

}
