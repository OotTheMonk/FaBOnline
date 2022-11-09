<?php

include "Search.php";
include "CardLogic.php";
include "AuraAbilities.php";
include "ItemAbilities.php";
include "AllyAbilities.php";
include "PermanentAbilities.php";
include "LandmarkAbilities.php";
include "CharacterAbilities.php";
include "WeaponLogic.php";
include "MZLogic.php";

function PlayAbility($cardID, $from, $resourcesPaid, $target = "-", $additionalCosts = "-")
{
  global $currentPlayer, $layers;
  $set = CardSet($cardID);
  $class = CardClass($cardID);
  if($target != "-")
  {
    $targetArr = explode("-", $target);
    //TODO: This -6 is not right
    if($targetArr[0] == "LAYER" && $targetArr[1] >= 0) $targetArr[1] -= 6;
    $target = $targetArr[0] . "-" . $targetArr[1];
  }
  if (($set == "ELE" || $set == "UPR") && $additionalCosts != "-" && HasFusion($cardID)) {
    FuseAbility($cardID, $currentPlayer, $additionalCosts);
  }
  if($cardID == "CRU097") {
    $otherPlayer = ($currentPlayer == 1 ? 2 : 1);
    $otherCharacter = &GetPlayerCharacter($otherPlayer);
    if(SearchCurrentTurnEffects($otherCharacter[0] . "-SHIYANA", $currentPlayer)) {
      return PlayAbility($otherCharacter[0], $from, $resourcesPaid, $target, $additionalCosts);
    }
  }
  if ($set == "WTR") {
    return WTRPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
  } else if ($set == "ARC") {
    switch ($class) {
      case "MECHANOLOGIST":
        return ARCMechanologistPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
      case "RANGER":
        return ARCRangerPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
      case "RUNEBLADE":
        return ARCRunebladePlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
      case "WIZARD":
        return ARCWizardPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
      case "GENERIC":
        return ARCGenericPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
      default:
        return "";
    }
  } else if ($set == "CRU") {
    return CRUPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
  } else if ($set == "MON") {
    switch ($class) {
      case "BRUTE":
        return MONBrutePlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
      case "ILLUSIONIST":
        return MONIllusionistPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
      case "RUNEBLADE":
        return MONRunebladePlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
      case "WARRIOR":
        return MONWarriorPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
      case "GENERIC":
        return MONGenericPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
      case "NONE":
        return MONTalentPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
      default:
        return "";
    }
  } else if ($set == "ELE") {
    switch ($class) {
      case "GUARDIAN":
        return ELEGuardianPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
      case "RANGER":
        return ELERangerPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
      case "RUNEBLADE":
        return ELERunebladePlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
      default:
        return ELETalentPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
    }
  } else if ($set == "EVR") {
    return EVRPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
  } else if ($set == "UPR") {
    return UPRPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
  } else if ($set == "DVR") {
    return DVRPlayAbility($cardID, $from, $resourcesPaid);
  } else if ($set == "RVD") {
    return RVDPlayAbility($cardID, $from, $resourcesPaid);
  } else if ($set == "DYN") {
    return DYNPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
  } else {
    return ROGUEPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts);
  }
  $rv = "";
  switch ($cardID) {
    default:
      break;
  }
}

function ProcessHitEffect($cardID)
{
  WriteLog("Processing hit effect for " . CardLink($cardID, $cardID) . ".");
  global $combatChainState, $CCS_ChainLinkHitEffectsPrevented, $currentPlayer, $combatChain;

  if (CardType($combatChain[0]) && (SearchAuras("CRU028", 1) || SearchAuras("CRU028", 2))) return;
  if ($combatChainState[$CCS_ChainLinkHitEffectsPrevented]) return;
  $set = CardSet($cardID);
  $class = CardClass($cardID);

  if ($cardID == "CRU097") {
    $otherPlayer = ($currentPlayer == 1 ? 2 : 1);
    $otherCharacter = &GetPlayerCharacter($otherPlayer);
    if (SearchCurrentTurnEffects($otherCharacter[0] . "-SHIYANA", $currentPlayer)) {
      return ProcessHitEffect($otherCharacter[0]);
    }
  }
  if ($set == "WTR") {
    return WTRHitEffect($cardID);
  }
  if ($set == "ARC") {
    switch ($class) {
      case "MECHANOLOGIST":
        ARCMechanologistHitEffect($cardID);
        return;
      case "RANGER":
        ARCRangerHitEffect($cardID);
        return;
      case "RUNEBLADE":
        ARCRunebladeHitEffect($cardID);
        return;
      case "WIZARD":
        ARCWizardHitEffect($cardID);
        return;
      case "GENERIC":
        ARCGenericHitEffect($cardID);
        return;
    }
  } else if ($set == "CRU") {
    return CRUHitEffect($cardID);
  } else if ($set == "MON") {
    switch ($class) {
      case "BRUTE":
        return MONBruteHitEffect($cardID);
      case "ILLUSIONIST":
        return MONIllusionistHitEffect($cardID);
      case "RUNEBLADE":
        return MONRunebladeHitEffect($cardID);
      case "WARRIOR":
        return MONWarriorHitEffect($cardID);
      case "GENERIC":
        return MONGenericHitEffect($cardID);
      case "NONE":
        return MONTalentHitEffect($cardID);
      default:
        return "";
    }
  } else if ($set == "ELE") {
    switch ($class) {
      case "GUARDIAN":
        return ELEGuardianHitEffect($cardID);
      case "RANGER":
        return ELERangerHitEffect($cardID);
      case "RUNEBLADE":
        return ELERunebladeHitEffect($cardID);
      default:
        return ELETalentHitEffect($cardID);
    }
  } else if ($set == "EVR") {
    return EVRHitEffect($cardID);
  } else if ($set == "UPR") {
    return UPRHitEffect($cardID);
  } else if ($set == "DYN") {
    return DYNHitEffect($cardID);
  }
  switch ($cardID) {
    default:
      break;
  }
}

function ProcessDealDamageEffect($cardID)
{
  $set = CardSet($cardID);
  if ($set == "UPR") {
    return UPRDealDamageEffect($cardID);
  }
  switch ($cardID) {
    default:
      break;
  }
}

function ArcaneHitEffect($player, $source, $target, $damage)
{
  switch ($source) {
    case "UPR104":
      if (MZIsPlayer($target) && $damage > 0) {
        AddDecisionQueue("ENCASEDAMAGE", MZPlayerID($player, $target), "-", 1);
      }
      break;
    case "UPR113": case "UPR114": case "UPR115":
      if (MZIsPlayer($target)) PayOrDiscard(MZPlayerID($player, $target), 2, true);
      break;
    case "UPR119": case "UPR120": case "UPR121":
      if (MZIsPlayer($target) && $damage > 0) {
        AddDecisionQueue("FINDINDICES", $player, "SEARCHMZ,THEIRARS", 1);
        AddDecisionQueue("SETDQCONTEXT", $player, "Choose which card you want to freeze", 1);
        AddDecisionQueue("CHOOSEMULTIZONE", $player, "<-", 1);
        AddDecisionQueue("MZOP", $player, "FREEZE", 1);
      }
      break;
    case "UPR122": case "UPR123": case "UPR124":
      if (MZIsPlayer($target) && $damage > 0) {
        AddDecisionQueue("PLAYAURA", MZPlayerID($player, $target), "ELE111", 1);
      }
      break;
    default:
      break;
  }

  if ($damage > 0 && SearchCurrentTurnEffects("UPR125", $player) && CardType($source) != "W") {
    AddDecisionQueue("DESTROYFROZENARSENAL", MZPlayerID($player, $target), "-");
    SearchCurrentTurnEffects("UPR125", $player, true); // Remove the effect
  }

  if (HasSurge($source) && $damage > ArcaneDamage($source)) {
    DoSurgeEffect($source, $player, $target);
  }
}

function DoSurgeEffect($cardID, $player, $target)
{
  global $mainPlayer;
  switch ($cardID) {
    case "DYN194":
      $targetPlayer = MZPlayerID($player, $target);
      $hand = &GetHand($targetPlayer);
      $numToDraw = count($hand) - 1;
      if($numToDraw < 0) $numToDraw = 0;
      $deck = &GetDeck($targetPlayer);
      while(count($hand) > 0) array_push($deck, array_shift($hand));
      for($i=0; $i<$numToDraw; ++$i) array_push($hand, array_shift($deck));
      WriteLog("Mind Warp warps the target's mind.");
      AddDecisionQueue("SHUFFLEDECK", $targetPlayer, "-");
      break;
    case "DYN195":
      PlayAura("DYN244", $player);
      WriteLog(CardLink($cardID, $cardID) . " surge's ability create a " . CardLink("DYN244", "DYN244") . " token.");
      break;
    case "DYN197": case "DYN198": case "DYN199":
      if (CurrentEffectPreventsGoAgain() || $player != $mainPlayer) break;
      WriteLog(CardLink($cardID, $cardID) . " gained go again due to its surge's ability");
      GainActionPoints();
      break;
    case "DYN203": case "DYN204": case "DYN205":
      PlayerOpt($player, 1);
      break;
    case "DYN206": case "DYN207": case "DYN208":
      AddDecisionQueue("MULTIZONEINDICES", $player, "THEIRCHAR:type=E;hasEnergyCounters=true");
      AddDecisionQueue("SETDQCONTEXT", $player, "Choose which permanent remove an energy counter");
      AddDecisionQueue("CHOOSEMULTIZONE", $player, "<-", 1);
      AddDecisionQueue("MZGETCARDINDEX", $player, "-", 1);
      AddDecisionQueue("REMOVEENERGYCOUNTER", $target, "-", 1);
      AddDecisionQueue("SURGEENERGYLOSSLOG", $target, $cardID, 1);
      break;
    default: break;
  }
}

function ProcessMissEffect($cardID)
{
  global $defPlayer;
  switch ($cardID) {
    case "EVR002":
      if(!IsAllyAttackTarget()) {
        PlayAura("WTR225", $defPlayer);
      }
    default:
      break;
  }
}

function ChainLinkBeginResolutionEffects()
{
  global $combatChain, $mainPlayer, $defPlayer, $CCS_CombatDamageReplaced, $combatChainState, $CCS_WeaponIndex;
  if (CardType($combatChain[0]) == "W") {
    $mainCharacterEffects = &GetMainCharacterEffects($mainPlayer);
    $index = $combatChainState[$CCS_WeaponIndex];
    for ($i = 0; $i < count($mainCharacterEffects); $i += CharacterEffectPieces()) {
      if ($mainCharacterEffects[$i] == $index) {
        switch ($mainCharacterEffects[$i + 1]) {
            //CR 2.1 - 6.5.4. Standard-replacement: Third, each player applies any active standard-replacement effects they control.
            //CR 2.1 - 6.5.5. Prevention: Fourth, each player applies any active prevention effects they control.
          case "EVR054":
            $pendingDamage = CachedTotalAttack() - CachedTotalBlock();
            AddDecisionQueue("SETDQCONTEXT", $mainPlayer, "Currently $pendingDamage damage would be dealt. Do you want to destroy a defending equipment instead?");
            AddDecisionQueue("YESNO", $mainPlayer, "if_you_want_to_destroy_a_blocking_equipment_instead_of_dealing_damage");
            AddDecisionQueue("NOPASS", $mainPlayer, "-");
            AddDecisionQueue("PASSPARAMETER", $mainPlayer, "1", 1);
            AddDecisionQueue("SETCOMBATCHAINSTATE", $mainPlayer, $CCS_CombatDamageReplaced, 1);
            AddDecisionQueue("FINDINDICES", $defPlayer, "SHATTER,$pendingDamage", 1);
            AddDecisionQueue("CHOOSETHEIRCHARACTER", $mainPlayer, "<-", 1);
            AddDecisionQueue("DESTROYCHARACTER", $defPlayer, "-", 1);
            break;
          default:
            break;
        }
      }
    }
  }
}

function CombatChainResolutionEffects()
{
  global $combatChain;
  for($i=CombatChainPieces(); $i<count($combatChain); $i+=CombatChainPieces())
  {
    switch($combatChain[0])
    {
      case "CRU051": case "CRU052":
        EvaluateCombatChain($totalAttack, $totalBlock);
        if ($totalBlock > 0 && BlockValue($combatChain[$i]) > $totalAttack) {
          DestroyCurrentWeapon();
        }
        break;
        default: break;
    }
  }
}

function HasCrush($cardID)
{
  switch ($cardID) {
    case "WTR043":
    case "WTR044":
    case "WTR045":
    case "WTR057":
    case "WTR058":
    case "WTR059":
    case "WTR060":
    case "WTR061":
    case "WTR062":
    case "WTR063":
    case "WTR064":
    case "WTR065":
    case "WTR066":
    case "WTR067":
    case "WTR068":
    case "WTR050":
    case "WTR049":
    case "WTR048":
    case "CRU026":
    case "CRU027":
    case "CRU032":
    case "CRU033":
    case "CRU034":
    case "CRU035":
    case "CRU036":
    case "CRU037":
      return true;
    default:
      return false;
  }
}

function ProcessCrushEffect($cardID)
{
  global $mainPlayer, $defPlayer, $defCharacter, $combatChain;
  if (CardType($combatChain[0]) && (SearchAuras("CRU028", 1) || SearchAuras("CRU028", 2))) return;
  if (IsHeroAttackTarget()) {
    switch ($cardID) {
      case "WTR043":
        DiscardRandom($defPlayer);
        DiscardRandom($defPlayer);
        break;
      case "WTR044":
        AddNextTurnEffect($cardID, $defPlayer);
        break;
      case "WTR045":
        AddNextTurnEffect($cardID, $defPlayer);
        break;
      case "WTR057":
      case "WTR058":
      case "WTR059":
        AddDecisionQueue("FINDINDICES", $defPlayer, "EQUIP");
        AddDecisionQueue("CHOOSETHEIRCHARACTER", $mainPlayer, "<-", 1);
        AddDecisionQueue("ADDNEGDEFCOUNTER", $defPlayer, "-", 1);
        break;
      case "WTR060":
      case "WTR061":
      case "WTR062":
        AddNextTurnEffect($cardID, $defPlayer);
        break;
      case "WTR063":
      case "WTR064":
      case "WTR065":
        $defCharacter[1] = 3;
        break;
      case "WTR066":
      case "WTR067":
      case "WTR068":
        AddNextTurnEffect($cardID, $defPlayer);
        break;
      case "WTR050":
      case "WTR049":
      case "WTR048":
        AddDecisionQueue("FINDINDICES", $mainPlayer, "SEARCHMZ,THEIRARS", 1);
        AddDecisionQueue("SETDQCONTEXT", $mainPlayer, "Choose which card you want to put at the bottom of the deck", 1);
        AddDecisionQueue("CHOOSEMULTIZONE", $mainPlayer, "<-", 1);
        AddDecisionQueue("MZADDBOTDECK", $mainPlayer, "-", 1);
        AddDecisionQueue("MZREMOVE", $mainPlayer, "-", 1);
        break;
      case "CRU026":
        AddDecisionQueue("FINDINDICES", $mainPlayer, "CRU026");
        AddDecisionQueue("CHOOSETHEIRCHARACTER", $mainPlayer, "<-", 1);
        AddDecisionQueue("DESTROYTHEIRCHARACTER", $mainPlayer, "-", 1);
        break;
      case "CRU027":
        AddDecisionQueue("FINDINDICES", $defPlayer, "DECKTOPX,5");
        AddDecisionQueue("SETDQVAR", $mainPlayer, "0");
        AddDecisionQueue("COUNTPARAM", $defPlayer, "<-", 1);
        AddDecisionQueue("SETDQCONTEXT", $mainPlayer, "Choose which card(s) to banish", 1);
        AddDecisionQueue("MULTICHOOSETHEIRDECK", $mainPlayer, "<-", 1, 1);
        AddDecisionQueue("VALIDATEALLSAMENAME", $defPlayer, "DECK", 1);
        AddDecisionQueue("MULTIREMOVEDECK", $defPlayer, "-", 1);
        AddDecisionQueue("MULTIBANISH", $defPlayer, "DECK,-", 1);
        AddDecisionQueue("SHOWBANISHEDCARD", $defPlayer, "-", 1);
        AddDecisionQueue("RIGHTEOUSCLEANSING", $mainPlayer, "<-", 1);
        break;
      case "CRU032":
      case "CRU033":
      case "CRU034":
        AddNextTurnEffect("CRU032", $defPlayer);
        break;
      case "CRU035":
      case "CRU036":
      case "CRU037":
        AddNextTurnEffect("CRU035", $defPlayer);
        break;
      default:
        return;
    }
  }
}

//NOTE: This happens at combat resolution, so can't use the my/their directly
function AttackModifier($cardID, $from = "", $resourcesPaid = 0, $repriseActive = -1)
{
  global $mainPlayer, $mainPitch, $CS_Num6PowDisc, $combatChain, $combatChainState, $mainAuras, $CCS_NumHits, $CS_CardsBanished, $CCS_HitsInRow;
  global $CS_NumCharged, $CCS_NumBoosted, $defPlayer, $CS_ArcaneDamageTaken;
  global $CS_NumNonAttackCards, $CS_NumPlayedFromBanish, $CCS_NumChainLinks, $CS_NumAuras, $CS_AtksWWeapon;
  if ($repriseActive == -1) $repriseActive = RepriseActive();
  switch ($cardID) {
    case "WTR003":
      return (GetClassState($mainPlayer, $CS_Num6PowDisc) > 0 ? 1 : 0);
    case "WTR040":
      $pitch = &GetPitch($mainPlayer);
      return CountPitch($pitch, 3) >= 2 ? 2 : 0;
    case "WTR080":
      return 1;
    case "WTR081":
      return (ComboActive() ? $resourcesPaid : 0);
    case "WTR082":
      return 1;
    case "WTR083":
      return (ComboActive() ? 1 : 0);
    case "WTR084":
      return (ComboActive() ? 1 : 0);
    case "WTR086":
    case "WTR087":
    case "WTR088":
      return (ComboActive() ? $combatChainState[$CCS_NumHits] : 0);
    case "WTR089":
    case "WTR090":
    case "WTR091":
      return (ComboActive() ? 3 : 0);
    case "WTR095":
    case "WTR096":
    case "WTR097":
      return (ComboActive() ? 1 : 0);
    case "WTR104":
    case "WTR105":
    case "WTR106":
      return (ComboActive() ? 2 : 0);
    case "WTR110":
    case "WTR111":
    case "WTR112":
      return (ComboActive() ? 1 : 0);
    case "WTR120":
      return 3;
    case "WTR121":
      return 1;
    case "WTR123":
      return $repriseActive ? 6 : 4;
    case "WTR124":
      return $repriseActive ? 5 : 3;
    case "WTR125":
      return $repriseActive ? 4 : 2;
    case "WTR132":
      return CardType($combatChain[0]) == "W" && $repriseActive ? 3 : 0;
    case "WTR133":
      return CardType($combatChain[0]) == "W" && $repriseActive ? 2 : 0;
    case "WTR134":
      return CardType($combatChain[0]) == "W" && $repriseActive ? 1 : 0;
    case "WTR135":
      return 3;
    case "WTR136":
      return 2;
    case "WTR137":
      return 1;
    case "WTR138":
      return 3;
    case "WTR139":
      return 2;
    case "WTR140":
      return 1;
    case "WTR176":
    case "WTR177":
    case "WTR178":
      return NumCardsNonEquipBlocking() < 2 ? 1 : 0;
    case "WTR206":
      return 4;
    case "WTR207":
      return 3;
    case "WTR208":
      return 2;
    case "WTR209":
      return 3;
    case "WTR210":
      return 2;
    case "WTR211":
      return 1;
    case "ARC077":
      return GetClassState($mainPlayer, $CS_NumNonAttackCards) > 0 ? 3 : 0;
    case "ARC188":
    case "ARC189":
    case "ARC190":
      return $combatChainState[$CCS_HitsInRow] > 0 ? 2 : 0;
    case "CRU016":
    case "CRU017":
    case "CRU018":
      return GetClassState($mainPlayer, $CS_Num6PowDisc) > 0 ? 1 : 0;
    case "CRU056":
      return ComboActive() ? 2 : 0;
    case "CRU057":
    case "CRU058":
    case "CRU059":
      return ComboActive() ? 1 : 0;
    case "CRU060":
    case "CRU061":
    case "CRU062":
      return ComboActive() ? 1 : 0;
    case "CRU063":
    case "CRU064":
    case "CRU065":
      return $combatChainState[$CCS_NumChainLinks] >= 3 ? 2 : 0;
    case "CRU073":
      return $combatChainState[$CCS_NumHits];
    case "CRU083":
      return 3;
    case "CRU112":
    case "CRU113":
    case "CRU114":
      return $combatChainState[$CCS_NumBoosted];
    case "CRU186":
      return 1;
    case "MON031":
      return GetClassState($mainPlayer, $CS_NumCharged) > 0 ? 3 : 0;
    case "MON039":
    case "MON040":
    case "MON041":
      return GetClassState($mainPlayer, $CS_NumCharged) > 0 ? 3 : 0;
    case "MON057":
      return GetClassState($mainPlayer, $CS_NumCharged) > 0 ? 3 : 0;
    case "MON058":
      return GetClassState($mainPlayer, $CS_NumCharged) > 0 ? 2 : 0;
    case "MON059":
      return GetClassState($mainPlayer, $CS_NumCharged) > 0 ? 1 : 0;
    case "MON155":
      return GetClassState($mainPlayer, $CS_NumPlayedFromBanish) > 0 ? 2 : 0;
    case "MON171":
    case "MON172":
    case "MON173":
      return GetClassState($defPlayer, $CS_ArcaneDamageTaken) > 0 ? 2 : 0;
    case "MON254":
    case "MON255":
    case "MON256":
      return GetClassState($mainPlayer, $CS_CardsBanished) > 0 ? 2 : 0;
    case "MON284":
    case "MON285":
    case "MON286":
      return NumCardsNonEquipBlocking() < 2 ? 1 : 0;
    case "MON287":
    case "MON288":
    case "MON289":
      return NumCardsNonEquipBlocking();
    case "MON290":
    case "MON291":
    case "MON292":
      return count($mainAuras) >= 1 ? 1 : 0;
    case "ELE082":
    case "ELE083":
    case "ELE084":
      return GetClassState($defPlayer,  $CS_ArcaneDamageTaken) >= 1 ? 2 : 0;
    case "ELE134":
    case "ELE135":
    case "ELE136":
      return $from == "ARS" ? 1 : 0;
    case "ELE202":
      $pitch = &GetPitch($mainPlayer);
      return CountPitch($pitch, 3) >= 1 ? 1 : 0;
    case "EVR038":
      return (ComboActive() ? 3 : 0);
    case "EVR040":
      return (ComboActive() ? 2 : 0);
    case "EVR041":
    case "EVR042":
    case "EVR043":
      return (ComboActive() ? CountCardOnChain("EVR041", "EVR042", "EVR043") : 0);
    case "EVR063":
      return 3;
    case "EVR064":
      return 2;
    case "EVR065":
      return 1;
    case "EVR105":
      return (GetClassState($mainPlayer, $CS_NumAuras) >= 2 ? 1 : 0);
    case "EVR116":
    case "EVR117":
    case "EVR118":
      return (GetClassState($mainPlayer, $CS_NumAuras) > 0 ? 3 : 0);
    case "DVR002":
      return GetClassState($mainPlayer, $CS_AtksWWeapon) >= 1 ? 1 : 0;
    case "RVD009":
      return IntimidateCount($mainPlayer) > 0 ? 2 : 0;
    case "UPR048":
      return (NumPhoenixFlameChainLinks() >= 2 ? 2 : 0);
    case "UPR098":
      return (RuptureActive() ? 3 : 0);
    case "UPR101":
      return (NumDraconicChainLinks() >= 2 ? 1 : 0);
    case "DYN047":
      return (ComboActive() ? 2 : 0);
    case "DYN056": case "DYN057": case "DYN058":
      return (ComboActive() ? 1 : 0);
    case "DYN059": case "DYN060": case "DYN061":
      return (ComboActive() ? 4 : 0);
    case "DYN115": case "DYN116":
      return NumEquipBlock() > 0 ? 1 : 0;
    case "DYN148": return 3;
    case "DYN149": return 2;
    case "DYN150": return 1;
    default:
      return 0;
  }
}

