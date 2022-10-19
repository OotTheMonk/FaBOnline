<?php

include "CardDictionary.php";
include "CoreLogic.php";

function PummelHit($player = -1)
{
  global $defPlayer;
  if ($player == -1) $player = $defPlayer;
  AddDecisionQueue("FINDINDICES", $player, "HAND");
  AddDecisionQueue("SETDQCONTEXT", $player, "Choose a card to discard", 1);
  AddDecisionQueue("CHOOSEHAND", $player, "<-", 1);
  AddDecisionQueue("MULTIREMOVEHAND", $player, "-", 1);
  AddDecisionQueue("ADDDISCARD", $player, "HAND", 1);
}

function HandToTopDeck($player)
{
  AddDecisionQueue("FINDINDICES", $player, "HAND");
  AddDecisionQueue("MAYCHOOSEHAND", $player, "<-", 1);
  AddDecisionQueue("MULTIREMOVEHAND", $player, "-", 1);
  AddDecisionQueue("MULTIADDTOPDECK", $player, "-", 1);
}

function BottomDeck()
{
  global $currentPlayer;
  $hand = GetHand($currentPlayer);
  if (count($hand) > 0) {
    AddDecisionQueue("FINDINDICES", $currentPlayer, "HAND");
    AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Put_a_card_from_your_hand_on_the_bottom_of_your_deck.");
    AddDecisionQueue("CHOOSEHAND", $currentPlayer, "<-", 1);
    AddDecisionQueue("REMOVEMYHAND", $currentPlayer, "-", 1);
    AddDecisionQueue("ADDBOTTOMMYDECK", $currentPlayer, "-", 1);
  }
}

function MayBottomDeck()
{
  global $currentPlayer;
  $hand = GetHand($currentPlayer);
  if (count($hand) > 0) {
    AddDecisionQueue("FINDINDICES", $currentPlayer, "HAND");
    AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "You_may_put_a_card_from_your_hand_on_the_bottom_of_your_deck.");
    AddDecisionQueue("MAYCHOOSEHAND", $currentPlayer, "<-", 1);
    AddDecisionQueue("REMOVEMYHAND", $currentPlayer, "-", 1);
    AddDecisionQueue("ADDBOTTOMMYDECK", $currentPlayer, "-", 1);
  }
}

function MayBottomDeckDraw()
{
  global $currentPlayer;
  $hand = GetHand($currentPlayer);
  if (count($hand) > 0) {
    MayBottomDeck();
    AddDecisionQueue("DRAW", $currentPlayer, "-", 1);
  }
}

function BottomDeckMultizone($player, $zone1, $zone2)
{
  AddDecisionQueue("FINDINDICES", $player, "SEARCHMZ," . $zone1 . "|" . $zone2, 1);
  AddDecisionQueue("SETDQCONTEXT", $player, "Choose a card to sink (or click the Pass button)", 1);
  AddDecisionQueue("MAYCHOOSEMULTIZONE", $player, "<-", 1);
  AddDecisionQueue("MULTIZONEREMOVE", $player, "-", 1);
  AddDecisionQueue("ADDBOTTOMMYDECK", $player, "-", 1);
}

function BottomDeckMultizoneDraw($player, $zone1, $zone2)
{
  BottomDeckMultizone($player, $zone1, $zone2);
  AddDecisionQueue("DRAW", $player, "-", 1);
}

function AddCurrentTurnEffect($cardID, $player, $from = "", $uniqueID = -1)
{
  global $currentTurnEffects, $combatChain;
  $card = explode("-", $cardID)[0];
  if (CardType($card) == "A" && count($combatChain) > 0 && !IsCombatEffectPersistent($cardID) && $from != "PLAY") {
    AddCurrentTurnEffectFromCombat($cardID, $player, $uniqueID);
    return;
  }
  array_push($currentTurnEffects, $cardID);
  array_push($currentTurnEffects, $player);
  array_push($currentTurnEffects, $uniqueID);
  array_push($currentTurnEffects, CurrentTurnEffectUses($cardID));
}

function AddAfterResolveEffect($cardID, $player, $from = "", $uniqueID = -1)
{
  global $afterResolveEffects, $combatChain;
  $card = explode("-", $cardID)[0];
  if (CardType($card) == "A" && count($combatChain) > 0 && !IsCombatEffectPersistent($cardID) && $from != "PLAY") {
    AddCurrentTurnEffectFromCombat($cardID, $player, $uniqueID);
    return;
  }
  array_push($afterResolveEffects, $cardID);
  array_push($afterResolveEffects, $player);
  array_push($afterResolveEffects, $uniqueID);
  array_push($afterResolveEffects, CurrentTurnEffectUses($cardID));
}

function CopyCurrentTurnEffectsFromAfterResolveEffects()
{
  global $currentTurnEffects, $afterResolveEffects;
  for ($i = 0; $i < count($afterResolveEffects); $i += CurrentTurnEffectPieces()) {
    array_push($currentTurnEffects, $afterResolveEffects[$i]);
    array_push($currentTurnEffects, $afterResolveEffects[$i + 1]);
    array_push($currentTurnEffects, $afterResolveEffects[$i + 2]);
    array_push($currentTurnEffects, $afterResolveEffects[$i + 3]);
  }
  $afterResolveEffects = [];
}

//This is needed because if you add a current turn effect from combat, it could get deleted as part of the combat resolution
function AddCurrentTurnEffectFromCombat($cardID, $player, $uniqueID = -1)
{
  global $currentTurnEffectsFromCombat;
  array_push($currentTurnEffectsFromCombat, $cardID);
  array_push($currentTurnEffectsFromCombat, $player);
  array_push($currentTurnEffectsFromCombat, $uniqueID);
  array_push($currentTurnEffectsFromCombat, CurrentTurnEffectUses($cardID));
}

function CopyCurrentTurnEffectsFromCombat()
{
  global $currentTurnEffects, $currentTurnEffectsFromCombat;
  for ($i = 0; $i < count($currentTurnEffectsFromCombat); $i += CurrentTurnEffectPieces()) {
    array_push($currentTurnEffects, $currentTurnEffectsFromCombat[$i]);
    array_push($currentTurnEffects, $currentTurnEffectsFromCombat[$i + 1]);
    array_push($currentTurnEffects, $currentTurnEffectsFromCombat[$i + 2]);
    array_push($currentTurnEffects, $currentTurnEffectsFromCombat[$i + 3]);
  }
  $currentTurnEffectsFromCombat = [];
}

