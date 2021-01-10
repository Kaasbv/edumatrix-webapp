<?php
class KlasModel extends Model {
  public static $_tableName = "KlasModel";

  protected static $_joins = [
    [
      "foreignKey" => "KLAS_ID",
      "tableName" => "LeerlingKlas",
    ]
  ];
    
  public int $id;
  public string $klasNaam;
  public string $docentId;
  public string $niveau;
  public int $leerjaar;
  public int $vakId;

  public function __construct($klasNaam, $docentId, $vakId, $leerjaar, $niveau){
    $this->klasNaam = $klasNaam;
    $this->docentId = $docentId;
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
}
?>
