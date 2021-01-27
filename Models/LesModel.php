<?php

class LesModel extends Model {
    public static $_tableName = "LesModel";

    protected static $_joins = [
        [
          "foreignKey" => "KLAS_ID",
          "tableName" => "LeerlingKlas",
        ]
        [
            "foreignKey" => "DOCENT_ID",
            "tableName" => "DocentModel",
        ]
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