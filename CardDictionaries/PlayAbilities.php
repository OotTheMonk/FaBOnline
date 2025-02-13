<?php

function AKOPlayAbility($cardID, $from, $resourcesPaid, $target = "-", $additionalCosts = "")
{
  global $currentPlayer;
  switch ($cardID) {
    case "AKO004":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    default:
      return "";
  }
}

function ASBPlayAbility($cardID, $from, $resourcesPaid, $target = "-", $additionalCosts = "")
{
  global $currentPlayer, $CS_NumCharged, $CombatChain;
  switch ($cardID) {
    case "ASB004":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "ASB025":
      if (GetClassState($currentPlayer, $CS_NumCharged) > 0) $CombatChain->Card(0)->ModifyPower(-2);
      return "";
    default:
      return "";
  }
}

function HVYPlayAbility($cardID, $from, $resourcesPaid, $target = "-", $additionalCosts = "")
{
  global $currentPlayer, $chainLinks, $defPlayer, $CS_NumCardsDrawn, $CS_HighestRoll, $CombatChain, $CS_NumMightDestroyed, $CS_DieRoll;
  $otherPlayer = $currentPlayer == 1 ? 2 : 1;
  $rv = "";
  switch ($cardID) {
    case "HVY007":
      Draw($currentPlayer);
      DiscardRandom();
      return "";
    case "HVY009":
      $roll = GetDieRoll($currentPlayer);
      AddCurrentTurnEffect($cardID . "-" . $roll, $currentPlayer);
      return "Rolled $roll and your intellect is " . $roll . " until the end of turn.";
    case "HVY010":
      Draw($currentPlayer);
      DiscardRandom($currentPlayer, $cardID);
      return "";
    case "HVY012":
      if (IsHeroAttackTarget()) {
        AddDecisionQueue("MULTIZONEINDICES", $currentPlayer, "THEIRARS");
        AddDecisionQueue("CHOOSEMULTIZONE", $currentPlayer, "<-", 1);
        AddDecisionQueue("MZBANISH", $currentPlayer, "CC," . $cardID, 1);
        AddDecisionQueue("MZREMOVE", $currentPlayer, "-", 1);
        AddDecisionQueue("ADDCURRENTEFFECT", $currentPlayer, $cardID, 1);
      } else {
        WriteLog("<span style='color:red;'>No arsenal is banished because it does not attack a hero.</span>");
      }
      return "";
    case "HVY013":
      if (IsHeroAttackTarget()) Intimidate();
      return "";
    case "HVY014":
      $deck = new Deck($currentPlayer);
      if ($deck->Reveal(6)) {
        $cards = explode(",", $deck->Top(amount: 6));
        $numSixes = 0;
        for ($i = 0; $i < count($cards); ++$i) {
          if (ModifiedAttackValue($cards[$i], $currentPlayer, "DECK") >= 6) ++$numSixes;
        }
        PlayAura("HVY241", $currentPlayer, $numSixes); //Might
        if (CountAura("HVY241", $currentPlayer) >= 6) PlayAura("HVY240", $currentPlayer); //Agility

        $zone = &GetDeck($currentPlayer);
        $topDeck = array_slice($zone, 0, 6);
        shuffle($topDeck);
        for ($i = 0; $i < count($topDeck); ++$i) {
          $zone[$i] = $topDeck[$i];
        }
      }
      return "";
    case "HVY015":
      RollDie($currentPlayer);
      $roll = GetClassState($currentPlayer, $CS_DieRoll);
      GainActionPoints(intval($roll / 2), $currentPlayer);
      if (GetClassState($currentPlayer, $CS_HighestRoll) == 6) Draw($currentPlayer);
      return "Rolled $roll and gained " . intval($roll / 2) . " action points";
    case "HVY016":
      AddCurrentTurnEffect($cardID . "-" . $additionalCosts, $currentPlayer);
      return "";
    case "HVY023":
    case "HVY024":
    case "HVY025":
      if (SearchCurrentTurnEffects("BEATCHEST", $currentPlayer) && IsHeroAttackTarget()) Intimidate();
      return "";
    case "HVY026":
    case "HVY027":
    case "HVY028":
      if (SearchCurrentTurnEffects("BEATCHEST", $currentPlayer)) PlayAura("HVY240", $currentPlayer);//Agility
      return "";
    case "HVY035":
    case "HVY036":
    case "HVY037":
      if (SearchCurrentTurnEffects("BEATCHEST", $currentPlayer)) PlayAura("HVY241", $currentPlayer);//Might
      return "";
    case "HVY041":
    case "HVY042":
    case "HVY043":
      if ($cardID == "HVY041") $amount = 3;
      else if ($cardID == "HVY042") $amount = 2;
      else if ($cardID == "HVY043") $amount = 1;
      if (SearchCurrentTurnEffects("BEATCHEST", $currentPlayer)) $amount += 2;
      AddCurrentTurnEffect($cardID . "," . $amount, $currentPlayer);
      return "";
    case "HVY044":
      PlayAura("HVY240", $currentPlayer);//Agility
      PlayAura("HVY241", $currentPlayer);//Might
      return "";
    case "HVY055":
      AddCurrentTurnEffect($cardID . "-PAID", $currentPlayer);
      return "";
    case "HVY057":
      if (IsHeroAttackTarget()) AskWager($cardID);
      return "";
    case "HVY058":
      if (GetClassState($currentPlayer, $CS_NumMightDestroyed) > 0 || SearchAurasForCard("HVY241", $currentPlayer)) AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "HVY063":
      AddCurrentTurnEffect($cardID, $defPlayer);
      return "";
    case "HVY089":
      PlayAura("HVY241", $currentPlayer);//Might
      PlayAura("HVY242", $currentPlayer);//Vigor
      return "";
    case "HVY133":
      PlayAura("HVY240", $currentPlayer);//Agility
      PlayAura("HVY242", $currentPlayer);//Vigor
      return "";
    case "HVY090":
    case "HVY091":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "HVY098":
      if (IsHeroAttackTarget()) {
        AddCurrentTurnEffect($cardID, $currentPlayer);
        AddOnWagerEffects();
      }
      return "";
    case "HVY099":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "HVY101":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      AddCurrentTurnEffectFromCombat($cardID, $currentPlayer);
      return "";
    case "HVY102":
      if (CachedTotalAttack() > AttackValue($CombatChain->AttackCard()->ID())) {
        GiveAttackGoAgain();
        AddCurrentTurnEffect($cardID, $currentPlayer);
      }
      return "";
    case "HVY103":
      AddDecisionQueue("PASSPARAMETER", $currentPlayer, $additionalCosts, 1);
      AddDecisionQueue("MODAL", $currentPlayer, "UPTHEANTE", 1);
      return "";
    case "HVY104":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      AddCurrentTurnEffect($cardID . "-BUFF", $currentPlayer);
      return "";
    case "HVY105":
      PlayAlly("HVY134", $currentPlayer, number: intval($additionalCosts));
      return "";
    case "HVY106":
    case "HVY107":
    case "HVY108":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      if (NumAttacksBlocking() > 0) {
        Draw($currentPlayer);
        $hand = &GetHand($currentPlayer);
        $arsenal = GetArsenal($currentPlayer);
        if (count($hand) + count($arsenal) == 1) {
          AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Here's the card that goes on the bottom of your deck.", 1);
          AddDecisionQueue("OK", $currentPlayer, "-");
        }
        if (count($hand) + count($arsenal) > 0) MZMoveCard($currentPlayer, "MYHAND&MYARS", "MYBOTDECK", silent: true);
      }
      return "";
    case "HVY109":
    case "HVY110":
    case "HVY111":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "HVY115":
    case "HVY116":
    case "HVY117":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      if (NumAttacksBlocking() > 0) PlayAura("HVY240", $currentPlayer); //Agility
      return "";
    case "HVY118":
    case "HVY119":
    case "HVY120":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      if (NumAttacksBlocking() > 0) PlayAura("HVY242", $currentPlayer); //Vigor
      return "";
    case "HVY121":
    case "HVY122":
    case "HVY123":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      Draw($currentPlayer);
      return "";
    case "HVY124":
    case "HVY125":
    case "HVY126":
      AddCurrentTurnEffect($cardID . "-BUFF", $currentPlayer);
      return "";
    case "HVY127":
    case "HVY128":
    case "HVY129":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "HVY130":
    case "HVY131":
    case "HVY132":
      AddCurrentTurnEffect($cardID . "-BUFF", $currentPlayer);
      return "";
    case "HVY135":
      PlayAura("HVY241", $currentPlayer); //Might
      return "";
    case "HVY136":
      AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Choose a number");
      AddDecisionQueue("BUTTONINPUT", $currentPlayer, "0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20");
      AddDecisionQueue("WRITELOGLASTRESULT", $currentPlayer, "-", 1);
      AddDecisionQueue("PREPENDLASTRESULT", $currentPlayer, "HVY136,");
      AddDecisionQueue("ADDCURRENTEFFECT", $currentPlayer, "<-");
      return "";
    case "HVY140":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "HVY143":
    case "HVY144":
    case "HVY145":
      if (GetResolvedAbilityType($cardID, "HAND") == "I") {
        PlayAura("HVY241", $currentPlayer); //Might
        CardDiscarded($currentPlayer, $cardID, source: $cardID);
      }
      return "";
    case "HVY149":
    case "HVY150":
    case "HVY151":
      if (IsHeroAttackTarget()) AskWager($cardID);
      return "";
    case "HVY152":
    case "HVY153":
    case "HVY154":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      PlayAura("HVY241", $currentPlayer); //Might
      return "";
    case "HVY155":
      PlayAura("HVY240", $currentPlayer); //Agility
      return "";
    case "HVY156":
      if (DoesAttackHaveGoAgain()) PlayAura("HVY240", $currentPlayer); //Agility
      return "";
    case "HVY160":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "HVY163":
    case "HVY164":
    case "HVY165":
      if (GetResolvedAbilityType($cardID, "HAND") == "I") {
        PlayAura("HVY240", $currentPlayer); //Agility
        CardDiscarded($currentPlayer, $cardID, source: $cardID);
      }
      return "";
    case "HVY169":
    case "HVY170":
    case "HVY171":
      if (IsHeroAttackTarget()) AskWager($cardID);
      return "";
    case "HVY172":
    case "HVY173":
    case "HVY174":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      PlayAura("HVY240", $currentPlayer); //Agility
      return "";
    case "HVY175":
      PlayAura("HVY242", $currentPlayer); //Vigor
      return "";
    case "HVY176":
      AddCurrentTurnEffect($cardID . "-BUFF", $currentPlayer);
      AddCurrentTurnEffect($cardID, $currentPlayer);
      AddCurrentTurnEffect($cardID, $otherPlayer);
      return "";
    case "HVY180":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "HVY186":
    case "HVY187":
    case "HVY188":
      if (GetResolvedAbilityType($cardID, "HAND") == "I") {
        PlayAura("HVY242", $currentPlayer); //Vigor
        CardDiscarded($currentPlayer, $cardID, source: $cardID);
      }
      return "";
    case "HVY189":
    case "HVY190":
    case "HVY191":
      if (IsHeroAttackTarget()) AskWager($cardID);
      return "";
    case "HVY192":
    case "HVY193":
    case "HVY194":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      PlayAura("HVY242", $currentPlayer); //Vigor
      return "";
    case "HVY195":
      Draw($currentPlayer);
      return "";
    case "HVY196":
      Draw($currentPlayer);
      return "";
    case "HVY197":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "HVY209":
      if (GetResolvedAbilityType($cardID, "HAND") == "I") {
        AddCurrentTurnEffect($cardID, $currentPlayer, $from);
      }
      return "";
    case "HVY210":
      MZMoveCard($currentPlayer, "MYARS", "MYBOTDECK", may: true, silent: true);
      AddDecisionQueue("ADDCURRENTEFFECT", $currentPlayer, $cardID, 1);
      return "";
    case "HVY211":
      $buff = NumCardsBlocking();
      for ($i = 0; $i < count($chainLinks); ++$i) {
        for ($j = 0; $j < count($chainLinks[$i]); $j += ChainLinksPieces()) {
          if ($chainLinks[$i][$j + 1] == $defPlayer && $chainLinks[$i][$j+2] == 1) ++$buff;
        }
      }
      AddCurrentTurnEffect($cardID . "," . $buff, $currentPlayer);
      return "";
    case "HVY212":
      LookAtTopCard($currentPlayer, $cardID, showHand: true);
      if ($from == "ARS") AddDecisionQueue("DRAW", $currentPlayer, "-");
      return "";
    case "HVY213":
    case "HVY214":
    case "HVY215":
      if (IsHeroAttackTarget() && PlayerHasLessHealth($currentPlayer) && GetPlayerNumEquipment($currentPlayer) < GetPlayerNumEquipment($otherPlayer) && GetPlayerNumTokens($currentPlayer) < GetPlayerNumTokens($otherPlayer)) {
        AddCurrentTurnEffect($cardID, $currentPlayer);
      }
      return "";
    case "HVY216":
    case "HVY217":
    case "HVY218":
      if (IsHeroAttackTarget()) AskWager($cardID);
      return "";
    case "HVY225":
    case "HVY226":
    case "HVY227":
      if ($from == "ARS") GiveAttackGoAgain();
      return "";
    case "HVY235":
    case "HVY236":
    case "HVY237":
      AddCurrentTurnEffect($cardID . "-BUFF", $currentPlayer);
      return "";
    case "HVY238":
      if (CountItem("DYN243", $currentPlayer, false) == 0) {
        PutItemIntoPlayForPlayer("DYN243", $currentPlayer, effectController: $currentPlayer);
        WriteLog(CardLink($cardID, $cardID) . " created a Gold token");
      }
      return;
    case "HVY245":
      if ($from == "GY") {
        $character = &GetPlayerCharacter($currentPlayer);
        $uniqueID = EquipWeapon($currentPlayer, "HVY245");
        for ($i = 0; $i < count($character); $i += CharacterPieces()) {
          if ($character[$i + 11] == $uniqueID) {
            if ($character[$i + 3] == 0) {
              ++$character[$i + 3];
            } else {
              ++$character[$i + 15];
            }
          }
        }
      }
      return "";
    case "HVY246":
      if (IsHeroAttackTarget()) {
        $deck = new Deck($otherPlayer);
        if ($deck->RemainingCards() > 0) {
          AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Choose a card to put on top of their deck");
          AddDecisionQueue("CHOOSETOPOPPONENT", $currentPlayer, $deck->Top(true, 3));
          AddDecisionQueue("FINDINDICES", $otherPlayer, "TOPDECK", 1);
          AddDecisionQueue("MULTIREMOVEDECK", $otherPlayer, "<-", 1);
          AddDecisionQueue("MULTIBANISH", $otherPlayer, "DECK," . $cardID . "," . $currentPlayer);
        }
      }
      return "";
    case "HVY247":
      $deck = new Deck($currentPlayer);
      $banishMod = "-";
      if (HasCombo($deck->Top())) $banishMod = "TT";
      $deck->BanishTop($banishMod, $currentPlayer);
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "HVY251":
      $xVal = $resourcesPaid / 2;
      MZMoveCard($currentPlayer, "MYDECK:maxCost=" . $xVal . ";subtype=Aura;class=RUNEBLADE", "MYAURAS", may: true);
      AddDecisionQueue("SHUFFLEDECK", $currentPlayer, "-");
      if ($xVal >= 2) {
        global $CS_NextNAACardGoAgain;
        SetClassState($currentPlayer, $CS_NextNAACardGoAgain, 1);
      }
      return "";
    case "HVY252":
      DealArcane(1, 1, "PLAYCARD", $cardID);
      AddDecisionQueue("SPECIFICCARD", $currentPlayer, "AERTHERARC");
      return "";
    case "HVY253":
      for ($i = 1; $i < 3; $i += 1) {
        $arsenal = &GetArsenal($i);
        for ($j = 0; $j < count($arsenal); $j += ArsenalPieces()) {
          AddDecisionQueue("FINDINDICES", $i, "ARSENAL");
          AddDecisionQueue("CHOOSEARSENAL", $i, "<-", 1);
          AddDecisionQueue("REMOVEARSENAL", $i, "-", 1);
          AddDecisionQueue("ADDBOTDECK", $i, "-", 1);
        }
        PlayAura("DYN244", $i);
      }
      return "";
    case "HVY250":
      AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Here are the top " . ($resourcesPaid + 1) . " cards of your deck.", 1);
      AddDecisionQueue("FINDINDICES", $currentPlayer, "DECKTOPXINDICES," . ($resourcesPaid + 1));
      AddDecisionQueue("DECKCARDS", $currentPlayer, "<-", 1);
      AddDecisionQueue("LOOKTOPDECK", $currentPlayer, "-", 1);
      AddDecisionQueue("SETDQCONTEXT", $currentPlayer, CardLink($cardID, $cardID) . " shows the top cards of your deck are", 1);
      AddDecisionQueue("MULTISHOWCARDSDECK", $currentPlayer, "<-", 1);
      AddDecisionQueue("FINDINDICES", $currentPlayer, "DECKTOPXINDICES," . ($resourcesPaid + 1));
      AddDecisionQueue("DECKCARDS", $currentPlayer, "<-", 1);
      AddDecisionQueue("TOPDECKCHOOSE", $currentPlayer, $resourcesPaid + 1 . ",Trap", 1);
      AddDecisionQueue("MULTICHOOSEDECK", $currentPlayer, "<-", 1);
      AddDecisionQueue("MULTIREMOVEDECK", $currentPlayer, "-", 1);
      AddDecisionQueue("MULTIADDHAND", $currentPlayer, "-", 1);
      AddDecisionQueue("REVEALCARDS", $currentPlayer, "-", 1);
      AddDecisionQueue("SHUFFLEDECK", $currentPlayer, "-", 1);
      Reload();
      return "";
    default:
      return "";
  }
}

