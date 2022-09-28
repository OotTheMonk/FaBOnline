<?php

include_once 'Header.php';
include "HostFiles/Redirector.php";


if (isset($_SESSION["userid"])) {
  $uidExists = getUInfo($conn, $_SESSION['useruid']);
  $_SESSION["userKarma"] = $uidExists["usersKarma"];
  $_SESSION["greenThumb"] = $uidExists["greenThumbs"];
  $_SESSION["redThumb"] = $uidExists["redThumbs"];
}

if (!empty($_SESSION['error'])) {
  $error = $_SESSION['error'];
  unset($_SESSION['error']);
  echo "<script>alert('" . $error . "')</script>";
}

?>

<style>
  body {
    background-image: url('Images/background_UPR.jpg');
    background-position: top center;
    background-repeat: no-repeat;
    background-size: cover;
    overflow: hidden;
  }
</style>

<div class="FabLogo" style="background-image: url('Images/TalisharLogo.webp');"></div>

<div class="ServerChecker">
  <?php
  include "ServerChecker.php";
  ?>
</div>

<div class="CreateGame_Menu">
  <h1 style="margin-top: 3px;">Create New Game</h1>

  <?php
  echo ("<form style='width:100%;display:inline-block;' action='" . $redirectPath . "/CreateGame.php'>");

  $favoriteDecks = [];
  if (isset($_SESSION["userid"])) {
    $favoriteDecks = LoadFavoriteDecks($_SESSION["userid"]);
    if (count($favoriteDecks) > 0) {
      echo ("<div class='FavoriteDeckMainMenu'>Favorite Decks: ");
      echo ("<select name='favoriteDecks' id='favoriteDecks'>");
      for ($i = 0; $i < count($favoriteDecks); $i += 3) {
        echo ("<option value='" . $favoriteDecks[$i] . "'>" . $favoriteDecks[$i + 1] . "</option>");
      }
      echo ("</select></div>");
    }
  }
  if (count($favoriteDecks) == 0) {
    echo ("<div class='FavoriteDeckMainMenu'>CC Starter Decks: ");
    echo ("<select name='decksToTry' id='decksToTry'>");
    echo ("<option value='1'>Bravo CC Starter Deck</option>");
    echo ("<option value='2'>Rhinar CC Starter Deck</option>");
    echo ("<option value='3'>Katsu CC Starter Deck</option>");
    echo ("<option value='4'>Dorinthea CC Starter Deck</option>");
    echo ("<option value='5'>Dash CC Starter Deck</option>");
    echo ("<option value='6'>Viserai CC Starter Deck</option>");
    echo ("<option value='7'>Kano CC Starter Deck</option>");
    echo ("<option value='8'>Azalea CC Starter Deck</option>");
    echo ("<option value='9'>Prism Blitz Starter Deck</option>");
    echo ("<option value='10'>Levia Blitz Starter Deck</option>");
    echo ("<option value='11'>Boltyn Blitz Starter Deck</option>");
    echo ("<option value='12'>Chane Blitz Starter Deck</option>");
    echo ("<option value='13'>Oldhim BlitzStarter Deck</option>");
    echo ("<option value='14'>Briar Blitz Starter Deck</option>");
    echo ("<option value='15'>Lexi Blitz Starter Deck</option>");
    echo ("<option value='16'>Fai Blitz Starter Deck</option>");
    echo ("<option value='17'>Dromai Blitz Starter Deck</option>");
    echo ("</select></div>");
  }
  echo ("<br>");

  ?>
    <label for="fabdb" style='font-weight:bolder; margin-left:10px;'>Deck Link:</label>
    <input type="text" id="fabdb" name="fabdb">
  <?php
  if (isset($_SESSION["userid"])) {
    echo ("<span style='display:inline;'>");
    echo ("<input class='inputFavoriteDeck' type='checkbox' id='favoriteDeck' name='favoriteDeck' />");
    echo ("<label title='Save deck to Favorites' for='favoriteDeck' style='margin-left:10px;'></label>");
    echo ("</span>");
  }
  echo ("<br>");
  ?>
  <br>
    <label for="gameDescription" style='font-weight:bolder; margin-left:10px;'>Game Name:</label>
    <input type="text" id="gameDescription" name="gameDescription" placeholder="Game #"><br><br>

  <?php
  if (isset($_SESSION["userid"])) {
    echo ("<label for='gameKarmaRestriction' style='font-weight:bolder; margin-left:20px;'>Restrict by Reputation:</label>");
    echo ("<select class='karmaRestriction-Select' style='margin-left:10px;' name='gameKarmaRestriction' id='gameKarmaRestriction'>");
    echo ("<option value='0'>No Restriction</option>");
    if ($_SESSION["userKarma"] >= 50) echo ("<option value='50'>☯ ≥ 50% - Exclude players with a karma below 50% (Bad reputation).</option>");
    if ($_SESSION["userKarma"] >= 75) echo ("<option value='75'>☯ ≥ 75% - Only players with a good reputation. Exclude players without accounts.</option>");
    if ($_SESSION["userKarma"] >= 85) echo ("<option value='85'>☯ ≥ 85% - Only players with a very good reputation, while excluding new players.</option>");
    echo ("</select><br><br>");
  }
  ?>

    <input type="radio" id="blitz" name="format" value="blitz">
    <label style='margin-left:-10px;' for="blitz">Blitz</label>

  <input style='margin-left: 10px;' type="radio" id="compblitz" name="format" value="compblitz">
  <label for="compblitz">Competitive Blitz</label>
  <br class="BRMobile">

  <input style='margin-left: 10px;' type="radio" id="cc" name="format" value="cc" checked="checked">
  <label for="cc">CC</label>
  <br class="BRMobile">

  <input style='margin-left: 10px;' type="radio" id="compcc" name="format" value="compcc">
  <label for="compcc">Competitive CC</label>
  <br class="BRMobile">

  <br><br>
    <input style='margin-left: 5px;' type="radio" id="commoner" name="format" value="commoner">
    <label style='margin-left:-12px;' for="commoner">Commoner</label>


   <input style='margin-left: 5px;' type="radio" id="livinglegendscc" name="format" value="livinglegendscc">
   <label style='margin-left:-12px;' for="livinglegendscc">Living Legends CC ❓</label>
  <br><br>

    <input type="radio" id="public" name="visibility" value="public" checked="checked">
    <label style='margin-left:-12px;' for="public">Public</label>

    <input type="radio" id="private" name="visibility" value="private">
    <label style='margin-left:-12px;' for="private">Private</label><br><br>

  <input style="margin-left: 20px;" type="checkbox" id="deckTestMode" name="deckTestMode" value="deckTestMode">
  <label for="deckTestMode">Single Player Mode</label><br><br>
  <div style="text-align:center;">

    <label>
      <input class="CreateGame_Button" type="submit" value="Create Game">
    </label>

  </div>
  </form>


  <?php
  //echo("<form style='width:100%;display:inline-block;' action='" . $redirectPath . "/PVE/PVEMenu.php'>");
  ?>
  <!---<div style="text-align:center;"><input type="submit" style="font-size:20px;" value="PVE Menu"></div>
