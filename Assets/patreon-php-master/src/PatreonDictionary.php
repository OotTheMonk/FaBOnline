<?php

enum ContentCreators : string
{
  case InstantSpeed = "0";
  case ManSant = "731";

  public function SessionName(): string
  {
    switch($this->value)
    {
      case "0": return "isInstantSpeedPatron";
      case "731": return "isManSantPatron";
      default: return "";
    }
  }

  public function PatreonLink(): string
  {
    switch($this->value)
    {
      case "0": return "https://www.patreon.com/instantspeedpod";
      case "731": return "https://www.patreon.com/ManSant";
      default: return "";
    }
  }

  public function ChannelLink(): string
  {
    switch($this->value)
    {
      case "0": return "https://www.youtube.com/playlist?list=PLIo1KFShm1L3e91QrlPG6ZdwfmqKk0NIP";
      case "731": return "https://www.youtube.com/@ManSantFaB";
      default: return "";
    }
  }

  public function BannerURL(): string
  {
    switch($this->value)
    {
      case "0": return "./Assets/patreon-php-master/assets/ContentCreatorImages/InstantSpeedBanner.webp";
      default: return "";
    }
  }

  public function HeroOverlayURL($heroID): string
  {
    switch($this->value)
    {
      case "0": //WatchFlake
        if(CardClass($heroID) == "GUARDIAN") return "./Assets/patreon-php-master/assets/ContentCreatorImages/Matt_anathos_overlay.webp";
        return "./Assets/patreon-php-master/assets/ContentCreatorImages/flakeOverlay.webp";
      case "731":
        return "./Assets/patreon-php-master/assets/ContentCreatorImages/ManSantLevia.webp";
      default: return "";
    }
  }

  public function NameColor(): string
  {
    switch($this->value)
    {
      case "0": return "rgb(2,190,253)";
      case "731": return "rgb(255,53,42)";
      default: return "";
    }
  }
}

enum PatreonCampaign : string
{
  //These ones have no patreon
  case Pummelowanko = "0";
  case DragonShieldProTeamWB = "1";
  case AscentGaming = "2";
  case EternalOracles = "3";
  case Luminaris = "4";
  case FABLAB = "5";
  case OnHit = "6";
  case SecondCycle = "7";
  case SonicDoom = "8";
  case TeamPummel = "9";
  case TeamEmperorsRome = "10";
  case SunflowerSamurai = "11";
  case ColdFoilControl = "12";
  case RighteousGaming = "13";
  case TeamTalishar = "14";
  case TeamTideBreakers = "15";
  case CupofTCG = "16";
  case ScowlingFleshBag = "17";
  case ThaiCardsShop = "18";
  case Talishar = "7198186";
  case PushThePoint = "7579026";
  case GoAgainGaming = "7329070";
  case RedZoneRogue = "1787491";
  case Fabrary = "8997252";
  case ManSant = "8955846";
  case AttackActionPodcast = "6839952";
  case ArsenalPass = "7285727";
  case TheTekloFoundry = "8635931";
  case FleshandCommonBlood = "8736344";
  case SinOnStream = "7593240";
  case FreshandBuds = "8458487";
  case Sloopdoop = "6996822";
  case DMArmada = "1919413";
  case TheCardGuyz = "7733166";
  case HomeTownTCG = "7009853";
  case FleshAndPod = "8338817";
  case Kappolo = "9361474";
  case LibrariansOfSolana = "3828539";
  case TheMetrixMetagame = "8951973";
  case TheTablePit = "9370276";
  case TCGTed = "9404423";
  case CardAdvantage = "8040288";
  case RavenousBabble = "10147920";
  case BlackWingStudios = "4006023";
  case OnHitEffect = "10811477";
  case DaganWhite = "9851977";
  case BrandaoTCG = "279086";
  case OffTheRailsTCG = "11184392";
  case Nxi = "11481720";
  case PvtVoid = "9408649";
  case WeMakeBest = "9734205";
  case MnRCast = "9574942";
  case OnTheBauble = "11561507";
  case GorganianTome = "9555916";
  case FABChaos = "8716783";
  case DailyFab = "11266104";
  case ThePlagueHive = "12144126";
  case Dropcast = "12245100";
  case FleshandBloodwithPablo = "12300349";
  case ChantsAndDaggers = "10956423";
  case Dazzyfizzle = "12977197";
  case Nikobru = "13586904";

