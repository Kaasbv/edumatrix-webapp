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
            left join Docent dm on lm.DOCENT_CODE = dm.DOCENT_CODE
            left join Klas km on lm.KLAS_NAAM = km.KLAS_NAAM
            where lm.DOCENT_CODE = ? AND lm.DATUM_TIJD > ? AND lm.DATUM_TIJD < ?
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
            left join Docent dm on lm.DOCENT_CODE = dm.DOCENT_CODE
            left join Klas km on lm.KLAS_NAAM = km.KLAS_NAAM
            left join LeerlingKlas lk on lm.KLAS_NAAM = lk.KLAS_NAAM
            where lk.LEERLING_NUMMER = ? AND lm.DATUM_TIJD > ? AND lm.DATUM_TIJD < ?
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