<?php
class Session {
  public static $user;

  public static function saveEmail($email){
    $_SESSION["email"] = $email;
  }

  public static function init(){
    session_start();
    if(isset($_SESSION) && isset($_SESSION["email"])){
      $user = GebruikerModel::getByEmail($_SESSION["email"]);
      if($user){
        switch($user->relatieRol){
          case "leerling":
            self::$user = LeerlingModel::getByEmail($_SESSION["email"]);
            break;
          case "docent":
            self::$user = DocentModel::getByEmail($_SESSION["email"]);
            break;
          case "ouder":
            throw new Exception("Ouder not implemented yet", 500);
          default:
            throw new Exception("Unknown relatie {$user->relatieRol}", 500);
        }
      }
    }
  }

  public static function destroy(){
    session_destroy();
    self::$user = null;
  }
}