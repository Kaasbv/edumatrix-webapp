<?php

class BeoordelingModel extends Model {
    public static $_tableName = "BeoordelingModel";

    public int $id;
    public string $klasId;
    public string $naam;
    public string $datum;
    public string $beschrijving;
    public string $opmerkingenDocent;
    protected string $type;


    public function getCijfers(){
        $CijfersFromBeoordeling = CijferModel::GetAll(["BEOORDELING_ID" => $this->id]);
        return $CijfersFromBeoordeling;
    }
}

?>