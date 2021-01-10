<?php
class Router {
  public $controllerDirectory = "Controllers";

  public function execute(){
    $requestPath = $_SERVER["REQUEST_URI"];
    if($requestPath === "/") $requestPath = "/site";
    
    $questionMarkPos = strpos($requestPath, "?");
    if($questionMarkPos !== false){
      $requestPath = substr($requestPath, 0, $questionMarkPos);
    }
    $pathArray = explode("/", rtrim($requestPath, '/'));
    

    $path = $this->controllerDirectory;
    foreach ($pathArray as $index => $part) {
      $newPath = $path . $part . "/";
      if(is_dir($newPath)){
        $path = $newPath;
      }else{
        $controllerName = $this->camelcaseify($part) . "Controller";
        $controllerPath = $path . $controllerName . ".php";
        if(is_file($controllerPath)){
          include $controllerPath;
          $controller = new $controllerName();
          $actionName = array_key_exists($index + 1, $pathArray) ? $pathArray[$index + 1] : "index";
          $action = "action" . $this->camelcaseify($actionName);

          if(!method_exists($controller, $action)){
            throw new Exception("Page not found", 404);
            return;
          }

          $controller->{"action" . $this->camelcaseify($actionName)}();
          break;
        }else{
          throw new Exception("Page not found", 404);
          return;
        }
      }
    }
  }

  public function camelcaseify($name){
    $lowercase = strtolower($name);
    return ucfirst($lowercase);
  }
}
?>