<?php


  function MONRunebladeCardType($cardID)
  {
    switch($cardID)
    {
      case "MON153": case "MON154": return "C";
      case "MON155": return "W";
      case "MON156": return "AA";
      case "MON157": return "A";
      case "MON158": return "I";
      case "MON159": case "MON160": case "MON161": return "AA";
      case "MON162": case "MON163": case "MON164": return "A";
      case "MON165": case "MON166": case "MON167": return "A";
      case "MON168": case "MON169": case "MON170": return "AA";
      case "MON171": case "MON172": case "MON173": return "AA";
      case "MON174": case "MON175": case "MON176": return "AA";
      case "MON177": case "MON178": case "MON179": return "AA";
      case "MON180": case "MON181": case "MON182": return "AA";
      case "MON183": case "MON184": case "MON185": return "A";
      case "MON186": return "T";
      case "MON229": return "W";
      case "MON230": return "E";
      case "MON231": return "A";
      case "MON232": case "MON233": case "MON234": return "AA";
      case "MON235": case "MON236": case "MON237": return "AA";
      case "MON406": case "MON407": return "M";
      default: return "";
    }
  }

  function MONRunebladeCardSubType($cardID)
  {
    switch($cardID)
    {
      case "MON155": return "Sword";
      case "MON157": return "Aura";
      case "MON229": return "Scythe";
      case "MON230": return "Chest";
      default: return "";
    }
  }

  //Minimum cost of the card
  function MONRunebladeCardCost($cardID)
  {
    switch($cardID)
    {
      case "MON156": return 0;
      case "MON157": return 2;
      case "MON158": return 1;
      case "MON159": case "MON160": case "MON161": return 1;
      case "MON162": case "MON163": case "MON164": return 1;
      case "MON165": case "MON166": case "MON167": return 3;
      case "MON168": case "MON169": case "MON170": return 0;
      case "MON171": case "MON172": case "MON173": return 2;
      case "MON174": case "MON175": case "MON176": return 1;
      case "MON177": case "MON178": case "MON179": return 2;
      case "MON180": case "MON181": case "MON182": return 2;
      case "MON183": case "MON184": case "MON185": return 0;
      case "MON232": case "MON233": case "MON234": return 1;
      case "MON235": case "MON236": case "MON237": return 0;
      default: return 0;
    }
  }

  function MONRunebladePitchValue($cardID)
  {
    switch($cardID)
    {
      case "MON156": return 3;
      case "MON157": return 2;
      case "MON158": return 3;
      case "MON159": case "MON162": case "MON165": case "MON168": case "MON171": case "MON174": case "MON177": case "MON180": case "MON183": return 1;
      case "MON160": case "MON163": case "MON166": case "MON169": case "MON172": case "MON175": case "MON178": case "MON181": case "MON184": return 2;
      case "MON161": case "MON164": case "MON167": case "MON170": case "MON173": case "MON176": case "MON179": case "MON182": case "MON185": return 3;
      case "MON231": case "MON232": case "MON235": return 1;
      case "MON233": case "MON236": return 2;
      case "MON234": case "MON237": return 3;
      case "MON407": return 0;
      default: return 0;
    }
  }

  function MONRunebladeBlockValue($cardID)
  {
    switch($cardID)
    {
      case "MON153": case "MON154": case "MON155": return -1;
      case "MON158": return -1;
      case "MON162": case "MON163": case "MON164": return 2;
      case "MON165": case "MON166": case "MON167": return 2;
      case "MON183": case "MON184": case "MON185": return 2;
      case "MON229": return -1;
      case "MON230": return 1;
      case "MON231": return 2;
      default: return 3;
    }
  }

  function MONRunebladeAttackValue($cardID)
  {
    switch($cardID)
    {
      case "MON155": return 1;
      case "MON156": return 2;
      case "MON159": case "MON171": case "MON177": case "MON180": return 4;
      case "MON160": case "MON168": case "MON172": case "MON174": case "MON178": case "MON181": return 3;
      case "MON161": case "MON169": case "MON173": case "MON175": case "MON179": case "MON182": return 2;
      case "MON170": case "MON176": return 1;
      //Normal Runeblade
      case "MON229": case "MON232": case "MON235": return 3;
      case "MON233": case "MON236": return 2;
      case "MON234": case "MON237": return 1;
      default: return 0;
    }
  }

  function MONRunebladePlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts)
  {
    global $currentPlayer, $CS_DynCostResolved;
    $otherPlayer = ($currentPlayer == 1 ? 2 : 1);
    $rv = "";
    switch($cardID)
    {
      case "MON153": case "MON154":
        PlayAura("MON186", $currentPlayer, 1, true);
        AddCurrentTurnEffect($cardID, $currentPlayer);
        return "Creates a " . CardLink("MON186", "MON186") . " and gives your next Runeblade or Shadow action this turn go again.";
      case "MON158":
        AddDecisionQueue("FINDINDICES", $otherPlayer, $cardID);
        AddDecisionQueue("MULTICHOOSETHEIRDISCARD", $currentPlayer, "<-", 1);
        AddDecisionQueue("MULTIREMOVEDISCARD", $otherPlayer, "-", 1);
        AddDecisionQueue("MULTIBANISH", $otherPlayer, "DISCARD,NA", 1);
        AddDecisionQueue("INVERTEXISTENCE", $currentPlayer, "-", 1);
        return "";
      case "MON159": case "MON160": case "MON161":
        AddDecisionQueue("FINDINDICES", $currentPlayer, $cardID);
        AddDecisionQueue("MAYCHOOSEDISCARD", $currentPlayer, "<-", 1);
        AddDecisionQueue("REMOVEDISCARD", $currentPlayer, "-", 1);
        AddDecisionQueue("ADDBOTDECK", $currentPlayer, "-", 1);
        AddDecisionQueue("SHOWSELECTEDCARD", $currentPlayer, "-", 1);
        return "Lets you put a non-attack action card with Blood Debt from your graveyard to your deck.";
      case "MON162": case "MON163": case "MON164":
        if($cardID == "MON162") $optAmt = 3;
        else if($cardID == "MON163") $optAmt = 2;
        else $optAmt = 1;
        Opt($cardID, $optAmt);
        AddDecisionQueue("FINDINDICES", $currentPlayer, "TOPDECK");
        AddDecisionQueue("DECKCARDS", $currentPlayer, "<-", 1);
        AddDecisionQueue("REVEALCARDS", $currentPlayer, "-", 1);
        AddDecisionQueue("DIMENXXIONALGATEWAY", $currentPlayer, "-", 1);
        return "Lets you Opt.";
      case "MON165": case "MON166": case "MON167":
        AddCurrentTurnEffect($cardID, $currentPlayer);
        return "Gives your next attack +1 and go again.";
      case "MON168": case "MON169": case "MON170":
        if($from == "BANISH")
        {
          AddCurrentTurnEffect($cardID, $currentPlayer);
          $rv = "Gains +1 because it was played from Banish.";
        }
        return $rv;
      case "MON174": case "MON175": case "MON176":
        if($from == "BANISH")
        {
          AddCurrentTurnEffect($cardID, $currentPlayer);
          $rv = "Gains +X because it was played from Banish.";
        }
        return $rv;
      case "MON177": case "MON178": case "MON179":
        if($from == "BANISH")
        {
          DealArcane(1, 0, "PLAYCARD", $cardID);
        }
        return "";
      case "MON183": case "MON184": case "MON185":
        AddCurrentTurnEffect($cardID, $currentPlayer);
        return "Deals 1 arcane damage to the next attack action card of certain cost.";
      case "MON229":
        if (!IsAllyAttackTarget()) {
          DealArcane(1, 0, "PLAYCARD", $cardID);
        }
        return "";
      case "MON230":
        GainResources($currentPlayer, 2);
        return "Gain 2 resources.";
      case "MON231":
        $xVal = GetClassState($currentPlayer, $CS_DynCostResolved)/2;
        $numRevealed = 3 + $xVal;
        WriteLog(CardLink($cardID, $cardID) . " reveals " . $numRevealed . " cards.");
        AddDecisionQueue("FINDINDICES", $currentPlayer, "FIRSTXDECK," . $numRevealed);
        AddDecisionQueue("DECKCARDS", $currentPlayer, "<-", 1);
        AddDecisionQueue("REVEALCARDS", $currentPlayer, "-", 1);
        AddDecisionQueue("SONATAARCANIX", $currentPlayer, "-", 1);
        AddDecisionQueue("MULTICHOOSEDECK", $currentPlayer, "<-", 1);
        AddDecisionQueue("MULTIREMOVEDECK", $currentPlayer, "-", 1);
        AddDecisionQueue("MULTIADDHAND", $currentPlayer, "1", 1);
        AddDecisionQueue("SONATAARCANIXSTEP2", $currentPlayer, "-", 1);
        AddDecisionQueue("SHUFFLEDECK", $currentPlayer, "-");
        return "";
      case "MON232": case "MON233": case "MON234":
        DealArcane(2, 0, "PLAYCARD", $cardID);
        return "";
      case "MON235": case "MON236": case "MON237":
        DealArcane(1, 0, "PLAYCARD", $cardID);
        return "";
      default: return "";
    }
  }

  function MONRunebladeHitEffect($cardID)
  {
    global $mainPlayer;
    switch($cardID)
    {
      case "MON155":
        if(IsHeroAttackTarget())
        {
          DealArcane(1, 0, "PLAYCARD", "MON155", false, $mainPlayer);
        }
        break;
      default: break;
    }
  }

  function SoulShackleStartTurn($player)
  {
    $deck = &GetDeck($player);
    if(count($deck) > 0)
    {
      $card = array_shift($deck);
      BanishCardForPlayer($card, $player, "DECK", "-");
    }
  }

  function InvertExistenceIndices($player)
  {
    $discard = &GetDiscard($player);
    if(count($discard) == 0) return "";
    $rv = (count($discard) == 1 ? "1" : "2") . "-";
    $rv .= GetIndices(count($discard));
    return $rv;
  }

  function DimenxxionalCrossroadsPassive($cardID, $from)
  {
    global $currentPlayer, $CS_NumAttackCards, $CS_NumNonAttackCards;
    if($from != "BANISH") return;
    $type = CardType($cardID);
    if(($type == "AA" && GetClassState($currentPlayer, $CS_NumAttackCards) == 1) || $type == "A" && GetClassState($currentPlayer, $CS_NumNonAttackCards) == 1)
    {
      DealArcane(1, 0, "PLAYCARD", "MON157");
    }
  }

  function LordSutcliffeAbility($player, $index)
  {
    global $currentPlayer;
    WriteLog(CardLink("MON407", "MON407") . " deals 1 arcane damage to each player.");
    DealArcane(1, 0, "ABILITY", "MON407", false, 1);
    AddDecisionQueue("LESSTHANPASS", $currentPlayer, "1");
    AddDecisionQueue("LORDSUTCLIFFE", $currentPlayer, $index, 1);
    DealArcane(1, 0, "ABILITY", "MON407", false, 2);
    AddDecisionQueue("LESSTHANPASS", $currentPlayer, "1");
    AddDecisionQueue("LORDSUTCLIFFE", $currentPlayer, $index, 1);
  }

  function LordSutcliffeAfterDQ($player, $parameter)
  {
    $index = $parameter;
    $arsenal = &GetArsenal($player);
    if (!ArsenalEmpty($player)) {
      $arsenal[$index+3] += 1;
      if($arsenal[$index+3] >= 3)
      {
        WriteLog(CardLink("MON407", "MON407") . " searched for a specialization card.");
        RemoveArsenal($player, $index);
        BanishCardForPlayer("MON407", $player, "ARS", "-");
        AddDecisionQueue("FINDINDICES", $player, "DECKSPEC");
        AddDecisionQueue("MAYCHOOSEDECK", $player, "<-", 1);
        AddDecisionQueue("ADDARSENALFACEUP", $player, "DECK", 1);
        AddDecisionQueue("SHUFFLEDECK", $player, "-", 1);
      }
    }
  }

?>
