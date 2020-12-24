<?php

class gebruikersModel extends Models {
    public static $_tableName = "gebruikersModel";

     protected id: int
     protected email: string
     protected voornaam: string
     protected tussenvoegsel: string
     protected achternaam: string
     protected geboortedatum: string
     protected password: string
     protected role: string
     protected lastLoggedIn: string
     protected profileImagePath: string

}


?>