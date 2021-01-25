<?php
    class RoosterController extends Controller{
        public function actionAfwezigheidDocent(string $datumVanAf, string $datumTotMet){
            $this->datumVanAf = $datumVanAf;
            $this->datumTotMet = $datumTotMet;

            $lessen = RoosterDocent->Call();
            LesDocent::Destroy(int $lessen);

        }
    }
?>