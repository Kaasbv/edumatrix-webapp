<?
class SiteController extends Controller{
  public function actionIndex(){
    echo "pure root";

    throw new Exception("test");
  }
}

?>