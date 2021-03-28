<?php
class KlasModel extends EmptyModel {
  public string $klasNaam;
  public string $niveau;
  public int $leerjaar;

  public function __construct($klasNaam, $leerjaar, $niveau){
    $this->klasNaam = $klasNaam;
    $this->leerjaar = $leerjaar;
    $this->niveau = $niveau;
  }

  public function getToetsOpdrachten() {
    return ToetsOpdrachtModel::getAllByKlasNaam($this->klasNaam);
  }

  public function getLeerlingen() {
    return LeerlingModel::getAllByKlasNaam($this->klasNaam);
  }

  public function getCijfers() {
    return CijferModel::getAllByKlasNaam($this->klasNaam);
  }

  public static function getByKlasNaam($klasNaam){
    $query = "
        SELECT * FROM Klas dm
        WHERE KLAS_NAAM = ?
    ";

    [$data] = DatabaseConnection::runPreparedQuery($query, [$klasNaam], ["s"]);

    $object = new KlasModel(
      $data["KLAS_NAAM"],
      $data["LEERJAAR"],
      $data["NIVEAU"]
    );

    return $object;
  }

  public static function getAllByDocentCode($docentCode){
    $query = "
        SELECT km.* FROM Klas km
        INNER JOIN Les lm on lm.KLAS_NAAM = km.KLAS_NAAM
        WHERE lm.DOCENT_CODE = ?
        GROUP BY km.KLAS_NAAM
    ";

    $data = DatabaseConnection::runPreparedQuery($query, [$docentCode], ["s"]);

    $objectArray = [];
    foreach ($data as $row) {
      $object = new KlasModel(
        $row["KLAS_NAAM"],
        $row["LEERJAAR"],
        $row["NIVEAU"]
      );

      $objectArray[] = $object;
  }

    return $objectArray;
  }
}
?>
