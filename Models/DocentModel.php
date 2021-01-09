<?php
class DocentModel extends GebruikerModel {
    public static $_tableName = "DocentModel";
    public static $_inheritanceColumn = "GEBRUIKER_ID";

    public $docentCode;
    public $id;

    public function getKlassen() {
        $docentKlassen = KlasModel::getAll(["DOCENT_ID" => $this->id]);
        return $docentKlassen;
    }
}

?>