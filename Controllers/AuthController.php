<?
class AuthController extends Controller {
  protected $layout = "default";

  public function actionIndex(){
    //Pas een model aan
    $test = Testtable::getOne(["id" => 1]);
    $test->a = 200;
    $test->save();
    $test = DatabaseConnection::select("testtable2", [], ["id" => 1]);
    //render
    $this->renderView("Auth/login", ["windowTitle" => "aa"]);
  }
}

?>