

<h1>Klassenlijst</h1>

<div>
  <?php

$klas=array("Klas H1a", "Klas H1c", "Klas H3c", "Klas V4", "Klas V6");
$arrlength=count($klas);

for($x=0;$x<$arrlength;$x++)
  {
  echo "<h5 class='ul'>" . $klas[$x] ;
  echo "<br>";
  }
?>
</div>
<ul><h5>
  <li>Klas H1a</li>
  <li>Klas H1c</li>
  <li>Klas H3c</li>
  <li>Klas V4</li>
  <li>Klas V6</li>
</h5></ul>