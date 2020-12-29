<?php

class BeoordelingModel extends Model {
    public static $_tableName = "BeoordelingModel";

    protected int $ID;
    protected string $VAK_ID;
    protected string $DATUM;
    protected string $BESCHRIJVING;
    protected string $OPMERKINGEN_DOCENT;
    protected string $TYPE;


    public function GetCijfers(){
        $CijfersFromBeoordeling = CijferModel::GetAll(["BEOORDELING_ID" => $this->ID]);
        return $CijfersFromBeoordeling;

    }

}

?>