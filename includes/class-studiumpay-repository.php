<?php

if (class_exists('Studiumpay_Repository')) {
  return;
}

class Studiumpay_Repository{

  public function saveOrder($data){
    global $wpdb;
    $stringedData = $this->stringify($data);
    var_dump($stringedData);
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
