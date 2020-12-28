<?php
class BeoordelingModel extends Model {
  public static $_tableName = "Beoordeling";
  
  protected int $id;
  public string $vak;
  public string $datum;
  public string $beschrijving;
  protected string $docentOpmerkingen;
}
?>