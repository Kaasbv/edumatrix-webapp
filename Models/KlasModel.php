<?php
class KlasModel extends Model {
  public static $_tableName = "KlasModel";

  protected int $ID;
  protected string $KLAS_NAAM;
  protected int $AANTAL_LEERLINGEN;
  protected string $NIVEAU;
  protected int $LEERJAAR;
}
?>
