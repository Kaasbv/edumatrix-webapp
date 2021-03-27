<?php
class VakModel extends EmptyModel {
  public int $id;
  public string $naam;
  public string $niveau;
  public int $leerjaar;

  public function __construct($vakId, $naam, $leerjaar, $niveau){
    $this->vakId = $vakId;
    $this->naam = $naam;
    $this->leerjaar = $leerjaar;
    $this->niveau = $niveau;
  }


  public static function getByVakId($vakId){
    $query = "
        SELECT * FROM VakModel vm
        WHERE ID = ?
    ";

    [$data] = DatabaseConnection::runPreparedQuery($query, [$vakId], ["i"]);

    $object = new VakModel(
      $data["ID"],
      $data["NAAM"],
      $data["LEERJAAR"],
      $data["NIVEAU"]
    );

    return $object;
  }
}
?>
