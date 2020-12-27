<?php

class gebruikersModel extends Model {
    public static $_tableName = "gebruikersModel";

     protected int $id;
     protected string $email;
     protected string $voornaam;
     protected string $tussenvoegsel;
     protected string $achternaam;
     protected string $geboortedatum; 
     protected string $password;
     protected string $role;
     protected string $lastLoggedIn;
     protected string $profileImagePath; 

}


?>
