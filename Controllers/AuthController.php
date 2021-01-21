<?php
  class AuthController extends Controller{      
      public function actionTestLogin(){
      var_dump(GebruikerModel::login("G.Zaad@gmail.com", "jemoeder1234"));
    }
  }