function RemoveCurrentTurnEffect($index)
{
  global $currentTurnEffects;
  unset($currentTurnEffects[$index + 3]);
  unset($currentTurnEffects[$index + 2]);
  unset($currentTurnEffects[$index + 1]);
  unset($currentTurnEffects[$index]);
  $currentTurnEffects = array_values($currentTurnEffects);
}

function CurrentTurnEffectPieces()
{
  return 4;
}

function CurrentTurnEffectUses($cardID)
{
  switch ($cardID) {
    case "EVR033":
      return 6;
    case "EVR034":
      return 5;
    case "EVR035":
      return 4;
    case "UPR000":
      return 3;
    case "UPR088":
      return 4;
    case "UPR221": return 4;
    case "UPR222": return 3;
    case "UPR223": return 2;
    default:
      return 1;
  }
}

function AddNextTurnEffect($cardID, $player, $uniqueID = -1)
{
  global $nextTurnEffects;
  array_push($nextTurnEffects, $cardID);
  array_push($nextTurnEffects, $player);
  array_push($nextTurnEffects, $uniqueID);
  array_push($nextTurnEffects, CurrentTurnEffectUses($cardID));
}

function IsCombatEffectLimited($index)
{
  global $currentTurnEffects, $combatChain, $mainPlayer, $combatChainState, $CCS_WeaponIndex, $CCS_AttackUniqueID;
  if (count($combatChain) == 0 || $currentTurnEffects[$index + 2] == -1) return false;
  $attackSubType = CardSubType($combatChain[0]);
  if (DelimStringContains($attackSubType, "Ally")) {
    $allies = &GetAllies($mainPlayer);
    if (count($allies) < $combatChainState[$CCS_WeaponIndex] + 5) return false;
    if ($allies[$combatChainState[$CCS_WeaponIndex] + 5] != $currentTurnEffects[$index + 2]) return true;
  } else {
    return $combatChainState[$CCS_AttackUniqueID] != $currentTurnEffects[$index + 2];
  }
  return false;
}

function HasEffect($cardID)
{
  global $currentTurnEffects;
  for ($i = 0; $i < count($currentTurnEffects); $i += CurrentTurnEffectPieces()) {
    if ($currentTurnEffects[$i] == $cardID) return true;
  }
  return false;
}

function AddLayer($cardID, $player, $parameter, $target = "-", $additionalCosts = "-", $uniqueID = "-")
{
  global $layers;
  //Layers are on a stack, so you need to push things on in reverse order
  array_unshift($layers, $uniqueID);
  array_unshift($layers, $additionalCosts);
  array_unshift($layers, $target);
  array_unshift($layers, $parameter);
  array_unshift($layers, $player);
  array_unshift($layers, $cardID);
  return count($layers);//How far it is from the end
}

function AddDecisionQueue($phase, $player, $parameter, $subsequent = 0, $makeCheckpoint = 0)
{
  global $decisionQueue;
  if (count($decisionQueue) == 0) $insertIndex = 0;
  else {
    $insertIndex = count($decisionQueue) - DecisionQueuePieces();
    if (!IsGamePhase($decisionQueue[$insertIndex])) //Stack must be clear before you can continue with the step
    {
      $insertIndex = count($decisionQueue);
    }
  }

  $parameter = str_replace(" ", "_", $parameter);
  array_splice($decisionQueue, $insertIndex, 0, $phase);
  array_splice($decisionQueue, $insertIndex + 1, 0, $player);
  array_splice($decisionQueue, $insertIndex + 2, 0, $parameter);
  array_splice($decisionQueue, $insertIndex + 3, 0, $subsequent);
  array_splice($decisionQueue, $insertIndex + 4, 0, $makeCheckpoint);
}

function PrependDecisionQueue($phase, $player, $parameter, $subsequent = 0, $makeCheckpoint = 0)
{
  global $decisionQueue;
  $parameter = str_replace(" ", "_", $parameter);
  array_unshift($decisionQueue, $makeCheckpoint);
  array_unshift($decisionQueue, $subsequent);
  array_unshift($decisionQueue, $parameter);
  array_unshift($decisionQueue, $player);
  array_unshift($decisionQueue, $phase);
}

function ProcessDecisionQueue()
{
  global $turn, $decisionQueue, $dqState;
  if ($dqState[0] != "1") {
    $count = count($turn);
    if (count($turn) < 3) $turn[2] = "-";
    $dqState[0] = "1"; //If the decision queue is currently active/processing
    $dqState[1] = $turn[0];
    $dqState[2] = $turn[1];
    $dqState[3] = $turn[2];
    $dqState[4] = "-"; //DQ helptext initial value
    $dqState[5] = "-"; //Decision queue multizone indices
    $dqState[6] = "0"; //Damage dealt
    $dqState[7] = "0"; //Target
    //array_unshift($turn, "-", "-", "-");
  }
  ContinueDecisionQueue("");
}

function CloseDecisionQueue()
{
  global $turn, $decisionQueue, $dqState, $combatChain, $currentPlayer, $mainPlayer;
  $dqState[0] = "0";
  $turn[0] = $dqState[1];
  $turn[1] = $dqState[2];
  $turn[2] = $dqState[3];
  $dqState[4] = "-"; //Clear the context, just in case
  $dqState[5] = "-"; //Clear Decision queue multizone indices
  $dqState[6] = "0"; //Damage dealt
  $dqState[7] = "0"; //Target
  $decisionQueue = [];
  if (($turn[0] == "D" || $turn[0] == "A") && count($combatChain) == 0) {
    $currentPlayer = $mainPlayer;
    $turn[0] = "M";
  }
}

function ShouldHoldPriorityNow($player)
{
  global $layerPriority, $layers;
  if ($layerPriority[$player - 1] != "1") return false;
  $currentLayer = $layers[count($layers) - LayerPieces()];
  $layerType = CardType($currentLayer);
  if (HoldPrioritySetting($player) == 3 && $layerType != "AA" && $layerType != "W") return false;
  return true;
}

function IsGamePhase($phase)
{
  switch ($phase) {
    case "RESUMEPAYING":
    case "RESUMEPLAY":
    case "RESOLVECHAINLINK":
    case "RESOLVECOMBATDAMAGE":
    case "PASSTURN":
      return true;
    default:
      return false;
  }
}

