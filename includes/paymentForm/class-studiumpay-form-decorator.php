<?php

if (class_exists('SP_Form_Decorator')) {
  return;
}

class SP_Form_Decorator {

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      Gregwar\Formidable\Form $from
   */
  private $from;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      Array $errors
   */
  private $errors = [];

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      Array    $courses    Active courses, name => cost
   */
  public $courses = [
    'a' => 100,
    'b' => 100,
    'c' => 100,
    'd' => 100,
  ];

  public function __construct(){
    $form = new Gregwar\Formidable\Form(
      __DIR__.'/studiumpay-form-template.php',
       [
         'courses' => $this->courses,
         'errors' => $this->errors,
       ]
     );
     $this->setConstraints($form);

    $this->form = $form;
  }

  public function render(){
    $this->renderErrors();
    echo $this->form;
  }

  public function handle($successCallback){
    $this->form->handle(
      $successCallback,
      function($errors){
        $this->errors = $errors;
      }
    );
  }

  private function setConstraints($form){
    $form->addConstraint('cost', function($value) {
      $postedCourses = array_intersect_key($this->courses,$_POST);
        if (!$postedCourses) {
          return 'At least one checkbox should be selected';
        }

        $cost = array_reduce($postedCourses, [$this, 'sum']);
        if ($value < $cost) {
          return 'Cost is too low';
        }
      });
  }

  private function renderErrors(){
    echo '<div>';
    foreach($this->errors as $error){
      echo $error;
    }
    echo '</div>';
  }

  private function sum($carry, $item){
    $carry += $item;
    return $carry;
  }
}
