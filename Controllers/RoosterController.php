<?php
class RoosterController extends Controller {
    public function actionGetles(){
        $les = LesModel::getOne(["id" => $_GET["lesId"]]);
        $this->renderView("Rooster/lesoverzicht", ["les" => $les]);
    }
}