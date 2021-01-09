<?php

class CijferModel extends model {
    protected static $_tableName = "CijferModel";

    public $id;
    public $leerlingId;
    public $beoordelingId;
    public $opmerkingDocent;
    public $cijfer;
    public $datumIngevoerd;
    public $datumToetsGemaakt;
}

?>
