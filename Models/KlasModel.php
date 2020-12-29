<?php
class KlasModel extends Model {
  public static $_tableName = "KlasModel";

  protected int $id;
  protected string $klasNaam;
  protected int $aantalLeerlingen;
  protected string $niveau;
  protected int $leerjaar;
}
?>
