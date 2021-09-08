<?php

  function ELEAbilityCost($cardID)
  {
    switch($cardID)
    {
      case "ELE001": case "ELE002": return 3;
      case "ELE003": return 3;
      case "ELE031": case "ELE032": return 0;
      case "ELE033": case "ELE034": return 1;
      case "ELE173": return 2;
      case "ELE195": case "ELE196": case "ELE197": return 2;
      default: return 0;
    }
  }

  function ELEAbilityType($cardID, $index=-1)
  {
    switch($cardID)
    {
      case "ELE001": case "ELE002": return "DR";
      case "ELE003": return "AA";
      case "ELE031": case "ELE032": return "A";
      case "ELE033": case "ELE034": return "I";
      case "ELE143": return "I";
      case "ELE172": return "I";
      case "ELE173": return "I";
      case "ELE195": case "ELE196": case "ELE197": return "I";
      default: return "";
    }
  }

  function ELEHasGoAgain($cardID)
  {
    switch($cardID)
    {
      case "ELE037": return true;
      case "ELE103": case "ELE104": case "ELE105": return true;
      case "ELE143": return true;
      case "ELE146": return true;
      case "ELE154": case "ELE155": case "ELE156": return true;
      case "ELE163": case "ELE164": case "ELE165": return true;
      case "ELE172": return true;
      case "ELE175": return true;
      case "ELE169": case "ELE170": case "ELE171": return true;
      case "ELE180": case "ELE181": case "ELE182": return true;
      case "ELE198": case "ELE199": case "ELE200": return true;
      default: return false;
    }
  }

  function ELEAbilityHasGoAgain($cardID)
  {
    switch($cardID)
    {
      case "ELE031": case "ELE032": return true;
      default: return false;
    }
  }

  function ELEEffectAttackModifier($cardID)
  {
    switch($cardID)
    {
      case "ELE033-1": return 1;
      case "ELE034-1": return 1;
      case "ELE035-2": return 1;
      case "ELE037-1": return 3;
      case "ELE103": return 4;
      case "ELE104": return 3;
      case "ELE105": return 2;
      case "ELE112": return 4;
      case "ELE143": return 1;
      case "ELE154": return 3;
      case "ELE155": return 2;
      case "ELE156": return 1;
      case "ELE180": return 3;
      case "ELE181": return 2;
      case "ELE182": return 1;
      default: return 0;
    }
  }

  function ELECombatEffectActive($cardID, $attackID)
  {
    global $combatChainState, $CCS_AttackFused;
    switch($cardID)
    {
      case "ELE031-1": return true;
      case "ELE033-1": case "ELE033-2": return CardSubtype($attackID) == "Arrow";//TODO+1 not strictly accurate because of multiple arsenal slots
      case "ELE034-1": case "ELE034-2": return CardSubtype($attackID) == "Arrow";//TODO+1 not strictly accurate because of multiple arsenal slots
      case "ELE035-2": return true;
      case "ELE037-1": case "ELE037-2": return CardSubtype($attackID) == "Arrow";
      case "ELE047": case "ELE048": case "ELE049": return true;
      case "ELE050": case "ELE051": case "ELE052": return true;
      case "ELE059": case "ELE060": case "ELE061": return true;
      case "ELE097": case "ELE098": case "ELE099": return true;
      case "ELE103": case "ELE104": case "ELE105": return $combatChainState[$CCS_AttackFused] == 1;
      case "ELE112": $talent = CardTalent($attackID); return $talent == "ICE" || $talent == "LIGHTNING" || $talent == "ELEMENTAL";
      case "ELE143": return CardType($attackID) == "AA";
      case "ELE154": case "ELE155": case "ELE156":
        $talent = CardTalent($attackID);
        return CardType($attackID) == "AA" && ($talent == "ICE" || $talent == "ELEMENTAL");
      case "ELE163": case "ELE164": case "ELE165": $talent = CardTalent($attackID); return $talent == "ICE" || $talent == "ELEMENTAL";
      case "ELE173": return CardType($attackID) == "AA";
      case "ELE180": case "ELE181": case "ELE182": $talent = CardTalent($attackID); return $talent == "LIGHTNING" || $talent == "ELEMENTAL";
      case "ELE195": case "ELE196": case "ELE197": return true;
      case "ELE198": case "ELE199": case "ELE200": return CardType($attackID) == "AA";
      default: return false;
    }
  }

  function ELECardTalent($cardID)
  {
    $number = intval(substr($cardID, 3));
    if($number <= 30) return "??";
    else if($number >= 31 && $number <= 111) return "ELEMENTAL";//Is this right?
    else if($number == 112) return "LIGHTNING,ICE";
    else if($number >= 128 && $number <= 143) return "EARTH";
    else if($number >= 146 && $number <= 172) return "ICE";
    else if($number >= 173 && $number <= 201) return "LIGHTNING";
    else return "NONE";
  }

?>

