<?php

require_once __DIR__ . '/class-studiumpay-form-decorator.php';


if (class_exists('SP_FormFactory')) {
  return;
}

class SP_FormFactory {
  public function createForm($formClass){
    $form = new $formClass();

    return $form;
	}
}
