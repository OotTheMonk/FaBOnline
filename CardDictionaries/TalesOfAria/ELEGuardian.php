<?php


  function ELEGuardianCardType($cardID)
  {
    switch($cardID)
    {
      case "ELE001": case "ELE002": return "C";
      case "ELE003": return "W";
      case "ELE004": return "AA";
      case "ELE005": return "AA";
      case "ELE006": return "I";
      case "ELE007": case "ELE008": case "ELE009": return "DR";
      case "ELE010": case "ELE011": case "ELE012": return "DR";
      case "ELE013": case "ELE014": case "ELE015": return "AA";
      case "ELE016": case "ELE017": case "ELE018": return "AA";
      case "ELE019": case "ELE020": case "ELE021": return "AA";
      case "ELE022": case "ELE023": case "ELE024": return "AA";
      case "ELE025": case "ELE026": case "ELE027": return "A";
      case "ELE028": case "ELE029": case "ELE030": return "A";
      case "ELE202": return "W";
      case "ELE203": case "ELE204": return "E";
      case "ELE205": return "A";
      case "ELE206": case "ELE207": case "ELE208": return "A";
      case "ELE209": case "ELE210": case "ELE211": return "AA";
      default: return "";
    }
  }

  function ELEGuardianCardSubType($cardID)
  {
    switch($cardID)
    {
      case "ELE003": return "Hammer";
      case "ELE025": case "ELE026": case "ELE027":
      case "ELE028": case "ELE029": case "ELE030": return "Aura";
      case "ELE202": return "Hammer";
      case "ELE203": case "ELE204": return "Off-Hand";
      case "ELE206": case "ELE207": case "ELE208": return "Aura";
      default: return "";
    }
  }

  //Minimum cost of the card
  function ELEGuardianCardCost($cardID)
  {
    switch($cardID)
    {
      case "ELE004": return 4;
      case "ELE005": return 3;
      case "ELE006": return 2;
      case "ELE007": case "ELE008": case "ELE009": return 2;
      case "ELE010": case "ELE011": case "ELE012": return 2;
      case "ELE013": case "ELE014": case "ELE015": return 3;
      case "ELE016": case "ELE017": case "ELE018": return 6;
      case "ELE019": case "ELE020": case "ELE021": return 4;
      case "ELE022": case "ELE023": case "ELE024": return 3;
      case "ELE025": case "ELE026": case "ELE027": return 2;
      case "ELE028": case "ELE029": case "ELE030": return 2;
      case "ELE205": Return 3;
      case "ELE206": case "ELE207": case "ELE208": return 4;
      case "ELE209": case "ELE210": case "ELE211": return 4;
      default: return 0;
    }
  }

  function ELEGuardianPitchValue($cardID)
  {
    switch($cardID)
    {
      case "ELE004": case "ELE005": return 1;
      case "ELE006": return 3;
      case "ELE007": case "ELE010": case "ELE013": case "ELE016": case "ELE019": case "ELE022": case "ELE025": case "ELE028": return 1;
      case "ELE008": case "ELE011": case "ELE014": case "ELE017": case "ELE020": case "ELE023": case "ELE026": case "ELE029": return 2;
      case "ELE009": case "ELE012": case "ELE015": case "ELE018": case "ELE021": case "ELE024": case "ELE027": case "ELE030": return 3;
      //Normal Guardian
      case "ELE205": return 3;
      case "ELE206": case "ELE209": return 1;
      case "ELE207": case "ELE210": return 2;
      case "ELE208": case "ELE211": return 3;
      default: return 0;
    }
  }

  function ELEGuardianBlockValue($cardID)
  {
    switch($cardID)
    {
      case "ELE001": case "ELE002": case "ELE003": return -1;
      case "ELE006": return -1;
      case "ELE007": return 4;
      case "ELE008": return 3;
      case "ELE009": return 2;
      case "ELE010": return 6;
      case "ELE011": return 5;
      case "ELE012": return 4;
      case "ELE202": return -1;
      case "ELE203": return 0;
      case "ELE204": return 1;
      default: return 3;
    }
  }

  function ELEGuardianAttackValue($cardID)
  {
    switch($cardID)
    {
      case "ELE003": return 4;
      case "ELE004": return 8;
      case "ELE005": return 7;
      case "ELE016": return 10;
      case "ELE017": return 9;
      case "ELE018": case "ELE019": return 8;
      case "ELE013": case "ELE020": case "ELE022": return 7;
      case "ELE014": case "ELE021": case "ELE023": return 6;
      case "ELE015": case "ELE024": return 5;
      //Normal Guardian
      case "ELE202": return 3;
      case "ELE209": return 6;
      case "ELE210": return 5;
      case "ELE211": return 4;
      default: return 0;
    }
  }

  function ELEGuardianPlayAbility($cardID, $from, $resourcesPaid, $target, $additionalCosts)
  {
    global $currentPlayer, $CS_DamagePrevention;
    $rv = "";
    switch($cardID)
    {
      case "ELE001": case "ELE002":
        $pitchArr = explode(",", $additionalCosts);
        $earthPitched = 0; $icePitched = 0;
        for($i=0; $i<count($pitchArr); ++$i)
        {
          if(TalentContains($pitchArr[$i], "EARTH", $currentPlayer)) $earthPitched = 1;
          if(TalentContains($pitchArr[$i], "ICE", $currentPlayer)) $icePitched = 1;
        }
        $rv = "";
        if($earthPitched)
        {
          IncrementClassState($currentPlayer, $CS_DamagePrevention, 2);
          $rv .= "Prevent the next 2 damage that would be dealt to Oldhim this turn. ";
        }
        if($icePitched)
        {
          if(IsAllyAttacking())
          {
            $rv .= "<span style='color:red;'>No card is put on top because there is no attacking hero when allies attack.</span>";
          }
          else
          {
            $otherPlayer = ($currentPlayer == 1 ? 2 : 1);
            AddDecisionQueue("FINDINDICES", $otherPlayer, "HAND");
            AddDecisionQueue("CHOOSEHAND", $otherPlayer, "<-", 1);
            AddDecisionQueue("MULTIREMOVEHAND", $otherPlayer, "-", 1);
            AddDecisionQueue("MULTIADDTOPDECK", $otherPlayer, "-", 1);
            $rv .= "The opponent must put a card from their hand on top of their deck.";
          }
        }
        return $rv;
      case "ELE003":
        $pitchArr = explode(",", $additionalCosts);
        $icePitched = 0;
        for($i=0; $i<count($pitchArr); ++$i)
        {
          if(TalentContains($pitchArr[$i], "ICE", $currentPlayer)) $icePitched = 1;
        }
        if($icePitched)
        {
          AddCurrentTurnEffect($cardID, $currentPlayer);
          $rv .= "If this hits, your opponent gains a Frostbite.";
        }
        return $rv;
      case "ELE005":
        if(DelimStringContains($additionalCosts, "ICE") && DelimStringContains($additionalCosts, "EARTH"))
        {
          AddCurrentTurnEffect($cardID, $currentPlayer);
          WriteLog(CardLink($cardID, $cardID) . " gets +2, Dominate, and discards cards on hit.");
        }
        return "";
      case "ELE006":
        if(DelimStringContains($additionalCosts, "EARTH")) AddDecisionQueue("AWAKENINGTOKENS", $currentPlayer, "-");
        AddDecisionQueue("AWAKENINGTOKENS", $currentPlayer, "-", 1);
        AddDecisionQueue("FINDINDICES", $currentPlayer, $cardID);
        AddDecisionQueue("MAYCHOOSEDECK", $currentPlayer, "<-", 1);
        AddDecisionQueue("ADDMYHAND", $currentPlayer, "-", 1);
        AddDecisionQueue("REVEALCARDS", $currentPlayer, "-", 1);
        AddDecisionQueue("SHUFFLEDECK", $currentPlayer, "-");
        return "";
      case "ELE205":
        AddCurrentTurnEffect($cardID, $currentPlayer);
        return "Gives your next Guardian attack +1, Dominate, and discards 2 on hit.";
      case "ELE206": case "ELE207": case "ELE208":
        if(NumNonTokenAura($currentPlayer) > 1) { $rv = "Draws a card."; MyDrawCard(); }
        return $rv;
      default: return "";
    }
  }

  function ELEGuardianHitEffect($cardID)
  {
    global $defPlayer, $combatChainState, $CCS_AttackFused;
    switch($cardID)
    {
      case "ELE004":
        if(IsHeroAttackTarget())
        {
          AddCurrentTurnEffect($cardID . "-HIT", $defPlayer);
          AddNextTurnEffect($cardID . "-HIT", $defPlayer);
          WriteLog(CardLink($cardID, $cardID) . " makes the defending player get a frostbite when activating an ability until the end of their next turn.");
        }
        break;
      case "ELE013": case "ELE014": case "ELE015":
        if(IsHeroAttackTarget() && $combatChainState[$CCS_AttackFused])
        {
          AddNextTurnEffect($cardID, $defPlayer);
          WriteLog(CardLink($cardID, $cardID) . " gives the opponent's first attack next turn -2.");
        }
        break;
      case "ELE209": case "ELE210": case "ELE211":
        if(IsHeroAttackTarget() && HasIncreasedAttack())
        {
          PummelHit();
        }
        break;
      default: break;
    }
  }


?>
