<?php
class LeerlingModel extends Model { //TODO: wanneer gebruiker model avaiable is, die extenden
  public static $_tableName = "LeerlingModel";
  public static $_inheritanceColumn = "_GEBRUIKER_ID";
  public static $_primaryKey = "nummer";

  protected static $_joins = [
    [
      "foreignKey" => "LEERLING_ID", //matcht met deze key in koppel tabel bijvoorbeeld klas_id
      "tableName" => "LeerlingKlas", //koppeltabel
    ]
  ];

  protected string $id;
  protected string $leerlingnummer;
  protected string $niveau;
  protected int $leerjaar;
}

?>
