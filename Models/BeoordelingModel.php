<?php

class BeoordelingModel extends Model {
    public static $_tableName = "BeoordelingModel";

    protected int $id;
    protected string $vak;
    protected string $datum;
    protected string $beschrijving;
    protected string $opmerkingenDocent;
    protected string $type;


    public function getCijfers(){
        $CijfersFromBeoordeling = CijferModel::GetAll(["BEOORDELING_ID" => $this->ID]);
        return $CijfersFromBeoordeling;
    }

}

?>