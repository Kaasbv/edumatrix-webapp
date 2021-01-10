<?php
  class CijferController extends Controller{
    public function actionKlas(){
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
      if(isset($_POST ["beoordelingId"]) && isset($_POST ["leerlingId"])){
        $cijferModel = new CijferModel();
        $cijferModel->cijfer = $_POST ["cijfer"];
        $cijferModel->beoordelingId = $_POST ["beoordelingId"];
        $cijferModel->leerlingId = $_POST ["leerlingId"];
        $cijferModel->opmerkingDocent = $_POST ["opmerkingen"];
        $cijferModel->datumToetsGemaakt = $_POST ["datum"];
        $cijferModel->save();
      }else if(isset($_POST ["cijferId"])){
        $cijferModel = CijferModel::getOne(["id" => $_POST["cijferId"]]);
        $cijferModel->cijfer = $_POST ["cijfer"];
        $cijferModel->opmerkingDocent = $_POST ["opmerkingen"];
        $cijferModel->datumToetsGemaakt = $_POST ["datum"];
        $cijferModel->save();
      }

      $this->redirect("/cijfer/klasoverzicht?klasId=" . $_POST["klasId"] . "&cijferId=" . $cijferModel->id);
    }

    public function actionKlassenoverzicht(){
      $docent = DocentModel::getOne(["id" => 1]);
      $klassen = $docent->getKlassen();
      $this->renderView("Cijfer/klassenoverzicht", ["klassen" => $klassen]);
    }
}

  
?>
