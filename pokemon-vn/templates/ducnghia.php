<?php
define('ROOT', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
if(isset($_POST)){
foreach($_POST as $index => $value){
if(is_string($_POST[$index])){
if($index != 'msg' AND $index != 'onclick' AND $index != 'text' AND $index != 'url' AND $index != 'cmd' AND $index != 'data0' AND $index != 'data1' AND  $index != 'data2' AND $index !='data3'  AND $index !='data4') {
$_POST[$index]=mysql_real_escape_string($_POST[$index]);
}
}
}
}
if(isset($_GET)){
foreach($_GET as $index => $value){
if(is_string($_GET[$index])){
$_GET[$index]=mysql_real_escape_string($_GET[$index]);
}
}
}
function ducnghia_vp($_aaaaaaaaaaaaaaaaaaaa){

	$ducnghia_dulieu_nek = mysql_fetch_assoc(mysql_query("SELECT * FROM `vatpham` WHERE `user_id` = '{$_SESSION[id]}' AND `id_shop` = '{$_aaaaaaaaaaaaaaaaaaaa}'"));
	
	return $ducnghia_dulieu_nek;
}
function thoigiantinh($from, $to = '') {
if (empty($to))
$to = time();
$diff = (int) abs($to - $from);
if ($diff <= 60) {
$since = sprintf(''.$diff.'s');
} elseif ($diff <= 3600) {
$mins = round($diff / 60);
if ($mins <= 1) {
$mins = 1;
}
/* mod thời gian phút */
$since = sprintf('%s phút', $mins);
} else if (($diff <= 86400) && ($diff > 3600)) {
$hours = round($diff / 3600);
if ($hours <= 1) {
$hours = 1;
}
$since = sprintf('%s giờ', $hours  );
} elseif ($diff >= 86400) {
$days = round($diff / 86400);
if ($days <= 1) {
$days = 1;
}
$since = sprintf('%s ngày', $days);
}
return $since;
}
function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

 function tien( $n ) {
	if ($n > 0 && $n < 1000) {
		// 1 - 999
		$n_format = floor($n);
		$suffix = '';
	} else if ($n >= 1000 && $n < 1000000) {
		// 1k-999k
		$n_format = floor($n / 1000);
		$suffix = 'K';
	} else if ($n >= 1000000 && $n < 1000000000) {
		// 1m-999m
		$n_format = floor($n / 1000000);
		$suffix = 'M';
	} else if ($n >= 1000000000 && $n < 1000000000000) {
		// 1b-999b
		$n_format = floor($n / 1000000000);
		$suffix = 'B+';
	} else if ($n >= 1000000000000) {
		// 1t+
		$n_format = floor($n / 1000000000000);
		$suffix = 'T+';
	}

	return !empty($n_format . $suffix) ? $n_format . $suffix : 0;
}
function bug($ducnghia_check){
	$ducnghia_dove=addslashes($ducnghia_check);
	return $ducnghia_dove;
}
function BBCODE($text,$forum = false){
	$text = htmlspecialchars($text);
        $SMILE_FOLD = glob(ROOT.'/style/images/smileys/*.gif', GLOB_BRACE);
        $SMILE_TOTAL = count($SMILE_FOLD);

            for ($i = 0; $i < $SMILE_TOTAL; $i++) {
				$new = basename($SMILE_FOLD[$i]);
				$new = str_replace('.gif','',$new);
				$text = str_replace($new,'<img src="/style/images/smileys/'.$new.'.gif">',$text);
            }
$find = array(
'~\[dam\](.*?)\[/dam\]~s',
'~\[red\](.*?)\[/red\]~s',
'~\[blue\](.*?)\[/blue\]~s',

'~\[b\](.*?)\[/b\]~s',
'~\[i\](.*?)\[/i\]~s',
'~\[u\](.*?)\[/u\]~s',
'~\[color=(.*?)\](.*?)\[/color\]~s',
'~\[url=((?:ftp|https?)://.*?)\](.*?)\[/url\]~s',
'~\[img\](https?://.*?)\[/img\]~s',
'~\[onclick=(.*?)\](.*?)\[/onclick\]~s',
'~\[div](.*?)\[/div\]~s'

);
 $replace = array(
     '<b class="viptxt">$1</b>',
     '<font color="red">$1</font>',
     '<font color="blue">$1</font>',

'<b>$1</b>',
 
'<i>$1</i>',
 
'<span style="text-decoration:underline;">$1</span>',
 
'<span style="color:$1;">$2</span>',
 
'<a href="$1">$2</a>',
 
'<img src="$1" alt="" />',

'<b onclick="$1" class="viptxt">$2</b>',
'<p class="$1"></p>'

 
);
 
// Thay thế
 
return preg_replace($find,$replace,$text);
			
}


function demkytu($kytu,$text){
$chars=str_split($text);
$count=0;
foreach($chars as &$char)
{
    if($char==$kytu)
    {
  $count++;
    }
}
return $count;
}
function smileys($element){
			$SMILE_FOLD = glob(ROOT.'/style/images/smileys/*.gif', GLOB_BRACE);
        $SMILE_TOTAL = count($SMILE_FOLD);
            for ($i = 1; $i < $SMILE_TOTAL; $i++) {
				$new = basename($SMILE_FOLD[$i]);
				$new = str_replace('.gif','',$new);
				$HEADER_modal .= ' '.str_replace($new,'<a href="javascript:smile(\''.$new.'\',\''.$element.'\');"><img src="/style/images/smileys/'.$new.'.gif"></a>',$new);
            }
			return $HEADER_modal;
}
function files($dirname)

{

    $total_files=0;

     

    if(is_dir($dirname))

    {

        $dp=opendir($dirname);

         

        if($dp)

        {

            while(($filename=readdir($dp)) == true)

            {

                if(($filename !=".") && ($filename !=".."))

                {

                    $total_files++;

                }

            }

        }

    }

     

     

    return $total_files;

}

function rand_string($length) {
$chars ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$size = strlen($char);
for($i = 0; $i<$length; $i++) {
$str .= $chars[rand(0, $size -1)];
$str=substr(str_shuffle($chars), 0, $length);
}
return$str;
}

///
#Voor welke scripts moet het captcha script tevoorschijn wordeng gehaald
$captcha_page_check = array('213312321');
#$captcha_page_check = array('attack/attack_map', 'attack/gyms', 'work', 'attack/duel/invite', 'tour', 'traders', 'race-invite', 'steal', 'spy', 'flip-a-coin', 'who-is-it-quiz', 'wheel-of-fortune', 'lottery');
function pokemon_popup($x) {
    return $x;
}
#Language event returnen naar goeie
function GetEventLanguage($land){
	if(($land == 'Netherlands') || ($land == 'Belgium')) return 'nl';
elseif($land == 'Germany') return 'de';
	elseif($land == 'Spain') return 'es';
	elseif($land == 'Poland') return 'pl';
	else return 'en';
}
			
#Money 1.000.000
function highamount($amount){
 return number_format(round($amount),0,",",".");                          
}

function tron($d) {
    return highamount($d);
}



//Cache Query in txt


function update_pokedex($wild_id,$old_id,$wat){
  $load = mysql_fetch_assoc(mysql_query("SELECT pok_gezien, pok_bezit, pok_gehad FROM users WHERE id ='".$_SESSION['id']."'"));
  $pokedex_bezit = in_array($wild_id, explode(",", $load['pok_bezit']));
  $pokedex_gehad = in_array($wild_id, explode(",", $load['pok_gehad']));
  $pokedex_gehad_old = in_array($old_id, explode(",", $load['pok_gehad']));
  $pokedex_gezien = in_array($wild_id, explode(",", $load['pok_gezien']));
  if($wat == 'ei'){
    if($pokedex_gezien === false) $query = "`pok_gezien`=concat(pok_gezien,',".$wild_id."')";
    if($pokedex_bezit === false) $query .= ",`pok_bezit`=concat(pok_bezit,',".$wild_id."')";
  }
  elseif($wat == 'zien'){
    if($pokedex_gezien === false) $query = "`pok_gezien`=concat(pok_gezien,',".$wild_id."')";
  }
  elseif($wat == 'vangen'){
    if($pokedex_bezit === false) $query = "`pok_bezit`=concat(pok_bezit,',".$wild_id."')";
  }
  elseif($wat == 'release'){
    if($pokedex_gehad === false) $query = "`pok_gehad`=concat(pok_gehad,',".$wild_id."')";
  }
  elseif($wat == 'buy'){
    if($pokedex_gezien === false) $query = "`pok_gezien`=concat(pok_gezien,',".$wild_id."')";
    if($pokedex_bezit === false) $query .= ",`pok_bezit`=concat(pok_bezit,',".$wild_id."')";
  }
  elseif($wat == 'evo'){
    if($pokedex_gezien === false) $query = "`pok_gezien`=concat(pok_gezien,',".$wild_id."')";
    if($pokedex_bezit === false) $query .= ",`pok_bezit`=concat(pok_bezit,',".$wild_id."')";
    if($pokedex_gehad_old === false) $query .= ",`pok_gehad`=concat(pok_gehad,',".$old_id."')";
  }
  if(!empty($query)) mysql_query("UPDATE users SET ".$query." WHERE user_id='".$_SESSION['id']."'");
}

//Calculate min/max price
function max_min_price($pokemon){
  $pokemon['zeldzaamheid'] *= 10;
  $shinywaard = 239;
  if($pokemon['shiny'] == 0) $shinywaard = 163; 
  
  $waard = $pokemon['level'] * $pokemon['zeldzaamheid'] * 30 / 100 * $shinywaard;
  
  $maxprice = $waard * 1.5;
  if($maxprice > 999) $maxprice += 1; 
  
  $max_min['maxprice'] = $maxprice;
  $max_min['minimum'] = round($waard / 2);
  $max_min['waard'] = $waard;
  //Waard ff mooi maken
  $max_min['minimum_mooi'] = highamount($max_min['minimum']);
  $max_min['waard_mooi'] =  highamount($waard);
  $max_min['maxprice_mooi'] = highamount($maxprice);
  return $max_min;
}

//Check if player can see the page
function page_timer($page,$timer){
  $zien = array('home', 'account-options', 'pokemoninfo', 'rankinglist', 'statistics', 'forum-categories', 'forum-threads', 'forum-messages', 'promotion', 'modify-order', 'extended', 'items', 'house', 'pokedex', 'inbox', 'send-message', 'read-message', 'events', 'buddylist', 'blocklist', 'area-messenger', 'search-user', 'profile', 'logout', 'area-market', 'information');
  if($timer == 'jail') array_push($zien, "jail");
  if(in_array($page, $zien)) return true;
  else return false;
}

#Als speler er rank bij krijgt
function rankerbij($soort,$txt){
  #Kijken wat speler gedaan heeft
  if($soort == "race") $soort = 1;
  elseif($soort == "werken") $soort = 2;
  elseif($soort == "whoisitquiz") $soort = 2;
  elseif($soort == "attack") $soort = 3;
  elseif($soort == "jail") $soort = 3;
  elseif($soort == "trainer") $soort = 4;
  elseif($soort == "gym") $soort = 5;
  elseif($soort == "duel") $soort = 5;
  //Kijken als speler niet boven de max zit.
  $spelerrank = mysql_fetch_assoc(mysql_query("SELECT `land`, `rankexp`, `rankexpnodig`, `rank` FROM `users` WHERE `id`='".$_SESSION['id']."'"));
  $rank = rank($spelerrank['rank']);
  $uitkomst = round(((($rank['ranknummer']/0.11)*$soort)/3)*1);
  mysql_query("UPDATE `users` SET `rankexp`=`rankexp`+'".$uitkomst."' WHERE `id`='".$_SESSION['id']."'");    
  //Heeft speler genoeg punten om rank omhoog te gaan?
  $spelerrank['rankexp'] = $spelerrank['rankexp']+$uitkomst;
  if($spelerrank['rankexpnodig'] <= $spelerrank['rankexp']){
    //Punten berekenen wat speler over heeft
    $rankexpover = $spelerrank['rankexp']-$spelerrank['rankexpnodig'];
    //Nieuwe rank level bepalen
    $ranknieuw = $spelerrank['rank']+1;
    //Gegevens laden van de nieuwe ranklevel
    $query = mysql_fetch_assoc(mysql_query("SELECT `naam`, `punten`, `naam` FROM `rank` WHERE `ranknummer`='".$ranknieuw."'"));
    //Nieuwe gegevens opslaan bij de gebruiker
	if($ranknieuw == 34 )
	mysql_query("UPDATE `users` SET `rank`='33', `rankexp`='1', `rankexpnodig`='170000000' WHERE `id`='".$_SESSION['id']."'");
    else
	mysql_query("UPDATE `users` SET `rank`='".$ranknieuw."', `rankexp`='".$rankexpover."', `rankexpnodig`='".$query['punten']."' WHERE `id`='".$_SESSION['id']."'");
	
    ##Event taal pack includen
	$eventlanguage = GetEventLanguage($spelerrank['land']);
	include('../language/events/language-events-en.php');
		$txt['event_rank_up'] = 'xin chúc mừng bạn đã lên cấp.';
	$event = '<img src="images/icons/up.png" width="16" height="16" class="imglower" /> '.$txt['event_rank_up'].' <b>'.$query['naam'].'</b>.';
	
	#Melding geven aan de uitdager
	mysql_query("INSERT INTO gebeurtenis (id, datum, ontvanger_id, bericht, gelezen)
	VALUES (NULL, NOW(), '".$_SESSION['id']."', '".$event."', '0')");
  }
    if(($computer_info['leven'] == 0) && (rand(1,50) == 1)){
    $priz = rand(200, 900);
    $event2 = '<img src="images/icons/ball.gif" width="16" height="16" class="imglower" /> bạn nhận được <img src="images/icons/silver.png"> '.$priz.' bạc!';
	#message event send
	mysql_query("INSERT INTO gebeurtenis (id, datum, ontvanger_id, bericht, gelezen)
	VALUES (NULL, NOW(), '".$_SESSION['id']."', '".$event2."', '0')");
    mysql_query("UPDATE `users` SET `silver`=`silver`+'".$priz."' WHERE `id`='".$_SESSION['id']."'");
    }
}

//Als speler er rank bij krijgt
function rankeraf($soort){
  //Kijken wat speler gedaan heeft
  if($soort == "werken")  $soort = 1;
  elseif($soort == "race") $soort = 1;
  elseif($soort == "whoisitquiz") $soort = 2;
  elseif($soort == "attack_run") $soort = 2;
  elseif($soort == "attack_lose") $soort = 3;
  //Kijken als speler niet boven de max zit.
  $spelerrank = mysql_fetch_assoc(mysql_query("SELECT `rank` FROM `users` WHERE `id`='".$_SESSION['id']."'"));
  $rank = rank($spelerrank['rank']);
  $uitkomst = floor(($rank['ranknummer']/0.15)*$soort)/3;
  mysql_query("UPDATE `users` SET `rankexp`=`rankexp`-'".$uitkomst."' WHERE `id`='".$_SESSION['id']."'");    
}

//Berekenen als het effect moet gebeuren of niet.
function kans($nummer){
    //Willekeurig getal nemen tussen 1 en 100
    $getal = rand(1,100);
    //Als nummer bijv. 50 is word deze loop 50x uitgevoerd
    for ($i=1; $i<=$nummer; $i++){
      $kans = rand(1,100);
      if($getal == $kans) return true;
    }
    return false;
}

//Als pokemon aanval leert of evolueert
function levelgroei($levelnieuw,$pokemon){
  //Load data from pokemon growing life from leveling table
  $levelensql = mysql_query("SELECT `id`, `level`, `trade`, `wild_id`, `wat`, `nieuw_id`, `aanval` FROM `levelen` WHERE `wild_id`='".$pokemon['wild_id']."'");
  //Voor elke actie kijken als het klopt.
  while($levelen = mysql_fetch_assoc($levelensql)){
    //als de actie een aanval leren is
    if($levelen['wat'] == "att"){
      //Komt het benodigde level overeen
      if($levelen['level'] == $levelnieuw){
        //Kent de pokemon deze aanval al
        if(($pokemon['aanval_1'] != $levelen['aanval']) AND ($pokemon['aanval_2'] != $levelen['aanval']) AND ($pokemon['aanval_3'] != $levelen['aanval']) AND ($pokemon['aanval_4'] != $levelen['aanval'])){
          //Als er 1 plek leeg is
          if((empty($pokemon['aanval_1'])) OR (empty($pokemon['aanval_2'])) OR (empty($pokemon['aanval_3'])) OR (empty($pokemon['aanval_4']))){       
            //Is de eerst plek niet leeg
            if(!empty($pokemon['aanval_1'])){
              //Is de tweede plek niet leeg
              if(!empty($pokemon['aanval_2'])){
                //Is de derde plek niet leeg
                if(!empty($pokemon['aanval_3'])){
                  //Is de vierde plek niet leeg, dan moet er gekozen worden, code maken die word mee gegeven
                  if(!empty($pokemon['aanval_4'])){
                    if(!$_SESSION['aanvalnieuw']) $_SESSION['aanvalnieuw'] = base64_encode($pokemon['id']."/".$levelen['aanval']);
                  }
                  //Als de vierde plek wel leeg is dan aanval daar opslaan
                  else mysql_query("UPDATE `pokemon_speler` SET `aanval_4`='".$levelen['aanval']."' WHERE `id`='".$pokemon['id']."'");
                }
                //Als de derde plek wel leeg is dan aanval daar opslaan
                else mysql_query("UPDATE `pokemon_speler` SET `aanval_3`='".$levelen['aanval']."' WHERE `id`='".$pokemon['id']."'");
              }
              //Als de tweede plek wel leeg is dan aanval daar opslaan
              else  mysql_query("UPDATE `pokemon_speler` SET `aanval_2`='".$levelen['aanval']."' WHERE `id`='".$pokemon['id']."'");
            }
            //Als de eerste plek wel leeg is dan aanval daar opslaan
            else mysql_query("UPDATE `pokemon_speler` SET `aanval_1`='".$levelen['aanval']."' WHERE `id`='".$pokemon['id']."'");
          }
          //Is alles vol, dan moet er gekozen worden
          else{ 
            if(!$_SESSION['aanvalnieuw']) $_SESSION['aanvalnieuw'] = base64_encode($pokemon['id']."/".$levelen['aanval']);
          }
        }
      }
    }
    //Gaat de pokemon evolueren
    elseif($levelen['wat'] == "evo"){
      //Is het level groter of gelijk aan de level die benodigd is? Naar andere pagina gaan
      if(($levelen['level'] <= $levelnieuw) OR (($levelen['trade'] == 1) AND ($pokemon['trade'] == "1.5"))){
        $code = base64_encode($pokemon['id']."/".$levelen['nieuw_id']);
        if(!$_SESSION['evolueren']) $_SESSION['evolueren'] = $code;
        elseif((!$_SESSION['evolueren2']) && ($_SESSION['evolueren'] != $code)) $_SESSION['evolueren2'] = $code;
        elseif((!$_SESSION['evolueren3']) && ($_SESSION['evolueren'] != $code) && ($_SESSION['evolueren2'] != $code)) $_SESSION['evolueren3'] = $code;
        elseif((!$_SESSION['evolueren4']) && ($_SESSION['evolueren'] != $code) && ($_SESSION['evolueren2'] != $code) && ($_SESSION['evolueren3'] != $code)) $_SESSION['evolueren4'] = $code;
        elseif((!$_SESSION['evolueren5']) && ($_SESSION['evolueren'] != $code) && ($_SESSION['evolueren2'] != $code) && ($_SESSION['evolueren3'] != $code) && ($_SESSION['evolueren4'] != $code)) $_SESSION['evolueren5'] = $code;
        elseif((!$_SESSION['evolueren6']) && ($_SESSION['evolueren'] != $code) && ($_SESSION['evolueren2'] != $code) && ($_SESSION['evolueren3'] != $code) && ($_SESSION['evolueren4'] != $code) && ($_SESSION['evolueren5'] != $code)) $_SESSION['evolueren6'] = $code;
      }    
    }
    else return True;
  }
}
  
//Als pokemon level groeit

function trangbi($id) {
          $tb1=mysql_fetch_array(mysql_query("SELECT * FROM `trangbi` WHERE `id` = '$id'"));
return $tb1;
}

function nieuwestats($pokemon,$levelnieuw,$nieuwexp){
 

  //Gegevens opzoeken in de experience tabel en karakter tabel
  $explevel = $levelnieuw+1;
  if($explevel < 101)
    $info = mysql_fetch_assoc(mysql_query("SELECT experience.punten, karakters.* FROM experience INNER JOIN karakters WHERE experience.soort='".$pokemon['groei']."' AND experience.level='".$explevel."' AND karakters.karakter_naam='".$pokemon['karakter']."'"));
  else{
    $info = mysql_fetch_assoc(mysql_query("SELECT * FROM karakters WHERE karakter_naam='".$pokemon['karakter']."'"));
    $info['punten'] = 0;
  }      
  //Exp bereken dat de pokemon over gehouden heeft en mee neemt naar het volgend level.
  $expover = $nieuwexp-$pokemon['expnodig'];
  //Nieuwe stats en hp berekenen   
  //Bron: http://www.upokecenter.com/games/rs/guides/id.html
  //Stats berekenen
  //Formule Stats = int((int(int(A*2+B+int(C/4))*D/100)+5)*E)
  $attackstat     = round(((((($pokemon['attack_base']*2+$pokemon['attack_iv']+floor($pokemon['attack_ev']/4))*$levelnieuw/100)+5)*1)+$pokemon['attack_up'])*$info['attack_add']);
  $defencestat    = round(((((($pokemon['defence_base']*2+$pokemon['defence_iv']+floor($pokemon['defence_ev']/4))*$levelnieuw/100)+5)*1)+$pokemon['defence_up'])*$info['defence_add']);
  $speedstat      = round(((((($pokemon['speed_base']*2+$pokemon['speed_iv']+floor($pokemon['speed_ev']/4))*$levelnieuw/100)+5)*1)+$pokemon['speed_up'])*$info['speed_add']);
  $spcattackstat  = round(((((($pokemon['spc.attack_base']*2+$pokemon['spc.attack_iv']+floor($pokemon['spc.attack_ev']/4))*$levelnieuw/100)+5)*1)+$pokemon['spc_up'])*$info['spc.attack_add']);
  $spcdefencestat = round(((((($pokemon['spc.defence_base']*2+$pokemon['spc.defence_iv']+floor($pokemon['spc.defence_ev']/4))*$levelnieuw/100)+5)*1)+$pokemon['spc_up'])*$info['spc.defence_add']);
  $hpstat         = round((($pokemon['hp_iv']+2*$pokemon['hp_base']+floor($pokemon['hp_ev']/4))*$levelnieuw/100)+10+$levelnieuw+$pokemon['hp_up']); 
$dn = $pokemon['groei'];  ///$dn = đức nghĩa
if($dn=="Erratic") {
    $dhp = 10;
    $dgiap = 5;
    $dtocdo = 1;
    $dtancong = 0;
    $sptancong = 3;
    $spphongthu = 3;
  
}

if($dn=="Fast") {
    $dhp = 5;
    $dgiap = 3;
    $dtocdo = 15;
    $dtancong = 0;
  $sptancong = 1;
    $spphongthu = 1;   
}

if($dn=="Medium Fast") {
    $dhp = 15;
    $dgiap = 5;
    $dtocdo = 1;
    $dtancong = 0;
  $sptancong = 6;
    $spphongthu = 6;    
}
if($dn=="Medium Slow") {
    $dhp = 20;
    $dgiap = 20;
    $dtocdo = 15;
    $dtancong = 15;
  $sptancong = 15;
    $spphongthu = 15;    
}
if($dn=="Slow") {
    $dhp = 25;
    $dgiap = 40;
    $dtocdo = 24;
    $dtancong = 36;
  $sptancong = 25;
    $spphongthu = 30;    
}

$ntc = $attackstat + ($attackstat/100*$dtancong);
 $nhp = $hpstat + ($hpstat/100*$dhp);
 $ntd = $speedstat + ($speedstat/100*$dtocdo);
 $ngiap = $defencestat + ($defencestat/100*$dgiap);
 $nspgiap = $spcdefencestat + ($spcdefencestat/100*$spphongthu);
 $nsptancong = $spcattackstat + ($spcattackstat/100*$spphongthu);

$sao = $pokemon['sao'];
if($sao==0) $buff = 0;
else if($sao==1) $buff = 20;
else if($sao==2) $buff = 40;
else if($sao==3) $buff = 60;
else if($sao==4) $buff = 80;
else if($sao==5) $buff = 100;

$atnew = round($ntc) + round($ntc/100*$buff);
$hpnew =  round($nhp)+ round($nhp/100*$buff);
$giapnew =  round($ngiap)+ round($ngiap/100*$buff);
$tdnew = round($ntd)+ round($ntd/100*$buff);
$spdnew = round($nspgiap)+ round($nspgiap/100*$buff);
$spattnew = round($nsptancong)+ round($nsptancong/100*$buff);

  //Stats opslaan
  mysql_query("UPDATE `pokemon_speler` SET `tn`=`tn`+'5',`level`='".$levelnieuw."', `levenmax`='".$hpnew."', `leven`='".$hpnew."', `exp`='".$expover."', `expnodig`='".$info['punten']."', `attack`='".$atnew."', `defence`='".$giapnew."', `speed`='".$tdnew."', `spc.attack`='".$spattnew."', `spc.defence`='".$spdnew."', `effect`='', `hoelang`='0' WHERE `id`='".$pokemon['id']."'");
  capnhat($pokemon['id']);
  return $info['punten'];
}

function capnhat($ducnghiapkm){
 

	$pokemon = mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_speler` WHERE  `id` = '".$ducnghiapkm."'"));
	$pokemon2 = mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_wild` WHERE  `wild_id` = '".$pokemon['wild_id']."'"));

$levelnieuw = $pokemon['level'];
                $info = mysql_fetch_assoc(mysql_query("SELECT * FROM karakters WHERE karakter_naam='".$pokemon['karakter']."'"));



  $attackstat     = round(((((($pokemon2['attack_base']*2+$pokemon['attack_iv']+floor($pokemon['attack_ev']/4))*$levelnieuw/100)+5)*1)+$pokemon['attack_up'])*$info['attack_add']);
  $defencestat    = round(((((($pokemon2['defence_base']*2+$pokemon['defence_iv']+floor($pokemon['defence_ev']/4))*$levelnieuw/100)+5)*1)+$pokemon['defence_up'])*$info['defence_add']);
  $speedstat      = round(((((($pokemon2['speed_base']*2+$pokemon['speed_iv']+floor($pokemon['speed_ev']/4))*$levelnieuw/100)+5)*1)+$pokemon['speed_up'])*$info['speed_add']);
  $spcattackstat  = round(((((($pokemon2['spc.attack_base']*2+$pokemon['spc.attack_iv']+floor($pokemon['spc.attack_ev']/4))*$levelnieuw/100)+5)*1)+$pokemon['spc_up'])*$info['spc.attack_add']);
  $spcdefencestat = round(((((($pokemon2['spc.defence_base']*2+$pokemon['spc.defence_iv']+floor($pokemon['spc.defence_ev']/4))*$levelnieuw/100)+5)*1)+$pokemon['spc_up'])*$info['spc.defence_add']);
  $hpstat         = round((($pokemon['hp_iv']+2*$pokemon2['hp_base']+floor($pokemon['hp_ev']/4))*$levelnieuw/100)+10+$levelnieuw+$pokemon['hp_up']); 
$dn = $pokemon2['groei'];  ///$dn = đức nghĩa
if($dn=="Erratic") {
    $dhp = 10;
    $dgiap = 5;
    $dtocdo = 1;
    $dtancong = 0;
    $sptancong = 3;
    $spphongthu = 3;
  $tnhp = '20';
    $tnatt = '15';
    $tndf = '25';
    $tnsp = '10';

}

if($dn=="Fast") {
    $dhp = 5;
    $dgiap = 3;
    $dtocdo = 15;
    $dtancong = 0;
  $sptancong = 1;
    $spphongthu = 1;   
    $tnhp = '25';
    $tnatt = '20';
    $tndf = '2';
    $tnsp = '50';
}

if($dn=="Medium Fast") {
    $dhp = 15;
    $dgiap = 5;
    $dtocdo = 1;
    $dtancong = 0;
  $sptancong = 6;
    $spphongthu = 6;    
     $tnhp = '30';
    $tnatt = '3';
    $tndf = '35';
    $tnsp = '3';
}
if($dn=="Medium Slow") {
    $dhp = 20;
    $dgiap = 20;
    $dtocdo = 15;
    $dtancong = 15;
  $sptancong = 15;
    $spphongthu = 15;   
    
    $tnhp = '5';
    $tnatt = '15';
    $tndf = '40';
    $tnsp = '3';
}
if($dn=="Slow") {
    $dhp = 25;
    $dgiap = 40;
    $dtocdo = 24;
    $dtancong = 36;
  $sptancong = 25;
    $spphongthu = 30;    
    
     $tnhp = '25';
    $tnatt = '20';
    $tndf = '1';
    $tnsp = '30';
}

if($pokemon[dai]>0) {
  $tmp = trangbi($pokemon[dai]);
  $hp_trangbi = $tmp[tang];
}

if($pokemon[non]>0) {
  $non = trangbi($pokemon[non]);
  $pt_trangbi = $non[tang];
}

if($pokemon[khan]>0) {
  $khan = trangbi($pokemon[khan]);
  $sp_tb = $khan[tang];
}
if($pokemon[kinh]>0) {
  $kinh = trangbi($pokemon[kinh]);
  $att_tb = $kinh[tang];
}
if($pokemon[day]>0) {
  $day = trangbi($pokemon[day]);
  $scpat_tb = $day[tang];
}
if($pokemon[nhan]>0) {
  $nhan = trangbi($pokemon[nhan]);
  $spcpt_tba = $nhan[tang];
}


$ntc = $attackstat + ($attackstat/100*$dtancong) + ($pokemon['tnat']*$tnatt)+$att_tb;
 $nhp = $hpstat + ($hpstat/100*$dhp) + ($pokemon['tnhp']*$tnhp)+$hp_trangbi;
 $ntd = $speedstat + ($speedstat/100*$dtocdo) + ($pokemon['tnsp']*$tnsp)+$sp_tb;
 $ngiap = $defencestat + ($defencestat/100*$dgiap) +  ($pokemon['tndf']*$tndf)+$pt_trangbi;
 $nspgiap = $spcdefencestat + ($spcdefencestat/100*$spphongthu) + $spcpt_tb;
 $nsptancong = $spcattackstat + ($spcattackstat/100*$spphongthu) + $spcpt_tba;

$sao = $pokemon['sao'];
if($sao==0) $buff = 0;
else if($sao==1) $buff = 20;
else if($sao==2) $buff = 40;
else if($sao==3) $buff = 60;
else if($sao==4) $buff = 80;
else if($sao==5) $buff = 100;

$atnew = round($ntc) + round($ntc/100*$buff);
$hpnew =  round($nhp)+ round($nhp/100*$buff);
$giapnew =  round($ngiap)+ round($ngiap/100*$buff);
$tdnew = round($ntd)+ round($ntd/100*$buff);
$spdnew = round($nspgiap)+ round($nspgiap/100*$buff);
$spattnew = round($nsptancong)+ round($nsptancong/100*$buff);

  //Stats opslaan
  if($pokemon[leven] > $pokemon[levenmax]) {
      $pokemon[leven] = $pokemon[levenmax];
  }
  
 $a= mysql_query("UPDATE `pokemon_speler` SET `levenmax`='".$hpnew."',`leven`='".$pokemon[leven]."', `attack`='".$atnew."', `defence`='".$giapnew."', `speed`='".$tdnew."', `spc.attack`='".$spattnew."', `spc.defence`='".$spdnew."' WHERE `id`='".$pokemon['id']."'");
  return $a;
}

//Tabel welke pokemon level je tegenkomt
function rankpokemon($ranknummer){ 
  /*
  Ranks en per rank de levels van de wilde pokemon
  1. Newbie		5
  2. Junior		5-10
  3. Bully		5-15
  4. Casual		8-20
  5. Trainer		10-25	
  6. Great Trainer	13-30
  7. Traveller		15-35
  8. Macho		18-40
  9. Gym Leader		20-45
  10. Shiny Trainer	25-50
  11. Elite Trainer	28-55
  12. Commander		30-60
  13. Professional	33-65
  14. Hero		35-70
  15. King 		38-75
  16. Champion		40-80
  17. Legendary		43-85
  18. Untouchable		45-90
  19. God			48-95
  20. Pokemon Master	50-100
  */
  
  if($ranknummer == 1) return 5;
  elseif($ranknummer == 2) return rand(5,10);
  elseif($ranknummer == 3) return rand(5,15);
  elseif($ranknummer == 4) return rand(8,20);
  elseif($ranknummer == 5) return rand(10,25);
  elseif($ranknummer == 6) return rand(13,30);
  elseif($ranknummer == 7) return rand(15,35);
  elseif($ranknummer == 8) return rand(18,40);
  elseif($ranknummer == 9) return rand(20,45);
  elseif($ranknummer == 10) return rand(25,50);
  elseif($ranknummer == 11) return rand(28,55);
  elseif($ranknummer == 12) return rand(30,60);
  elseif($ranknummer == 13) return rand(33,65);
  elseif($ranknummer == 14) return rand(35,70);
  elseif($ranknummer == 15) return rand(38,75);
  elseif($ranknummer == 16) return rand(40,80);
  elseif($ranknummer == 17) return rand(43,85);
  elseif($ranknummer == 18) return rand(45,90);
  elseif($ranknummer == 19) return rand(48,95);
  elseif($ranknummer == 20) return rand(50,100);
  else return 5;
}




//Ranknaam bepalen a.d.v ranknummer(a)
function rank($ranknummer){
  //Gegevens laden vanaf ranknummer
  $query = mysql_fetch_assoc(mysql_query("SELECT `naam` FROM `rank` WHERE `ranknummer`='".$ranknummer."'"));
  //Gegevens opstellen
  $rank['ranknummer'] = $ranknummer;
  $rank['ranknaam']   = $query['naam'];
  //Gegevens terug sturen
  return $rank;
}

//Maak pokemon naam goed ivm roepnaam & male/female
function pokemon_naam($oud,$roepnaam){
  $new_name = $oud;
  //Heeft de pokemon een roepnaam
  if(!empty($roepnaam)) 
    $new_name = $roepnaam;
  //Staat er een f/m achter de naam Male/Female Character maken
  elseif (preg_match('/ /', $oud)) {
    $pokemon = explode(" ", $oud);
    if($pokemon[1] == "f") $new_name = $pokemon[0]." &#9792;";
    elseif($pokemon[1] == "m") $new_name = $pokemon[0]." &#9794;";
    else $new_name = $oud;
  }
  //Nieuw naam terug sturen
  return $new_name;
}
  
//Maak Computer naam goed ivm male/female
function computer_naam($old){
  //Staat er een f/m achter de naam Male/Female Character maken
  if (preg_match('/ /', $old)) {
    $pokemon = explode(" ", $old);
    if($pokemon[1] == "f") 
      return $pokemon[0]." &#9792;";
    elseif($pokemon[1] == "m") 
      return $pokemon[0]." &#9794;";
    else return $old;
  }
  //Naam bevat geen spatie
  else return $old;
}

//Pokemonei function
function pokemonei($geg){
  if($geg['ei'] == 1){
    $ei = True;
    //Beide tijden opvragen, en strtotime van maken
    $tijdtoen = strtotime($geg['ei_tijd']);
    $tijdnu   = strtotime(date('Y-m-d H:i:s'));
    //Is er geen tijd dus niet goed geactieveerd, geen pokemon
    if($tijdtoen == ""){
      //Link maken voor het plaatje van de pokemon
      $new['animatie'] = "images/icons/egg.gif";
      $new['little']   = "images/icons/egg_big.gif";
      $new['link']     = "images/icons/egg_big.gif";
      //Geen leven opgeven
      $new['levenproc'] = "";
      //Andere naam voor de pokemon en de level
      $new['naam']  = "";
      $new['level'] = ""; 
      $new['ei']  = 1;
    }
    //Als het verschil minder dan 600 sec is, dan hele ei
    elseif($tijdnu-$tijdtoen < 300){
      //Bereken hoeveel tijd er nog over is
      $new['tijdover']  = 600-($tijdnu-$tijdtoen);
      $new['afteltijd'] = strftime("%M:%S", $new['tijdover']);
      //Link maken voor het plaatje van de pokemon
      $new['animatie']  = "images/icons/egg.gif";
      $new['little']    = "images/icons/egg_big.gif";
      $new['link']      = "images/icons/egg_big.gif";
      //Geen leven opgeven
      $new['levenproc'] = "Nog ".$new['afteltijd']." Trứng";
      //Alles andere naam toewijzen
      $new['ei']       = 1;
	  $new['wild_id'] = '??';
      $new['naam']       = "??";
      $new['def_naam']   = "??";
      $new['roepnaam'] = "??";
      $new['id']     = $geg['id'];
      $new['attack']     = "??";
      $new['leven']      = "??";
      $new['levenmax']   = "??";
      $new['defence']    = "??";
      $new['type1']      = "??";
      $new['type2']      = "??";
      $new['speed']      = "??";
      $new['level']      = "??";
      $new['exp']        = "??";
      $new['totalexp']   = "??";
      $new['expnodig']   = "??";
      $new['spcattack']  = "??";
      $new['spcdefence'] = "??";
      $new['lvl_hook']   = "(lvl ??)";
      $new['level_1'] = "-";
      $new['type']       = "<div style=&quot;padding-left:2px;&quot;>??</div>";
      $new['gevongenmet'] = "Pokeball";
      $new['karakter'] = "??";
      $new['aanval_1'] = "??";
      $new['aanval_2'] = "??";
      $new['aanval_3'] = "??";
      $new['aanval_4'] = "??";
    }
    //Als het verschil meer dan 600 sec is maar minder dan 900 dan halve ei
    elseif($tijdnu-$tijdtoen < 600){
      //Bereken hoeveel tijd er nog over is
      $new['tijdover']  = 600-($tijdnu-$tijdtoen);
      $new['afteltijd'] = strftime("%M:%S", $new['tijdover']);
      //Link maken voor het plaatje van de pokemon
      $new['link']      = "images/icons/egg_big.gif";
      $new['little']  = "images/icons/egg_big.gif";
      $new['animatie']  = "images/icons/egg_hatching.gif";
      //Geen leven opgeven
      $new['levenproc'] = "còn ".$new['afteltijd']." cho đến khi trứng nở";
      //Alles andere naam toewijzen
      $new['ei']       = 1;
	  $new['wild_id'] = '??';
      $new['naam']       = "??";
      $new['def_naam']   = "??";
      $new['roepnaam'] = "??";
      $new['shiny'] = 0;
      $new['id']     = $geg['id'];
      $new['attack']     = "??";
      $new['leven']      = "??";
      $new['levenmax']   = "??";
      $new['defence']    = "??";
      $new['type1']      = "??";
      $new['type2']      = "??";
      $new['speed']      = "??";
      $new['level']      = "??";
      $new['exp']        = "??";
      $new['totalexp']   = "??";
      $new['expnodig']   = "??";
      $new['spcattack']  = "??";
      $new['spcdefence'] = "??";
      $new['lvl_hook']   = "(lvl ??)";
      $new['lvl_stripe'] = "-";
      $new['type']       = "<div style=&quot;padding-left:2px;&quot;>??</div>";
      $new['gevongenmet'] = "Pokeball";
      $new['karakter'] = "??";
      $new['aanval_1'] = "??";
      $new['aanval_2'] = "??";
      $new['aanval_3'] = "??";
      $new['aanval_4'] = "??";
    }
    else $ei = False;
  }
  else $ei = False;
  if(!$ei){
    //Link maken voor het plaatje van de pokemon \
    foreach ($geg as $k => $v) {
      if(!is_numeric($k)) $new[$k] = $v;
    }   
    $new['ei'] = 0;
    $new['naamklein'] = strtolower($geg['naam']);

  	##**##
  	if($geg['shiny'] == 1){
        $new['link'] = "/images/shiny/".$new['wild_id'].".gif";
        $new['animatie'] = "/images/shiny/icon/".$new['wild_id'].".gif";
      $new['ducnghia'] = "/images/shiny/".$new['wild_id'].".gif";

      }
    else{
        $new['link'] = "/images/pokemon/".$new['wild_id'].".gif";
                $new['animatie'] = "/images/pokemon/icon/".$new['wild_id'].".gif";

        $new['ducnghia'] = "/images/pokemon/".$new['wild_id'].".gif";
    }
    #Andere naam voor de pokemon en de level
    #Alles andere naam toewijzen   
    $new['karakter'] = ucfirst($geg['karakter']);
    $new['def_naam'] = $geg['naam'];
	  if(empty($geg['roepnaam'])) $new['roepnaam'] = $geg['naam']; 
    else {
  		$new['roepnaam'] = $geg['roepnaam'];
  		$new['naam'] = $geg['naam'];
  	}
    if($geg['leven'] > 0) $new['levenprocent'] = round(($geg['leven']/$geg['levenmax'])*100);
    else $new['levenprocent'] = 0;
    if($geg['expnodig'] > 0) $new['expprocent'] = round(($geg['exp']/$geg['expnodig'])*100);
    else $new['expprocent'] = 0;
    $new['levenmin100'] = 100-$new['levenprocent']; 
	if(!empty($new['vorm'])) { $geg['type1'] = $new['vorm']; }
    $new['type1']       = strtolower($geg['type1']);
    $new['type2']       = strtolower($geg['type2']);
    //Heeft de pokemon twee types?
    if(empty($new['type2'])) $new['type'] = '<table><tr><td><div class=&quot;type '.$new['type1'].'&quot;>'.$new['type1'].'</div></td></tr></table>';
    else $new['type'] = '<table><tr><td><div class=&quot;type '.$new['type1'].'&quot;>'.$new['type1'].'</div></td><td> <div class=&quot;type '.$new['type2'].'&quot;>'.$new['type2'].'</div></td></tr></table>';
    $new['lvl_hook']     = "(lvl ".$geg['level'].")"; 
    $new['level_1']      = $geg['level'];
    $new['expmin100']    = 100-$new['expprocent']; 
    $new['spcattack']    = $geg['spc.attack'];
    $new['spcdefence']   = $geg['spc.defence'];
  }
  return $new;
}


	//if (file_exists("".$_SERVER['DOCUMENT_ROOT']."/firewall.php"))
 // include_once "".$_SERVER['DOCUMENT_ROOT']."/firewall.php";  



function ducnghia_bbcode($text) {
    // Mã BB
    $search = array(
        '~\[b\](.+?)\[/b\]~s',

        '~\[i\](.+?)\[/i\]~s',
                        '~\[red\](.+?)\[/red\]~s',

        '~\[u\](.+?)\[/u\]~s',
        '~\[quote\](.+?)\[/quote\]~s',
        '~\[color=(.+)\](.+?)\[/color\]~s',
        '~\[url\](.+)\[/url\]~s',
        '~\[url=(.+)\](.+)\[/url\]~s',
        '~\[img\](.+)\[/img\]~s',
                '~\[t\]~'

    );
    // Mã HTML tương ứng
    $replace = array(
        '<b>$1</b>',
        '<i>$1</i>',
                '<font color="red">$1</font>',

        '<span style="text-decoration:underline;">$1</span>',
        '<blockquote>$1</blockquote>',
        '<span style="color:$1;">$2</span>',
        '<a href="$1">$1</a>',
        '<a href="$1">$2</a>',
        '<img src="$1" alt="DucNghia" />',
                '</br>$1'
                
                
                

    );
   
    // Thay thế các mã BB bằng các mã HTML tương ứng
    return preg_replace($search, $replace, $text);
}

///adđ pokeon
function pokemon($pokemon, $level, $nid = 0) {
    if($nid==0) {
        $ui = $_SESSION['id'];
    } else {
        $ui = $nid;
    }
    $check_id = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id`='".$ui."'"));
 $new_computer_sql = mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_wild` WHERE `wild_id`='$pokemon'"));
$_POST['level'] = $level;
$pokemon_sql = mysql_query("SELECT pw.naam, pw.type1, pw.type2, pw.zeldzaamheid, pw.groei, pw.aanval_1, pw.aanval_2, pw.aanval_3, pw.aanval_4, ps.* FROM pokemon_wild AS pw INNER JOIN pokemon_speler AS ps ON ps.wild_id = pw.wild_id WHERE ps.user_id='".$check_id['id']."' AND ps.opzak='ja' ORDER BY ps.opzak_nummer ASC");

    //Alle gegevens vast stellen voordat alles begint.
    $new_computer['id']             = $new_computer_sql['wild_id'];
    $new_computer['pokemon']        = $new_computer_sql['naam'];
    $new_computer['aanval1']        = $new_computer_sql['aanval_1'];
    $new_computer['aanval2']        = $new_computer_sql['aanval_2'];
    $new_computer['aanval3']        = $new_computer_sql['aanval_3'];
    $new_computer['aanval4']        = $new_computer_sql['aanval_4'];
    $klaar          = false;
    $loop           = 0;
    $lastid         = 0;
	
    //Loop beginnen
    do{ 
      $teller = 0;
      $loop++;
      //Levelen gegevens laden van de pokemon
      $levelenquery = mysql_query("SELECT * FROM `levelen` WHERE `wild_id`='".$new_computer['id']."' AND `level`<='$level' ORDER BY `id` ASC ");

      //Voor elke pokemon alle gegeven behandelen
      while($groei = mysql_fetch_assoc($levelenquery)){

        //Teller met 1 verhogen
        $teller++;
        //Is het nog binnen de level?
        if($level >= $groei['level']){
          //Is het een aanval?
          if($groei['wat'] == 'att'){
            //Is er een plek vrij
            if(empty($new_computer['aanval1'])) $new_computer['aanval1'] = $groei['aanval'];
            elseif(empty($new_computer['aanval2'])) $new_computer['aanval2'] = $groei['aanval'];
            elseif(empty($new_computer['aanval3'])) $new_computer['aanval3'] = $groei['aanval'];
            elseif(empty($new_computer['aanval4'])) $new_computer['aanval4'] = $groei['aanval'];
            //Er is geen ruimte, dan willekeurig een aanval kiezen en plaatsen
            else{
              if(($new_computer['aanval1'] != $groei['aanval']) AND ($new_computer['aanval2'] != $groei['aanval']) AND ($new_computer['aanval3'] != $groei['aanval']) AND ($new_computer['aanval4'] != $groei['aanval'])){
                $nummer = rand(1,4);
                if($nummer == 1) $new_computer['aanval1'] = $groei['aanval'];
                elseif($nummer == 2) $new_computer['aanval2'] = $groei['aanval'];
                elseif($nummer == 3) $new_computer['aanval3'] = $groei['aanval'];
                elseif($nummer == 4) $new_computer['aanval4'] = $groei['aanval'];
              }
            }
          }

          //Evolueert de pokemon
          elseif($groei['wat'] == "evo"){
            $evo = mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_wild` WHERE `wild_id`='".$groei['nieuw_id']."'"));
            $new_computer['id']             = $groei['nieuw_id'];
            $new_computer['pokemon']        = $groei['naam'];
            $loop = 0;
            break;
          }
        }

        //Er gebeurd niks dan stoppen
        else{
          $klaar = true;
          break;
        }
      }
      if($teller == 0){
        break;
        $klaar = true;
      }
      if($loop == 2){
        break;
        $klaar = true;
      }
    }
	while(!$klaar);

    //Karakter kiezen 
    $karakter  = mysql_fetch_assoc(mysql_query("SELECT * FROM `karakters` ORDER BY rand() limit 1"));
    $experience = mysql_fetch_assoc(mysql_query("SELECT `punten` FROM `experience` WHERE `soort`='".$new_computer_sql['groei']."' AND `level`='$level'"));
    $attack_iv       = rand(2,31);
    $defence_iv      = rand(2,31);
    $speed_iv        = rand(2,31);
    $spcattack_iv    = rand(2,31);
    $spcdefence_iv   = rand(2,31);
    $hp_iv           = rand(2,31);
    $new_computer['attackstat']     = round(((($new_computer_sql['attack_base']*2+$attack_iv)*$_POST['level']/100)+5)*1);
    $new_computer['defencestat']    = round(((($new_computer_sql['defence_base']*2+$defence_iv)*$_POST['level']/100)+5)*1);
    $new_computer['speedstat']      = round(((($new_computer_sql['speed_base']*2+$speed_iv)*$_POST['level']/100)+5)*1);
    $new_computer['spcattackstat']  = round(((($new_computer_sql['spc.attack_base']*2+$spcattack_iv)*$_POST['level']/100)+5)*1);
    $new_computer['spcdefencestat'] = round(((($new_computer_sql['spc.defence_base']*2+$spcdefence_iv)*$_POST['level']/100)+5)*1);
    $new_computer['hpstat']         = round(((($new_computer_sql['hp_base']*2+$hp_iv)*$_POST['level']/100)+$_POST['level'])+10);
    $tijd = date('Y-m-d H:i:s');
    $opzak = $check_id['in_hand']+1;
$data_ducnghia_add = mysql_query("INSERT INTO `pokemon_speler` (`wild_id`, `user_id`, `opzak`, `opzak_nummer`, `karakter`, `level`, `levenmax`, `leven`, `totalexp`, `expnodig`, `attack`, `defence`, `speed`, `spc.attack`, `spc.defence`, `attack_iv`, `defence_iv`, `speed_iv`, `spc.attack_iv`, `spc.defence_iv`, `hp_iv`, `attack_ev`, `defence_ev`, `speed_ev`, `spc.attack_ev`, `spc.defence_ev`, `hp_ev`, `aanval_1`, `aanval_2`, `aanval_3`, `aanval_4`, `effect`, `ei`, `ei_tijd`,`nguoibat`) 
VALUES ('".$new_computer['id']."', '".$check_id['id']."', 'nee', '', '".$karakter['karakter_naam']."', '$level', '".$new_computer['hpstat'] ."', '".$new_computer['hpstat'] ."', '".$experience['punten']."', '".$experience['punten']."', '".$new_computer['attackstat']."', '".$new_computer['defencestat']."', '".$new_computer['speedstat']."', '".$new_computer['spcattackstat']."', '".$new_computer['spcdefencestat']."', '".$attack_iv."', '".$defence_iv."', '".$speed_iv."', '".$spcattack_iv."', '".$spcdefence_iv."', '".$hp_iv."', '".$new_computer_sql['effort_attack']."', '".$new_computer_sql['effort_defence']."', '".$new_computer_sql['effort_spc.attack']."', '".$new_computer_sql['effort_spc.defence']."', '".$new_computer_sql['effort_speed']."', '".$new_computer_sql['effort_hp']."', '".$new_computer['aanval1']."', '".$new_computer['aanval2']."', '".$new_computer['aanval3']."', '".$new_computer['aanval4']."', '".$new_computer_sql['effect']."', '0', '".$tijd."','".$check_id[id]."')");  

	return  $data_ducnghia_add;



}

//song

//$u  = mysql_fetch_assoc(mysql_query ("SELECT * FROM users WHERE id='".$_SESSION['id']."'"));
//$gebruiker= $u;
//$user_id = $u[id];
//$datauser= $u;


function vatpham($id,$soluong,$user_id){
	    	        $db = mysql_fetch_array(mysql_query("select * from vatpham where `user_id` = '$user_id' AND `id_shop` = '$id'"));
 if($id == 16){   
$vpt=7*24*3600+time();
} else 	    	        
	    	     if($id == 22){   
$vpt=1*24*3600+time();
} else 
  if($id == 23){   
$vpt=3*24*3600+time();
} else 
  if($id == 24){   
$vpt=7*24*3600+time();
} else  {
    $vpt = 0;
}
	    	        
	    	        
               if($db[id]==0) {
                   $a =   mysql_query("INSERT INTO `vatpham` SET `user_id`='".$user_id."', `id_shop`='{$id}' ,`soluong` = '".$soluong."',`timesudung` = '".$vpt."'");
   
               } else {
	    
			  $a =   mysql_query("UPDATE `vatpham` SET `soluong`=`soluong` + '".$soluong."',`timesudung` = '".$vpt."' WHERE `user_id`='".$user_id."' AND `id_shop`='".$id."'");
               }

        return $a;

}


function nick($gid){
 return   ducnghia_us($gid);
}

function ducnghia_us($gid){
	$gunner = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = $gid"));
$tkm = $gunner;

if(empty($tkm[name])) {$tennv =ucfirst($gunner['username']);}else{ $tennv =ucfirst($gunner['name']);}

if($tkm[admin]==1)  {
    $chuc = 'style="background-image: url(img/2.gif);width:350px;"'; $ma = 'mod'; }
    if($tkm[admin]==2) {
    $chuc = '[GM]'; }
    if($tkm[admin]==3) {
        $chuc .= 'style="background-image: url(img/backround3.gif);width:350px;"';
        $ma = 'admin';
    }

if($tkm[ducnghia_thoigiankhoa] > time()) {
return '<a href="javascript:ttnv('.$gid.')" style="color:#190B07;"><strike>'.$tennv.'</strike></a>'; 
} else {
	return '<b onclick="ttnv('.$gid.')"  class="'.$ma.'" '.$chuc.'>'.$tennv.'</b>'; }
   
	
	
	}
	
	
function ducnghia_usa($gid){
	global $_con;
	$gunner = mysql_fetch_assoc(mysqli_query($_con,"SELECT * FROM `users` WHERE `id` = $gid"));

	return '<b style="color:#E91E63;">'.ucfirst($gunner['username']).'</b>';
   
	
	
	}
	
	function users($gid){
	$gunner = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = $gid"));

	return ''.ucfirst($gunner['username']).'';
   
	
	
	}
	
	if($user_id >= 1) {
  
                     mysql_query("UPDATE `users` SET `user_id`=`id` WHERE `id`='".$datauser->id."'");

}
	$pokemon_sql = mysql_query("SELECT pw.naam, pw.type1, pw.type2, pw.zeldzaamheid, pw.groei, pw.aanval_1, pw.aanval_2, pw.aanval_3, pw.aanval_4, ps.* FROM pokemon_wild AS pw INNER JOIN pokemon_speler AS ps ON ps.wild_id = pw.wild_id WHERE ps.user_id='".$_SESSION['id']."' AND ps.opzak='ja' ORDER BY ps.opzak_nummer ASC");
  $gebruiker->in_hand = mysql_num_rows($pokemon_sql);
	                     mysql_query("UPDATE `users` SET `in_hand`='".mysql_num_rows($pokemon_sql)."' WHERE `id`='".$datauser->id."'");


$_exp_lv = array(
1 => '1000',
2 => '5000',
3 => '10000',
4 => '15000',
5 => '25000',
6 => '35000',
7 => '50000',
8 => '90000',
9 => '190000',
10 => '350000',
11 => '455000',
12 => '695000',
13 => '720000',
14 => '850000',
15 => '985000',
16 => '750000',
17 => '850000',
18 => '950000',
19 => '1900000',
20 => '2500000',
21 => '3800000',
22 => '4500000',
23 => '5900000',
24 => '6300000',
25 => '7700000',
25 => '8900000',
26 => '9390000',
27 => '11590000',
28 => '14990000',
29 => '15390000',
30 => '17690000',
31 => '19690000',
32 => '21690000',
33 => '25690000',
34 => '27690000',
35 => '30690000',
36 => '32690000',
37 => '35690000',
38 => '40690000',
39 => '45690000',
40 => '55690000',
41 => '68690000',
42 => '78690000',
43 => '88690000',
44 => '98690000',
45 => '108690000',
46 => '128690000',
47 => '138690000',
48 => '148690000',
49 => '158690000',
50 => '168690000',
);

$_level = $datauser->level;
$_lv_up = $datauser->level + 1;
$_exp = $datauser->exp;
$_exp_all = $_exp_lv[$_lv_up];
$_exp_new = $_exp - $_exp_all;
$_chiso = $_exp / $_exp_all * 100;

if($_exp >= $datauser->expmax AND $_level <50 ) {
    $ex = $_exp  - $datauser->expmax;
mysql_query("UPDATE `users` SET `exp` = '".$ex."',`level` = '".$_lv_up."',`expmax`='".$_exp_all."'  WHERE `user_id` = $user_id");




}

mysql_query("UPDATE `users` SET `exp` = '168680000'  WHERE `level` = '50' AND `exp` >= '16869000'");


mysql_query("UPDATE `vatpham` SET `soluong` = '0',`timesudung` = '0'  WHERE `timesudung` <= '".time()."' AND `timesudung` != '0' ");



function tinnhan($noidung,$nguoinhan,$nguoigui){
if(!$nguoigui) $nguoigui = 2;
if(!mysql_num_rows(mysql_query("SELECT * FROM `chat_users` WHERE `user_id` = $nguoigui AND `user_fr` = $nguoinhan")))
mysql_query("INSERT INTO `chat_users` SET `user_id` = {$nguoigui}, `user_fr` = {$nguoinhan}"); 

mysql_query("INSERT INTO `chat` SET `user_id` = $nguoigui, `user_fr` = $nguoinhan, `time` = '".time()."', `text` = '".$noidung."'");
mysql_query("UPDATE `chat_users` SET `amount` = `amount`+1, `amountplus` = `amountplus`+1, `view` = 0, `time` = '".time()."' WHERE `user_id` = $nguoigui AND `user_fr` = $nguoinhan");

}
function tin($chat) {
    $time = time()+5;
    //  $time = (time()*1000);


              mysql_query("INSERT INTO `chatthegioi` SET name = 'Server', user_id = '2',`text` = '".$chat."',`time` = '".$time."'");
}


    mysql_query("DELETE FROM `chatthegioi` WHERE `time` <= '".time()."' ");

    mysql_query("DELETE FROM `npcs` WHERE `time` <= '".time()."' AND `time` !='0' ");


$xbada=mysql_query("SELECT * FROM `ducnghia_boss` WHERE `hp` <= '0' AND `lv` >='1'");

	                        
    while($bossn=mysql_fetch_array($xbada)) {
     
     if (time()>$bossn['time']+60*60 AND $bossn['hp']<=0) {
    $ta = time()+5*60;
            mysql_query("UPDATE `ducnghia_boss` SET `hp`=`hpfull`,`uid`='0',`time` ='".$ta."' WHERE `id`='".$bossn[id]."'");
   	   $mapnl=mysql_fetch_array(mysql_query("SELECT * FROM `maps` WHERE `hieuung` = '1'  ORDER BY RAND() LIMIT 1 "));
   	$map_npc=mysql_fetch_array(mysql_query("SELECT * FROM `npcs` WHERE `map` = '".$mapnl[id]."' AND `style` !=''  ORDER BY RAND() LIMIT 1 "));

            mysql_query("UPDATE `npcs` SET `map` = '".$map_npc[map]."',`x` = '".$map_npc[x]."',`y` = '".$map_npc[y]."'   WHERE `id`='".$bossn[map]."'");

         
tin($bossn[id]);
}   
        
    }




//  mysql_query("DELETE FROM `pokemon_speler_gevecht` WHERE `time` <= '".time()."' ");
 //   mysql_query("DELETE FROM `pokemon_wild_gevecht` WHERE `time` <= '".time()."' ");

  mysql_query("DELETE FROM `ducnghia_vuotai` WHERE `thoigian` <= '".time()."'");



 $vuotai = mysql_fetch_assoc(mysql_query("SELECT * FROM `ducnghia_vuotai` WHERE `user_id`='".$user_id."'"));









///tiến hóa
if(!empty($_SESSION['evolueren'])) {
$link = base64_decode($_SESSION['evolueren']);
		  #Code splitten, zodat informatie duidelijk word
		  list ($evolueren['pokemonid'], $evolueren['nieuw_id']) = split ('[/]', $link);
		  $pokemon = mysql_fetch_assoc(mysql_query("SELECT pokemon_wild.wild_id, pokemon_wild.naam, pokemon_wild.groei, pokemon_speler.* FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_wild.wild_id = pokemon_speler.wild_id WHERE pokemon_speler.id='".$evolueren['pokemonid']."'"));

$update = mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_wild` WHERE `wild_id`='".$evolueren['nieuw_id']."'"));

  $button = False;
  #Pokemon opslaan als in bezit
  update_pokedex($update['wild_id'],$pokemon['wild_id'],'evo');

  #Nieuwe stats opslaan
  #Nieuwe level word
  $levelnieuw = $pokemon['level']+1;
  if($levelnieuw > 100) $levelnieuw = 100;
  $info = mysql_fetch_assoc(mysql_query("SELECT experience.punten, karakters.* FROM experience INNER JOIN karakters WHERE experience.soort='".$pokemon['groei']."' AND experience.level='".$levelnieuw."' AND karakters.karakter_naam='".$pokemon['karakter']."'"));

  $attackstat     = round(((((($update['attack_base']*2+$pokemon['attack_iv']+floor($pokemon['attack_ev']/4))*$pokemon['level']/100)+5)*1)+$pokemon['attack_up'])*$info['attack_add']);
  $defencestat    = round(((((($update['defence_base']*2+$pokemon['defence_iv']+floor($pokemon['defence_ev']/4))*$pokemon['level']/100)+5)*1)+$pokemon['defence_up'])*$info['defence_add']);
  $speedstat      = round(((((($update['speed_base']*2+$pokemon['speed_iv']+floor($pokemon['speed_ev']/4))*$pokemon['level']/100)+5)*1)+$pokemon['speed_up'])*$info['speed_add']);
  $spcattackstat  = round(((((($update['spc.attack_base']*2+$pokemon['spc.attack_iv']+floor($pokemon['spc.attack_ev']/4))*$pokemon['level']/100)+5)*1)+$pokemon['spc_up'])*$info['spc.attack_add']);
  $spcdefencestat = round(((((($update['spc.defence_base']*2+$pokemon['spc.defence_iv']+floor($pokemon['spc.defence_ev']/4))*$pokemon['level']/100)+5)*1)+$pokemon['spc_up'])*$info['spc.defence_add']);
  $hpstat         = round((((($update['hp_base']*2+$pokemon['hp_iv']+floor($pokemon['hp_ev']/4))*$pokemon['level']/100)+$pokemon['level'])+10)+$pokemon['hp_up']);

  #Pokemon gegevens en Stats opslaan
  mysql_query("UPDATE `pokemon_speler` SET `wild_id`='".$update['wild_id']."', `attack`='".$attackstat."', `defence`='".$defencestat."', `speed`='".$speedstat."', `spc.attack`='".$spcattackstat."', `spc.defence`='".$spcdefencestat."', `levenmax`='".$hpstat."', `leven`='".$hpstat."' WHERE `id`='".$pokemon['id']."'");
 
  #Check if more pokemon should evolve
  $current = array_pop($_SESSION['used']);      
  
  $count = 0;
  $sql = mysql_query("SELECT pokemon_wild.naam, pokemon_speler.id, pokemon_speler.wild_id, pokemon_speler.roepnaam, pokemon_speler.level, pokemon_speler.expnodig, pokemon_speler.exp FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_wild.wild_id = pokemon_speler.wild_id WHERE pokemon_speler.id='".$current."'");
  while($select = mysql_fetch_assoc($sql)){
    #Change name for male and female
    $select['naam_goed'] = pokemon_naam($select['naam'],$select['roepnaam']);
    if($select['level'] < 100){
      #Load data from pokemon living grows Leveling table
      $levelensql = mysql_query("SELECT `id`, `level`, `trade`, `wild_id`, `wat`, `nieuw_id`, `aanval` FROM `levelen` WHERE `wild_id`='".$select['wild_id']."' AND `level`>'".$_SESSION['lvl_old']."' AND `level`<='".$select['level']."' ORDER BY id ASC");
      #Voor elke actie kijken als het klopt.
      while($levelen = mysql_fetch_assoc($levelensql)){
        #als de actie een aanval leren is
        if($levelen['wat'] == "att"){
          #Kent de pokemon deze aanval al
          if(($select['aanval_1'] != $levelen['aanval']) AND ($select['aanval_2'] != $levelen['aanval']) AND ($select['aanval_3'] != $levelen['aanval']) AND ($select['aanval_4'] != $levelen['aanval'])){
            unset($_SESSION['evolueren']);
            if($levelen['level'] > $select['level']) break;
            $_SESSION['aanvalnieuw'] = base64_encode($select['id']."/".$levelen['aanval']);
            $count++;
            $_SESSION['lvl_old'] = $levelen['level'];
            array_push($_SESSION['used'], $select['id']);
            break;
          }
        }
        #Gaat de pokemon evolueren
        elseif($levelen['wat'] == "evo"){
          #The level is greater than or equal to the level that is required? To another page
          if(($levelen['level'] <= $select['level']) OR (($levelen['trade'] == 1) AND ($select['trade'] == "1.5"))){
            unset($_SESSION['aanvalnieuw']);
            if($levelen['level'] > $select['level']) break;
            $_SESSION['evolueren'] = base64_encode($select['id']."/".$levelen['nieuw_id']);
            $count++;
            $_SESSION['lvl_old'] = $levelen['level'];
            array_push($_SESSION['used'], $select['id']);
            break;
          }    
        }
      }
      if($count != 0) break;
    }
  }
  if($count == 0) unset($_SESSION['evolueren']);  
  
}

///ducnghia

	$check_nv_lv = mysql_fetch_assoc(mysql_query("SELECT * FROM `ducnghia_data_nhiemvu` WHERE `user_id` = '" . $user_id. "' AND `loai` = 'level'  "));
             	
             	if($check_nv_lv[id] !=0){
             	             mysql_query("UPDATE `ducnghia_data_nhiemvu` SET `song`='".$datauser->level."' WHERE `user_id`='".$_SESSION['id']."' AND `loai` = 'level'"); 
 
             	}	
      
 class hethong {
    public function __construct(...$args) {
        $this->hethong(...$args);
    }
		public $id = 0;
	

		public function hethong($id) {
			$map = mysql_fetch_array(mysql_query("SELECT * FROM `ducnghia_hethong` WHERE `id` = '" . mysql_real_escape_string($id) . "'"));

			foreach($map as $key => $value) {
				$this->{$key} = $value;
			}

			$this->data = json_decode($this->data);
			if (!isset($this->data)) {
				$this->data = new stdClass();
			}

		
		}
	}     
	
	$hethong = new hethong(1);
	if($hethong->data->thoigianmua < time()) {
  	mysql_query("UPDATE `maps` SET `thoitiet` = '0'");
	    
	   $ducnghiad_m=mysql_query("SELECT * FROM `maps` WHERE `hieuung` = '1' AND `thoitiet` ='0' ORDER BY RAND() LIMIT 2 ");
    while($mapgame=mysql_fetch_array($ducnghiad_m)) {
        	mysql_query("UPDATE `maps` SET `thoitiet` = '1' WHERE `id` ='".$mapgame[id]."'  ");
    }
  $hethong->data->thoigianmua = time() + 300; //5p
  	mysql_query("UPDATE `ducnghia_hethong` SET `data` = '" . json_encode($hethong->data) . "' WHERE `id` = '1'");
  
    
	}
	
	                     mysql_query("UPDATE `users` SET `top`=`id` WHERE `top`='0'");

///vqmm
         $datavqmm=mysql_fetch_array(mysql_query("SELECT * FROM `vxmm` ORDER BY `id` DESC LIMIT 1"));
         
     if($datavqmm['time'] <= time() AND $datavqmm['time'] !=0) {
   	                     mysql_query("UPDATE `users` SET `xu`=`xu`+'".$datavqmm['xu']."' WHERE `id`='".$datavqmm['u']."'");
    mysql_query("UPDATE `vxmm` SET `xu`='0',`time`='0',`u`='0' WHERE `id`='1'");
 	                     
      tin(''.users($datavqmm['u']).' vừa chiến thắng '.tron($datavqmm[xu]).' xu trong vòng quay may mắn. ');
     }    

if($datauser->khoa>time()) {
    session_destroy() ;

}



function shopvatpham($gid, $sl = 1){
    if($sl<=0) {
        $sl = 1;
    }
	$sq = mysql_fetch_assoc(mysql_query("SELECT * FROM `shopvatpham` WHERE `id` = $gid"));


	return ''.$sq[tenvatpham].'';
	
	}
	
	  $duel_sql = mysql_query("SELECT `id`, `datum`, `uitdager`, `tegenstander`, `bedrag`, `status` FROM `duel` WHERE `tegenstander`='".$datauser->username."' AND (`status`='wait') ORDER BY id DESC LIMIT 1");
	  
