<?php
class DocentModel extends Model {
    public static $_tableName = "docentModel";
    public static $_inheritanceColumn = "_GEBRUIKER_ID";

    protected string $code;
    protected int $id;

    public function getKlasDocent($id) {
        var_dump($this->id);
        exit();
        $docentKlassen = KlasModel::getAll(["DOCENT_ID" => $this->id]);

    }
}

?>