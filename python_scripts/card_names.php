function CardName ($cardID)
{
    $arr = str_split($cardID, 3);
    $set = $arr[0];
    $num = $arr[1];
    

if ($set == "ARC")
	{  switch($num)	   {

		case "000": return "Eye of Ophidia";
		case "001": return "Dash, Inventor Extraordinaire";
		case "002": return "Dash";
		case "003": return "‘Teklo Plasma Pistol";
		case "004": return "Teklo Foundry Heart";
		case "005": return "Achilles Accelerator";
		case "006": return "High Octane";
		case "007": return "Teklo Core";
		case "008": return "Maximum Velocity";
		case "009": return "Spark of Genius";
		case "010": return "Induction Chamber";
		case "011": return "Pedal to the Metal";
		case "012": return "Pedal to the Metal";
		case "013": return "Pedal to the Metal";
		case "014": return "Pour the Mold";
		case "015": return "Pour the Mold";
		case "016": return "Pour the Mold";
		case "017": return "Aether Sink";
		case "018": return "Cognition Nodes";
		case "019": return "Convection Amplifier";
		case "020": return "Qver Loop";
		case "021": return "Qver Loop";
		case "022": return "Qver Loop";
		case "023": return "Throttle";
		case "024": return "Throttle";
		case "025": return "Throttle";
		case "026": return "Zero to Sixty";
		case "027": return "Zero to Sixty";
		case "028": return "Zero to Sixty";
		case "029": return "Zipper Hit";
		case "030": return "Zipper Hit";
		case "031": return "Zipper Hit";
		case "032": return "Locked and Loaded";
		case "033": return "Locked and Loaded";
		case "034": return "Locked and Loaded";
		case "035": return "Dissipation Shield";
		case "036": return "Hyper Driver";
		case "037": return "Optekal Monocle";
		case "038": return "Azalea, Ace in the Hole";
		case "039": return "£ Azalea o";
		case "040": return "Death Dealer";
		case "041": return "Skullbone Crosswrap";
		case "042": return "Bull's Eye Bracers";
		case "043": return "Red in the Ledger";
		case "044": return "Three of a Kind";
		case "045": return "Endless Arrow";
		case "046": return "Nock the Deathwhistle";
		case "047": return "Rapid Fire";
		case "048": return "Take Cover";
		case "049": return "Take Cover";
		case "050": return "Take Cover";
		case "051": return "Silver the Tip";
		case "052": return "Silver the Tip";
		case "053": return "Silver the Tip";
		case "054": return "Take Aim";
		case "055": return "Take Aim";
		case "056": return "Take Aim";
		case "057": return "Head Shot";
		case "058": return "Head Shot";
		case "059": return "Head Shot";
		case "060": return "Hamstring Shot";
		case "061": return "Hamstring Shot";
		case "062": return "Hamstring Shot";
		case "063": return "Ridge Rider Shot";
		case "064": return "Ridge Rider Shot";
		case "065": return "Ridge Rider Shot";
		case "066": return "Salvage Shot";
		case "067": return "Salvage Shot";
		case "068": return "Salvage Shot";
		case "069": return "Searing Shot";
		case "070": return "Searing Shot";
		case "071": return "Searing Shot";
		case "072": return "Sic 'Em Shot";
		case "073": return "Sic 'Em Shot";
		case "074": return "Sic 'Em Shot";
		case "075": return "Viserai, Rune Blood";
		case "076": return "Viserai";
		case "077": return "Nebula Blade";
		case "078": return "Grasp of the Arknight";
		case "079": return "Crown of Dichotomy";
		case "080": return "Arknight Ascendancy";
		case "081": return "Mordred Tide";
		case "082": return "Ninth Blade of the Blood Oatt";
		case "083": return "Become the Arknight";
		case "084": return "Tome of the Arknight";
		case "085": return "Spellblade Assault";
		case "086": return "Spellblade Assault";
		case "087": return "Spellblade Assault";
		case "088": return "Reduce to Runechant";
		case "089": return "Reduce to Runechant";
		case "090": return "Reduce to Runechant";
		case "091": return "Qath of the Arknight";
		case "092": return "Qath of the Arknight";
		case "093": return "Qath of the Arknight";
		case "094": return "Amplify the Arknight";
		case "095": return "Amplify the Arknight";
		case "096": return "Amplify the Arknight";
		case "097": return "Drawn to the Dark Dimension";
		case "098": return "Drawn to the Dark Dimension";
		case "099": return "Drawn to the Dark Dimension";
		case "100": return "Rune Flash";
		case "101": return "Rune Flash";
		case "102": return "Rune Flash";
		case "103": return "Spellblade Strike";
		case "104": return "Spellblade Strike";
		case "105": return "Spellblade Strike";
		case "106": return "Bloodspill Invocation";
		case "107": return "Bloodspill Invocation";
		case "108": return "Bloodspill Invocation";
		case "109": return "Read the Runes";
		case "110": return "Read the Runes";
		case "111": return "Read the Runes";
		case "112": return "Runechant";
		case "113": return "Cano, Dracai of Aether";
		case "114": return "Kano";
		case "115": return "rucible of Aetherweav";
		case "116": return "Storm Striders";
		case "117": return "Robe of Rapture";
		case "118": return "~ Blazing Aether";
		case "119": return "Sonic Boom";
		case "120": return "Forked Lightning";
		case "121": return "Lesson in Lava";
		case "122": return "Tome of Aetherwind";
		case "123": return "Absorb in Aether";
		case "124": return "Absorb in Aether";
		case "125": return "Absorb in Aether";
		case "126": return "Aether Spindle";
		case "127": return "Aether Spindle";
		case "128": return "Aether Spindle";
		case "129": return "Stir the Aetherwinds";
		case "130": return "Stir the Aetherwinds";
		case "131": return "Stir the Aetherwinds";
		case "132": return "Aether Flare";
		case "133": return "Aether Flare";
		case "134": return "Aether Flare";
		case "135": return "Index";
		case "136": return "Index";
		case "137": return "Index";
		case "138": return "Reverberate";
		case "139": return "Reverberate";
		case "140": return "Reverberate";
		case "141": return "Scalding Rain";
		case "142": return "Scalding Rain";
		case "143": return "Scalding Rain";
		case "144": return "Zap";
		case "145": return "Zap";
		case "146": return "Zap";
		case "147": return "Voltic Bolt";
		case "148": return "Voltic Bolt";
		case "149": return "Voltic Bolt";
		case "150": return "Arcanite Skullcap";
		case "151": return "Talismanic Lens";
		case "152": return "Vest of the First Fist";
		case "153": return "Bracers of Beliet";
		case "154": return "Mage Master Boots";
		case "155": return "Nullrune Hood";
		case "156": return "Nullrune Robe";
		case "157": return "Nullrune Gloves";
		case "158": return "Nullrune Boots";
		case "159": return "Command and Conquer";
		case "160": return "Art of War";
		case "161": return "Pursuit of Knowledge";
		case "162": return "Chains of Eminence";
		case "163": return "Rusted Relic";
		case "164": return "Life for a Life";
		case "165": return "Life for a Life";
		case "166": return "Life for a Life";
		case "167": return "Enchanting Melody";
		case "168": return "Enchanting Melody";
		case "169": return "Enchanting Melody";
		case "170": return "Plunder Run";
		case "171": return "Plunder Run";
		case "172": return "Plunder Run";
		case "173": return "Eirina's Prayer";
		case "174": return "Eirina's Prayer";
		case "175": return "Eirina's Prayer";
		case "176": return "Back Alley Breakline";
		case "177": return "Back Alley Breakline";
		case "178": return "Back Alley Breakline";
		case "179": return "Cadaverous Contraband";
		case "180": return "Cadaverous Contraband";
		case "181": return "Cadaverous Contraband";
		case "182": return "Fervent Forerunner";
		case "183": return "Fervent Forerunner";
		case "184": return "Fervent Forerunner";
		case "185": return "Moon Wish";
		case "186": return "Moon Wish";
		case "187": return "Moon Wish";
		case "188": return "Push the Point";
		case "189": return "Push the Point";
		case "190": return "Push the Point";
		case "191": return "Ravenous Rabble";
		case "192": return "Ravenous Rabble";
		case "193": return "Ravenous Rabble";
		case "194": return "Rifting";
		case "195": return "Rifting";
		case "196": return "Rifting";
		case "197": return "Vigor Rush";
		case "198": return "Vigor Rush";
		case "199": return "Vigor Rush";
		case "200": return "Fate Foreseen";
		case "201": return "Fate Foreseen";
		case "202": return "Fate Foreseen";
		case "203": return "Come to Fight";
		case "204": return "Come to Fight";
		case "205": return "Come to Fight";
		case "206": return "Force Sight";
		case "207": return "Force Sight";
		case "208": return "Force Sight";
		case "209": return "Lead the Charge";
		case "210": return "Lead the Charge";
		case "211": return "Lead the Charge";
		case "212": return "Sun Kiss";
		case "213": return "Sun Kiss";
		case "214": return "Sun Kiss";
		case "215": return "Whisper of the Oracle";
		case "216": return "Whisper of the Oracle";
		case "217": return "Whisper of the Oracle";
		case "218": return "Cracked Bauble";

		   }	}
if ($set == "CRU")
	{  switch($num)	   {

		case "000": return "Arknight Shard";
		case "001": return "vinar, Reckless Rampa;";
		case "002": return "Kayo, Berserker Runt";
		case "003": return "Romping Club";
		case "004": return "Mandible Claw";
		case "005": return "Mandible Claw";
		case "006": return "Skullhorn";
		case "007": return "Beast Within";
		case "008": return "Massacre";
		case "009": return "Argh... Smash!";
		case "010": return "Barraging Big Horn";
		case "011": return "Barraging Big Horn";
		case "012": return "Barraging Big Horn";
		case "013": return "Predatory Assault";
		case "014": return "Predatory Assault";
		case "015": return "Predatory Assault";
		case "016": return "Riled Up";
		case "017": return "Riled Up";
		case "018": return "Riled Up";
		case "019": return "Swing Fist, Think Later";
		case "020": return "Swing Fist, Think Later";
		case "021": return "Swing Fist, Think Later";
		case "022": return "Bravo, Showstopper";
		case "023": return "Anothos";
		case "024": return "Sledge of Anvilheim";
		case "025": return "Crater Fist";
		case "026": return "Mangle";
		case "027": return "Righteous Cleansing";
		case "028": return "Stamp Authority";
		case "029": return "Towering Titan";
		case "030": return "Towering Titan";
		case "031": return "Towering Titan";
		case "032": return "Crush the Weak";
		case "033": return "Crush the Weak";
		case "034": return "Crush the Weak";
		case "035": return "Chokeslam";
		case "036": return "Chokeslam";
		case "037": return "Chokeslam";
		case "038": return "Emerging Dominance";
		case "039": return "Emerging Dominance";
		case "040": return "Emerging Dominance";
		case "041": return "Blessing of Serenity";
		case "042": return "Blessing of Serenity";
		case "043": return "Blessing of Serenity";
		case "044": return "Seismic Surge";
		case "045": return "Katsu, the Wanderer";
		case "046": return "Ira, Crimson Haze";
		case "047": return "enji, the Piercing Win";
		case "048": return "Harmonized Kodachi";
		case "049": return "Harmonized Kodachi";
		case "050": return "Edge of Autumn";
		case "051": return "Zephyr Needle";
		case "052": return "Zephyr Needle";
		case "053": return "Breeze Rider Boots";
		case "054": return "Find Center";
		case "055": return "Flood of Force";
		case "056": return "Heron's Flight";
		case "057": return "Crane Dance";
		case "058": return "Crane Dance";
		case "059": return "Crane Dance";
		case "060": return "Rushing River";
		case "061": return "Rushing River";
		case "062": return "Rushing River";
		case "063": return "Flying Kick";
		case "064": return "Flying Kick";
		case "065": return "Flying Kick";
		case "066": return "Soulbead Strike";
		case "067": return "Soulbead Strike";
		case "068": return "Soulbead Strike";
		case "069": return "Torrent of Tempo";
		case "070": return "Torrent of Tempo";
		case "071": return "Torrent of Tempo";
		case "072": return "Bittering Thorns";
		case "073": return "Salt the Wound";
		case "074": return "Whirling Mist Blossom";
		case "075": return "Zen State";
		case "076": return "Dorinthea Ironsong";
		case "077": return "assai, Cintari Sellswor";
		case "078": return "Dawnblade";
		case "079": return "Cintari Saber";
		case "080": return "Cintari Saber";
		case "081": return "Courage of Bladehold";
		case "082": return "Twinning Blade";
		case "083": return "Unified Decree";
		case "084": return "Spoils of War";
		case "085": return "Dauntless";
		case "086": return "Dauntless";
		case "087": return "Dauntless";
		case "088": return "Out for Blood";
		case "089": return "Out for Blood";
		case "090": return "Out for Blood";
		case "091": return "Hit and Run";
		case "092": return "Hit and Run";
		case "093": return "Hit and Run";
		case "094": return "Push Forward";
		case "095": return "Push Forward";
		case "096": return "Push Forward";
		case "097": return "riyana, Diamond Gemi";
		case "098": return "Dash, Inventor Extraordinaire";
		case "099": return "Data Doll MKII";
		case "100": return "Teklo Plasma Pistol";
		case "101": return "Plasma Barrel Shot";
		case "102": return "Viziertronic Model i";
		case "103": return "Meganetic Shockwave";
		case "104": return "Absorption Dome";
		case "105": return "Plasma Purifier";
		case "106": return "High Speed Impact";
		case "107": return "High Speed Impact";
		case "108": return "High Speed Impact";
		case "109": return "Combustible Courier";
		case "110": return "Combustible Courier";
		case "111": return "Combustible Courier";
		case "112": return "Overblast";
		case "113": return "Overblast";
		case "114": return "Overblast";
		case "115": return "Teklovossen's Workshop";
		case "116": return "Teklovossen's Workshop";
		case "117": return "Teklovossen's Workshop";
		case "118": return ";Kavdaen, Trader of Skiy}s/";
		case "119": return ":Azalea, Ace in the qug";
		case "120": return "Death Dealer";
		case "121": return "Red Liner";
		case "122": return "Perch Grapplers";
		case "123": return "Remorseless";
		case "124": return "Poison the Tips";
		case "125": return "Feign Death";
		case "126": return "Tripwire Trap";
		case "127": return "Pitfall Trap";
		case "128": return "Rockslide Trap";
		case "129": return "Pathing Helix";
		case "130": return "Pathing Helix";
		case "131": return "Pathing Helix";
		case "132": return "Sleep Dart";
		case "133": return "Sleep Dart";
		case "134": return "Sleep Dart";
		case "135": return "Increase the Tension";
		case "136": return "Increase the Tension";
		case "137": return "Increase the Tension";
		case "138": return "Viserai, Rune Blood";
		case "139": return "Nebula Blade";
		case "140": return "Reaping Blade";
		case "141": return "Bloodsheath Skeleta";
		case "142": return "Dread Triptych";
		case "143": return "Rattle Bones";
		case "144": return "Runeblood Barrier";
		case "145": return "Mauvrion Skies";
		case "146": return "Mauvrion Skies";
		case "147": return "Mauvrion Skies";
		case "148": return "Consuming Volition";
		case "149": return "Consuming Volition";
		case "150": return "Consuming Volition";
		case "151": return "Meat and Greet";
		case "152": return "Meat and Greet";
		case "153": return "Meat and Greet";
		case "154": return "Sutcliffe's Research Notes";
		case "155": return "Sutcliffe's Research Notes";
		case "156": return "Sutcliffe's Research Notes";
		case "157": return "Runechant";
		case "158": return "Cano, Dracai of Aether";
		case "159": return "rucible of Aetherweay";
		case "160": return "Aether Conduit";
		case "161": return "Metacarpus Node";
		case "162": return "Chain Lightning";
		case "163": return "Gaze the Ages";
		case "164": return "Aetherize";
		case "165": return "Cindering Foresight";
		case "166": return "Cindering Foresight";
		case "167": return "Cindering Foresight";
		case "168": return "Foreboding Bolt";
		case "169": return "Foreboding Bolt";
		case "170": return "Foreboding Bolt";
		case "171": return "Rousing Aether";
		case "172": return "Rousing Aether";
		case "173": return "Rousing Aether";
		case "174": return "Snapback";
		case "175": return "Snapback";
		case "176": return "Snapback";
		case "177": return "alishar, the Lost Princ";
		case "178": return "Fyendal's Spring Tunic";
		case "179": return "Gambler's Gloves";
		case "180": return "Coax a Commotion";
		case "181": return "Gorganian Tome";
		case "182": return "Shag";
		case "183": return "Promise of Plenty";
		case "184": return "Promise of Plenty";
		case "185": return "Promise of Plenty";
		case "186": return "Lunging Press";
		case "187": return "Springboard Somersault";
		case "188": return "Cash In";
		case "189": return "Reinforce the Line";
		case "190": return "Reinforce the Line";
		case "191": return "Reinforce the Line";
		case "192": return "Brutal Assault";
		case "193": return "Brutal Assault";
		case "194": return "Brutal Assault";
		case "195": return "Cracked Bauble";
		case "196": return "Quicken";
		case "197": return "Copper";

		   }	}
if ($set == "ELE")
	{  switch($num)	   {

		case "000": return "NWaper? -~ ©"";
		case "001": return "him, Grandfather of Eter";
		case "002": return "Oldhim";
		case "003": return "Winter's Wail";
		case "004": return "Endless Winter";
		case "005": return "Qaken Old";
		case "006": return "Awakening";
		case "007": return "Biting Gale";
		case "008": return "Biting Gale";
		case "009": return "Biting Gale";
		case "010": return "Turn Timber";
		case "011": return "Turn Timber";
		case "012": return "Turn Timber";
		case "013": return "Entangle";
		case "014": return "Entangle";
		case "015": return "Entangle";
		case "016": return "Glacial Footsteps";
		case "017": return "Glacial Footsteps";
		case "018": return "Glacial Footsteps";
		case "019": return "Mulch";
		case "020": return "Mulch";
		case "021": return "Mulch";
		case "022": return "Snow Under";
		case "023": return "Snow Under";
		case "024": return "Snow Under";
		case "025": return "Emerging Avalanche";
		case "026": return "Emerging Avalanche";
		case "027": return "Emerging Avalanche";
		case "028": return "Strength of Sequoia";
		case "029": return "Strength of Sequoia";
		case "030": return "Strength of Sequoia";
		case "031": return "Lexi, Livewire";
		case "032": return "Lexi";
		case "033": return "Shiver";
		case "034": return "Voltaire, Strike Twice";
		case "035": return "Frost Lock";
		case "036": return "Light it Up";
		case "037": return "lIce Storm";
		case "038": return "Cold Wave";
		case "039": return "Cold Wave";
		case "040": return "Cold Wave";
		case "041": return "Snap Shot";
		case "042": return "Snap Shot";
		case "043": return "Snap Shot";
		case "044": return "Blizzard Bolt";
		case "045": return "Blizzard Bolt";
		case "046": return "Blizzard Bolt";
		case "047": return "Buzz Bolt";
		case "048": return "Buzz Bolt";
		case "049": return "Buzz Bolt";
		case "050": return "Chilling Icevein";
		case "051": return "Chilling Icevein";
		case "052": return "Chilling Icevein";
		case "053": return "Dazzling Crescendo";
		case "054": return "Dazzling Crescendo";
		case "055": return "Dazzling Crescendo";
		case "056": return "Flake Out";
		case "057": return "Flake Out";
		case "058": return "Flake Out";
		case "059": return "Frazzle";
		case "060": return "Frazzle";
		case "061": return "Frazzle";
		case "062": return "riar, Warden of Thorn";
		case "063": return "Briar";
		case "064": return "Blossoming Spellblade";
		case "065": return "Flicker Wisp";
		case "066": return "Force of Nature";
		case "067": return "Explosive Growth";
		case "068": return "Explosive Growth";
		case "069": return "Explosive Growth";
		case "070": return "Rites of Lightning";
		case "071": return "Rites of Lightning";
		case "072": return "Rites of Lightning";
		case "073": return "Arcanic Shockwave";
		case "074": return "Arcanic Shockwave";
		case "075": return "Arcanic Shockwave";
		case "076": return "Vela Flash";
		case "077": return "Vela Flash";
		case "078": return "Vela Flash";
		case "079": return "Rites of Replenishment";
		case "080": return "Rites of Replenishment";
		case "081": return "Rites of Replenishment";
		case "082": return "Stir the Wildwood";
		case "083": return "Stir the Wildwood";
		case "084": return "Stir the Wildwood";
		case "085": return "Bramble Spark";
		case "086": return "Bramble Spark";
		case "087": return "Bramble Spark";
		case "088": return "Inspire Lightning";
		case "089": return "Inspire Lightning";
		case "090": return "Inspire Lightning";
		case "091": return "Fulminate";
		case "092": return "Flashfreeze";
		case "093": return "Exposed to the Elements";
		case "094": return "Entwine Earth";
		case "095": return "Entwine Earth";
		case "096": return "Entwine Earth";
		case "097": return "Entwine lce";
		case "098": return "Entwine lce";
		case "099": return "Entwine lce";
		case "100": return "Entwine Lightning";
		case "101": return "Entwine Lightning";
		case "102": return "Entwine Lightning";
		case "103": return "Invigorate";
		case "104": return "Invigorate";
		case "105": return "Invigorate";
		case "106": return "Rejuvenate";
		case "107": return "Rejuvenate";
		case "108": return "Rejuvenate";
		case "109": return "Embodiment of Earth";
		case "110": return "mbodiment of Lightnin";
		case "111": return "Frostbite";
		case "112": return "Pulse of Volthaven";
		case "113": return "Pulse of Candlehold";
		case "114": return "Pulse of Isenloft";
		case "115": return "Crown of Seeds";
		case "116": return "Plume of Evergrowth";
		case "117": return "Channel Mount Heroic";
		case "118": return "Tome of Harvests";
		case "119": return "Evergreen";
		case "120": return "Evergreen";
		case "121": return "Evergreen";
		case "122": return "Weave Earth";
		case "123": return "Weave Earth";
		case "124": return "Weave Earth";
		case "125": return "Summerwood Shelter";
		case "126": return "Summerwood Shelter";
		case "127": return "Summerwood Shelter";
		case "128": return "Autumn's Touch";
		case "129": return "Autumn's Touch";
		case "130": return "Autumn's Touch";
		case "131": return "Break Ground";
		case "132": return "Break Ground";
		case "133": return "Break Ground";
		case "134": return "Burgeoning";
		case "135": return "Burgeoning";
		case "136": return "Burgeoning";
		case "137": return "Earthlore Surge";
		case "138": return "Earthlore Surge";
		case "139": return "Earthlore Surge";
		case "140": return "Sow Tomorrow";
		case "141": return "Sow Tomorrow";
		case "142": return "Sow Tomorrow";
		case "143": return "Amulet of Earth";
		case "144": return "Heart of Ice";
		case "145": return "Coat of Frost";
		case "146": return "Channel Lake Frigid";
		case "147": return "Blizzard";
		case "148": return "Frost Fang";
		case "149": return "Frost Fang";
		case "150": return "Frost Fang";
		case "151": return "Ice Quake";
		case "152": return "Ice Quake";
		case "153": return "Ice Quake";
		case "154": return "Weave Ice";
		case "155": return "Weave Ice";
		case "156": return "Weave Ice";
		case "157": return "Icy Encounter";
		case "158": return "Icy Encounter";
		case "159": return "Icy Encounter";
		case "160": return "Winter's Grasp";
		case "161": return "Winter's Grasp";
		case "162": return "Winter's Grasp";
		case "163": return "Chill to the Bone";
		case "164": return "Chill to the Bone";
		case "165": return "Chill to the Bone";
		case "166": return "Polar Blast";
		case "167": return "Polar Blast";
		case "168": return "Polar Blast";
		case "169": return "Winter's Bite";
		case "170": return "Winter's Bite";
		case "171": return "Winter's Bite";
		case "172": return "Amulet of Ice";
		case "173": return "Shock Charmers";
		case "174": return "Mark of Lightning";
		case "175": return "Channel Thunder Steppe";
		case "176": return "Blink";
		case "177": return "Flash";
		case "178": return "Flash";
		case "179": return "Flash";
		case "180": return "Weave Lightning";
		case "181": return "Weave Lightning";
		case "182": return "Weave Lightning";
		case "183": return "Lightning Press";
		case "184": return "Lightning Press";
		case "185": return "Lightning Press";
		case "186": return "Ball Lightning";
		case "187": return "Ball Lightning";
		case "188": return "Ball Lightning";
		case "189": return "Lightning Surge";
		case "190": return "Lightning Surge";
		case "191": return "Lightning Surge";
		case "192": return "Heaven's Claws";
		case "193": return "Heaven's Claws";
		case "194": return "Heaven's Claws";
		case "195": return "Shock Striker";
		case "196": return "Shock Striker";
		case "197": return "Shock Striker";
		case "198": return "Electrify";
		case "199": return "Electrify";
		case "200": return "Electrify";
		case "201": return "Amulet of Lightning";
		case "202": return "Titan's Fist";
		case "203": return "mpart of the Ram's He";
		case "204": return "Rotten Old Buckler";
		case "205": return "Tear Asunder";
		case "206": return "Embolden";
		case "207": return "Embolden";
		case "208": return "Embolden";
		case "209": return "Thump";
		case "210": return "Thump";
		case "211": return "Thump";
		case "212": return "Seismic Surge";
		case "213": return "New Horizon";
		case "214": return "Honing Hood";
		case "215": return "Seek and Destroy";
		case "216": return "Bolt'n' Shot";
		case "217": return "Bolt'n' Shot";
		case "218": return "Bolt'n' Shot";
		case "219": return "Over Flex";
		case "220": return "Over Flex";
		case "221": return "Over Flex";
		case "222": return "Rosetta Thorn";
		case "223": return "Duskblade";
		case "224": return "Spellbound Creepers";
		case "225": return "Sutcliffe’'s Suede Hides";
		case "226": return "Sting of Sorcery";
		case "227": return "Sigil of Suffering";
		case "228": return "Sigil of Suffering";
		case "229": return "Sigil of Suffering";
		case "230": return "Singeing Steelblade";
		case "231": return "Singeing Steelblade";
		case "232": return "Singeing Steelblade";
		case "233": return "Ragamufhin's Hat";
		case "234": return "Deep Blue";
		case "235": return "Cracker Jax";
		case "236": return "Runaways";
		case "237": return "Cracked Bauble";

		   }	}
if ($set == "MON")
	{  switch($num)	   {

		case "000": return "\N| W/";
		case "001": return "sm, Sculptor of Arc Li";
		case "002": return "Prism";
		case "003": return "Luminaris";
		case "004": return "Herald of Erudition";
		case "005": return "Arc Light Sentinel";
		case "006": return "Genesis";
		case "007": return "Herald of Judgment";
		case "008": return "Herald of Triumph";
		case "009": return "Herald of Triumph";
		case "010": return "Herald of Triumph";
		case "011": return "Parable of Humility";
		case "012": return "Merciful Retribution";
		case "013": return "Qde to Wrath";
		case "014": return "Herald of Protection";
		case "015": return "Herald of Protection";
		case "016": return "Herald of Protection";
		case "017": return "Herald of Ravages";
		case "018": return "Herald of Ravages";
		case "019": return "Herald of Ravages";
		case "020": return "Herald of Rebirth";
		case "021": return "Herald of Rebirth";
		case "022": return "Herald of Rebirth";
		case "023": return "Herald of Tenacity";
		case "024": return "Herald of Tenacity";
		case "025": return "Herald of Tenacity";
		case "026": return "Wartune Herald";
		case "027": return "Wartune Herald";
		case "028": return "Wartune Herald";
		case "029": return "Boltyn, Breaker of D:";
		case "030": return "Boltyn";
		case "031": return "Raydn, Duskbane";
		case "032": return "Bolting Blade";
		case "033": return "Beacon of Victory";
		case "034": return "Lumina Ascension";
		case "035": return "V of the Vanguard";
		case "036": return "Battlefield Blitz";
		case "037": return "Battlefield Blitz";
		case "038": return "Battlefield Blitz";
		case "039": return "Valiant Thrust";
		case "040": return "Valiant Thrust";
		case "041": return "Valiant Thrust";
		case "042": return "Bolt of Courage";
		case "043": return "Bolt of Courage";
		case "044": return "Bolt of Courage";
		case "045": return "Cross the Line";
		case "046": return "Cross the Line";
		case "047": return "Cross the Line";
		case "048": return "Engulfing Light";
		case "049": return "Engulfing Light";
		case "050": return "Engulfing Light";
		case "051": return "Express Lightning";
		case "052": return "Express Lightning";
		case "053": return "Express Lightning";
		case "054": return "Take Flight";
		case "055": return "Take Flight";
		case "056": return "Take Flight";
		case "057": return "Courageous Steelhand";
		case "058": return "Courageous Steelhand";
		case "059": return "Courageous Steelhand";
		case "060": return "Vestige of Sol";
		case "061": return "Halo of lllumination";
		case "062": return "Celestial Cataclysm";
		case "063": return "Soul Shield";
		case "064": return "Soul Food";
		case "065": return "Tome of Divinity";
		case "066": return "Invigorating Light";
		case "067": return "Invigorating Light";
		case "068": return "Invigorating Light";
		case "069": return "Glisten";
		case "070": return "Glisten";
		case "071": return "Glisten";
		case "072": return "Illuminate";
		case "073": return "Illuminate";
		case "074": return "Illuminate";
		case "075": return "Impenetrable Belief";
		case "076": return "Impenetrable Belief";
		case "077": return "Impenetrable Belief";
		case "078": return "Rising Solartide";
		case "079": return "Rising Solartide";
		case "080": return "Rising Solartide";
		case "081": return "Seek Enlightenment";
		case "082": return "Seek Enlightenment";
		case "083": return "Seek Enlightenment";
		case "084": return "Blinding Beam";
		case "085": return "Blinding Beam";
		case "086": return "Blinding Beam";
		case "087": return "Ray of Hope";
		case "088": return "Iris of Reality";
		case "089": return "Phantasmal Footsteps";
		case "090": return "Dream Weavers";
		case "091": return "Phantasmaclasm";
		case "092": return "Prismatic Shield";
		case "093": return "Prismatic Shield";
		case "094": return "Prismatic Shield";
		case "095": return "Phantasmify";
		case "096": return "Phantasmify";
		case "097": return "Phantasmify";
		case "098": return "Enigma Chimera";
		case "099": return "Enigma Chimera";
		case "100": return "Enigma Chimera";
		case "101": return "Spears of Surreality";
		case "102": return "Spears of Surreality";
		case "103": return "Spears of Surreality";
		case "104": return "Spectral Shield";
		case "105": return "Hatchet of Body";
		case "106": return "Hatchet of Mind";
		case "107": return "Valiant Dynamo";
		case "108": return "Gallantry Gold";
		case "109": return "Spill Blood";
		case "110": return "Dusk Path Pilgrimage";
		case "111": return "Dusk Path Pilgrimage";
		case "112": return "Dusk Path Pilgrimage";
		case "113": return "Plow Through";
		case "114": return "Plow Through";
		case "115": return "Plow Through";
		case "116": return "Second Swing";
		case "117": return "Second Swing";
		case "118": return "Second Swing";
		case "119": return "ia, Shadowborn Abominat";
		case "120": return "Levia";
		case "121": return "xagore, the Death Hyx";
		case "122": return "oves of the Shadowbe";
		case "123": return "Deep Rooted Evil";
		case "124": return "Mark of the Beast";
		case "125": return "Shadow of Blasmophet";
		case "126": return "Endless Maw";
		case "127": return "Endless Maw";
		case "128": return "Endless Maw";
		case "129": return "Werithing Beast Hulk";
		case "130": return "Werithing Beast Hulk";
		case "131": return "Werithing Beast Hulk";
		case "132": return "onvulsions from the Bellows of He";
		case "133": return "onvulsions from the Bellows of He";
		case "134": return "onvulsions from the Bellows of He";
		case "135": return "Boneyard Marauder";
		case "136": return "Boneyard Marauder";
		case "137": return "Boneyard Marauder";
		case "138": return "Deadwood Rumbler";
		case "139": return "Deadwood Rumbler";
		case "140": return "Deadwood Rumbler";
		case "141": return "Dread Screamer";
		case "142": return "Dread Screamer";
		case "143": return "Dread Screamer";
		case "144": return "Graveling Growl";
		case "145": return "Graveling Growl";
		case "146": return "Graveling Growl";
		case "147": return "Hungering Slaughterbeast";
		case "148": return "Hungering Slaughterbeast";
		case "149": return "Hungering Slaughterbeast";
		case "150": return "Unworldly Bellow";
		case "151": return "Unworldly Bellow";
		case "152": return "Unworldly Bellow";
		case "153": return "hane, Bound by Shado";
		case "154": return "Chane";
		case "155": return "Galaxxi Black";
		case "156": return "Shadow of Ursur";
		case "157": return "Dimenxxional Crossroads";
		case "158": return "Invert Existence";
		case "159": return "Unhallowed Rites";
		case "160": return "Unhallowed Rites";
		case "161": return "Unhallowed Rites";
		case "162": return "Dimenxxional Gateway";
		case "163": return "Dimenxxional Gateway";
		case "164": return "Dimenxxional Gateway";
		case "165": return "Seeping Shadows";
		case "166": return "Seeping Shadows";
		case "167": return "Seeping Shadows";
		case "168": return "Bounding Demigon";
		case "169": return "Bounding Demigon";
		case "170": return "Bounding Demigon";
		case "171": return "Piercing Shadow Vise";
		case "172": return "Piercing Shadow Vise";
		case "173": return "Piercing Shadow Vise";
		case "174": return "Rift Bind";
		case "175": return "Rift Bind";
		case "176": return "Rift Bind";
		case "177": return "Rifted Torment";
		case "178": return "Rifted Torment";
		case "179": return "Rifted Torment";
		case "180": return "Rip Through Reality";
		case "181": return "Rip Through Reality";
		case "182": return "Rip Through Reality";
		case "183": return "Seeds of Agony";
		case "184": return "Seeds of Agony";
		case "185": return "Seeds of Agony";
		case "186": return "Soul Shackle";
		case "187": return "Carrion Husk";
		case "188": return "Ebon Fold";
		case "189": return "Doomsday";
		case "190": return "Eclipse";
		case "191": return "Mutated Mass";
		case "192": return "Guardian of the Shadowrealm";
		case "193": return "Shadow Puppetry";
		case "194": return "Tome of Torment";
		case "195": return "Consuming Aftermath";
		case "196": return "Consuming Aftermath";
		case "197": return "Consuming Aftermath";
		case "198": return "Soul Harvest";
		case "199": return "Soul Reaping";
		case "200": return "Howl from Beyond";
		case "201": return "Howl from Beyond";
		case "202": return "Howl from Beyond";
		case "203": return "Ghostly Visit";
		case "204": return "Ghostly Visit";
		case "205": return "Ghostly Visit";
		case "206": return "Lunartide Plunderer";
		case "207": return "Lunartide Plunderer";
		case "208": return "Lunartide Plunderer";
		case "209": return "Void Wraith";
		case "210": return "Void Wraith";
		case "211": return "Void Wraith";
		case "212": return "Spew Shadow";
		case "213": return "Spew Shadow";
		case "214": return "Spew Shadow";
		case "215": return "Blood Tribute";
		case "216": return "Blood Tribute";
		case "217": return "Blood Tribute";
		case "218": return "Eclipse Existence";
		case "219": return "smophet, the Soul Harves";
		case "220": return "Ursur, the Soul Reapet";
		case "221": return "Ravenous Meataxe";
		case "222": return "Tear Limb from Limb";
		case "223": return "Pulping";
		case "224": return "Pulping";
		case "225": return "Pulping";
		case "226": return "Smash with Big Tree";
		case "227": return "Smash with Big Tree";
		case "228": return "Smash with Big Tree";
		case "229": return "Dread Scythe";
		case "230": return "Aether Ironweave";
		case "231": return "Sonata Arcanix";
		case "232": return "Vexing Malice";
		case "233": return "Vexing Malice";
		case "234": return "Vexing Malice";
		case "235": return "Arcanic Crackle";
		case "236": return "Arcanic Crackle";
		case "237": return "Arcanic Crackle";
		case "238": return "Blood Drop Brocade";
		case "239": return "Stubby Hammerers";
		case "240": return "Time Skippers";
		case "241": return "Ironhide Helm";
		case "242": return "Ironhide Plate";
		case "243": return "Ironhide Gauntlet";
		case "244": return "Ironhide Legs";
		case "245": return "Exude Confidence";
		case "246": return "Nourishing Emptiness";
		case "247": return "Rouse the Ancients";
		case "248": return "Qut Muscle";
		case "249": return "Qut Muscle";
		case "250": return "Qut Muscle";
		case "251": return "Seek Horizon";
		case "252": return "Seek Horizon";
		case "253": return "Seek Horizon";
		case "254": return "Tremor of iArathael";
		case "255": return "Tremor of iArathael";
		case "256": return "Tremor of iArathael";
		case "257": return "Rise Above";
		case "258": return "Rise Above";
		case "259": return "Rise Above";
		case "260": return "Captain's Call";
		case "261": return "Captain's Call";
		case "262": return "Captain's Call";
		case "263": return "Adrenaline Rush";
		case "264": return "Adrenaline Rush";
		case "265": return "Adrenaline Rush";
		case "266": return "Belittle";
		case "267": return "Belittle";
		case "268": return "Belittle";
		case "269": return "Brandish";
		case "270": return "Brandish";
		case "271": return "Brandish";
		case "272": return "Frontline Scout";
		case "273": return "Frontline Scout";
		case "274": return "Frontline Scout";
		case "275": return "Overload";
		case "276": return "Overload";
		case "277": return "Overload";
		case "278": return "Pound for Pound";
		case "279": return "Pound for Pound";
		case "280": return "Pound for Pound";
		case "281": return "Rally the Rearguard";
		case "282": return "Rally the Rearguard";
		case "283": return "Rally the Rearguard";
		case "284": return "Stony Woottonhog";
		case "285": return "Stony Woottonhog";
		case "286": return "Stony Woottonhog";
		case "287": return "Surging Militia";
		case "288": return "Surging Militia";
		case "289": return "Surging Militia";
		case "290": return "Yinti Yanti";
		case "291": return "Yinti Yanti";
		case "292": return "Yinti Yanti";
		case "293": return "Zealous Belting";
		case "294": return "Zealous Belting";
		case "295": return "Zealous Belting";
		case "296": return "Minnowism";
		case "297": return "Minnowism";
		case "298": return "Minnowism";
		case "299": return "Warmonger's Recital";
		case "300": return "Warmonger's Recital";
		case "301": return "Warmonger's Recital";
		case "302": return "Talisman of Dousing";
		case "303": return "Memorial Ground";
		case "304": return "Memorial Ground";
		case "305": return "Memorial Ground";
		case "306": return "Cracked Bauble";

		   }	}
if ($set == "WTR")
	{  switch($num)	   {

		case "000": return "Heart of Fyendal";
		case "001": return "rinar, Reckless Rampa;";
		case "002": return "Rhinar";
		case "003": return "Romping Club";
		case "004": return "Scabskin Leathers";
		case "005": return "Barkbone Strapping";
		case "006": return "~ Alpha Rampage";
		case "007": return "Bloodrush Bellow";
		case "008": return "Reckless Swing";
		case "009": return "~ Sand Sketched Plan";
		case "010": return "Bone Head Barrier";
		case "011": return "Breakneck Battery";
		case "012": return "Breakneck Battery";
		case "013": return "Breakneck Battery";
		case "014": return "Savage Feast";
		case "015": return "Savage Feast";
		case "016": return "Savage Feast";
		case "017": return "Barraging Beatdown";
		case "018": return "Barraging Beatdown";
		case "019": return "Barraging Beatdown";
		case "020": return "Savage Swing";
		case "021": return "Savage Swing";
		case "022": return "Savage Swing";
		case "023": return "Pack Hunt";
		case "024": return "Pack Hunt";
		case "025": return "Pack Hunt";
		case "026": return "Smash Instinct";
		case "027": return "Smash Instinct";
		case "028": return "Smash Instinct";
		case "029": return "Wrecker Romp";
		case "030": return "Wrecker Romp";
		case "031": return "Wrecker Romp";
		case "032": return "Awakening Bellow";
		case "033": return "Awakening Bellow";
		case "034": return "Awakening Bellow";
		case "035": return "Primeval Bellow";
		case "036": return "Primeval Bellow";
		case "037": return "Primeval Bellow";
		case "038": return "Bravo, Showstopper";
		case "039": return "Bravo";
		case "040": return "Anothos";
		case "041": return "Tectonic Plating";
		case "042": return "Helm of Isen's Peak";
		case "043": return "Crippling Crush";
		case "044": return "Spinal Crush";
		case "045": return "Cranial Crush";
		case "046": return "Forged for War";
		case "047": return "Show Time!";
		case "048": return "Disable";
		case "049": return "Disable";
		case "050": return "Disable";
		case "051": return "Staunch Response";
		case "052": return "Staunch Response";
		case "053": return "Staunch Response";
		case "054": return "Blessing of Deliverance";
		case "055": return "Blessing of Deliverance";
		case "056": return "Blessing of Deliverance";
		case "057": return "Buckling Blow";
		case "058": return "Buckling Blow";
		case "059": return "Buckling Blow";
		case "060": return "Cartilage Crush";
		case "061": return "Cartilage Crush";
		case "062": return "Cartilage Crush";
		case "063": return "Crush Confidence";
		case "064": return "Crush Confidence";
		case "065": return "Crush Confidence";
		case "066": return "Debilitate";
		case "067": return "Debilitate";
		case "068": return "Debilitate";
		case "069": return "Emerging Power";
		case "070": return "Emerging Power";
		case "071": return "Emerging Power";
		case "072": return "Stonewall Confidence";
		case "073": return "Stonewall Confidence";
		case "074": return "Stonewall Confidence";
		case "075": return "Seismic Surge";
		case "076": return "Katsu, the Wanderer";
		case "077": return "Katsu";
		case "078": return "Harmonized Kodachi";
		case "079": return "Mask of Momentum";
		case "080": return "Breaking Scales";
		case "081": return "Lord of Wind";
		case "082": return "Ancestral Empowerment";
		case "083": return "Mugenshi: RELEASE";
		case "084": return "Hurricane Technique";
		case "085": return "Pounding Gale";
		case "086": return "Fluster Fist";
		case "087": return "Fluster Fist";
		case "088": return "Fluster Fist";
		case "089": return "Blackout Kick";
		case "090": return "Blackout Kick";
		case "091": return "Blackout Kick";
		case "092": return "Flic Flak";
		case "093": return "Flic Flak";
		case "094": return "Flic Flak";
		case "095": return "Open the Center";
		case "096": return "Open the Center";
		case "097": return "Open the Center";
		case "098": return "Head Jab";
		case "099": return "Head Jab";
		case "100": return "Head Jab";
		case "101": return "Leg Tap";
		case "102": return "Leg Tap";
		case "103": return "Leg Tap";
		case "104": return "Rising Knee Thrust";
		case "105": return "Rising Knee Thrust";
		case "106": return "Rising Knee Thrust";
		case "107": return "Surging Strike";
		case "108": return "Surging Strike";
		case "109": return "Surging Strike";
		case "110": return "Whelming Gustwave";
		case "111": return "Whelming Gustwave";
		case "112": return "Whelming Gustwave";
		case "113": return "Dorinthea Ironsong";
		case "114": return "Dorinthea";
		case "115": return "Dawnblade";
		case "116": return "Braveforge Bracers";
		case "117": return "Refraction Bolters";
		case "118": return "Glint the Quicksilver";
		case "119": return "Steelblade Supremacy";
		case "120": return "Rout";
		case "121": return "Singing Steelblade";
		case "122": return "Ironsong Determination";
		case "123": return "QOverpower";
		case "124": return "QOverpower";
		case "125": return "QOverpower";
		case "126": return "Steelblade Shunt";
		case "127": return "Steelblade Shunt";
		case "128": return "Steelblade Shunt";
		case "129": return "Warrior's Valor";
		case "130": return "Warrior's Valor";
		case "131": return "Warrior's Valor";
		case "132": return "Ironsong Response";
		case "133": return "Ironsong Response";
		case "134": return "Ironsong Response";
		case "135": return "Biting Blade";
		case "136": return "Biting Blade";
		case "137": return "Biting Blade";
		case "138": return "Stroke of Foresight";
		case "139": return "Stroke of Foresight";
		case "140": return "Stroke of Foresight";
		case "141": return "Sharpen Steel";
		case "142": return "Sharpen Steel";
		case "143": return "Sharpen Steel";
		case "144": return "Driving Blade";
		case "145": return "Driving Blade";
		case "146": return "Driving Blade";
		case "147": return "Nature's Path Pilgrimage";
		case "148": return "Nature's Path Pilgrimage";
		case "149": return "Nature's Path Pilgrimage";
		case "150": return "Fyendal's Spring Tunic";
		case "151": return "Hope Merchant's Hooc";
		case "152": return "Heartened Cross Strap";
		case "153": return "Goliath Gauntlet";
		case "154": return "Snapdragon Scalers";
		case "155": return "Ironrot Helm";
		case "156": return "Ironrot Plate";
		case "157": return "Ironrot Gauntlet";
		case "158": return "Ironrot Legs";
		case "159": return "Enlightened Strike";
		case "160": return "Tome of Fyendal";
		case "161": return "Last Ditch Effort";
		case "162": return "Crazy Brew";
		case "163": return "Remembrance";
		case "164": return "Drone of Brutality";
		case "165": return "Drone of Brutality";
		case "166": return "Drone of Brutality";
		case "167": return "Snatch";
		case "168": return "Snatch";
		case "169": return "Snatch";
		case "170": return "Energy Potion";
		case "171": return "Potion of Strength";
		case "172": return "Timesnap Potion";
		case "173": return "Sigil of Solace";
		case "174": return "Sigil of Solace";
		case "175": return "Sigil of Solace";
		case "176": return "Barraging Brawnhide";
		case "177": return "Barraging Brawnhide";
		case "178": return "Barraging Brawnhide";
		case "179": return "Demolition Crew";
		case "180": return "Demolition Crew";
		case "181": return "Demolition Crew";
		case "182": return "lock of the Feather Walker";
		case "183": return "lock of the Feather Walker";
		case "184": return "lock of the Feather Walker";
		case "185": return "Nimble Strike";
		case "186": return "Nimble Strike";
		case "187": return "Nimble Strike";
		case "188": return "Raging Onslaught";
		case "189": return "Raging Onslaught";
		case "190": return "Raging Onslaught";
		case "191": return "Scar for a Scar";
		case "192": return "Scar for a Scar";
		case "193": return "Scar for a Scar";
		case "194": return "Scour the Battlescape";
		case "195": return "Scour the Battlescape";
		case "196": return "Scour the Battlescape";
		case "197": return "Regurgitating Slog";
		case "198": return "Regurgitating Slog";
		case "199": return "Regurgitating Slog";
		case "200": return "‘Wounded Bull";
		case "201": return "‘Wounded Bull";
		case "202": return "‘Wounded Bull";
		case "203": return "Wounding Blow";
		case "204": return "Wounding Blow";
		case "205": return "Wounding Blow";
		case "206": return "Pummel";
		case "207": return "Pummel";
		case "208": return "Pummel";
		case "209": return "Razor Reflex";
		case "210": return "Razor Reflex";
		case "211": return "Razor Reflex";
		case "212": return "Unmovable";
		case "213": return "Unmovable";
		case "214": return "Unmovable";
		case "215": return "Sink Below";
		case "216": return "Sink Below";
		case "217": return "Sink Below";
		case "218": return "Nimblism";
		case "219": return "Nimblism";
		case "220": return "Nimblism";
		case "221": return "Sloggism";
		case "222": return "Sloggism";
		case "223": return "Sloggism";
		case "224": return "Cracked Bauble";
		case "225": return "Quicken";

		   }	}

        return "";    }
            
