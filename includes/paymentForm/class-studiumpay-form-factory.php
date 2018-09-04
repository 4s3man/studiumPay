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
    'a' => 10,
    'b' => 10,
    'c' => 10,
    'd' => 10,
  ];

  public function __construct(){

  }

  public function createForm(){
		$form = new Gregwar\Formidable\Form($this->getFormTemplate(__DIR__.'/studiumpay-form-template.php'));
    $em = 'dono';
    $form->addConstraint('cost', function($value) {
    //todo zrobić constraint uzywając $courses dodac jquery żeby range przesuwał się na prawo i lewo
    if (10 < intval((string) $value)) {
        return 'Your name should be at least 10 characters!';
      }
    });

    return $form;
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

}
