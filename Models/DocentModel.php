<?php
class DocentModel extends Model {
    public static $_tableName = "DocentModel";
    public static $_inheritanceColumn = "_GEBRUIKER_ID";

    protected string $DOCENT_CODE;
    protected int $ID;

    public function getKlasDocent() {
        $docentKlassen = KlasModel::getAll(["DOCENT_ID" => $this->ID]);
        return $docentKlassen;
    }
}

?>