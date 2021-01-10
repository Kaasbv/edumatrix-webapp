<?php

class CijferModel extends Model {
    public static $_tableName = "CijferModel";

    protected static $_joins = [
        [
            "primaryKey" => "BEOORDELING_ID",
            "foreignKey" => "ID",
            "tableName" => "BeoordelingModel",
        ],
        [
          "primaryKey" => "KLAS_ID",
          "primaryTableName" => "BeoordelingModel",
          "foreignKey" => "ID",
          "tableName" => "KlasModel",
        ]
    ];

    public $id;
    public $leerlingId;
    public $beoordelingId;
    public $opmerkingDocent;
    public $cijfer;
    public $datumIngevoerd;
    public $datumToetsGemaakt;

    function __construct($leerlingId, $beoordelingId, $cijfer){
        $this->leerlingId = $leerlingId;
        $this->beoordelingId = $beoordelingId;
        $this->cijfer = $cijfer;
    }
}

?>
