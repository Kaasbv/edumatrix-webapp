<?php

class RoosterModel extends Model {
    public static $_tableName = "RoosterModel";

    private int $id;
    private string $roosterCode;
   
    public function roosterWijziging(){
        return LesModel::GetAll(["LES_ID" => $this->id]);
    }
}

?>