//Return 1 if the effect should be removed
function EffectHitEffect($cardID)
{
  global $combatChainState, $CCS_GoesWhereAfterLinkResolves, $defPlayer, $mainPlayer, $CCS_WeaponIndex, $combatChain, $CCS_DamageDealt;
  if (CardType($combatChain[0]) == "AA" && (SearchAuras("CRU028", 1) || SearchAuras("CRU028", 2))) return;
  switch ($cardID) {
    case "WTR129":
    case "WTR130":
    case "WTR131":
      GiveAttackGoAgain();
      break;
    case "WTR147":
    case "WTR148":
    case "WTR149":
      NaturesPathPilgrimageHit();
      break;
    case "ARC170-1":
    case "ARC171-1":
    case "ARC172-1":
      MainDrawCard();
      return 1;
    case "CRU124":
      if (IsHeroAttackTarget()) {
        PummelHit();
      }
      break;
    case "CRU145": case "CRU146": case "CRU147":
      if (ClassContains($combatChain[0], "RUNEBLADE", $mainPlayer)){
        if ($cardID == "CRU145") $amount = 3;
        else if ($cardID == "CRU146") $amount = 2;
        else $amount = 1;
        PlayAura("ARC112", $mainPlayer, $amount);
      }
      break;
    case "CRU084-2":
      PutItemIntoPlayForPlayer("CRU197", $mainPlayer, 0, 2);
      break;
    case "MON034":
      LuminaAscensionHit();
      break;
    case "MON081":
    case "MON082":
    case "MON083":
      $combatChainState[$CCS_GoesWhereAfterLinkResolves] = "SOUL";
      break;
    case "MON110":
    case "MON111":
    case "MON112":
      DuskPathPilgrimageHit();
      break;
    case "MON193":
      ShadowPuppetryHitEffect();
      break;
    case "MON218":
      if (count(GetSoul($defPlayer)) > 0) {
        BanishFromSoul($defPlayer);
        LoseHealth(1, $defPlayer);
      }
      break;
    case "MON299":
    case "MON300":
    case "MON301":
      $combatChainState[$CCS_GoesWhereAfterLinkResolves] = "BOTDECK";
      break;
    case "ELE003":
      if (IsHeroAttackTarget()) {
        PlayAura("ELE111", $defPlayer);
      }
      break;
    case "ELE005":
      if (IsHeroAttackTarget()) {
        $hand = &GetHand($defPlayer);
        $cards = "";
        if (!empty($hand)) // Discard 1st card at random
        {
          $ind = GetRandom() % count($hand);
          $card1 = $hand[$ind];
          unset($hand[$ind]);
          $hand = array_values($hand);
        }
        if (!empty($hand)) // Discard 2nd card at random
        {
          $ind = GetRandom() % count($hand);
          $card2 = $hand[$ind];
          unset($hand[$ind]);
          $hand = array_values($hand);
        }
        if ($card1 != "") $cards .= $card1;
        if ($card2 != "") $cards .= "," . $card2;
        if ($cards != "") {
          AddDecisionQueue("CHOOSEBOTTOM", $defPlayer, $cards);
        }
      }
      break;
    case "ELE019":
    case "ELE020":
    case "ELE021":
      if (IsHeroAttackTarget()) {
        AddDecisionQueue("FINDINDICES", $mainPlayer, "SEARCHMZ,THEIRARS", 1);
        AddDecisionQueue("SETDQCONTEXT", $mainPlayer, "Choose which card you want to put at the bottom of the deck", 1);
        AddDecisionQueue("CHOOSEMULTIZONE", $mainPlayer, "<-", 1);
        AddDecisionQueue("MZADDBOTDECK", $mainPlayer, "-", 1);
        AddDecisionQueue("MZREMOVE", $mainPlayer, "-", 1);
      }
      break;
    case "ELE022":
    case "ELE023":
    case "ELE024":
      if (IsHeroAttackTarget()) {
        PlayAura("ELE111", $defPlayer);
      }
      break;
    case "ELE035-2":
      if (IsHeroAttackTarget()) {
        AddCurrentTurnEffect("ELE035-3", $defPlayer);
        AddNextTurnEffect("ELE035-3", $defPlayer);
      }
      break;
    case "ELE037-2":
      if (IsHeroAttackTarget()) {
        DamageTrigger($defPlayer, 1, "ATTACKHIT");
      }
      break;
    case "ELE047":
    case "ELE048":
    case "ELE049":
      if (IsHeroAttackTarget()) {
        DamageTrigger($defPlayer, 1, "ATTACKHIT");
      }
      break;
    case "ELE066-HIT":
      AddLayer("TRIGGER", $mainPlayer, "ELE066");
      break;
    case "ELE092-BUFF":
      if (IsHeroAttackTarget()) {
        DamageTrigger($defPlayer, 3, "ATTACKHIT");
      }
      break;
    case "ELE151-HIT":
    case "ELE152-HIT":
    case "ELE153-HIT":
      if (IsHeroAttackTarget()) {
        PlayAura("ELE111", $defPlayer);
      }
      break;
    case "ELE163":
      if (IsHeroAttackTarget()) {
        PlayAura("ELE111", $defPlayer);
        PlayAura("ELE111", $defPlayer);
        PlayAura("ELE111", $defPlayer);
      }
      break;
    case "ELE164":
      if (IsHeroAttackTarget()) {
        PlayAura("ELE111", $defPlayer);
        PlayAura("ELE111", $defPlayer);
      }
      break;
    case "ELE165":
      if (IsHeroAttackTarget()) {
        PlayAura("ELE111", $defPlayer);
      }
      break;
    case "ELE173":
      if (IsHeroAttackTarget()) {
        DamageTrigger($defPlayer, 1, "ATTACKHIT");
      }
      return 1;
    case "ELE195":
    case "ELE196":
    case "ELE197":
      if (IsHeroAttackTarget()) {
        DamageTrigger($defPlayer, 1, "ATTACKHIT");
      }
      break;
    case "ELE198":
    case "ELE199":
    case "ELE200":
      if (IsHeroAttackTarget()) {
        if ($cardID == "ELE198") $damage = 3;
        else if ($cardID == "ELE199") $damage = 2;
        else $damage = 1;
        DamageTrigger($defPlayer, $damage, "ATTACKHIT");
        return 1;
      }
      break;
    case "ELE205":
      if (IsHeroAttackTarget()) {
        PummelHit();
        PummelHit();
      }
      break;
    case "ELE215":
      if (IsHeroAttackTarget()) {
        AddNextTurnEffect($cardID . "-1", $defPlayer);
        AddCurrentTurnEffectFromCombat("ELE215", $defPlayer); //Doesn't do anything just show it in the effects
      }
      break;
    case "EVR047-1":
    case "EVR048-1":
    case "EVR049-1":
      $idArr = explode("-", $cardID);
      AddCurrentTurnEffectFromCombat($idArr[0] . "-2", $mainPlayer);
      break;
    case "EVR066-1":
    case "EVR067-1":
    case "EVR068-1":
      PutItemIntoPlayForPlayer("CRU197", $mainPlayer);
      return 1;
    case "EVR161-1":
      GainHealth(2, $mainPlayer);
      break;
    case "EVR164":
      PutItemIntoPlayForPlayer("CRU197", $mainPlayer, 0, 6);
      RemoveCurrentEffect($mainPlayer, $cardID);
      break;
    case "EVR165":
      PutItemIntoPlayForPlayer("CRU197", $mainPlayer, 0, 4);
      RemoveCurrentEffect($mainPlayer, $cardID);
      break;
    case "EVR166":
      PutItemIntoPlayForPlayer("CRU197", $mainPlayer, 0, 2);
      RemoveCurrentEffect($mainPlayer, $cardID);
      break;
    case "EVR170-1":
    case "EVR171-1":
    case "EVR172-1":
      if (IsHeroAttackTarget()) {
        AddDecisionQueue("FINDINDICES", $defPlayer, "ITEMSMAX,2");
        AddDecisionQueue("CHOOSETHEIRITEM", $mainPlayer, "<-", 1);
        AddDecisionQueue("DESTROYITEM", $defPlayer, "<-", 1);
        return 1;
      }
      break;
    case "DVR008-1":
      $char = &GetPlayerCharacter($mainPlayer);
      if (IsHeroAttackTarget()) {
        ++$char[$combatChainState[$CCS_WeaponIndex] + 3];
      }
      break;
    case "DYN028":
      AddDecisionQueue("FINDINDICES", $mainPlayer, "CRU026");
      AddDecisionQueue("CHOOSETHEIRCHARACTER", $mainPlayer, "<-", 1);
      AddDecisionQueue("DESTROYTHEIRCHARACTER", $mainPlayer, "-", 1);
      break;
    case "DYN071":
      AddDecisionQueue("MULTIZONEINDICES", $mainPlayer, "THEIRALLY", 1);
      AddDecisionQueue("SETDQCONTEXT", $mainPlayer, "Choose a target to deal " . $combatChainState[$CCS_DamageDealt] . " damage.");
      AddDecisionQueue("MAYCHOOSEMULTIZONE", $mainPlayer, "<-", 1);
      AddDecisionQueue("MZDAMAGE", $mainPlayer, $combatChainState[$CCS_DamageDealt] . ",DAMAGE," . $cardID, 1);
      break;
    case "DYN155":
      if (IsHeroAttackTarget() && SearchCurrentTurnEffects("AIM", $mainPlayer)) {
        AddDecisionQueue("FINDINDICES", $mainPlayer, "SEARCHMZ,THEIRHAND");
        AddDecisionQueue("SETDQCONTEXT", $mainPlayer, "Choose which card you want your opponent to discard", 1);
        AddDecisionQueue("CHOOSEMULTIZONE", $mainPlayer, "<-", 1);
        AddDecisionQueue("MZDISCARD", $mainPlayer, "HAND,-," . $defPlayer, 1);
        AddDecisionQueue("MZREMOVE", $mainPlayer, "-", 1);
      }
      break;
    case "DYN185-HIT": case "DYN186-HIT": case "DYN187-HIT":
      if (ClassContains($combatChain[0], "RUNEBLADE", $mainPlayer)) {
        if ($cardID == "DYN185-HIT") $amount = 3;
        else if ($cardID == "DYN186-HIT") $amount = 2;
        else $amount = 1;
        PlayAura("ARC112", $mainPlayer, $amount, true);
      }
      break;
    default:
      break;
  }
  return 0;
}

function EffectAttackModifier($cardID)
{
  $set = CardSet($cardID);
  if ($set == "WTR") {
    return WTREffectAttackModifier($cardID);
  } else if ($set == "ARC") {
    return ARCEffectAttackModifier($cardID);
  } else if ($set == "CRU") {
    return CRUEffectAttackModifier($cardID);
  } else if ($set == "MON") {
    return MONEffectAttackModifier($cardID);
  } else if ($set == "ELE") {
    return ELEEffectAttackModifier($cardID);
  } else if ($set == "EVR") {
    return EVREffectAttackModifier($cardID);
  } else if ($set == "DVR") {
    return DVREffectAttackModifier($cardID);
  } else if ($set == "RVD") {
    return RVDEffectAttackModifier($cardID);
  } else if ($set == "UPR") {
    return UPREffectAttackModifier($cardID);
  } else if ($set == "DYN") {
    return DYNEffectAttackModifier($cardID);
  }
  switch ($cardID) {
    default:
      return 0;
  }
}

function EffectBlockModifier($cardID)
{
  global $combatChain, $defPlayer;
  switch ($cardID) {
    case "ELE000-2":
      return 1;
    case "ELE143":
      return 1;
    case "DYN115": case "DYN116":
      $rv = 0;
      for($i=0; $i<count($combatChain); $i+=CombatChainPieces())
      {
        if($combatChain[$i+1] != $defPlayer) continue;
        $cardType = CardType($combatChain[$i]);
        $cardBlock = BlockValue($combatChain[$i]);
        if($cardType == "AA" && $cardBlock-1 >= 0) $rv -= 1; // Check for rare case of cards with 0 defense
      }
      return $rv;
    default:
      return 0;
  }
}

function BlockModifier($cardID, $from, $resourcesPaid)
{
  global $defPlayer, $CS_CardsBanished, $mainPlayer, $CS_ArcaneDamageTaken, $combatChain, $chainLinkSummary;
  $blockModifier = 0;
  $cardType = CardType($cardID);
  if ($cardType == "AA") $blockModifier += CountCurrentTurnEffects("ARC160-1", $defPlayer);
  if ($cardType == "AA") $blockModifier += CountCurrentTurnEffects("EVR186", $defPlayer);
  if ($cardType == "E" && ($combatChain[0] == "DYN095" || $combatChain[0] == "DYN096" || $combatChain[0] == "DYN097")) $blockModifier -= 1;
  if (SearchCurrentTurnEffects("ELE114", $defPlayer) && ($cardType == "AA" || $cardType == "A") && (TalentContains($cardID, "ICE", $defPlayer) || TalentContains($cardID, "EARTH", $defPlayer) || TalentContains($cardID, "ELEMENTAL", $defPlayer))) $blockModifier += 1;
  $defAuras = &GetAuras($defPlayer);
  for ($i = 0; $i < count($defAuras); $i += AuraPieces()) {
    if ($defAuras[$i] == "WTR072" && CardCost($cardID) >= 3) $blockModifier += 4;
    if ($defAuras[$i] == "WTR073" && CardCost($cardID) >= 3) $blockModifier += 3;
    if ($defAuras[$i] == "WTR074" && CardCost($cardID) >= 3) $blockModifier += 2;
    if ($defAuras[$i] == "WTR046" && $cardType == "E") $blockModifier += 1;
    if ($defAuras[$i] == "ELE109" && $cardType == "A") $blockModifier += 1;
  }
  switch ($cardID) {
    case "WTR212":
    case "WTR213":
    case "WTR214":
      $blockModifier += $from == "ARS" ? 1 : 0;
      break;
    case "WTR051":
    case "WTR052":
    case "WTR053":
      $blockModifier += ($resourcesPaid >= 6 ? 3 : 0);
      break;
    case "ARC150":
      $blockModifier += (DefHasLessHealth() ? 1 : 0);
      break;
    case "CRU187":
      $blockModifier += ($from == "ARS" ? 2 : 0);
      break;
    case "MON075":
    case "MON076":
    case "MON077":
      return GetClassState($mainPlayer, $CS_CardsBanished) >= 3 ? 2 : 0;
    case "MON290":
    case "MON291":
    case "MON292":
      return count($defAuras) >= 1 ? 1 : 0;
    case "ELE227":
    case "ELE228":
    case "ELE229":
      return GetClassState($mainPlayer, $CS_ArcaneDamageTaken) > 0 ? 1 : 0;
    case "EVR050":
    case "EVR051":
    case "EVR052":
      return (CardCost($combatChain[0]) == 0 && CardType($combatChain[0]) == "AA" ? 2 : 0);
    case "DYN045":
      $blockModifier += (count($chainLinkSummary)/ChainLinksPieces() >= 4 ? 4 : 0);
      break;
    case "DYN036": case "DYN037": case "DYN038":
      $blockModifier += SearchCharacter($defPlayer, subtype: "Off-Hand", class: "GUARDIAN") != "" ? 4 : 0;
      break;
    default:
      break;
  }
  return $blockModifier;
}

function PlayBlockModifier($cardID)
{
  switch ($cardID) {
    case "CRU189":
      return 4;
    case "CRU190":
      return 3;
    case "CRU191":
      return 2;
    case "ELE125":
      return 4;
    case "ELE126":
      return 3;
    case "ELE127":
      return 2;
    default:
      return 0;
  }
}

function SelfCostModifier($cardID)
{
  global $CS_NumCharged, $currentPlayer, $combatChain, $CS_LayerTarget;
  switch ($cardID) {
    case "ARC080":
      return (-1 * NumRunechants($currentPlayer));
    case "ARC082":
      return (-1 * NumRunechants($currentPlayer));
    case "ARC088":
    case "ARC089":
    case "ARC090":
      return (-1 * NumRunechants($currentPlayer));
    case "ARC094":
    case "ARC095":
    case "ARC096":
      return (-1 * NumRunechants($currentPlayer));
    case "ARC097":
    case "ARC098":
    case "ARC099":
      return (-1 * NumRunechants($currentPlayer));
    case "ARC100":
    case "ARC101":
    case "ARC102":
      return (-1 * NumRunechants($currentPlayer));
    case "MON032":
      return (-1 * (2 * GetClassState($currentPlayer, $CS_NumCharged)));
    case "MON084":
    case "MON085":
    case "MON086":
      return TalentContains($combatChain[GetClassState($currentPlayer, $CS_LayerTarget)], "SHADOW") ? -1 : 0;
    case "DYN104":
    case "DYN105":
    case "DYN106":
      $numHypers = 0;
      $numHypers += CountItem("ARC036", $currentPlayer);
      $numHypers += CountItem("DYN111", $currentPlayer);
      $numHypers += CountItem("DYN112", $currentPlayer);
      return $numHypers > 0 ? -1 : 0;
    default:
      return 0;
  }
}

function CharacterCostModifier($cardID, $from)
{
  global $currentPlayer, $CS_NumSwordAttacks;
  $modifier = 0;
  if (CardSubtype($cardID) == "Sword" && GetClassState($currentPlayer, $CS_NumSwordAttacks) == 1 && (SearchCharacterActive($currentPlayer, "CRU077") || (SearchCharacterActive($currentPlayer, "CRU097") && SearchCurrentTurnEffects("CRU077-SHIYANA", $currentPlayer)))) {
    --$modifier;
  }
  return $modifier;
}

function RemoveCurrentEffect($player, $effectID)
{
  global $currentTurnEffects;
  for ($i = count($currentTurnEffects) - CurrentTurnPieces(); $i >= 0; $i -= CurrentTurnPieces()) {
    if ($currentTurnEffects[$i + 1] == $player && $currentTurnEffects[$i] == $effectID) {
      RemoveCurrentTurnEffect($i);
      break;
    }
  }
  $currentTurnEffects = array_values($currentTurnEffects);
}

function CurrentEffectChainClosedEffects()
{
  global $currentTurnEffects;
  $costModifier = 0;
  for ($i = count($currentTurnEffects) - CurrentTurnPieces(); $i >= 0; $i -= CurrentTurnPieces()) {
    $remove = 0;
    switch ($currentTurnEffects[$i]) {
      case "CRU106":
      case "CRU107":
      case "CRU108":
        $remove = 1;
        break;
      default:
        break;
    }
    if ($remove == 1) RemoveCurrentTurnEffect($i);
  }
  return $costModifier;
}

function CurrentEffectBaseAttackSet($cardID)
{
  global $currentPlayer, $currentTurnEffects;
  $currentModifier = -1;
  for ($i = count($currentTurnEffects) - CurrentTurnPieces(); $i >= 0; $i -= CurrentTurnPieces()) {
    $mod = -1;
    if ($currentTurnEffects[$i + 1] == $currentPlayer && IsCombatEffectActive($currentTurnEffects[$i])) {
      switch ($currentTurnEffects[$i]) {
        case "UPR155":
          $mod = 8;
          break;
        case "UPR156":
          $mod = 7;
          break;
        case "UPR157":
          $mod = 6;
          break;
        default:
          break;
      }
      if ($mod > $currentModifier) $currentModifier = $mod;
    }
  }
  return $currentModifier;
}

function CurrentEffectCostModifiers($cardID, $from)
{
  global $currentTurnEffects, $currentPlayer, $CS_PlayUniqueID;
  $costModifier = 0;
  for ($i = count($currentTurnEffects) - CurrentTurnPieces(); $i >= 0; $i -= CurrentTurnPieces()) {
    if ($currentTurnEffects[$i + 1] == $currentPlayer) {
      $remove = 0;
      switch ($currentTurnEffects[$i]) {
        case "WTR060":
        case "WTR061":
        case "WTR062":
          if (IsAction($cardID)) {
            $costModifier += 1;
            $remove = 1;
          }
          break;
        case "WTR075":
          if (ClassContains($cardID, "GUARDIAN", $currentPlayer) && CardType($cardID) == "AA") {
            $costModifier -= 1;
            $remove = 1;
          }
          break;
        case "WTR152":
          if (CardType($cardID) == "AA") {
            $costModifier -= 2;
            $remove = 1;
          }
          break;
        case "CRU081":
          if (CardType($cardID) == "W" && CardSubType($cardID) == "Sword") {
            $costModifier -= 1;
          }
          break;
        case "CRU085-2":
        case "CRU086-2":
        case "CRU087-2":
          if (CardType($cardID) == "DR") {
            $costModifier += 1;
            $remove = 1;
          }
          break;
        case "CRU141-AA":
          if (CardType($cardID) == "AA") {
            $costModifier -= CountAura("ARC112", $currentPlayer);
            $remove = 1;
          }
          break;
        case "CRU141-NAA":
          if (CardType($cardID) == "A") {
            $costModifier -= CountAura("ARC112", $currentPlayer);
            $remove = 1;
          }
          break;
        case "CRU188":
          $costModifier -= 999;
          $remove = 1;
          break;
        case "MON257":
          $costModifier -= 999;
          $remove = 1;
          break;
        case "MON199":
          $costModifier -= 999;
          $remove = 1;
          break;
        case "ARC185":
          $costModifier -= 999;
          $remove = 1;
          break;
        case "EVR161":
          $costModifier -= 999;
          $remove = 1;
          break;
        case "ARC060":
        case "ARC061":
        case "ARC062":
          if (CardType($cardID) == "AA" || GetAbilityType($cardID) == "AA") {
            $costModifier += 1;
            $remove = 1;
          }
          break;
        case "ELE035-1":
          $costModifier += 1;
          break;
        case "ELE038":
        case "ELE039":
        case "ELE040":
          $costModifier += 1;
          break;
        case "ELE144":
          $costModifier += 1;
          break;
        case "EVR179":
          if (IsStaticType(CardType($cardID), $from, $cardID)) {
            $costModifier -= 1;
            $remove = 1;
          }
          break;
        case "UPR000":
          if (TalentContains($cardID, "DRACONIC", $currentPlayer) && $from != "PLAY" && $from != "EQUIP") {
            $costModifier -= 1;
            --$currentTurnEffects[$i + 3];
            if ($currentTurnEffects[$i + 3] <= 0) $remove = 1;
          }
          break;
        case "UPR075":
        case "UPR076":
        case "UPR077":
          if (GetClassState($currentPlayer, $CS_PlayUniqueID) == $currentTurnEffects[$i + 2]) {
            --$costModifier;
            $remove = 1;
          }
          break;
        case "UPR166":
          if (IsStaticType(CardType($cardID), $from, $cardID) && DelimStringContains(CardSubType($cardID), "Staff")) {
            $costModifier -= 3;
            $remove = 1;
          }
          break;
        default:
          break;
      }
      if ($remove == 1) RemoveCurrentTurnEffect($i);
    }
  }
  return $costModifier;
}

function BanishCostModifier($from, $index)
{
  global $currentPlayer;
  if ($from != "BANISH") return 0;
  $banish = GetBanish($currentPlayer);
  $mod = explode("-", $banish[$index + 1]);
  switch ($mod[0]) {
    case "ARC119":
      return -1 * intval($mod[1]);
    default:
      return 0;
  }
}

function CurrentEffectDamagePrevention($player, $type, $damage, $source)
{
  global $currentTurnEffects, $currentPlayer;
  $prevention = 0;
  for ($i = count($currentTurnEffects) - CurrentTurnEffectPieces(); $i >= 0 && $prevention < $damage; $i -= CurrentTurnEffectPieces()) {
    if ($currentTurnEffects[$i + 1] == $player) {
      $effects = explode("-", $currentTurnEffects[$i]);
      $remove = 0;
      switch ($effects[0]) {
        case "ARC035":
          $prevention += $effects[1];
          $remove = 1;
          break;
        case "CRU041":
          if ($type == "COMBAT") {
            $prevention += 3;
            $remove = 1;
          }
          break;
        case "CRU042":
          if ($type == "COMBAT") {
            $prevention += 2;
            $remove = 1;
          }
          break;
        case "CRU043":
          if ($type == "COMBAT") {
            $prevention += 1;
            $remove = 1;
          }
          break;
        case "EVR033": case "EVR034": case "EVR035":
          if ($source == $currentTurnEffects[$i + 2]) {
            $prevention += $currentTurnEffects[$i + 3];
            $currentTurnEffects[$i + 3] -= $damage;
            if ($currentTurnEffects[$i + 3] <= 0) $remove = 1;
          }
          break;
        case "EVR180":
          $prevention += 1;
          $remove = 1;
          break;
        case "UPR183":
          $prevention += 1;
          $remove = 1;
          break;
        case "UPR221": case "UPR222": case "UPR223":
          if($source == $currentTurnEffects[$i+2])
          {
            $prevention += $currentTurnEffects[$i+3];
            $currentTurnEffects[$i+3] -= $damage;
            if($currentTurnEffects[$i+3] <= 0) $remove = 1;
          }
          break;
        case "DYN025":
          if ($currentTurnEffects[$i] == "DYN025-1") {
            $prevention += 1;
            $remove = 1;
          }
          break;
        default:
          break;
      }
      if ($remove == 1) RemoveCurrentTurnEffect($i);
    }
  }
  return $prevention;
}

function CurrentEffectAttackAbility()
{
  global $currentTurnEffects, $combatChain, $mainPlayer;
  global $CS_PlayIndex;
  if (count($combatChain) == 0) return;
  $attackID = $combatChain[0];
  $attackType = CardType($attackID);
  for ($i = count($currentTurnEffects) - CurrentTurnPieces(); $i >= 0; $i -= CurrentTurnPieces()) {
    $remove = 0;
    if ($currentTurnEffects[$i + 1] == $mainPlayer) {
      switch ($currentTurnEffects[$i]) {
        case "EVR056":
          if ($attackType == "W") {
            $character = &GetPlayerCharacter($mainPlayer);
            ++$character[GetClassState($mainPlayer, $CS_PlayIndex) + 3];
          }
          break;
        case "MON183":
        case "MON184":
        case "MON185":
          if ($currentTurnEffects[$i] == "MON183") $maxCost = 2;
          else if ($currentTurnEffects[$i] == "MON184") $maxCost = 1;
          else $maxCost = 0;
          if ($attackType == "AA" && CardCost($attackID) <= $maxCost) {
            WriteLog("Seeds of Agony dealt 1 damage.");
            DealArcane(1, 0, "PLAYCARD", $currentTurnEffects[$i], true);
            $remove = 1;
          }
          break;
        default:
          break;
      }
    }
    if ($remove == 1) RemoveCurrentTurnEffect($i);
  }
  $currentTurnEffects = array_values($currentTurnEffects); //In case any were removed
}

function CurrentEffectPlayAbility($cardID, $from)
{
  global $currentTurnEffects, $currentPlayer, $actionPoints, $CS_LastDynCost, $CCS_CurrentAttackGainedGoAgain;

  //Check for dynamic costs
  if (DynamicCost($cardID) != "") {
    $cost = GetClassState($currentPlayer, $CS_LastDynCost);
  } else {
    $cost = CardCost($cardID);
  }

  for ($i = count($currentTurnEffects) - CurrentTurnPieces(); $i >= 0; $i -= CurrentTurnPieces()) {
    $remove = 0;
    if ($currentTurnEffects[$i + 1] == $currentPlayer) {
      switch ($currentTurnEffects[$i]) {
        case "ARC209":
          $cardType = CardType($cardID);
          if (($cardType == "A" || $cardType == "AA") && $cost >= 0) {
            ++$actionPoints;
            $remove = 1;
          }
          break;
        case "ARC210":
          $cardType = CardType($cardID);
          if (($cardType == "A" || $cardType == "AA") && $cost >= 1) {
            ++$actionPoints;
            $remove = 1;
          }
          break;
        case "ARC211":
          $cardType = CardType($cardID);
          if (($cardType == "A" || $cardType == "AA") && $cost >= 2) {
            ++$actionPoints;
            $remove = 1;
          }
          break;
        case "MON153":
        case "MON154":
          if (CardType($cardID) != "A" && (ClassContains($cardID, "RUNEBLADE", $currentPlayer) || TalentContains($cardID, "SHADOW", $currentPlayer))) {
            GiveAttackGoAgain();
            $remove = 1;
          }
          break;
        case "DYN200": case "DYN201": case "DYN202":
          if ($currentTurnEffects[$i] == "DYN200") $amount = 3;
          else if ($currentTurnEffects[$i] == "DYN201") $amount = 2;
          else $amount = 1;
          if (ActionsThatDoArcaneDamage($cardID)) AddArcaneBonus($amount, $currentPlayer);
          if ($from != "EQUIP") $remove = 1;
          break;
        case "DYN209": case "DYN210": case "DYN211":
          if ($currentTurnEffects[$i] == "DYN209") $maxCost = 2;
          else if ($currentTurnEffects[$i] == "DYN210") $maxCost = 1;
          else $maxCost = 0;
          if (ActionsThatDoArcaneDamage($cardID) && CardCost($cardID) <= $maxCost)
          {
            AddArcaneBonus(1, $currentPlayer);
            $remove = 1;
          }
          break;
        default:
          break;
      }
      if ($remove == 1) RemoveCurrentTurnEffect($i);
    }
  }
  $currentTurnEffects = array_values($currentTurnEffects); //In case any were removed
  return false;
}

function CurrentEffectGrantsNonAttackActionGoAgain($cardID)
{
  global $currentTurnEffects, $currentPlayer;
  $hasGoAgain = false;
  for ($i = count($currentTurnEffects) - CurrentTurnPieces(); $i >= 0; $i -= CurrentTurnPieces()) {
    $remove = 0;
    if ($currentTurnEffects[$i + 1] == $currentPlayer) {
      switch ($currentTurnEffects[$i]) {
        case "MON153":
        case "MON154":
          if (ClassContains($cardID, "RUNEBLADE", $currentPlayer) || TalentContains($cardID, "SHADOW", $currentPlayer)) {
            $hasGoAgain = true;
            $remove = 1;
          }
          break;
        case "ELE177":
          if (CardCost($cardID) >= 0) {
            $hasGoAgain = true;
            $remove = 1;
          }
          break;
        case "ELE178":
          if (CardCost($cardID) >= 1) {
            $hasGoAgain = true;
            $remove = 1;
          }
          break;
        case "ELE179":
          if (CardCost($cardID) >= 2) {
            $hasGoAgain = true;
            $remove = 1;
          }
          break;
        case "ELE201":
          $hasGoAgain = true;
          $remove = 1;
          break;
        default:
          break;
      }
    }
    if ($remove == 1) RemoveCurrentTurnEffect($i);
  }
  return $hasGoAgain;
}

