<?
  class Gebruiker extends Model {
    private $id;
    private $password;
    private $role;
    private $lastLoggedIn;
    private $profileImagePath;

    public $email;
    public $voornaam;
    public $tussenvoegsel;
    public $achternaam;
    public $geboortedatum;

    function __constructor($email, $password){
      $this->email = $email;
      $this->password = hashPassword($password);
    }

    private function hashPassword($plainPassword){
      return openssl_digest($plainPassword, "sha512");
    }
  }