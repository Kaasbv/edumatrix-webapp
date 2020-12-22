<?
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
    // set_exception_handler([$this, "exceptionHandler"]);

    //Connect to database
    $database = new DatabaseConnection();
    $database->startConnection();
    //start routing
    ob_start();
    (new Router())->execute();
  }

  public function exceptionHandler($exception){
    $code = $exception->getCode() ? $exception->getCode() : 500;
    $message = $exception->getMessage() ?? "Internal Server error";

    ob_clean();
    http_response_code($code);
    echo http_response_code();
    
    //render view
    $view = new View("Error/" . ($code === 500 || $code === 404 ? $code : 500));
    $view->render(["message" => $message]);

    exit;
  }


}