  public function SessionID(): string
  {
    switch($this->value)
    {
      case "7198186": return "isPatron";
      case "7579026": return "isPtPPatron";
      case "7329070": return "isGoAgainGamingPatron";
      case "1787491": return "isRedZoneRoguePatron";
      case "8997252": return "isFabraryPatron";
      case "8955846": return "isManSantPatron";
      case "6839952": return "isAttackActionPodcastPatreon";
      case "7285727": return "isArsenalPassPatreon";
      case "8635931": return "isTheTekloFoundryPatreon";
      case "8736344": return "isFleshAndCommonBloodPatreon";
      case "7593240": return "isSinOnStreamPatreon";
      case "8458487": return "isFreshAndBudsPatreon";
      case "6996822": return "isSloopdoopPatron";
      case "1919413": return "isDMArmadaPatron";
      case "7733166": return "isTheCardGuyzPatron";
      case "7009853": return "isHomeTownTCGPatron";
      case "8338817": return "isFleshAndPodPatron";
      case "9361474": return "isKappoloPatron";
      case "3828539": return "isLibrariansOfSolanaPatron";
      case "8951973": return "isTheMetrixMetagamePatron";
      case "9370276": return "isTheTablePitPatron";
      case "9404423": return "isTCGTedPatron";
      case "8040288": return "isCardAdvantagePatron";
      case "10147920": return "isRavenousBabblePatron";
      case "4006023": return "isBlackWingStudiosPatron";
      case "10811477": return "isOnHitEffectPatron";
      case "9851977": return "isDaganWhitePatron";
      case "279086": return "isBrandaoTCGPatron";
      case "11184392": return "isOffTheRailsTCGPatron";
      case "11481720": return "isNxiPatron";
      case "9408649": return "isPvtVoidPatron";
      case "9734205": return "isWeMakeBestPatron";
      case "9574942": return "isMnRCastPatron";
      case "11561507": return "isOnTheBaublePatron";
      case "9555916": return "isGorganianTomePatron";
      case "8716783": return "isFABChaosPatron";
      case "11266104": return "isDailyFabPatron";
      case "12245100": return "isDropcastPatron";
      case "12300349": return "IsFleshandBloodwithPabloPatron";
      case "10956423": return "isChantsAndDaggersPatron";
      case "12977197": return "isDazzyfizzlePatron";
      case "13586904": return "isNikobruPatron";
      default: return "";
    }
  }

  public function CampaignName(): string
  {
    switch($this->value)
    {
      case "0": return "Pummelowanko";
      case "1": return "Dragon Shield Pro Team";
      case "2": return "AscentGaming";
      case "3": return "Eternal Oracles";
      case "4": return "Luminaris";
      case "5": return "FAB-LAB";
      case "6": return "OnHit";
      case "7": return "Second Cycle";
      case "8": return "Sonic Doom";
      case "9": return "Pummel 52100";
      case "10": return "Team Emperors Rome";
      case "11": return "Sunflower Samurai";
      case "12": return "Cold Foil Control";
      case "13": return "Righteous Gaming";
      case "14": return "Team Talishar";
      case "15": return "Team Tide Breakers";
      case "16": return "Cup of TCG";
      case "17": return "ScowlingFleshBag";
      case "18": return "Thai Cards Shop";
      case "7198186": return "Talishar";
      case "7579026": return "Push the Point";
      case "7329070": return "Go Again Gaming";
      case "1787491": return "Red Zone Rogue";
      case "8997252": return "Fabrary";
      case "8955846": return "Man Sant";
      case "6839952": return "Attack Action Podcast";
      case "7285727": return "Arsenal Pass";
      case "8635931": return "The Teklo Foundry";
      case "8736344": return "Flesh and Common Blood";
      case "7593240": return "Sin On Stream";
      case "8458487": return "Fresh and Buds";
      case "6996822": return "Sloopdoop";
      case "1919413": return "DM Armada";
      case "7733166": return "The Card Guyz";
      case "7009853": return "HomeTownTCG";
      case "8338817": return "Flesh And Pod";
      case "9361474": return "Kappolo";
      case "3828539": return "Librarians of Solana";
      case "8951973": return "The Metrix Metagame";
      case "9370276": return "The Table Pit";
      case "9404423": return "TCG Ted";
      case "8040288": return "Card Advantage";
      case "10147920": return "Ravenous Babble";
      case "4006023": return "Black Wing Studios";
      case "10811477": return "On Hit Effect";
      case "9851977": return "Dagan White";
      case "279086": return "BrandaoTCG";
      case "11184392": return "Off the Rails TCG";
      case "11481720": return "Nxi";
      case "9408649": return "PvtVoid";
      case "9734205": return "WeMakeBest";
      case "9574942": return "MnRCast";
      case "11561507": return "OnTheBauble";
      case "9555916": return "GorganianTome";
      case "8716783": return "FABChaos";
      case "11266104": return "DailyFab";
      case "12144126": return "ThePlagueHive";
      case "12245100": return "Dropcast";
      case "12300349": return "Flesh and Blood with Pablo";
      case "10956423": return "Chants and Daggers";
      case "12977197": return "Dazzyfizzle";
      case "13586904": return "Nikobru";
      default: return "";
    }
  }

