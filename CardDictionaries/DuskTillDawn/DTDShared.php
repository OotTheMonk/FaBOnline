<?php

function DTDAbilityCost($cardID)
{
  switch($cardID) {
    case "DTD001": case "DTD002": return 2;
    case "DTD003": return 2;
    case "DTD046": return 2;
    case "DTD060": case "DTD061": case "DTD062": return 1;
    case "DTD075": case "DTD076": case "DTD077": case "DTD078": return 0;
    case "DTD105": return 2;
    case "DTD135": return 0;
    case "DTD136": return 1;
    case "DTD193": return 0;
    case "DTD199": return 1;
    case "DTD205": return 3;
    case "DTD207": return 1;
    case "DTD210": return 2;
    case "DTD405": case "DTD406": case "DTD407": case "DTD408"://Angels
    case "DTD409": case "DTD410": case "DTD411": case "DTD412": return 2;
    default: return 0;
  }
}

function DTDAbilityType($cardID, $index = -1)
{
  switch($cardID) {
    case "DTD001": case "DTD002": return "I";
    case "DTD003": return "I";
    case "DTD046": return "AA";
    case "DTD060": case "DTD061": case "DTD062": return "AR";
    case "DTD075": case "DTD076": case "DTD077": case "DTD078": return "I";
    case "DTD105": return "AA";
    case "DTD135": return "AA";
    case "DTD136": return "I";
    case "DTD193": return "AA";
    case "DTD199": return "AA";
    case "DTD205": return "AA";
    case "DTD207": return "A";
    case "DTD210": return "A";
    case "DTD405": case "DTD406": case "DTD407": case "DTD408"://Angels
    case "DTD409": case "DTD410": case "DTD411": case "DTD412": return "AA";
    default: return "";
  }
}

function DTDAbilityHasGoAgain($cardID)
{
  switch($cardID) {
    case "DTD207": return true;
    default: return false;
  }
}

function DTDEffectAttackModifier($cardID)
{
  global $mainPlayer;
  $params = explode(",", $cardID);
  $cardID = $params[0];
  if(count($params) > 1) $parameter = $params[1];
  switch($cardID) {
    case "DTD032": return 3;
    case "DTD033": return 2;
    case "DTD034": return 1;
    case "DTD035": return 4;
    case "DTD036": return 3;
    case "DTD037": return 2;
    case "DTD053": return 2;//Prayer of Bellona
    case "DTD057": case "DTD058": case "DTD059": return 1;//Beaming Bravado
    case "DTD060": return 3;
    case "DTD061": return 2;
    case "DTD062": return 1;
    case "DTD069": return 3;//Resounding Courage
    case "DTD070": return 2;
    case "DTD071": return 1;
    case "DTD072": return 3;//Charge of the Light Brigade
    case "DTD073": return 2;
    case "DTD074": return 1;
    case "DTD082": case "DTD083": case "DTD084": return 1;
    case "DTD111": return $parameter;
    case "DTD118": return 5;
    case "DTD119": return 4;
    case "DTD120": return 3;
    case "DTD127": case "DTD128": case "DTD129": return 2;
    case "DTD130": case "DTD131": case "DTD132": return 2;
    case "DTD149": return 3;
    case "DTD150": return 2;
    case "DTD151": return 1;
    case "DTD161": return 5;
    case "DTD162": return 4;
    case "DTD163": return 3;
    case "DTD196": return 1;//Anthem of Spring
    case "DTD213": return 3;
    case "DTD232": return 1;//Courage
    default:
      return 0;
  }
}

