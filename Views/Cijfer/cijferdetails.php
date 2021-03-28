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
    <?php if (isset($_GET["leerlingNummer"])){ ?>
        <input type="hidden"  name="leerlingNummer" value="<?= $_GET["leerlingNummer"]?>">
    <?php } ?>
    
    <?php if (isset($_GET["toetsOpdrachtId"])){  ?>
        <input type="hidden"  name="toetsOpdrachtId" value="<?= $_GET["toetsOpdrachtId"]?>">
    <?php } ?>
    
    <?php if (isset($_GET["klasNaam"])){ ?>
        <input type="hidden"  name="klasNaam" value="<?= $_GET["klasNaam"]?>">  
    <?php } ?>

    <?php if (!isset($context->cijfer->cijfer)){ ?>
        <input type="hidden"  name="new" value="1">
    <?php } ?>
    <input type="submit" value="Toepassen">
  </form>
</div>



