<h1 id = "Maand"><?php echo date("F")?></h1>
<h2 id = "Week">Week <?php echo date("W")?></h2>

<?php
$lessen = [
  (object)[
    "datumTijd" => "2020-12-11 15:00",
    "docent" => (object) ["code" => "GEN"],
    "klas" => (object) ["naam" => "HVA1"],
    "vak" => (object) ["naam" => "Frans"]
  ],
  (object)[
    "datumTijd" => "2020-12-11 16:00",
    "docent" => (object) ["code" => "Ben"],
    "klas" => (object) ["naam" => "HVA1"],
    "vak" => (object) ["naam" => "Aarderijksunde"]
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
        <td rowspan= "25"></td>
        <td rowspan= "25"> </td>
        <td rowspan= "25"> </td>
        <td rowspan= "25"> </td>
        <td rowspan= "25"> </td>
        <td rowspan= "25"> </td>
        <td rowspan= "25"> </td>
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