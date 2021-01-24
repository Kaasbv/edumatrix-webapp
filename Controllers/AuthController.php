<?php
  class AuthController extends Controller{      
    public function actionTestLogin(){
      var_dump(GebruikerModel::login("G.Zaad@gmail.com", "jemoeder1234"));
    }

    public function actionLogin(){
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $session = GebruikerModel::login($username, $password);
      } else {
        $this->renderView("Auth/placeholder_login", ["error" => "Waar is die POST ahhhh zehmer?"]);
        } if($session) {
          echo "OMFG IK BEN INGELOGD!!!";
          //$this->redirect("/dashboard");
          } else {
            $this->renderView("Auth/placeholder_login", ["error" => "Wollah dit is geen bestaande user"]);
          }
    }

    public function actionLogout(){
      Session::destroy();
      $this->redirect("/auth/login");
    }
  }