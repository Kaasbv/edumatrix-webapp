<?php
class DocentModel extends GebruikerModel {
    public static $_tableName = "DocentModel";
    public static $_inheritanceColumn = "GEBRUIKER_ID";

    public string $docentCode;
    public int $id;
    public int $roosterId;

    function __construct($docentCode)
    {
        $this->docentCode = $docentCode;
    }

    public function getKlassen() {
        return KlasModel::getAll(["DOCENT_ID" => $this->id]);
    }

    public static function getByDocentId($docentId){
        $query = "
            SELECT
                dm.*,
                gm.EMAIL,
                gm.VOORNAAM,
                gm.TUSSENVOEGSEL,
                gm.ACHTERNAAM,
                gm.GEBOORTEDATUM,
                gm.PASSWORD,
                gm.RELATIE_ROL,
                gm.LAST_LOGGED_IN,
                gm.PF_IMG_PATH
            FROM DocentModel dm
            LEFT JOIN GebruikerModel gm ON dm.GEBRUIKER_ID = gm.ID
            WHERE dm.ID = ?
        ";

        [$data] = DatabaseConnection::runPreparedQuery($query, [$docentId], ["i"]);

        $object = new DocentModel($data["DOCENT_CODE"]);
        self::fillObject($object, $data);
        

        return $object;
    }

    public static function getByUserId($userId){
        $query = "
            SELECT
                dm.*,
                gm.EMAIL,
                gm.VOORNAAM,
                gm.TUSSENVOEGSEL,
                gm.ACHTERNAAM,
                gm.GEBOORTEDATUM,
                gm.PASSWORD,
                gm.RELATIE_ROL,
                gm.LAST_LOGGED_IN,
            gm.PF_IMG_PATH
            FROM DocentModel dm
            LEFT JOIN GebruikerModel gm on gm.ID = dm.GEBRUIKER_ID
            WHERE GEBRUIKER_ID = ?
        ";

        [$data] = DatabaseConnection::runPreparedQuery($query, [$userId], ["i"]);

        $object = new DocentModel($data["DOCENT_CODE"]);
        self::fillObject($object, $data);
        return $object;
    }

}

?>