//Must be called with the my/their context
function ContinueDecisionQueue($lastResult = "")
{
  global $decisionQueue, $turn, $currentPlayer, $mainPlayerGamestateStillBuilt, $makeCheckpoint, $otherPlayer, $CS_LayerTarget;
  global $layers, $layerPriority, $dqVars, $dqState, $CS_AbilityIndex, $CS_AdditionalCosts, $mainPlayer, $CS_LayerPlayIndex;
  if (count($decisionQueue) == 0 || IsGamePhase($decisionQueue[0])) {
    if ($mainPlayerGamestateStillBuilt) UpdateMainPlayerGameState();
    else if (count($decisionQueue) > 0 && $currentPlayer != $decisionQueue[1]) {
      UpdateGameState($currentPlayer);
    }
    if (count($decisionQueue) == 0 && count($layers) > 0) {
      $priorityHeld = 0;
      if ($mainPlayer == 1) {
        if (ShouldHoldPriorityNow(1)) {
          AddDecisionQueue("INSTANT", 1, "-");
          $priorityHeld = 1;
          $layerPriority[0] = 0;
        }
        if (ShouldHoldPriorityNow(2)) {
          AddDecisionQueue("INSTANT", 2, "-");
          $priorityHeld = 1;
          $layerPriority[1] = 0;
        }
      } else {
        if (ShouldHoldPriorityNow(2)) {
          AddDecisionQueue("INSTANT", 2, "-");
          $priorityHeld = 1;
          $layerPriority[1] = 0;
        }
        if (ShouldHoldPriorityNow(1)) {
          AddDecisionQueue("INSTANT", 1, "-");
          $priorityHeld = 1;
          $layerPriority[0] = 0;
        }
      }
      if ($priorityHeld) {
        ContinueDecisionQueue("");
      } else {
        if (RequiresDieRoll($layers[0], explode("|", $layers[2])[0], $layers[1])) {
          RollDie($layers[1]);
          ContinueDecisionQueue("");
          return;
        }
        CloseDecisionQueue();
        $cardID = array_shift($layers);
        $player = array_shift($layers);
        $parameter = array_shift($layers);
        $target = array_shift($layers);
        $additionalCosts = array_shift($layers);
        $uniqueID = array_shift($layers);
        $params = explode("|", $parameter);
        if ($currentPlayer != $player) {
          if ($mainPlayerGamestateStillBuilt) UpdateMainPlayerGameState();
          else UpdateGameState($currentPlayer);
          $currentPlayer = $player;
          $otherPlayer = $currentPlayer == 1 ? 2 : 1;
          BuildMyGamestate($currentPlayer);
        }
        $layerPriority[0] = ShouldHoldPriority(1);
        $layerPriority[1] = ShouldHoldPriority(2);
        if ($cardID == "ENDTURN") FinishTurnPass();
        else if ($cardID == "RESUMETURN") $turn[0] = "M";
        else if ($cardID == "LAYER") ProcessLayer($player, $parameter);
        else if ($cardID == "FINALIZECHAINLINK") FinalizeChainLink($parameter);
        else if ($cardID == "DEFENDSTEP") { $turn[0] = "A"; $currentPlayer = $mainPlayer; }
        else if ($cardID == "TRIGGER") {
          ProcessTrigger($player, $parameter, $uniqueID, $target);
          ProcessDecisionQueue();
        } else {
          SetClassState($player, $CS_AbilityIndex, $params[2]); //This is like a parameter to PlayCardEffect and other functions
          PlayCardEffect($cardID, $params[0], $params[1], $target, $additionalCosts, $params[3], $params[2]);
          ClearDieRoll($player);
        }
      }
    } else if (count($decisionQueue) > 0 && $decisionQueue[0] == "RESUMEPLAY") {
      if ($currentPlayer != $decisionQueue[1]) {
        $currentPlayer = $decisionQueue[1];
        $otherPlayer = $currentPlayer == 1 ? 2 : 1;
        BuildMyGamestate($currentPlayer);
      }
      $params = explode("|", $decisionQueue[2]);
      CloseDecisionQueue();
      if ($turn[0] == "B" && count($layers) == 0) //If a layer is not created
      {
        PlayCardEffect($params[0], $params[1], $params[2], "-", $params[3], $params[4]);
      } else {
        //params 3 = ability index
        //params 4 = Unique ID
        $additionalCosts = GetClassState($currentPlayer, $CS_AdditionalCosts);
        if ($additionalCosts == "") $additionalCosts = "-";
        $layerIndex = count($layers) - GetClassState($currentPlayer, $CS_LayerPlayIndex);
        $layers[$layerIndex + 2] = $params[1] . "|" . $params[2] . "|" . $params[3] . "|" . $params[4];
        $layers[$layerIndex + 4] = $additionalCosts;
        ProcessDecisionQueue();
        return;
      }
    } else if (count($decisionQueue) > 0 && $decisionQueue[0] == "RESUMEPAYING") {
      $player = $decisionQueue[1];
      $params = explode("-", $decisionQueue[2]); //Parameter
      if ($lastResult == "") $lastResult = 0;
      CloseDecisionQueue();
      if ($currentPlayer != $player) {
        $currentPlayer = $player;
        $otherPlayer = $currentPlayer == 1 ? 2 : 1;
        BuildMyGamestate($currentPlayer);
      }
      PlayCard($params[0], $params[1], $lastResult, $params[2]);
    } else if (count($decisionQueue) > 0 && $decisionQueue[0] == "RESOLVECHAINLINK") {
      CloseDecisionQueue();
      ResolveChainLink();
    } else if (count($decisionQueue) > 0 && $decisionQueue[0] == "RESOLVECOMBATDAMAGE") {
      $parameter = $decisionQueue[2];
      if ($parameter != "-") $damageDone = $parameter;
      else $damageDone = $dqState[6];
      CloseDecisionQueue();
      ResolveCombatDamage($damageDone);
    } else if (count($decisionQueue) > 0 && $decisionQueue[0] == "PASSTURN") {
      CloseDecisionQueue();
      PassTurn();
    } else {
      CloseDecisionQueue();
      FinalizeAction();
    }
    return;
  }
  $phase = array_shift($decisionQueue);
  $player = array_shift($decisionQueue);
  $parameter = array_shift($decisionQueue);
  //WriteLog($phase . " " . $player . " " . $parameter . " " . $lastResult);//Uncomment this to visualize decision queue execution
  $parameter = str_replace("{I}", $dqState[5], $parameter);
  if (count($dqVars) > 0) {
    if (str_contains($parameter, "{0}")) $parameter = str_replace("{0}", $dqVars[0], $parameter);
    if (str_contains($parameter, "<0>")) $parameter = str_replace("<0>", CardLink($dqVars[0], $dqVars[0]), $parameter);
    if (str_contains($parameter, "{1}")) $parameter = str_replace("{1}", $dqVars[1], $parameter);
  }
  if (count($dqVars) > 1) $parameter = str_replace("<1>", CardLink($dqVars[1], $dqVars[1]), $parameter);
  $subsequent = array_shift($decisionQueue);
  $makeCheckpoint = array_shift($decisionQueue);
  $turn[0] = $phase;
  $turn[1] = $player;
  $currentPlayer = $player;
  $turn[2] = ($parameter == "<-" ? $lastResult : $parameter);
  $return = "PASS";
  if ($subsequent != 1 || is_array($lastResult) || strval($lastResult) != "PASS") $return = DecisionQueueStaticEffect($phase, $player, ($parameter == "<-" ? $lastResult : $parameter), $lastResult);
  if ($parameter == "<-" && !is_array($lastResult) && $lastResult == "-1") $return = "PASS"; //Collapse the rest of the queue if this decision point has invalid parameters
  if (is_array($return) || strval($return) != "NOTSTATIC") {
    if ($phase != "SETDQCONTEXT") $dqState[4] = "-"; //Clear out context for static states -- context only persists for one choice
    ContinueDecisionQueue($return);
  } else {
    if ($mainPlayerGamestateStillBuilt) UpdateMainPlayerGameState();
  }
}

