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
  * Construct
  */
  public function __construct($courses){
    $form = new Gregwar\Formidable\Form(
      __DIR__.'/form-template.html.php',
       [
         'courses' => $this->courses,
         'errors' => $this->errors,
       ]
     );
     $this->setConstraints($form);

    $this->form = $form;
  }

  /**
  * Render error panel and form
  */
  public function render(){
    $this->renderErrors();
    echo $this->form;
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
  * Set form constraints
  *
  * @param Gregwar\Formidable\Form $from
  * @return String error
  */
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

  /**
  * Sum used in setConstraints function
  * to sum minimum events cost
  *
  * @param int $carry sum container
  * @param int $item
  *
  * @return int sum
  */
  private function sum($carry, $item){
    $carry += $item;
    return $carry;
  }
}
