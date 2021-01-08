<?php

class CijferModel extends model {
    public static $_tableName = "CijferModel";

    protected $id;
    protected $leerlingId;
    protected $beoordelingId;
    protected $toets;
    protected $cijfer;
    protected $datumIngevoerd;
    protected $datumToetsGemaakt;
}

?>
