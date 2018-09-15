<?php

if (class_exists('Studiumpay_Przelewy24')) {
  return;
}

class Studiumpay_Przelewy24_Decorator{

  /**
   * The payment getaway
   *
   * @since    1.0.0
   * @access   private
   * @var      Przelewy24\Przelewy24    $przelewy24
   */
  private $przelewy24;

  public function __construct(){

  }

}
