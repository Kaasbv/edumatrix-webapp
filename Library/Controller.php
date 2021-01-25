<?php
  class Controller {
    protected $layout = "default";

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