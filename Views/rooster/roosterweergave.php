<h1 id = "Maand"><?php echo date("F")?></h1>
<h2 id = "Week">Week <?php echo date("W")?></h2>

<?php
$lessen = [
  (object)[
    "datumTijd" => "2021-03-04 15:00",
    "docent" => (object) ["code" => "GEN"],
    "klas" => (object) ["naam" => "HVA1"],
    "vak" => (object) ["naam" => "Frans"]
  ],
  (object)[
    "datumTijd" => "2021-03-05 16:00",
    "docent" => (object) ["code" => "Ben"],
    "klas" => (object) ["naam" => "HVA1"],
    "vak" => (object) ["naam" => "Aardrijkskunde"]
  ],
];

?>

<table id =RoosterWeergave>
    <tr>
        <th></th>
        <?php
            $startDate = "2021-03-01 14:00";
            $y = 0;
            while ($y < 7) {
                echo "<th>";
                echo date('D d-M', strtotime($startDate . " + $y days") ) ;
                echo "</th>";
            $y++;
            }
        ?>
    </tr>
    <tr>
        <td class = "RoosterTijd" >00:00 </td>
        <?php
            $y = 0;
            while ($y < 7) {
                $date = date('d-m-y', strtotime($startDate . " + $y days") );
                echo "<td rowspan=25>";
                foreach ($lessen as $les) {
                    $dateLesson = date('d-m-y', strtotime($les->datumTijd));
                    if($date === $dateLesson){
                        $hour = date('h', strtotime($les->datumTijd));
                        echo "<div class='jemoeder' style='margin-top: {$hour}px'>
                                <span>{$les->vak->naam}</span>
                                <span>{$les->klas->naam}</span>
                                <span>{$les->docent->code}</span>
                            </div>
                        ";
                    }
                }
                echo "</td>";
            $y++;
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
</table>