<?php
class KlasModel extends Model {
  public static $_tableName = "KlasModel";

  protected static $_joins = [
    [
      "foreignKey" => "KLAS_ID", //matcht met deze key in koppel tabel bijvoorbeeld klas_id
      "tableName" => "LeerlingKlas", //koppeltabel
    ]
  ];

  protected int $id;
  protected string $klasNaam;
  protected int $aantalLeerlingen;
  protected string $niveau;
  protected int $leerjaar;
  protected int $vakId;

  public function getBeoordelingen() {
    return BeoordelingModel::getAll(["KLAS_ID" => $this->id]);
  }
}
?>