  public function IsTeamMember($userName): string
  {
    switch($this->value)
    {
      case "0": return ($userName == "MrShub" || $userName == "duofanel" || $userName == "Matiisen" ||  $userName == "Pepowski" ||  $userName == "Seba_stian" ||  $userName == "NatAlien" ||  $userName == "dvooyas" || $userName == "Lukashu" || $userName == "Qwak" || $userName == "NatAlien");
      case "1": return ($userName == "TwitchTvFabschool" || $userName == "MattRogers" || $userName == "TariqPatel");
      case "2": return ($userName == "hometowntcg" || $userName == "ProfessorKibosh" || $userName == "criticalclover8" || $userName == "bomberman" || $userName == "woodjp64" || $userName == "TealWater" || $userName == "Bravosaur" || $userName == "DaganTheZookeeper" || $userName == "Dratylis" || $userName == "MoBogsly");
      case "3": return ($userName == "DeadSummer");
      case "4": return ($userName == "LeoLeo");
      case "5": return ($userName == "XIR");
      case "6": return ($userName == "wackzitt" || $userName == "RainyDays" || $userName == "HelpMeJace2" || $userName == "S1lverback55" || $userName == "VexingTie" || $userName == "Ragnell");
      case "7": return IsTeamSecondCycle($userName);
      case "8": return IsTeamSonicDoom($userName);
      case "9": return IsTeamPummel($userName);
      case "10": return IsTeamEmperorsRome($userName);
      case "11": return IsTeamSunflowerSamurai($userName);
      case "12": return IsTeamColdFoilControl($userName);
      case "13": return IsTeamRighteousGaming($userName);
      case "14": return IsTeamTalishar($userName);
      case "15": return IsTeamTideBreakers($userName);
      case "16": return IsTeamCupofTCG($userName);
      case "17": return IsTeamScowlingFleshBag($userName);
      case "18": return IsTeamThaiCardsShop($userName);
      case "7198186": return ($userName == "OotTheMonk");
      case "7579026": return ($userName == "Hamsack" || $userName == "BigMedSi" || $userName == "Tripp");
      case "7329070": return ($userName == "GoAgainGamingAz");
      case "1787491": return ($userName == "RedZoneRogue");
      case "8997252": return ($userName == "phillip");
      case "8955846": return ($userName == "Man_Sant");
      case "6839952": return ($userName == "chonigman" || $userName == "Ijaque");
      case "7285727": return ($userName == "Brendan" || $userName == "TheClub");
      case "8635931": return ($userName == "TheTekloFoundry");
      case "8736344": return ($userName == "Smithel");
      case "7593240": return ($userName == "SinOnStream");
      case "8458487": return ($userName == "FreshLord");
      case "6996822": return ($userName == "Sloopdoop");
      case "1919413": return ($userName == "DMArmada");
      case "7733166": return ($userName == "NamVoTCGz" || $userName == "AlexTheCardGuy" || $userName == "RegularDegular" || $userName == "joshlau7" || $userName == "WillyB" || $userName == "Spoofy" || $userName == "ItsSebBruh" || $userName == "Knight");
      case "7009853": return ($userName == "hometowntcg");
      case "8338817": return ($userName == "imjorman" || $userName == "ADavis83" || $userName == "loganpetersen");
      case "9361474": return ($userName == "kappolo");
      case "3828539": return ($userName == "Tee");
      case "8951973": return ($userName == "Wes" || $userName == "Brandon");
      case "9370276": return ($userName == "TheTablePitYT" || $userName == "TunaTCG");
      case "9404423": return ($userName == "TCGTed");
      case "8040288": return IsTeamCardAdvantage($userName);
      case "10147920": return ($userName == "RavenousBabble" || $userName == "Arty" || $userName == "jargowsky" || $userName == "Nick52cost" || $userName == "Boomerang" || $userName == "matthias" || $userName == "Repas801");
      case "4006023": return ($userName == "BlackWingStudio");
      case "10811477": return ($userName == "Mezzo");
      case "9851977": return ($userName == "DaganTheZookeeper" || $userName == "OotTheMonk");
      case "279086": return ($userName == "brandaotcg" || $userName == "OotTheMonk");
      case "11184392": return ($userName == "PatSmashGood" || $userName == "OotTheMonk");
      case "11481720": return ($userName == "nxi");
      case "9408649": return ($userName == "PvtVoid");
      case "9734205": return ($userName == "tog" || $userName == "bnet" || $userName == "balakay" || $userName == "PvtVoid");
      case "9574942": return ($userName == "Azor" || $userName == "PvtVoid");
      case "11561507": return ($userName == "PvtVoid");
      case "9555916": return ($userName == "Cathardigan" || $userName == "GorganianTome" || $userName == "PvtVoid");
      case "8716783": return IsTeamFABChaos($userName);
      case "11266104": return ($userName == "Lupinefiasco" || $userName == "PvtVoid");
      case "12144126": return ($userName == "Pentregarth" || $userName == "Archon Alters" || $userName == "PvtVoid");
      case "12245100": return ($userName == "PvtVoid" || $userName == "Smithel" || $userName == "Poopking" || $userName == "HeyLookItsBrice");
      case "12300349": return ($userName == "PvtVoid");
      case "10956423": return ($userName == "ChantsAndDaggers" || $userName == "OotTheMonk");
      case "12977197": return ($userName == "PvtVoid" || $userName == "dazzyfizzle" || $userName == "OotTheMonk");
      case "13586904": return ($userName == "PvtVoid" || $userName == "Nikobru");
      default: return "";
    }
  }

