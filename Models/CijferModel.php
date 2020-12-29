<?php

class CijferModel extends model {
    public static $_tableName = "CijferModel";

    protected int $id;
    protected int $beoordelingId;
    protected string $toets;
    protected int $cijfer;
    protected string $datumIngevoerd;
    protected string $datumToetsGemaakt;

}

?>
