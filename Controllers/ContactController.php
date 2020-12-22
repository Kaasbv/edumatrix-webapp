<?
  class ContactController extends Controller {
    public function actionIndex(){
      $this->renderView("Contact/index");
    }
    
    public function actionAanmaken(){
      //Verkrijg van post variablen
      $newnaam = $_POST["naam"];
      $newbericht = $_POST["bericht"];

      //Maak een model aan
      $contactform = new ContactFormulierModel();
      //check input
      $message = $contactform->getVerifyMessage($newnaam, $newbericht);
      if($message){
        $this->renderView("Contact/error", ["message" => $message]);
        return;
      }
      //Pas aan en sla op
      $contactform->naam = $newnaam;
      $contactform->bericht = $newbericht;
      $contactform->save();
      $this->renderView("Contact/success");
    }
  }
