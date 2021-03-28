<?php

class GebruikerModel extends EmptyModel {
    public string $email;
    public string $voornaam;
    protected string $tussenvoegsel;
    protected string $achternaam;
    protected string $geboortedatum; 
    protected string $password;
    public string $relatieRol;
    protected string $lastLoggedIn;
    protected string $pfImgPath;


    public static function getByEmail($email){
        $query = "
            SELECT * FROM Gebruiker vm
            WHERE EMAIL = ?
        ";

        [$data] = DatabaseConnection::runPreparedQuery($query, [$email], ["s"]);

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
        $user = GebruikerModel::getByEmail($email);
        if(!isset($user)){ 
            return false;
        }
        if ($user->checkPassword($password)){
            Session::saveEmail($user->email);
            return true;
        }
        else{
            return false;
        }
    }

    public function getLessen($begintijd, $eindtijd) {
        if($this->relatieRol === "leerling"){
            $lessen = LesModel::getPeriodeLeerling($this->leerlingNummer, $begintijd, $eindtijd);
        } else if($this->relatieRol === "docent"){
            $lessen = LesModel::getPeriodeDocent($this->docentCode, $begintijd, $eindtijd);
        }
        return $lessen;
    }

    public function isAuthorized($arrayOfUserTypes){
        return in_array(Session::$user->relatieRol, $arrayOfUserTypes);
    }
}

?>
