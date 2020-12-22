<?php
  class Controller {
    private $layout = "default";

    public function renderView($name, $context = []){
      $view = new View($name, $this->layout);
      $view->render($context);
    }

    public function redirect($path){
      ob_clean();
      header("Location: {$path}");
      exit();
    }
  }

?>