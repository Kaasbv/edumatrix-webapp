<?php
  class CijferController extends Controller{
    public function actionIndex(){
      $docent = DocentModel::getOne(["ID" => 1]);
      $klasse = $docent -> getKlasDocent();

      $this->renderView("Cijfer/test");
    }



    public function actionVoorbeeld(){
      $cijferId = $_GET["cijferId"];
      
      $cijferModel = CijferModel::getOne(["ID" => $cijferId]);
      print_r($cijferModel);


      exit;
    }

    // public function actionGetCijfers(){ //placeholder
    //   $cijfer = BeoordelingModel::GetOne(["ID" => 1]);
    //   $cijferBeoordeling = $cijfer -> getcijfers();
    // }


  
    // public function actionCijferMenu(){
    //   $this->renderView("Cijfer/sidemenu");
    // }
    
    public function actionKlasOverzicht(){
      if(!isset($_GET["klasId"])){
        throw new Exception("KlasId niet gespecificeerd", 400);
      }
      $klasId = $_GET["klasId"];
      $klas = KlasModel::getOne(["id" => $klasId]);

      if(!$klas){
        throw new Exception("Klas niet gevonden", 404);
      }

      $beoordelingen = $klas->getBeoordelingen();
      $cijfers = [];
      foreach ($beoordelingen as $beoordeling) {
        array_push($cijfers, ...$beoordeling->getCijfers());
      }

      

      $this->renderView("Cijfer/index", [
        "beoordelingen" => $beoordelingen,
        "cijfers" => $cijfers
      ]);
    }

}


?>
