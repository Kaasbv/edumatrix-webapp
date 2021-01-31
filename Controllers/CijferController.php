<?php
  class CijferController extends Controller{
    public function actionKlas(){
      //Authorization
      $this->checkAuthorization(["docent"]);

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
      $cijfers = $klas->getCijfers();
      $leerlingen = $klas->getLeerlingen();

      //Render view
      $this->renderView("Cijfer/cijferoverzichtklas", [
        "beoordelingen" => $beoordelingen,
        "cijfers" => $cijfers,
        "leerlingen" => $leerlingen,
        "klasId" => $klas->id
      ]);
    }

    public function actionUpdate(){
      //Authorization
      $this->checkAuthorization(["docent"]);

      if(isset($_POST ["beoordelingId"]) && isset($_POST ["leerlingId"])){
        $cijferModel = new CijferModel($_POST ["leerlingId"], $_POST ["beoordelingId"], $_POST ["cijfer"]);
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

      $this->redirect("/cijfer/klas?klasId=" . $_POST["klasId"] . "&cijferId=" . $cijferModel->id);
    }

    public function actionKlassenoverzicht(){
      //Authorization
      $this->checkAuthorization(["docent"]);

      $docent = Session::$user;
      $klassen = $docent->getKlassen();
      $this->renderView("Cijfer/klassenoverzicht", ["klassen" => $klassen]);
    }
}

  
?>
