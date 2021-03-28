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
        $query = "
            SELECT * FROM Les lm 
            INNER JOIN Docent dm on lm.DOCENT_CODE = dm.DOCENT_CODE
            INNER JOIN Klas km on lm.KLAS_NAAM = km.KLAS_NAAM
            WHERE lm.DOCENT_CODE = ? AND lm.DATUM_TIJD > ? AND lm.DATUM_TIJD < ?
        ";
        
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
        $query = "
            SELECT lm.* FROM Les lm
            INNER JOIN Docent dm on lm.DOCENT_CODE = dm.DOCENT_CODE
            INNER JOIN Klas km on lm.KLAS_NAAM = km.KLAS_NAAM
            INNER JOIN LeerlingKlas lk on lm.KLAS_NAAM = lk.KLAS_NAAM
            WHERE lk.LEERLING_NUMMER = ? AND lm.DATUM_TIJD > ? AND lm.DATUM_TIJD < ?
        ";
        
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