function DTDCombatEffectActive($cardID, $attackID)
{
  global $combatChainState, $CCS_IsBoosted, $mainPlayer, $combatChainState, $CCS_AttackNumCharged, $combatChain;
  global $Card_LifeBanner, $Card_ResourceBanner, $CCS_WasRuneGate;
  $params = explode(",", $cardID);
  $cardID = $params[0];
  switch($cardID) {
    case "DTD010": return true;
    case "DTD032": case "DTD033": case "DTD034": return SubtypeContains($attackID, "Angel", $mainPlayer);
    case "DTD035": case "DTD036": case "DTD037": return str_contains(NameOverride($attackID, $mainPlayer), "Herald");
    case "DTD051": return CardType($attackID) == "AA";//Beckoning Light
    case "DTD052": return CardType($attackID) == "AA";//Spirit of War
    case "DTD053": return true;//Prayer of Bellona
    case "DTD057": case "DTD058": case "DTD059": return true;//Beaming Bravado
    case "DTD060": case "DTD061": case "DTD062": return true;
    case "DTD063": case "DTD064": case "DTD065": return true;//Glaring Impact
    case "DTD066": case "DTD067": case "DTD068": return true;
    case "DTD069": case "DTD070": case "DTD071": return true;//Resounding Courage
    case "DTD072": case "DTD073": case "DTD074": return $combatChainState[$CCS_AttackNumCharged] > 0;//Charge of the Light Brigade
    case "DTD082": case "DTD083": case "DTD084": return true;
    case "DTD094": case "DTD095": case "DTD096": return true;
    case "DTD111": return ClassContains($attackID, "BRUTE", $mainPlayer) || TalentContains($attackID, "SHADOW", $mainPlayer);
    case "DTD118": case "DTD119": case "DTD120": return ClassContains($attackID, "BRUTE", $mainPlayer) || TalentContains($attackID, "SHADOW", $mainPlayer);
    case "DTD127": case "DTD128": case "DTD129": return true;
    case "DTD130": case "DTD131": case "DTD132": return true;
    case "DTD149": case "DTD150": case "DTD151": return $combatChainState[$CCS_WasRuneGate] == 1;
    case "DTD161": case "DTD162": case "DTD163": return $combatChainState[$CCS_WasRuneGate] == 1;
    case "DTD196": return CardType($attackID) == "AA";//Anthem of Spring
    case "DTD198": return true;//Call Down the Lightning
    case "DTD206": return true;
    case "DTD207": return SubtypeContains($combatChain[0], "Sword", $mainPlayer);//Ironsong Versus
    case "DTD213": return CardType($attackID) == "AA" && ClassContains($attackID, "RUNEBLADE", $mainPlayer);
    case "DTD232": return true;//Courage
    case $Card_LifeBanner: return true;
    case $Card_ResourceBanner: return true;
    case "DTD410": return true;
    default:
      return false;
  }
}

function DTDPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts)
{
  global $currentPlayer, $CS_NumCharged, $CS_DamagePrevention, $CS_NumCardsDrawn, $combatChain;
  $otherPlayer = ($currentPlayer == 1 ? 2 : 1);
  $rv = "";
  switch($cardID) {
    case "DTD001": case "DTD002":
      AddDecisionQueue("MULTIZONEINDICES", $currentPlayer, "MYPERM:subtype=Figment");
      AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Choose a figment to awaken");
      AddDecisionQueue("CHOOSEMULTIZONE", $currentPlayer, "<-", 1);
      AddDecisionQueue("AWAKEN", $currentPlayer, "-", 1);
      return "";
    case "DTD003":
      GiveAttackGoAgain();
      return "";
    case "DTD005":
      PlayAura("DYN244", $currentPlayer);
      return "";
    case "DTD007":
      PlayAura("MON104", $currentPlayer);
      return "";
    case "DTD008":
      DealArcane(1, 2, "PLAYCARD", $cardID, false, $currentPlayer);
      return "";
    case "DTD009":
      MZMoveCard($currentPlayer, "MYDISCARD:type=A;pitch=2", "MYTOPDECK");
      return;
    case "DTD010":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "DTD011":
      AddCurrentTurnEffect($cardID, $otherPlayer);
      return "";
    case "DTD012":
      PlayAura("DTD232", $currentPlayer);
      return "";
    case "DTD032": case "DTD033": case "DTD034":
      GiveAttackGoAgain();
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "DTD035": case "DTD036": case "DTD037":
      AddCurrentTurnEffect($cardID, $currentPlayer, "PLAY");
      break;
    case "DTD038": case "DTD039": case "DTD040":
      if($cardID == "DTD038") $amount = 3;
      else if($cardID == "DTD039") $amount = 2;
      else $amount = 1;
      if($target != "-") $combatChain[intval($target)+5] -= $amount;
      return "";
    case "DTD053":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      $deck = new Deck($currentPlayer);
      if($deck->Reveal() && PitchValue($deck->Top()) == 2)
      {
        $card = $deck->Top(remove:true);
        AddPlayerHand($card, $currentPlayer, "DECK");
        Charge();
      }
      return "";
    case "DTD060": case "DTD061": case "DTD062"://V for Valor
      if($from == "PLAY") AddCurrentTurnEffect($cardID, $currentPlayer, from:"PLAY");
      return "";
    case "DTD069": case "DTD070": case "DTD071"://Resounding Courage
      AddCurrentTurnEffect($cardID, $currentPlayer);
      if(GetClassState($currentPlayer, $CS_NumCharged) > 0) PlayAura("DTD232", $currentPlayer);
      return "";
    case "DTD072": case "DTD073": case "DTD074"://Charge of the Light Brigade
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "DTD075": case "DTD076": case "DTD077": case "DTD078":
      IncrementClassState($currentPlayer, $CS_DamagePrevention, 2);
      return "";
    case "DTD082": case "DTD083": case "DTD084"://Lay to Rest
      $theirChar = &GetPlayerCharacter($otherPlayer);
      if(TalentContains($theirChar[0], "SHADOW", $otherPlayer)) AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "DTD085": GainHealth(3, $currentPlayer); break;//Blessing of Salvation
    case "DTD086": GainHealth(2, $currentPlayer); break;
    case "DTD087": GainHealth(1, $currentPlayer); break;
    case "DTD088": case "DTD089": case "DTD090"://Cleansing Light
      if($cardID == "DTD088") $targetPitch = 1;
      else if($cardID == "DTD089") $targetPitch = 2;
      else if($cardID == "DTD090") $targetPitch = 3;
      WriteLog($taregtPitch);
      MZChooseAndDestroy($currentPlayer, "THEIRAURAS:pitch=" . $targetPitch . "&MYAURAS:pitch=" . $targetPitch);
      return "";
    case "DTD091": case "DTD092": case "DTD093":
      if(SearchPitchForColor($currentPlayer, 2) > 0) GiveAttackGoAgain();
      return "";
    case "DTD100": case "DTD101": case "DTD102":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "DTD105":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "DTD108":
      $numBD = SearchCount(SearchBanish($currentPlayer, "", "", -1, -1, "", "", true));
      $damage = 13 - $numBD;
      DamageTrigger($currentPlayer, $damage, "PLAYCARD", $cardID);
      return "";
    case "DTD111":
      $cards = explode(",", $additionalCosts);
      $num6Pow = 0;
      for($i=0; $i<count($cards); ++$i)
      {
        if(HasBloodDebt($cards[$i])) Draw($currentPlayer);
        if(AttackValue($cards[$i]) >= 6) ++$num6Pow;
      }
      if($num6Pow > 0) AddCurrentTurnEffect("DTD111," . $num6Pow, $currentPlayer);
      return "";
    case "DTD112": case "DTD113": case "DTD114":
      if(AttackValue($additionalCosts) >= 6) GiveAttackGoAgain();
      return "";
    case "DTD118": case "DTD119": case "DTD120":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "DTD127": case "DTD128": case "DTD129":
      if(AttackValue($additionalCosts) >= 6) {
        AddCurrentTurnEffect($cardID, $currentPlayer);
      }
      return "";
    case "DTD130": case "DTD131": case "DTD132":
      if(AttackValue($additionalCosts) >= 6) {
        AddCurrentTurnEffect($cardID, $currentPlayer);
      }
      return "";
    case "DTD136":
      PlayAura("DTD233", $currentPlayer);
      return "";
    case "DTD140":
      PlayAura("ARC112", $currentPlayer);
      return "";
    case "DTD141":
      PlayAura("DTD233", $currentPlayer);
      return "";
    case "DTD142":
      PlayAlly("DTD193", $currentPlayer);
      return "";
    case "DTD149": case "DTD150": case "DTD151":
      PlayAura("ARC112", $currentPlayer);
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "DTD161": case "DTD162": case "DTD163":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "DTD169":
      $deck = new Deck($currentPlayer);
      if($deck->Empty()) return "Ravenous Dabble does not get negative attack because your deck is empty";
      $top = $deck->BanishTop();
      $pitch = PitchValue($top);
      SetCCAttackModifier(0, -$pitch);
      return "";
    case "DTD170":
      if($from == "BANISH")
      {
        $auras = &GetAuras($currentPlayer);
        $index = count($auras) - AuraPieces();
        $auras[$index+2] = 1;
      }
      return "";
    case "DTD175": GainHealth(3, $currentPlayer); return "";
    case "DTD176": GainHealth(2, $currentPlayer); return "";
    case "DTD177": GainHealth(1, $currentPlayer); return "";
    case "DTD184": case "DTD185": case "DTD186":
      $theirSoul = &GetSoul($otherPlayer);
      if(count($theirSoul) > 0) GiveAttackGoAgain();
      return "";
    case "DTD196"://Anthem of Spring
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "DTD198"://Call Down the Lightning
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "DTD207"://Ironsong Versus
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "DTD210":
      DealArcane(1, 3, "ABILITY", $cardID);
      AddDecisionQueue("SPECIFICCARD", $currentPlayer, "SCEPTEROFPAIN");
      return "";
    case "DTD212":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "DTD213":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "DTD219"://Lost in Thought
      AddDecisionQueue("MULTIZONEINDICES", $currentPlayer, "THEIRHAND:type=A&THEIRHAND:type=AA");
      AddDecisionQueue("CHOOSEMULTIZONE", $currentPlayer, "<-", 1);
      AddDecisionQueue("MZREMOVE", $currentPlayer, "-", 1);
      AddDecisionQueue("ADDBOTDECK", $otherPlayer, "-", 1);
      return "";
    case "DTD228":
      if(GetClassState($otherPlayer, $CS_NumCardsDrawn) >= 2)
      {
        IncrementClassState($currentPlayer, $CS_DamagePrevention, 3);
        WriteLog("Prevents the next 3 damage");
      }
      return "";
    default:
      return "";
  }
}