function ProcessLayer($player, $parameter)
{
  switch ($parameter) {
    case "PHANTASM":
      PhantasmLayer();
      break;
    default:
      break;
  }
}

function ProcessTrigger($player, $parameter, $uniqueID, $target="-")
{
  global $combatChain, $CS_NumNonAttackCards, $CS_ArcaneDamageDealt, $CS_NumRedPlayed, $CS_DamageTaken, $CS_EffectContext;

  $resources = &GetResources($player);
  $items = &GetItems($player);
  $character = &GetPlayerCharacter($player);
  $auras = &GetAuras($player);

  if(CardType($parameter) == "C")
  {
    $otherPlayer = ($player == 1 ? 2 : 1);
    $otherCharacter = &GetPlayerCharacter($otherPlayer);
    if(SearchCurrentTurnEffects($otherCharacter[0] . "-SHIYANA", $player)) {
      $parameter = $otherCharacter[0];
    }
  }

  switch ($parameter) {
    case "WTR001": case "WTR002": case "RVD001":
      WriteLog(CardLink($parameter, $parameter) . " Intimidates.");
      Intimidate();
      break;
    case "WTR046":
      DestroyAuraUniqueID($player, $uniqueID);
      WriteLog(CardLink($parameter, $parameter) . " is destroyed.");
      break;
    case "WTR047":
      SetClassState($player, $CS_EffectContext, $parameter);
      Draw($player);
      WriteLog(CardLink($parameter, $parameter) . " draw a card.");
      DestroyAuraUniqueID($player, $uniqueID);
      break;
    case "WTR054": case "WTR055": case "WTR056":
      if($parameter == "WTR054") $amount = 3;
      else if($parameter == "WTR055") $amount = 2;
      else $amount = 1;
      BlessingOfDeliveranceDestroy($amount);
      DestroyAuraUniqueID($player, $uniqueID);
      break;
    case "WTR069": case "WTR070": case "WTR071":
      WriteLog(CardLink($parameter, $parameter) . " gives the next Guardian attack action card this turn +" . EffectAttackModifier($parameter) . ".");
      AddCurrentTurnEffect($parameter, $player);
      DestroyAuraUniqueID($player, $uniqueID);
      break;
    case "WTR072": case "WTR073": case "WTR074":
      DestroyAuraUniqueID($player, $uniqueID);
      WriteLog(CardLink($parameter, $parameter) . " is destroyed.");
      break;
    case "WTR075":
      AddCurrentTurnEffect($parameter, $player);
      DestroyAuraUniqueID($player, $uniqueID);
      break;
    case "WTR076": case "WTR077":
        KatsuHit();
      break;
    case "WTR079":
        WriteLog(CardLink($parameter, $parameter) . " drew a card.");
        MainDrawCard();
      break;
    case "WTR117":
      $index = FindCharacterIndex($player, $parameter);
      AddDecisionQueue("YESNO", $player, "if_you_want_to_destroy_Refraction_Bolters_to_give_your_attack_Go_Again");
      AddDecisionQueue("REFRACTIONBOLTERS", $player, $index, 1);
      break;
    case "ARC007":
      $index = SearchItemsForUniqueID($uniqueID, $player);
      --$items[$index + 1];
      $resources[0] += 2;
      if ($items[$index + 1] <= 0) DestroyMainItem($index);
      WriteLog(CardLink($parameter, $parameter) . " produced 2 resources.");
      break;
    case "ARC035":
      $index = SearchItemsForUniqueID($uniqueID, $player);
      WriteLog(CardLink($parameter, $parameter) . " lost a steam counter and remain in play.");
      --$items[$index + 1];
      if ($items[$index + 1] <= 0) DestroyMainItem($index);
      break;
    case "ARC075":
    case "ARC076":
      ViseraiPlayCard($target);
      break;
    case "ARC112":
      DealArcane(1, 1, "RUNECHANT", "ARC112", player:$player);
      DestroyAuraUniqueID($player, $uniqueID);
      break;
    case "ARC152":
      $index = FindCharacterIndex($player, $parameter);
      AddDecisionQueue("YESNO", $player, "if_you_want_to_destroy_Vest_of_the_First_Fist_to_gain_2_resources");
      AddDecisionQueue("VESTOFTHEFIRSTFIST", $player, $index, 1);
      break;
    case "ARC162":
      DestroyAuraUniqueID($player, $uniqueID);
      WriteLog(CardLink($parameter, $parameter) . " is destroyed.");
      break;
    case "ARC185": case "ARC186": case "ARC187":
      AddDecisionQueue("FINDINDICES", $player, $parameter);
      AddDecisionQueue("MAYCHOOSEDECK", $player, "<-", 1);
      AddDecisionQueue("ADDMYHAND", $player, "-", 1);
      AddDecisionQueue("REVEALCARDS", $player, "-", 1);
      AddDecisionQueue("SHUFFLEDECK", $player, "-", 1);
      break;
    case "CRU000":
      PlayAura("ARC112", $player);
      break;
    case "CRU008":
      Intimidate();
      break;
    case "CRU028":
      DestroyAuraUniqueID($player, $uniqueID);
      WriteLog(CardLink($parameter, $parameter) . " is destroyed.");
      break;
    case "CRU029": case "CRU030": case "CRU031":
      WriteLog(CardLink($parameter, $parameter) . " gives the next Guardian attack action card this turn +" . EffectAttackModifier($parameter) . ".");
      AddCurrentTurnEffect($parameter, $player);
      DestroyAuraUniqueID($player, $uniqueID);
      break;
    case "CRU038": case "CRU039": case "CRU040":
      WriteLog(CardLink($parameter, $parameter) . " gives the next Guardian attack action card this turn +" . EffectAttackModifier($parameter) . " and dominate.");
      AddCurrentTurnEffect($parameter, $player);
      DestroyAuraUniqueID($player, $uniqueID);
      break;
    case "CRU051": case "CRU052":
      EvaluateCombatChain($totalAttack, $totalBlock);
      for ($i = CombatChainPieces(); $i < count($combatChain); $i += CombatChainPieces()) {
        if ($totalBlock > 0 && (intval(BlockValue($combatChain[$i])) + BlockModifier($combatChain[$i], "CC", 0) + $combatChain[$i + 6]) > $totalAttack) {
          DestroyCurrentWeapon();
        }
      }
      break;
    case "CRU053":
      $index = FindCharacterIndex($player, $parameter);
      AddDecisionQueue("YESNO", $player, "if_you_want_to_destroy_Breeze_Rider_Boots_to_give_your_Combo_attacks_Go_Again");
      AddDecisionQueue("NOPASS", $player, "-");
      AddDecisionQueue("PASSPARAMETER", $player, $index, 1);
      AddDecisionQueue("DESTROYCHARACTER", $player, "-", 1);
      AddDecisionQueue("ADDCURRENTEFFECT", $player, $character[$index], 1);
      break;
    case "CRU075":
      $index = SearchAurasForUniqueID($uniqueID, $player);
      if ($auras[$index + 2] == 0) {
        DestroyAuraUniqueID($player, $uniqueID);
      } else {
        --$auras[$index + 2];
      }
      break;
    case "CRU097":
      $otherPlayer = ($player == 1 ? 2 : 1);
      $otherPlayerMainCharacter = &GetPlayerCharacter($otherPlayer);
      $index = FindCharacterIndex($player, $parameter);
      if ($character[$index] != $otherPlayerMainCharacter[$index]) {
        AddDecisionQueue("MULTIZONEINDICES", $player, "MYCHAR:type=C&THEIRCHAR:type=C");
        AddDecisionQueue("SETDQCONTEXT", $player, "Choose which hero to copy");
        AddDecisionQueue("CHOOSEMULTIZONE", $player, "<-", 1);
        AddDecisionQueue("MZGETCARDID", $player, "-", 1);
        AddDecisionQueue("APPENDLASTRESULT", $player, "-SHIYANA", 1);
        AddDecisionQueue("ADDCURRENTANDNEXTTURNEFFECT", $player, "<-", 1);
      }
      break;
    case "CRU142":
      //When you attack with Dread Triptych, if you've played a 'non-attack' action card this turn, create a Runechant token.
      if (GetClassState($player, $CS_NumNonAttackCards) > 0) PlayAura("ARC112", $player);
      //When you attack with Dread Triptych, if you've dealt arcane damage this turn, create a Runechant token.
      if (GetClassState($player, $CS_ArcaneDamageDealt) > 0) PlayAura("ARC112", $player);
      break;
    case "CRU144":
      DestroyAuraUniqueID($player, $uniqueID);
      WriteLog(CardLink($parameter, $parameter) . " is destroyed.");
      break;
    case "CRU161":
      AddDecisionQueue("YESNO", $player, "if_you_want_to_pay_1_to_give_+1_arcane_damage");
      AddDecisionQueue("NOPASS", $player, "-", 1, 1); //Create cancel point
      AddDecisionQueue("PAYRESOURCES", $player, "1", 1);
      AddDecisionQueue("BUFFARCANE", $player, "1", 1);
      AddDecisionQueue("CHARFLAGDESTROY", $player, FindCharacterIndex($player, "CRU161"), 1);
      break;
    case "MON089": // Phantasmal Footsteps
      AddDecisionQueue("SETDQCONTEXT", $player, "Choose how much to pay for " . CardLink($parameter, $parameter));
      AddDecisionQueue("BUTTONINPUT", $player, "0,1");
      AddDecisionQueue("PAYRESOURCES", $player, "<-", 1);
      AddDecisionQueue("LESSTHANPASS", $player, "1", 1);
      AddDecisionQueue("PASSPARAMETER", $player, $target, 1);
      AddDecisionQueue("PHANTASMALFOOTSTEPS", $player, "1", 1);
      AddDecisionQueue("PHANTASMALFOOTSTEPSDESTROYED", $player, "-");
      break;
    case "MON122":
      $index = FindCharacterIndex($player, $parameter);
      AddDecisionQueue("CHARREADYORPASS", $player, $index);
      AddDecisionQueue("YESNO", $player, "if_you_want_to_destroy_Hooves_of_the_Shadowbeast_to_gain_an_action_point", 1);
      AddDecisionQueue("NOPASS", $player, "-", 1);
      AddDecisionQueue("PASSPARAMETER", $player, $index, 1);
      AddDecisionQueue("DESTROYCHARACTER", $player, "-", 1); //Operates off last result
      AddDecisionQueue("GAINACTIONPOINTS", $player, 1, 1);
      break;
    case "MON186":
      SoulShackleStartTurn($player);
      break;
    case "MON241": case "MON242": case "MON243":
    case "MON244": case "RVD005": case "RVD006":
      AddDecisionQueue("SETDQCONTEXT", $player, "Choose how much to pay for " . CardLink($parameter, $parameter));
      AddDecisionQueue("BUTTONINPUT", $player, "0,1");
      AddDecisionQueue("PAYRESOURCES", $player, "<-", 1);
      AddDecisionQueue("LESSTHANPASS", $player, "1", 1);
      AddDecisionQueue("IRONHIDE", $player, $target, 1);
      break;
    case "ELE025": case "ELE026": case "ELE027":
      WriteLog(CardLink($parameter, $parameter) . " gives the next attack action card this turn +" . EffectAttackModifier($parameter) . ".");
      AddCurrentTurnEffect($parameter, $player);
      DestroyAuraUniqueID($player, $uniqueID);
      break;
    case "ELE028": case "ELE029": case "ELE030":
      WriteLog(CardLink($parameter, $parameter) . " gives the next attack action card this turn +" . EffectAttackModifier($parameter) . ".");
      AddCurrentTurnEffect($parameter, $player);
      DestroyAuraUniqueID($player, $uniqueID);
      break;
    case "ELE062": case "ELE063":
      PlayAura("ELE110", $player);
      WriteLog(CardLink($parameter, $parameter) . " created an Embodiment of Lightning aura.");
      break;
    case "ELE066":
      if (HasIncreasedAttack()) MainDrawCard();
      break;
    case "ELE004":
      for ($i = 1; $i < count($combatChain); $i += CombatChainPieces()) {
        if ($combatChain[$i] == $player) {
        PlayAura("ELE111", $player);
        }
      }
      break;
    case "ELE109":
      DestroyAuraUniqueID($player, $uniqueID);
      WriteLog(CardLink($parameter, $parameter) . " is destroyed.");
      break;
    case "ELE111":
      DestroyAuraUniqueID($player, $uniqueID);
      WriteLog(CardLink($parameter, $parameter) . " is destroyed.");
      break;
    case "ELE174":
      $otherPlayer = ($player == 1 ? 2 : 1);
      $index = FindCharacterIndex($player, $parameter);
      AddDecisionQueue("YESNO", $player, "destroy_mark_of_lightning_to_have_the_attack_deal_1_damage");
      AddDecisionQueue("NOPASS", $player, "-", 1);
      AddDecisionQueue("PASSPARAMETER", $player, $index, 1);
      AddDecisionQueue("DESTROYCHARACTER", $player, "-", 1);
      AddDecisionQueue("DEALDAMAGE", $otherPlayer, 1 . "-" . $combatChain[0] . "-" . "COMBAT", 1);
      break;
    case "ELE175":
      AddDecisionQueue("YESNO", $player, "do_you_want_to_pay_1_to_give_your_action_go_again", 0, 1);
      AddDecisionQueue("NOPASS", $player, "-", 1);
      AddDecisionQueue("PASSPARAMETER", $player, 1, 1);
      AddDecisionQueue("PAYRESOURCES", $player, "<-", 1);
      AddDecisionQueue("GIVEACTIONGOAGAIN", $player, $target, 1);
      break;
    case "ELE203": // Rampart of the Ram's Head
      AddDecisionQueue("SETDQCONTEXT", $player, "Choose how much to pay for " . CardLink($parameter, $parameter));
      AddDecisionQueue("BUTTONINPUT", $player, "0,1");
      AddDecisionQueue("PAYRESOURCES", $player, "<-", 1);
      AddDecisionQueue("RAMPARTOFTHERAMSHEAD", $player, $target, 1);
      break;
    case "ELE206": case "ELE207": case "ELE208":
      WriteLog(CardLink($parameter, $parameter) . " gives the next Guardian attack action card this turn +" . EffectAttackModifier($parameter) . ".");
      AddCurrentTurnEffect($parameter, $player);
      DestroyAuraUniqueID($player, $uniqueID);
      break;
    case "EVR018":
        PlayAura("ELE111", $player);
      break;
    case "EVR037":
      $index = FindCharacterIndex($player, $parameter);
      AddDecisionQueue("YESNO", $player, "if_you_want_to_destroy_Mask_of_the_Pouncing_Lynx_to_tutor_a_card");
      AddDecisionQueue("NOPASS", $player, "-");
      AddDecisionQueue("PASSPARAMETER", $player, $index, 1);
      AddDecisionQueue("DESTROYCHARACTER", $player, "-", 1);
      AddDecisionQueue("FINDINDICES", $player, "MASKPOUNCINGLYNX", 1);
      AddDecisionQueue("MAYCHOOSEDECK", $player, "<-", 1);
      AddDecisionQueue("MULTIBANISH", $player, "DECK,TT", 1);
      AddDecisionQueue("SHOWBANISHEDCARD", $player, "-", 1);
      AddDecisionQueue("SHUFFLEDECK", $player, "-", 1);
      break;
    case "EVR069":
      $index = SearchItemsForUniqueID($uniqueID, $player);
      WriteLog(CardLink($parameter, $parameter) . " lost a steam counter and remain in play.");
      --$items[$index + 1];
      if ($items[$index + 1] < 0) DestroyMainItem($index);
      break;
    case "EVR071":
      $index = SearchItemsForUniqueID($uniqueID, $player);
      WriteLog(CardLink($parameter, $parameter) . " lost a steam counter and remain in play.");
      --$items[$index + 1];
      if ($items[$index + 1] < 0) DestroyMainItem($index);
      break;
    case "EVR107": case "EVR108": case "EVR109":
      $index = SearchAurasForUniqueID($uniqueID, $player);
      if ($index == -1) break;
      $auras = &GetAuras($player);
      if ($auras[$index + 2] == 0) {
        WriteLog(CardLink($parameter, $parameter) . " is destroyed.");
        DestroyAuraUniqueID($player, $uniqueID);
      } else {
        --$auras[$index + 2];
        PlayAura("ARC112", $player);
      }
      break;
    case "EVR120": case "UPR102": case "UPR103":
      $otherPlayer = ($player == 1 ? 2 : 1);
      PlayAura("ELE111", $otherPlayer);
      WriteLog(CardLink($parameter, $parameter) . " created a Frostbite for playing an ice card.");
      break;
    case "EVR131": case "EVR132": case "EVR133":
      DestroyAuraUniqueID($player, $uniqueID);
      WriteLog(CardLink($parameter, $parameter) . " is destroyed.");
      break;
    case "RVD015":
      $deck = &GetDeck($player);
      $rv = "";
      if (count($deck) == 0) $rv .= "Your deck is empty. No card is revealed.";
      $wasRevealed = RevealCards($deck[0]);
      if ($wasRevealed) {
        if (AttackValue($deck[0]) < 6) {
          WriteLog("The card was put on the bottom of your deck.");
          array_push($deck, array_shift($deck));
        }
      }
      break;
    case "UPR095":
      if (GetClassState($player, $CS_DamageTaken) > 0) {
        $discard = &GetDiscard($player);
        $found = -1;
        for ($i = 0; $i < count($discard) && $found == -1; $i += DiscardPieces()) {
          if ($discard[$i] == "UPR101") $found = $i;
        }
        if ($found == -1) WriteLog("No Phoenix Flames in discard.");
        else {
          RemoveGraveyard($player, $found);
          AddPlayerHand("UPR101", $player, "GY");
        }
      }
      break;
    case "UPR096":
        if(GetClassState($player, $CS_NumRedPlayed) > 1 && CanRevealCards($player))
        {
          AddDecisionQueue("FINDINDICES", $player, "DECKCARD,UPR101");
          AddDecisionQueue("MAYCHOOSEDECK", $player, "<-", 1);
          AddDecisionQueue("ADDMYHAND", $player, "-", 1);
          AddDecisionQueue("SHUFFLEDECK", $player, "-", 1);
        }
        return "";
    case "UPR140":
      $index = SearchAurasForUniqueID($uniqueID, $player);
      if ($index == -1) break;
      $auras = &GetAuras($player);
      --$auras[$index + 2];
      PayOrDiscard($target, 2, true);
      if ($auras[$index + 2] == 0) {
        WriteLog(CardLink($auras[$index], $auras[$index]) . " is destroyed.");
        DestroyAura($player, $index);
      }
      break;
    case "UPR141": case "UPR142": case "UPR143":
      if ($parameter == "UPR141") $numFrost = 4;
      else if ($parameter == "UPR142") $numFrost = 3;
      else $numFrost = 2;
      PlayAura("ELE111", $target, $numFrost);
      break;
    case "UPR182":
      BottomDeckMultizoneDraw($player, "MYHAND", "MYARS");
      break;
    case "UPR190":
      DestroyAuraUniqueID($player, $uniqueID);
      WriteLog(CardLink($parameter, $parameter) . " is destroyed.");
      break;
    case "UPR191": case "UPR192": case "UPR193": // Flex
      AddDecisionQueue("SETDQCONTEXT", $player, "Choose how much to pay for " . CardLink($parameter, $parameter));
      AddDecisionQueue("BUTTONINPUT", $player, "0,2");
      AddDecisionQueue("PAYRESOURCES", $player, "<-", 1);
      AddDecisionQueue("LESSTHANPASS", $player, "2", 1);
      AddDecisionQueue("PASSPARAMETER", $player, $target, 1);
      AddDecisionQueue("COMBATCHAINBUFFPOWER", $player, "2", 1);
      break;
    case "UPR194": case "UPR195": case "UPR196":
      if (PlayerHasLessHealth($player)) {
        GainHealth(1, $player);
        WriteLog(CardLink($parameter, $parameter) . " gives 1 health.");
      }
      break;
    case "UPR203": case "UPR204": case "UPR205":
      AddDecisionQueue("SETDQCONTEXT", $player, "Choose how much to pay for " . CardLink($parameter, $parameter));
      AddDecisionQueue("BUTTONINPUT", $player, "0,1");
      AddDecisionQueue("PAYRESOURCES", $player, "<-", 1);
      AddDecisionQueue("LESSTHANPASS", $player, "1", 1);
      AddDecisionQueue("PASSPARAMETER", $player, $target, 1);
      AddDecisionQueue("COMBATCHAINBUFFDEFENSE", $player, "2", 1);
      break;
    case "UPR218": case "UPR219": case "UPR220":
      DestroyAuraUniqueID($player, $uniqueID);
      WriteLog(CardLink($parameter, $parameter) . " is destroyed.");
      break;
    case "DYN094":
      $otherPlayer = ($player == 1 ? 2 : 1);
      $index = GetItemIndex($parameter, $player);
      AddDecisionQueue("YESNO", $player, "Do_you_want_to_destroy_" . CardLink($parameter, $parameter) . "_and_a_defending_equipment?");
      AddDecisionQueue("NOPASS", $player, "-");
      AddDecisionQueue("DESTROYITEM", $player, $index, 1);
      AddDecisionQueue("FINDINDICES", $otherPlayer, "EQUIPONCC", 1);
      AddDecisionQueue("CHOOSETHEIRCHARACTER", $player, "<-", 1);
      AddDecisionQueue("DESTROYTHEIRCHARACTER", $player, "-", 1);
      break;
    default:
      break;
  }
}

