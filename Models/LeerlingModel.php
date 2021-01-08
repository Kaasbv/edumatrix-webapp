<?php
class LeerlingModel extends Model { //TODO: wanneer gebruiker model avaiable is, die extenden
  public static $_tableName = "LeerlingModel";
  public static $_inheritanceColumn = "_GEBRUIKER_ID";
  public static $_primaryKey = "nummer";

  protected static $_joins = [
    [
      "foreignKey" => "LEERLING_ID",
      "tableName" => "LeerlingKlas",
    ]
  ];

  protected string $id;
  protected string $leerlingnummer;
  protected string $niveau;
  protected int $leerjaar;
}

?>
