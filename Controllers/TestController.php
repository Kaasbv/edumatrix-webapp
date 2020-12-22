<?
  class TestController extends Controller {
    public function actionIndex(){
      
      
      $this->renderView("Test/index");
    }
    
    public function actionAanpassen(){
      $newbericht = $_POST["bericht"];
      $contactform = new ContactFormulier();

      $contactform->naam = "test";
      $contactform->bericht = $newbericht;
      $contactform->save();
    }
  }
