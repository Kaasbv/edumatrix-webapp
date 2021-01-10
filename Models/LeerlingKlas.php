<?php
class LeerlingKlas extends Model {
  public static $_tableName = "LeerlingKlas";
  public int $id;
  public string $leerlingId;
  public string $klasId;
  public string $gebruikerID;

}
?>