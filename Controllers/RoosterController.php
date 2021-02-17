<?php
    class RoosterController extends Controller{
        //private int $user = Session::$user;
        private string $beginTijd;
        private string $eindTijd;
        private array $lessen;
        
        public function setTimeWeek(){
            if( isset($_GET["beginTijd"]) ){
                $this->beginTijd = $_GET["beginTijd"];
            }else{
                $this->beginTijd = lower(GETDATE(), week);
            }

            $this->eindTijd = upper($this->beginTijd, week);
        }

        public function actionIndex(){
            $this->lessen = session::$user->getLessen($beginTijd, $eindTijd);

            viewRooster($beginTijd, $eindTijd, $lessen);
        }

    }
?>
<p>php:valid</p>