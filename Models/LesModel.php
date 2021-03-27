<?php

class LesModel extends EmptyModel {
    public static $_tableName = "LesModel";
    
    public int $id;
    public string $datumTijd;
    public string $beschrijving;
    public int $vakId;
    public int $duurMinuten;
    public int $roosterId;
    public int $docentId;
    public int $klasId;

    static function getPeriodeDocent($docentId, $startDate, $endDate){
        $query = "
            SELECT * FROM LesModel lm 
            left join DocentModel dm on lm.DOCENT_ID = dm.ID 
            left join KlasModel km on lm.KLAS_ID = km.ID
            where lm.DOCENT_ID = ? AND lm.DATUM_TIJD > ? AND lm.DATUM_TIJD < ?
        ";
        
        $data = DatabaseConnection::runPreparedQuery($query, [$docentId, $startDate, $endDate], ["i", "s", "s"]);

        $objectArray = [];
        foreach ($data as $row) {
            $object = new LesModel();
            self::fillObject($object, $row);

            $object->docent = DocentModel::getByDocentId($object->docentId);
            $object->klas = KlasModel::getByKlasId($object->klasId);
            $object->vak = VakModel::getByVakId($object->vakId);

            $objectArray[] = $object;
        }

        return $objectArray;
    }

    static function getPeriodeLeerling($leerlingId, $startDate, $endDate){
        $query = "
            SELECT lm.* FROM LesModel lm
            left join DocentModel dm on lm.DOCENT_ID = dm.ID
            left join KlasModel km on lm.KLAS_ID = km.ID
            left join LeerlingKlas lk on lm.KLAS_ID = lk.KLAS_ID
            where lk.LEERLING_ID = ? AND lm.DATUM_TIJD > ? AND lm.DATUM_TIJD < ?
        ";
        
        $data = DatabaseConnection::runPreparedQuery($query, [$leerlingId, $startDate, $endDate], ["i", "s", "s"]);

        $objectArray = [];
        foreach ($data as $row) {
            $object = new LesModel();
            self::fillObject($object, $row);

            $object->docent = DocentModel::getByDocentId($object->docentId);
            $object->klas = KlasModel::getByKlasId($object->klasId);
            $object->vak = VakModel::getByVakId($object->vakId);

            $objectArray[] = $object;
        }

        return $objectArray;
    }
}

?>