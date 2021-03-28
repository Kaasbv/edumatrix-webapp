<h1>Klassenlijst</h1>

<div>
  <?php

    $klassenLength= count($context->klassen);

    for($klasIndex = 0; $klasIndex < $klassenLength; $klasIndex++)
    {
      echo "<a href='/cijfer/klas?klasNaam=" . $context->klassen[$klasIndex]->klasNaam .  "' class='ul'>" . $context->klassen[$klasIndex]->klasNaam . "</a>";
    }
  ?>
</div>