function DTDHitEffect($cardID)
{
  global $mainPlayer;
  switch($cardID) {
    case "DTD082": case "DTD083": case "DTD084":
      if(IsHeroAttackTarget())
      {
        AddDecisionQueue("MULTIZONEINDICES", $mainPlayer, "THEIRBANISH");
        AddDecisionQueue("MAYCHOOSEMULTIZONE", $mainPlayer, "<-", 1);
        AddDecisionQueue("MZOP", $mainPlayer, "TURNBANISHFACEDOWN", 1);
      }
      break;
    case "DTD135":
      PlayAura("ARC112", $mainPlayer);
      break;
    case "DTD172": case "DTD173": case "DTD174":
      if(IsHeroAttackTarget()) MZMoveCard($mainPlayer, "THEIRSOUL", "THEIRBANISH,SOUL,-");
      break;
    case "DTD193":
      if(IsHeroAttackTarget()) MZMoveCard($mainPlayer, "THEIRSOUL", "THEIRBANISH,SOUL,-");
      break;
    case "DTD226":
      WriteLog("This is a partially manual card. Name the card in chat and enforce the restriction manually.");
      break;
    default: break;
  }
}

function DoesAttackTriggerMirage()
{
  global $combatChain, $mainPlayer;
  if(ClassContains($combatChain[0], "ILLUSIONIST", $mainPlayer)) return false;
  return CachedTotalAttack() >= 6;
}

function ProcessMirageOnBlock($index)
{
  global $mainPlayer;
  if(IsMirageActive($index) && DoesAttackTriggerMirage())
  {
    AddLayer("LAYER", $mainPlayer, "MIRAGE");
  }
}

function IsMirageActive($index)
{
  global $combatChain;
  if(count($combatChain) == 0) return false;
  return HasMirage($combatChain[$index]);
}

function HasMirage($cardID)
{
  switch($cardID)
  {
    case "DTD218": return true;
    default: return false;
  }
}

function MirageLayer()
{
  global $combatChain, $mainPlayer, $combatChainState, $defPlayer, $turn, $layers;
  if(DoesAttackTriggerMirage())
  {
    for($i=count($combatChain)-CombatChainPieces(); $i>=CombatChainPieces(); $i-=CombatChainPieces())
    {
      if(IsMirageActive($i))
      {
        WriteLog(CardLink($combatChain[$i], $combatChain[$i]) . " is destroyed by Mirage.");
        AddGraveyard($combatChain[$i], $defPlayer, "CC");
        RemoveCombatChain($i);
      }
    }
  }
  else {
    $turn[0] = "D";
    $currentPlayer = $mainPlayer;
    for($i=count($layers)-LayerPieces(); $i >= 0; $i-=LayerPieces())
    {
      if($layers[$i] == "DEFENDSTEP" || ($layers[$i] == "LAYER" && $layers[$i+2] == "MIRAGE"))
      {
        for($j=$i; $j<($i+LayerPieces()); ++$j) unset($layers[$j]);
      }
    }
    $layers = array_values($layers);
  }
}