  public function AltArts(): string
  {
    switch($this->value)
    {
      //Talishar
      case "7198186": return "ELE183=ELE183-T,ELE222=ELE222-T,MST004=MST004-T,MST010=MST010-T,MST032=MST032-T,MST048=MST048-T,MST053=MST053-T,MST066=MST066-T,MST068=MST068-T,MST095=MST095-T,MST096=MST096-T,MST097=MST097-T,MST098=MST098-T,MST099=MST099-T,MST100=MST100-T,MST101=MST101-T,MST102=MST102-T,MST400=MST400-T,MST410=MST410-T,MST432=MST432-T,MST453=MST453-T,MST495=MST495-T,MST496=MST496-T,MST497=MST497-T,MST498=MST498-T,MST499=MST499-T,MST500=MST500-T,MST501=MST501-T,MST502=MST502-T,ROS022=ROS022-T,ROS028=ROS028-T,ROS036=ROS036-T,ROS042=ROS042-T,ROS043=ROS043-T,ROS044=ROS044-T,ROS045=ROS045-T,ROS070=ROS070-T,ROS082=ROS082-T,ROS088=ROS088-T,ROS089=ROS089-T,ROS090=ROS090-T,ROS091=ROS091-T,ROS110=ROS110-T,ROS111=ROS111-T,ROS112=ROS112-T,ROS113=ROS113-T,ROS114=ROS114-T,ROS133=ROS133-T,ROS149=ROS149-T,ROS155=ROS155-T,ROS161=ROS161-T,ROS168=ROS168-T,ROS173=ROS173-T,ROS182=ROS182-T,ROS210=ROS210-T,ROS211=ROS211-T,ROS217=ROS217-T,ROS218=ROS218-T,ROS226=ROS226-T,ROS230=ROS230-T,TCC048=TCC048-T,UPR194=UPR194-T,WTR092=WTR092-T,WTR172=WTR172-T,WTR173=WTR173-T,ARC159=ARC159-T,EVR008=EVR008-T,EVR009=EVR009-T,EVR010=EVR010-T,EVR105=EVR105-T,MON245=MON245-T,UPR187=UPR187-T,WTR001=WTR001-T,WTR002=WTR002-T,WTR098=WTR098-T,WTR099=WTR099-T,WTR100=WTR100-T,WTR150=WTR150-T,WTR162=WTR162-T,WTR224=WTR224-T,ARC191=ARC191-T,CRU082=CRU082-T,MON155=MON155-T,MON215=MON215-T,MON216=MON216-T,MON217=MON217-T,MON219=MON219-T,MON220=MON220-T,ELE146=ELE146-T,EVR020=EVR020-T,UPR006=UPR006-T,UPR007=UPR007-T,UPR008=UPR008-T,UPR009=UPR009-T,UPR010=UPR010-T,UPR011=UPR011-T,UPR012=UPR012-T,UPR013=UPR013-T,UPR014=UPR014-T,UPR015=UPR015-T,UPR016=UPR016-T,UPR017=UPR017-T,UPR042=UPR042-T,UPR043=UPR043-T,UPR169=UPR169-T,UPR406=UPR406-T,UPR407=UPR407-T,UPR408=UPR408-T,UPR409=UPR409-T,UPR410=UPR410-T,UPR411=UPR411-T,UPR412=UPR412-T,UPR413=UPR413-T,UPR414=UPR414-T,UPR415=UPR415-T,UPR416=UPR416-T,UPR417=UPR417-T,DYN001=DYN001-T,DYN005=DYN005-T,DYN026=DYN026-T,DYN045=DYN045-T,DYN065=DYN065-T,DYN068=DYN068-T,DYN088=DYN088-T,DYN092=DYN092-T,DYN121=DYN121-T,DYN151=DYN151-T,DYN171=DYN171-T,DYN192=DYN192-T,DYN212=DYN212-T,DYN213=DYN213-T,DYN234=DYN234-T,DYN492a=DYN492a-T,DYN492b=DYN492b-T,DYN492c=DYN492c-T,DYN612=DYN612-T,DTD005=DTD005-T,DTD006=DTD006-T,DTD007=DTD007-T,DTD008=DTD008-T,DTD009=DTD009-T,DTD010=DTD010-T,DTD011=DTD011-T,DTD012=DTD012-T,DTD164=DTD164-T,DTD564=DTD564-T,DTD405=DTD405-T,DTD406=DTD406-T,DTD407=DTD407-T,DTD408=DTD408-T,DTD409=DTD409-T,DTD410=DTD410-T,DTD411=DTD411-T,DTD412=DTD412-T,EVO010=EVO010-T,EVO026=EVO026-T,EVO027=EVO027-T,EVO028=EVO028-T,EVO029=EVO029-T,EVO030=EVO030-T,EVO031=EVO031-T,EVO032=EVO032-T,EVO033=EVO033-T,EVO410=EVO410-T,EVO410a=EVO410a-T,EVO410b=EVO410b-T,EVO426=EVO426-T,EVO427=EVO427-T,EVO428=EVO428-T,EVO429=EVO429-T,OUT231=OUT231-T,EVR063=EVR063-T,WTR031=WTR031-T,ELE200=ELE200-T,DYN206=DYN206-T,DYN207=DYN207-T,DYN208=DYN208-T,MON088=MON088-T,ARC026=ARC026-T,ELE082=ELE082-T,ARC200=ARC200-T,WTR191=WTR191-T,MON135=MON135-T,UPR039=UPR039-T,UPR221=UPR221-T,WTR170=WTR170-T";
      //PvtVoid
      case "9408649": return "ELE183=ELE183-T,ELE222=ELE222-T,MST004=MST004-T,MST010=MST010-T,MST032=MST032-T,MST048=MST048-T,MST053=MST053-T,MST066=MST066-T,MST068=MST068-T,MST095=MST095-T,MST096=MST096-T,MST097=MST097-T,MST098=MST098-T,MST099=MST099-T,MST100=MST100-T,MST101=MST101-T,MST102=MST102-T,MST400=MST400-T,MST410=MST410-T,MST432=MST432-T,MST453=MST453-T,MST495=MST495-T,MST496=MST496-T,MST497=MST497-T,MST498=MST498-T,MST499=MST499-T,MST500=MST500-T,MST501=MST501-T,MST502=MST502-T,ROS022=ROS022-T,ROS028=ROS028-T,ROS036=ROS036-T,ROS042=ROS042-T,ROS043=ROS043-T,ROS044=ROS044-T,ROS045=ROS045-T,ROS070=ROS070-T,ROS082=ROS082-T,ROS088=ROS088-T,ROS089=ROS089-T,ROS090=ROS090-T,ROS091=ROS091-T,ROS110=ROS110-T,ROS111=ROS111-T,ROS112=ROS112-T,ROS113=ROS113-T,ROS114=ROS114-T,ROS133=ROS133-T,ROS149=ROS149-T,ROS155=ROS155-T,ROS161=ROS161-T,ROS168=ROS168-T,ROS173=ROS173-T,ROS182=ROS182-T,ROS210=ROS210-T,ROS211=ROS211-T,ROS217=ROS217-T,ROS218=ROS218-T,ROS226=ROS226-T,ROS230=ROS230-T,TCC048=TCC048-T,UPR194=UPR194-T,WTR092=WTR092-T,WTR172=WTR172-T,WTR001=WTR001-T,WTR002=WTR002-T,WTR098=WTR098-T,WTR099=WTR099-T,WTR100=WTR100-T,WTR150=WTR150-T,WTR162=WTR162-T,WTR173=WTR173-T,WTR224=WTR224-T,ARC191=ARC191-T,CRU082=CRU082-T,MON155=MON155-T,MON215=MON215-T,MON216=MON216-T,MON217=MON217-T,MON219=MON219-T,MON220=MON220-T,ELE146=ELE146-T,EVR020=EVR020-T,UPR006=UPR006-T,UPR007=UPR007-T,UPR008=UPR008-T,UPR009=UPR009-T,UPR010=UPR010-T,UPR011=UPR011-T,UPR012=UPR012-T,UPR013=UPR013-T,UPR014=UPR014-T,UPR015=UPR015-T,UPR016=UPR016-T,UPR017=UPR017-T,UPR042=UPR042-T,UPR043=UPR043-T,UPR169=UPR169-T,UPR406=UPR406-T,UPR407=UPR407-T,UPR408=UPR408-T,UPR409=UPR409-T,UPR410=UPR410-T,UPR411=UPR411-T,UPR412=UPR412-T,UPR413=UPR413-T,UPR414=UPR414-T,UPR415=UPR415-T,UPR416=UPR416-T,UPR417=UPR417-T,DYN001=DYN001-T,DYN005=DYN005-T,DYN026=DYN026-T,DYN045=DYN045-T,DYN065=DYN065-T,DYN068=DYN068-T,DYN088=DYN088-T,DYN092=DYN092-T,DYN121=DYN121-T,DYN151=DYN151-T,DYN171=DYN171-T,DYN192=DYN192-T,DYN212=DYN212-T,DYN213=DYN213-T,DYN234=DYN234-T,DYN492a=DYN492a-T,DYN492b=DYN492b-T,DYN492c=DYN492c-T,DYN612=DYN612-T,DTD005=DTD005-T,DTD006=DTD006-T,DTD007=DTD007-T,DTD008=DTD008-T,DTD009=DTD009-T,DTD010=DTD010-T,DTD011=DTD011-T,DTD012=DTD012-T,DTD164=DTD164-T,DTD564=DTD564-T,DTD405=DTD405-T,DTD406=DTD406-T,DTD407=DTD407-T,DTD408=DTD408-T,DTD409=DTD409-T,DTD410=DTD410-T,DTD411=DTD411-T,DTD412=DTD412-T,EVO010=EVO010-T,EVO026=EVO026-T,EVO027=EVO027-T,EVO028=EVO028-T,EVO029=EVO029-T,EVO030=EVO030-T,EVO031=EVO031-T,EVO032=EVO032-T,EVO033=EVO033-T,EVO410=EVO410-T,EVO410a=EVO410a-T,EVO410b=EVO410b-T,EVO426=EVO426-T,EVO427=EVO427-T,EVO428=EVO428-T,EVO429=EVO429-T,OUT231=OUT231-T,EVR063=EVR063-T,WTR031=WTR031-T,ELE200=ELE200-T,DYN206=DYN206-T,DYN207=DYN207-T,DYN208=DYN208-T,MON088=MON088-T,ARC026=ARC026-T,ELE082=ELE082-T,ARC200=ARC200-T,WTR191=WTR191-T,MON135=MON135-T,UPR039=UPR039-T,UPR221=UPR221-T,WTR170=WTR170-T";      
      //ManSant
      case "8955846": return "MON119=MON119-ManSant,MON120=MON120-ManSant,HVY240=HVY240-ManSant,HVY241=HVY241-ManSant";
      //Brandao
      case "279086": return "ARC001=ARC001-Brandao,ARC113=ARC113-Brandao,CRU077=CRU077-Brandao,ELE031=ELE031-Brandao,OUT091=OUT091-Brandao,UPR001=UPR001-Brandao,WTR038=WTR038-Brandao,ARC003=ARC003-Brandao,CRU079=CRU079-Brandao,CRU080=CRU080-Brandao,CRU197=CRU197-Brandao,ELE111=ELE111-Brandao,UPR003=UPR003-Brandao,UPR042=UPR042-Brandao,UPR043=UPR043-Brandao,WTR040=WTR040-Brandao,WTR075=WTR075-Brandao,ARC112=ARC112_Brandao,CRU049=CRU049_Brandao,DTD134=DTD134_Brandao,DTD135=DTD135_Brandao,EVO004=EVO004_Brandao,EVO006=EVO006_Brandao,EVO234=EVO234_Brandao,WTR076=WTR076_Brandao,WTR078=WTR078_Brandao,CRU004=CRU004_Brandao,CRU005=CRU005_Brandao,DTD232=DTD232_Brandao,WTR001=WTR001_Brandao,WTR113=WTR113_Brandao,WTR115=WTR115_Brandao";
      //TeamTalishar
      case "14": return "ELE109=ELE109-Promo,ELE110=ELE110-Promo";
      default: return "";
    }
  }

