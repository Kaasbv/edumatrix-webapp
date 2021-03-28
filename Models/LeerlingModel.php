<?php
class LeerlingModel extends GebruikerModel {
  public static $_tableName = "LeerlingModel";
  public static $_inheritanceColumn = "GEBRUIKER_ID";

  protected static $_joins = [
    [
      "foreignKey" => "LEERLING_ID",
      "tableName" => "LeerlingKlas",
    ]
  ];

  public int $id;
  public string $leerlingnummer;
  public int $gebruikerId;
  public string $niveau;
  public int $leerjaar;
  public int $roosterId;

  public function __construct($leerlingnummer, $gebruikerId, $niveau, $leerjaar){
    $this->leerlingnummer = $leerlingnummer;
    $this->gebruikerId = $gebruikerId;
    $this->niveau = $niveau;
    $this->leerjaar = $leerjaar;
  }

  public static function getAllByKlasId($klasId){
    $query = "
        SELECT gm.*, lm.* FROM LeerlingModel lm
        INNER JOIN LeerlingKlas lk on lk.LEERLING_ID = lm.ID
        LEFT JOIN GebruikerModel gm on gm.ID = lm.GEBRUIKER_ID
        WHERE lk.KLAS_ID = ?
        GROUP BY lm.id
    ";

    $data = DatabaseConnection::runPreparedQuery($query, [$klasId], ["i"]);

    $objectArray = [];
    foreach ($data as $row) {
        $object = new LeerlingModel(
            $row["LEERLINGNUMMER"],
            $row["GEBRUIKER_ID"],
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
