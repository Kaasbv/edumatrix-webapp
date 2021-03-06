<?php

class RoosterController extends Controller {
    public function actionRoosteroverzicht(){
        $dayNumber = date("w") - 1;
        if($dayNumber === -1) $dayNumber = 6;

        if(!isset($_GET["startDate"])){
            $startDate = date('Y-m-d', strtotime(date('d-m-Y') . " - " . $dayNumber  . " days")) . " 00:00:00";
        }else{
            $startDate = $_GET["startDate"];
        }

        if(!isset($_GET["endDate"])){
            $endDate = date('Y-m-d', strtotime(date('d-m-Y') . " + " . (7 - $dayNumber) . " days")) . " 23:59:00";
        }else{
            $endDate = $_GET["endDate"];
        }

        $lessen = Session::$user->getLessen($startDate, $endDate);
        
        $this->renderView("rooster/roosterweergave", [
            "lessen" => $lessen,
            "startDate" => $startDate,
            "endDate" =>$endDate
        ]);
    }
}
?>