function TCCPlayAbility($cardID, $from, $resourcesPaid, $target = "-", $additionalCosts = "")
{
  global $mainPlayer, $currentPlayer, $defPlayer;
  $rv = "";
  $otherPlayer = ($currentPlayer == 1 ? 2 : 1);
  switch ($cardID) {
    case "TCC035":
      AddCurrentTurnEffect($cardID, $defPlayer);
      return "";
    case "TCC050":
      $abilityType = GetResolvedAbilityType($cardID);
      $character = &GetPlayerCharacter($currentPlayer);
      $charIndex = FindCharacterIndex($mainPlayer, $cardID);
      if ($abilityType == "A") {
        AddDecisionQueue("SETDQCONTEXT", $otherPlayer, "Choose a token to create");
        AddDecisionQueue("MULTICHOOSETEXT", $otherPlayer, "1-Might (+1),Vigor (Resource),Quicken (Go Again)-1");
        AddDecisionQueue("SHOWMODES", $otherPlayer, $cardID, 1);
        AddDecisionQueue("MODAL", $otherPlayer, "JINGLEWOOD", 1);
        PutItemIntoPlayForPlayer("CRU197", $currentPlayer);
        --$character[$charIndex + 5];
      }
      return "";
    case "TCC051":
      Draw(1);
      Draw(2);
      return "";
    case "TCC052":
      PlayAura("HVY242", 1);
      PlayAura("HVY242", 2);
      return "";
    case "TCC053":
      PlayAura("HVY241", 1);
      PlayAura("HVY241", 2);
      return "";
    case "TCC054":
      PlayAura("WTR225", 1);
      PlayAura("WTR225", 2);
      return "";
    case "TCC057":
      $numPitch = SearchCount(SearchPitch($currentPlayer)) + SearchCount(SearchPitch($otherPlayer));
      AddCurrentTurnEffect($cardID . "," . ($numPitch * 2), $currentPlayer);
      return "";
    case "TCC058":
    case "TCC062":
    case "TCC075":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "TCC061":
      MZMoveCard($currentPlayer, "MYDISCARD:class=BARD;type=AA", "MYHAND", may: false, isSubsequent: false);
      return "";
    case "TCC064":
      PlayAura("WTR225", $otherPlayer);
      return "";
    case "TCC065":
      GainHealth(1, $otherPlayer);
      return "";
    case "TCC066":
      PlayAura("HVY242", $otherPlayer);
      return "";
    case "TCC067":
      PlayAura("HVY241", $otherPlayer);
      return "";
    case "TCC068":
      Draw($otherPlayer);
      return "";
    case "TCC069":
      MZMoveCard($otherPlayer, "MYDISCARD:type=AA", "MYBOTDECK", may: true);
      return "";
    case "TCC079":
      Draw($currentPlayer);
      return "";
    case "TCC080":
      GainResources($currentPlayer, 1);
      return "";
    case "TCC082":
      BanishCardForPlayer("DYN065", $currentPlayer, "-", "TT", $currentPlayer);
      return "";
    case "TCC086":
    case "TCC094":
      AddCurrentTurnEffectFromCombat($cardID, $currentPlayer);
      break;
    default:
      return "";
  }
}

