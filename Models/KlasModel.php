<?php
class KlasModel extends EmptyModel {
  public static $_tableName = "KlasModel";

  protected static $_joins = [
    [
      "foreignKey" => "KLAS_ID",
      "tableName" => "LeerlingKlas",
    ]
  ];
    
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
    return BeoordelingModel::getAll(["KLAS_ID" => $this->id]);
  }

  public function getLeerlingen() {
    return LeerlingModel::getAll(["KLAS_ID" => $this->id]);
  }

  public function getCijfers() {
    return CijferModel::GetAll(["KLAS_ID" => $this->id]);
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

    return $object;
  }
}
?>
