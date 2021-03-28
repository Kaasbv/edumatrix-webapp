<?php

class CijferModel extends EmptyModel {
    public $toetsOpdrachtId;
    public $leerlingNummer;
    public $opmerkingDocent;
    public $cijfer;
    public $datumIngevoerd;
    public $datumToetsGemaakt;

    function __construct($leerlingNummer, $toetsOpdrachtId, $cijfer){
        $this->leerlingNummer = $leerlingNummer;
        $this->toetsOpdrachtId = $toetsOpdrachtId;
        $this->cijfer = $cijfer;
    }

    public static function getByIds($leerlingId, $toetsOpdrachtId){
        $query = "
            SELECT * FROM Cijfer cm
            WHERE TOETSOPDRACHT_ID = ? AND LEERLING_NUMMER = ?
        ";

        [$data] = DatabaseConnection::runPreparedQuery($query, [$toetsOpdrachtId, $leerlingId], ["i", "i"]);

        $object = new CijferModel(
            $data["LEERLING_NUMMER"],
            $data["TOETSOPDRACHT_ID"],
            $data["CIJFER"],
        );

        $object->opmerkingDocent = $data["OPMERKING_DOCENT"];
        $object->datumIngevoerd = $data["DATUM_INGEVOERD"] ?? "";
        $object->datumToetsGemaakt = $data["DATUM_TOETS_GEMAAKT"] ?? "";

        return $object;
    }

    public function update(){
        $query = "
            UPDATE Cijfer
            SET
                CIJFER=?,
                OPMERKING_DOCENT=?,
                DATUM_TOETS_GEMAAKT=?
            WHERE TOETSOPDRACHT_ID = ? AND LEERLING_NUMMER = ?
        ";

        DatabaseConnection::runPreparedQuery($query, [
            $this->cijfer,
            $this->opmerkingDocent ?? "",
            $this->datumToetsGemaakt, 
            $this->toetsOpdrachtId,
            $this->leerlingNummer
        ], ["d", "s", "s", "i", "i"]);
    }

    public function create(){
        $query = "
            INSERT INTO Cijfer
            (LEERLING_NUMMER, TOETSOPDRACHT_ID, CIJFER, OPMERKING_DOCENT, DATUM_TOETS_GEMAAKT)
            VALUES(?, ?, ?, ?, ?);
        ";

        DatabaseConnection::runPreparedQuery($query, [
            $this->leerlingNummer,
            $this->toetsOpdrachtId,
            $this->cijfer,
            $this->opmerkingDocent ?? "",
            $this->datumToetsGemaakt
        ], ["i", "i", "d", "s", "s"]);
    }

    public static function getAllByKlasNaam($klasnaam){
        $query = "
            SELECT cm.* FROM Cijfer cm
            INNER JOIN ToetsOpdracht tom on tom.TOETSOPDRACHT_ID = cm.TOETSOPDRACHT_ID
            WHERE tom.KLAS_NAAM = ?
        ";

        $data = DatabaseConnection::runPreparedQuery($query, [$klasnaam], ["s"]);

        $objectArray = [];
        foreach ($data as $row) {
            $object = new CijferModel(
                $row["LEERLING_NUMMER"],
                $row["TOETSOPDRACHT_ID"],
                $row["CIJFER"],
            );
;
            $object->opmerkingDocent = $row["OPMERKING_DOCENT"];
            $object->datumIngevoerd = $row["DATUM_INGEVOERD"] ?? "";
            $object->datumToetsGemaakt = $row["DATUM_TOETS_GEMAAKT"] ?? "";

            $objectArray[] = $object;
        }

        return $objectArray;
    }
}

?>
