<?php
class SiteController extends Controller {
  public function actionIndex(){
    $this->renderView("main");
  }

  public function actionWip(){
    $this->renderView("wip");
  }
}

?>