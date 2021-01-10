<h1>Klassenlijst</h1>

<div>
  <?php

    $klassenLength= count($context->klassen);

    for($klasIndex = 0; $klasIndex < $klassenLength; $klasIndex++)
    {
      echo "<a href='/cijfer/klas?klasId=" . $context->klassen[$klasIndex]->id .  "' class='ul'>" . $context->klassen[$x]->klasNaam;
      echo "<br>";
    }
  ?>
</div>