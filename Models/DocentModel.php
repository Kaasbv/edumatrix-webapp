<?php
class DocentModel extends GebruikerModel {
    public string $docentCode;

    function __construct($docentCode)
    {
        $this->docentCode = $docentCode;
    }

    public function getKlassen() {
        return KlasModel::getAllByDocentCode($this->docentCode);
    }

    public static function getByDocentCode($docentCode){
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
            FROM Docent dm
            LEFT JOIN Gebruiker gm ON dm.GEBRUIKER_EMAIL = gm.EMAIL
            WHERE dm.DOCENT_CODE = ?
        ";

        [$data] = DatabaseConnection::runPreparedQuery($query, [$docentCode], ["s"]);

        return new DocentModel($data["DOCENT_CODE"]);
    }

    public static function getByEmail($email){
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
            FROM Docent dm
            LEFT JOIN Gebruiker gm on gm.EMAIL = dm.GEBRUIKER_EMAIL
            WHERE GEBRUIKER_EMAIL = ?
        ";

        [$data] = DatabaseConnection::runPreparedQuery($query, [$email], ["s"]);

        $object = new DocentModel($data["DOCENT_CODE"]);
        self::fillObject($object, $data);
        return $object;
    }

}

?>