<div id="cijferMenu">
  <form method="post" action="/cijfer/update">
    <label for="cijfer">Cijfer:</label><br>
    <input type="number" name="cijfer" id="cijfer" value="<?= $context->cijfer->cijfer ?? 0 ?>" step="0.1" min="0" max="10" required>
    <br>
    <label for="datum">Datum behaald:</label><br>
    <input type="date" name="datum" id="datum" value="<?= $context->cijfer->datumToetsGemaakt ?? "" ?>" required>
    <br>
    <label for="opmerkingen">Opmerkingen:</label>
    <textarea name="opmerkingen" id="opmerkingen"><?= $context->cijfer->opmerkingDocent ?? "" ?></textarea>
    <br>
    <?php if (isset($_GET["leerlingId"])){ ?>
        <input type="hidden"  name="leerlingId" value="<?= $_GET["leerlingId"]?>">
    <?php } ?>
    
    <?php if (isset($_GET["beoordelingId"])){  ?>
        <input type="hidden"  name="beoordelingId" value="<?= $_GET["beoordelingId"]?>">
    <?php } ?>
    
    <?php if (isset($_GET["cijferId"])){ ?>
        <input type="hidden"  name="cijferId" value="<?= $_GET["cijferId"]?>">
    <?php } ?>
    <?php if (isset($_GET["klasId"])){ ?>
        <input type="hidden"  name="klasId" value="<?= $_GET["klasId"]?>">  
    <?php } ?>
    <input type="submit" value="Toepassen">
  </form>
</div>



