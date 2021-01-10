<?php
  //Prepare variables
  $selectedCijferId = isset($_GET["cijferId"]) ? $_GET["cijferId"] : 0;
  $selectedBeoordelingId = isset($_GET["beoordelingId"]) ? $_GET["beoordelingId"] : 0;
  $selectedLeerlingId = isset($_GET["leerlingId"]) ? $_GET["leerlingId"] : 0;  
?>
<div id="tableView">
  <table>
    <thead>
      <tr>
        <td></td>
        <?php foreach ($context->beoordelingen as $beoordeling): ?>
          <td><?= $beoordeling->naam ?></td>
        <?php endforeach ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($context->leerlingen as $leerling): ?>
        <tr>
          <td><?= $leerling->getVolledigeNaam() ?></td>
          <?php foreach ($context->beoordelingen as $beoordeling): ?>
            <?php 
              //verkrijf cijfer waar beoordelingId en leerlingId staat
              $results = array_values(array_filter($context->cijfers, function($cijfer) use($leerling, $beoordeling){
                return $cijfer->leerlingId === $leerling->id && $cijfer->beoordelingId === $beoordeling->id;
              }));
              //Initialize every loop
              $cijfer = (object)[];
              $classes = [];

              if(count($results) > 0){//Er hoort een cijfer bij
                $cijfer = $results[0];
                //Set correct suffix
                $urlSuffix = "&cijferId={$cijfer->id}";
                //generate classes
                if($cijfer->cijfer < 5.5){
                  $classes[] = "onvoldoende";
                }
                if($selectedCijferId == $cijfer->id){
                  $classes[] = "selected";
                }
              }else{
                //Set correct suffix
                $urlSuffix = "&beoordelingId={$beoordeling->id}&leerlingId={$leerling->id}";
                //generate classes
                if($selectedBeoordelingId == $beoordeling->id && $selectedLeerlingId == $leerling->id){
                  $classes[] = "selected";
                }
              }

              ?>
            <td class="<?= implode(" ", $classes) ?>">
              <a href="/cijfer/klas?klasId=<?= $context->klasId . $urlSuffix ?>"><?= $cijfer->cijfer ?? "-" ?></a>
            </td>
          <?php endforeach ?>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>

<?php 
  //Check of sidemenu zichtbaar moet zijn
  if($selectedCijferId || ($selectedBeoordelingId && $selectedLeerlingId)){//Een van de het variablen zijn actief
    $cijfer = (object)[];
    //Prepare data if needed
    if($selectedCijferId){
      $cijfers = array_values(array_filter($context->cijfers, function($cijfer){
        return $cijfer->id == $_GET["cijferId"];
      }));

      if(count($cijfers) > 0){
        $cijfer = $cijfers[0];
      }
    }
    //Render view
    $this->renderSubView("Cijfer/cijferdetails", ["cijfer" => $cijfer]);
  }
?>

<link rel="stylesheet" href="/cijfer.css">