function EVOPlayAbility($cardID, $from, $resourcesPaid, $target = "-", $additionalCosts = "")
{
  global $mainPlayer, $currentPlayer, $defPlayer, $layers, $combatChain, $CCS_RequiredNegCounterEquipmentBlock, $combatChainState;
  global $CS_NamesOfCardsPlayed, $CS_NumBoosted, $CS_PlayIndex, $CS_NumItemsDestroyed, $CS_DamagePrevention;
  $rv = "";
  $otherPlayer = ($currentPlayer == 1 ? 2 : 1);
  $character = &GetPlayerCharacter($currentPlayer);
  switch ($cardID) {
    case "EVO004":
    case "EVO005":
      PutItemIntoPlayForPlayer("EVO234", $currentPlayer, 2);
      --$character[5];
      return "";
    case "EVO007":
    case "EVO008":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      --$character[5];
      return "";
    case "EVO010":
      $conditionsMet = CheckIfSingularityConditionsAreMet($currentPlayer);
      if ($conditionsMet != "") return $conditionsMet;
      $char = &GetPlayerCharacter($currentPlayer);
      // We don't want function calls in every iteration check
      $charCount = count($char);
      $charPieces = CharacterPieces();
      AddSoul($char[0], $currentPlayer, "-");
      if (isSubcardEmpty($char, 0)) $char[10] = $char[0];
      else $char[10] = $char[10] . "," . $char[0];
      $char[0] = "EVO410";
      $char[1] = 2;
      $char[2] = 0;
      $char[3] = 0;
      $char[4] = 0;
      $char[5] = 999; // Remove the 'Once per Turn' limitation from Teklovossen
      $char[6] = 0;
      $char[7] = 0;
      $char[8] = 0;
      $char[9] = 2;
      $char[11] = GetUniqueId("EVO410", $currentPlayer);
      $mechropotentIndex = 0; // we pushed it, so should be the last element
      for ($i = $charCount - $charPieces; $i >= 0; $i -= $charPieces) {
        if ($char[$i] != "EVO410" && $char[$i] != "NONE00") {
          EvoTransformAbility("EVO410", $char[$i], $currentPlayer);
          RemoveCharacterAndAddAsSubcardToCharacter($currentPlayer, $i, $mechropotentIndex);
        }
      }
      PutCharacterIntoPlayForPlayer("EVO410b", $currentPlayer);
      return "";
    case "EVO013":
      ModularMove($cardID, $additionalCosts);
      return "";
    case "EVO014":
      MZMoveCard($mainPlayer, "MYBANISH:class=MECHANOLOGIST;type=AA", "MYTOPDECK", isReveal: true);
      AddDecisionQueue("SHUFFLEDECK", $mainPlayer, "-", 1);
      return "";
    case "EVO015":
      AddDecisionQueue("GAINRESOURCES", $mainPlayer, "2");
      return "";
    case "EVO016":
      AddCurrentTurnEffectNextAttack($cardID, $mainPlayer);
      return "";
    case "EVO017":
      AddDecisionQueue("GAINACTIONPOINTS", $mainPlayer, "1");
      return "";
    case "EVO030":
    case "EVO031":
    case "EVO032":
    case "EVO033":
      AddDecisionQueue("PASSPARAMETER", $currentPlayer, "-");
      AddDecisionQueue("SETDQVAR", $currentPlayer, "0");
      AddDecisionQueue("SPECIFICCARD", $currentPlayer, "EVOBREAKER");
      return "Light up the gem under the equipment when you want to use the conditional effect❗";
    case "EVO057":
      if (IsHeroAttackTarget() && EvoUpgradeAmount($mainPlayer) > 0) {
        AddDecisionQueue("MULTIZONEINDICES", $currentPlayer, "THEIRITEMS:hasSteamCounter=true&THEIRCHAR:hasSteamCounter=true");
        AddDecisionQueue("PREPENDLASTRESULT", $currentPlayer, "MAXCOUNT-" . EvoUpgradeAmount($mainPlayer) . ",MINCOUNT-" . 0 . ",", 1);
        AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Choose up to " . EvoUpgradeAmount($currentPlayer) . " card" . (EvoUpgradeAmount($mainPlayer) > 1 ? "s" : "") . " to remove all steam counters from.", 1);
        AddDecisionQueue("MAYCHOOSEMULTIZONE", $currentPlayer, "<-", 1);
        AddDecisionQueue("MZREMOVECOUNTER", $currentPlayer, "<-");
      }
      return "";
    case "EVO058":
      if (IsHeroAttackTarget() && EvoUpgradeAmount($currentPlayer) > 0) {
        $otherPlayer = ($currentPlayer == 1 ? 2 : 1);
        AddDecisionQueue("PASSPARAMETER", $otherPlayer, EvoUpgradeAmount($currentPlayer), 1);
        AddDecisionQueue("SETDQVAR", $currentPlayer, "0");
        AddDecisionQueue("FINDINDICES", $otherPlayer, "HAND");
        AddDecisionQueue("APPENDLASTRESULT", $otherPlayer, "-{0}", 1);
        AddDecisionQueue("PREPENDLASTRESULT", $otherPlayer, "{0}-", 1);
        AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Choose " . EvoUpgradeAmount($currentPlayer) . " card(s)", 1);
        AddDecisionQueue("MULTICHOOSEHAND", $otherPlayer, "<-", 1);
        AddDecisionQueue("IMPLODELASTRESULT", $otherPlayer, ",", 1);
        AddDecisionQueue("SETDQVAR", $currentPlayer, "1");
        AddDecisionQueue("REVEALHANDCARDS", $otherPlayer, "<-", 1);
        AddDecisionQueue("PASSPARAMETER", $currentPlayer, "{1}", 1);
        AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Choose a card", 1);
        AddDecisionQueue("SPECIFICCARD", $otherPlayer, "PULSEWAVEPROTOCOLFILTER", 1);
        AddDecisionQueue("CHOOSETHEIRHAND", $currentPlayer, "<-", 1);
        AddDecisionQueue("MULTIREMOVEHAND", $otherPlayer, "-", 1);
        AddDecisionQueue("ADDCARDTOCHAINASDEFENDINGCARD", $otherPlayer, "HAND", 1);
      }
      return "";
    case "EVO059":
      $negCounterEquip = explode(",", SearchCharacter($otherPlayer, hasNegCounters: true));
      $numNegCounterEquip = count($negCounterEquip);
      if ($numNegCounterEquip > EvoUpgradeAmount($currentPlayer)) $requiredEquip = EvoUpgradeAmount($currentPlayer);
      else $requiredEquip = $numNegCounterEquip;
      if ($numNegCounterEquip > 0 && $requiredEquip > 0 && !IsAllyAttackTarget()) {
        $combatChainState[$CCS_RequiredNegCounterEquipmentBlock] = $requiredEquip;
        if ($requiredEquip > 1) $rv = CardLink($cardID, $cardID) . " requires you to block with " . $requiredEquip . " equipments";
        else $rv = CardLink($cardID, $cardID) . " requires you to block with " . $requiredEquip . " equipment";
        WriteLog($rv);
      }
      return "";
    case "EVO070":
      if ($from == "PLAY") DestroyTopCardTarget($currentPlayer);
      break;
    case "EVO071":
      if ($from == "PLAY") {
        $deck = new Deck($currentPlayer);
        $deck->Reveal();
        $pitchValue = PitchValue($deck->Top());
        MZMoveCard($currentPlayer, ("MYBANISH:class=MECHANOLOGIST;subtype=Item;pitch=" . $pitchValue), "MYTOPDECK", may: true, isReveal: true);
      }
      break;
    case "EVO072":
      if ($from == "PLAY") {
        MZMoveCard($currentPlayer, "MYHAND:class=MECHANOLOGIST;subtype=Item;maxCost=1", "", may: true);
        AddDecisionQueue("PUTPLAY", $currentPlayer, "0", 1);
      }
      break;
    case "EVO073":
      if ($from == "PLAY") {
        $index = GetClassState($currentPlayer, $CS_PlayIndex);
        RemoveItem($currentPlayer, $index);
        $deck = new Deck($currentPlayer);
        $deck->AddBottom($cardID, from: "PLAY");
        AddDecisionQueue("FINDINDICES", $otherPlayer, "EQUIP");
        AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Choose target equipment it cannot defend this turn");
        AddDecisionQueue("CHOOSETHEIRCHARACTER", $currentPlayer, "<-", 1);
        AddDecisionQueue("EQUIPCANTDEFEND", $otherPlayer, "EVO073-B-", 1);
      }
      break;
    case "EVO075":
      if ($from == "PLAY") GainResources($currentPlayer, 1);
      return "";
    case "EVO076":
      if ($from == "PLAY") GainHealth(2, $currentPlayer);
      return "";
    case "EVO077":
      if ($from == "PLAY") {
        AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Choose a card with Crank to get a steam counter", 1);
        AddDecisionQueue("MULTIZONEINDICES", $currentPlayer, "MYITEMS:hasCrank=true");
        AddDecisionQueue("CHOOSEMULTIZONE", $currentPlayer, "<-", 1);
        AddDecisionQueue("MZADDCOUNTER", $currentPlayer, "-", 1);
      }
      return "";
    case "EVO079":
      if ($currentPlayer == $defPlayer) {
        for ($j = CombatChainPieces(); $j < count($combatChain); $j += CombatChainPieces()) {
          if ($combatChain[$j + 1] != $currentPlayer) continue;
          if (CardType($combatChain[$j]) == "AA" && ClassContains($combatChain[$j], "MECHANOLOGIST", $currentPlayer)) CombatChainPowerModifier($j, 1);
        }
      }
      break;
    case "EVO081":
    case "EVO082":
    case "EVO083":
      if ($from == "PLAY") {
        MZMoveCard($currentPlayer, "MYDISCARD:pitch=" . PitchValue($cardID) . ";type=AA;class=MECHANOLOGIST", "MYHAND", may: true);
      }
      return "";
    case "EVO087":
    case "EVO088":
    case "EVO089":
      if ($from == "PLAY") {
        AddCurrentTurnEffect($cardID, $currentPlayer);
        IncrementClassState($currentPlayer, $CS_DamagePrevention, 1);
      }
      return "";
    case "EVO100":
      $items = SearchDiscard($currentPlayer, subtype: "Item");
      $itemsCount = count(explode(",", $items));
      if ($itemsCount < $resourcesPaid) {
        WriteLog("Player " . $currentPlayer . " would need to banish " . $resourcesPaid . " items from their graveyard but they only have " . $itemsCount . " items in their graveyard.");
        RevertGamestate();
      }
      AddDecisionQueue("MULTICHOOSEDISCARD", $currentPlayer, $resourcesPaid . "-" . $items . "-" . $resourcesPaid, 1);
      AddDecisionQueue("SPECIFICCARD", $currentPlayer, "HYPERSCRAPPER");
      return "";
    case "EVO101":
      $numScrap = 0;
      $costAry = explode(",", $additionalCosts);
      for ($i = 0; $i < count($costAry); ++$i) if ($costAry[$i] == "SCRAP") ++$numScrap;
      if ($numScrap > 0) GainResources($currentPlayer, $numScrap * 2);
      return "";
    case "EVO102":
    case "EVO103":
    case "EVO104":
      if ($additionalCosts == "SCRAP") AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "EVO105":
    case "EVO106":
    case "EVO107":
      if (GetClassState($currentPlayer, $CS_NumItemsDestroyed) > 0) AddCurrentTurnEffect($cardID, $defPlayer);
      return "";
    case "EVO108":
    case "EVO109":
    case "EVO110":
      if ($additionalCosts == "SCRAP") PlayAura("WTR225", $currentPlayer);
      return "";
    case "EVO126":
    case "EVO127":
    case "EVO128":
      if ($additionalCosts == "SCRAP") AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "EVO129":
    case "EVO130":
    case "EVO131":
      if ($additionalCosts == "SCRAP") AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "EVO132":
    case "EVO133":
    case "EVO134":
      if ($additionalCosts == "SCRAP") {
        AddDecisionQueue("MULTIZONEINDICES", $currentPlayer, "MYITEMS:hasCrank=true");
        AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Choose a card with Crank to get a steam counter", 1);
        AddDecisionQueue("CHOOSEMULTIZONE", $currentPlayer, "<-", 1);
        AddDecisionQueue("MZADDCOUNTER", $currentPlayer, "-", 1);
      }
      return "";
    case "EVO135":
    case "EVO136":
    case "EVO137":
      if ($additionalCosts == "SCRAP") GainResources($currentPlayer, 1);
      return "";
    case "EVO140":
      for ($i = 0; $i < $resourcesPaid; $i += 2) AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "EVO141":
      if (GetClassState($mainPlayer, $CS_NumItemsDestroyed) > 0) AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "EVO143":
      if ($resourcesPaid == 0) return;
      AddDecisionQueue("MULTIZONEINDICES", $otherPlayer, "MYCHAR:type=E");
      AddDecisionQueue("PREPENDLASTRESULT", $otherPlayer, "MAXCOUNT-" . $resourcesPaid / 3 . ",MINCOUNT-" . $resourcesPaid / 3 . ",");
      AddDecisionQueue("SETDQCONTEXT", $otherPlayer, "Choose " . $resourcesPaid / 3 . " equipment for the effect of " . CardLink("EVO143", "EVO143") . ".");
      AddDecisionQueue("CHOOSEMULTIZONE", $otherPlayer, "<-", 1);
      AddDecisionQueue("MZSWITCHPLAYER", $currentPlayer, "<-", 1);
      AddDecisionQueue("CHOOSEMULTIZONE", $currentPlayer, "<-", 1);
      AddDecisionQueue("SPECIFICCARD", $currentPlayer, "MEGANETICLOCKWAVE");
      return "";
    case "EVO144":
      AddDecisionQueue("MULTIZONEINDICES", $mainPlayer, "THEIRITEMS:hasSteamCounter=true&THEIRCHAR:hasSteamCounter=true&MYITEMS:hasSteamCounter=true&MYCHAR:hasSteamCounter=true");
      AddDecisionQueue("SETDQCONTEXT", $mainPlayer, "Choose an equipment, item, or weapon. Remove all steam counters from it.");
      AddDecisionQueue("CHOOSEMULTIZONE", $mainPlayer, "<-", 1);
      AddDecisionQueue("MZREMOVECOUNTER", $currentPlayer, "-", 1);
      AddDecisionQueue("SYSTEMFAILURE", $currentPlayer, "<-", 1);
      return "";
    case "EVO145":
      $indices = SearchMultizone($currentPlayer, "MYITEMS:class=MECHANOLOGIST;maxCost=1");
      $indices = str_replace("MYITEMS-", "", $indices);
      $num = SearchCount($indices);
      $num = $resourcesPaid < $num ? $resourcesPaid : $num;
      AddDecisionQueue("MULTICHOOSEITEMS", $currentPlayer, $num . "-" . $indices . "-" . $num);
      AddDecisionQueue("SPECIFICCARD", $currentPlayer, "SYSTEMRESET");
      return "";
    case "EVO146":
      AddDecisionQueue("PASSPARAMETER", $currentPlayer, $additionalCosts, 1);
      AddDecisionQueue("MODAL", $currentPlayer, "FABRICATE", 1);
      return "";
    case "EVO153":
    case "EVO154":
    case "EVO155":
      if (GetClassState($currentPlayer, $CS_NumBoosted) >= 2) AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "EVO156":
    case "EVO157":
    case "EVO158":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "EVO222":
    case "EVO223":
    case "EVO224":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      MZMoveCard($currentPlayer, "MYBANISH:isSameName=ARC036", "", may: true);
      AddDecisionQueue("PUTPLAY", $currentPlayer, "0", 1);
      return "";
    case "EVO225":
    case "EVO226":
    case "EVO227":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "EVO228":
    case "EVO229":
    case "EVO230":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Choose a Hyper Driver to get a steam counter", 1);
      AddDecisionQueue("MULTIZONEINDICES", $currentPlayer, "MYITEMS:isSameName=ARC036");
      AddDecisionQueue("CHOOSEMULTIZONE", $currentPlayer, "<-", 1);
      AddDecisionQueue("MZADDCOUNTER", $currentPlayer, "-", 1);
      return "";
    case "EVO235":
      $options = GetChainLinkCards(($currentPlayer == 1 ? 2 : 1), "AA");
      if ($options != "") {
        AddDecisionQueue("CHOOSECOMBATCHAIN", $currentPlayer, $options);
        AddDecisionQueue("COMBATCHAINDEFENSEMODIFIER", $currentPlayer, -1, 1);
      }
      return "";
    case "EVO237":
      Draw($currentPlayer);
      $card = DiscardRandom();
      if (ModifiedAttackValue($card, $currentPlayer, "HAND", source: "EVO237") >= 6) {
        $items = SearchMultizone($currentPlayer, "THEIRITEMS&MYITEMS");
        if ($items != "") {
          $items = explode(",", $items);
          $destroyedItem = $items[GetRandom(0, count($items) - 1)];
          $destroyedItemID = GetMZCard($currentPlayer, $destroyedItem);
          WriteLog(CardLink("EVO237", "EVO237") . " destroys " . CardLink($destroyedItemID, $destroyedItemID) . ".");
          MZDestroy($currentPlayer, $destroyedItem, $currentPlayer);
        }
      }
      return "";
    case "EVO238":
      PlayAura("WTR075", $currentPlayer, number: $resourcesPaid);
      return "";
    case "EVO239":
      $cardsPlayed = explode(",", GetClassState($currentPlayer, $CS_NamesOfCardsPlayed));
      for ($i = 0; $i < count($cardsPlayed); ++$i) {
        if (CardName($cardsPlayed[$i]) == "Wax On") {
          PlayAura("CRU075", $currentPlayer);
          break;
        }
      }
      return "";
    case "EVO240":
      if (ArsenalHasFaceDownCard($otherPlayer)) {
        SetArsenalFacing("UP", $otherPlayer);
        if (SearchArsenal($otherPlayer, type: "DR") != "") {
          DestroyArsenal($otherPlayer, effectController: $currentPlayer);
          AddCurrentTurnEffect($cardID, $currentPlayer);
        }
      }
      return "";
    case "EVO242":
      $xVal = $resourcesPaid / 2;
      PlayAura("ARC112", $currentPlayer, $xVal);
      if ($xVal >= 6) {
        DiscardRandom($otherPlayer, $cardID, $currentPlayer);
        DiscardRandom($otherPlayer, $cardID, $currentPlayer);
        DiscardRandom($otherPlayer, $cardID, $currentPlayer);
      }
      return "";
    case "EVO245":
      Draw($currentPlayer);
      if (IsRoyal($currentPlayer)) Draw($currentPlayer);
      PrependDecisionQueue("OP", $currentPlayer, "BANISHHAND", 1);
      if (SearchCount(SearchHand($currentPlayer, pitch: 1)) >= 2) {
        PrependDecisionQueue("ELSE", $currentPlayer, "-");
        PitchCard($currentPlayer, "MYHAND:pitch=1");
        PitchCard($currentPlayer, "MYHAND:pitch=1");
        PrependDecisionQueue("NOPASS", $currentPlayer, "-");
        PrependDecisionQueue("YESNO", $currentPlayer, "if you want to pitch 2 red cards");
      }
      return "";
    case "EVO246":
      PutPermanentIntoPlay($currentPlayer, $cardID);
      return "";
    case "EVO247":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "EVO248":
      MZChooseAndDestroy($currentPlayer, "THEIRALLY:subtype=Angel");
      return "";
    case "EVO410":
      if (IsHeroAttackTarget()) PummelHit();
      return "";
    case "EVO434":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "EVO435":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "EVO436":
      AddCurrentTurnEffectNextAttack($cardID, $currentPlayer);
      return "";
    case "EVO437":
      AddDecisionQueue("MULTIZONEINDICES", $currentPlayer, "MYCHAR:type=W");
      AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Choose a weapon to attack an additional time");
      AddDecisionQueue("CHOOSEMULTIZONE", $currentPlayer, "<-", 1);
      AddDecisionQueue("MZOP", $currentPlayer, "ADDITIONALUSE", 1);
      return "";
    case "EVO446":
      Draw($currentPlayer);
      MZMoveCard($currentPlayer, "MYHAND", "MYTOPDECK", silent: true);
      return "";
    case "EVO447":
      AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Choose a card with Crank to get a steam counter", 1);
      AddDecisionQueue("MULTIZONEINDICES", $currentPlayer, "MYITEMS:hasCrank=true");
      AddDecisionQueue("CHOOSEMULTIZONE", $currentPlayer, "<-", 1);
      AddDecisionQueue("MZADDCOUNTER", $currentPlayer, "-", 1);
      return "";
    case "EVO448":
      MZMoveCard($currentPlayer, "MYHAND:subtype=Item;maxCost=1", "MYITEMS", may: true);
      return "";
    case "EVO449":
      PlayAura("WTR225", $currentPlayer);
      return "";
    default:
      return "";
  }
}

