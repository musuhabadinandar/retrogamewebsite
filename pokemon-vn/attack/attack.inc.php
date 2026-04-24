<?
#Load Computer Data
function computer_data($computer_id){
  #Load And Return All Computer Information
  return mysql_fetch_assoc(mysql_query("SELECT pokemon_wild.*, pokemon_wild_gevecht.* FROM pokemon_wild INNER JOIN pokemon_wild_gevecht ON pokemon_wild_gevecht.wildid = pokemon_wild.wild_id WHERE pokemon_wild_gevecht.id='".$computer_id."'"));
}

#Load  Pokemon Data
function pokemon_data($pokemon_id){
  #Load And Return All Pokemon Information
  return mysql_fetch_assoc(mysql_query("SELECT pw.*, ps.*, psg.* FROM pokemon_wild AS pw INNER JOIN pokemon_speler AS ps ON ps.wild_id = pw.wild_id INNER JOIN pokemon_speler_gevecht AS psg ON ps.id = psg.id  WHERE psg.id='".$pokemon_id."'"));
}
  
#Load Aanval logs
function aanval_log($aanval_log_id){
  #Load And Send Data
  return mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval_log` WHERE `id`='".$aanval_log_id."'"));
}

function aanval_log2($aanval_log_id){
  #Load And Send Data
  return mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval_log` WHERE `id`='".$aanval_log_id."'"));
}

#Knocked One Pokemon down
function one_pokemon_exp($aanval_log,$pokemon_info,$computer_info,$txt,$duc){
  $ids = explode(",", $aanval_log['gebruikt_id']);
  $aantal = 0;
  #Count all pokemon
  foreach($ids as $pokemonid){
    if(!empty($pokemonid)) $aantal++;
  }
  foreach($ids as $pokemonid){
    if(!empty($pokemonid)){  
      $used_info = mysql_fetch_assoc(mysql_query("SELECT pokemon_wild.naam, pokemon_speler.roepnaam, pokemon_speler.trade, pokemon_speler.level, pokemon_speler.expnodig, pokemon_speler_gevecht.leven, pokemon_speler_gevecht.exp FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_wild.wild_id = pokemon_speler.wild_id INNER JOIN pokemon_speler_gevecht ON pokemon_speler.id = pokemon_speler_gevecht.id WHERE pokemon_speler.id='".$pokemonid."'"));
      $used_info['naam_goed'] = pokemon_naam($used_info['naam'],$used_info['roepnaam']);  
      #If pokemon is dead no exp.
      if($used_info['leven'] > 0){
        #If pokemon is level 100 no more exp for him
        if($used_info['level'] < 100){
          #Check if the user is premium
          $user = mysql_fetch_assoc(mysql_query("SELECT premiumaccount FROM gebruikers WHERE user_id='".$_SESSION['id']."'"));

          $extra_exp = $used_info['trade'];
 if($used_info[level] <=30) {
     $expn = rand(30,50);
 } else {
     $expn = round($used_info[level]/1.5);
 }
 $expnua = round(($used_info[totalexp] - $used_info['exp'])/$used_info[level]);
if($expnua<=0) {
    $expnua=0;
}
          #Calculate EXP, division by aantal for amount of pokemon
          $tinh = round(((($computer_info['base_exp']*$computer_info['level'])*$extra_exp*1)/7)/$aantal)*$expn;
          if($duc==0) {
         $xp = $tinh+$expnua;
          } else {
                       $xp = ($tinh+$expnua)*5;

          }
         
         $ret['exp'] = $xp*2 ;
          #Add the exp and Effort points 
          mysql_query("UPDATE `pokemon_speler_gevecht` SET `exp`=`exp`+'".$ret['exp'] ."', `totalexp`=`totalexp`+'".$ret['exp'] ."', `attack_ev`=`attack_ev`+'".$computer_info['effort_attack']."', `defence_ev`=`defence_ev`+'".$computer_info['effort_defence']."', `speed_ev`=`speed_ev`+'".$computer_info['effort_speed']."', `spc.attack_ev`=`spc.attack_ev`+'".$computer_info['effort_spc.attack']."', `spc.defence_ev`=`spc.defence_ev`+'".$computer_info['effort_spc.defence']."', `hp_ev`=`hp_ev`+'".$computer_info['effort_hp']."' WHERE `id`='".$pokemonid."'");
          
          #Check if the Pokemon is traded
           $ret['bericht'] .= $used_info['naam_goed']." + ".$ret['exp']." xp,";

        }
      }
      else $aantal -= 1;
    }
  }
  #Empty Pokemon Used For new pokemon
  mysql_query("UPDATE `aanval_log` SET `gebruikt_id`=',".$pokemon_info['id'].",' WHERE `id`='".$aanval_log['id']."'");
 
  return $ret;
}

