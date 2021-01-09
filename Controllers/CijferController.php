<?php
  class CijferController extends Controller{
    public function actionIndex(){
      $docent = DocentModel::getOne(["ID" => 1]);
      $klasse = $docent -> getKlasDocent();
      $this->renderView("Cijfer/index");

    }

    public function actionKlassenIndex(){
      $this->renderView("Cijfer/index");
    }

    public function actionGetCijfers(){ //placeholder
      $cijfer = BeoordelingModel::GetOne(["ID" => 1]);
      $cijferBeoordeling = $cijfer -> getcijfers();
    }


  
    public function actionCijferMenu(){
      $this->renderView("Cijfer/sidemenu");
    }

    public function actionKlassenoverzicht(){
      $this->renderView("Cijfer/klassenoverzicht");
    }
}

  
?>
