<?php

ob_start();
include "HostFiles/Redirector.php";
include "Libraries/HTTPLibraries.php";
include "Libraries/SHMOPLibraries.php";
ob_end_clean();

$format = "blitz";
$visibility = "private";
$gameDescription = "Draft game";
$karmaRestriction = TryGet("gameKarmaRestriction", "0");

$gcFile = fopen("HostFiles/GameIDCounter.txt", "r+");
$attemptCount = 0;

while (!flock($gcFile, LOCK_EX) && $attemptCount < 30) {  // acquire an exclusive lock
  sleep(1);
  ++$attemptCount;
}
if ($attemptCount == 30) {
  header("Location: " . $redirectorPath . "MainMenu.php"); //We never actually got the lock
}
$counter = intval(fgets($gcFile));
//$gameName = hash("sha256", $counter);
$gameName = $counter;
ftruncate($gcFile, 0);
rewind($gcFile);
fwrite($gcFile, $counter + 1);
flock($gcFile, LOCK_UN);    // release the lock
fclose($gcFile);

if ( (!file_exists("Games/$gameName")) && (mkdir("Games/$gameName", 0700, true)) ){
} else {
  print_r("Encountered a problem creating a game. Please return to the main menu and try again");
}

$p1Data = [1];
$p2Data = [2];
$gameStatus = 0; //Initial
$firstPlayerChooser = "";
$firstPlayer = 1;
$p1Key = hash("sha256", rand() . rand());
$p2Key = hash("sha256", rand() . rand() . rand());
$p1uid = "-";
$p2uid = "-";
$p1id = "-";
$p2id = "-";
$hostIP = $_SERVER['REMOTE_ADDR'];

$filename = "./Games/" . $gameName . "/GameFile.txt";
$gameFileHandler = fopen($filename, "w");
include "MenuFiles/WriteGamefile.php";
WriteGameFile();

$filename = "./Games/" . $gameName . "/gamelog.txt";
$handler = fopen($filename, "w");
fclose($handler);

$currentTime = round(microtime(true) * 1000);
WriteCache($gameName, 1 . "!" . $currentTime . "!" . $currentTime . "!0!-1!" . $currentTime . "!!!0!0"); //Initialize SHMOP cache for this game

echo($gameName);
