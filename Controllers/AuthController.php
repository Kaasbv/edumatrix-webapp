<?php
  class AuthController extends Controller{
    protected $layout = "auth";

    public function actionLogin(){
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $session = GebruikerModel::login($username, $password);

        if($session) {
          $this->redirect("/");
        } else {
          $this->renderView("Auth/login", ["error" => "Email of wachtwoord fout"]);
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