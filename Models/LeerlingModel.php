<?php
class LeerlingModel extends Model { //TODO: wanneer gebruiker model avaiable is, die extenden
  public static $_tableName = "leerlingmodel";
  public static $_inheritanceColumn = "_GEBRUIKER_ID";
  public static $_primaryKey = "nummer";

  protected string $nummer;
  protected string $niveau;
  protected int $leerjaar
}

?>