function CurrentEffectGrantsGoAgain()
{
  global $currentTurnEffects, $mainPlayer, $combatChainState, $CCS_AttackFused, $CCS_CurrentAttackGainedGoAgain;
  for ($i = 0; $i < count($currentTurnEffects); $i += CurrentTurnEffectPieces()) {
    if ($currentTurnEffects[$i + 1] == $mainPlayer && IsCombatEffectActive($currentTurnEffects[$i]) && !IsCombatEffectLimited($i)) {
      switch ($currentTurnEffects[$i]) {
        case "WTR144":
        case "WTR145":
        case "WTR146":
          return true;
        case "ARC047":
          return true;
        case "ARC160-3":
          return true;
        case "CRU053":
          return true;
        case "CRU055":
          return true;
        case "CRU084":
          return true;
        case "CRU091-1":
        case "CRU092-1":
        case "CRU093-1":
          return true;
        case "CRU122":
          return true;
        case "CRU145":
        case "CRU146":
        case "CRU147":
          return true;
        case "MON165":
        case "MON166":
        case "MON167":
          return true;
        case "MON193":
          return true;
        case "MON247":
          return true;
        case "MON260-2":
        case "MON261-2":
        case "MON262-2":
          return true;
        case "ELE031-1":
          return true;
        case "ELE034-2":
          return true;
        case "ELE091-GA":
          return true;
        case "ELE177":
        case "ELE178":
        case "ELE179":
          return true;
        case "ELE180":
        case "ELE181":
        case "ELE182":
          return $combatChainState[$CCS_AttackFused] == 1;
        case "ELE201":
          return true;
        case "EVR017":
          return true;
        case "EVR161-3":
          return true;
        case "EVR044":
        case "EVR045":
        case "EVR046":
          return true;
        case "DVR008":
          return true;
        case "DVR019":
          return true;
        case "UPR081":
        case "UPR082":
        case "UPR083":
          return true;
        case "UPR094":
          return true;
        case "DYN076": case "DYN077": case "DYN078": return true;
        default:
          break;
      }
    }
  }
  return false;
}

function CurrentEffectPreventsGoAgain()
{
  global $currentTurnEffects, $mainPlayer;
  for ($i = 0; $i < count($currentTurnEffects); $i += CurrentTurnEffectPieces()) {
    if ($currentTurnEffects[$i + 1] == $mainPlayer) {
      switch ($currentTurnEffects[$i]) {
        case "WTR044":
          return true;
        default:
          break;
      }
    }
  }
  return false;
}

function CurrentEffectPreventsDefenseReaction($from)
{
  global $currentTurnEffects, $currentPlayer;
  for ($i = 0; $i < count($currentTurnEffects); $i += CurrentTurnEffectPieces()) {
    if ($currentTurnEffects[$i + 1] == $currentPlayer) {
      switch ($currentTurnEffects[$i]) {
        case "CRU123":
          return $from == "ARS" && IsCombatEffectActive($currentTurnEffects[$i]);
        case "CRU135-1":
        case "CRU136-1":
        case "CRU137-1":
          return $from == "HAND" && IsCombatEffectActive($currentTurnEffects[$i]);
        case "EVR091-1":
        case "EVR092-1":
        case "EVR093-1":
          return $from == "ARS" && IsCombatEffectActive($currentTurnEffects[$i]);
        default:
          break;
      }
    }
  }
  return false;
}

function CurrentEffectPreventsDraw($player, $isMainPhase)
{
  global $currentTurnEffects;
  for ($i = 0; $i < count($currentTurnEffects); $i += CurrentTurnEffectPieces()) {
    if ($currentTurnEffects[$i + 1] == $player) {
      switch ($currentTurnEffects[$i]) {
        case "WTR045":
          return $isMainPhase;
        default:
          break;
      }
    }
  }
  return false;
}

function CurrentEffectIntellectModifier()
{
  global $currentTurnEffects, $mainPlayer;
  $intellectModifier = 0;
  for ($i = count($currentTurnEffects) - CurrentTurnEffectPieces(); $i >= 0; $i -= CurrentTurnEffectPieces()) {
    if ($currentTurnEffects[$i + 1] == $mainPlayer) {
      switch ($currentTurnEffects[$i]) {
        case "WTR042":
          $intellectModifier += 1;
          break;
        case "ARC161":
          $intellectModifier += 1;
          break;
        case "CRU028":
          $intellectModifier += 1;
          break;
        case "MON000":
          $intellectModifier += 1;
          break;
        case "MON246":
          $intellectModifier += 1;
          break;
        default:
          break;
      }
    }
  }
  return $intellectModifier;
}

function CurrentEffectEndTurnAbilities()
{
  global $currentTurnEffects;
  for ($i = count($currentTurnEffects) - CurrentTurnPieces(); $i >= 0; $i -= CurrentTurnPieces()) {
    $remove = 0;
    $cardID = substr($currentTurnEffects[$i], 0, 6);
    if (SearchCurrentTurnEffects($cardID . "-UNDER", $currentTurnEffects[$i + 1])) {
      AddNextTurnEffect($currentTurnEffects[$i], $currentTurnEffects[$i + 1]); // Todo: Need to check in the future if it's still under
    }
    switch ($currentTurnEffects[$i]) {
      case "MON069":
      case "MON070":
      case "MON071":
      case "EVR056": //Oath of Steel does the same thing
        $char = &GetPlayerCharacter($currentTurnEffects[$i + 1]);
        for ($j = 0; $j < count($char); $j += CharacterPieces()) {
          if (CardType($char[$j]) == "W") $char[$j + 3] = 0; //Glisten clears out all +1 power counters
        }
        $remove = 1;
        break;
      default:
        break;
    }
    if ($remove == 1) RemoveCurrentTurnEffect($i);
  }
}

function IsCombatEffectActive($cardID)
{
  global $combatChain, $currentPlayer;
  if (count($combatChain) == 0) return;
  if($cardID == "AIM") return true;
  $attackID = $combatChain[0];
  if ($cardID == "CRU097") {
    $otherPlayer = ($currentPlayer == 1 ? 2 : 1);
    $otherCharacter = &GetPlayerCharacter($otherPlayer);
    if (SearchCurrentTurnEffects($otherCharacter[0] . "-SHIYANA", $currentPlayer)) {
      return IsCombatEffectActive($otherCharacter[0]);
    }
  }
  $set = CardSet($cardID);
  if ($set == "WTR") {
    return WTRCombatEffectActive($cardID, $attackID);
  } else if ($set == "ARC") {
    return ARCCombatEffectActive($cardID, $attackID);
  } else if ($set == "CRU") {
    return CRUCombatEffectActive($cardID, $attackID);
  } else if ($set == "MON") {
    return MONCombatEffectActive($cardID, $attackID);
  } else if ($set == "ELE") {
    return ELECombatEffectActive($cardID, $attackID);
  } else if ($set == "EVR") {
    return EVRCombatEffectActive($cardID, $attackID);
  } else if ($set == "DVR") {
    return DVRCombatEffectActive($cardID, $attackID);
  } else if ($set == "UPR") {
    return UPRCombatEffectActive($cardID, $attackID);
  } else if ($set == "DYN") {
    return DYNCombatEffectActive($cardID, $attackID);
  }
  switch ($cardID) {
    default:
      return 0;
  }
}

function IsCombatEffectPersistent($cardID)
{
  global $currentPlayer;
  if ($cardID == "CRU097") {
    $otherPlayer = ($currentPlayer == 1 ? 2 : 1);
    $otherCharacter = &GetPlayerCharacter($otherPlayer);
    if (SearchCurrentTurnEffects($otherCharacter[0] . "-SHIYANA", $currentPlayer)) {
      return IsCombatEffectPersistent($otherCharacter[0]);
    }
  }
  switch ($cardID) {
    case "WTR007":
      return true;
    case "WTR038":
    case "WTR039":
      return true;
    case "ARC047":
      return true;
    case "ARC160-1":
      return true;
    case "ARC170-1":
    case "ARC171-1":
    case "ARC172-1":
      return true;
    case "CRU025":
      return true;
    case "CRU053":
      return true;
    case "CRU084-2":
      return true;
    case "CRU105":
      return true;
    case "CRU122":
      return true;
    case "CRU124":
      return true;
    case "MON034":
      return true;
    case "MON087":
      return true;
    case "MON108":
      return true;
    case "MON109":
      return true;
    case "MON218":
      return true;
    case "MON239":
      return true;
    case "MON245":
      return true;
    case "ELE044":
    case "ELE045":
    case "ELE046":
      return true;
    case "ELE047":
    case "ELE048":
    case "ELE049":
      return true;
    case "ELE050":
    case "ELE051":
    case "ELE052":
      return true;
    case "ELE059":
    case "ELE060":
    case "ELE061":
      return true;
    case "ELE066-HIT":
      return true;
    case "ELE067":
    case "ELE068":
    case "ELE069":
      return true;
    case "ELE091-BUFF":
    case "ELE091-GA":
      return true;
    case "ELE092-DOM":
    case "ELE092-BUFF":
      return true;
    case "ELE112-1":
      return true;
    case "ELE143":
      return true;
    case "ELE151-HIT":
    case "ELE152-HIT":
    case "ELE153-HIT":
      return true;
    case "ELE173":
      return true;
    case "ELE198":
    case "ELE199":
    case "ELE200":
      return true;
    case "EVR001":
      return true;
    case "EVR019":
      return true;
    case "EVR066-1":
    case "EVR067-1":
    case "EVR068-1":
      return true;
    case "EVR090":
      return true;
    case "EVR160":
      return true;
    case "EVR164":
    case "EVR165":
    case "EVR166":
      return true;
    case "EVR170-1":
    case "EVR171-1":
    case "EVR172-1":
      return true;
    case "EVR186":
      return true;
    case "DVR008-1":
      return true;
    case "UPR036": case "UPR037": case "UPR038": return true;
    case "UPR047":
      return true;
    case "UPR049":
      return true;
    case "DYN009":
      return true;
    case "DYN049":
      return true;
    case "DYN089-UNDER":
      return true;
    case "DYN154":
      return true;
    default:
      return false;
  }
}

function BeginEndPhaseEffects()
{
  global $currentTurnEffects, $mainPlayer, $CS_EffectContext;
  EndTurnBloodDebt(); //This has to be before resetting character, because of sleep dart effects
  for ($i = 0; $i < count($currentTurnEffects); $i += CurrentTurnPieces()) {
    switch ($currentTurnEffects[$i]) {
      case "ELE215-1":
        WriteLog(CardLink("ELE215", "ELE215") . " discarded your hand and arsenal.");
        DestroyArsenal($currentTurnEffects[$i + 1]);
        DiscardHand($currentTurnEffects[$i + 1]);
        break;
      case "EVR106":
        WriteLog(CardLink($currentTurnEffects[$i], $currentTurnEffects[$i]) . " destroyed your Runechants.");
        DestroyAllThisAura($currentTurnEffects[$i + 1], "ARC112");
        break;
      case "UPR200":
      case "UPR201":
      case "UPR202":
        SetClassState($currentTurnEffects[$i + 1], $CS_EffectContext, $currentTurnEffects[$i]);
        Draw($currentTurnEffects[$i + 1]);
        break;
      case "DYN153":
        $deck = &GetDeck($mainPlayer);
        if(count($deck) == 0) {
          WriteLog("Your Heat Seeker fizzled out.");
          break;
        }
        if(!ArsenalFull($mainPlayer)) {
          $card = array_shift($deck);
          WriteLog("Heat Seeker added " . CardLink($card, $card) . " to your arsenal.");
          AddArsenal($card, $mainPlayer, "DECK", "UP");
        } else {
          WriteLog("Your arsenal is full, so you cannot put an arrow in your arsenal.");
        }
        break;
      default:
        break;
    }
  }
}

//NOTE: This happens at start of turn, so must use main player game state
function ItemStartTurnAbility($index)
{
  global $mainPlayer;
  $mainItems = &GetItems($mainPlayer);
  switch ($mainItems[$index]) {
    case "ARC007":
      AddLayer("TRIGGER", $mainPlayer, $mainItems[$index], "-", "-", $mainItems[$index + 4]);
      break;
    case "ARC035":
      AddLayer("TRIGGER", $mainPlayer, $mainItems[$index], "-", "-", $mainItems[$index + 4]);
      break;
    case "EVR069":
      AddLayer("TRIGGER", $mainPlayer, $mainItems[$index], "-", "-", $mainItems[$index + 4]);
      break;
    case "EVR071":
      AddLayer("TRIGGER", $mainPlayer, $mainItems[$index], "-", "-", $mainItems[$index + 4]);
      break;
    default:
      break;
  }
}

function ItemEndTurnAbilities()
{
  global $mainPlayer;
  $items = &GetItems($mainPlayer);
  for ($i = count($items) - ItemPieces(); $i >= 0; $i -= ItemPieces()) {
    $remove = false;
    switch ($items[$i]) {
      case "EVR188":
        $remove = TalismanOfBalanceEndTurn();
        break;
      default:
        break;
    }
    if ($remove) {
      DestroyItemForPlayer($mainPlayer, $i);
    }
  }
}

function ItemDamageTakenAbilities($player, $damage)
{
  $otherPlayer = ($player == 1 ? 2 : 1);
  $items = &GetItems($otherPlayer);
  for ($i = count($items) - ItemPieces(); $i >= 0; $i -= ItemPieces()) {
    $remove = false;
    switch ($items[$i]) {
      case "EVR193":
        if (IsHeroAttackTarget() && $damage == 2) {
          WriteLog("Talisman of Warfare destroyed both arsenals.");
          DestroyArsenal(1);
          DestroyArsenal(2);
          $remove = true;
        }
        break;
      default:
        break;
    }
    if ($remove) {
      DestroyItemForPlayer($otherPlayer, $i);
    }
  }
}

function CharacterStartTurnAbility($index)
{
  global $mainPlayer;
  $mainCharacter = &GetPlayerCharacter($mainPlayer);

  if ($mainCharacter[$index + 1] == 0 && !CharacterTriggerInGraveyard($mainCharacter[$index])) return; //Do not process ability if it is destroyed
  switch ($mainCharacter[$index]) {
    case "WTR150":
      if ($mainCharacter[$index + 2] < 3) ++$mainCharacter[$index + 2];
      break;
    case "CRU097":
      if ($mainCharacter[$index + 1] == 2) {
        AddLayer("TRIGGER", $mainPlayer, $mainCharacter[$index]);
      }
      break;
    case "MON187":
      if (GetHealth($mainPlayer) <= 13) {
        $mainCharacter[$index + 1] = 0;
        BanishCardForPlayer($mainCharacter[$index], $mainPlayer, "EQUIP", "NA");
        WriteLog(CardLink($mainCharacter[$index], $mainCharacter[$index]) . " got banished for having 13 or less health.");
      }
      break;
    case "EVR017":
      if ($mainCharacter[$index + 1] == 2) {
        AddDecisionQueue("SETDQCONTEXT", $mainPlayer, "You may reveal an Earth, Ice, and Lightning card from your hand for Bravo, Star of the Show.");
        AddDecisionQueue("FINDINDICES", $mainPlayer, "BRAVOSTARSHOW");
        AddDecisionQueue("MULTICHOOSEHAND", $mainPlayer, "<-", 1);
        AddDecisionQueue("BRAVOSTARSHOW", $mainPlayer, "-", 1);
      }
      break;
    case "EVR019":
      if (CountAura("WTR075", $mainPlayer) >= 3 && $mainCharacter[$index + 1] == 2) {
        WriteLog(CardLink($mainCharacter[$index], $mainCharacter[$index]) . " gives your Crush attacks Dominate this turn.");
        AddCurrentTurnEffect("EVR019", $mainPlayer);
      }
      break;
    case "DYN117": case "DYN118":
      $discardIndex = SearchDiscardForCard($mainPlayer, $mainCharacter[$index]);
      if($mainCharacter[$index+1] == 0 && CountItem("EVR195", $mainPlayer) >= 2 && $discardIndex != "") {
        AddDecisionQueue("COUNTSILVERS", $mainPlayer, "");
        AddDecisionQueue("LESSTHANPASS", $mainPlayer, "2");
        AddDecisionQueue("SETDQCONTEXT", $mainPlayer, "Do you want to pay 2 silvers to equip " . CardLink($mainCharacter[$index], $mainCharacter[$index]) . "?", 1);
        AddDecisionQueue("YESNO", $mainPlayer, "if_they_want_to_pay_and_equip_" . CardLink($mainCharacter[$index], $mainCharacter[$index]), 1);
        AddDecisionQueue("NOPASS", $mainPlayer, "-", 1);
        AddDecisionQueue("PASSPARAMETER", $mainPlayer, "EVR195-2", 1);
        AddDecisionQueue("FINDANDDESTROYITEM", $mainPlayer, "<-", 1);
        AddDecisionQueue("PASSPARAMETER", $mainPlayer, "MYCHAR-" . $index, 1);
        AddDecisionQueue("MZUNDESTROY", $mainPlayer, "-", 1);
        AddDecisionQueue("PASSPARAMETER", $mainPlayer, "MYDISCARD-" . $discardIndex, 1);
        AddDecisionQueue("MULTIZONEREMOVE", $mainPlayer, "-", 1);
      }
      break;
    default:
      break;
  }
}

function DefCharacterStartTurnAbilities()
{
  global $defPlayer, $mainPlayer;
  $character = &GetPlayerCharacter($defPlayer);
  for ($i = 0; $i < count($character); $i += CharacterPieces()) {
    if ($character[$i + 1] == 0) continue; //Do not process ability if it is destroyed
    switch ($character[$i]) {
      case "EVR086":
        if (PlayerHasLessHealth($mainPlayer)) {
          AddDecisionQueue("CHARREADYORPASS", $defPlayer, $i);
          AddDecisionQueue("YESNO", $mainPlayer, "if_you_want_to_draw_a_card_and_give_your_opponent_a_silver.", 1);
          AddDecisionQueue("NOPASS", $mainPlayer, "-", 1);
          AddDecisionQueue("DRAW", $mainPlayer, "-", 1);
          AddDecisionQueue("PASSPARAMETER", $defPlayer, "EVR195", 1);
          AddDecisionQueue("PUTPLAY", $defPlayer, "0", 1);
        }
        break;
      default:
        break;
    }
  }
}

function PitchAbility($cardID)
{
  global $currentPlayer, $CS_NumAddedToSoul;

  $pitchValue = PitchValue($cardID);
  if (GetClassState($currentPlayer, $CS_NumAddedToSoul) > 0 && SearchCharacterActive($currentPlayer, "MON060") && TalentContains($cardID, "LIGHT", $currentPlayer)) {
    $resources = &GetResources($currentPlayer);
    $resources[0] += 1;
  }
  if ($pitchValue == 1) {
    $talismanOfRecompenseIndex = GetItemIndex("EVR191", $currentPlayer);
    if ($talismanOfRecompenseIndex > -1) {
      WriteLog("Talisman of Recompense gained 3 instead of 1 and destroyed itself.");
      DestroyItemForPlayer($currentPlayer, $talismanOfRecompenseIndex);
      GainResources($currentPlayer, 2);
    }
    if (SearchCharacterActive($currentPlayer, "UPR001") || SearchCharacterActive($currentPlayer, "UPR002") || SearchCurrentTurnEffects("UPR001-SHIYANA", $currentPlayer) || SearchCurrentTurnEffects("UPR002-SHIYANA", $currentPlayer)) {
      WriteLog("Dromai creates an Ash.");
      PutPermanentIntoPlay($currentPlayer, "UPR043");
    }
  }
  switch ($cardID) {
    case "WTR000":
      AddLayer("TRIGGER", $currentPlayer, $cardID);
      break;
    case "ARC000":
      AddLayer("TRIGGER", $currentPlayer, $cardID);
      break;
    case "CRU000":
      AddLayer("TRIGGER", $currentPlayer, $cardID);
      break;
    case "EVR000":
      WriteLog(CardLink($cardID, $cardID). " created a Seismic Surge.");
      PlayAura("WTR075", $currentPlayer);
      break;
    case "UPR000":
      WriteLog(CardLink($cardID, $cardID) . " makes the next 3 draconic cards you play cost 1 less this turn.");
      AddCurrentTurnEffect($cardID, $currentPlayer);
      break;
    default:
      break;
  }
}

function RemoveEffectsOnChainClose()
{
  global $currentTurnEffects;
  for ($i = count($currentTurnEffects) - CurrentTurnPieces(); $i >= 0; $i -= CurrentTurnPieces()) {
    $remove = 0;
    switch ($currentTurnEffects[$i]) {
      case "MON245":
        $remove = 1;
        break;
      case "ELE067":
      case "ELE068":
      case "ELE069":
        $remove = 1;
        break;
      case "ELE186":
      case "ELE187":
      case "ELE188":
        $remove = 1;
        break;
      case "UPR049":
        $remove = 1;
      default:
        break;
    }
    if ($remove == 1) RemoveCurrentTurnEffect($i);
  }
}

function OnAttackEffects($attack)
{
  global $currentTurnEffects, $mainPlayer, $defPlayer;
  $attackType = CardType($attack);
  for ($i = count($currentTurnEffects) - CurrentTurnPieces(); $i >= 0; $i -= CurrentTurnPieces()) {
    $remove = 0;
    if ($currentTurnEffects[$i + 1] == $mainPlayer) {
      switch ($currentTurnEffects[$i]) {
        case "ELE085":
        case "ELE086":
        case "ELE087":
          if ($attackType == "AA") {
            DealArcane(1, 0, "PLAYCARD", $attack, true);
            $remove = 1;
          }
          break;
        case "ELE092-DOM":
          AddDecisionQueue("FLASHFREEZEDOMINATE", $mainPlayer, $currentTurnEffects[$i] . "ATK", 1);
          AddDecisionQueue("SETDQCONTEXT", $defPlayer, "Choose to pay 2 to remove dominate from this attack", 1);
          AddDecisionQueue("BUTTONINPUT", $defPlayer, "0,2", 0, 1);
          AddDecisionQueue("PAYRESOURCES", $defPlayer, "<-", 1);
          AddDecisionQueue("LESSTHANPASS", $defPlayer, "2", 1);
          AddDecisionQueue("REMOVECURRENTEFFECT", $mainPlayer, $currentTurnEffects[$i] . "ATK", 1);
          break;
        default:
          break;
      }
    }
    if ($remove == 1) RemoveCurrentTurnEffect($i);
  }
}

function OnBlockResolveEffects()
{
  global $combatChain, $CS_DamageTaken, $defPlayer, $mainPlayer;
  //This is when blocking fully resolves, so everything on the chain from here is a blocking card except the first
  for ($i = CombatChainPieces(); $i < count($combatChain); $i += CombatChainPieces()) {
    if (SearchCurrentTurnEffects("ARC160-1", $defPlayer) && CardType($combatChain[$i]) == "AA") CombatChainPowerModifier($i, 1);
    if (SearchAurasForCard("ELE117", $defPlayer) && CardType($combatChain[$i]) == "AA") CombatChainPowerModifier($i, 3);
    ProcessPhantasmOnBlock($i); // Phantasm should trigger first until we can re-order triggers
  }
  switch ($combatChain[0]) {
    case "CRU051": case "CRU052":
      AddLayer("TRIGGER", $mainPlayer, $combatChain[0]);
      break;
    case "ELE004":
      if (SearchCurrentTurnEffects($combatChain[0], $defPlayer)) {
        AddLayer("TRIGGER", $defPlayer, $combatChain[0]);
      }
      break;
  }
  for ($i = CombatChainPieces(); $i < count($combatChain); $i += CombatChainPieces()) {
    switch ($combatChain[$i]) {
      case "EVR018":
        if (!IsAllyAttacking()) {
          WriteLog(CardLink($combatChain[$i], $combatChain[$i]) . " trigger creates a layer.");
          AddLayer("TRIGGER", $mainPlayer, $combatChain[$i]);
        }
        break;
      case "MON241": case "MON242": case "MON243":
      case "MON244": case "RVD005": case "RVD006": // Pay 1 -> Get 2 Defense
        AddLayer("TRIGGER", $defPlayer, $combatChain[$i], $i);
        break;
      case "ELE203": // Rampart of the Ram's Head
        AddLayer("TRIGGER", $defPlayer, $combatChain[$i], $i);
        break;
      case "MON089": // Phantasmal Footsteps
        AddLayer("TRIGGER", $defPlayer, $combatChain[$i], $i);
        break;
      case "UPR191": case "UPR192": case "UPR193": // Flex
        AddLayer("TRIGGER", $defPlayer, $combatChain[$i], $i);
        break;
      case "UPR194": case "UPR195": case "UPR196":
        AddLayer("TRIGGER", $defPlayer, $combatChain[$i], $i);
        break;
      case "RVD015":
        AddLayer("TRIGGER", $defPlayer, $combatChain[$i]);
        break;
      case "UPR095":
        AddLayer("TRIGGER", $defPlayer, $combatChain[$i]);
        break;
      case "UPR182":
        AddLayer("TRIGGER", $defPlayer, $combatChain[$i]);
        break;
      case "UPR203": case "UPR204": case "UPR205":
        AddLayer("TRIGGER", $defPlayer, $combatChain[$i], $i);
        break;
      case "DYN152":
        AddLayer("TRIGGER", $defPlayer, $combatChain[$i]);
        break;
      default:
        break;
    }
  }
}

function OnBlockEffects($index, $from)
{
  global $currentTurnEffects, $combatChain, $currentPlayer, $combatChainState, $CCS_WeaponIndex, $mainPlayer;
  $cardType = CardType($combatChain[$index]);
  $otherPlayer = ($currentPlayer == 1 ? 2 : 1);
  for ($i = count($currentTurnEffects) - CurrentTurnPieces(); $i >= 0; $i -= CurrentTurnPieces()) {
    $remove = 0;
    if ($currentTurnEffects[$i + 1] == $currentPlayer) {
      switch ($currentTurnEffects[$i]) {
        case "WTR092": case "WTR093": case "WTR094":
          if (HasCombo($combatChain[$index])) {
            $combatChain[$index + 6] += 2;
          }
          $remove = 1;
          break;
        case "ELE004":
          if ($cardType == "DR") {
            PlayAura("ELE111", $currentPlayer);
          }
          break;
        case "DYN042": case "DYN043": case "DYN044":
          if(ClassContains($combatChain[$index], "GUARDIAN", $currentPlayer) && CardSubType($combatChain[$index]) == "Off-Hand")
          {
            if($currentTurnEffects[$i] == "DYN042") $amount = 6;
            else if($currentTurnEffects[$i] == "DYN043") $amount = 5;
            else $amount = 4;
            $combatChain[$index + 6] += $amount;
            $remove = 1;
          }
          break;
        default:
          break;
      }
    } else if ($currentTurnEffects[$i + 1] == $otherPlayer) {
      switch ($currentTurnEffects[$i]) {
        case "MON113": case "MON114": case "MON115":
          $numbPlow = 0;
          for ($j = count($currentTurnEffects) - CurrentTurnPieces(); $j >= 0; $j -= CurrentTurnPieces()) {
            if ($currentTurnEffects[$j] == $currentTurnEffects[$i]) {
              ++$numbPlow;
            }
          }
          if ($cardType == "AA" && IsCombatEffectActive($currentTurnEffects[$i])) {
            $first = true;
            if (SearchCharacterEffects($otherPlayer, $combatChainState[$CCS_WeaponIndex], $currentTurnEffects[$i])) {
              $first = false;
            }
            if ($first) {
              for ($k = 0; $k < $numbPlow; $k++) {
                AddCharacterEffect($otherPlayer, $combatChainState[$CCS_WeaponIndex], $currentTurnEffects[$i]);
                WriteLog(CardLink($currentTurnEffects[$i], $currentTurnEffects[$i]) . " gives you weapon +1 for the rest of the turn.");
              }
            }
          }
          break;
        default:
          break;
      }
    }
    if ($remove == 1) RemoveCurrentTurnEffect($i);
  }
  $currentTurnEffects = array_values($currentTurnEffects);
  switch ($combatChain[0]) {
    case "CRU079": case "CRU080":
      if ($cardType == "AA") {
        $first = true;
        for ($i = 0; $i < $index; $i += CombatChainPieces()) {
          if ($combatChain[$i + 1] == $currentPlayer && CardType($combatChain[$i]) == "AA") $first = false;
        }
        if ($first) {
          AddCharacterEffect($otherPlayer, $combatChainState[$CCS_WeaponIndex], $combatChain[0]);
          WriteLog(CardLink($combatChain[0], $combatChain[0]) . " got +1 for the rest of the turn.");
        }
      }
      break;
    default:
      break;
  }
  $mainCharacter = &GetPlayerCharacter($mainPlayer);
  for ($i = 0; $i < count($mainCharacter); $i += CharacterPieces()) {
    if ($mainCharacter[$i + 1] != 2) continue;
    switch ($mainCharacter[$i]) {
      case "ELE174":
        if ($from == "HAND" && IsCharacterActive($mainPlayer, $i)) {
          if (TalentContains($combatChain[0], "LIGHTNING", $mainPlayer) || TalentContains($combatChain[0], "ELEMENTAL", $mainPlayer)) {
            AddLayer("TRIGGER", $mainPlayer, $mainCharacter[$i]);
          }
        }
      default:
        break;
    }
  }
}

