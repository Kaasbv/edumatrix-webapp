<?
class ContactFormulierModel extends Model {
  public static $_tableName = "contactformuliermodel";

  protected $id;
  public $naam;
  public $bericht;

  public function getVerifyMessage($naam, $bericht){
    if(strlen($naam) < 3){
      return "Je naam is te kort";
    }
  }
}
?>