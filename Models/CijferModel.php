<?php

class CijferModel extends EmptyModel {
    public static $_tableName = "CijferModel";

    public $id;
    public $leerlingId;
    public $beoordelingId;
    public $opmerkingDocent;
    public $cijfer;
    public $datumIngevoerd;
    public $datumToetsGemaakt;

    function __construct($leerlingId, $beoordelingId, $cijfer){
        $this->leerlingId = $leerlingId;
        $this->beoordelingId = $beoordelingId;
        $this->cijfer = $cijfer;
    }

    public static function getById($id){
        $query = "
            SELECT * FROM CijferModel cm
            WHERE ID = ?
        ";

        [$data] = DatabaseConnection::runPreparedQuery($query, [$id], ["i"]);

        $object = new CijferModel(
            $data["LEERLING_ID"],
            $data["BEOORDELING_ID"],
            $data["CIJFER"],
        );

        $object->id = $data["ID"];
        $object->opmerkingDocent = $data["OPMERKING_DOCENT"];
        $object->datumIngevoerd = $data["DATUM_INGEVOERD"] ?? "";
        $object->datumToetsGemaakt = $data["DATUM_TOETS_GEMAAKT"] ?? "";


        return $object;
    }

    public function update(){
        $query = "
            UPDATE CijferModel
            SET
                CIJFER=?,
                OPMERKING_DOCENT=?,
                DATUM_TOETS_GEMAAKT=?
            WHERE ID=?;
        ";

        DatabaseConnection::runPreparedQuery($query, [$this->cijfer, $this->opmerkingDocent ?? "", $this->datumToetsGemaakt, $this->id], ["d", "s", "s", "i"]);
    }

    public function create(){
        $query = "
            INSERT INTO CijferModel
            (LEERLING_ID, BEOORDELING_ID, CIJFER, OPMERKING_DOCENT, DATUM_TOETS_GEMAAKT)
            VALUES(?, ?, ?, ?, ?);
        ";

        DatabaseConnection::runPreparedQuery($query, [
            $this->leerlingId,
            $this->beoordelingId,
            $this->cijfer,
            $this->opmerkingDocent ?? "",
            $this->datumToetsGemaakt
        ], ["i", "i", "d", "s", "s"]);
    }

    public static function getAllByKlasId($klasId){
        $query = "
            SELECT cm.* FROM CijferModel cm
            INNER JOIN BeoordelingModel bm on bm.ID = cm.BEOORDELING_ID 
            WHERE bm.KLAS_ID = ?
        ";

        $data = DatabaseConnection::runPreparedQuery($query, [$klasId], ["i"]);

        $objectArray = [];
        foreach ($data as $row) {
            $object = new CijferModel(
                $row["LEERLING_ID"],
                $row["BEOORDELING_ID"],
                $row["CIJFER"],
            );

            $object->id = $row["ID"];
            $object->opmerkingDocent = $row["OPMERKING_DOCENT"];
            $object->datumIngevoerd = $row["DATUM_INGEVOERD"] ?? "";
            $object->datumToetsGemaakt = $row["DATUM_TOETS_GEMAAKT"] ?? "";

            $objectArray[] = $object;
        }


        return $objectArray;
    }
}

?>