function ActivateAbilityEffects()
{
  global $currentPlayer, $currentTurnEffects;
  for ($i = count($currentTurnEffects) - CurrentTurnPieces(); $i >= 0; $i -= CurrentTurnPieces()) {
    $remove = 0;
    if ($currentTurnEffects[$i + 1] == $currentPlayer) {
      switch ($currentTurnEffects[$i]) {
        case "ELE004-HIT":
          WriteLog(CardLink("ELE004", "ELE004") . " creates a frostbite.");
          PlayAura("ELE111", $currentPlayer);
          break;
        default:
          break;
      }
    }
    if ($remove == 1) RemoveCurrentTurnEffect($i);
  }
  $currentTurnEffects = array_values($currentTurnEffects);
}

function CountPitch(&$pitch, $min = 0, $max = 9999)
{
  $pitchCount = 0;
  for ($i = 0; $i < count($pitch); ++$i) {
    $cost = CardCost($pitch[$i]);
    if ($cost >= $min && $cost <= $max) ++$pitchCount;
  }
  return $pitchCount;
}

function Draw($player, $mainPhase = true)
{
  global $CS_EffectContext, $mainPlayer;
  $otherPlayer = ($player == 1 ? 2 : 1);
  if ($mainPhase && $player != $mainPlayer) {
    $talismanOfTithes = SearchItemsForCard("EVR192", $otherPlayer);
    if ($talismanOfTithes != "") {
      $indices = explode(",", $talismanOfTithes);
      DestroyItemForPlayer($otherPlayer, $indices[0]);
      WriteLog(CardLink("EVR192", "EVR192") . " prevented a draw and was destroyed.");
      return "";
    }
  }
  if ($mainPhase && (SearchAurasForCard("UPR138", $otherPlayer) != "" || SearchAurasForCard("UPR138", $player) != "")) {
    WriteLog("Draw prevented by " . CardLink("UPR138", "UPR138"));
    return "";
  }
  $deck = &GetDeck($player);
  $hand = &GetHand($player);
  if (count($deck) == 0) return -1;
  if (CurrentEffectPreventsDraw($player, $mainPhase)) return -1;
  array_push($hand, array_shift($deck));
  WriteReplay($player, "Hide", "DECK", "HAND");
  if ($mainPhase && (SearchCharacterActive($otherPlayer, "EVR019") || (SearchCurrentTurnEffects("EVR019-SHIYANA", $otherPlayer) && SearchCharacterActive($otherPlayer, "CRU097")))) PlayAura("WTR075", $otherPlayer);
  if (SearchCharacterActive($player, "EVR020")) {
    //Check if it was played by the player with Eartlore Bounty
    $context = GetClassState($player, $CS_EffectContext);
    //Otherwise it gets the cardID (context) from the other player.
    if ($context == "-") $context = GetClassState($otherPlayer, $CS_EffectContext);
    if ($context != "-") {
      $cardType = CardType($context);
      if ($cardType == "A" || $cardType == "AA") PlayAura("WTR075", $player);
    }
  }
  if ($mainPhase && SearchCurrentTurnEffects("DYN196", $player)) {
    $character = &GetPlayerCharacter($player);
    DealArcane(1, 2, "TRIGGER", $character[0]);
  }
  return $hand[count($hand) - 1];
}

function MyDrawCard()
{
  global $currentPlayer;
  Draw($currentPlayer);
}

function TheirDrawCard()
{
  global $currentPlayer;
  Draw(($currentPlayer == 1 ? 2 : 1));
}

function MainDrawCard()
{
  global $mainPlayer;
  Draw($mainPlayer);
}

function CombatChainCloseAbilities($player, $cardID, $chainLink)
{
  global $chainLinkSummary, $mainPlayer;
  switch ($cardID) {
    case "UPR189":
      if ($chainLinkSummary[$chainLink * ChainLinkSummaryPieces() + 1] <= 2) {
        Draw($player);
        WriteLog(CardLink($cardID, $cardID) . " draw a card.");
      }
      break;
    case "DYN121":
      if ($player == $mainPlayer) {
        PlayerLoseHealth($mainPlayer, GetHealth($mainPlayer));
      }
      break;
    default:
      break;
  }
}

function NumNonEquipmentDefended()
{
  global $combatChain, $defPlayer;
  $number = 0;
  for ($i = 0; $i < count($combatChain); $i += CombatChainPieces()) {
    $cardType = CardType($combatChain[$i]);
    if ($combatChain[$i + 1] == $defPlayer && $cardType != "E" && $cardType != "C") ++$number;
  }
  return $number;
}

function CharacterDestroyEffect($cardID, $player)
{
  switch ($cardID) {
    case "ELE213":
      DestroyArsenal($player);
      break;
    case "DYN214":
      PlayAura("MON104", $player);
      break;
    default:
      break;
  }
}

function MainCharacterEndTurnAbilities()
{
  global $mainClassState, $CS_HitsWDawnblade, $CS_AtksWWeapon, $mainPlayer, $defPlayer, $CS_NumNonAttackCards;
  global $CS_NumAttackCards, $defCharacter, $CS_ArcaneDamageDealt;

  $mainCharacter = &GetPlayerCharacter($mainPlayer);
  for ($i = 0; $i < count($mainCharacter); $i += CharacterPieces()) {
    $characterID = $mainCharacter[$i];
    if($i == 0 && $mainCharacter[$i] == "CRU097")
    {
      $otherCharacter = &GetPlayerCharacter($defPlayer);
      if (SearchCurrentTurnEffects($otherCharacter[0] . "-SHIYANA", $mainPlayer)) {
        $characterID = $otherCharacter[0];
      }
    }
    switch ($characterID) {
      case "WTR115":
        if (GetClassState($mainPlayer, $CS_HitsWDawnblade) == 0) $mainCharacter[$i + 3] = 0;
        break;
      case "CRU077":
        KassaiEndTurnAbility();
        break;
      case "MON089":
        $mainCharacter[$i + 4] = 0;
      case "MON107":
        if ($mainClassState[$CS_AtksWWeapon] >= 2 && $mainCharacter[$i + 4] < 0) ++$mainCharacter[$i + 4];
        break;
      case "ELE203":
        $mainCharacter[$i + 4] = 0;
        break;
      case "ELE223":
        if (GetClassState($mainPlayer, $CS_NumNonAttackCards) == 0 || GetClassState($mainPlayer, $CS_NumAttackCards) == 0) $mainCharacter[$i + 3] = 0;
        break;
      case "ELE224":
        if (GetClassState($mainPlayer, $CS_ArcaneDamageDealt) < $mainCharacter[$i + 2]) {
          DestroyCharacter($mainPlayer, $i);
          $mainCharacter[$i + 2] = 0;
        }
        break;
      default:
        break;
    }
  }
  for ($i = 0; $i < count($defCharacter); $i += CharacterPieces()) {
    switch ($defCharacter[$i]) {
      case "MON089":
        $defCharacter[$i + 4] = 0;
        break;
      case "ELE203":
        $defCharacter[$i + 4] = 0;
        break;
      default:
        break;
    }
  }
}

function MainCharacterHitAbilities()
{
  global $combatChain, $combatChainState, $CCS_WeaponIndex, $CCS_HitsInRow, $mainPlayer;
  $attackID = $combatChain[0];
  $mainCharacter = &GetPlayerCharacter($mainPlayer);

  for ($i = 0; $i < count($mainCharacter); $i += CharacterPieces()) {
    if (CardType($mainCharacter[$i]) == "W" || $mainCharacter[$i + 1] != "2") continue;
    $characterID = $mainCharacter[$i];
    if($i == 0 && $mainCharacter[0] == "CRU097") {
      $otherPlayer = ($mainPlayer == 1 ? 2 : 1);
      $otherCharacter = &GetPlayerCharacter($otherPlayer);
      if (SearchCurrentTurnEffects($otherCharacter[0] . "-SHIYANA", $mainPlayer)) {
        $characterID = $otherCharacter[0];
      }
    }
    switch ($characterID) {
      case "WTR076":
      case "WTR077":
        if (CardType($attackID) == "AA") {
          AddLayer("TRIGGER", $mainPlayer, $characterID);
          $mainCharacter[$i + 1] = 1;
        }
        break;
      case "WTR079":
        if (CardType($attackID) == "AA" && $combatChainState[$CCS_HitsInRow] >= 3) {
          AddLayer("TRIGGER", $mainPlayer, $characterID);
          $mainCharacter[$i + 1] = 1;
        }
        break;
      case "WTR113":
      case "WTR114":
        if ($mainCharacter[$i + 1] == 2 && CardType($attackID) == "W" && $mainCharacter[$combatChainState[$CCS_WeaponIndex] + 1] != 0) {
          $mainCharacter[$i + 1] = 1;
          $mainCharacter[$combatChainState[$CCS_WeaponIndex] + 1] = 2;
          ++$mainCharacter[$combatChainState[$CCS_WeaponIndex] + 5];
        }
        break;
      case "WTR117":
        if (CardType($attackID) == "W" && IsCharacterActive($mainPlayer, $i)) {
          AddLayer("TRIGGER", $mainPlayer, $characterID);
        }
        break;
      case "ARC152":
        if (CardType($attackID) == "AA" && IsCharacterActive($mainPlayer, $i)) {
          AddLayer("TRIGGER", $mainPlayer, $characterID);
        }
        break;
      case "CRU047":
        if (CardType($attackID) == "AA" && $mainCharacter[$i+5] == 1) {
          AddCurrentTurnEffectFromCombat("CRU047", $mainPlayer);
          $mainCharacter[$i+5] = 0;
        }
        break;
      case "CRU053":
        if (CardType($attackID) == "AA" && ClassContains($attackID, "NINJA", $mainPlayer) && IsCharacterActive($mainPlayer, $i)) {
          AddLayer("TRIGGER", $mainPlayer, $characterID);
        }
        break;
      case "ELE062": case "ELE063":
        if (IsHeroAttackTarget() && CardType($attackID) == "AA" && !SearchAuras("ELE109", $mainPlayer)) {
          PlayAura("ELE109", $mainPlayer);
        }
        break;
      case "EVR037":
        if (CardType($attackID) == "AA" && IsCharacterActive($mainPlayer, $i)) {
          AddLayer("TRIGGER", $mainPlayer, $characterID);
        }
        break;
      default:
        break;
    }
  }
}

function MainCharacterAttackModifiers($index = -1, $onlyBuffs = false)
{
  global $combatChainState, $CCS_WeaponIndex, $mainPlayer, $CS_NumAttacks;
  $modifier = 0;
  $mainCharacterEffects = &GetMainCharacterEffects($mainPlayer);
  $mainCharacter = &GetPlayerCharacter($mainPlayer);
  if ($index == -1) $index = $combatChainState[$CCS_WeaponIndex];
  for ($i = 0; $i < count($mainCharacterEffects); $i += CharacterEffectPieces()) {
    if ($mainCharacterEffects[$i] == $index) {
      switch ($mainCharacterEffects[$i + 1]) {
        case "WTR119":
          $modifier += 2;
          break;
        case "WTR122":
          $modifier += 1;
          break;
        case "WTR135":
        case "WTR136":
        case "WTR137":
          $modifier += 1;
          break;
        case "CRU079":
        case "CRU080":
          $modifier += 1;
          break;
        case "MON105":
        case "MON106":
          $modifier += 1;
          break;
        case "MON113":
        case "MON114":
        case "MON115":
          $modifier += 1;
          break;
        case "EVR055-1":
          $modifier += 1;
          break;
        default:
          break;
      }
    }
  }
  if ($onlyBuffs) return $modifier;

  $mainCharacter = &GetPlayerCharacter($mainPlayer);
  for ($i = 0; $i < count($mainCharacter); $i += CharacterPieces()) {
    if (!IsEquipUsable($mainPlayer, $i)) continue;
    $characterID = $mainCharacter[$i];
    if($i == 0 && $mainCharacter[0] == "CRU097")
    {
      $otherPlayer = ($mainPlayer == 1 ? 2 : 1);
      $otherCharacter = &GetPlayerCharacter($otherPlayer);
      if (SearchCurrentTurnEffects($otherCharacter[0] . "-SHIYANA", $mainPlayer)) {
        $characterID = $otherCharacter[0];
      }
    }
    switch ($characterID) {
      case "MON029":
      case "MON030":
        if (HaveCharged($mainPlayer) && NumAttacksBlocking() > 0) {
          $modifier += 1;
        }
        break;
      default:
        break;
    }
  }
  return $modifier;
}

function MainCharacterHitEffects()
{
  global $combatChainState, $CCS_WeaponIndex, $mainPlayer;
  $modifier = 0;
  $mainCharacterEffects = &GetMainCharacterEffects($mainPlayer);
  for ($i = 0; $i < count($mainCharacterEffects); $i += 2) {
    if ($mainCharacterEffects[$i] == $combatChainState[$CCS_WeaponIndex]) {
      switch ($mainCharacterEffects[$i + 1]) {
        case "WTR119":
          MainDrawCard();
          break;
        default:
          break;
      }
    }
  }
  return $modifier;
}

function MainCharacterGrantsGoAgain()
{
  global $combatChainState, $CCS_WeaponIndex, $mainPlayer;
  if ($combatChainState[$CCS_WeaponIndex] == -1) return false;
  $mainCharacterEffects = &GetMainCharacterEffects($mainPlayer);
  for ($i = 0; $i < count($mainCharacterEffects); $i += 2) {
    if ($mainCharacterEffects[$i] == $combatChainState[$CCS_WeaponIndex]) {
      switch ($mainCharacterEffects[$i + 1]) {
        case "EVR055-2":
          return true;
        default:
          break;
      }
    }
  }
  return false;
}

function CombatChainPlayAbility($cardID)
{
  global $combatChain, $defPlayer;
  for ($i = 0; $i < count($combatChain); $i += CombatChainPieces()) {
    switch ($combatChain[$i]) {
      case "EVR122":
        if (ClassContains($cardID, "WIZARD", $defPlayer)) {
          $combatChain[$i + 6] += 2;
          WriteLog(CardLink($combatChain[$i], $combatChain[$i]) . " gets +2 defense.");
        }
        break;
      default:
        break;
    }
  }
}

function PutCharacterIntoPlayForPlayer($cardID, $player)
{
  $char = &GetPlayerCharacter($player);
  $index = count($char);
  array_push($char, $cardID); //0 - Card ID
  array_push($char, 2); //1 - Status (2=ready, 1=unavailable, 0=destroyed)
  array_push($char, CharacterCounters($cardID)); //2 - Num counters
  array_push($char, 0); //3 - Num attack counters
  array_push($char, 0); //4 - Num defense counters
  array_push($char, 1); //5 - Num uses
  array_push($char, 0); //6 - On chain (1 = yes, 0 = no)
  array_push($char, 0); //7 - Flagged for destruction (1 = yes, 0 = no)
  array_push($char, 0); //8 - Frozen (1 = yes, 0 = no)
  array_push($char, 2); //9 - Is Active (2 = always active, 1 = yes, 0 = no)
  return $index;
}

function CharacterCounters ($cardID)
{
  switch ($cardID) {
    case "DYN492a":
      return 8;
    default:
      return 0;
  }
}

function PutItemIntoPlay($item, $steamCounterModifier = 0)
{
  global $currentPlayer;
  PutItemIntoPlayForPlayer($item, $currentPlayer, $steamCounterModifier);
}

function PutItemIntoPlayForPlayer($item, $player, $steamCounterModifier = 0, $number = 1)
{
  $otherPlayer = ($player == 1 ? 2 : 1);
  if (CardSubType($item) != "Item") return;
  $items = &GetItems($player);
  $myHoldState = ItemDefaultHoldTriggerState($item);
  if ($myHoldState == 0 && HoldPrioritySetting($player) == 1) $myHoldState = 1;
  $theirHoldState = ItemDefaultHoldTriggerState($item);
  if ($theirHoldState == 0 && HoldPrioritySetting($otherPlayer) == 1) $theirHoldState = 1;
  for ($i = 0; $i < $number; ++$i) {
    $uniqueID = GetUniqueId();
    $steamCounters = SteamCounterLogic($item, $player, $uniqueID) + $steamCounterModifier;
    array_push($items, $item); //Card ID
    array_push($items, $steamCounters); //Counters
    array_push($items, 2); //Status
    array_push($items, ItemUses($item)); //Num Uses
    array_push($items, $uniqueID); //Unique ID
    array_push($items, $myHoldState); //My Hold priority for triggers setting 2=Always hold, 1=Hold, 0=Don't hold
    array_push($items, $theirHoldState); //Opponent Hold priority for triggers setting 2=Always hold, 1=Hold, 0=Don't hold
  }
}

function ItemUses($cardID)
{
  switch ($cardID) {
    case "EVR070":
      return 3;
    default:
      return 1;
  }
}

function SteamCounterLogic($item, $playerID, $uniqueID)
{
  global $CS_NumBoosted;
  $counters = ETASteamCounters($item);
  switch ($item) {
    case "CRU104":
      $counters += GetClassState($playerID, $CS_NumBoosted);
      break;
    default:
      break;
  }
  if(ClassContains($item, "MECHANOLOGIST", $playerID))
  {
    $items = &GetItems($playerID);
    for($i=count($items)-ItemPieces(); $i>=0; $i-=ItemPieces())
    {
      if($items[$i] == "DYN093")
      {
        AddLayer("TRIGGER", $playerID, $items[$i], $uniqueID, "-", $items[$i + 4]);
      }
    }
  }
  return $counters;
}

function IsDominateActive()
{
  global $currentTurnEffects, $mainPlayer, $CCS_WeaponIndex, $combatChain, $combatChainState;
  global $CS_NumAuras, $CCS_NumBoosted, $chainLinks, $chainLinkSummary;
  if (count($combatChain) == 0) return false;
  if (SearchCurrentTurnEffectsForCycle("EVR097", "EVR098", "EVR099", $mainPlayer)) return false;
  $characterEffects = GetCharacterEffects($mainPlayer);
  for ($i = 0; $i < count($currentTurnEffects); $i += CurrentTurnEffectPieces()) {
    if ($currentTurnEffects[$i + 1] == $mainPlayer && IsCombatEffectActive($currentTurnEffects[$i]) && !IsCombatEffectLimited($i) && DoesEffectGrantDominate($currentTurnEffects[$i])) return true;
  }
  for ($i = 0; $i < count($characterEffects); $i += CharacterEffectPieces()) {
    if ($characterEffects[$i] == $combatChainState[$CCS_WeaponIndex]) {
      switch ($characterEffects[$i + 1]) {
        case "WTR122":
          return true;
        default:
          break;
      }
    }
  }
  switch ($combatChain[0]) {
    case "WTR095": case "WTR096": case "WTR097": return (ComboActive() ? true : false);
    case "WTR179": case "WTR180": case "WTR181": return true;
    case "ARC080": return true;
    case "MON004": return true;
    case "MON023": case "MON024": case "MON025": return true;
    case "MON246": return SearchDiscard($mainPlayer, "AA") == "";
    case "MON275": case "MON276": case "MON277": return true;
    case "ELE209": case "ELE210": case "ELE211": return HasIncreasedAttack();
    case "EVR027": case "EVR028": case "EVR029": return true;
    case "EVR038": return (ComboActive() ? true : false);
    case "EVR076": case "EVR077": case "EVR078": return $combatChainState[$CCS_NumBoosted] > 0;
    case "EVR110": case "EVR111": case "EVR112": return GetClassState($mainPlayer, $CS_NumAuras) > 0;
    case "EVR138":
      $hasDominate = false;
      for ($i = 0; $i < count($chainLinks); ++$i)
      {
        for ($j = 0; $j < count($chainLinks[$i]); $j += ChainLinksPieces())
        {
          $isIllusionist = ClassContains($chainLinks[$i][$j], "ILLUSIONIST", $mainPlayer) || ($j == 0 && DelimStringContains($chainLinkSummary[$i * ChainLinkSummaryPieces() + 3], "ILLUSIONIST"));
          if ($chainLinks[$i][$j + 2] == "1" && $chainLinks[$i][$j] != "EVR138" && $isIllusionist && CardType($chainLinks[$i][$j]) == "AA")
          {
              if (!$hasDominate) $hasDominate = HasDominate($chainLinks[$i][$j]);
            }
          }
        }
      return $hasDominate;
    default:
      break;
  }
  return false;
}

function HasDominate ($cardID)
{
  global $mainPlayer, $combatChainState;
  global $CS_NumAuras, $CCS_NumBoosted;
  switch ($cardID)
  {
    case "WTR095": case "WTR096": case "WTR097": return (ComboActive() ? true : false);
    case "WTR179": case "WTR180": case "WTR181": return true;
    case "ARC080": return true;
    case "MON004": return true;
    case "MON023": case "MON024": case "MON025": return true;
    case "MON246": return SearchDiscard($mainPlayer, "AA") == "";
    case "MON275": case "MON276": case "MON277": return true;
    case "ELE209": case "ELE210": case "ELE211": return HasIncreasedAttack();
    case "EVR027": case "EVR028": case "EVR029": return true;
    case "EVR038": return (ComboActive() ? true : false);
    case "EVR076": case "EVR077": case "EVR078": return $combatChainState[$CCS_NumBoosted] > 0;
    case "EVR110": case "EVR111": case "EVR112": return GetClassState($mainPlayer, $CS_NumAuras) > 0;
    default: break;
  }
  return false;
}

function isOverpowerActive()
{
  global $combatChain, $mainPlayer;
  if (count($combatChain) == 0) return false;
  switch ($combatChain[0]) {
    case "DYN068": return SearchCurrentTurnEffects("DYN068", $mainPlayer);
    case "DYN088": return true;
    case "DYN227": case "DYN228": case "DYN229": SearchCurrentTurnEffects("DYN227", $mainPlayer);
    case "DYN492a": return true;
    default:
      break;
  }
  return false;
}

function HasOverpower ($cardID)
{
  switch ($cardID) {
    case "DYN068": return true;
    case "DYN088": return true;
    case "DYN492a": return true;
    default: break;
  }
  return false;
}

function EquipPayAdditionalCosts($cardIndex, $from)
{
  global $currentPlayer;
  $character = &GetPlayerCharacter($currentPlayer);
  $cardID = $character[$cardIndex];
  if ($cardID == "CRU097") {
    $otherPlayer = ($currentPlayer == 1 ? 2 : 1);
    $otherCharacter = &GetPlayerCharacter($otherPlayer);
    if (SearchCurrentTurnEffects($otherCharacter[0] . "-SHIYANA", $currentPlayer)) {
      $cardID = $otherCharacter[$cardIndex];
    }
  }
  switch ($cardID) {
    case "WTR005":
      DestroyCharacter($currentPlayer, $cardIndex);
      break;
    case "WTR042":
      DestroyCharacter($currentPlayer, $cardIndex);
      break;
    case "WTR080":
      DestroyCharacter($currentPlayer, $cardIndex);
      break;
    case "WTR150":
      $character[$cardIndex + 2] -= 3;
      break;
    case "WTR151":
    case "WTR152":
    case "WTR153":
    case "WTR154":
      DestroyCharacter($currentPlayer, $cardIndex);
      break;
    case "ARC003":
      $character[$cardIndex + 1] = 2;
      break;
    case "ARC005":
    case "ARC042":
    case "ARC079":
    case "ARC116":
    case "ARC117":
    case "ARC151":
    case "ARC153":
    case "ARC154":
      DestroyCharacter($currentPlayer, $cardIndex);
      break;
    case "ARC113":
    case "ARC114":
    case "WTR037":
    case "WTR038":
      $character[$cardIndex + 1] = 2;
      break;
    case "CRU006":
    case "CRU025":
    case "CRU081":
    case "CRU102":
    case "CRU122":
    case "CRU141":
      DestroyCharacter($currentPlayer, $cardIndex);
      break;
    case "CRU024":
      break; //No limits on use, so override default
    case "CRU101":
      /*
      if($character[$cardIndex+2] == 0) $character[$cardIndex+1] = 2;
      else
      {
        --$character[$cardIndex+5];
        if($character[$cardIndex+5] == 0) $character[$cardIndex+1] = 1;//By default, if it's used, set it to used
      }
      */
      break;
    case "CRU177":
      $character[$cardIndex + 1] = 1;
      ++$character[$cardIndex + 2];
      break;
    case "MON061":
    case "MON090":
    case "MON108":
    case "MON188":
    case "MON230":
    case "MON238":
    case "MON239":
    case "MON240":
    case "DVR005":
      DestroyCharacter($currentPlayer, $cardIndex);
      break;
    case "MON029":
    case "MON030":
      $character[$cardIndex + 1] = 2; //It's not limited to once
      break;
    case "ELE116":
    case "ELE145":
    case "ELE214":
    case "ELE225":
    case "ELE233":
    case "ELE234":
    case "ELE235":
    case "ELE236":
      DestroyCharacter($currentPlayer, $cardIndex);
      break;
    case "ELE173":
      break; //Unlimited uses, explicitly don't use default
    case "ELE224":
      ++$character[$cardIndex + 2];
      --$character[$cardIndex + 5];
      if ($character[$cardIndex + 5] == 0) $character[$cardIndex + 1] = 1;
      break;
    case "EVR053":
    case "EVR103":
    case "EVR137":
      DestroyCharacter($currentPlayer, $cardIndex);
      break;
    case "DVR004":
    case "RVD004":
      DestroyCharacter($currentPlayer, $cardIndex);
      break;
    case "UPR004":
    case "UPR047":
    case "UPR085":
    case "UPR125":
    case "UPR137":
    case "UPR159":
    case "UPR167":
      DestroyCharacter($currentPlayer, $cardIndex);
      break;
    case "UPR151":
      $character[$cardIndex + 2] -= 1;
      --$character[$cardIndex + 5];
      if ($character[$cardIndex + 5] == 0) $character[$cardIndex + 1] = 1;
      break;
    case "UPR166":
      $character[$cardIndex + 2] -= 2;
      break;
    case "DYN088":
      $character[$cardIndex + 2] -= 2;
      break;
    case "DYN117":
      DestroyCharacter($currentPlayer, $cardIndex);
      break;
    case "DYN118":
      DestroyCharacter($currentPlayer, $cardIndex);
      break;
    case "DYN235":
      DestroyCharacter($currentPlayer, $cardIndex);
      break;
    case "DYN492a":
      --$character[$cardIndex + 2];
      WriteLog(CardLink($cardID, $cardID) . " banished a card from under itself.");
      BanishCardForPlayer("DYN492a", $currentPlayer, "-"); // TODO: Temporary until we can actually banish the cards that were put under
      break;
    default:
      --$character[$cardIndex + 5];
      if ($character[$cardIndex + 5] == 0) $character[$cardIndex + 1] = 1; //By default, if it's used, set it to used
      break;
  }
}

