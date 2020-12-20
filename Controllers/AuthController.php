<?
class AuthController extends Controller {
  private $layout = "default";

  public function actionIndex(){
    $user = new Gebruiker("Jemoeder", "test1243%");
    $user->save();
    $this->renderView("Auth/login", ["windowTitle" => "aa"]);
  }

  public function actionStephan(){
    echo "rl master";
  }
}

?>