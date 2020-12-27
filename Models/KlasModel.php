<?php
class KlasModel extends Model {
  public static $_tableName = "klasModel";

  protected int $id;
  protected string $naam;
  protected int $aantalLeerlingen;
  protected string $niveau;
  protected int $leerjaar;
}
?>
