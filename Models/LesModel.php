<?php

class LesModel extends EmptyModel {
    public int $lesId;
    public string $datumTijd;
    public string $beschrijving;
    public string $vakCode;
    public int $duurMinuten;
    public string $docentCode;
    public string $klasNaam;
    public string $lokaalNummer;

    static function getPeriodeDocent($docentCode, $startDate, $endDate){
        $query = "CALL getPeriodeDocent(?, ?, ?);";
        
        $data = DatabaseConnection::runPreparedQuery($query, [$docentCode, $startDate, $endDate], ["s", "s", "s"]);

        $objectArray = [];
        foreach ($data as $row) {
            $object = new LesModel();
            self::fillObject($object, $row);

            $object->docent = DocentModel::getByDocentCode($object->docentCode);
            $object->klas = KlasModel::getByKlasNaam($object->klasNaam);
            $object->vak = VakModel::getByVakCode($object->vakCode);

            $objectArray[] = $object;
        }

        return $objectArray;
    }

    static function getPeriodeLeerling($leerlingNummer, $startDate, $endDate){
        $query = "CALL getPeriodeLeerling(?, ?, ?);";
        
        $data = DatabaseConnection::runPreparedQuery($query, [$leerlingNummer, $startDate, $endDate], ["i", "s", "s"]);

        $objectArray = [];
        foreach ($data as $row) {
            $object = new LesModel();
            self::fillObject($object, $row);

            $object->docent = DocentModel::getByDocentCode($object->docentCode);
            $object->klas = KlasModel::getByKlasNaam($object->klasNaam);
            $object->vak = VakModel::getByVakCode($object->vakCode);

            $objectArray[] = $object;
        }

        return $objectArray;
    }
}

?>