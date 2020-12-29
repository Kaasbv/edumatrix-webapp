<?php
class DocentModel extends Model {
    public static $_tableName = "DocentModel";
    public static $_inheritanceColumn = "GEBRUIKER_ID";

    protected string $docentCode;
    protected int $id;

    public function getKlasDocent() {
        $docentKlassen = KlasModel::getAll(["DOCENT_ID" => $this->id]);
        return $docentKlassen;
    }
}

?>