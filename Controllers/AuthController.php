<?php
  class AuthController extends Controller{      
    public function actionTestLogin(){
      var_dump(GebruikerModel::login("G.Zaad@gmail.com", "jemoeder1234"));
    }

    public function actionLogin(){
      //LVS-113 Hoi nassim
      $this->renderView("Auth/placeholder_login", ["error" => "poep"]);
    }

    public function actionLogout(){
      Session::destroy();
      $this->redirect("/auth/login");
    }
  }