function GetDQHelpText()
{
  global $dqState;
  if (count($dqState) < 5) return "-";
  return $dqState[4];
}

function FinalizeAction()
{
  global $currentPlayer, $mainPlayer, $actionPoints, $turn, $combatChain, $defPlayer, $makeBlockBackup, $mainPlayerGamestateStillBuilt;
  if (!$mainPlayerGamestateStillBuilt) UpdateGameState(1);
  BuildMainPlayerGamestate();
  if ($turn[0] == "M") {
    if (count($combatChain) > 0) //Means we initiated a chain link
    {
      $turn[0] = "B";
      $currentPlayer = $defPlayer;
      $turn[2] = "";
      $makeBlockBackup = 1;
    } else {
      if ($actionPoints > 0 || ShouldHoldPriority($mainPlayer)) {
        $turn[0] = "M";
        $currentPlayer = $mainPlayer;
        $turn[2] = "";
      } else {
        $currentPlayer = $mainPlayer;
        BeginTurnPass();
      }
    }
  } else if ($turn[0] == "A") {
    //This code would switch to the defense player after resolving an attack reaction if the rules ever change to that
    //$turn[0] = "D";
    //$currentPlayer = $defPlayer;
    $turn[2] = "";
  } else if ($turn[0] == "D") {
    $turn[0] = "A";
    $currentPlayer = $mainPlayer;
    $turn[2] = "";
  } else if ($turn[0] == "B") {
    $turn[0] = "B";
  }
  return 0;
}

