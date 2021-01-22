<?php
class Session {
  public static $user;

  public static function saveUserId($userId){
    $_SESSION["userId"] = $userId;
  }

  public static function init(){
    session_start();
    if(isset($_SESSION) && isset($_SESSION["userId"])){
      $user = GebruikerModel::getOne(["id" => $_SESSION["userId"]]);
      if($user){
        switch($user->relatieRol){
          case "leerling":
            self::$user = LeerlingModel::getOne(["gebruiker_id" => $_SESSION["userId"]]);
            break;
          case "docent":
            self::$user = DocentModel::getOne(["gebruiker_id" => $_SESSION["userId"]]);
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
    unset(self::$user);
  }
}