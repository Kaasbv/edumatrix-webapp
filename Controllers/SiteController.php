<?php
class SiteController extends Controller {
  public function actionIndex(){
    $this->checkAuthorization();
    $this->renderView("main");
  }

  public function actionWip(){
    $this->checkAuthorization();
    $this->renderView("wip");
  }

}

?>