function IsReactionPhase()
{
  global $turn, $dqState;
  if ($turn[0] == "A" || $turn[0] == "D") return true;
  if (count($dqState) >= 2 && ($dqState[1] == "A" || $dqState[1] == "D")) return true;
  return false;
}

//Return whether priority should be held for the player by default/settings
function ShouldHoldPriority($player, $layerCard = "")
{
  global $mainPlayer;
  $prioritySetting = HoldPrioritySetting($player);
  if ($prioritySetting == 0 || $prioritySetting == 1) return 1;
  if (($prioritySetting == 2 || $prioritySetting == 3) && $player != $mainPlayer) return 1;
  return 0;
}

function GiveAttackGoAgain()
{
  global $combatChainState, $CCS_CurrentAttackGainedGoAgain;
  $combatChainState[$CCS_CurrentAttackGainedGoAgain] = 1;
}

function DefenderTopDeckToArsenal()
{
  global $defPlayer;
  TopDeckToArsenal($defPlayer);
}

function MainTopDeckToArsenal()
{
  global $mainPlayer;
  TopDeckToArsenal($mainPlayer);
}

function TopDeckToArsenal($player)
{
  $deck = &GetDeck($player);
  if (!ArsenalEmpty($player) || count($deck) == 0) return; //Already something there
  AddArsenal(array_shift($deck), $player, "DECK", "DOWN");
  WriteLog("The top card of player " . $player . "'s deck was put in their arsenal.");
}

