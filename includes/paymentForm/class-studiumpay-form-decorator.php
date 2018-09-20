<?php

if (class_exists('Studiumpay_Form_Decorator')) {
  return;
}

class Studiumpay_Form_Decorator {

  /**
   * Gregwar Formidable form
   *
   * @since    1.0.0
   * @access   private
   * @var      Gregwar\Formidable\Form $from
   */
  private $from;

  /**
   * Array of errors
   *
   * @since    1.0.0
   * @access   private
   * @var      Array $errors
   */
  private $errors = [];

  /**
   * Array of products for checking the minimum cost of order
   *
   * @since    1.0.0
   * @access   private
   * @var      Array    $products    Active products, 'productId_' . id => cost
   */
  private $products = [];

  /**
   * Array of supported languages
   *
   * @since    1.0.0
   * @access   private
   * @var      Array    $languages  textToDisplay => value
   */
  private $languages = [
    'PL' => 'PL',
    'EN' => 'EN',
  ];

  /**
  * Construct
  */
  public function __construct($products){
    $this->products = $this->parseProducts($products);

    $form = new Gregwar\Formidable\Form(
      __DIR__.'/form-template.html.php',
       [
         'products' => $products,
         'errors' => $this->errors,
       ]
     );
   $this->setConstraints($form);

   $form->source('languages', $this->languages);
   $form->setValue('p24_language', 'PL');

   $this->form = $form;
  }


  /**
  * Handle form, default handle errors
  *
  * @param Function $successCallback callback on success
  */
  public function handle($successCallback){
    $this->form->handle(
      $successCallback,
      function($errors){
        $this->errors = $errors;
      }
    );
  }

  /**
  * Render error panel and form
  */
  public function render(){
    $this->renderErrors();
    echo $this->form;
  }

  public function getValues(){
    return $this->productsToIdQuantityArray(
      $this->form->getValues()
    );
  }

  public function getDataForPaymentRequest(){
    $data = $this->form->getValues();
    $postedProducts = array_intersect_key($data, $this->products);
    $id = 1;

    $parsedData = [];
    foreach ($postedProducts as $key => $value) {
      if ($value > 0) {
        $parsedData['p24_name_' . $id] = $key;
        $parsedData['p24_quantity_' . $id] = intval((string) $value);
        $parsedData['p24_price_' . $id] = intval((string)$this->products[$key]) * 100;
        $id++;
      }
    }

    $parsedData['p24_client'] = $data['client_name'] . ' ' . $data['client_surname'];
    unset($data['client_name']);
    unset($data['client_surname']);

    unset($data['regimen_agreement']);

    $data['p24_amount'] *= 100;

    return array_merge($parsedData, array_diff_key($data, $this->products));
  }

  /**
  * Set form constraints
  *
  * @param Gregwar\Formidable\Form $from
  * @return String error
  */
  private function setConstraints($form){
    $form->addConstraint('p24_email', function($value){
      if (!filter_var(trim($value), FILTER_VALIDATE_EMAIL)) {
        return 'Invalid email format';
      }
    });

    $form->addConstraint('p24_amount', function($value) {
        $data = $this->form->getValues();
        $postedProducts = array_intersect_key($data, $this->products);
        $minCost = $this->calculateMinCost($postedProducts);
        if ($value < $minCost) {
          return 'Cost is too low';
        }
      });

      $form->addConstraint('client_name', function($value) {
        if(preg_match('/[^\p{L}]+/', trim($value))){
          return 'Invalid characters in name field';
        };
      });

      $form->addConstraint('client_surname', function($value) {
        if(preg_match('/[^\p{L}]+/', trim($value))){
          return 'Invalid characters in surname field';
        };
      });
  }

/**
* Render Form error template
*/
  private function renderErrors(){
    echo '<div>';
    foreach($this->errors as $error){
      echo $error;
    }
    echo '</div>';
  }

  private function parseProducts($products){
    $id = array_column($products, 'id');
    $cost = array_column($products, 'cost');
    array_walk($id, function(&$element){
      $element = 'productId_' . $element;
    });

    return array_combine($id, $cost);
  }

  private function calculateMinCost($postedProducts){
    $minCost = 0;
    foreach ($postedProducts as $key => $value) {
      $minCost += $value * $this->products[$key];
    }
    return $minCost;
  }

  private function productsToIdQuantityArray($data){
    foreach ($data as $key => $value) {
      if (0 !== intval((string)$value) && preg_match('/productId_\d+/', $key)) {
        $newKey = preg_replace('/productId_/', '', $key);
        $data['productId_quantity'][$newKey] = $value;
        unset($data[$key]);
      }
    }

    return $data;
  }
}
