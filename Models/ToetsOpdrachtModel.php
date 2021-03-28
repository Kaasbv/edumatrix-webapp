<?php

class ToetsOpdrachtModel extends EmptyModel {
    public int $toetsopdrachtId;
    public string $klasNaam;
    public string $naam;
    public string $datum;
    public string $beschrijving;
    public string $opmerkingDocent;
    protected string $type;

    public function __construct($klasNaam, $naam, $datum, $beschrijving, $type){
        $this->klasNaam = $klasNaam;
        $this->naam = $naam;
        $this->datum = $datum;
        $this->beschrijving = $beschrijving;
        $this->type = $type;
    }

    public static function getAllByKlasNaam($klasNaam){
        $query = "
            SELECT * FROM ToetsOpdracht
            WHERE KLAS_NAAM = ?
        ";

        $data = DatabaseConnection::runPreparedQuery($query, [$klasNaam], ["s"]);

        $objectArray = [];
        foreach ($data as $row) {
            $object = new ToetsOpdrachtModel(
                $row["KLAS_NAAM"],
                $row["NAAM"],
                $row["DATUM"],
                $row["BESCHRIJVING"],
                $row["TYPE"]
            );
    
            $object->toetsopdrachtId = $row["TOETSOPDRACHT_ID"];
            $object->opmerkingDocent = $row["OPMERKING_DOCENT"] ?? "";
            $objectArray[] = $object;
        }


        return $objectArray;
    }
}
