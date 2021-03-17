<?php
    class RoosterController extends Controller{
        //private int $user = Session::$user;
        private string $beginTijd;
        private string $eindTijd;
        private array $lessen;

        public function setTimeWeek(){
            if( isset($_GET["beginTijd"]) ){
                $dayN = date('N', $_GET["beginTijd"]);
                $this->beginTijd = date('Y-m-d', strtotime($_GET["beginTijd"] . "- $dayN")) . ' 00:00';
            }else{
                $this->beginTijd = date('Y-m-d', strtotime("this week")) . ' 00:00';
            }

            $this->eindTijd = date('Y-m-d', strtotime($this->beginTijd . "+ 1 week")) . ' 23:59';
        }

        public function actionIndex(){
            $this->setTimeWeek();
            //var_dump($this->beginTijd, $this->eindTijd);

            $this->lessen = Session::$user->getLessen($this->beginTijd, $this->eindTijd);

            viewRooster($this->beginTijd, $this->eindTijd, $this->lessen);
        
        }

    }

?>
