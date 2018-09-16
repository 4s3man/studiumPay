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

  /**
  * Set form constraints
  *
  * @param Gregwar\Formidable\Form $from
  * @return String error
  */
  private function setConstraints($form){
    $form->addConstraint('p24_email', function($value){
      if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return 'Invalid email format';
      }
    });

    // TEST
    // $form->addConstraint('kurwa', function($value) {
    //     return 'error kurwa';
    // });

    // $form->addConstraint('p24_amount', function($value) {
    //   $postedCourses = array_intersect_key($this->courses,$_POST);
    //     $cost = array_reduce($postedCourses, [$this, 'sum']);
    //     if ($value < $cost) {
    //       return 'Cost is too low';
    //     }
    //   });
  }

  // private function setConstraintsForCourses($form){
  //   foreach ($this->courses as $name => $cost){
  //     $form->addConstraint($name, function($value){
  //       if ($value < 0) {
  //         return 'Invalid course amount';
  //       }
  //     });
  //   }
  // }

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
