<?php
//Is all the information send
  //Session On
  session_start();  
  //Connect With Database
    include_once('../../templates/config.php'); 
include_once('../../templates/ducnghia.php'); 

  //Include Attack Functions
  include("../attack.inc.php");
  $page = 'attack/wild/wild-attack';
  //Goeie taal erbij laden voor de page
  include_once('../../language/language-pages.php');
  //Load Attack Info
  $aanval_log = aanval_log($_GET['aanval_log_id']);
  //Check if the right aanval_log is choosen
  if($aanval_log['user_id'] != $_SESSION['id']) exit;
  //Load Pokemon Info
  $pokemon_info = pokemon_data($aanval_log['pokemonid']);
  //Check if the right pokemon is choosen
  if($pokemon_info['user_id'] != $_SESSION['id']) exit;
  //Change name for male and female
  $pokemon_info['naam_goed'] = pokemon_naam($pokemon_info['naam'],$pokemon_info['roepnaam']);
  //Set Database Table
  $pokemon_info['table']['fight'] = "pokemon_speler_gevecht";
  //Load Computer Info
  $computer_info = computer_data($aanval_log['tegenstanderid']);
  //Change name for male and female
  $computer_info['naam_goed'] = computer_naam($computer_info['naam']);
  //Set Database Table
  $computer_info['table']['fight'] = "pokemon_wild_gevecht";
  $win_lose = 0;
  //Is the new pokemon alive
  ///ski;;;/


  ///ducnghia
  if($pokemon_info['leven'] == 0) $message = $pokemon_info['naam_goed'].$txt['new_pokemon_dead'];
  //You've caught the computer
  elseif($aanval_log['laatste_aanval'] == "gevongen") $message = $txt['success_catched_1'].$computer_info['naam_goed'].$txt['success_catched_2'];
  //The fight is ended
  elseif($aanval_log['laatste_aanval'] == "klaar") $message = $txt['new_pokemon_dead_1'].$computer_info['naam_goed'].$txt['new_pokemon_dead_2'];
  else{
    switch($_GET['wie']){
      case "pokemon":
        //Turn Check
        if(($aanval_log['laatste_aanval'] == "pokemon") OR ($aanval_log['laatste_aanval'] == "computereersteaanval")){
          $message = $computer_info['naam']." ".$txt['must_attack'];
          $next_turn = 1;
        }

        //Is te Pokemon Alive
        elseif($pokemon_info['leven'] <= 0){
          $message = "PokeMon ".$pokemon_info['naam_goed']." ".$txt['is_ko'];
        }
        else{
          //Check the attack
          
       
          $attack_name = $_GET['attack_name'];
          $attack_status['last_attack'] = "pokemon";
          $next_turn = 1;
          $attacker_info = $pokemon_info;
          $opponent_info = $computer_info;
          $attack_status['you'] = "pokemon";
          $attack_status['opponent'] = "computer";
          $attack_status['table']['you_busy'] = "aanval_bezig_speler";
          $attack_status['table']['other_busy'] = "aanval_bezig_computer";
          
$skillak = mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam`='{$attack_name}'"));
$hinhanh1 = strtolower($skillak['soort']);
$url = '/ducnghia/_/mega/'.$hinhanh1.'.gif';
          
        }

      break;  

      case "computer":
        //Turn Check
        if(($aanval_log['laatste_aanval'] == "computer") OR ($aanval_log['laatste_aanval'] == "spelereersteaanval")){
          $message = $pokemon_info['naam']." ".$txt['must_attack'];
        }
        else{
          //Check Wich Attack Computer have.
          $computer_attack = 0;
          if(!empty($computer_info['aanval_1'])) $computer_attack += 1;
          if(!empty($computer_info['aanval_2'])) $computer_attack += 1;
          if(!empty($computer_info['aanval_3'])) $computer_attack += 1;
          if(!empty($computer_info['aanval_4'])) $computer_attack += 1;
          $computer_attack = "aanval_".rand(1,$computer_attack);
          $attack_name = $computer_info[$computer_attack];
          $attack_status['last_attack'] = "computer";
          $next_turn = 0;
          $attacker_info = $computer_info;
          $opponent_info = $pokemon_info;
          $attack_status['you'] = "computer";
          $attack_status['opponent'] = "pokemon";
          $attack_status['table']['you_busy'] = "aanval_bezig_computer";
          $attack_status['table']['other_busy'] = "aanval_bezig_speler";
$skillak = mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam`='{$attack_name}'"));
$hinhanh1 = strtolower($skillak['soort']);
$url = '/ducnghia/_/mega/'.$hinhanh1.'.gif';
        }

      break;

      default:
        echo "Error: 4001";
        exit;
    }

    //Attack Begin
    //Set Default Attack Values
    $attack_status['continu'] = 1;
    $message_add = "";      
    $stappen = "";

    //Check For effect
    if(!empty($attacker_info['effect'])){
      $new_attacker_info['hoelang'] = $attacker_info['hoelang']-1;
      $new_attacker_info['effect'] = $attacker_info['effect'];  
	  
	  
      if($attacker_info['effect'] == "Flinch"){
        //Effect Empty
        $new_attacker_info['effect'] = "";
        $attack_status['continu'] = 0;
        $message = $attacker_info['naam_goed']." ".$txt['flinched'];
      }
	 
      elseif($attacker_info['effect'] == "Sleep"){
        $attack_status['continu'] = 0;
        if($new_attacker_info['hoelang'] >= 1){
          $message = $attacker_info['naam_goed']." ".$txt['sleeps'];
        }
        elseif($new_attacker_info['hoelang'] == 0){
          $message = $attacker_info['naam_goed']." ".$txt['awake'];
          $new_attacker_info['effect'] = "";
        }
      }

      elseif($attacker_info['effect'] == "Freeze"){
        $attack_status['continu'] = 0;
        if($new_attacker_info['hoelang'] >= 1){
          $message = $attacker_info['naam_goed']." ".$txt['frozen'];
        }
        elseif($new_attacker_info['hoelang'] == 0){
          $message = $attacker_info['naam_goed']." ".$txt['no_frozen'];
          $new_attacker_info['effect'] = "";
        }
      }

      elseif($attacker_info['effect'] == "Paralyzed"){
        $attack_change = rand(1,3);
        if($new_attacker_info['hoelang'] == 0){
          $attack_status['continu'] = 0;
          $message = $attacker_info['naam_goed']." ".$txt['not_paralyzed'];
          $new_attacker_info['effect'] = "";
        }
        elseif($attack_change == 2){
          $attack_status['continu'] = 1;
        }
        elseif($new_attacker_info['hoelang'] >= 1){
          $attack_status['continu'] = 0;
          $message = $attacker_info['naam_goed']." ".$txt['paralyzed'];
        }
      }
        
      elseif($attacker_info['effect'] == "Confused"){
        $attack_change = rand(1,3);
        if($new_attacker_info['hoelang'] == 0){
          $attack_status['continu'] = 0;
          $message = $attacker_info['naam_goed']." không còn bị nhầm lẫn.";
          $new_attacker_info['effect'] = "";
        }
        elseif($attack_change == 2){
          $attack_status['continu'] = 1;
        }
        elseif($new_attacker_info['hoelang'] >= 1){
          $attack_status['continu'] = 0;
          $message = $attacker_info['naam_goed']." bị bối rối.";
        }
      }
      
      elseif($new_attacker_info['hoelang'] == 0){
        $new_attacker_info['effect'] = "";
      }
      
      if($attack_status['continu'] == 0){
        if($_GET['wie'] == 'computer') $message .= $txt['your_attack_turn'];
        else $message .= " <br />".$opponent_info['naam_goed']." ".$txt['opponent_choose_attack'];
        
        
        mysql_query("UPDATE ".$attacker_info['table']['fight']." SET `effect`='".$new_attacker_info['effect']."', `hoelang`='".$new_attacker_info['hoelang']."' WHERE id='".$attacker_info['id']."'");
        mysql_query("UPDATE `aanval_log` SET `laatste_aanval`='".$attack_status['last_attack']."', `beurten`=`beurten`+'1' WHERE id='".$aanval_log['id']."'");
        echo $message." | ".$next_turn." | ".$opponent_info['leven']." | ".$opponent_info['levenmax']." | ".$attack_status['opponent']." | 0 | 0 | 0 | ".$opponent_info['id'] ." | ".$pokemon_info['opzak_nummer']." | ".$return['bericht']." | ".$new_exp." | ".$pokemon_info['expnodig']." | ".$recoil_d ." | ".$rec_left." | ".$attacker_info['levenmax']." | ".$attack_status['you']." | ".$stappen." | ".$url;
        exit;     
      }
      
    }
	
    //Load Attack Infos
    $attack_info = mysql_fetch_array(mysql_query("SELECT * FROM `aanval` WHERE `naam`='".$attack_name."'"));
	
    if($attack_info['naam'] == ""){
      if($_GET['wie'] == "computer") $next_turn = 1;
            echo "<a  onclick=vuotai()><b class=viptxt>Tiếp Tục</b></a>";
	  mysql_query("INSERT INTO `aanval_fail` (`username`, `aanval_name`, `aanval_computer`) VALUES ('".$_SESSION['naam']."', '".$attack_name."', '".$computer_attack."')");
      exit;  
    }
	
	  //Hit ratio down
	  $htdown = $attacker_info['hit_ratio_down']*2;
	  if($htdown > 0) $attack_info['mis']+$htdown;
	  
    //Check if attack does hit
    elseif((($attack_info['mis'] != 0) AND ($aanval_log[$attack_status['table']['you_busy']] == '') AND (rand(0,500) <= $attack_info['mis'])) OR
    ($aanval_log[$attack_status['table']['other_busy']] == 'Fliegen') OR
    ($aanval_log[$attack_status['table']['other_busy']] == 'Schaufler') OR
    ($aanval_log[$attack_status['table']['other_busy']] == 'Taucher') OR
	($aanval_log[$attack_status['table']['other_busy']] == 'Hyperstrahl') OR
	($aanval_log[$attack_status['table']['other_busy']] == 'Solarstrahl') OR
    ($aanval_log[$attack_status['table']['other_busy']] == 'Sprungfeder')){
      $message = $attacker_info['naam_goed']." sử dụng ".$attack_info['naam']." hụt";
      if($_GET['wie'] == 'computer') $message .= $txt['your_attack_turn'];
      else $message .= "<br />".$opponent_info['naam_goed']." ".$txt['opponent_choose_attack'];
      
      mysql_query("UPDATE `aanval_log` SET `laatste_aanval`='".$attack_status['last_attack']."', `beurten`=`beurten`+'1' WHERE id='".$aanval_log['id']."'");
      echo $message." | ".$next_turn." | ".$opponent_info['leven']." | ".$opponent_info['levenmax']." | ".$attack_status['opponent']." | 0 | 0 | 0 | ".$opponent_info['id'] ." | ".$pokemon_info['opzak_nummer']." | ".$return['bericht']." | ".$new_exp." | ".$pokemon_info['expnodig']." | ".$recoil_d ." | ".$rec_left." | ".$attacker_info['levenmax']." | ".$attack_status['you']." | ".$stappen." | ".$url;
      exit;
    } 	
	
    //Check if attack does have power
    if($attack_info['sterkte'] != 0){
      //Calculate Life Decreasing
      $life_decrease = life_formula($attacker_info,$opponent_info,$attack_info);
    }
    elseif($attack_info['hp_schade'] != 0){
      $life_decrease = $attack_info['hp_schade'];
    }

    //If attack hits more then once
    if($attack_info['aantalkeer'] != "1"){
      $multi_hit = multiple_hits($attack_info,$life_decrease);
      $life_decrease = $multi_hit['damage'];
      $message_add .= $multi_hit['message'];
    }
    
    //Does the attack have Critical Hit?
    if($attack_info['critical'] == 1){
      $critic_change = round(($attacker_info['speed']*100)/128);
      if(rand(0,100) <= $critic_change){
        $attack_info['sterkte'] = $attack_info['sterkte']*1.5;
        $message_add .= "<br />,một hit trực tiếp!";
      }
    }
    
    //Does the attack have any side effects
    if((!empty($attack_info['effect_naam'])) AND ($attack_info['effect_kans'] != 0)){
      if(($attack_info['effect_kans'] == 100) OR (rand(0,100) <= ($attack_info['effect_kans']))){
        $effect_info = mysql_fetch_array(mysql_query("SELECT * FROM effect WHERE actie='".$attack_info['effect_naam']."'"));
        if(($effect_info['wat'] == "negatief_tijd") AND ($effect_info['id'] != 31)){
          $turns = 0;
          //Sleep or Freeze
          if(($effect_info['id'] == 28) OR ($effect_info['id'] == 32)) $turns = rand(1,5);
          //Confused 
          elseif($effect_info['id'] == 33) $turns = rand(1,4);
          //Flinch
          elseif($effect_info['id'] == 34) $turns = 1;
          //Save to opponent
          mysql_query("UPDATE ".$opponent_info['table']['fight']." SET effect='".$effect_info['actie']."', hoelang='".$turns."' WHERE id='".$opponent_info['id']."' AND effect=''");
          $message = $attacker_info['naam_goed']." sử dụng ".$attack_info['naam']." chí mạng!";
          if(empty($opponent_info['effect'])) $message .= "<br />".$opponent_info['naam_goed']." ist ".$effect_info['naam'];
          if($_GET['wie'] == 'computer') $message .= $txt['your_attack_turn'];
          else $message .= "<br />".$opponent_info['naam_goed']." ".$txt['opponent_choose_attack'];
         
          mysql_query("UPDATE `aanval_log` SET `laatste_aanval`='".$attack_status['last_attack']."', `beurten`=`beurten`+'1' WHERE id='".$aanval_log['id']."'");
          echo $message." | ".$next_turn." | ".$opponent_info['leven']." | ".$opponent_info['levenmax']." | ".$attack_status['opponent']." | 0 | 0 | 0 | ".$opponent_info['id'] ." | ".$pokemon_info['opzak_nummer']." | ".$return['bericht']." | ".$new_exp." | ".$pokemon_info['expnodig']." | ".$recoil_d ." | ".$rec_left." | ".$attacker_info['levenmax']." | ".$attack_status['you']." | ".$stappen." | ".$url;
          exit;
        }
        elseif($effect_info['wat'] == "negatief"){
          if(($effect_info['actie'] == "Defence_down") OR ($effect_info['actie'] == "Defence_down_2")){
            //Defence Down
            $new_stat = round(($opponent_info['defence']/100)*(100-$effect_info['kracht']));
            $sql = "defence='".$new_stat."'";
            $text = ' Phòng vệ sinh.';
          }
          elseif(($effect_info['actie'] == "Speed_down") OR ($effect_info['actie'] == "Speed_down_2")){
            //Speed Down
            $new_stat = round(($opponent_info['speed']/100)*(100-$effect_info['kracht']));
            $sql = "speed='".$new_stat."'";
            $text = ' Giảm tốc độ.';
          }
          elseif(($effect_info['actie'] == "Spc.defence_down") OR ($effect_info['actie'] == "Spc.defence_down_2")){
            //Special Defence Down
            $new_stat = round(($opponent_info['spc.defence']/100)*(100-$effect_info['kracht']));
            $sql = "`spc.defence`='".$new_stat."'";
            $text = ' SPZ phòng thủ đang chìmt.';
          }
          elseif(($effect_info['actie'] == "Attack_down") OR ($effect_info['actie'] == "Attack_down_2")){
            //Attack Down
            $new_stat = round(($opponent_info['attack']/100)*(100-$effect_info['kracht']));
            $sql = "attack='".$new_stat."'";
            $text = ' Tấn công chìm(giảm).';
          }
          elseif($effect_info['actie'] == "Attack_defence_down"){
            //Attack& Speed Down
            $new_stat = round(($opponent_info['attack']/100)*(100-$effect_info['kracht']));
            $sql = "attack='".$new_stat."'";
            $new_stat = round(($opponent_info['defence']/100)*(100-$effect_info['kracht']));
            $sql .= ", defence='".$new_stat."'";
            $text = ' Tấn công và giảm tốc độ.';
          }
          elseif($effect_info['actie'] == "defence_spc.defence_down"){  
            //Spc.Defence & Defence Down          
            $new_stat = round(($opponent_info['defence']/100)*(100-$effect_info['kracht']));
            $sql = "defence='".$new_stat."'";
            $new_stat = round(($opponent_info['spc.defence']/100)*(100-$effect_info['kracht']));
            $sql .= ", `spc.defence`='".$new_stat."'";
            $text = ' SPC đang giảm.';
          }
          elseif($effect_info['actie'] == "Hit_ratio_down"){      
            //Hit Ratio Down          
            $new_stat = $opponent_info['hit_ratio_down']+1;
            $sql = "hit_ratio_down='".$new_stat."'";
            $text = ' Tỷ lệ lần truy cập giảm.';
          }
          mysql_query("UPDATE ".$opponent_info['table']['fight']." SET ".$sql." WHERE id='".$opponent_info['id']."'");
          $message_add .= "<br /> ".$opponent_info['naam_goed']." ".$text;
        }
        elseif($effect_info['wat'] == "positief"){
          if(($effect_info['actie'] == "Defence_up") OR ($effect_info['actie'] == "Defence_up_2")){
            //Defence Up
            $new_stat = round(($attacker_info['defence']/100)*(100+$effect_info['kracht']));
            $sql = "defence='".$new_stat."'";
            $text = ' Phòng thủ tăng.';
          }
          elseif(($effect_info['actie'] == "Attack_up") OR ($effect_info['actie'] == "Attack_up_2")){
            //Attack up
            $new_stat = round(($attacker_info['attack']/100)*(100+$effect_info['kracht']));
            $sql = "attack='".$new_stat."'";
            $text = ' Tấn công tăng.';
          }
          elseif($effect_info['actie'] == "Speed_up_2"){
            //Speed Up
            $new_stat = round(($attacker_info['speed']/100)*(100+$effect_info['kracht']));
            $sql = "speed='".$new_stat."'";
            $text = ' Tốc độ tăng.';
          }
          elseif($effect_info['actie'] == "Spc.defence_up_2"){
            //Spc. Defence Up
            $new_stat = round(($attacker_info['spc.defence']/100)*(100+$effect_info['kracht']));
            $sql .= "`spc.defence`='".$new_stat."'";
            $text = ' SPC.PT tăng.';
          }
          elseif($effect_info['actie'] == "All_up"){  
            //All stats Up          
            $new_stat = round(($attacker_info['attack']/100)*(100+$effect_info['kracht']));
            $sql = "attack='".$new_stat."'";
            $new_stat = round(($attacker_info['defence']/100)*(100+$effect_info['kracht']));
            $sql .= ", defence='".$new_stat."'";
            $new_stat = round(($attacker_info['spc.defence']/100)*(100+$effect_info['kracht']));
            $sql .= ", `spc.defence`='".$new_stat."'";
            $new_stat = round(($attacker_info['spc.attack']/100)*(100+$effect_info['kracht']));
            $sql .= ", `spc.attack`='".$new_stat."'";
            $new_stat = round(($attacker_info['speed']/100)*(100+$effect_info['kracht']));
            $sql .= ", speed='".$new_stat."'";
            $text = ' Giá trị được nâng lên đáng kể.';
          }
          elseif($effect_info['actie'] == "Attack_defence_up"){      
            //Attack & Defence Up         
            $new_stat = round(($attacker_info['attack']/100)*(100+$effect_info['kracht']));
            $sql = "attack='".$new_stat."'";
            $new_stat = round(($attacker_info['defence']/100)*(100+$effect_info['kracht']));
            $sql .= ", defence='".$new_stat."'";
            $text = ' Tấn công và phòng thủ đang gia tăng.';
          }
          elseif($effect_info['actie'] == "spc_up"){      
            //Specials Up    
            $new_stat = round(($attacker_info['spc.attack']/100)*(100+$effect_info['kracht']));
            $sql = "`spc.attack`='".$new_stat."'";
            $new_stat = round(($attacker_info['spc.defence']/100)*(100+$effect_info['kracht']));
            $sql .= ", `spc.defence`='".$new_stat."'";
            $text = ' SPC.phòng thủ tăng..';
          }
          elseif($effect_info['actie'] == "defence_spc.defence_up"){      
            //Defences UP        
            $new_stat = round(($attacker_info['defence']/100)*(100+$effect_info['kracht']));
            $sql = "defence='".$new_stat."'";
            $new_stat = round(($attacker_info['spc.defence']/100)*(100+$effect_info['kracht']));
            $sql .= ", `spc.defence`='".$new_stat."'";
            $text = 'SPC PHÒNG THỦ TĂNG.';
          }
          elseif($effect_info['actie'] == "attack_speed_up"){      
            //Attack & Speed Up         
            $new_stat = round(($attacker_info['attack']/100)*(100+$effect_info['kracht']));
            $sql = "attack='".$new_stat."'";
            $new_stat = round(($attacker_info['speed']/100)*(100+$effect_info['kracht']));
            $sql .= ", speed='".$new_stat."'";
            $text = ' Tấn công tốc độ tăng.';
          }
          elseif($effect_info['actie'] == "Spc.Attack_up_2"){      
            //Spc. Attack Up    
            $new_stat = round(($attacker_info['spc.attack']/100)*(100+$effect_info['kracht']));
            $sql = "`spc.attack`='".$new_stat."'";
            $text = ' SPC.Tấn công tăng.';
          }

          mysql_query("UPDATE ".$attacker_info['table']['fight']." SET ".$sql." WHERE id='".$attacker_info['id']."'");
          $message_add .= "<br /> ".$attacker_info['naam_goed']." ".$text;
        }
        elseif($effect_info['wat'] == "beide"){
          if($effect_info['actie'] == "attack_defence_up_speed_down"){
            $new_stat = round(($attacker_info['attack']/100)*(100+$effect_info['kracht']));
            $sql = "attack='".$new_stat."'";
            $new_stat = round(($attacker_info['defence']/100)*(100+$effect_info['kracht']));
            $sql .= "defence='".$new_stat."'";
            $new_stat = round(($opponent_info['speed']/100)*(100-$effect_info['kracht']));
            $sql .= "speed='".$new_stat."'";
            mysql_query("UPDATE ".$attacker_info['table']['fight']." SET "." WHERE id='".$attacker_info['id']."'");
            $message_add .= "<br /> ".$attacker_info['naam_goed']." Tấn công và phòng thủ đang gia tăng.<br />Giảm tốc độ.";
          }
        }
      }
    }
    
    //Does the attack have an extra effect
    elseif(!empty($attack_info['extra'])){
      if($attack_info['extra'] == 'half_attack_recover'){
        if($attacker_info['leven'] != $attacker_info['levenmax']){
          $rec_left = $attacker_info['leven']+round($life_decrease/2);
          mysql_query("UPDATE `".$attacker_info['table']['fight']."` SET `leven`=`levenmax` WHERE `id`='".$attacker_info['id']."'");
          $message_add .= "<br /> ".$attacker_info['naam_goed']." khôi phục HP ";
        }
      }
    }
	
	//Attacke Finale
    if($attack_info['naam'] == "Finale"){
      $finale = $attacker_info['levenmax']-$attacker_info['levenmax'];
      mysql_query("UPDATE `".$attacker_info['table']['fight']."` SET `leven`='".$finale."' WHERE `id`='".$attacker_info['id']."'");
      $message_add .= "<br /> ".$attacker_info['naam_goed']." đã đánh bại chính mình. ";
    }
	
	//Explosion
	if($attack_info['naam'] == "Explosion"){
	$explosion = (round($attacker_info['leven']) - round($attacker_info['levenmax'])/2);
	if(round($explosion) <= 1){
	    mysql_query("UPDATE `".$attacker_info['table']['fight']."` SET `leven`='0' WHERE `id`='".$attacker_info['id']."'");
        $message_add .= "<br /> ".$attacker_info['naam_goed']." đã bị đánh bại.";	
	}
	elseif(round($explosion) <= round($attacker_info['leven'])){
	    mysql_query("UPDATE `".$attacker_info['table']['fight']."` SET `leven`='".$explosion."' WHERE `id`='".$attacker_info['id']."'");
        $message_add .= "<br /> ".$attacker_info['naam_goed']." mất 1 nửa HP.";
		}
	else{
	mysql_query("UPDATE `".$attacker_info['table']['fight']."` SET `leven`='0' WHERE `id`='".$attacker_info['id']."'");
	exit;
	}
      }
    
    //Does The attack Hits in recoil?
    elseif($attack_info['recoil'] > 1){
      $recoil_d = round(($life_decrease/100)*$attack_info['recoil']);
      $rec_left = $attacker_info['leven']-$recoil_d;
      if($rec_left < 0) $rec_left = 0;
      mysql_query("UPDATE `".$attacker_info['table']['fight']."` SET `leven`='".$rec_left."' WHERE `id`='".$attacker_info['id']."'");
      $message_add .= "<br /> ".$attacker_info['naam_goed']." bị trúng giật. ";
    }
    
    //Hits with burn?
    if($attacker_info['effect'] == 'Burn'){
      $recoil_d = round($attacker_info['levenmax']/16);
      $rec_left = $attacker_info['leven']-$recoil_d;
      if($rec_left < 0) $rec_left = 0;
      mysql_query("UPDATE `".$attacker_info['table']['fight']."` SET `leven`='".$rec_left."' WHERE `id`='".$attacker_info['id']."'");
      $message_add .= "<br /> ".$attacker_info['naam_goed']." bỏng. ";
    }
    
    //Attack Have to Steps
    if($attack_info['stappen'] == 2){
      //attack have to load first
      if(($attack_info['laden'] == 'voor') AND (empty($aanval_log[$attack_status['table']['you_busy']]))){
        if($_GET['wie'] == 'pokemon') $stappen = $attack_info['naam'];
        $message = $attacker_info['naam_goed']." chuẩn bị sẵn sàng cho ".$attack_info['naam'];
        if($_GET['wie'] == 'computer') $message .= $txt['your_attack_turn'];
        else $message .= "<br />".$opponent_info['naam_goed']." ".$txt['opponent_choose_attack'];
       
        mysql_query("UPDATE `aanval_log` SET `laatste_aanval`='".$attack_status['last_attack']."', `beurten`=`beurten`+'1', ".$attack_status['table']['you_busy']."='".$attack_info['naam']."' WHERE id='".$aanval_log['id']."'");
        echo $message." | ".$next_turn." | ".$opponent_info['leven']." | ".$opponent_info['levenmax']." | ".$attack_status['opponent']." | 0 | 0 | 0 | ".$opponent_info['id'] ." | ".$pokemon_info['opzak_nummer']." | ".$return['bericht']." | ".$new_exp." | ".$pokemon_info['expnodig']." | ".$recoil_d ." | ".$rec_left." | ".$attacker_info['levenmax']." | ".$attack_status['you']." | ".$stappen." | ".$url;
        exit;
      }
      else{
        $aanval_log_sql = ",".$attack_status['table']['you_busy']."=''";
      }

    }
    
    //Check burn
    if(($attack_info['effect_naam'] == 'Burn') AND (($attack_info['effect_kans'] == 100) OR (rand(0,100) <= $attack_info['effect_kans']))){
      //Save to opponent
      mysql_query("UPDATE ".$opponent_info['table']['fight']." SET effect='Burn', hoelang='".$turns."' WHERE id='".$opponent_info['id']."' AND effect=''");
      $message_burn = "<br />".$opponent_info['naam_goed']." bỏng.";
    }
  
      
	
    if($life_decrease > 0) $life_off = 1;
    else $life_off = 0;

    $levenover = $opponent_info['leven']-$life_decrease;
    //$message .= "<br />".$levenover;
    $attack_status['fight_end'] = 0;
      $message = $attacker_info['naam_goed']." ".$txt['did']." ".$attack_info['naam'].".".$message_add.$message_burn;
    if($life_decrease == 0){
      if($_GET['wie'] == 'computer') $message .= $txt['your_attack_turn'];
      else $message .= "<br />".$opponent_info['naam_goed']." ".$txt['opponent_choose_attack'];
    }
    elseif($levenover <= 0){
      //Gevecht klaar als dit de tegenstander is
      $next_turn = 0;
      $levenover = 0;
      $attack_status['fight_end'] = 1;
      if($attack_status['last_attack'] == "computer"){
        //Alle pokemons van de speler tellen
        $aantalpokemon = mysql_num_rows(mysql_query("SELECT pokemon_speler_gevecht.id FROM pokemon_speler_gevecht INNER JOIN pokemon_speler ON pokemon_speler_gevecht.id = pokemon_speler.id WHERE pokemon_speler_gevecht.aanval_log_id = '".$aanval_log['id']."' AND pokemon_speler_gevecht.leven > '0' AND pokemon_speler.ei = '0'"));
        //Kan hij geen pokemon wisselen
        if(($aantalpokemon <= 1) OR (empty($aantalpokemon))){
          $aantalbericht = $txt['fight_over'];
          $attack_status['last_attack'] = "end_screen";
        }
        else{
          $aantalbericht = $txt['choose_another_pokemon'];
          $attack_status['fight_end'] = 0;
          $attack_status['last_attack'] = "wissel";
        }

        $message = $computer_info['naam_goed']." ".$txt['use_attack_1']." ".$attack_info['naam'].$txt['use_attack_2'].$message_add.$aantalbericht;

      }
      elseif($attack_status['last_attack'] == "pokemon"){
        $attack_status['last_attack'] = "end_screen";
        $message = ''.$pokemon_info['naam_goed']." ".$txt['use_attack_1']." ".$attack_info['naam'].$txt['use_attack_2_hit']." ".$computer_info['naam_goed']." ".$txt['is_ko'].$message_add;
        $return = one_pokemon_exp($aanval_log,$pokemon_info,$computer_info,$txt,1);
      }
    }
    else{
      $message = ''.$attacker_info['naam_goed']." ".$txt['did']." ".$attack_info['naam'].$txt['hit!'].$message_add.$message_burn;
      if($_GET['wie'] == 'computer') $message .= $txt['your_attack_turn'];
      else $message .= "<br />".$opponent_info['naam_goed']." ".$txt['opponent_choose_attack'];
    }

    //Update
    mysql_query("UPDATE `".$opponent_info['table']['fight']."` SET `leven`='".$levenover."' WHERE `id`='".$opponent_info['id']."'");
    //Update Aanval Log
    mysql_query("UPDATE `aanval_log` SET `laatste_aanval`='".$attack_status['last_attack']."', `beurten`=`beurten`+'1' ".$aanval_log_sql." WHERE `id`='".$aanval_log['id']."'"); 
  }

  $new_exp = ($pokemon_info['exp']+$return['exp'])*1;
				




  echo $message." | ".$next_turn." | ".$levenover." | ".$opponent_info['levenmax']." | ".$attack_status['opponent']." | ".$life_off." | ".$attack_status['fight_end']." | ".$life_decrease ." | ".$opponent_info['id'] ." | ".$pokemon_info['opzak_nummer']." | ".$return['bericht']." | ".$new_exp." | ".$pokemon_info['expnodig']." | ".$recoil_d ." | ".$rec_left." | ".$attacker_info['levenmax']." | ".$attack_status['you']." | ".$stappen." | ".$url ;

?>