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

    public function checkAuthorization($arrayOfUserTypes = []){
      if(!isset(Session::$user)){
        ob_clean();
        header("Location: /auth/login");
        exit();
      }else if(count($arrayOfUserTypes) !== 0 && !Session::$user->isAuthorized($arrayOfUserTypes)){
        throw new Error("Unauthorized for this action", 403);
      }
    }
  }
?>