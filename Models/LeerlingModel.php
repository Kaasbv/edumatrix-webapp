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
  protected string $leerlingnummer;
  protected string $niveau;
  protected int $leerjaar;
}

?>
