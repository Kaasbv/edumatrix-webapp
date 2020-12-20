<?

class Application {
  function __construct(){
    spl_autoload_register(function ($class_name) {
      include $class_name . '.php';
    });

    //start routing
    (new Router())->execute();
  }
}