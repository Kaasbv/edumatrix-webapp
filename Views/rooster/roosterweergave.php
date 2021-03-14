<h1 id = "Maand"><?php echo date("F")?></h1>
<h2 id = "Week">Week <?php echo date("W")?></h2>

<?php
$lessen = [
  (object)[
    "datumTijd" => "2021-03-04 12:00",
    "duur" => 60,
    "docent" => (object) ["code" => "GEN"],
    "klas" => (object) ["naam" => "HVA1"],
    "vak" => (object) ["naam" => "Frans"]
  ],
  (object)[
    "datumTijd" => "2021-03-05 18:00",
    "duur" => 120,
    "docent" => (object) ["code" => "Ben"],
    "klas" => (object) ["naam" => "HVA1"],
    "vak" => (object) ["naam" => "Aardrijkskunde"]
  ],
];

?>

<table id =RoosterWeergave>
    <thead>
        <tr>
            <th></th>
            <?php
                $startDate = "2021-03-01 14:00";
                for ($y = 0; $y <7; $y++ ) {
                    echo "<th class = 'dagWeergave'>";
                    echo "<div class = 'dag'></div>";
                    echo date('D d-M', strtotime($startDate . " + $y days") ) ;
                    echo "</th>";
                }
            ?>
        </tr>
    </thead>
    <tbody class = "roosterbody">
    <tr>
        <td class = "RoosterTijd" >00:00 </td>
        <?php
            for( $y = 0; $y < 7; $y++) {
                $date = date('d-m-y', strtotime($startDate . " + $y days") );
                echo "<td class = 'dagColum' rowspan=25>";
                foreach ($lessen as $les) {
                    $dateLesson = date('d-m-y', strtotime($les->datumTijd));
                    if($date === $dateLesson){
                        $hour = date('H', strtotime($les->datumTijd));
                        $hourCalc = 80 * $hour; 
                        $minutes  = date ("i" , strtotime($les-> datumTijd));
                        $minutesCalc = (80/60) * $minutes;
                        $timeCalc = $hourCalc + $minutesCalc;

                        $lesDuur =  (80/60) * $les ->duur;
                        echo "<div class='LesInRooster' style='margin-top: {$timeCalc}px; height:{$lesDuur}px'>
                                <span>{$les->vak->naam}</span>
                                <span>{$les->klas->naam}</span>
                                <span>{$les->docent->code}</span>
                                <span>$hour:$minutes</span>
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
                echo 
                    "<tr>
                    <td class = RoosterTijd> $time:00</td>       
                    </tr>";
            }
            elseif ($time <= 24) {
                echo 
                    "<tr>
                    <td class = RoosterTijd> 23:59</td>       
                    </tr>";
            }
        }       
    ?> 
    </tbody>
</table>