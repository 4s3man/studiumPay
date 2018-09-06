<?php

if (class_exists('SP_FormFactory')) {
  return;
}

class SP_FormFactory {

  /**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Gregwar/Formidable/Form    $form    From to be displayed
	 */
	private $form;

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

  public $additional = [
    'prepay' => 500,
  ];

  public function __construct(){

  }

  public function render(){
    echo $this->form;
  }

  public function handle(){
    $this->form->handle();
  }

  public function createForm(){
		$form = new Gregwar\Formidable\Form($this->getFormTemplate(__DIR__.'/studiumpay-form-template.php'));

    $form->addConstraint('cost', function($value) {
      $postedCourses = array_intersect_key($this->courses,$_POST);

      if ($_POST['prepay'] && sizeof($postedCourses) === sizeof($this->courses)) {
        $_POST['cost'] = $this->additional['prepay'];
      } else {
        if (!$postedCourses) {
          return 'At least one checkbox should be selected';
        }

        $cost = array_reduce($postedCourses, [$this, 'sum']);
        if ($value < $cost) {
          return 'Cost is too low';
        }
      }
    });
    $this->form = $form;

    return $this;
	}

  private function initialValue($name){
    return isset($_POST[$name]) and !empty($_POST[$name]) ? $_POST[$name] : '';
  }

	private function getFormTemplate($src){
		ob_start();
		include $src;
		$view = ob_get_clean();

		return $view;
	}

  private function sum($carry, $item){
    $carry += $item;
    return $carry;
  }

  public function handleErrors(){

    // $errors = isset($_POST['studiumPayErrors']) && isArray($_POST['studiumPayErrors']) ?: $_POST['studiumPayErrors'];
    // if ( count($errors) ) {
    //   foreach ($erros as $error){
    //     var_dump($error);
    //   }
    //   exit('error dbu');
    // }
  }
}
