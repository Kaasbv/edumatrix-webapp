<?php

class CijferModel extends Model {
    public static $_tableName = "CijferModel";

    protected static $_relations = [
        [
            "model" => BeoordelingModel, //Bevat Model waarmee je de relatie aangaat
            "fromProperty" => "beoordelingId", //de property in deze ($this) model
            "toProperty" => "id", //de property in het 
        ],
        [
            "model" => KlasModel, //Bevat Model waarmee je de relatie aangaat
            "fromModel" => BeoordelingModel, //Bevat in sommige gevallen het model waarvanaf gejoined wordt als er dubbel wordt gejoined 
            "fromProperty" => "klasId", //de property in deze ($this) model
            "toProperty" => "id", //de property in het 
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
