<?
class View {
  public $name;
  public $layout;
  private $layoutDirectory = __DIR__ . "/../Layouts";
  private $viewDirectory = __DIR__ . "/../Views";

  function __construct($path, $layout = false){
    $this->path = $path;
    $this->layout = $layout;
  }

  public function renderSubView($path){
    $view = new View($path);
    $view->render($this->context);
  }

  public function render($context){
    $context = (object) $context;
    $this->context = $context;

    ob_start();
    include $this->viewDirectory . "/" . $this->path . ".php";
    $content = ob_get_clean();

    if($this->layout){
      include $this->layoutDirectory . "/" . $this->layout . ".php";
    }else{
      echo $content;
    }
  }
}

?>