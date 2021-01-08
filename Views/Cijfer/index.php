<?php
$leerlingen = [
  (object)[
    "id" => 1,
    "voornaam" => "gert",
    "tussenvoegsel" => "van de",
    "achternaam" => "henk"
  ],
  (object)[
    "id" => "2",
    "voornaam" => "johan",
    "tussenvoegsel" => "van de",
    "achternaam" => "gertjes"
  ]
];

$beoordelingen = [
  (object)[
    "id" => 1,
    "naam" => "SO AAAAA",
  ],
  (object)[
    "id" => 2,
    "naam" => "SET 1"
  ]
];

$cijfers = [
  (object)[
    "beoordeling_id" => 1,
    "leerling_id" => 1,
    "cijfer" => 8.1
  ],
  (object)[
    "beoordeling_id" => 1,
    "leerling_id" => 2,
    "cijfer" => 1.5
  ],
  (object)[
    "beoordeling_id" => 2,
    "leerling_id" => 1,
    "cijfer" => 6.1
  ],
  (object)[
    "beoordeling_id" => 2,
    "leerling_id" => 2,
    "cijfer" => 8
  ],
]
?>

<table>
  <thead>
    <tr>
      <td>Leerlingnaam</td>
      <?php foreach ($context->beoordelingen as $beoordeling): ?>
        <td><?= $beoordeling->naam ?></td>
      <?php endforeach ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($leerlingen as $leerling): ?>
        <tr>
          <td><?= $leerling->voornaam ?></td>
          <?php foreach ($context->beoordelingen as $beoordeling): ?>
            <td></td>
          <?php endforeach ?>
        </tr>
    <?php endforeach ?>
  </tbody>
</table>
