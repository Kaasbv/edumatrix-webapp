<?php
class DocentModel extends GebruikerModel {
    public static $_tableName = "DocentModel";
    public static $_inheritanceColumn = "GEBRUIKER_ID";

    public $docentCode;
    public $id;

    public function getKlasDocent() {
        $docentKlassen = KlasModel::getAll(["DOCENT_ID" => $this->id]);
        return $docentKlassen;
    }
}

?>