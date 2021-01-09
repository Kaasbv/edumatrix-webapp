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

    public function actionUpdate(){
      $cijferModel = new CijferModel();
      $cijferModel->cijfer = $_POST ["cijfer"];
      $cijferModel->beoordelingId = $_POST ["beoordelingId"];
      $cijferModel->leerlingId = $_POST ["leerlingId"];
      $cijferModel->opmerkingDocent = $_POST ["opmerkingen"];
      $cijferModel->datumIngevoerd = $_POST ["datum"];
      $cijferModel->save();
      var_dump($_POST);
    }
}

  
?>
