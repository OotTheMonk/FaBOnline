<?php

use SendGrid\Mail\Mail;

// Check for empty input signup
function emptyInputSignup($username, $email, $pwd, $pwdRepeat) {
	if (empty($username) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

// Check invalid username
function invalidUid($username) {
	if(!ctype_alnum($username)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

// Check invalid email
function invalidEmail($email) {
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

// Check if passwords matches
function pwdMatch($pwd, $pwdrepeat) {
	if ($pwd !== $pwdrepeat) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

// Check if username is in database, if so then return data
function uidExists($conn, $username) {
	$conn = GetDBConnection();
  $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
	 	header("location: ../Signup.php?error=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "ss", $username, $email);
	mysqli_stmt_execute($stmt);

	// "Get result" returns the results from a prepared statement
	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	}
	else {
		$result = false;
		return $result;
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}

// Check if username is in database, if so then return data
function getUInfo($conn, $username) {
	$conn = GetDBConnection();
  $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_close($conn);
	 	header("location: ../Signup.php?error=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "ss", $username, $email);
	mysqli_stmt_execute($stmt);

	// "Get result" returns the results from a prepared statement
	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		mysqli_close($conn);
		return $row;
	}
	else {
		$result = false;
		mysqli_close($conn);
		return $result;
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}

// Insert new user into database
function createUser($conn, $username, $email, $pwd, $reportingServer=false) {
	if($reportingServer) $conn = GetReportingDBConnection();
	else $conn = GetDBConnection();
  $sql = "INSERT INTO users (usersUid, usersEmail, usersPwd) VALUES (?, ?, ?);";

	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
	 	header("location: ../Signup.php?error=stmtfailed");
		exit();
	}

	$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

	mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	header("location: ../Signup.php?error=none");
	exit();
}

// Check for empty input login
function emptyInputLogin($username, $pwd) {
	if (empty($username) || empty($pwd)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

// Log user into website
function loginUser($username, $pwd, $rememberMe) {
	$conn = GetDBConnection();
	$uidExists = uidExists($conn, $username);

	if ($uidExists === false) {
		mysqli_close($conn);
		header("location: ../Login.php?error=wronglogin");
		exit();
	}

	$pwdHashed = $uidExists["usersPwd"];
	$checkPwd = password_verify($pwd, $pwdHashed);

	if ($checkPwd === false) {
		mysqli_close($conn);
		header("location: ../Login.php?error=wronglogin");
		exit();
	}
	elseif ($checkPwd === true) {
		if(session_status() !== PHP_SESSION_ACTIVE) session_start();
		$_SESSION["userid"] = $uidExists["usersId"];
		$_SESSION["useruid"] = $uidExists["usersUid"];
		$_SESSION["useremail"] = $uidExists["usersEmail"];
		$_SESSION["userspwd"] = $uidExists["usersPwd"];
		$patreonAccessToken = $uidExists["patreonAccessToken"];
		$_SESSION["userKarma"] = $uidExists["usersKarma"];
		$_SESSION["greenThumb"] = $uidExists["greenThumbs"];
		$_SESSION["redThumb"] = $uidExists["redThumbs"];

		PatreonLogin($patreonAccessToken);

		if($rememberMe)
		{
			$cookie = hash("sha256", rand() . $_SESSION["userspwd"] . rand());
			setcookie("rememberMeToken", $cookie, time() + (86400 * 90), "/");
			storeRememberMeCookie($conn, $_SESSION["useruid"], $cookie);
		}
		session_write_close();

		mysqli_close($conn);
		header("location: ../MainMenu.php?error=none");
		exit();
	}
}

function loginFromCookie()
{
	$token = $_COOKIE["rememberMeToken"];
	$conn = GetDBConnection();
	$sql = "SELECT usersID, usersUid, usersEmail, patreonAccessToken, patreonRefreshToken, usersKarma FROM users WHERE rememberMeToken='$token'";
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_execute($stmt);
		$data = mysqli_stmt_get_result($stmt);
		$row = mysqli_fetch_array($data, MYSQLI_NUM);
		mysqli_stmt_close($stmt);
		if(session_status() !== PHP_SESSION_ACTIVE) session_start();
		if($row != null && count($row) > 0)
		{
			$_SESSION["userid"] = $row[0];
			$_SESSION["useruid"] = $row[1];
			$_SESSION["useremail"] = $row[2];
			$patreonAccessToken = $row[3];
			$patreonRefreshToken = $row[4];
			$_SESSION["userKarma"] = $row[5];
			PatreonLogin($patreonAccessToken);
		}
		else {
			unset($_SESSION["userid"]);
			unset($_SESSION["useruid"]);
			unset($_SESSION["useremail"]);
			unset($_SESSION["userKarma"]);
		}
		session_write_close();
	}
	mysqli_close($conn);
}

function storeRememberMeCookie($conn, $uuid, $cookie)
{
  $sql = "UPDATE users SET rememberMeToken='$cookie' WHERE usersUid='$uuid'";
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

function addFavoriteDeck($userID, $decklink, $deckName, $heroID)
{
	$conn = GetDBConnection();
	$deckName = implode("", explode("\"", $deckName));
	$deckName = implode("", explode("'", $deckName));
	$values = "'" . $decklink . "'," . $userID . ",'" . $deckName . "','" . $heroID . "'";
	$sql = "INSERT IGNORE INTO favoritedeck (decklink, usersId, name, hero) VALUES (" . $values. ");";
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
}

function LoadFavoriteDecks($userID)
{
	if($userID == "") return "";
	$conn = GetDBConnection();
	$sql = "SELECT decklink, name, hero from favoritedeck where usersId='$userID'";
	$stmt = mysqli_stmt_init($conn);
	$output = [];
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_execute($stmt);
		$data = mysqli_stmt_get_result($stmt);
	  while($row = mysqli_fetch_array($data, MYSQLI_NUM)) {
			for($i=0;$i<3;++$i) array_push($output, $row[$i]);
		}
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
	return $output;
}

//Challenge ID 1 = sigil of solace blue
//Challenge ID 2 = Talishar no dash
//Challenge ID 3 = Moon Wish
function logCompletedGameStats() {
	global $winner, $currentTurn, $gameName;//gameName is assumed by ParseGamefile.php
	global $p1id, $p2id, $p1IsChallengeActive, $p2IsChallengeActive, $p1DeckLink, $p2DeckLink, $firstPlayer;
	$loser = ($winner == 1 ? 2 : 1);
	$columns = "WinningHero, LosingHero, NumTurns, WinnerDeck, LoserDeck, WinnerHealth, FirstPlayer";
	$values = "?, ?, ?, ?, ?, ?, ?";
	$winnerDeck = file_get_contents("./Games/" . $gameName . "/p" . $winner . "Deck.txt");
	$loserDeck = file_get_contents("./Games/" . $gameName . "/p" . $loser . "Deck.txt");
	$winHero = &GetPlayerCharacter($winner);
	$loseHero = &GetPlayerCharacter($loser);

	$conn = GetDBConnection();

	if($p1id != "" && $p1id != "-")
	{
		$columns .= ", " . ($winner == 1 ? "WinningPID" : "LosingPID");
		$values .= ", " . $p1id;
	}
	if($p2id != "" && $p2id != "-")
	{
		$columns .= ", " . ($winner == 2 ? "WinningPID" : "LosingPID");
		$values .= ", " . $p2id;
	}

	$sql = "INSERT INTO completedgame (" . $columns . ") VALUES (" . $values . ");";
	$stmt = mysqli_stmt_init($conn);
	$gameResultID = 0;
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_bind_param($stmt, "sssssss", $winHero[0], $loseHero[0], $currentTurn, $winnerDeck, $loserDeck, GetHealth($winner), $firstPlayer);
		mysqli_stmt_execute($stmt);
		$gameResultID = mysqli_insert_id($conn);
		mysqli_stmt_close($stmt);
	}

	if($p1IsChallengeActive == "1" && $p1id != "-") LogChallengeResult($conn, $gameResultID, $p1id, ($winner == 1 ? 1 : 0));
	if($p2IsChallengeActive == "1" && $p2id != "-") LogChallengeResult($conn, $gameResultID, $p2id, ($winner == 2 ? 1 : 0));

	$p1Deck = ($winner == 1 ? $winnerDeck : $loserDeck);
	$p2Deck = ($winner == 2 ? $winnerDeck : $loserDeck);
	$p1Hero = ($winner == 1 ? $winHero[0] : $loseHero[0]);
	$p2Hero = ($winner == 2 ? $winHero[0] : $loseHero[0]);

	if(!AreStatsDisabled(1)) SendFabraryResults(1, $p1DeckLink, $p1Deck, $gameResultID, $p2Hero);
	if(!AreStatsDisabled(2)) SendFabraryResults(2, $p2DeckLink, $p2Deck, $gameResultID, $p1Hero);
	if(!AreStatsDisabled(1)) SendFabDBResults(1, $p1DeckLink, $p1Deck, $gameResultID, $p2Hero);
	if(!AreStatsDisabled(2)) SendFabDBResults(2, $p2DeckLink, $p2Deck, $gameResultID, $p1Hero);
	if(!AreStatsDisabled(1) && !AreStatsDisabled(2)) SendFullFabraryResults($gameResultID, $p1DeckLink, $p1Deck, $p1Hero, $p2DeckLink, $p2Deck, $p2Hero);
	mysqli_close($conn);
}

function LogChallengeResult($conn, $gameResultID, $playerID, $result)
{
	WriteLog("Writing challenge result for player " . $playerID);
	$challengeId = 3;
	$sql = "INSERT INTO challengeresult (gameId, challengeId, playerId, result) VALUES (?, ?, ?, ?);";
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_bind_param($stmt, "ssss", $gameResultID, $challengeId, $playerID, $result);//Challenge ID 1 = sigil of solace blue
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}


function SendFabDBResults($player, $decklink, $deck, $gameID, $opposingHero)
{
	global $fabDBToken, $fabDBSecret, $gameName, $p1deckbuilderID, $p2deckbuilderID;
	if(!str_contains($decklink, "fabdb.net")) return;

	$linkArr = explode("/", $decklink);
	$slug = array_pop($linkArr);

	$url = "https://api.fabdb.net/game/results/" . $slug;
	$ch = curl_init($url);
	$payload = SerializeGameResult($player, $decklink, $deck, $gameID, $opposingHero, $gameName);
	$payloadArr = json_decode($payload, true);
	$payloadArr["time"] = microtime();
	$payloadArr["hash"] = hash("sha512", $fabDBSecret . $payloadArr["time"]);
	$payloadArr["player"] = $player;
	$payloadArr["user"] = ($player == 1 ? $p1deckbuilderID : $p2deckbuilderID);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payloadArr));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$headers = array(
		"Authorization: Bearer " . $fabDBToken,
	);

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	$result = curl_exec($ch);
	$information = curl_getinfo($ch);
	curl_close($ch);
}

function SendFabraryResults($player, $decklink, $deck, $gameID, $opposingHero)
{
	global $FaBraryKey, $gameName;
	if(!str_contains($decklink, "fabrary.net")) return;

	$url = "https://5zvy977nw7.execute-api.us-east-2.amazonaws.com/prod/decks/01G7FD2B3YQAMR8NJ4B3M58H96/results";
	$ch = curl_init($url);
	$payload = SerializeGameResult($player, $decklink, $deck, $gameID, $opposingHero, $gameName);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$headers = array(
		"x-api-key: " . $FaBraryKey,
		"Content-Type: application/json",
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	curl_close($ch);
}

function SendFullFabraryResults($gameID, $p1Decklink, $p1Deck, $p1Hero, $p2Decklink, $p2Deck, $p2Hero)
{
	global $FaBraryKey, $gameName;
	$url = "https://5zvy977nw7.execute-api.us-east-2.amazonaws.com/prod/results";
	$ch = curl_init($url);
	$payloadArr = [];
	$payloadArr['gameID'] = $gameID;
	$payloadArr['gameName'] = $gameName;
	$payloadArr['deck1'] = json_decode(SerializeGameResult(1, $p1Decklink, $p1Deck, $gameID, $p2Hero, $gameName));
	$payloadArr['deck2'] = json_decode(SerializeGameResult(2, $p2Decklink, $p2Deck, $gameID, $p1Hero, $gameName));
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payloadArr));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$headers = array(
		"x-api-key: " . $FaBraryKey,
		"Content-Type: application/json",
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	curl_close($ch);
}

function SerializeGameResult($player, $DeckLink, $deckAfterSB, $gameID="", $opposingHero="", $gameName="")
{
	global $winner, $currentTurn, $CardStats_TimesPlayed, $CardStats_TimesBlocked, $CardStats_TimesPitched, $firstPlayer;
	$DeckLink = explode("/", $DeckLink);
	$DeckLink = $DeckLink[count($DeckLink)-1];
	$deckAfterSB = explode("\r\n", $deckAfterSB);
	if(count($deckAfterSB) == 1) return;
	$deckAfterSB = $deckAfterSB[1];
	$deck = [];
	if($gameID != "") $deck["gameId"] = $gameID;
	if($gameName != "") $deck["gameName"] = $gameName;
	$deck["deckId"] = $DeckLink;
	$deck["turns"] = intval($currentTurn);
	$deck["result"] = ($player == $winner ? 1 : 0);
	$deck["firstPlayer"] = ($player == $firstPlayer ? 1 : 0);
	if($opposingHero != "") $deck["opposingHero"] = $opposingHero;
	$deck["cardResults"] = [];
	$deckAfterSB = explode(" ", $deckAfterSB);
	$deduplicatedDeck = [];
	for($i=0; $i<count($deckAfterSB); ++$i)
	{
		if($i > 0 && $deckAfterSB[$i] == $deckAfterSB[$i-1]) continue;//Don't send duplicates
		array_push($deduplicatedDeck, $deckAfterSB[$i]);
	}
	for($i=0; $i<count($deduplicatedDeck); ++$i)
	{
		$deck["cardResults"][$i] = [];
		$deck["cardResults"][$i]["cardId"] = $deduplicatedDeck[$i];
		$deck["cardResults"][$i]["played"] = 0;
		$deck["cardResults"][$i]["blocked"] = 0;
		$deck["cardResults"][$i]["pitched"] = 0;
	}
	$cardStats = &GetCardStats($player);
	for($i=0; $i<count($cardStats); $i+=CardStatPieces())
	{
		for($j=0; $j<count($deck["cardResults"]); ++$j)
		{
			if($deck["cardResults"][$j]["cardId"] == $cardStats[$i])
			{
				$deck["cardResults"][$j]["played"] = $cardStats[$i+$CardStats_TimesPlayed];
				$deck["cardResults"][$j]["blocked"] = $cardStats[$i+$CardStats_TimesBlocked];
				$deck["cardResults"][$j]["pitched"] = $cardStats[$i+$CardStats_TimesPitched];
				break;
			}
		}
	}
	return json_encode($deck);
}

function UpdateKarma($p1value=0, $p2value=0)
{
	global $p1id, $p2id;

	$conn = GetDBConnection();
	$stmt = "";
	if($p1id != "" && $p1id != "-")
	{
		/*
		if($p1value < 0) {
			$sql = "SELECT usersKarma FROM users WHERE usersid='$p1id'";
			$result = mysqli_query($conn, $sql);
			$result = $result->fetch_array();
			$p1karma = intval($result[0]);
			if ($p1karma <= 10) $p1value = $p1value - ($p1karma + $p1value);
		}
		*/
		$sql = "UPDATE users SET usersKarma=IF(usersKarma < 100, usersKarma+$p1value, usersKarma) WHERE usersid='$p1id'"; // SET field = IF (condition, new value, field)
		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, $sql)) {
			mysqli_stmt_execute($stmt);
		}
	}
	if($p2id != "" && $p2id != "-")
	{
		/*
		if ($p2value < 0) {
			$sql = "SELECT usersKarma FROM users WHERE usersid='$p2id'";
			$result = mysqli_query($conn, $sql);
			$result = $result->fetch_array();
			$p2karma = intval($result[0]);
			if ($p2karma <= 10) $p2value = $p2value - ($p2karma + $p2value);
		}
		*/
		$sql = "UPDATE users SET usersKarma=IF(usersKarma < 100, usersKarma+$p2value, usersKarma) WHERE usersid='$p2id'"; // SET field = IF (condition, new value, field)
		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, $sql)) {
			mysqli_stmt_execute($stmt);
		}
	}
	if($stmt != ""){
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
}

function AddRating($player, $rating)
{
	global $p1id, $p2id;

	$dbID = ($player == 1 ? $p1id : $p2id);

	if($dbID != "" && $dbID != "-")
	{
		$conn = GetDBConnection();
		$sql = "UPDATE users SET " . $rating . "Thumbs=" . $rating . "Thumbs+1 WHERE usersid='$dbID'";
		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, $sql)) {
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		mysqli_close($conn);
	}
}

function SavePatreonTokens($accessToken, $refreshToken)
{
	if(!isset($_SESSION["userid"])) return;
	$userID = $_SESSION["userid"];
	$conn = GetDBConnection();
	$sql = "UPDATE users SET patreonAccessToken='$accessToken', patreonRefreshToken='$refreshToken' WHERE usersid='$userID'";
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
}

function LoadBadges($userID)
{
	if($userID == "") return "";
	$conn = GetDBConnection();
	$sql = "SELECT pb.playerId,pb.badgeId,pb.intVariable,bs.topText,bs.bottomText,bs.image,bs.link FROM playerbadge pb join badges bs on bs.badgeId = pb.badgeId WHERE pb.playerId = '$userID';";
	$stmt = mysqli_stmt_init($conn);
	$output = [];
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_execute($stmt);
		$data = mysqli_stmt_get_result($stmt);
	  while($row = mysqli_fetch_array($data, MYSQLI_NUM)) {
			for($i=0;$i<7;++$i) array_push($output, $row[$i]);
		}
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
	return $output;
}

function GetMyAwardableBadges($userID)
{
	if($userID == "") return "";
	$output = [];
	$conn = GetDBConnection();
	$sql = "select * from userassignablebadge where playerId=?";
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_bind_param($stmt, "s", $userID);
		mysqli_stmt_execute($stmt);
		$data = mysqli_stmt_get_result($stmt);
	  while($row = mysqli_fetch_array($data, MYSQLI_NUM)) {
			array_push($output, $row[0]);
		}
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
	return $output;
}

function AwardBadge($userID, $badgeID)
{
	if($userID == "") return "";
	$conn = GetDBConnection();
	$sql = "insert into playerbadge (playerId, badgeId, intVariable) values (?, ?, 1) ON DUPLICATE KEY UPDATE intVariable = intVariable + 1;";
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_bind_param($stmt, "ss", $userID, $badgeID);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
}

function SaveSetting($playerId, $settingNumber, $value)
{
	if($playerId == "") return;
	$conn = GetDBConnection();
	$sql = "insert into savedsettings (playerId, settingNumber, settingValue) values (?, ?, ?) ON DUPLICATE KEY UPDATE settingValue = VALUES(settingValue);";
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_bind_param($stmt, "sss", $playerId, $settingNumber, $value);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
}

function LoadSavedSettings($playerId)
{
	if($playerId == "") return [];
	$output = [];
	$conn = GetDBConnection();
	$sql = "select settingNumber,settingValue from `savedsettings` where playerId=(?)";
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_bind_param($stmt, "s", $playerId);
		mysqli_stmt_execute($stmt);
		$data = mysqli_stmt_get_result($stmt);
		while($row = mysqli_fetch_array($data, MYSQLI_NUM)) {
			array_push($output, $row[0]);
			array_push($output, $row[1]);
		}
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
	return $output;
}

function SendEmail($userEmail, $url) {
  include "../APIKeys/APIKeys.php";
  require '../vendor/autoload.php';

  $email = new Mail();
  $email->setFrom("no-reply@fleshandbloodonline.com", "No-Reply");
  $email->setSubject("Talishar Password Reset");
  $email->addTo($userEmail);
  $email->addContent(
      "text/html",
      "
        <p>
          We recieved a password reset request. The link to reset your password is below.
          If you did not make this request, you can ignore this email
        </p>
        <p>
          Here is your password reset link: </br>
          <a href=$url>Password Reset</a>
        </p>
      "
  );
  $sendgrid = new \SendGrid($sendgridKey);
  try {
      $response = $sendgrid->send($email);
      print $response->statusCode() . "\n";
      print_r($response->headers());
      print $response->body() . "\n";
  } catch (Exception $e) {
      echo 'Caught exception: '. $e->getMessage() ."\n";
  }
}

function BackupAuthkey($playerId, $authKey)
{
	if($playerId == "") return;
	$conn = GetDBConnection();
	$sql = "UPDATE users SET lastAuthKey=(?) WHERE usersId='$playerId'";
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_bind_param($stmt, "s", $authKey);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
}

function GetBackupAuthkey($playerId)
{
	if($playerId == "") return "";
	$authKey = "";
	$conn = GetDBConnection();
	$sql = "SELECT lastAuthKey from users WHERE usersId='$playerId'";
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_execute($stmt);
		$data = mysqli_stmt_get_result($stmt);
		$row = mysqli_fetch_array($data, MYSQLI_NUM);
		$authKey = $row[0];
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
	return $authKey;
}
