<?php
class Application {
  public function run(){
    //Register autoload for library classes
    spl_autoload_register(function ($className) {
      $autoDirectories = ["Controllers", "Models", "Library"];
      foreach ($autoDirectories as $dir) {
        $path = __DIR__ . "/../{$dir}/{$className}.php";
        if(is_file($path)){
          include $path;
          return;
        }
      }

      throw new Exception("Can't find class {$className}");
    });

    //Register exception handler
    set_exception_handler([$this, "exceptionHandler"]);

    //Connect to database
    $database = new DatabaseConnection();
    $database->startConnection();

    //Start session
    Session::init();

    //start routing
    ob_start();
    (new Router())->execute();

    //close after
    $database->closeConnection();
  }

  public function exceptionHandler($exception){
    $code = $exception->getCode() ? $exception->getCode() : 500;
    $message = $exception->getMessage() ?? "Internal Server error";
    $messageWithLocation = "<b>{$message}</b> on {$exception->getFile()}:{$exception->getLine()}"; 

    ob_clean();
    http_response_code($code);
    
    //render view
    $view = new View("Error/" . ($code === 500 || $code === 404 ? $code : 500), "default");
    $view->render(["message" => $messageWithLocation, "trace" => $exception->getTraceAsString()]);
    exit;
  }


}