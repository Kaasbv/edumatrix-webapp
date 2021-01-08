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

<?php if (isset($_GET["leerlingID"])){ ?>
    <input type="hidden"  name="leerlingID" value="<?= $_GET["leerlingID"]?>">
<?php } ?>

<?php if (isset($_GET["beoordelingId"])){  ?>
    <input type="hidden"  name="beoordelingId" value="<?= $_GET["beoordelingId"]?>">
<?php } ?>

<?php if (isset($_GET["cijferId"])){ ?>
    <input type="hidden"  name="cijferId" value="<?= $_GET["cijferId"]?>">
<?php } ?>


  </form>

</div>



