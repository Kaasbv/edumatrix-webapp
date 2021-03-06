<h1 id = "Maand"><?php echo date("F", strtotime($context->startDate))?></h1>
<h2 id = "Week">Week <?php echo date("W", strtotime($context->startDate))?></h2>

<?php
$lessen = [
  (object)[
    "datumTijd" => "2021-03-05 15:00",
    "duur" => 80,
    "docent" => (object) ["code" => "Jimmy"],
    "klas" => (object) ["naam" => "HVA1"],
    "vak" => (object) ["naam" => "Wiskunde"]
  ],
  (object)[
    "datumTijd" => "2021-03-02 09:00",
    "duur" => 120,
    "docent" => (object) ["code" => "Ben"],
    "klas" => (object) ["naam" => "HVA1"],
    "vak" => (object) ["naam" => "Duits"]
  ],
  (object)[
    "datumTijd" => "2021-03-04 09:00",
    "duur" => 120,
    "docent" => (object) ["code" => "Nassim"],
    "klas" => (object) ["naam" => "HVA1"],
    "vak" => (object) ["naam" => "Nederlands"]
  ],
  (object)[
    "datumTijd" => "2021-03-04 08:00",
    "duur" => 50,
    "docent" => (object) ["code" => "Jimmy"],
    "klas" => (object) ["naam" => "HVA1"],
    "vak" => (object) ["naam" => "Wiskunde"]
  ],
  (object)[
    "datumTijd" => "2021-03-04 12:00",
    "duur" => 60,
    "docent" => (object) ["code" => "Marijn"],
    "klas" => (object) ["naam" => "HVA1"],
    "vak" => (object) ["naam" => "Frans"]
  ],
  (object)[
    "datumTijd" => "2021-03-03 10:00",
    "duur" => 120,
    "docent" => (object) ["code" => "Ben"],
    "klas" => (object) ["naam" => "HVA1"],
    "vak" => (object) ["naam" => "Aardrijkskunde"]
  ],
  (object)[
    "datumTijd" => "2021-03-05 10:00",
    "duur" => 120,
    "docent" => (object) ["code" => "Katya"],
    "klas" => (object) ["naam" => "HVA1"],
    "vak" => (object) ["naam" => "Russisch"]
  ],
];

?>




<div id = "Rooster">
  <?php
    $prefixUrl = "/rooster/roosteroverzicht";

    $pastWeekStart = urlencode(date("Y-m-d", strtotime($context->startDate . " - 1 weeks")) . " 00:00:00");
    $pastWeekEnd = urlencode(date("Y-m-d", strtotime($context->endDate . " - 1 weeks")) . " 23:59:00");
    $pastUrl = $prefixUrl . "?startDate={$pastWeekStart}&endDate={$pastWeekEnd}";

    $nextWeekStart = urlencode(date("Y-m-d", strtotime($context->startDate . " + 1 weeks")) . " 00:00:00");
    $nextWeekEnd = urlencode(date("Y-m-d", strtotime($context->endDate . " + 1 weeks")) . " 23:59:00");
    $nextUrl = $prefixUrl . "?startDate={$nextWeekStart}&endDate={$nextWeekEnd}";
  ?>

  <button class="back" onclick="window.location.href='<?= $pastUrl ?>'">Vorige Week</button>
  <button class="button" onclick="window.location.href='<?= $nextUrl ?>'">Volgende</button>


    <table id = "RoosterWeergave">
        <thead>
            <tr>
                <th class = "dagWeergave"></th>
                <?php
                    for ($y = 0; $y <7; $y++ ) {
                        echo "<th class = 'dagWeergave'>";
                        echo "<div class = 'dag'></div>";
                        echo date('D d-M', strtotime($context->startDate . " + $y days") ) ;
                        echo "</th>";
                    }
                ?>
            </tr>
        </thead>
        <tbody id = "roosterBody">
        <tr>
            <td class = "RoosterTijd" >00:00 </td>
            <?php
                for( $y = 0; $y < 7; $y++) {
                    $date = date('d-m-y', strtotime($context->startDate . " + $y days") );
                    echo "<td class = 'dagColum' rowspan=25>";
                    foreach ($context->lessen as $les) {
                        $dateLesson = date('d-m-y', strtotime($les->datumTijd));
                        if($date === $dateLesson){
                            $tijdHoogte = 80;
                            $hour = date('H', strtotime($les->datumTijd));
                            $hourCalc = $tijdHoogte * $hour; 
                            $minutes  = date ("i" , strtotime($les-> datumTijd));
                            $minutesCalc = ($tijdHoogte/60) * $minutes;
                            $timeCalc = $hourCalc + $minutesCalc;

                            $lesDuur =  ($tijdHoogte/60) * $les->duurMinuten;
                            echo "<div class='LesInRooster' style='top: {$timeCalc}px; height:{$lesDuur}px'>
                                    <div class ='LesDetails'>
                                    <span>{$les->vak->vakCode}</span>
                                    <span>{$les->klas->klasNaam}</span>
                                    <span>{$les->docent->docentCode}</span>
                                    <span>$hour:$minutes</span>
                                    </div>
                                </div>
                            ";
                        }
                    }
                    echo "</td>";
                }
            ?>
        </tr>
        <?php

            for ($time = 1; $time <= 24; $time++) {
                if ($time <= 23) {
                    echo "<tr>";
                    echo "<td class = RoosterTijd> $time:00</td>";
                    echo "</tr>";
                }
                elseif ($time <= 24) {
                    echo "<tr>";
                    echo "<td class = RoosterTijd> 23:59</td>";    
                    echo "</tr>";
                }
            }       
        ?> 
        </tbody>
    </table>
</div>

<script>
document.getElementById('roosterBody').scrollTop = 600;
</script>