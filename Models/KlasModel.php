<?php
class KlasModel extends EmptyModel {
  public int $id;
  public string $klasNaam;
  public string $niveau;
  public int $leerjaar;
  public int $vakId;

  public function __construct($klasNaam, $vakId, $leerjaar, $niveau){
    $this->klasNaam = $klasNaam;
    $this->vakId = $vakId;
    $this->leerjaar = $leerjaar;
    $this->niveau = $niveau;
  }

  public function getBeoordelingen() {
    return BeoordelingModel::getAllByKlasId($this->id);
  }

  public function getLeerlingen() {
    return LeerlingModel::getAllByKlasId($this->id);
  }

  public function getCijfers() {
    return CijferModel::getAllByKlasId($this->id);
  }

  public static function getByKlasId($klasId){
    $query = "
        SELECT * FROM KlasModel dm
        WHERE ID = ?
    ";

    [$data] = DatabaseConnection::runPreparedQuery($query, [$klasId], ["i"]);

    $object = new KlasModel(
      $data["KLAS_NAAM"],
      $data["VAK_ID"],
      $data["LEERJAAR"],
      $data["NIVEAU"]
    );

    $object->id = $data["ID"];


    return $object;
  }

  public static function getAllByDocentId($docentId){
    $query = "
        SELECT km.* FROM KlasModel km
        INNER JOIN LesModel lm on lm.KLAS_ID = km.ID
        WHERE lm.DOCENT_ID = ?
        GROUP BY km.id
    ";

    $data = DatabaseConnection::runPreparedQuery($query, [$docentId], ["i"]);

    $objectArray = [];
    foreach ($data as $row) {
      $object = new KlasModel(
        $row["KLAS_NAAM"],
        $row["VAK_ID"],
        $row["LEERJAAR"],
        $row["NIVEAU"]
      );

      $object->id = $row["ID"];

      $objectArray[] = $object;
  }


    return $objectArray;
  }
}
?>
