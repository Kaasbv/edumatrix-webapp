<?php

class RoosterController extends Controller {

    public function actionRoosteroverzicht(){
        $this->renderView("rooster/roosterweergave");
    }
}
?>