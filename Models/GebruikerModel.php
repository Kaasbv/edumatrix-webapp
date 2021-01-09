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
}


?>
