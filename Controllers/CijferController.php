<?php
  class CijferController extends Controller{
    public function actionIndex(){
      $docent = DocentModel::getOne(["ID" => 1]);
      $klasse = $docent -> getKlasDocent();
      $this->renderView("Cijfer/index");

    }

    public function actionKlasOverzicht(){
      if(!isset($_GET["klasId"])){
        throw new Exception("KlasId niet gespecificeerd", 400);
      }
      //Verkrijg klas
      $klasId = $_GET["klasId"];
      $klas = KlasModel::getOne(["id" => $klasId]);

      if(!$klas){//Error als klas niet bestaat
        throw new Exception("Klas niet gevonden", 404);
      }

      //Verkrijg alle benodigde data
      $beoordelingen = $klas->getBeoordelingen();
      $cijfers = [];
      foreach ($beoordelingen as $beoordeling) {
        array_push($cijfers, ...$beoordeling->getCijfers());
      }
      $leerlingen = $klas->getLeerlingen();

      //Render view
      $this->renderView("Cijfer/index", [
        "beoordelingen" => $beoordelingen,
        "cijfers" => $cijfers,
        "leerlingen" => $leerlingen,
        "klasId" => $klas->id
      ]);
    }

    public function actionKlassenoverzicht(){
      $docent = DocentModel::getOne(["id" => 1]);
      $klassen = $docent->getKlassen();
      $this->renderView("Cijfer/klassenoverzicht", ["klassen" => $klassen]);
    }
}

  
?>
