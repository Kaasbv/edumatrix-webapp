<?php

class LesModel extends Model {
    public static $_tableName = "LesModel";

    protected static $_joins = [
        [
            "foreignKey" => "DOCENT_ID",
            "tableName" => "DocentModel",
        ],
        [
            "foreignKey" => "KLAS_ID",
            "tableName" => "KlasModel",
        ],
        [
            "foreignKey" => "KLAS_ID",
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