function PhantomTidemawDestroy($player = -1, $index = -1)
{
  global $mainPlayer;
  $auras = &GetAuras($player);
  if ($player == -1) {
    $player = $mainPlayer;
  }

  if ($index == -1) {
    for ($i = 0; $i < count($auras); $i++) {
      if (isset($auras[$i * AuraPieces()]) && $auras[$i * AuraPieces()] == "EVO244") {
        ++$auras[$i * AuraPieces() + 3];
      }
    }
  } else if ($index > -1) {
    ++$auras[$index + 3];
  }
}

function ModularMove($cardID, $uniqueID)
{
  global $currentPlayer;
  AddDecisionQueue("LISTEXPOSEDEQUIPSLOTS", $currentPlayer, "-");
  AddDecisionQueue("SETDQCONTEXT", $currentPlayer, "Choose an equipment zone to move " . CardLink($cardID, $cardID) . " to.", 1);
  AddDecisionQueue("BUTTONINPUT", $currentPlayer, "<-", 1);
  AddDecisionQueue("SETDQVAR", $currentPlayer, "0", 1);
  AddDecisionQueue("EQUIPCARD", $currentPlayer, $cardID . "-{0}", 1);
  AddDecisionQueue("REMOVEMODULAR", $currentPlayer, $uniqueID);
}