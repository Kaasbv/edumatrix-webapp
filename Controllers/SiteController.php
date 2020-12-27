<?php
class SiteController extends Controller {
  public function actionIndex(){
    $docent = DocentModel::getOne(["id" => 1]);
    var_dump($docent);
    $this->renderView("main");

  }
}


?>