function DestroyArsenal($player)
{
  $arsenal = &GetArsenal($player);
  for ($i = 0; $i < count($arsenal); $i += ArsenalPieces()) {
    WriteLog(CardLink($arsenal[$i], $arsenal[$i]) . " was destroyed from the arsenal.");
    AddGraveyard($arsenal[$i], $player, "ARS");
  }
  $arsenal = [];
}

function DiscardHand($player)
{
  $hand = &GetHand($player);
  for ($i = 0; $i < count($hand); $i += HandPieces()) {
    AddGraveyard($hand[$i], $player, "HAND");
  }
  $hand = [];
}

function DiscardIndex($player, $index)
{
  $hand = &GetHand($player);
  AddGraveyard($hand[$index], $player, "HAND");
  unset($hand[$index]);
  $hand = array_values($hand);
}

function Opt($cardID, $amount)
{
  global $currentPlayer;
  PlayerOpt($currentPlayer, $amount);
}

function OptMain($amount)
{
  global $mainPlayer;
  PlayerOpt($mainPlayer, $amount);
}

function PlayerOpt($player, $amount)
{
  AddDecisionQueue("FINDINDICES", $player, "DECKTOPX," . $amount);
  AddDecisionQueue("MULTIREMOVEDECK", $player, "-", 1);
  AddDecisionQueue("OPT", $player, "<-", 1);
}