</form>
--->
</div>
</div>

<div class="NewsMenu">

  <h1>Open Beta Test</h1>
  <p style='margin:10px; font-size:13px;'><b>Disclaimer: </b>Talishar is a fan-made project that is still under active development. There are still many bugs, although we try to improve it a little bit each day.</p>

  <h3 style='text-align:center;'>________</h3>

  <div style="position: relative;">
    <div style='vertical-align:middle; text-align:center;'>

      <h2>Now supporting decks from FaB Meta!</h2>
      <a href='https://www.fabmeta.net' target='_blank'><img style="margin-left:5%; margin-right:5%; width:90%; border-radius:5%;" src="./Images/logos/fabmeta_logo.svg" /></a><br><br>

      <!--
  <div style=" padding-top:10%; vertical-align:middle; position: relative;">
    <div style="vertical-align:middle; position: relative;">
      <h2>Coax a Commotion #3!<br>[Ending Soon!]</h2>
      <h4>Win as many games as you can <br>with Moon Wish</h4><br>
      <img style="margin-left:5%; margin-right:5%; width:90%; border-radius:5%;" src="./Images/challenges/moonwish.png" /><br><br>
      <p style="width:90%; padding-left:5%; font-size:small;">Must be logged in with (4 in blitz / 6 in CC) copies of Moon Wish in your deck <i>after sideboarding</i> for the challenge to work. Check back soon for results!</p>
    </div>
    <div style='text-align:center;'><a href='./ChallengeLeaderboard.php'>Leaderboard</a></div>
-->

      <h3 style='text-align:center;'>________</h3>

      <div style='vertical-align:middle; text-align:center;'>
        <h2 style="width:100%; text-align:center; color:rgb(220, 220, 220); font-size:20px;">Learn to Play Talishar</h2>
        <a title='English' href='https://youtu.be/zxQStzZPVGI' target=' _blank'><img style='height:30px;' src='./Images/flags/uk.png' /></a>
        <!-- <a title='Italian' href='https://youtu.be/xj5vg1BsNPk' target='_blank'><img style='height:30px;' src='./Images/flags/italy.png' /></a> -->
        <a title='Spanish' href='https://youtu.be/Rr-TV3kRslk' target=' _blank'><img style='height:30px;' src='./Images/flags/spain.png' /></a>
        <br>
        <p style="text-align: center; font-size:small; width:90%; padding-left:5%;">If you make a video in another language, let us know on Discord!</p>
      </div>

    </div>
  </div>
  <?php
  include_once 'Footer.php';
  ?>