function DecisionQueueStaticEffect($phase, $player, $parameter, $lastResult)
{
  global $redirectPath, $playerID, $gameName;
  global $currentPlayer, $combatChain, $defPlayer;
  global $combatChainState, $CCS_CurrentAttackGainedGoAgain, $actionPoints, $CCS_ChainAttackBuff;
  global $defCharacter, $CS_NumCharged, $otherPlayer, $CCS_ChainLinkHitEffectsPrevented;
  global $CS_NumFusedEarth, $CS_NumFusedIce, $CS_NumFusedLightning, $CS_NextNAACardGoAgain, $CCS_AttackTarget;
  global $CS_LayerTarget, $dqVars, $mainPlayer, $lastPlayed, $CS_EffectContext, $dqState, $CS_AbilityIndex, $CS_CharacterIndex;
  global $CS_AdditionalCosts, $CS_AlluvionUsed, $CS_MaxQuellUsed, $CS_DamageDealt, $CS_ArcaneTargetsSelected, $inGameStatus;
  global $CS_ArcaneDamageDealt, $MakeStartTurnBackup, $CCS_AttackTargetUID, $chainLinkSummary, $chainLinks;
  $rv = "";
  switch ($phase) {
    case "FINDRESOURCECOST":
      switch ($parameter) {
        case "CRU126": case "CRU127": case "CRU128":
          return (($lastResult == "YES" || $lastResult == "PAY") ? 1 : 0);
        case "ELE148": case "ELE149": case "ELE150":
          return (($lastResult == "YES" || $lastResult == "PAY") ? 2 : 0);
        default:
          return (($lastResult == "YES" || $lastResult == "PAY") ? $parameter : 0);
      }
      return 0;
    case "FINDINDICES":
      UpdateGameState($currentPlayer);
      BuildMainPlayerGamestate();
      $parameters = explode(",", $parameter);
      $parameter = $parameters[0];
      if (count($parameters) > 1) $subparam = $parameters[1];
      else $subparam = "";
      switch ($parameter) {
        case "ARCANETARGET":
          $rv = GetArcaneTargetIndices($player, $subparam);
          break;
        case "WTR083":
          $rv = SearchDeckForCard($player, "WTR081");
          if ($rv != "") $rv = count(explode(",", $rv)) . "-" . $rv;
          break;
        case "WTR076-1":
          $rv = SearchHand($player, "", "", 0);
          break;
        case "WTR076-2":
          $rv = GetComboCards();
          break;
        case "WTR081":
          $rv = LordOfWindIndices($player);
          if ($rv != "") $rv = count(explode(",", $rv)) . "-" . $rv;
          break;
        case "ARC014":
          $rv = SearchHand($player, "", "Item", 2, -1, "MECHANOLOGIST");
          break;
        case "ARC015":
          $rv = SearchHand($player, "", "Item", 1, -1, "MECHANOLOGIST");
          break;
        case "ARC016":
          $rv = SearchHand($player, "", "Item", 0, -1, "MECHANOLOGIST");
          break;
        case "ARC079":
          $rv = CombineSearches(SearchDiscard($player, "AA", "", -1, -1, "RUNEBLADE"), SearchDiscard($player, "A", "", -1, -1, "RUNEBLADE"));
          break;
        case "ARC121":
          $rv = SearchDeck($player, "", "", $lastResult, -1, "WIZARD");
          break;
        case "ARC138":
        case "ARC139":
        case "ARC140":
          $rv = SearchHand($player, "A", "", $lastResult, -1, "WIZARD");
          break;
        case "ARC185":
        case "ARC186":
        case "ARC187":
          $rv = SearchDeckForCard($player, "ARC212", "ARC213", "ARC214");
          break;
        case "CRU026":
          $rv = SearchEquipNegCounter($defCharacter);
          break;
        case "CRU105":
          $rv = GetWeaponChoices("Pistol");
          break;
        case "CRU143":
          $rv = SearchDiscard($player, "AA", "", -1, -1, "RUNEBLADE");
          break;
        case "LAYER":
          $rv = SearchLayerDQ($player, $subparam);
          break;
        case "DECK":
          $rv = SearchDeck($player);
          break;
        case "TOPDECK":
          $deck = &GetDeck($player);
          if (count($deck) > 0) $rv = "0";
          break;
        case "DECKTOPX":
          $rv = "";
          $deck = &GetDeck($player);
          for ($i = 0; $i < $subparam; ++$i) if ($i < count($deck)) {
            if ($rv != "") $rv .= ",";
            $rv .= $i;
          }
          break;
        case "DECKCLASSAA":
          $rv = SearchDeck($player, "AA", "", -1, -1, $subparam);
          break;
        case "DECKCLASSNAA":
          $rv = SearchDeck($player, "A", "", -1, -1, $subparam);
          break;
        case "DECKSPEC":
          $rv = SearchDeck($player, "", "", -1, -1, "", "", false, false, -1, true);
          break;
        case "DECKCARD":
          $rv = SearchDeckForCard($player, $subparam);
          break;
        case "PERMSUBTYPE":
          if ($subparam == "Aura") $rv = SearchAura($player, "", $subparam);
          else $rv = SearchPermanents($player, "", $subparam);
          break;
        case "SEARCHMZ":
          $rv = SearchMZ($player, $subparam);
          break;
        case "MZSTARTTURN":
          $rv = MZStartTurnIndices();
          break;
        case "HAND":
          $rv = GetIndices(count(GetHand($player)));
          break;
        case "HANDTALENT":
          $rv = SearchHand($player, "", "", -1, -1, "", $subparam);
          break;
        case "HANDPITCH":
          $rv = SearchHand($player, "", "", -1, -1, "", "", false, false, $subparam);
          break;
        case "HANDACTION":
          $rv = CombineSearches(SearchHand($player, "A"), SearchHand($player, "AA"));
          break;
        case "HANDACTIONMAXCOST":
          $rv = CombineSearches(SearchHand($player, "A", "", $subparam), SearchHand($player, "AA", "", $subparam));
          break;
        case "MULTIHAND":
          $hand = &GetHand($player);
          $rv = count($hand) . "-" . GetIndices(count($hand));
          break;
        case "MULTIHANDAA":
          $search = SearchHand($player, "AA");
          $rv = SearchCount($search) . "-" . $search;
          break;
        case "ARSENAL":
          $arsenal = &GetArsenal($player);
          $rv = GetIndices(count($arsenal), 0, ArsenalPieces());
          break;
        case "ARSENALDOWN":
          $rv = GetArsenalFaceDownIndices($player);
          break;
        case "ARSENALUP":
          $rv = GetArsenalFaceUpIndices($player);
          break;
        case "ITEMS":
          $rv = GetIndices(count(GetItems($player)), 0, ItemPieces());
          break;
        case "ITEMSMAX":
          $rv = SearchItems($player, "", "", $subparam);
          break;
        case "DECKMECHITEMCOST":
          $rv = SearchDeck($player, "", "Item", $subparam, $subparam, "MECHANOLOGIST");
          break;
        case "EQUIP":
          $rv = GetEquipmentIndices($player);
          break;
        case "EQUIP0":
          $rv = GetEquipmentIndices($player, 0);
          break;
        case "EQUIPCARD":
          $rv = FindCharacterIndex($player, $subparam);
          break;
        case "EQUIPONCC":
          $rv = GetEquipmentIndices($player, onCombatChain:true);
          break;
        case "CCAA":
          $rv = SearchCombatChainLink($player, "AA");
          break;
        case "CCDEFLESSX":
          $rv = SearchCombatChainLink($player, "", "", -1, -1, "", "", false, false, -1, false, -1, $subparam);
          break;
        case "HANDEARTH":
          $rv = SearchHand($player, "", "", -1, -1, "", "EARTH");
          break;
        case "HANDICE":
          $rv = SearchHand($player, "", "", -1, -1, "", "ICE");
          break;
        case "HANDLIGHTNING":
          $rv = SearchHand($player, "", "", -1, -1, "", "LIGHTNING");
          break;
        case "HANDAAMAXCOST":
          $rv = SearchHand($player, "AA", "", $subparam);
          break;
        case "MYHANDAA":
          $rv = SearchHand($player, "AA");
          break;
        case "MYHANDARROW":
          $rv = SearchHand($player, "", "Arrow");
          break;
        case "MYDECKARROW":
          $rv = SearchDeck($player, "", "Arrow");
          break;
        case "MAINHAND":
          $rv = GetIndices(count(GetHand($mainPlayer)));
          break;
        case "FIRSTXDECK":
          $deck = &GetDeck($player);
          if ($subparam > count($deck)) $subparam = count($deck);
          $rv = GetIndices($subparam);
          break;
        case "BANISHTYPE":
          $rv = SearchBanish($player, $subparam);
          break;
        case "GY":
          $discard = &GetDiscard($player);
          $rv = GetIndices(count($discard));
          break;
        case "GYTYPE":
          $rv = SearchDiscard($player, $subparam);
          break;
        case "GYAA":
          $rv = SearchDiscard($player, "AA");
          break;
        case "GYNAA":
          $rv = SearchDiscard($player, "A");
          break;
        case "GYCLASSAA":
          $rv = SearchDiscard($player, "AA", "", -1, -1, $subparam);
          break;
        case "GYCLASSNAA":
          $rv = SearchDiscard($player, "A", "", -1, -1, $subparam);
          break;
        case "GYCARD":
          $rv = SearchDiscardForCard($player, $subparam);
          break;
        case "WEAPON":
          $rv = WeaponIndices($player, $player, $subparam);
          break;
        case "DMGPREVENTION": $rv = GetDamagePreventionIndices(); break;
        case "MON020":
        case "MON021":
        case "MON022":
          $rv = SearchDiscard($player, "", "", -1, -1, "", "", false, true);
          break;
        case "MON033-1":
          $rv = GetIndices(count(GetSoul($player)), 1);
          break;
        case "MON033-2":
          $rv = CombineSearches(SearchDeck($player, "A", "", $lastResult), SearchDeck($player, "AA", "", $lastResult));
          break;
        case "MON125":
          $rv = SearchDeck($player, "", "", -1, -1, "", "", true);
          break;
        case "MON156":
          $rv = SearchHand($player, "", "", -1, -1, "", "", true);
          break;
        case "MON158":
          $rv = InvertExistenceIndices($player);
          break;
        case "MON159":
        case "MON160":
        case "MON161":
          $rv = SearchDiscard($player, "A", "", -1, -1, "", "", true);
          break;
        case "MON212":
          $rv = SearchBanish($player, "AA", "", $subparam);
          break;
        case "MON266-1":
          $rv = SearchHand($player, "AA", "", -1, -1, "", "", false, false, -1, false, 3);
          break;
        case "MON266-2":
          $rv = SearchDeckForCard($player, "MON296", "MON297", "MON298");
          break;
        case "MON303":
          $rv =  SearchDiscard($player, "AA", "", 2);
          break;
        case "MON304":
          $rv = SearchDiscard($player, "AA", "", 1);
          break;
        case "MON305":
          $rv = SearchDiscard($player, "AA", "", 0);
          break;
        case "HANDIFZERO":
          if ($lastResult == 0) {
            $hand = &GetHand($player);
            $rv = GetIndices(count($hand));
          }
          break;
        case "ELE006":
          $count = CountAura("WTR075", $player);
          $rv = SearchDeck($player, "AA", "", $count, -1, "GUARDIAN");
          break;
        case "ELE113":
          $rv = PulseOfCandleholdIndices($player);
          break;
        case "ELE116":
          $rv = PlumeOfEvergrowthIndices($player);
          break;
        case "ELE125":
        case "ELE126":
        case "ELE127":
          $rv = SummerwoodShelterIndices($player);
          break;
        case "ELE140":
        case "ELE141":
        case "ELE142":
          $rv = SowTomorrowIndices($player, $parameter);
          break;
        case "EVR178":
          $rv = SearchDeckForCard($player, "MON281", "MON282", "MON283");
          break;
        case "HEAVE":
          $rv = HeaveIndices();
          break;
        case "BRAVOSTARSHOW":
          $rv = BravoStarOfTheShowIndices();
          break;
        case "AURACLASS":
          $rv = SearchAura($player, "", "", -1, -1, $subparam);
          break;
        case "AURAMAXCOST":
          $rv = SearchAura($player, "", "", $subparam);
          break;
        case "DECKAURAMAXCOST":
          $rv = SearchDeck($player, "", "Aura", $subparam);
          break;
        case "CROWNOFREFLECTION":
          $rv = SearchHand($player, "", "Aura", -1, -1, "ILLUSIONIST");
          break;
        case "LIFEOFPARTY":
          $rv = LifeOfThePartyIndices();
          break;
        case "COALESCENTMIRAGE":
          $rv = SearchHand($player, "", "Aura", -1, 0, "ILLUSIONIST");
          break;
        case "MASKPOUNCINGLYNX":
          $rv = SearchDeck($player, "AA", "", -1, -1, "", "", false, false, -1, false, 2);
          break;
        case "SHATTER":
          $rv = ShatterIndices($player, $subparam);
          break;
        case "KNICKKNACK":
          $rv = KnickKnackIndices($player);
          break;
        case "CASHOUT":
          $rv = CashOutIndices($player);
          break;
        case "UPR086":
          $rv = ThawIndices($player);
          break;
        case "QUELL":
          $rv = QuellIndices($player);
          break;
        case "SOUL":
          $rv = SearchSoul($player, talent:"LIGHT");
          break;
        default:
          $rv = "";
          break;
      }
      return ($rv == "" ? "PASS" : $rv);
    case "MULTIZONEINDICES":
      $rv = SearchMultizone($player, $parameter);
      return ($rv == "" ? "PASS" : $rv);
    case "PUTPLAY":
      $subtype = CardSubType($lastResult);
      if ($subtype == "Item") {
        PutItemIntoPlayForPlayer($lastResult, $player, ($parameter != "-" ? $parameter : 0));
      } else if (DelimStringContains($subtype, "Aura")) {
        PlayAura($lastResult, $player);
        PlayAbility($lastResult, "-", 0);
      }
      return $lastResult;
    case "PUTPLAYITEMDQVAR":
      PutItemIntoPlayForPlayer($dqVars[$parameter], $player, 0);
      return $lastResult;
    case "STARTOFGAMEPUTPLAY":
      PutItemIntoPlayForPlayer($parameter, $player);
      return $lastResult;
    case "DRAW":
      return Draw($player);
    case "BANISH":
      BanishCardForPlayer($lastResult, $player, "-", $parameter);
      return $lastResult;
    case "MULTIBANISH":
      $cards = explode(",", $lastResult);
      $params = explode(",", $parameter);
      if(count($params) < 3) array_push($params, "");
      $mzIndices = "";
      for ($i = 0; $i < count($cards); ++$i) {
        $index = BanishCardForPlayer($cards[$i], $player, $params[0], $params[1], $params[2]);
        if ($mzIndices != "") $mzIndices .= ",";
        $mzIndices .= "BANISH-" . $index;
      }
      $dqState[5] = $mzIndices;
      return $lastResult;
    case "DUPLICITYBANISH":
      $cards = explode(",", $lastResult);
      $params = explode(",", $parameter);
      $mzIndices = "";

      if (cardType($cards[0]) == "A") {
        $isPlayable = $params[1];
      } else {
        $isPlayable = "-";
      }

      for ($i = 0; $i < count($cards); ++$i) {
        $index = BanishCardForPlayer($cards[$i], $player, $params[0], $isPlayable);
        if ($mzIndices != "") $mzIndices .= ",";
        $mzIndices .= "BANISH-" . $index;
      }
      $dqState[5] = $mzIndices;
      return $lastResult;
    case "REMOVECOMBATCHAIN":
      $cardID = $combatChain[$lastResult];
      for ($i = CombatChainPieces() - 1; $i >= 0; --$i) {
        unset($combatChain[$lastResult + $i]);
      }
      $combatChain = array_values($combatChain);
      return $cardID;
    case "REMOVESOUL":
      $soul = &GetSoul($player);
      $cardID = $soul[$lastResult];
      unset($soul[$lastResult]);
      $soul = array_values($soul);
      return $cardID;
    case "COMBATCHAINBUFFPOWER":
      CombatChainPowerModifier($lastResult, $parameter);
      return $lastResult;
    case "COMBATCHAINBUFFDEFENSE":
      $combatChain[$lastResult + 6] += $parameter;
      return $lastResult;
    case "COMBATCHAINDEBUFFDEFENSE":
      $defense = BlockingCardDefense($lastResult);
      if ($parameter > $defense) $parameter = $defense;
      $combatChain[$lastResult + 6] -= $parameter;
      return $lastResult;
    case "REMOVEMYDISCARD":
      $discard = &GetDiscard($player);
      $cardID = $discard[$lastResult];
      unset($discard[$lastResult]);
      $discard = array_values($discard);
      return $cardID;
    case "REMOVEDISCARD":
      $discard = &GetDiscard($player);
      $cardID = $discard[$lastResult];
      unset($discard[$lastResult]);
      $discard = array_values($discard);
      return $cardID;
    case "REMOVEMYHAND":
      $hand = &GetHand($player);
      $cardID = $hand[$lastResult];
      unset($hand[$lastResult]);
      $hand = array_values($hand);
      return $cardID;
    case "HANDCARD":
      $hand = &GetHand($player);
      $cardID = $hand[$lastResult];
      return $cardID;
    case "MULTIREMOVEDISCARD":
      $discard = &GetDiscard($player);
      $cards = "";
      if (!is_array($lastResult)) $lastResult = explode(",", $lastResult);
      for ($i = 0; $i < count($lastResult); ++$i) {
        if ($cards != "") $cards .= ",";
        $cards .= $discard[$lastResult[$i]];
        unset($discard[$lastResult[$i]]);
      }
      $discard = array_values($discard);
      return $cards;
    case "MULTIREMOVEMYSOUL":
      for ($i = 0; $i < $lastResult; ++$i) BanishFromSoul($player);
      return $lastResult;
    case "ADDTHEIRHAND":
      $oPlayer = ($player == 1 ? 2 : 1);
      AddPlayerHand($lastResult, $oPlayer, "-");
      return $lastResult;
    case "ADDMAINHAND":
      AddPlayerHand($lastResult, $mainPlayer, "-");
      return $lastResult;
    case "ADDMYHAND":
      AddPlayerHand($lastResult, $currentPlayer, "-");
      return $lastResult;
    case "ADDHAND":
      AddPlayerHand($lastResult, $player, "-");
      return $lastResult;
    case "ADDMYPITCH":
      $pitch = &GetPitch($player);
      array_push($pitch, $lastResult);
      return $lastResult;
    case "PITCHABILITY":
      PitchAbility($lastResult);
      return $lastResult;
    case "ADDARSENALFACEUP":
      $params = explode("-", $parameter);
      if (count($params) > 1) AddArsenal($lastResult, $player, $params[0], "UP", $params[1]);
      else AddArsenal($lastResult, $player, $params[0], "UP");
      return $lastResult;
    case "ADDARSENALFACEDOWN":
      AddArsenal($lastResult, $player, $parameter, "DOWN");
      return $lastResult;
    case "TURNARSENALFACEUP":
      $arsenal = &GetArsenal($player);
      $arsenal[$lastResult + 1] = "UP";
      return $lastResult;
    case "REMOVEARSENAL":
      $index = $lastResult;
      $arsenal = &GetArsenal($player);
      $cardToReturn = $arsenal[$index];
      RemoveArsenalEffects($player, $cardToReturn);
      for ($i = $index + ArsenalPieces() - 1; $i >= $index; --$i) {
        unset($arsenal[$i]);
      }
      $arsenal = array_values($arsenal);
      return $cardToReturn;
    case "MULTIREMOVEARSENAL":
      $cards = "";
      $arsenal = &GetArsenal($player);
      if (!is_array($lastResult)) $lastResult = explode(",", $lastResult);
      for ($i = 0; $i < count($lastResult); ++$i) {
        if ($cards != "") $cards .= ",";
        $cards .= $arsenal[$lastResult[$i]];
        unset($arsenal[$lastResult[$i]]);
      }
      $arsenal = array_values($arsenal);
      return $cards;
    case "FULLARSENALTODECK":
      $arsenal = &GetArsenal($player);
      $deck = &GetDeck($player);
      $i = 0;
      while (count($arsenal) > 0) {
        if ($i % ArsenalPieces() == 0) {
          array_push($deck, $arsenal[$i]);
          RemoveArsenalEffects($player, $arsenal[$i]);
        }
        unset($arsenal[$i]);
        ++$i;
      }
      return $lastResult;
    case "MULTIADDHAND":
      $cards = explode(",", $lastResult);
      $hand = &GetHand($player);
      $displayText = "";
      for ($i = 0; $i < count($cards); ++$i) {
        if ($parameter == "1") {
          if ($displayText != "") $displayText .= ", ";
          if ($i != 0 && $i == count($cards) - 1) $displayText .= "and ";
          $displayText .= CardLink($cards[$i], $cards[$i]);
        }
        array_push($hand, $cards[$i]);
      }
      if ($displayText != "") {
        $word = (count($cards) == 1 ? "was" : "were");
        WriteLog($displayText . " $word added to your hand.");
      }
      return $lastResult;
    case "MULTIREMOVEHAND":
      $cards = "";
      $hand = &GetHand($player);
      if (!is_array($lastResult)) $lastResult = explode(",", $lastResult);
      for ($i = 0; $i < count($lastResult); ++$i) {
        if ($cards != "") $cards .= ",";
        $cards .= $hand[$lastResult[$i]];
        unset($hand[$lastResult[$i]]);
      }
      $hand = array_values($hand);
      return $cards;
    case "ADDLAYER":
      AddLayer("TRIGGER", $player, $parameter);
      return $lastResult;
    case "DESTROYCHARACTER":
      DestroyCharacter($player, $lastResult);
      return $lastResult;
    case "DESTROYTHEIRCHARACTER":
      $character = &GetPlayerCharacter($defPlayer);
      DestroyCharacter($player == 1 ? 2 : 1, $lastResult);
      WriteLog(CardLink($character[$lastResult], $character[$lastResult]) . " was destroyed.");
      return $lastResult;
    case "DESTROYEQUIPDEF0":
      $character = &GetPlayerCharacter($defPlayer);
      if (BlockValue($character[$lastResult]) + $character[$lastResult + 4] <= 0) {
        WriteLog(CardLink($character[$lastResult], $character[$lastResult]) . " was destroyed.");
        DestroyCharacter($defPlayer, $lastResult);
      }
      return "";
    case "CHARFLAGDESTROY":
      $character = &GetPlayerCharacter($player);
      $character[$parameter + 7] = 1;
      return $lastResult;
    case "ADDCHARACTEREFFECT":
      $characterEffects = &GetCharacterEffects($player);
      array_push($characterEffects, $lastResult);
      array_push($characterEffects, $parameter);
      return $lastResult;
    case "ADDMZBUFF":
      $lrArr = explode("-", $lastResult);
      $characterEffects = &GetCharacterEffects($player);
      array_push($characterEffects, $lrArr[1]);
      array_push($characterEffects, $parameter);
      return $lastResult;
    case "ADDMZUSES":
      $lrArr = explode("-", $lastResult);
      switch ($lrArr[0]) {
        case "MYCHAR":
        case "THEIRCHAR":
          AddCharacterUses($player, $lrArr[1], $parameter);
          break;
        default:
          break;
      }
      return $lastResult;
    case "MZOP":
      switch ($parameter) //Mode
      {
        case "FREEZE":
          MZFreeze($lastResult);
          break;
        default:
          break;
      }
      return $lastResult;
    case "PASSPARAMETER":
      return $parameter;
    case "DISCARDMYHAND":
      $hand = &GetHand($player);
      $cardID = $hand[$lastResult];
      unset($hand[$lastResult]);
      $hand = array_values($hand);
      AddGraveyard($cardID, $player, "HAND");
      CardDiscarded($player, $cardID);
      return $cardID;
    case "DISCARDCARD":
      AddGraveyard($lastResult, $player, $parameter);
      CardDiscarded($player, $lastResult);
      WriteLog(CardLink($lastResult, $lastResult) . " was discarded.");
      return $lastResult;
    case "ADDDISCARD":
      AddGraveyard($lastResult, $player, $parameter);
      WriteLog(CardLink($lastResult, $lastResult) . " was discarded.");
      return $lastResult;
    case "ADDBOTTOMMYDECK":
      $deck = &GetDeck($player);
      array_push($deck, $lastResult);
      WriteLog("A card was put at the bottom of the deck.");
      return $lastResult;
    case "ADDBOTDECK":
      $deck = &GetDeck($player);
      array_push($deck, $lastResult);
      return $lastResult;
    case "MULTIADDDECK":
      $deck = &GetDeck($player);
      $cards = explode(",", $lastResult);
      for ($i = 0; $i < count($cards); ++$i) {
        array_push($deck, $cards[$i]);
      }
      return $lastResult;
    case "MULTIADDTOPDECK":
      $deck = &GetDeck($player);
      $cards = explode(",", $lastResult);
      for ($i = 0; $i < count($cards); ++$i) {
        array_unshift($deck, $cards[$i]);
      }
      return $lastResult;
    case "MULTIREMOVEDECK":
      if (!is_array($lastResult)) $lastResult = ($lastResult == "" ? [] : explode(",", $lastResult));
      $cards = "";
      $deck = &GetDeck($player);
      for ($i = 0; $i < count($lastResult); ++$i) {
        if ($cards != "") $cards .= ",";
        $cards .= $deck[$lastResult[$i]];
        unset($deck[$lastResult[$i]]);
      }
      $deck = array_values($deck);
      return $cards;
    case "PLAYAURA":
      PlayAura($parameter, $player);
      break;
    case "DESTROYAURA":
      DestroyAura($player, $lastResult);
      break;
    case "DESTROYALLY":
      DestroyAlly($player, $lastResult);
      break;
    case "DESTROYCHANNEL":
      $auras = &GetAuras($mainPlayer);
      if ($dqVars[0] > 0) {
        WriteLog(CardLink($auras[$parameter], $auras[$parameter]) . " was destroyed.");
        DestroyAura($player, $parameter);
      }
      break;
    case "PARAMDELIMTOARRAY":
      return explode(",", $parameter);
    case "ADDSOUL":
      AddSoul($lastResult, $player, $parameter);
      return $lastResult;
    case "SHUFFLEDECK":
      $zone = &GetDeck($player);
      $destArr = [];
      if($parameter == "SKIPSEED") { global $randomSeeded; $randomSeeded = true; }
      while (count($zone) > 0) {
        $index = GetRandom(0, count($zone) - 1);
        array_push($destArr, $zone[$index]);
        unset($zone[$index]);
        $zone = array_values($zone);
      }
      $zone = $destArr;
      return $lastResult;
    case "GIVEATTACKGOAGAIN":
      $combatChainState[$CCS_CurrentAttackGainedGoAgain] = 1;
      return $lastResult;
    case "EXHAUSTCHARACTER":
      $character = &GetPlayerCharacter($player);
      $character[$parameter + 1] = 1;
      return $parameter;
    case "DECKCARDS":
      $indices = explode(",", $parameter);
      $deck = &GetDeck($player);
      $rv = "";
      for ($i = 0; $i < count($indices); ++$i) {
        if ($rv != "") $rv .= ",";
        $rv .= $deck[$i];
      }
      return $rv == "" ? "PASS" : $rv;
    case "SHOWSELECTEDCARD":
      WriteLog(CardLink($lastResult, $lastResult) . " was selected.");
      return $lastResult;
    case "SHOWSELECTEDMODE":
      $rv = implode(" ", explode("_", $lastResult));
      WriteLog(CardLink($parameter, $parameter) . " mode is: " . $rv);
      return $lastResult;
    case "SHOWSELECTEDMODES":
      $rv = "";
      for ($i = 0; $i < count($lastResult); ++$i) {
        if ($rv != "") $rv .= " and ";
        $rv .= implode(" ", explode("_", $lastResult[$i]));
      }
      WriteLog(CardLink($parameter, $parameter) . " modes are: " . $rv);
      return $lastResult;
    case "SHOWBANISHEDCARD":
      WriteLog(CardLink($lastResult, $lastResult) . " was banished.");
      return $lastResult;
    case "SHOWDISCARDEDCARD":
      WriteLog(CardLink($lastResult, $lastResult) . " was discarded.");
      return $lastResult;
    case "SHOWSELECTEDHANDCARD":
      $hand = &GetHand($player);
      WriteLog(CardLink($hand[$lastResult], $hand[$lastResult]) . " was selected.");
      return $lastResult;
    case "REVEALCARDS":
      $cards = (is_array($lastResult) ? implode(",", $lastResult) : $lastResult);
      $revealed = RevealCards($cards, $player);
      return ($revealed ? $lastResult : "PASS");
    case "REVEALHANDCARDS":
      $indices = (is_array($lastResult) ? $lastResult : explode(",", $lastResult));
      $hand = &GetHand($player);
      $cards = "";
      for ($i = 0; $i < count($indices); ++$i) {
        if ($cards != "") $cards .= ",";
        $cards .= $hand[$indices[$i]];
      }
      $revealed = RevealCards($cards, $player);
      return ($revealed ? $cards : "PASS");
    case "REVEALHANDCARDSRETURNLASTRESULT":
      $indices = (is_array($lastResult) ? $lastResult : explode(",", $lastResult));
      $hand = &GetHand($player);
      $cards = "";
      for ($i = 0; $i < count($indices); ++$i) {
        if ($cards != "") $cards .= ",";
        $cards .= $hand[$indices[$i]];
      }
      $revealed = RevealCards($cards, $player);
      return ($revealed ? $lastResult : "PASS");
    case "WRITELOG":
      WriteLog(implode(" ", explode("_", $parameter)));
      return $lastResult;
    case "WRITECARDLOG":
      $message = implode(" ", explode("_", $parameter)) . CardLink($lastResult, $lastResult);
      WriteLog($message);
      return $lastResult;
    case "ADDNEGDEFCOUNTER":
      $character = &GetPlayerCharacter($player);
      $character[$lastResult + 4] -= 1;
      WriteLog(CardLink($character[$lastResult], $character[$lastResult]) . " gained a negative counter.");
      return $lastResult;
    case "ADDEQUIPCOUNTER":
      $character = &GetPlayerCharacter($player);
      $character[$lastResult + 3] += 1;
      WriteLog("A counter was added to " . CardLink($character[$lastResult], $character[$lastResult]));
      return $lastResult;
    case "REMOVENEGDEFCOUNTER":
      $character = &GetPlayerCharacter($player);
      $character[$lastResult + 4] += 1;
      WriteLog("A negative counter was removed from " . CardLink($character[$lastResult], $character[$lastResult]));
      return $lastResult;
    case "REMOVEENERGYCOUNTER":
      $character = &GetPlayerCharacter($player);
      $character[$lastResult + 2] -= 1;
      return $lastResult;
    case "SURGEENERGYLOSSLOG":
      $character = &GetPlayerCharacter($player);
      WriteLog(CardLink($parameter, $parameter) . " surge's ability removed 1 energy counter from " . CardLink($character[$lastResult], $character[$lastResult]));
      return $lastResult;
    case "FLASHFREEZEDOMINATE":
      AddCurrentTurnEffect($parameter, $player, "PLAY");
      return "1";
    case "ADDCURRENTEFFECT":
      AddCurrentTurnEffect($parameter, $player);
      return "1";
    case "REMOVECURRENTEFFECT":
      RemoveCurrentEffect($player, $parameter);
      return "1";
    case "ADDCURRENTANDNEXTTURNEFFECT":
      AddCurrentTurnEffect($parameter, $player);
      AddNextTurnEffect($parameter, $player);
      return "1";
    case "ADDLIMITEDCURRENTEFFECT":
      $params = explode(",", $parameter);
      AddCurrentTurnEffect($params[0], $player, $params[1], $lastResult);
      return $lastResult;
    case "ADDARSENALUNIQUEIDCURRENTEFFECT":
      $arsenal = &GetArsenal($player);
      $params = explode(",", $parameter);
      AddCurrentTurnEffect($params[0], $player, $params[1], $arsenal[$lastResult + 5]);
      return $lastResult;
    case "ADDAIMCOUNTER":
      $arsenal = &GetArsenal($player);
      $arsenal[$lastResult + 3] += 1;
      return $lastResult;
    case "OPTX":
      Opt("NA", $parameter);
      return $lastResult;
    case "SETCLASSSTATE":
      SetClassState($player, $parameter, $lastResult);
      return $lastResult;
    case "SETCLASSSTATEMULTICHOOSETEXT":
      $value = $lastResult[0] . "," . $lastResult[1];
      SetClassState($player, $parameter, $value);
      return $lastResult;
    case "GAINACTIONPOINTS":
      $actionPoints += $parameter;
      return $lastResult;
    case "NOPASS":
      if ($lastResult == "NO") return "PASS";
      return 1;
    case "NOPASSLOG":
      if ($lastResult == "NO") {
        writelog("Player " . $player . " looked at the top of the deck and left the card there.");
        return "PASS";
      }
      writelog("Player " . $player . " put a card at the bottom of the deck.");
      return 1;
    case "NOPASSARAKNI":
      if ($lastResult == "NO") {
        writelog(CardLink($parameter, $parameter) . " looked at the top of the deck and left the card there.", $player);
        return "PASS";
      }
      writelog(CardLink($parameter, $parameter) . " put a card at the bottom of the deck.", $player);
      return 1;
    case "SANDSCOURGREATBOW":
      if ($lastResult == "NO") {
        ReloadArrow($player); // From Hand
      } else {                // From Top Deck
        AddDecisionQueue("PARAMDELIMTOARRAY", $currentPlayer, "0", 1);
        AddDecisionQueue("MULTIREMOVEDECK", $currentPlayer, "-", 1);
        AddDecisionQueue("NULLPASS", $currentPlayer, "-", 1);
        AddDecisionQueue("ADDARSENALFACEUP", $currentPlayer, "DECK-1", 1);
        AddDecisionQueue("ALLCARDSUBTYPEORPASS", $currentPlayer, "Arrow", 1);
      }
      return $lastResult;
    case "NOFUSE":
      if ($lastResult == "PASS") {
        WriteLog("Nothing is revealed for " . CardLink($parameter, $parameter) . " fusion.");
        return "PASS";
      }
      return $lastResult;
    case "NULLPASS":
      if ($lastResult == "") return "PASS";
      return $lastResult;
    case "ELSE":
      if($lastResult == "PASS") return "0";
      else if ($lastResult == "NO") return "NO";
      else return $lastResult;
    case "FINDCURRENTEFFECTPASS":
      if (SearchCurrentTurnEffects($parameter, $player)) return "PASS";
      return $lastResult;
    case "LESSTHANPASS":
      if ($lastResult < $parameter) return "PASS";
      return $lastResult;
    case "GREATERTHANPASS":
      if ($lastResult > $parameter) return "PASS";
      return $lastResult;
    case "EQUIPDEFENSE":
      $char = &GetPlayerCharacter($player);
      $defense = BlockValue($char[$lastResult]) + $char[$lastResult + 4];
      if ($defense < 0) $defense = 0;
      return $defense;
    case "ALLCARDTYPEORPASS":
      $cards = explode(",", $lastResult);
      for ($i = 0; $i < count($cards); ++$i) {
        if (CardType($cards[$i]) != $parameter) return "PASS";
      }
      return $lastResult;
    case "NONECARDTYPEORPASS":
      $cards = explode(",", $lastResult);
      for ($i = 0; $i < count($cards); ++$i) {
        if (CardType($cards[$i]) == $parameter) return "PASS";
      }
      return $lastResult;
    case "ALLCARDSUBTYPEORPASS":
      $cards = explode(",", $lastResult);
      for ($i = 0; $i < count($cards); ++$i) {
        if (CardSubtype($cards[$i]) != $parameter) return "PASS";
      }
      return $lastResult;
    case "ALLCARDTALENTORPASS":
      $cards = explode(",", $lastResult);
      for ($i = 0; $i < count($cards); ++$i) {
        if (!TalentContains($cards[$i], $parameter, $player)) return "PASS";
      }
      return $lastResult;
    case "ALLCARDSCOMBOORPASS":
      $cards = explode(",", $lastResult);
      for ($i = 0; $i < count($cards); ++$i) {
        if (!HasCombo($cards[$i])) return "PASS";
      }
      return $lastResult;
    case "ALLCARDMAXCOSTORPASS":
      $cards = explode(",", $lastResult);
      for ($i = 0; $i < count($cards); ++$i) {
        if (CardCost($cards[$i]) > $parameter) return "PASS";
      }
      return $lastResult;
    case "ALLCARDCLASSORPASS":
      $cards = explode(",", $lastResult);
      for ($i = 0; $i < count($cards); ++$i) {
        if (!ClassContains($cards[$i], $parameter, $player)) return "PASS";
      }
      return $lastResult;
    case "CLASSSTATEGREATERORPASS":
      $parameters = explode("-", $parameter);
      $state = $parameters[0];
      $threshold = $parameters[1];
      if (GetClassState($player, $state) < $threshold) return "PASS";
      return 1;
    case "CHARREADYORPASS":
      $char = &GetPlayerCharacter($player);
      if ($char[$parameter + 1] != 2) return "PASS";
      return 1;
    case "ESTRIKE":
      switch ($lastResult) {
        case "Draw_a_Card":
          WriteLog(CardLink("WTR159", "WTR159") . " draw a card.");
          return MyDrawCard();
        case "Buff_Power":
          WriteLog(CardLink("WTR159", "WTR159") . " gained +2 power.");
          AddCurrentTurnEffect("WTR159", $player);
          return 1;
        case "Go_Again":
          WriteLog(CardLink("WTR159", "WTR159") . " gained go again.");
          $combatChainState[$CCS_CurrentAttackGainedGoAgain] = 1;
          return 2;
      }
      return $lastResult;
    case "NIMBLESTRIKE":
      AddCurrentTurnEffect("WTR185", $player);
      $combatChainState[$CCS_CurrentAttackGainedGoAgain] = 1;
      return "1";
    case "SLOGGISM":
      AddCurrentTurnEffect("WTR197", $player);
      return "1";
    case "SANDSKETCH":
      if (count(GetHand($player)) == 0) {
        WriteLog("No card for Sand Sketched Plan to discard.");
        return "1";
      }
      $discarded = DiscardRandom($player, "WTR009");
      if (AttackValue($discarded) >= 6) {
        if($currentPlayer == $mainPlayer) {
          $actionPoints += 2;
          WriteLog(CardLink("WTR009","WTR009") . " gained 2 action points.");
        }
      }
      return "1";
    case "REMEMBRANCE":
      $cards = "";
      $deck = &GetDeck($player);
      $discard = &GetDiscard($player);
      for ($i = 0; $i < count($lastResult); ++$i) {
        array_push($deck, $discard[$lastResult[$i]]);
        if ($cards != "") $cards .= ", ";
        if ($i == count($lastResult) - 1) $cards .= "and ";
        $cards .= CardLink($discard[$lastResult[$i]], $discard[$lastResult[$i]]);
        unset($discard[$lastResult[$i]]);
      }
      WriteLog("Remembrance shuffled back " . $cards . ".");
      $discard = array_values($discard);
      return "1";
    case "HOPEMERCHANTHOOD":
      $cards = explode(",", $lastResult);
      if ($cards[0] != "") {
        for ($i = 0; $i < count($cards); ++$i) {
          MyDrawCard();
        }
        WriteLog(CardLink("WTR151", "WTR151") . " shuffle and draw " . count($cards) . " cards.");
      } else {
        WriteLog(CardLink("WTR151", "WTR151") . " shuffle and draw 0 card.");
      }
      return "1";
    case "LORDOFWIND":
      $number = count(explode(",", $lastResult));
      AddResourceCost($player, $number);
      return $number;
    case "REFRACTIONBOLTERS":
      if ($lastResult == "YES") {
        $character = &GetPlayerCharacter($player);
        DestroyCharacter($player, $parameter);
        $combatChainState[$CCS_CurrentAttackGainedGoAgain] = 1;
        WriteLog(CardLink("WTR117", "WTR117") . " was destroyed and gave the current attack go again.");
      }
      return $lastResult;
    case "TOMEOFAETHERWIND":
      $params = explode(",", $lastResult);
      for ($i = 0; $i < count($params); ++$i) {
        switch ($params[$i]) {
          case "Buff_Arcane":
            AddArcaneBonus(1, $player);
            break;
          case "Draw_card":
            MyDrawCard();
            break;
          default:
            break;
        }
      }
      return $lastResult;
    case "COAXCOMMOTION":
      for ($i = 0; $i < count($lastResult); ++$i) {
        switch ($lastResult[$i]) {
          case "Quicken_token":
            PlayAura("WTR225", 1);
            PlayAura("WTR225", 2);
            break;
          case "Draw_card":
            MyDrawCard();
            TheirDrawCard();
            break;
          case "Gain_life":
            GainHealth(1, $player);
            GainHealth(1, ($player == 1 ? 2 : 1));
            break;
          default:
            break;
        }
      }
      return $lastResult;
    case "CAPTAINSCALL":
      switch ($lastResult) {
        case "Buff_Power":
          WriteLog(CardLink($parameter, $parameter) . " gives +2 power.");
          AddCurrentTurnEffect($parameter . "-1", $player);
          return 1;
        case "Go_Again":
          WriteLog(CardLink($parameter, $parameter) . " gives go again.");
          AddCurrentTurnEffect($parameter . "-2", $player);
          return 2;
      }
      return $lastResult;
    case "IRONHIDE":
      $character = &GetPlayerCharacter($player);
      $index = FindCharacterIndex($player, $combatChain[$parameter]);
      $character[$index + 4] += 2;
      return $lastResult;
    case "RAMPARTOFTHERAMSHEAD":
      $character = &GetPlayerCharacter($player);
      $index = FindCharacterIndex($player, $combatChain[$parameter]);
      $character[$index + 4] += $lastResult;
      return $lastResult;
    case "PHANTASMALFOOTSTEPS":
      $character = &GetPlayerCharacter($player);
      $index = FindCharacterIndex($player, $combatChain[$lastResult]);
      if ($character[$index + 4] <= 0) $character[$index + 4] += 1;
      else $character[$index + 4] == 1;
      return $lastResult;
    case "PHANTASMALFOOTSTEPSDESTROYED":
      $otherPlayer = $player == 1 ? 2 : 1;
      $character = &GetPlayerCharacter($player);
      $index = FindCharacterIndex($player, $combatChain[$lastResult]);
      if (!ClassContains($combatChain[0], "ILLUSIONIST", $otherPlayer) && DoesBlockTriggerPhantasm(0)) {
        $character[$index + 1] = 0;
      }
      return $lastResult;
    case "ARTOFWAR":
      global $currentPlayer, $combatChain, $defPlayer;
      $params = explode(",", $lastResult);
      for ($i = 0; $i < count($params); ++$i) {
        switch ($params[$i]) {
          case "Buff_your_attack_action_cards_this_turn":
            WriteLog(CardLink("ARC160", "ARC160") . " gives attack action cards +1 power and defense this turn.");
            AddCurrentTurnEffect("ARC160-1", $currentPlayer);
            if ($currentPlayer == $defPlayer) {
              for ($j = CombatChainPieces(); $j <= count($combatChain); $j += CombatChainPieces()) {
                if (CardType($combatChain[$j]) == "AA") CombatChainPowerModifier($j, 1);
              }
            }
            break;
          case "Your_next_attack_action_card_gains_go_again":
            WriteLog(CardLink("ARC160", "ARC160") . " gives the next attack action card this turn go again.");
            if (count($combatChain) > 0) {
              AddCurrentTurnEffectFromCombat("ARC160-3", $currentPlayer);
            } else {
              AddCurrentTurnEffect("ARC160-3", $currentPlayer);
            }
            break;
          case "Defend_with_attack_action_cards_from_arsenal":
            WriteLog(CardLink("ARC160", "ARC160") . " makes it possible to block with attack actions from arsenal.");
            AddCurrentTurnEffect("ARC160-2", $currentPlayer);
            break;
          case "Banish_an_attack_action_card_to_draw_2_cards":
            WriteLog(CardLink("ARC160", "ARC160") . " allows you to banish a card and draw 2.");
            PrependDecisionQueue("DRAW", $currentPlayer, "-", 1);
            PrependDecisionQueue("DRAW", $currentPlayer, "-", 1);
            PrependDecisionQueue("SHOWBANISHEDCARD", $currentPlayer, "-", 1);
            PrependDecisionQueue("BANISH", $currentPlayer, "-", 1);
            PrependDecisionQueue("REMOVEMYHAND", $currentPlayer, "-", 1);
            PrependDecisionQueue("MAYCHOOSEHAND", $currentPlayer, "<-", 1);
            PrependDecisionQueue("SETDQCONTEXT", $currentPlayer, "Choose a card to banish", 1);
            PrependDecisionQueue("FINDINDICES", $currentPlayer, "MYHANDAA");
            break;
          default:
            break;
        }
      }
      return $lastResult;
    case "BLOODONHERHANDS":
      BloodOnHerHandsResolvePlay($lastResult);
      return $lastResult;
    case "VESTOFTHEFIRSTFIST":
      if ($lastResult == "YES") {
        $character = &GetPlayerCharacter($player);
        $character[$parameter + 1] = 0;
        GainResources($player, 2);
        WriteLog("Vest of the First Fist was destroyed and gave 2 resources.");
      }
      return $lastResult;
    case "BOOST":
      global $CS_NumBoosted, $CCS_NumBoosted, $CCS_IsBoosted;
      $deck = &GetDeck($currentPlayer);
      if (count($deck) == 0) {
        WriteLog("Could not boost. No cards left in deck.");
        return;
      }
      ItemBoostEffects();
      $actionPoints += CountCurrentTurnEffects("ARC006", $currentPlayer);
      $cardID = $deck[0];
      if(CardSubType($cardID) == "Item" && SearchCurrentTurnEffects("DYN091-2", $player, true)) PutItemIntoPlay($cardID);
      else BanishCardForPlayer($cardID, $currentPlayer, "DECK", "BOOST");
      unset($deck[0]);
      $deck = array_values($deck);
      $grantsGA = ClassContains($cardID, "MECHANOLOGIST", $currentPlayer);
      WriteLog("Boost banished " . CardLink($cardID, $cardID) . " and " . ($grantsGA ? "DID" : "did NOT") . " grant go again.");
      IncrementClassState($currentPlayer, $CS_NumBoosted);
      ++$combatChainState[$CCS_NumBoosted];
      $combatChainState[$CCS_IsBoosted] = 1;
      if ($grantsGA) {
        GiveAttackGoAgain();
      }
      return $grantsGA;
    case "VOFTHEVANGUARD":
      if ($parameter == "1" && TalentContains($lastResult, "LIGHT")) {
        WriteLog("V of the Vanguard gives all attacks on this combat chain +1.");
        ++$combatChainState[$CCS_ChainAttackBuff];
      }
      $hand = &GetHand($player);
      if (count($hand) > 0) {
        PrependDecisionQueue("VOFTHEVANGUARD", $player, "1", 1);
        PrependDecisionQueue("CHARGE", $player, "-", 1);
      }
      return "1";
    case "BEACONOFVICTORY-1":
      WriteLog(CardLink("MON033", "MON033") . " was played with X = " . $lastResult . ".");
      return $lastResult . ",BEACONOFVICTORY";
    case "BEACONOFVICTORY-2":
      $combatChain[5] += $parameter;
      return $parameter;
    case "TRIPWIRETRAP":
      if ($lastResult == 0) {
        WriteLog("Hit effects are prevented by " . CardLink("CRU126", "CRU126") . " this chain link.");
        $combatChainState[$CCS_ChainLinkHitEffectsPrevented] = 1;
      }
      return 1;
    case "PITFALLTRAP":
      if ($lastResult == 0) {
        WriteLog(CardLink("CRU127", "CRU127") . " deals 2 damage to the attacking hero.");
        DamageTrigger($player, 2, "DAMAGE");
      }
      return 1;
    case "ROCKSLIDETRAP":
      if ($lastResult == 0) {
        WriteLog(CardLink("CRU128", "CRU128") . " give the target attack -2.");
        $combatChain[5] -= 2;
      }
      return 1;
    case "SONATAARCANIX":
      $cards = explode(",", $lastResult);
      $numAA = 0;
      $numNAA = 0;
      $AAIndices = "";
      for ($i = 0; $i < count($cards); ++$i) {
        $cardType = CardType($cards[$i]);
        if ($cardType == "A") ++$numNAA;
        else if ($cardType == "AA") {
          ++$numAA;
          if ($AAIndices != "") $AAIndices .= ",";
          $AAIndices .= $i;
        }
      }
      $numMatch = ($numAA > $numNAA ? $numNAA : $numAA);
      if ($numMatch == 0) return "PASS";
      return $numMatch . "-" . $AAIndices . "-" . $numMatch;
    case "SONATAARCANIXSTEP2":
      $numArcane = count(explode(",", $lastResult));
      DealArcane($numArcane, 0, "PLAYCARD", "MON231", true);
      return 1;
    case "SOULREAPING":
      $cards = explode(",", $lastResult);
      if (count($cards) > 0) AddCurrentTurnEffect("MON199", $player);
      $numBD = 0;
      for ($i = 0; $i < count($cards); ++$i) if (HasBloodDebt($cards[$i])) {
        ++$numBD;
      }
      GainResources($player, $numBD);
      return 1;
    case "CHARGE":
      DQCharge();
      return "1";
    case "FINISHCHARGE":
      IncrementClassState($player, $CS_NumCharged);
      return $lastResult;
    case "DEALDAMAGE":
      $target = explode("-", $lastResult);
      $targetPlayer = ($target[0] == "MYCHAR" || $target[0] == "MYALLY" ? $player : ($player == 1 ? 1 : 2));
      $parameters = explode("-", $parameter);
      $damage = $parameters[0];
      $source = $parameters[1];
      $type = $parameters[2];
      if ($target[0] == "THEIRALLY" || $target[0] == "MYALLY") {
        $allies = &GetAllies($targetPlayer);
        if ($allies[$target[1] + 6] > 0) {
          $damage -= 3;
          if ($damage < 0) $damage = 0;
          --$allies[$target[1] + 6];
        }
        $allies[$target[1] + 2] -= $damage;
        if ($damage > 0) AllyDamageTakenAbilities($targetPlayer, $target[1]);
        if ($allies[$target[1] + 2] <= 0) DestroyAlly($targetPlayer, $target[1]);
        return $damage;
      } else {
        $quellChoices = QuellChoices($targetPlayer, $damage);
        PrependDecisionQueue("TAKEDAMAGE", $targetPlayer, $parameter);
        if ($quellChoices != "0") {
          PrependDecisionQueue("PAYRESOURCES", $targetPlayer, "<-", 1);
          PrependDecisionQueue("AFTERQUELL", $targetPlayer, "-", 1);
          PrependDecisionQueue("BUTTONINPUT", $targetPlayer, $quellChoices);
          PrependDecisionQueue("SETDQCONTEXT", $targetPlayer, "Choose an amount to pay for Quell");
        } else {
          PrependDecisionQueue("PASSPARAMETER", $targetPlayer, "0"); //If no quell, we need to discard the previous last result
        }
      }
      return $damage;
    case "TAKEDAMAGE":
      $params = explode("-", $parameter);
      $damage = intval($params[0]);
      $source = $params[1];
      $type = $params[2];
      if (!CanDamageBePrevented($player, $damage, "DAMAGE")) $lastResult = 0;
      $damage -= intval($lastResult);
      $damage = DealDamageAsync($player, $damage, $type, $source);
      $dqState[6] = $damage;
      return $damage;
    case "AFTERQUELL":
      $curMaxQuell = GetClassState($player, $CS_MaxQuellUsed);
      WriteLog("Player $player prevented damage with Quell.", $player);
      if ($lastResult > $curMaxQuell) SetClassState($player, $CS_MaxQuellUsed, $lastResult);
      return $lastResult;
    case "SPELLVOIDCHOICES":
      $damage = $parameter;
      if ($lastResult != "PASS") {
        $prevented = ArcaneDamagePrevented($player, $lastResult);
        $damage -= $prevented;
        if ($damage < 0) $damage = 0;
        $dqVars[0] = $damage;
        if($damage > 0) CheckSpellvoid($player, $damage);
      }
      PrependDecisionQueue("INCDQVAR", $player, "1", 1);
      return $prevented;
    case "DEALARCANE":
      $dqState[7] = $lastResult;
      $target = explode("-", $lastResult);
      $targetPlayer = ($target[0] == "MYCHAR" || $target[0] == "MYALLY" ? $player : ($player == 1 ? 2 : 1));
      $otherPlayer = $player == 1 ? 2 : 1;
      $parameters = explode("-", $parameter);
      $damage = $parameters[0];
      $source = $parameters[1];
      $type = $parameters[2];
      if ($type == "PLAYCARD") {
        $damage += ConsumeArcaneBonus($player);
        WriteLog(CardLink($source, $source) . " is dealing " . $damage . " arcane damage.");
      }
      if ($target[0] == "THEIRALLY" || $target[0] == "MYALLY") {
        $allies = &GetAllies($targetPlayer);
        if ($allies[$target[1] + 6] > 0) {
          $damage -= 3;
          if ($damage < 0) $damage = 0;
          --$allies[$target[1] + 6];
        }
        $allies[$target[1] + 2] -= $damage;
        if ($damage > 0) AllyDamageTakenAbilities($targetPlayer, $target[1]);
        if ($allies[$target[1] + 2] <= 0) {
          DestroyAlly($targetPlayer, $target[1]);
        } else {
          AppendClassState($player, $CS_ArcaneTargetsSelected, $lastResult);
        }
        return "";
      }

      if (SearchCurrentTurnEffects("DYN025", $otherPlayer) && $targetPlayer != $otherPlayer) {
        SearchCurrentTurnEffects("DYN025", $otherPlayer, true);
        AddCurrentTurnEffect("DYN025-1", $otherPlayer);
        $targetPlayer = $otherPlayer;
      } elseif (SearchCurrentTurnEffects("DYN025", $player) && $targetPlayer != $player) {
        SearchCurrentTurnEffects("DYN025", $player, true);
        AddCurrentTurnEffect("DYN025-1", $player);
        $targetPlayer = $player;
      }

      AppendClassState($player, $CS_ArcaneTargetsSelected, $lastResult);
      $target = $targetPlayer;
      $sourceType = CardType($source);
      if($sourceType == "A" || $sourceType == "AA") $damage += CountCurrentTurnEffects("ELE065", $player);
      $arcaneBarrier = ArcaneBarrierChoices($target, $damage);
      //Create cancel point
      PrependDecisionQueue("TAKEARCANE", $target, $damage . "-" . $source . "-" . $player);
      PrependDecisionQueue("PASSPARAMETER", $target, "{1}");

      CheckSpellvoid($target, $damage);
      $quellChoices = QuellChoices($target, $damage);
      if ($quellChoices != "0") {
        PrependDecisionQueue("INCDQVAR", $target, "1", 1);
        PrependDecisionQueue("PAYRESOURCES", $target, "<-", 1);
        PrependDecisionQueue("AFTERQUELL", $target, "-", 1);
        PrependDecisionQueue("BUTTONINPUT", $target, $quellChoices);
        PrependDecisionQueue("SETDQCONTEXT", $target, "Choose an amount to pay for Quell");
      }
      PrependDecisionQueue("INCDQVAR", $target, "1", 1);
      PrependDecisionQueue("PAYRESOURCES", $target, "<-", 1);
      PrependDecisionQueue("ARCANECHOSEN", $target, "-", 1, 1);
      PrependDecisionQueue("CHOOSEARCANE", $target, $arcaneBarrier, 1, 1);
      PrependDecisionQueue("SETDQVAR", $target, "0", 1);
      PrependDecisionQueue("PASSPARAMETER", $target, $damage . "-" . $source, 1);
      PrependDecisionQueue("SETDQVAR", $target, "1", 1);
      PrependDecisionQueue("PASSPARAMETER", $target, "0", 1);
      return $parameter;
    case "ARCANEHITEFFECT":
      if ($dqVars[0] > 0) ArcaneHitEffect($player, $parameter, $dqState[7], $dqVars[0]); //player, source, target, damage
      return $lastResult;
    case "ARCANECHOSEN":
      if ($lastResult > 0) {
        if (SearchCharacterActive($player, "UPR166")) {
          $char = &GetPlayerCharacter($player);
          $index = FindCharacterIndex($player, "UPR166");
          if ($char[$index + 2] < 4 && GetClassState($player, $CS_AlluvionUsed) == 0) {
            ++$char[$index + 2];
            SetClassState($player, $CS_AlluvionUsed, 1);
          }
        }
      }
      return $lastResult;
    case "TAKEARCANE":
      $parameters = explode("-", $parameter);
      $damage = $parameters[0];
      $source = $parameters[1];
      $playerSource = $parameters[2];
      if (!CanDamageBePrevented($player, $damage, "ARCANE")) $lastResult = 0;
      $damage = DealDamageAsync($player, $damage - $lastResult, "ARCANE", $source);
      if ($damage < 0) $damage = 0;
      if($damage > 0) IncrementClassState($playerSource, $CS_ArcaneDamageDealt, $damage);
      WriteLog("Player " . $player . " lost $damage life from " . CardLink($source, $source) . " arcane damage.", $player);
      if (DelimStringContains(CardSubType($source), "Ally") && $damage > 0) ProcessDealDamageEffect($source); // Interaction with Burn Them All! + Nekria
      $dqVars[0] = $damage;
      return $damage;
    case "PAYRESOURCES":
      $resources = &GetResources($player);
      if ($lastResult < 0) $resources[0] += (-1 * $lastResult);
      else if ($resources[0] > 0) {
        $res = $resources[0];
        $resources[0] -= $lastResult;
        $lastResult -= $res;
        if ($resources[0] < 0) $resources[0] = 0;
      }
      if ($lastResult > 0) {
        $hand = &GetHand($player);
        if (count($hand) == 0) {
          WriteLog("You have resources to pay for a declared effect, but have no cards to pitch. Reverting gamestate prior to that declaration.");
          RevertGamestate();
        }
        PrependDecisionQueue("PAYRESOURCES", $player, $parameter, 1);
        PrependDecisionQueue("SUBPITCHVALUE", $player, $lastResult, 1);
        PrependDecisionQueue("PITCHABILITY", $player, "-", 1);
        PrependDecisionQueue("ADDMYPITCH", $player, "-", 1);
        PrependDecisionQueue("REMOVEMYHAND", $player, "-", 1);
        PrependDecisionQueue("CHOOSEHANDCANCEL", $player, "<-", 1);
        PrependDecisionQueue("SETDQCONTEXT", $player, "Choose a card to pitch", 1);
        PrependDecisionQueue("FINDINDICES", $player, "HAND", 1);
      }
      return $parameter;
    case "BLIZZARDLOG":
      if ($lastResult > 0) WriteLog($lastResult . " was paid for " . CardLink("ELE147", "ELE147"));
      else WriteLog("Target attack lost and can't gain go again due to " . CardLink("ELE147", "ELE147"));
      return $lastResult;
    case "ADDCLASSSTATE":
      $parameters = explode("-", $parameter);
      IncrementClassState($player, $parameters[0], $parameters[1]);
      return 1;
    case "APPENDCLASSSTATE":
      $parameters = explode("-", $parameter);
      AppendClassState($player, $parameters[0], $parameters[1]);
      return $lastResult;
    case "AFTERFUSE":
      $params = explode("-", $parameter);
      $card = $params[0];
      $elements = $params[1];
      $elementArray = explode(",", $elements);
      for ($i = 0; $i < count($elementArray); ++$i) {
        $element = $elementArray[$i];
        switch ($element) {
          case "EARTH":
            IncrementClassState($player, $CS_NumFusedEarth);
            break;
          case "ICE":
            IncrementClassState($player, $CS_NumFusedIce);
            break;
          case "LIGHTNING":
            IncrementClassState($player, $CS_NumFusedLightning);
            break;
          default:
            break;
        }
        AppendClassState($player, $CS_AdditionalCosts, $elements);
        CurrentTurnFuseEffects($player, $element);
        AuraFuseEffects($player, $element);
        $lastPlayed[3] = (GetClassState($player, $CS_AdditionalCosts) == HasFusion($card) || IsAndOrFuse($card) ? "FUSED" : "UNFUSED");
      }
      return $lastResult;
    case "SUBPITCHVALUE":
      return $parameter - PitchValue($lastResult);
    case "BUFFARCANE":
      AddArcaneBonus($parameter, $player);
      return $parameter;
    case "SHIVER":
      $arsenal = &GetArsenal($player);
      switch ($lastResult) {
        case "1_Attack":
          WriteLog("Shiver gives the arrow +1.");
          AddCurrentTurnEffect("ELE033-1", $player, "HAND", $arsenal[count($arsenal) - ArsenalPieces() + 5]);
          return 1;
        case "Dominate":
          WriteLog("Shiver gives the arrow Dominate.");
          AddCurrentTurnEffect("ELE033-2", $player, "HAND", $arsenal[count($arsenal) - ArsenalPieces() + 5]);
          return 1;
      }
      return $lastResult;
    case "VOLTAIRE":
      $arsenal = &GetArsenal($player);
      switch ($lastResult) {
        case "1_Attack":
          WriteLog("Voltaire gives the arrow +1.");
          AddCurrentTurnEffect("ELE034-1", $player, "HAND", $arsenal[count($arsenal) - ArsenalPieces() + 5]);
          return 1;
        case "Go_again":
          WriteLog("Voltaire gives the arrow go again.");
          AddCurrentTurnEffect("ELE034-2", $player, "HAND", $arsenal[count($arsenal) - ArsenalPieces() + 5]);
          return 1;
      }
      return $lastResult;
    case "DREADBORE":
      $arsenal = &GetArsenal($player);
      AddCurrentTurnEffect($parameter, $player, "HAND", $arsenal[count($arsenal) - ArsenalPieces() + 5]);
      return 1;
    case "AZALEA":
      $arsenal = &GetArsenal($player);
      AddCurrentTurnEffect($parameter, $player, "DECK", $arsenal[count($arsenal) - ArsenalPieces() + 5]);
      return 1;
    case "BULLEYESBRACERS":
      $arsenal = &GetArsenal($player);
      AddCurrentTurnEffect($parameter, $player, "HAND", $arsenal[count($arsenal) - ArsenalPieces() + 5]);
      return 1;
    case "AWAKENINGTOKENS":
      $num = GetHealth($player == 1 ? 2 : 1) - GetHealth($player);
      for ($i = 0; $i < $num; ++$i) {
        PlayAura("WTR075", $player);
      }
      return 1;
    case "DIMENXXIONALGATEWAY":
      if (ClassContains($lastResult, "RUNEBLADE", $player)) DealArcane(1, 0, "PLAYCARD", "MON161", true); //TODO: Not totally correct
      if (TalentContains($lastResult, "SHADOW", $player)) {
        PrependDecisionQueue("SHOWBANISHEDCARD", $player, "-", 1);
        PrependDecisionQueue("MULTIBANISH", $player, "DECK,-", 1);
        PrependDecisionQueue("MULTIREMOVEDECK", $player, "<-", 1);
        PrependDecisionQueue("FINDINDICES", $player, "TOPDECK", 1);
        PrependDecisionQueue("NOPASS", $player, "-", 1);
        PrependDecisionQueue("YESNO", $player, "if_you_want_to_banish_the_card", 1);
      }
      return $lastResult;
    case "INVERTEXISTENCE":
      $cards = explode(",", $lastResult);
      $numAA = 0;
      $numNAA = 0;
      for ($i = 0; $i < count($cards); ++$i) {
        $type = CardType($cards[$i]);
        if ($type == "AA") ++$numAA;
        else if ($type == "A") ++$numNAA;
      }
      if ($numAA == 1 && $numNAA == 1) DealArcane(2, 0, "PLAYCARD", "MON158", true, $player);
      return $lastResult;
    case "ROUSETHEANCIENTS":
      $cards = (is_array($lastResult) ? $lastResult : explode(",", $lastResult));
      $totalAV = 0;
      for ($i = 0; $i < count($cards); ++$i) {
        $totalAV += AttackValue($cards[$i]);
      }
      if ($totalAV >= 13) {
        AddCurrentTurnEffect("MON247", $player);
        WriteLog(CardLink("MON247", "MON247") . " got +7 and go again.");
      }
      return $lastResult;
    case "BEASTWITHIN":
      $deck = &GetDeck($player);
      if (count($deck) == 0) {
        LoseHealth(9999, $player);
        WriteLog("Your deck has no cards, so " . CardLink("CRU007", "CRU007") . " continues damaging you until you die.");
        return 1;
      }
      $card = array_shift($deck);
      LoseHealth(1, $player);
      if (AttackValue($card) >= 6) {
        WriteLog(CardLink("CRU007", "CRU007") . " banished " . CardLink($card, $card) . " and was added to hand.");
        BanishCardForPlayer($card, $player, "DECK", "-");
        $banish = &GetBanish($player);
        RemoveBanish($player, count($banish) - BanishPieces());
        AddPlayerHand($card, $player, "BANISH");
      } else {
        WriteLog(CardLink("CRU007", "CRU007") . " banished " . CardLink($card, $card) . ".");
        BanishCardForPlayer($card, $player, "DECK", "-");
        PrependDecisionQueue("BEASTWITHIN", $player, "-");
      }
      return 1;
    case "CROWNOFDICHOTOMY":
      $lastType = CardType($lastResult);
      $indicesParam = ($lastType == "A" ? "GYCLASSAA,RUNEBLADE" : "GYCLASSNAA,RUNEBLADE");
      PrependDecisionQueue("REVEALCARDS", $player, "-", 1);
      PrependDecisionQueue("DECKCARDS", $player, "0", 1);
      PrependDecisionQueue("MULTIADDTOPDECK", $player, "-", 1);
      PrependDecisionQueue("MULTIREMOVEDISCARD", $player, "-", 1);
      PrependDecisionQueue("CHOOSEDISCARD", $player, "<-", 1);
      PrependDecisionQueue("FINDINDICES", $player, $indicesParam);
      return 1;
    case "BECOMETHEARKNIGHT":
      $lastType = CardType($lastResult);
      $indicesParam = ($lastType == "A" ? "DECKCLASSAA,RUNEBLADE" : "DECKCLASSNAA,RUNEBLADE");
      PrependDecisionQueue("MULTIADDHAND", $player, "-", 1);
      PrependDecisionQueue("REVEALCARDS", $player, "-", 1);
      PrependDecisionQueue("MAYCHOOSEDECK", $player, "<-", 1);
      PrependDecisionQueue("FINDINDICES", $player, $indicesParam);
      return 1;
    case "GENESIS":
      if (TalentContains($lastResult, "LIGHT", $player)) Draw($player);
      if (ClassContains($lastResult, "ILLUSIONIST", $player)) PlayAura("MON104", $player);
      return 1;
    case "GIVEACTIONGOAGAIN":
      if ($parameter == "A") SetClassState($player, $CS_NextNAACardGoAgain, 1);
      else if ($parameter == "AA") GiveAttackGoAgain();
      return 1;
    case "ADDMYRESOURCES":
      AddResourceCost($player, $parameter);
      return $parameter;
    case "PROCESSATTACKTARGET":
      $combatChainState[$CCS_AttackTarget] = $lastResult;
      $mzArr = explode("-", $lastResult);
      $zone = &GetMZZone($defPlayer, $mzArr[0]);
      $uid = "-";
      switch($mzArr[0])
      {
        case "MYALLY": case "THEIRALLY": $uid = $zone[$mzArr[1]+5]; break;
        case "MYAURAS": case "THEIRAURAS": $uid = $zone[$mzArr[1]+6]; break;
        default: break;
      }
      $combatChainState[$CCS_AttackTargetUID] = $uid;
      WriteLog(GetMZCardLink($defPlayer, $lastResult) . " was chosen as the attack target.");
      return 1;
    case "STARTTURNABILITIES":
      StartTurnAbilities();
      return 1;
    case "DRAWTOINTELLECT":
      $deck = &GetDeck($player);
      $hand = &GetHand($player);
      $char = &GetPlayerCharacter($player);
      for ($i = 0; $i < CharacterIntellect($char[0]); ++$i) {
        array_push($hand, array_shift($deck));
      }
      return 1;
    case "REMOVELAST":
      if ($lastResult == "") return $parameter;
      $cards = explode(",", $parameter);
      for ($i = 0; $i < count($cards); ++$i) {
        if ($cards[$i] == $lastResult) {
          unset($cards[$i]);
          $cards = array_values($cards);
          break;
        }
      }
      return implode(",", $cards);
    case "ROLLDIE":
      $roll = RollDie($player, true, $parameter == "1");
      return $roll;
    case "SETCOMBATCHAINSTATE":
      $combatChainState[$parameter] = $lastResult;
      return $lastResult;
    case "BANISHADDMODIFIER":
      $banish = &GetBanish($player);
      $banish[$lastResult + 1] = $parameter;
      return $lastResult;
    case "SETLAYERTARGET":
      global $layers;
      for($i=0; $i<count($layers); $i+=LayerPieces())
      {
        if($layers[$i] == $parameter)
        {
          $layers[$i+3] = $lastResult;
        }
      }
      return $lastResult;
    case "SHOWSELECTEDTARGET":
      if (substr($lastResult, 0, 5) == "THEIR") {
        $otherP = ($player == 1 ? 2 : 1);
        WriteLog(GetMZCardLink($otherP, $lastResult) . " was targeted");
      } else {
        WriteLog(GetMZCardLink($player, $lastResult) . " was targeted");
      }
      return $lastResult;
    case "MULTIZONEFORMAT":
      return SearchMultizoneFormat($lastResult, $parameter);
    case "MULTIZONEDESTROY":
      $params = explode("-", $lastResult);
      $source = $params[0];
      $index = $params[1];
      $otherP = ($player == 1 ? 2 : 1);
      switch ($source) {
        case "MYAURAS":
          DestroyAura($player, $index);
          break;
        case "THEIRAURAS":
          DestroyAura($otherP, $index);
          break;
        case "MYHAND":
          DiscardIndex($player, $index);
          break;
        case "MYITEMS":
          DestroyItemForPlayer($player, $index);
          break;
        case "MYCHAR":
          DestroyCharacter($player, $index);
          break;
        default:
          break;
      }
      return $lastResult;
    case "MULTIZONEREMOVE":
      $params = explode("-", $lastResult);
      $source = $params[0];
      $index = $params[1];
      $otherP = ($player == 1 ? 2 : 1);
      switch ($source) {
        case "MYARS":
          $arsenal = &GetArsenal($player);
          $card = $arsenal[$index];
          RemoveFromArsenal($player, $index);
          break;
        case "MYHAND":
          $hand = &GetHand($player);
          $card = $hand[$index];
          RemoveCard($player, $index);
          break;
        case "DISCARD":
        case "MYDISCARD":
          $discard = &GetDiscard($player);
          $card = $discard[$index];
          RemoveGraveyard($player, $index);
          break;
        default:
          break;
      }
      return $card;
    case "MULTIZONETOKENCOPY":
      $params = explode("-", $lastResult);
      $source = $params[0];
      $index = $params[1];
      switch ($source) {
        case "MYAURAS":
          TokenCopyAura($player, $index);
          break;
        default:
          break;
      }
      return $lastResult;
    case "COUNTITEM":
      return CountItem($parameter, $player);
    case "FINDANDDESTROYITEM":
      $params = explode("-", $parameter);
      $cardID = $params[0];
      $number = $params[1];
      for ($i = 0; $i < $number; ++$i) {
        $index = GetItemIndex($cardID, $player);
        if ($index != -1) DestroyItemForPlayer($player, $index);
      }
      return $lastResult;
    case "DESTROYITEM":
      DestroyItemForPlayer($player, $parameter);
      return $lastResult;
    case "COUNTPARAM":
      $array = explode(",", $parameter);
      return count($array) . "-" . $parameter;
    case "VALIDATEALLSAMENAME":
      if ($parameter == "DECK") {
        $zone = &GetDeck($player);
      }
      if (count($lastResult) == 0) return "PASS";
      $name = CardName($zone[$lastResult[0]]);
      for ($i = 1; $i < count($lastResult); ++$i) {
        if (CardName($zone[$lastResult[$i]]) != $name) {
          WriteLog("You selected cards that do not have the same name. Reverting gamestate prior to that effect.");
          RevertGamestate();
          return "PASS";
        }
      }
      return $lastResult;
    case "PREPENDLASTRESULT":
      return $parameter . $lastResult;
    case "APPENDLASTRESULT":
      return $lastResult . $parameter;
    case "LASTRESULTPIECE":
      $pieces = explode("-", $lastResult);
      return $pieces[$parameter];
    case "IMPLODELASTRESULT":
      return implode($parameter, $lastResult);
    case "VALIDATECOUNT":
      if (count($lastResult) != $parameter) {
        WriteLog("The count from the last step is incorrect. Reverting gamestate prior to that effect.");
        RevertGamestate();
        return "PASS";
      }
      return $lastResult;
    case "SOULHARVEST":
      $numBD = 0;
      $discard = GetDiscard($player);
      for ($i = 0; $i < count($lastResult); ++$i) {
        if (HasBloodDebt($discard[$lastResult[$i]])) ++$numBD;
      }
      if ($numBD > 0) AddCurrentTurnEffect("MON198," . $numBD, $player);
      return $lastResult;
    case "ADDATTACKCOUNTERS":
      $lastResults = explode("-", $lastResult);
      $zone = $lastResults[0];
      $zoneDS = &GetMZZone($player, $zone);
      $index = $lastResults[1];
      if ($zone == "MYCHAR" || $zone == "THEIRCHAR") $zoneDS[$index + 3] += $parameter;
      else if ($zone == "MYAURAS" || $zone == "THEIRAURAS") $zoneDS[$index + 3] += $parameter;
      return $lastResult;
    case "FINALIZEDAMAGE":
      $params = explode(",", $parameter);
      return FinalizeDamage($player, $lastResult, $params[0], $params[1], $params[2]);
    case "KORSHEM":
      switch ($lastResult) {
        case "Gain_a_resource":
          GainResources($player, 1);
          return 1;
        case "Gain_a_life":
          GainHealth(1, $player);
          return 2;
        case "1_Attack":
          AddCurrentTurnEffect("ELE000-1", $player);
          return 3;
        case "1_Defense":
          AddCurrentTurnEffect("ELE000-2", $player);
          return 4;
      }
      return $lastResult;
    case "SETDQVAR":
      $dqVars[$parameter] = $lastResult;
      return $lastResult;
    case "INCDQVAR":
      $dqVars[$parameter] += $lastResult;
      return $lastResult;
    case "DECDQVAR":
      $dqVars[$parameter] -= 1;
      return $lastResult;
    case "DIVIDE":
      return floor($lastResult / $parameter);
    case "DQVARPASSIFSET":
      if ($dqVars[$parameter] == "1") return "PASS";
      return "PROCEED";
    case "LORDSUTCLIFFE":
      LordSutcliffeAfterDQ($player, $parameter);
      return $lastResult;
    // case "APPROVEMANUALMODE":
    //   ApproveManualMode($player);
    //   return $lastResult;
    case "BINGO":
      if ($lastResult == "") WriteLog("No card was revealed for " . CardLink("EVR156","EVR156") . ".");
      $cardType = CardType($lastResult);
      if ($cardType == "AA") {
        WriteLog(CardLink("EVR156","EVR156") . " gained go again.");
        GiveAttackGoAgain();
      } else if ($cardType == "A") {
        WriteLog(CardLink("EVR156","EVR156") . " draw a card.");
        Draw($player);
      } else WriteLog(CardLink("EVR156","EVR156") . "... did not hit the mark.");
      return $lastResult;
    case "ADDCARDTOCHAIN":
      AddCombatChain($lastResult, $player, $parameter, 0);
      return $lastResult;
    case "ATTACKWITHIT":
      PlayCardSkipCosts($lastResult, "DECK");
      return $lastResult;
    case "EVENBIGGERTHANTHAT":
      $deck = &GetDeck($player);
      if (RevealCards($deck[0], $player) && AttackValue($deck[0]) > GetClassState(($player == 1 ? 1 : 2), $CS_DamageDealt)) {
        WriteLog("Even Bigger Than That! draw a card and create a Quicken token.");
        Draw($player);
        PlayAura("WTR225", $player);
      }
      return $lastResult;
    case "BLESSINGOFFOCUS":
      $deck = &GetDeck($mainPlayer);
      if (RevealCards($deck[0], $mainPlayer) && CardSubType($deck[0]) == "Arrow") {
        if (!ArsenalFull($mainPlayer)) AddArsenal($deck[0], $mainPlayer, "DECK", "UP", 1);
        else WriteLog("Your arsenal is full, so you cannot put an arrow in your arsenal.");
      }
      return $lastResult;
    case "KRAKENAETHERVEIN":
      if ($lastResult > 0) {
        for ($i = 0; $i < $lastResult; ++$i) Draw($player);
      }
      return $lastResult;
    case "HEAVE":
      PrependDecisionQueue("PAYRESOURCES", $player, "<-");
      AddArsenal($lastResult, $player, "HAND", "UP");
      $heaveValue = HeaveValue($lastResult);
      for ($i = 0; $i < $heaveValue; ++$i) {
        PlayAura("WTR075", $player);
      }
      WriteLog("You must pay " . HeaveValue($lastResult) . " resources to heave this.");
      return HeaveValue($lastResult);
    case "POTIONOFLUCK":
      $arsenal = &GetArsenal($player);
      $hand = &GetHand($player);
      $deck = &GetDeck($player);
      $sizeToDraw = count($hand) + count($arsenal) / ArsenalPieces();
      $i = 0;
      while (count($hand) > 0) {
        array_push($deck, $hand[$i]);
        unset($hand[$i]);
        ++$i;
      }
      for ($i = 0; $i < $sizeToDraw; $i++) {
        PrependDecisionQueue("DRAW", $currentPlayer, "-", 1);
      }
      PrependDecisionQueue("FULLARSENALTODECK", $currentPlayer, "-", 1);
      PrependDecisionQueue("SHUFFLEDECK", $currentPlayer, "-", 1);
      WriteLog(CardLink("EVR187","EVR187") . " shuffled your hand and arsenal into your deck and draw " . $sizeToDraw . " cards.");
      return $lastResult;
    case "BRAVOSTARSHOW":
      $hand = &GetHand($player);
      $cards = "";
      $hasLightning = false;
      $hasIce = false;
      $hasEarth = false;
      for ($i = 0; $i < count($lastResult); ++$i) {
        if ($cards != "") $cards .= ",";
        $card = $hand[$lastResult[$i]];
        if (TalentContains($card, "LIGHTNING")) $hasLightning = true;
        if (TalentContains($card, "ICE")) $hasIce = true;
        if (TalentContains($card, "EARTH")) $hasEarth = true;
        $cards .= $card;
      }
      if (RevealCards($cards, $player) && $hasLightning && $hasIce && $hasEarth) {
        WriteLog("Bravo, Star of the Show gives the next attack with cost 3 or more +2, Dominate, and go again.");
        AddCurrentTurnEffect("EVR017", $player);
      }
      return $lastResult;
    case "SETDQCONTEXT":
      $dqState[4] = implode("_", explode(" ", $parameter));
      return $lastResult;
    case "AFTERDIEROLL":
      AfterDieRoll($player);
      return $lastResult;
    case "PICKACARD":
      $hand = &GetHand(($player == 1 ? 2 : 1));
      $rand = GetRandom(0, count($hand) - 1);
      if (RevealCards($hand[$rand], $player) && CardName($hand[$dqVars[0]]) == CardName($hand[$rand])) {
        WriteLog("Bingo! Your opponent tossed you a silver.");
        PutItemIntoPlayForPlayer("EVR195", $player);
      }
      return $lastResult;
    case "TWINTWISTERS":
      switch ($lastResult) {
        case "Hit_Effect":
          WriteLog("If Twin Twisters hits, the next attack gets +1 power.");
          AddCurrentTurnEffect($parameter . "-1", $player);
          return 1;
        case "1_Attack":
          WriteLog("Twin Twisters gets +1 power.");
          AddCurrentTurnEffect($parameter . "-2", $player);
          return 2;
      }
      return $lastResult;
    case "AETHERWILDFIRE":
      AddCurrentTurnEffect("EVR123," . $lastResult, $player);
      return $lastResult;
    case "SURGENTAETHERTIDE":
      AddCurrentTurnEffect("DYN192," . $lastResult, $player);
      return $lastResult;
    case "CLEAREFFECTCONTEXT":
      SetClassState($currentPlayer, $CS_EffectContext, "-");
      return $lastResult;
    case "MICROPROCESSOR":
      $deck = &GetDeck($player); // TODO: Once per turn restriction
      switch ($lastResult) {
        case "Opt":
          WriteLog("Player " . $player . " Opt 1 with " . Cardlink("EVR070","EVR070") . ".");
          Opt("EVR070", 1);
          break;
        case "Draw_then_top_deck":
          if (count($deck) > 0) {
            WriteLog("Player " . $player . " draw a card then put a card on top of their deck with " . Cardlink("EVR070", "EVR070") . ".");
            Draw($player);
            HandToTopDeck($player);
          }
          break;
        case "Banish_top_deck":
          if (count($deck) > 0) {
            $card = array_shift($deck);
            BanishCardForPlayer($card, $player, "DECK", "-");
            WriteLog("Player " . $player . " banish the top card of their deck with " . Cardlink("EVR070", "EVR070") . ".");
            WriteLog(CardLink($card, $card) . " was banished.");
          }
          break;
        default:
          break;
      }
      return "";
    case "TALISMANOFCREMATION":
      $discard = &GetDiscard($player);
      $cardName = CardName($discard[$lastResult]);
      $count = 0;
      for ($i = count($discard) - DiscardPieces(); $i >= 0; $i -= DiscardPieces()) {
        if (CardName($discard[$i]) == $cardName) {
          BanishCardForPlayer($discard[$i], $player, "GY");
          RemoveGraveyard($player, $i);
          ++$count;
        }
      }
      WriteLog("Talisman of Cremation banished " . $count . " cards named " . $cardName . ".");
      return "";
    case "SCOUR":
      WriteLog("Scour deals " . $parameter . " arcane damage.");
      DealArcane($parameter, 0, "PLAYCARD", "EVR124", true, $player, resolvedTarget: ($player == 1 ? 2 : 1));
      return "";
    case "KNICKKNACK":
      for ($i = 0; $i < ($dqVars[0] + 1); ++$i) {
        PrependDecisionQueue("PUTPLAY", $player, "-", 1);
        PrependDecisionQueue("MAYCHOOSEDECK", $player, "<-", 1);
        PrependDecisionQueue("FINDINDICES", $player, "KNICKKNACK");
      }
      return "";
    case "CASHOUTCONTINUE":
      PrependDecisionQueue("CASHOUTCONTINUE", $currentPlayer, "-", 1);
      PrependDecisionQueue("PUTPLAY", $currentPlayer, "-", 1);
      PrependDecisionQueue("PASSPARAMETER", $currentPlayer, "EVR195", 1);
      PrependDecisionQueue("MULTIZONEDESTROY", $currentPlayer, "-", 1);
      PrependDecisionQueue("MAYCHOOSEMULTIZONE", $currentPlayer, "<-", 1);
      PrependDecisionQueue("FINDINDICES", $currentPlayer, "CASHOUT");
      return "";
    case "SETABILITYTYPE":
      $lastPlayed[2] = $lastResult;
      $index = GetAbilityIndex($parameter, GetClassState($player, $CS_CharacterIndex), $lastResult);
      SetClassState($player, $CS_AbilityIndex, $index);
      $names = explode(",", GetAbilityNames($parameter, GetClassState($player, $CS_CharacterIndex)));
      WriteLog(implode(" ", explode("_", $names[$index])) . " ability was chosen.");
      return $lastResult;
    case "ENCASEDAMAGE":
      $character = &GetPlayerCharacter($player);
      $character[8] = 1;
      for ($i = CharacterPieces(); $i < count($character); $i += CharacterPieces()) {
        if (CardType($character[$i]) == "E" && $character[$i + 1] != 0) $character[$i + 8] = 1;
      }
      return $lastResult;
    case "MZSTARTTURNABILITY":
      $params = explode("-", $lastResult);
      $zone = &GetMZZone($player, $params[0]);
      $cardID = $zone[$params[1]];
      MZStartTurnAbility($cardID, $lastResult);
      return "";

    case "MZDAMAGE":
      $lastResultArr = explode(",", $lastResult);
      $params = explode(",", $parameter);
      $otherPlayer = ($player == 1 ? 2 : 1);
      for ($i = 0; $i < count($lastResultArr); ++$i) {
        $mzIndex = explode("-", $lastResultArr[$i]);
        switch ($mzIndex[0]) {
          case "MYCHAR":
            DamageTrigger($player, $params[0], $params[1]);
            break;
          case "THEIRCHAR":
            DamageTrigger($otherPlayer, $params[0], $params[1]);
            break;
          case "MYALLY":
            DamageTrigger($player, $params[0], $params[1]);
            break;
          case "THEIRALLY":
            DamageTrigger($otherPlayer, $params[0], $params[1]);
            break;
          default:
            break;
        }
      }
      return $lastResult;

    case "MZDESTROY":
      $lastResultArr = explode(",", $lastResult);
      $params = explode(",", $parameter);
      $otherPlayer = ($player == 1 ? 2 : 1);
      for ($i = 0; $i < count($lastResultArr); ++$i) {
        $mzIndex = explode("-", $lastResultArr[$i]);
        switch ($mzIndex[0]) {
          case "MYALLY":
            DestroyAlly($player, $mzIndex[1]);
            break;
          case "THEIRALLY":
            DestroyAlly($otherPlayer, $mzIndex[1]);
            break;
          case "MYAURAS":
            DestroyAura($player, $mzIndex[1]);
            break;
          case "THEIRAURAS":
            DestroyAura($otherPlayer, $mzIndex[1]);
            break;
          case "MYITEMS":
            DestroyItemForPlayer($player, $mzIndex[1]);
            break;
          case "THEIRITEMS":
            DestroyItemForPlayer($otherPlayer, $mzIndex[1]);
            break;
          case "LANDMARK":
            DestroyLandmark($mzIndex[1]);
            break;
          default:
            break;
        }
      }
      return $lastResult;
    case "MZUNDESTROY":
      $lastResultArr = explode(",", $lastResult);
      $params = explode(",", $parameter);
      $otherPlayer = ($player == 1 ? 2 : 1);
      for ($i = 0; $i < count($lastResultArr); ++$i) {
        $mzIndex = explode("-", $lastResultArr[$i]);
        switch ($mzIndex[0]) {
          case "MYCHAR":
            UndestroyCharacter($player, $mzIndex[1]);
            break;
          default: break;
        }
      }
      break;
    case "MZBANISH":
      $lastResultArr = explode(",", $lastResult);
      $params = explode(",", $parameter);
      $otherPlayer = ($player == 1 ? 2 : 1);
      for ($i = 0; $i < count($lastResultArr); ++$i) {
        $mzIndex = explode("-", $lastResultArr[$i]);
        switch ($mzIndex[0]) {
          case "MYDISCARD":
            $zone = &GetMZZone($player, $mzIndex[0]);
            BanishCardForPlayer($zone[$mzIndex[1]], $player, $params[0], $params[1], $params[2]);
            break;
          case "THEIRDISCARD":
            $zone = &GetMZZone($otherPlayer, $mzIndex[0]);
            BanishCardForPlayer($zone[$mzIndex[1]], $otherPlayer, $params[0], $params[1], $params[2]);
            break;
          case "MYHAND":
            $zone = &GetMZZone($player, $mzIndex[0]);
            BanishCardForPlayer($zone[$mzIndex[1]], $player, $params[0], $params[1], $params[2]);
            break;
          case "THEIRHAND":
            $zone = &GetMZZone($otherPlayer, $mzIndex[0]);
            BanishCardForPlayer($zone[$mzIndex[1]], $otherPlayer, $params[0], $params[1], $params[2]);
            break;
          case "MYARS":
            $zone = &GetMZZone($player, $mzIndex[0]);
            BanishCardForPlayer($zone[$mzIndex[1]], $player, $params[0], $params[1], $params[2]);
            break;
          case "THEIRARS":
            $zone = &GetMZZone($otherPlayer, $mzIndex[0]);
            BanishCardForPlayer($zone[$mzIndex[1]], $otherPlayer, $params[0], $params[1], $params[2]);
            break;
          case "THEIRAURAS":
            $zone = &GetMZZone($otherPlayer, $mzIndex[0]);
            BanishCardForPlayer($zone[$mzIndex[1]], $otherPlayer, $params[0], $params[1], $params[2]);
            break;
          default:
            break;
        }
      }
      WriteLog(CardLink($zone[$mzIndex[1]], $zone[$mzIndex[1]]) . " was banished.");
      return $lastResult;
    case "MZREMOVE":
      $lastResultArr = explode(",", $lastResult);
      $otherPlayer = ($player == 1 ? 2 : 1);
      for ($i = 0; $i < count($lastResultArr); ++$i) {
        $mzIndex = explode("-", $lastResultArr[$i]);
        switch ($mzIndex[0]) {
          case "MYDISCARD":
            RemoveGraveyard($player, $mzIndex[1]);
            break;
          case "THEIRDISCARD":
            RemoveGraveyard($otherPlayer, $mzIndex[1]);
            break;
          case "MYBANISH":
            RemoveBanish($player, $mzIndex[1]);
            break;
          case "THEIRBANISH":
            RemoveBanish($otherPlayer, $mzIndex[1]);
            break;
          case "MYARS":
            RemoveFromArsenal($player, $mzIndex[1]);
            break;
          case "THEIRARS":
            RemoveFromArsenal($otherPlayer, $mzIndex[1]);
            break;
          case "MYPITCH":
            RemovefromPitch($player, $mzIndex[1]);
            break;
          case "THEIRPITCH":
            RemovefromPitch($otherPlayer, $mzIndex[1]);
            break;
          case "MYHAND":
            RemoveCard($player, $mzIndex[1]);
            break;
          case "THEIRHAND":
            RemoveCard($otherPlayer, $mzIndex[1]);
            break;
          case "THEIRAURAS":
            RemoveAura($otherPlayer, $mzIndex[1]);
            break;
          default:
            break;
        }
      }
      return $lastResult;
    case "MZADDBOTDECK":
      $lastResultArr = explode(",", $lastResult);
      $otherPlayer = ($player == 1 ? 2 : 1);
      $params = explode(",", $parameter);
      for ($i = 0; $i < count($lastResultArr); ++$i) {
        $mzIndex = explode("-", $lastResultArr[$i]);
        switch ($mzIndex[0]) {
          case "MYDISCARD":
            $deck = &GetDeck($player);
            AddBottomDeck($deck[$mzIndex[1]], $player, $params[0]);
            break;
          case "THEIRDISCARD":
            $deck = &GetDeck($otherPlayer);
            AddBottomDeck($deck[$mzIndex[1]], $otherPlayer, $params[0]);
            break;
          case "MYARS":
            $arsenal = &GetArsenal($player);
            AddBottomDeck($arsenal[$mzIndex[1]], $player, $params[0]);
            break;
          case "THEIRARS":
            $arsenal = &GetArsenal($otherPlayer);
            AddBottomDeck($arsenal[$mzIndex[1]], $otherPlayer, $params[0]);
            break;
          case "MYPITCH":
            $pitch = &GetPitch($player);
            AddBottomDeck($pitch[$mzIndex[1]], $player, $params[0]);
            break;
          case "THEIRDISCARD":
            $pitch = &GetPitch($otherPlayer);
            AddBottomDeck($pitch[$mzIndex[1]], $otherPlayer, $params[0]);
            break;
          case "MYHAND":
            $hand = &GetHand($player);
            AddBottomDeck($hand[$mzIndex[1]], $player, $params[0]);
            break;
          case "THEIRHAND":
            $hand = &GetHand($otherPlayer);
            AddBottomDeck($hand[$mzIndex[1]], $otherPlayer, $params[0]);
            break;
          default:
            break;
        }
      }
      return $lastResult;
    case "MZADDTOPDECK":
      $lastResultArr = explode(",", $lastResult);
      $otherPlayer = ($player == 1 ? 2 : 1);
      $params = explode(",", $parameter);
      for ($i = 0; $i < count($lastResultArr); ++$i) {
        $mzIndex = explode("-", $lastResultArr[$i]);
        switch ($mzIndex[0]) {
          case "MYDISCARD":
            $deck = &GetDeck($player);
            AddTopDeck($deck[$mzIndex[1]], $player, $params[0]);
            break;
          case "THEIRDISCARD":
            $deck = &GetDeck($otherPlayer);
            AddTopDeck($deck[$mzIndex[1]], $otherPlayer, $params[0]);
            break;
          case "MYARS":
            $arsenal = &GetArsenal($player);
            AddTopDeck($arsenal[$mzIndex[1]], $player, $params[0]);
            break;
          case "THEIRARS":
            $arsenal = &GetArsenal($otherPlayer);
            AddTopDeck($arsenal[$mzIndex[1]], $otherPlayer, $params[0]);
            break;
          case "MYPITCH":
            $pitch = &GetPitch($player);
            AddTopDeck($pitch[$mzIndex[1]], $player, $params[0]);
            break;
          case "THEIRDISCARD":
            $pitch = &GetPitch($otherPlayer);
            AddTopDeck($pitch[$mzIndex[1]], $otherPlayer, $params[0]);
            break;
          case "MYHAND":
            $hand = &GetHand($player);
            AddTopDeck($hand[$mzIndex[1]], $player, $params[0]);
            break;
          case "THEIRHAND":
            $hand = &GetHand($otherPlayer);
            AddTopDeck($hand[$mzIndex[1]], $otherPlayer, $params[0]);
            break;
          default:
            break;
        }
      }
      return $lastResult;
    case "MZDISCARD":
      $lastResultArr = explode(",", $lastResult);
      $otherPlayer = ($player == 1 ? 2 : 1);
      $params = explode(",", $parameter);
      for ($i = 0; $i < count($lastResultArr); ++$i) {
        $mzIndex = explode("-", $lastResultArr[$i]);
        switch ($mzIndex[0]) {
          case "MYDISCARD":
            $deck = &GetDeck($player);
            AddGraveyard($deck[$mzIndex[1]], $player, $params[0]);
            WriteLog(CardLink($deck[$mzIndex[1]], $deck[$mzIndex[1]]) . " was discarded");
            break;
          case "THEIRDISCARD":
            $deck = &GetDeck($otherPlayer);
            AddGraveyard($deck[$mzIndex[1]], $otherPlayer, $params[0]);
            WriteLog(CardLink($deck[$mzIndex[1]], $deck[$mzIndex[1]]) . " was discarded");
            break;
          case "MYARS":
            $arsenal = &GetArsenal($player);
            AddGraveyard($arsenal[$mzIndex[1]], $player, $params[0]);
            WriteLog(CardLink($arsenal[$mzIndex[1]], $arsenal[$mzIndex[1]]) . " was discarded");
            break;
          case "THEIRARS":
            $arsenal = &GetArsenal($otherPlayer);
            AddGraveyard($arsenal[$mzIndex[1]], $otherPlayer, $params[0]);
            WriteLog(CardLink($arsenal[$mzIndex[1]], $arsenal[$mzIndex[1]]) . " was discarded");
            break;
          case "MYPITCH":
            $pitch = &GetPitch($player);
            AddGraveyard($pitch[$mzIndex[1]], $player, $params[0]);
            WriteLog(CardLink($pitch[$mzIndex[1]], $pitch[$mzIndex[1]]) . " was discarded");
            break;
          case "THEIRDISCARD":
            $pitch = &GetPitch($otherPlayer);
            AddGraveyard($pitch[$mzIndex[1]], $otherPlayer, $params[0]);
            WriteLog(CardLink($pitch[$mzIndex[1]], $pitch[$mzIndex[1]]) . " was discarded");
            break;
          case "MYHAND":
            $hand = &GetHand($player);
            AddGraveyard($hand[$mzIndex[1]], $player, $params[0]);
            WriteLog(CardLink($hand[$mzIndex[1]], $hand[$mzIndex[1]]) . " was discarded");
            break;
          case "THEIRHAND":
            $hand = &GetHand($otherPlayer);
            AddGraveyard($hand[$mzIndex[1]], $otherPlayer, $params[0]);
            WriteLog(CardLink($hand[$mzIndex[1]], $hand[$mzIndex[1]]) . " was discarded");
            break;
          default:
            break;
        }
      }
      return $lastResult;
    case "TRANSFORM":
      return "ALLY-" . ResolveTransform($player, $lastResult, $parameter);
    case "TRANSFORMPERMANENT":
      return "PERMANENT-" . ResolveTransformPermanent($player, $lastResult, $parameter);
    case "TRANSFORMAURA":
      return "AURA-" . ResolveTransformAura($player, $lastResult, $parameter);
    case "MZGETUNIQUEID":
      $params = explode("-", $lastResult);
      $zone = &GetMZZone($player, $params[0]);
      switch ($params[0]) {
        case "ALLY":
          return $zone[$params[1] + 5];
        case "BANISH":
          return $zone[$params[1] + 2];
      }
      return "-1";
    case "MZGETCARDID":
      global $mainPlayer, $defPlayer;
      $rv = "-1";
      $params = explode("-", $lastResult);
      if(substr($params[0], 0, 5) == "THEIR"){
        $zone = &GetMZZone($defPlayer, $params[0]);
      } else $zone = &GetMZZone($mainPlayer, $params[0]);
      $rv = $zone[$params[1]];
      return $rv;
    case "MZGETCARDINDEX":
      global $mainPlayer, $defPlayer;
      $rv = "-1";
      $params = explode("-", $lastResult);
      if (substr($params[0], 0, 5) == "THEIR") {
        $zone = &GetMZZone($defPlayer, $params[0]);
      } else $zone = &GetMZZone($mainPlayer, $params[0]);
      switch ($params[0]) {
        case "MYCHAR":
          $rv = $params[1];
        case "THEIRCHAR":
          $rv = $params[1];
      }
      return $rv;
    case "SIFT":
      $numCards = SearchCount($lastResult);
      for ($i = 0; $i < $numCards; ++$i) {
        Draw($player);
      }
      return "1";
    case "CCFILTERTYPE":
      if ($lastResult == "" || $lastResult == "PASS") return "PASS";
      $arr = explode(",", $lastResult);
      $rv = [];
      for ($i = 0; $i < count($arr); ++$i) {
        if (CardType($combatChain[$arr[$i]]) != $parameter) array_push($rv, $arr[$i]);
      }
      $rv = implode(",", $rv);
      return ($rv == "" ? "PASS" : $rv);
    case "CCFILTERPLAYER":
      if ($lastResult == "" || $lastResult == "PASS") return "PASS";
      $arr = explode(",", $lastResult);
      $rv = [];
      for ($i = 0; $i < count($arr); ++$i) {
        if ($combatChain[$arr[$i] + 1] != $parameter) array_push($rv, $arr[$i]);
      }
      $rv = implode(",", $rv);
      return ($rv == "" ? "PASS" : $rv);
    case "ITEMGAINCONTROL":
      $otherPlayer = ($player == 1 ? 2 : 1);
      StealItem($otherPlayer, $lastResult, $player);
      return $lastResult;
    case "AFTERTHAW":
      $otherPlayer = ($player == 1 ? 2 : 1);
      $params = explode("-", $lastResult);
      if ($params[0] == "MYAURAS") {
        DestroyAura($player, $params[1]);
      } else {
        UnfreezeMZ($player, $params[0], $params[1]);
      }
      return "";
    case "SUCCUMBTOWINTER":
      $params = explode("-", $lastResult);
      $otherPlayer = ($player == 1 ? 2 : 1);
      if ($params[0] == "THEIRALLY") {
        $allies = &GetAllies($otherPlayer);
        WriteLog(CardLink($params[2], $params[2]) . " destroyed your frozen ally.");
        if ($allies[$params[1] + 8] == "1") DestroyAlly($otherPlayer, $params[1]);
      } else {
        DestroyFrozenArsenal($otherPlayer);
        WriteLog(CardLink($params[2], $params[2]) . " destroyed your frozen arsenal card.");
        break;
      }
      return $lastResult;
    case "STARTGAME":
      $inGameStatus = "1";
      $MakeStartTurnBackup = true;
      return 0;
    case "ADDARCANEBONUS":
      AddArcaneBonus($parameter, $player);
      return 0;
    case "QUICKREMATCH":
      $currentTime = round(microtime(true) * 1000);
      SetCachePiece($gameName, 2, $currentTime);
      SetCachePiece($gameName, 3, $currentTime);
      include "MenuFiles/ParseGamefile.php";
      header("Location: " . $redirectPath . "/Start.php?gameName=$gameName&playerID=$playerID");
      exit;
    case "REMATCH":
      global $GameStatus_Rematch, $inGameStatus;
      if($lastResult == "YES") $inGameStatus = $GameStatus_Rematch;
      return 0;
    case "IMPERIALWARHORN":
      $otherPlayer = ($player == 1 ? 2 : 1);
      switch ($lastResult) {
        case "Target_Opponent":
          if (IsRoyal($player)) {
            ImperialWarHorn($player, "THEIR");
          } else {
            ImperialWarHorn($otherPlayer, "MY");
          }
          break;
        case "Target_Both_Heroes":
          if (IsRoyal($player)) {
            ImperialWarHorn($player, "MY");
            ImperialWarHorn($player, "THEIR");
          } else {
            ImperialWarHorn($player, "MY");
            ImperialWarHorn($otherPlayer, "MY");
          }
          break;
        case "Target_Yourself":
          ImperialWarHorn($player, "MY");
          break;
        case "Target_No_Heroes":
          return "";
        default:
          break;
      }
      return "";
    case "CORONETPEAK":
      $otherPlayer = ($player == 1 ? 2 : 1);
      if ($lastResult == "") $lastResult = $parameter;
      switch ($lastResult) {
        case "Target_Opponent":
          AddDecisionQueue("DQPAYORDISCARD", $otherPlayer, "1");
          break;
        case "Target_Yourself":
          AddDecisionQueue("DQPAYORDISCARD", $player, "1");
          break;
        default:
          break;
      }
      return "";
    case "DQPAYORDISCARD":
      PayOrDiscard($player, $parameter);
      return "";
    case "PRY":
      $otherPlayer = ($player == 1 ? 2 : 1);
      $plurial = "";
      switch ($lastResult) {
        case "Target_Opponent":
          $theirHand = &GetHand($otherPlayer);
          if ($player != $mainPlayer) $dqVars[0] = count($theirHand);
          if ($dqVars[0] > 1) $plurial = "s";
          AddDecisionQueue("FINDINDICES", $otherPlayer, "HAND");
          AddDecisionQueue("PREPENDLASTRESULT", $otherPlayer, $dqVars[0] . "-", 1);
          AddDecisionQueue("APPENDLASTRESULT", $otherPlayer, "-" . $dqVars[0], 1);
          AddDecisionQueue("SETDQCONTEXT", $player, "Choose " . $dqVars[0] . " card" . $plurial, 1);
          AddDecisionQueue("MULTICHOOSEHAND", $otherPlayer, "<-", 1);
          AddDecisionQueue("IMPLODELASTRESULT", $otherPlayer, ",", 1);
          AddDecisionQueue("SETDQCONTEXT", $player, "Choose a card", 1);
          AddDecisionQueue("CHOOSETHEIRHAND", $player, "<-", 1);
          AddDecisionQueue("MULTIREMOVEHAND", $otherPlayer, "-", 1);
          AddDecisionQueue("ADDBOTDECK", $otherPlayer, "-", 1);
          AddDecisionQueue("DRAW", $otherPlayer, "-", 1);
          break;
        case "Target_Yourself":
          $myHand = &GetHand($player);
          if ($player != $mainPlayer) $dqVars[0] = count($myHand);
          if ($dqVars[0] > 1) $plurial = "s";
          AddDecisionQueue("FINDINDICES", $player, "HAND");
          AddDecisionQueue("PREPENDLASTRESULT", $player, $dqVars[0] . "-", 1);
          AddDecisionQueue("APPENDLASTRESULT", $player, "-" . $dqVars[0], 1);
          AddDecisionQueue("SETDQCONTEXT", $player, "Choose " . $dqVars[0] . " card" . $plurial, 1);
          AddDecisionQueue("MULTICHOOSEHAND", $player, "<-", 1);
          AddDecisionQueue("IMPLODELASTRESULT", $player, ",", 1);
          AddDecisionQueue("SETDQCONTEXT", $player, "Choose a card", 1);
          AddDecisionQueue("CHOOSEHAND", $player, "<-", 1);
          AddDecisionQueue("MULTIREMOVEHAND", $player, "-", 1);
          AddDecisionQueue("ADDBOTDECK", $player, "-", 1);
          AddDecisionQueue("DRAW", $player, "-", 1);
          break;
        default:
          break;
      }
      return "";
      case "DESTROYFROZENARSENAL":
        DestroyFrozenArsenal($player);
        return "";
      case "RIGHTEOUSCLEANSING":
        $numBanished = explode(",", $parameter); //Banished card
        $numToReorder = 5 - count($numBanished);
        $otherPlayer = ($player == 1 ? 2 : 1);
        $deck = &GetDeck($otherPlayer);
        for ($i = 0; $i < $numToReorder; ++$i) {
          if (count($deck) > 0) {
            if ($cards != "") $cards .= ",";
            $card = array_shift($deck);
            $cards .= $card;
          }
        }
        PrependDecisionQueue("CHOOSETOPOPPONENT", $player, $cards);
        PrependDecisionQueue("SETDQCONTEXT", $player, "Choose a card to put on top of your opponent deck");
        return "";
      case "COUNTSILVERS":
        return CountItem("EVR195", $player);
      case "BLOCKVALUE":
        return BlockValue($lastResult);
      case "PULSECHECKVALIDCARDS":
      $indices = (is_array($lastResult) ? $lastResult : explode(",", $lastResult));
      $hand = &GetHand($player);
      $newIndices = "";
      for ($i = 0; $i < count($indices); ++$i) {
        if (BlockValue($hand[$indices[$i]]) > -1 && BlockValue($hand[$indices[$i]]) <= $parameter && (CardType($hand[$indices[$i]]) == "A" || CardType($hand[$indices[$i]]) == "AA"))
        {
          if ($newIndices != "") $newIndices .= ",";
          $newIndices .= $indices[$i];
        }
      }
      return ($newIndices != "" ? $newIndices : "PASS");
    case "MZADDSTEAMCOUNTER":
      $lastResultArr = explode(",", $lastResult);
      $otherPlayer = ($player == 1 ? 2 : 1);
      $params = explode(",", $parameter);
      for ($i = 0; $i < count($lastResultArr); ++$i) {
        $mzIndex = explode("-", $lastResultArr[$i]);
        switch ($mzIndex[0]) {
          case "MYITEMS":
            $items = &GetItems($player);
            $items[$mzIndex[1] + 1 ] += 1;
            WriteLog(CardLink($items[$mzIndex[1]], $items[$mzIndex[1]]) . " gained a steam counter.");
            break;
          default:
            break;
        }
      }
      return $lastResult;
    case "PASSTAKEDAMAGE":
      if($lastResult == "PASS") DamageTrigger($player, $parameter, "DAMAGE");
      return $lastResult;
    case "PLASMAMAINLINE":
      $items = &GetItems($player);
      $params = explode(",", $parameter);
      $plasmaIndex = SearchItemsForUniqueID($params[0], $player);
      $targetIndex = SearchItemsForUniqueID($params[1], $player);
      ++$items[$targetIndex + 1];
      --$items[$plasmaIndex + 1];
      if ($items[$plasmaIndex + 1] == 0) DestroyItemForPlayer($player, $plasmaIndex);
      return $lastResult;
    case "SURAYA":
      DealArcane(1, 2, "ABILITY", $parameter, true);
      return $lastResult;
    default:
      return "NOTSTATIC";
  }
}

