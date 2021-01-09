<?php
class KlasModel extends Model {
  public static $_tableName = "KlasModel";

  public int $id;
  public string $klasNaam;
  protected int $aantalLeerlingen;
  protected string $niveau;
  protected int $leerjaar;
}
?>