function DiscardRandom($player = "", $source = "")
{
  global $currentPlayer;
  if ($player == "") $player = $currentPlayer;
  $hand = &GetHand($player);
  if (count($hand) == 0) return "";
  $index = GetRandom() % count($hand);
  $discarded = $hand[$index];
  unset($hand[$index]);
  $hand = array_values($hand);
  AddGraveyard($discarded, $player, "HAND");
  WriteLog(CardLink($discarded, $discarded) . " was randomly discarded.");
  CardDiscarded($player, $discarded, $source);

  return $discarded;
};

function CardDiscarded($player, $discarded, $source = "")
{
  global $CS_Num6PowDisc, $mainPlayer;
  if (AttackValue($discarded) >= 6) {
    $character = &GetPlayerCharacter($player);
    if (($character[0] == "WTR001" || $character[0] == "WTR002" || $character[0] == "RVD001" || SearchCurrentTurnEffects("WTR001-SHIYANA", $mainPlayer) || SearchCurrentTurnEffects("WTR002-SHIYANA", $mainPlayer) || SearchCurrentTurnEffects("RVD001-SHIYANA", $mainPlayer)) && $character[1] == 2 && $player == $mainPlayer) { //Rhinar
      AddLayer("TRIGGER", $mainPlayer, $character[0]);
    }
    IncrementClassState($player, $CS_Num6PowDisc);
  }
  if ($discarded == "CRU008" && $source != "" && ClassContains($source, "BRUTE", $mainPlayer) && CardType($source) == "AA") {
    WriteLog(CardLink("CRU008", "CRU008") . " intimidated because it was discarded by a Brute attack action card.");
    AddLayer("TRIGGER", $mainPlayer, $discarded);
  }
}

function Intimidate()
{
  global $defPlayer; //For now we'll assume you can only intimidate the opponent
  //$otherPlayer = ($currentPlayer == 1 ? 2 : 1);
  $hand = &GetHand($defPlayer);
  if (count($hand) == 0) {
    WriteLog("Intimidate did nothing because there are no cards in hand.");
    return;
  } //Nothing to do if they have no hand
  $index = GetRandom() % count($hand);
  BanishCardForPlayer($hand[$index], $defPlayer, "HAND", "INT");
  unset($hand[$index]);
  $hand = array_values($hand);
  WriteLog("Intimidate banished a card.");
}

//Deprecated: Use BanishCard in CardSetters instead
function Banish($player, $cardID, $from)
{
  BanishCardForPlayer($cardID, $player, $from);
}

function RemoveCard($player, $index)
{
  $hand = &GetHand($player);
  $cardID = $hand[$index];
  unset($hand[$index]);
  $hand = array_values($hand);
  return $cardID;
}

function RemoveFromPitch($player, $index)
{
  $pitch = &GetPitch($player);
  $cardID = $pitch[$index];
  unset($pitch[$index]);
  $pitch = array_values($pitch);
  return $cardID;
}

function RemoveFromArsenal($player, $index)
{
  $arsenal = &GetArsenal($player);
  $cardID = $arsenal[$index];
  RemoveArsenalEffects($player, $cardID);
  for ($i = $index + ArsenalPieces() - 1; $i >= $index; --$i) {
    unset($arsenal[$i]);
  }
  $arsenal = array_values($arsenal);
  return $cardID;
}

function DestroyFrozenArsenal($player)
{
  $arsenal = &GetArsenal($player);
  for ($i = 0; $i < count($arsenal); $i += ArsenalPieces()) {
    if ($arsenal[$i + 4] == "1") {
      DestroyArsenal($player);
    }
  }
}

function isAttackGreaterThanTwiceBasePower()
{
  global $currentPlayer, $combatChainState, $CCS_CachedTotalAttack, $combatChain;
  if (count($combatChain) > 0 && CardType($combatChain[0]) == "W" && $combatChainState[$CCS_CachedTotalAttack] > (AttackValue($combatChain[0]) * 2)) return true;
  $character = &GetPlayerCharacter($currentPlayer);
  for ($i = 0; $i < count($character); $i += CharacterPieces()) {
    if (cardType($character[$i]) != "W") continue;
    $baseAttack = AttackValue($character[$i]);
    $buffedAttack = $baseAttack + $character[$i + 3] + MainCharacterAttackModifiers($i, true) + AttackModifier($character[$i]);
    if ($buffedAttack > $baseAttack * 2) return true;
  }
  return false;
}

function HasNegativeCounters($array, $index)
{
  if ($array[$index + 4] < 0) return true;
  return false;
}

function HasEnergyCounters($array, $index)
{
  switch ($array[$index]) {
    case "WTR150": case "UPR166":
      return $array[$index + 2] > 0;
    default:
      return false;
  }
}
