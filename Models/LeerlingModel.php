<?
class LeerlingModel extends Model { //TODO: wanneer gebruiker model avaiable is, die extenden
  public static $_tableName = "leerlingmodel";
  public static $_inheritanceColumn = "_GEBRUIKER_ID";
  public static $_primaryKey = "nummer";

  protected $nummer;
  protected $niveau;
}