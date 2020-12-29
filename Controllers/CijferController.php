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
  }
  
?>
