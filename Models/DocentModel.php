<?php
class DocentModel extends GebruikerModel {
    public static $_tableName = "DocentModel";
    public static $_inheritanceColumn = "GEBRUIKER_ID";

    public string $docentCode;
    public int $id;

    public function getKlassen() {
        $docentKlassen = KlasModel::getAll(["DOCENT_ID" => $this->id]);
        return $docentKlassen;
    }
}

?>