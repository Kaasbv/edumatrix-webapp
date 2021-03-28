<?php

class BeoordelingModel extends EmptyModel {
    public int $id;
    public string $klasId;
    public string $naam;
    public string $datum;
    public string $beschrijving;
    public string $opmerkingDocent;
    protected string $type;

    public function __construct($klasId, $naam, $datum, $beschrijving, $type){
        $this->klasId = $klasId;
        $this->naam = $naam;
        $this->datum = $datum;
        $this->beschrijving = $beschrijving;
        $this->type = $type;
    }

    public static function getAllByKlasId($klasId){
        $query = "
            SELECT * FROM BeoordelingModel
            WHERE KLAS_ID = ?
        ";

        $data = DatabaseConnection::runPreparedQuery($query, [$klasId], ["i"]);

        $objectArray = [];
        foreach ($data as $row) {
            $object = new BeoordelingModel(
                $row["KLAS_ID"],
                $row["NAAM"],
                $row["DATUM"],
                $row["BESCHRIJVING"],
                $row["TYPE"]
            );
    
            $object->id = $row["ID"];
            $object->opmerkingDocent = $row["OPMERKING_DOCENT"] ?? "";
            $objectArray[] = $object;
        }


        return $objectArray;
    }


    public function getCijfers(){
        return CijferModel::GetAll(["BEOORDELING_ID" => $this->id]);
    }
}
