<div id="cijferMenu">
  <form action=".php"> <!--aanpassen-->
    <label for="cijfer">Cijfer:</label><br>
    <input type="number" name="cijfer" id="cijfer" step="0.1" min="0" max="10" >
    <br>
    <label for="datum">Datum behaald:</label><br>
    <input type="date" name="datum" id="datum">
    <br>
    <label for="opmerkingen">Opmerkingen:</label>
    <textarea name="opmerkingen" id="opmerkingen"></textarea>
    <br>
    <input type="submit" value="Toepassen">

<?php

  if (isset($_GET["leerlingID"]) === true){
    echo "leerlingId";
} 

  else if (isset($_GET["beoordelingId"]) === true){ 
    echo "beooordelingId";
}

  else if (isset($_GET["cijferId"]) === true) {
    echo "cijferId";

}

  else {
    return "jimmy is lekker";
}

?>


  </form>
</div>