#Let Pokemon Grow
function pokemon_grow($txt){           
  $_SESSION['used'] = Array();    
  $count = 0;
  $sql = mysql_query("SELECT pokemon_wild.naam, pokemon_speler.id, pokemon_speler.roepnaam, pokemon_speler.level, pokemon_speler.expnodig, pokemon_speler.exp FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_wild.wild_id = pokemon_speler.wild_id WHERE user_id='".$_SESSION['id']."' AND `exp`>=`expnodig` AND `opzak`='ja'");
  while($select = mysql_fetch_assoc($sql)){
    if($count == 0) $_SESSION['lvl_old'] = $select['level'];
    array_push($_SESSION['used'], $select['id']);
    $count++;
    #Change name for male and female
    $select['naam_goed'] = pokemon_naam($select['naam'],$select['roepnaam']);
    if($select['level'] < 100){
      if($select['exp'] >= $select['expnodig']){
        do{                
          $real = mysql_fetch_assoc(mysql_query("SELECT pokemon_wild.*, pokemon_speler.* FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_speler.wild_id = pokemon_wild.wild_id  WHERE pokemon_speler.id='".$select['id']."'"));
                    
          #level info
          $levelnieuw = $real['level']+1;
          if($levelnieuw > 100) break;
          
          #Call Script for Calulcalate New stats
          $expnodig = nieuwestats($real,$levelnieuw,$real['exp']);
      
          #Check if Pokemon is growing a level
          if((!$_SESSION['aanvalnieuw']) AND (!$_SESSION['evolueren'])) $toestemming = levelgroei($levelnieuw,$real);
    
          #make Log
          $pokemonnaam = htmlspecialchars($select['naam_goed'], ENT_QUOTES);
		  
			#Event taal pack includen
			$eventlanguagesql = mysql_fetch_assoc(mysql_query("SELECT land FROM gebruikers WHERE user_id = '".$_SESSION['id']."'"));
			$eventlanguage = GetEventLanguage($eventlanguagesql['land']);
			include('../../language/events/language-events-en.php');
		  
			$event = '<img src="images/icons/blue.png" width="16" height="16" class="imglower" /> '.$pokemonnaam.' '.$txt['event_is_level_up'];
			
			#Melding geven aan de uitdager
			mysql_query("INSERT INTO gebeurtenis (id, datum, ontvanger_id, bericht, gelezen)
			VALUES (NULL, NOW(), '".$_SESSION['id']."', '".$event."', '0')");
		
        }while($expnodig < $real['exp']-$real['expnodig']);
      }
    }
  }
}

#Update Pokemon PLayer Hand
function pokemon_player_hand_update(){
  #Copy Life en Effect Stats to pokemon_speler table
  $player_hand_query = mysql_query("SELECT `id`, `leven`, `exp`, `totalexp`, `effect`, `attack_ev`, `defence_ev`, `speed_ev`, `spc.attack_ev`, `spc.defence_ev`, `hp_ev` FROM `pokemon_speler_gevecht` WHERE `user_id`='".$_SESSION['id']."'");
  while($player_hand = mysql_fetch_assoc($player_hand_query)){
    mysql_query("UPDATE `pokemon_speler` SET `leven`='".$player_hand['leven']."', `exp`='".$player_hand['exp']."', `totalexp`='".$player_hand['totalexp']."', `effect`='".$player_hand['effect']."', `attack_ev`=`attack_ev`+'".$player_hand['attack_ev']."', `defence_ev`=`defence_ev`+'".$player_hand['defence_ev']."', `speed_ev`=`speed_ev`+'".$player_hand['speed_ev']."', `spc.attack_ev`=`spc.attack_ev`+'".$player_hand['spc.attack_ev']."', `spc.defence_ev`=`spc.defence_ev`+'".$player_hand['spc.defence_ev']."', `hp_ev`=`hp_ev`+'".$player_hand['hp_ev']."' WHERE `id`='".$player_hand['id']."'");
  }
}

#Remove All Attack Data
function remove_attack($aanval_log_id){
  #Remove Attack
  mysql_query("UPDATE `gebruikers` SET `pagina`='attack_start' WHERE `user_id`='".$_SESSION['id']."'");
  mysql_query("DELETE FROM `pokemon_wild_gevecht` WHERE `aanval_log_id`='".$aanval_log_id."'");
  mysql_query("DELETE FROM `pokemon_speler_gevecht` WHERE `aanval_log_id`='".$aanval_log_id."'");
  mysql_query("DELETE FROM `aanval_log` WHERE `id`='".$aanval_log_id."'");
}

#Advantage (Water Against Fire)
function attack_to_defender_advantage($soort,$defender){
  #Gegevens laden uit de database
  $voordeel = mysql_fetch_assoc(mysql_query("SELECT `krachtiger` FROM `voordeel` WHERE `aanval`='".$soort."' AND (`verdediger`='".$defender['type1']."' OR `verdediger`='".$defender['type2']."')"));
  #Als er geen voordeel is, deze gegeven als 1 omdat anders de formule niet werkt
  if($voordeel['krachtiger'] == "") return 1; 
  #als het 0.00 is heeft aanval geen effect op de tegenstander
  elseif($voordeel['krachtiger'] == "0.00") return 0;
  #Anders het voordeel gebruiken
  else return $voordeel['krachtiger'];
}

#Attacker advantege 
function attacker_with_attack_advantage($attacker_info,$attack_info){
  if($attacker_info['type1'] OR $attacker_info['type2'] == $attack_info['soort']) return 1.5;
  else return 1;
}

#Multiple Hits
function multiple_hits($attack,$damage){
  #2-5 times?
  if($attack['aantalkeer'] == "2-5"){
    $kans = rand(1,4);
    #is kans niet 2, dan word aanval 2-3 keer uitgevoerd
    if($kans != 2){
      #Kijken hoeveek het echt word
      $times = rand(2,3);
      #Nieuwe levenaf berekenen
      $multi_hit['damage'] = $damage*$times;
      $multi_hit['message'] = "<br />".$attack['naam']." hits ".$times." times. ";
    }
    #Is het wel 2 dan word het 4-5 keer uitgevoerd
    else{
      #Kijken hoeveek het echt word
      $times = rand(4,5);
      #Nieuwe levenaf berekenen
      $multi_hit['damage'] = $damage*$times;
      $multi_hit['message'] = "<br />".$attack['naam']." hits ".$times." times. ";
    }
  }
  elseif($attack['aantalkeer'] == "1-3"){
    $times = rand(1,3);
    #Nieuwe levenaf berekenen
    $multi_hit['damage'] = $damage*$times;
    $multi_hit['message'] = "<br />".$attack['naam']." hits ".$times." times. ";
  }
  elseif($attack['aantalkeer'] == "gezond_opzak"){
    #Attack as many times as player have helaty pokemon in hand
    $times = mysql_num_rows(mysql_query("SELECT `id` FROM `pokemon_speler_gevecht` WHERE `user_id`='".$_SESSION['id']."' AND `effect`='' AND `leven`>'0'"));
    #Nieuwe levenaf berekenen
    $multi_hit['damage'] = $damage*$times;
    $multi_hit['message'] = "<br />".$attack['naam']." hits ".$times." times. ";
  }
  else{
    #Nieuwe levenaf berekenen
    $multi_hit['damage'] = $damage*$attack['aantalkeer'];
    $multi_hit['message'] = "<br />".$attack['naam']." hits ".$attack['aantalkeer']." times. ";
  }
  return $multi_hit;
}

#Calculate the amount of life thats going away
function life_formula($attacker_info,$opponent_info,$attack_info){
  #Check if the attack has a strength
  if($attack_info['sterkte'] != 0){
    #Check if attack is in advantage against oponent. Example: Water Against Fire
    $attack_adv = attack_to_defender_advantage($attack_info['soort'],$opponent_info)*10;
    #Check if attack is in advantage with attacker. Example Electric Pokemon does Thunder
    $attacker_adv = attacker_with_attack_advantage($attacker_info,$attack_info);
    #Generate Luck
    $luck = rand(217,255);
    if($opponent_info['defence'] <= 0) $opponent_info['defence'] = 1;
    
    #((2A/5+2)*B*C)/D)/50)+2)*X)*Y/10)*Z)/255
    # A = level
    # B = aanvallers attack
    # C = Kracht van de aanval
    # D = Verdedigers defence
    # X = Aanval type zelfde als Pokemon type. Zo ja dan 1.5, anders 1
    # Y = voordeel van de aanval
    # Z = willekeurig getal tussen 217 en 255
  
    $life_of = round(((((((((2*$attacker_info['level']/5+2)*$attacker_info['attack']*$attack_info['sterkte'])/$opponent_info['defence'])/50)+2)*$attacker_adv)*$attack_adv/10)*$luck)/255);
    return $life_of;
  }
  else return 0;
}
?>
