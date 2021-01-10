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

  public function __construct($leerlingnummer, $gebruikerId, $niveau, $leerjaar){
    $this->leerlingnummer = $leerlingnummer;
    $this->gebruikerId = $gebruikerId;
    $this->niveau = $niveau;
    $this->leerjaar = $leerjaar;
  }
}

?>
