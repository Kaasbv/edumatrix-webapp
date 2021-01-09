<?php
class LeerlingModel extends GebruikerModel { //TODO: wanneer gebruiker model avaiable is, die extenden
  public static $_tableName = "LeerlingModel";
  public static $_inheritanceColumn = "GEBRUIKER_ID";

  protected static $_joins = [
    [
      "foreignKey" => "LEERLING_ID",
      "tableName" => "LeerlingKlas",
    ]
  ];

  protected int $id;
  protected string $leerlingnummer;
  protected string $niveau;
  protected int $leerjaar;
}

?>
