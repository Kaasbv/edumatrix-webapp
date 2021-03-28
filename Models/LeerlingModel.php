<?php
class LeerlingModel extends GebruikerModel {
  public int $leerlingnummer;
  public string $gebruikerEmail;
  public string $niveau;
  public int $leerjaar;

  public function __construct($leerlingNummer, $gebruikerId, $niveau, $leerjaar){
    $this->leerlingNummer = $leerlingNummer;
    $this->gebruikerId = $gebruikerId;
    $this->niveau = $niveau;
    $this->leerjaar = $leerjaar;
  }

  public static function getAllByKlasNaam($klasNaam){
    $query = "
        SELECT gm.*, lm.* FROM Leerling lm
        INNER JOIN LeerlingKlas lk on lk.LEERLING_NUMMER = lm.LEERLING_NUMMER
        LEFT JOIN Gebruiker gm on gm.EMAIL = lm.GEBRUIKER_EMAIL
        WHERE lk.KLAS_NAAM = ?
        GROUP BY lm.LEERLING_NUMMER
    ";

    $data = DatabaseConnection::runPreparedQuery($query, [$klasNaam], ["s"]);

    $objectArray = [];
    foreach ($data as $row) {
        $object = new LeerlingModel(
            $row["LEERLING_NUMMER"],
            $row["GEBRUIKER_EMAIL"],
            $row["NIVEAU"],
            $row["LEERJAAR"],
        );

        self::fillObject($object, $row);

        $objectArray[] = $object;
    }

    return $objectArray;
  }
}

?>
