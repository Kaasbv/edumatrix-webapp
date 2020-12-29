<?php
  class CijferController extends Controller{
    public function actionIndex(){
      $this->renderView("Cijfer/index");
    }

    public function actionKlassenIndex(){
      $this->renderView("Cijfer/index");
    }
    public function actionGetCijfers(){ //placeholder
      $cijfer = BeoordelingModel::GetOne(["ID" => 1]);
      $cijferBeoordeling = $cijfer -> getcijfers();
    }
  }

  
?>
