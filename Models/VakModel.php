<?php
class VakModel extends EmptyModel {
  public string $vakCode;
  public string $naam;
  public string $niveau;
  public int $leerjaar;

  public function __construct($vakCode, $naam, $leerjaar, $niveau){
    $this->vakCode = $vakCode;
    $this->naam = $naam;
    $this->leerjaar = $leerjaar;
    $this->niveau = $niveau;
  }


  public static function getByVakCode($vakCode){
    $query = "
        SELECT * FROM Vak vm
        WHERE VAK_CODE = ?
    ";

    [$data] = DatabaseConnection::runPreparedQuery($query, [$vakCode], ["s"]);

    $object = new VakModel(
      $data["VAK_CODE"],
      $data["NAAM"],
      $data["LEERJAAR"],
      $data["NIVEAU"]
    );

    return $object;
  }
}
?>