function ImperialWarHorn($player, $term)
{
  //Allies
  AddDecisionQueue("MULTIZONEINDICES", $player, $term . "ALLY");
  AddDecisionQueue("SETDQCONTEXT", $player, "Choose an ally to destroy", 1);
  AddDecisionQueue("CHOOSEMULTIZONE", $player, "<-", 1);
  AddDecisionQueue("MZDESTROY", $player, "-", 1);
  //Auras
  AddDecisionQueue("MULTIZONEINDICES", $player, $term . "AURAS");
  AddDecisionQueue("SETDQCONTEXT", $player, "Choose an aura to destroy", 1);
  AddDecisionQueue("CHOOSEMULTIZONE", $player, "<-", 1);
  AddDecisionQueue("MZDESTROY", $player, "-", 1);
  //Items
  AddDecisionQueue("MULTIZONEINDICES", $player, $term . "ITEMS");
  AddDecisionQueue("SETDQCONTEXT", $player, "Choose an item to destroy", 1);
  AddDecisionQueue("CHOOSEMULTIZONE", $player, "<-", 1);
  AddDecisionQueue("MZDESTROY", $player, "-", 1);
  //Landmarks
  AddDecisionQueue("MULTIZONEINDICES", $player, "LANDMARK");
  AddDecisionQueue("SETDQCONTEXT", $player, "Choose a landmark to destroy", 1);
  AddDecisionQueue("CHOOSEMULTIZONE", $player, "<-", 1);
  AddDecisionQueue("MZDESTROY", $player, "-", 1);
}

function CharacterTriggerInGraveyard($cardID)
{
  switch ($cardID) {
    case "DYN117": case "DYN118":
      return true;
    default:
      return false;
  }
}
