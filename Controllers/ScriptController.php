<?php
class ScriptController extends Controller {
  private $voornamen = ["Nassim", "Burak", "Nash", "Auke", "Marijn", "Jimmy", "Johan", "Gert", "Sjaak", "Ashley", "Frank", "Jack", "Shenkie", "Dom", "Rik", "Hans"];
  private $achternamen = ["Boom", "Wal", "Gitaar", "Kast", "Stronk", "Oof", "Jansen", "Rutte", "Beer", "Boek", "Ster", "Avans", "Steen", "Klok", "Trump", "Jack", "Sleutel"];
  private $tussenvoegsel = ["van de", "de", "van den", false, false];
  private $niveau = ["HAVO", "VWO"];
  private $klasSuffixen = ["a", "b", "c", "d"];
  public function actionGenerateKlas(){
    //Generate klas
    $niveau = $this->getRandomItem($this->niveau);
    $leerjaar = mt_rand(1, 5);
    $naam = strtolower($niveau[0]) . $leerjaar . $this->getRandomItem($this->klasSuffixen);
    $klas = new KlasModel($naam, 1, 1, $leerjaar, $niveau);
    $klasId = $klas->save();

    //Generate leerlingen
    $leerlingen = [];
    for($index = 0; $index < 30; $index++){
      //Generate gebruiker
      $gebruiker = new GebruikerModel(
        $this->getRandomItem($this->voornamen),
        $this->getRandomItem($this->tussenvoegsel),
        $this->getRandomItem($this->achternamen)
      );
      $gebruikerId = $gebruiker->save();
      //Generate leerling
      $leerling = new LeerlingModel(mt_rand(100000, 999999), $gebruikerId, $niveau, $leerjaar);
      $leerlingId = $leerling->save();
      $leerlingen[] = $leerling;
      //Generate koppeling
      $koppeling = new LeerlingKlas();
      $koppeling->leerlingId = $leerlingId;
      $koppeling->klasId = $klasId;
      $koppeling->save();
    }

    //Generate beoordelingen
    $beoordelingen = [];
    for($index = 1; $index < 17; $index++){
      //Generate gebruiker
      $beoordeling = new BeoordelingModel($klasId, "Toets H" . $index, "2020-01-01", "AAAAAAAA", "toets");
      $beoordeling->save();
      $beoordelingen[] = $beoordeling;
    }

    //Generate cijfers
    foreach($leerlingen as $leerling){
      foreach($beoordelingen as $beoordeling){
        if(mt_rand(0, 7)){
          if(mt_rand(0, 5)){
            $cijfer = new CijferModel($leerling->id, $beoordeling->id, mt_rand(56, 100) / 10);
          }else{
            $cijfer = new CijferModel($leerling->id, $beoordeling->id, mt_rand(10, 55) / 10);
          }
          $cijfer->datumToetsGemaakt = "2020-01-01";
          $cijfer->save();
        }
      }
    }
  
  }

  private function getRandomItem($array){
    return $array[mt_rand(0, count($array) - 1)];
  }
}
?>