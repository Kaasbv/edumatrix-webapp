<?
  class Controller {
    private $layout = "default";

    public function renderView($name, $context = []){
      $view = new View($name, $this->layout);
      $view->render($context);
    }
  }

?>