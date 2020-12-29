<?php

class CijferModel extends model {
    public static $_tableName = "CijferModel";

    protected int $ID;
    protected int $BEOORDELING_ID;
    protected string $TOETS;
    protected int $CIJFER;
    protected string $DATUM_INGEVOERD;
    protected string $DATUM_TOETS_GEMAAKT;

}

?>
