<?php

class GebruikerModel extends EmptyModel {
    public static $_tableName = "GebruikerModel";
    protected int $id;
    public string $email;
    public string $voornaam;
    protected string $tussenvoegsel;
    protected string $achternaam;
    protected string $geboortedatum; 
    protected string $password;
    public string $relatieRol;
    protected string $lastLoggedIn;
    protected string $pfImgPath;

    public static function getById($id){
        $query = "
            SELECT * FROM GebruikerModel vm
            WHERE ID = ?
        ";

        [$data] = DatabaseConnection::runPreparedQuery($query, [$id], ["i"]);

        $object = new GebruikerModel(
            $data["VOORNAAM"],
            $data["TUSSENVOEGSEL"],
            $data["ACHTERNAAM"]
        );

        self::fillObject($object, $data);

        return $object;
    }

    public function getVolledigeNaam(){
        if(isset($this->tussenvoegsel)){
            return "{$this->voornaam} {$this->tussenvoegsel} {$this->achternaam}";
        }else{
            return "{$this->voornaam} {$this->achternaam}";
        }
    }

    public function __construct($voornaam, $tussenvoegsel, $achternaam){
        $this->voornaam = $voornaam;
        if(isset($tussenvoegsel)){
            $this->tussenvoegsel = $tussenvoegsel;
        }
        $this->achternaam = $achternaam;
      }


    //password hash + salt
    public function changePassword($password){
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->save();
    }

    //password verifiëren
    public function checkPassword($password){
        $hash = $this->password;
        if (password_verify($password, $hash)) {
            return true;
        } else {
            return false;
        }
    }


    public static function login($email, $password){
        $user = GebruikerModel::getOne(["email" => $email]);
        if(!isset($user)){ 
            return false;
        }
        if ($user->checkPassword($password)){
            Session::saveUserId($user->id);
            return true;
        }
        else{
            return false;
        }
    }

    public function getLessen($begintijd, $eindtijd) {
        if($this->relatieRol === "leerling"){
            $lessen = LesModel::getPeriodeLeerling($this->id, $begintijd, $eindtijd);
        } else if($this->relatieRol === "docent"){
            $lessen = LesModel::getPeriodeDocent($this->id, $begintijd, $eindtijd);
        }
        return $lessen;
    }

    public function isAuthorized($arrayOfUserTypes){
        return in_array(Session::$user->relatieRol, $arrayOfUserTypes);
    }
}

?>
