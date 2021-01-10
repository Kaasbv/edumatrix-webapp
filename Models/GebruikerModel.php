<?php

class GebruikerModel extends Model {
    public static $_tableName = "GebruikerModel";
    protected int $id;
    protected string $email;
    protected string $voornaam;
    protected string $tussenvoegsel;
    protected string $achternaam;
    protected string $geboortedatum; 
    protected string $password;
    protected string $relatieRol;
    protected string $lastLoggedIn;
    protected string $pfImgPath; 

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
}


?>
