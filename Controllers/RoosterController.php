<?php
    class RoosterController extends Controller{
        private string $datumVanAf;
        private string $datumTotMet;
        
        public function actionAfwezigheidDocent(string $datumVanAf, string $datumTotMet){
            $this->datumVanAf = $datumVanAf;
            $this->datumTotMet = $datumTotMet;

            $lessen = RoosterDocent->Call();
            LesDocent::Destroy(int $lessen);

        }
    }
?>