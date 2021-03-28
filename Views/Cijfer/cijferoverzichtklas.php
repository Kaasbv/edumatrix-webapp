<?php
  //Prepare variables
  $selectedToetsOpdrachtId = isset($_GET["toetsOpdrachtId"]) ? $_GET["toetsOpdrachtId"] : 0;
  $selectedLeerlingNummer = isset($_GET["leerlingNummer"]) ? $_GET["leerlingNummer"] : 0;  
?>
<div id="tableView">
  <table>
    <thead>
      <tr>
        <td></td>
        <?php foreach ($context->toetsOpdrachten as $toetsOpdracht): ?>
          <td><?= $toetsOpdracht->naam ?></td>
        <?php endforeach ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($context->leerlingen as $leerling): ?>
        <tr>
          <td><?= $leerling->getVolledigeNaam() ?></td>
          <?php foreach ($context->toetsOpdrachten as $toetsOpdracht): ?>
            <?php 
              //verkrijf cijfer waar toetsOpdrachtId en leerlingId staat
              $results = array_values(array_filter($context->cijfers, function($cijfer) use($leerling, $toetsOpdracht){
                return $cijfer->leerlingNummer === $leerling->leerlingNummer && $cijfer->toetsOpdrachtId === $toetsOpdracht->toetsopdrachtId;
              }));
              //Initialize every loop
              $cijfer = (object)[];
              $classes = [];
              //Set correct suffix
              $urlSuffix = "&toetsOpdrachtId={$toetsOpdracht->toetsopdrachtId}&leerlingNummer={$leerling->leerlingNummer}";

              if(count($results) > 0){//Er hoort een cijfer bij
                $cijfer = $results[0];
                //generate classes
                if($cijfer->cijfer < 5.5){
                  $classes[] = "onvoldoende";
                }
              }
              //generate classes
              if($selectedToetsOpdrachtId == $toetsOpdracht->toetsopdrachtId && $selectedLeerlingNummer == $leerling->leerlingNummer){
                $classes[] = "selected";
              }

              ?>
            <td class="<?= implode(" ", $classes) ?>">
              <a href="/cijfer/klas?klasNaam=<?= $context->klasNaam . $urlSuffix ?>">
                <?= isset($cijfer->cijfer) ? $cijfer->cijfer + 0 : "-" ?>
              </a>
            </td>
          <?php endforeach ?>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>

<?php 
  //Check of sidemenu zichtbaar moet zijn
  if($selectedToetsOpdrachtId && $selectedLeerlingNummer){//Een van de het variablen zijn actief
    $cijfer = (object)[];

    $cijfers = array_values(array_filter($context->cijfers, function($cijfer) use ($selectedToetsOpdrachtId, $selectedLeerlingNummer){
      return $cijfer->toetsOpdrachtId == $selectedToetsOpdrachtId && $cijfer->leerlingNummer == $selectedLeerlingNummer;
    }));

    if(count($cijfers) > 0){
      $cijfer = $cijfers[0];
    }
    //Render view
    $this->renderSubView("Cijfer/cijferdetails", ["cijfer" => $cijfer]);
  }
?>

<link rel="stylesheet" href="/cijfer.css">