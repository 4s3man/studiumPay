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
   * Array of courses //todo set dinamicaly
   *
   * @since    1.0.0
   * @access   private
   * @var      Array    $courses    Active courses, name => cost
   */
  private $courses = [
    'a' => 100,
    'b' => 100,
    'c' => 100,
    'd' => 100,
  ];

  /**
   * Array of courses
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
  public function __construct(){
    $form = new Gregwar\Formidable\Form(
      __DIR__.'/form-template.html.php',
       [
         'courses' => $this->courses,
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
    return $this->form->getValues();
  }

  public function getDataForPaymentRequest(){
    $data = $this->form->getValues();
    $postedCourses = array_intersect_key($data, $this->courses);
    $id = 1;

    $parsedData = [];
    foreach ($postedCourses as $key => $value) {
      if ($value > 0) {
        $parsedData['p24_name_' . $id] = $key;
        $parsedData['p24_quantity_' . $id] = intval((string) $value);
        $parsedData['p24_price_' . $id] = intval((string)$this->courses[$key]);
        $id++;
      }
    }

    $parsedData['p24_client'] = $data['client_name'] . ' ' . $data['client_surname'];
    unset($data['client_name']);
    unset($data['client_surname']);

    return array_merge($parsedData, array_diff_key($data, $this->courses));
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
        $postedCourses = array_intersect_key($data, $this->courses);
        $minCost = $this->calculateMinCost($postedCourses);
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

  private function calculateMinCost($postedCourses){
    $minCost = 0;
    foreach ($postedCourses as $key => $value) {
      $minCost += $value * $this->courses[$key];
    }
    return $minCost;
  }
}
