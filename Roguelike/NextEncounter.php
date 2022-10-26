<head>

<?php

  include '../Libraries/HTTPLibraries.php';

  //We should always have a player ID as a URL parameter
  $gameName=$_GET["gameName"];
  $playerID=TryGet("playerID", 3);

  //First we need to parse the game state from the file
  include "ZoneGetters.php";
  include "ParseGamestate.php";
  include "EncounterDictionary.php";
  include "../CardDictionary.php";
  include "../HostFiles/Redirector.php";
  include "../Libraries/UILibraries2.php";
  include "../WriteLog.php";
/*
  if($currentPlayer == $playerID) $icon = "ready.png";
  else $icon = "notReady.png";
  echo '<link rel="shortcut icon" type="image/png" href="./HostFiles/' . $icon . '"/>';
*/

?>

<style>
  td {
    text-align:center;
  }
</style>

<link rel="shortcut icon" type="image/png" href="../Images/TeenyCoin.png" />

</head>

<body style='z-index:-200;'>

<?php

$cardSize = 200;
$cardIconSize = intval($cardSize / 2.7); //40
$cardIconLeft = intval($cardSize / 4.2); //30
$cardIconTop = intval($cardSize / 4.2); //30

  //Include js files
  echo("<script src=\"../jsInclude.js\"></script>");
  echo("<script>SubmitInput = function(mode, params, fullRefresh = false){   var ajaxLink =
      'ProcessInput.php?gameName=' + document.getElementById('gameName').value;
    ajaxLink += '&playerID=' + document.getElementById('playerID').value;
    ajaxLink += '&authKey=' + document.getElementById('authKey').value;
    ajaxLink += '&mode=' + mode;
    ajaxLink += params;
    document.location = ajaxLink;
  }</script>");

  //Display hidden elements
  echo("<div id=\"cardDetail\" style=\"z-index:1000; display:none; position:absolute;\"></div>");
  echo("<div id=\"authKey\" style=\"display:none;\"></div>");


  $encounter = &GetZone($playerID, "Encounter");


  $health = &GetZone($playerID, "Health");

  $deck = &GetZone($playerID, "Deck");
  echo(CreatePopup("myDeckPopup", $deck, 1, 0, "Your Deck (" . count($deck) . " cards)", 1, "", "../", true));

  $character = &GetZone($playerID, "Character");

  //Display background
  echo("<div style='position:absolute; left:0px; top:0px; background-image:url(\"../Images/wooden-texture.jpg\"); width:100%; height:100%;'><div style='margin-left:1.5%; margin-top:1%; text-align:center;'><img style='height:94%; border: 3px solid black; border-radius: 5px;' src='../Images/map_of_rathe.jpg' /></div>");

  //Display left sidebar
  echo("<div style='position:absolute; text-align: center; z-index:100; border: 3px solid black; border-radius:5px; left:10px; top:17px; height:calc(95% - 26px); width:14%; background-color:rgba(235, 213, 179, .85);'>");
  echo("<h2 style='width:100%;'>Encounter #" . $encounter[0] . "</h2>");

  echo ("<div style='height:6vh; width:100%; z-index:-200;'><span title='Your remaining life' style='top: 10%; left: 50%; text-align: center; transform: translate(-50%, -50%); position:absolute; display:inline-block;'><img style='opacity: 0.9; height:" . $cardIconSize/1.5 . "; width:" . $cardIconSize/1.5 . ";' src='../Images/Life.png'>
      <div style='margin: 0; top: 50%; left: 50%; margin-right: -50%; width: 32px; height: 32px; padding: 1px;
      text-align: center; transform: translate(-50%, -50%); line-height: 1.2;
      position:absolute; font-size:32px; font-weight: 600; color: #EEE; text-shadow: 3px 0 0 #000, 0 -2px 0 #000, 0 2px 0 #000, -2px 0 0 #000;'>" . $health[0] . "</div></img></span></div>");

  echo("<center>" . Card($character[0], "../concat", $cardSize, 0, 1) . "</center>");
  echo("<BR>");

  echo("<center><div style='cursor:pointer;' onclick='(function(){ document.getElementById(\"myDeckPopup\").style.display = \"inline\";})();'>" . Card("CardBack", "../concat", $cardSize, 0, 1, 0, 0, count($deck)) . "</div></center>");

  $myDQ = &GetZone($playerID, "DecisionQueue");

  $encounterContent = "";
  if(count($myDQ) > 0)
  {
    if($myDQ[0] == "CHOOSECARD")
    {
      $options = explode(",", $myDQ[1]);
      //$encounterContent .= "<div style='position:absolute; text-align:center; top:30%; left: 250%; width:" . count($options)*155 . "; background-color: rgba(255,255,255,0.8); border: 3px solid black; border-radius: 5px;'>";
      $encounterContent .= "<h2>Choose a card</h2>";
      $encounterContent .= "<div style='display:inline;'>";
      for($i=0; $i<count($options); ++$i)
      {
        $encounterContent .= Card($options[$i], "../concat", 150, 1, 1, 0, 0, 0, strval($options[$i]));
      }
      $encounterContent .= "</div>";
      //$encounterContent .= "<div>";
    }
    else if($myDQ[0] == "BUTTONINPUT")
    {
      $encounterContent = "<div display:inline;'>";
      $options = explode(",", $myDQ[1]);
      for ($i = 0; $i < count($options); ++$i) {
        $encounterContent .= CreateButton($playerID, str_replace("_", " ", $options[$i]), 2, strval($options[$i]), "24px");
      }
      $encounterContent .= "</div>";
      $encounterContent .= "<BR>";
      //echo CreatePopup("BUTTONINPUT", [], 0, 1, "Choose a button", 1, $content);
    }
    else {
      $encounterContent .= "Bug. This phase not implemented: " . $myDQ[0];
    }
  }
  else {
    $encounterContent .= "<form style='width:100%;display:inline-block;' action='" . $redirectPath . "/Roguelike/PlayEncounter.php'>";
    $encounterContent .= "<input type='hidden' id='gameName' name='gameName' value='$gameName' />";
    $encounterContent .= "<input type='hidden' id='playerID' name='playerID' value='$playerID' />";
    $encounterContent .= "<input type='submit' style='font-size:20px;' value='Play Encounter' />";
    $encounterContent .= "</form>";
  }

  echo("</div>");//End cards div

  echo("</div>");//End left sidebar div

  $content = "<div style='width:800px;'>";
  $content .= "<center><img src='../crops/" . EncounterImage($encounter[0], $encounter[1]) . "' /></center>";
  $content .= "<BR>";
  $content .= "</div>";
  $content .= "<center>" . $encounterContent . "</center>";
  echo CreatePopup("BUTTONINPUT", [], 0, 1, EncounterDescription($encounter[0], $encounter[1]), 1, $content, overCombatChain:true);
  //EncounterImage($encounter[0], $encounter[1]);


  echo("</div>");//End background

  echo("</div>");//End play area div

  //Display the log
  echo("<div id='gamelog' style='background-color: rgba(255,255,255,0.8); border: 3px solid black; border-radius: 5px; position:fixed; display:inline; width:12%; height: 92%; top:2%; right:1%; overflow-y: scroll;'>");

  EchoLog($gameName, $playerID);
  echo("</div>");

  echo("<div id='chatbox' style='position:fixed; display:inline; width:200px; height: 50px; right:10px;'>");
  //echo("<input style='width:155px; display:inline;' type='text' id='chatText' name='chatText' value='' autocomplete='off' onkeypress='ChatKey(event)'>");
  //echo("<button style='display:inline;' onclick='SubmitChat()'>Chat</button>");
  echo("<input type='hidden' id='gameName' value='" . $gameName . "'>");
  echo("<input type='hidden' id='playerID' value='" . $playerID . "'>");

  function PlayableCardBorderColor($cardID)
  {
    if(HasReprise($cardID) && RepriseActive()) return 3;
    return 0;
  }

  function CanPassPhase($phase)
  {
    switch($phase)
    {
      case "P": return 0;
      case "PDECK": return 0;
      case "CHOOSEDECK": return 0;
      case "HANDTOPBOTTOM": return 0;
      case "CHOOSECOMBATCHAIN": return 0;
      case "CHOOSECHARACTER": return 0;
      case "CHOOSEHAND": return 0;
      case "CHOOSEHANDCANCEL": return 0;
      case "MULTICHOOSEDISCARD": return 0;
      case "CHOOSEDISCARDCANCEL": return 0;
      case "CHOOSEARCANE": return 0;
      case "CHOOSEARSENAL": return 0;
      case "CHOOSEDISCARD": return 0;
      case "MULTICHOOSEHAND": return 0;
      default: return 1;
    }
  }

  function IsDarkMode() { return false; } // This must exist for UILibraries2
  function IsLanguageJP() { return false; } // This must exist for UILibraries2
  function IsGameOver() { return false; } // This must exist for UILibraries2

?>
</body>
</div>


<!----- Footer ----->
<div style="height:11px; bottom:8px; left:20px; width: auto;
        position:absolute;
        color:white;
        font-size: .7em;
        font-style: italic; opacity: 0.8;
        font-weight: normal;
        text-indent: 1px;
        background-color:rgba(74, 74, 74, 0.9);
        border-radius: 2px;
        text-shadow: 2px 0 0 #1a1a1a, 0 -2px 0 #1a1a1a, 0 2px 0 #1a1a1a, -2px 0 0 #1a1a1a;
        ">Talishar is in no way affiliated with Legend Story Studios. Legend Story Studios®, Flesh and Blood™,
  and set names are trademarks of Legend Story Studios.
  Flesh and Blood characters, cards, logos, and art are property of Legend Story Studios.
  Card Images © Legend Story Studios
</div>
