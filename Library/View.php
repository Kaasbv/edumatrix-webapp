<?
class View {
  public $name;
  public $layout;
  private $layoutDirectory = __DIR__ . "/../Layouts";
  private $viewDirectory = __DIR__ . "/../Views";

  function __construct($path, $layout){
    $this->path = $path;
    $this->layout = $layout;
  }

  public function render($context){
    $context = (object) $context;
    ob_start();
    include $this->viewDirectory . "/" . $this->path . ".php";
    $content = ob_get_clean();    
    include $this->layoutDirectory . "/" . $this->layout . ".php";
  }
}

?>