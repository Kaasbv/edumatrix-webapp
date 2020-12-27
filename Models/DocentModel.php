<?php
class KlasModel extends Model {
  public static $_tableName = "docentModel";
  public static $_inheritanceColumn = "_GEBRUIKER_ID";

    protected string $code;
    protected int $id;
}

?>