  public function CardBacks(): string
  {
    switch($this->value)
    {
      case "0": return "27";
      case "1": return "28";
      case "2": return "37";
      case "3": return "42";
      case "4": return "45";
      case "5": return "46";
      case "6": return "48";
      case "7": return "49";
      case "8": return "55";
      case "9": return "64";
      case "10": return "67";
      case "11": return "70";
      case "12": return "75";
      case "13": return "77,78";
      case "14": return "82,83";
      case "15": return "84";
      case "16": return "87";
      case "17": return "88";
      case "18": return "96";
      case "7198186": return "1,2,3,4,5,6,7,8,82,83";
      case "7579026": return "9";
      case "7329070": return "10,11,12,13,14,15,16";
      case "1787491": return "17,18,19,20";
      case "8997252": return "21,22,57,58,59,60,61,62";
      case "8955846": return "23,52";
      case "6839952": return "24";
      case "7285727": return "25";
      case "8635931": return "26";
      case "8736344": return "29";
      case "7593240": return "30";
      case "8458487": return "31";
      case "6996822": return "32";
      case "1919413": return "33";
      case "7733166": return "35";
      case "7009853": return "36";
      case "8338817": return "38";
      case "9361474": return "39";
      case "3828539": return "40";
      case "8951973": return "41";
      case "9370276": return "43";
      case "9404423": return "44";
      case "8040288": return "47";
      case "10147920": return "50";
      case "4006023": return "51";
      case "10811477": return "53";
      case "9851977": return "54";
      case "279086": return "56";
      case "11184392": return "63";
      case "11481720": return "65";
      case "9408649": return "1,2,3,4,5,6,7,8,82,83";
      case "9734205": return "68,69";
      case "9574942": return "71";
      case "11561507": return "72";
      case "9555916": return "73";
      case "8716783": return "74";
      case "11266104": return "76";
      case "12144126": return "79";
      case "12245100": return "80";
      case "12300349": return "81";
      case "10956423": return "85,86";
      case "12977197": return "89,90,91,92,93,94,95";
      case "13586904": return "97";
      default: return "";
    }
  }
}
