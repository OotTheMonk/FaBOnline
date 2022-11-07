<?php

include 'CardDictionary.php';

$set = "DYN";
$count = 0;
for ($number = 0; $number < 246; ++$number) {
  if($number == 65) continue;//Tiger (ignore no attack)
  if($number == 191) continue;//Runechant
  if($number == 216) continue;//Spectral Procession (ignore no attack)
  if($number == 233) continue;
  if($number == 245) continue;
  $card = strval($number);
  if ($number < 10) $card = "0" . $card;
  if ($number < 100) $card = "0" . $card;
  $card = $set . $card;
  $type = CardType($card);
  if ($type == "") {
    echo ($card . " not found.<br>");
    ++$count;
  }
  if ($type == "AA" && $card != "EVR138" && AttackValue($card) == 0) echo ($card . " Attack action has no attack.<br>");
  if (($type != "C" && $type != "E" && $type != "W" && $type != "T") && PitchValue($card) == 0) echo ($card . " has no pitch value.<br>");
}
echo ("Total missing: " . $count);
