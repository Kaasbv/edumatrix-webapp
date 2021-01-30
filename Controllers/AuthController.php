<?php
  class AuthController extends Controller{
    protected $layout = "auth";

    public function actionTestLogin(){
      var_dump(GebruikerModel::login("G.Zaad@gmail.com", "jemoeder1234"));
    }

    public function actionLogin(){
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $session = GebruikerModel::login($username, $password);

        if($session) {
          $this->redirect("/");
        } else {
          $this->renderView("Auth/login", ["error" => "Wollah dit is geen bestaande user"]);
        }
      } else {
        $this->renderView("Auth/login", ["error" => ""]);
      }
    }

    public function actionLogout(){
      Session::destroy();
      $this->redirect("/auth/login");
    }
  }