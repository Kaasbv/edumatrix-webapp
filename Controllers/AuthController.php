<?
class AuthController extends Controller {
  private $layout = "default";

  public function actionIndex(){
    $this->renderView("Auth/login", ["windowTitle" => "test"]);
  }

  public function actionStephan(){
    echo "rl master";
  }
}

?>