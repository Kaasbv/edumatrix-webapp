<?php
  class CijferController extends Controller{
    public function actionKlas(){
      //Authorization
      $this->checkAuthorization(["docent"]);

      if(!isset($_GET["klasNaam"])){
        throw new Exception("klasNaam niet gespecificeerd", 400);
      }
      //Verkrijg klas
      $klasNaam = $_GET["klasNaam"];
      $klas = KlasModel::getByKlasNaam($klasNaam);

      if(!$klas){//Error als klas niet bestaat
        throw new Exception("Klas niet gevonden", 404);
      }

      //Verkrijg alle benodigde data
      $toetsOpdrachten = $klas->getToetsOpdrachten();
      $cijfers = $klas->getCijfers();
      $leerlingen = $klas->getLeerlingen();

      //Render view
      $this->renderView("Cijfer/cijferoverzichtklas", [
        "toetsOpdrachten" => $toetsOpdrachten,
        "cijfers" => $cijfers,
        "leerlingen" => $leerlingen,
        "klasNaam" => $klas->klasNaam
      ]);
    }

    public function actionUpdate(){
      //Authorization
      $this->checkAuthorization(["docent"]);

      if(isset($_POST["new"])){
        $cijferModel = new CijferModel($_POST ["leerlingNummer"], $_POST ["toetsOpdrachtId"], $_POST ["cijfer"]);
        $cijferModel->opmerkingDocent = $_POST ["opmerkingen"];
        $cijferModel->datumToetsGemaakt = $_POST ["datum"];
        $cijferModel->create();
      }else{
        $cijferModel = CijferModel::getByIds($_POST ["leerlingNummer"], $_POST ["toetsOpdrachtId"]);
        $cijferModel->cijfer = $_POST ["cijfer"];
        $cijferModel->opmerkingDocent = $_POST ["opmerkingen"];
        $cijferModel->datumToetsGemaakt = $_POST ["datum"];
        $cijferModel->update();
      }

      $this->redirect("/cijfer/klas?klasNaam=" . $_POST["klasNaam"] . "&leerlingNummer=" . $cijferModel->leerlingNummer . "&toetsOpdrachtId=" . $cijferModel->toetsOpdrachtId);
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
