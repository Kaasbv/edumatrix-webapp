<?php

class LesModel extends Model {
    public static $_tableName = "LesModel";

    protected static $_joins = [
        [
            "primaryKey" => "DOCENT_ID",
            "foreignKey" => "ID",
            "tableName" => "DocentModel",
        ],
        [
            "primaryKey" => "KLAS_ID",
            "foreignKey" => "ID",
            "tableName" => "KlasModel",
        ],
        [
            "foreignKey" => "KLAS_ID",
            "primaryKey" => "KLAS_ID",
            "tableName" => "LeerlingKlas",
        ],
    ];

    private int $id;
    private string $datumTijd;
    private string $beschrijving;
    private int $vakId;
    private int $duurMinuten;
    private int $roosterId;
    private int $docentId;
    private int $klasId;
}

?>