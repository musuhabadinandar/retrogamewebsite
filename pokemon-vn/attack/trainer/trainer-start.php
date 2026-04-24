<?
function create_new_trainer_attack($trainer,$trainer_ave_level,$gebied){

  //Delete last attack logs
  mysql_query("DELETE FROM `aanval_log` WHERE `user_id`='".$_SESSION['id']."'");
  mysql_query("DELETE FROM `pokemon_speler_gevecht` WHERE `user_id`='".$_SESSION['id']."'");

  //Create Attack log
  create_aanval_log($gebied,$trainer);

  //Create Trainer
  $attack_info = create_new_trainer($trainer,$trainer_ave_level);
  
  //Create Player
  create_player($attack_info);
    
  //Who can start
  $attack_info = who_can_start($attack_info);
    
  //There Are no living pokemon.
  if(empty($attack_info['bericht'])){
    //Save Computer As Seen in Pokedex
    update_pokedex($attack_info['computer_wildid'],'','zien');
    
	//Save Attack Info
    save_attack($attack_info);
    
    $_SESSION['trainer']['begin_zien'] = true;
  }
  else{
    //Clear Computer
    mysql_query("DELETE FROM `pokemon_wild_gevecht` WHERE `id`='".$attack_info['computer_id']."'");
    //Clear Player
    mysql_query("DELETE FROM `pokemon_speler_gevecht` WHERE `user_id`='".$_SESSION['id']."'");
  }
  
  return $attack_info;
}

function create_aanval_log($gebied,$trainer){
  mysql_query("INSERT INTO `aanval_log` (`user_id`, `gebied`, `trainer`)
    VALUES ('".$_SESSION['id']."', '".$gebied."', '".$trainer."')");
    
  $_SESSION['trainer']['aanval_log_id'] = mysql_insert_id();
}

function save_attack($attack_info){
  $gebruikt = ','.$attack_info['pokemonid'].',';
  
  //UPDATE Query
  mysql_query("UPDATE `aanval_log` SET `laatste_aanval`='".$attack_info['begin']."', `tegenstanderid`='".$attack_info['computer_id']."', `pokemonid`='".$attack_info['pokemonid']."', `gebruikt_id`='".$gebruikt."' WHERE `id`='".$_SESSION['trainer']['aanval_log_id']."'");
  
  //Save Player Page Status   
}

function who_can_start($attack_info){
  //Kijken wie de meeste speed heeft, die mag dus beginnen.
  //Speed stat tegenstander -> $speedstat
  //Pokemons laden die de speler opzak heeft
  $nummer = 0;
  $opzaksql = mysql_query("SELECT ps.id, ps.opzak_nummer, ps.leven, ps.speed, ps.ei, pw.naam  FROM pokemon_speler AS ps INNER JOIN pokemon_wild AS pw ON ps.wild_id = pw.wild_id WHERE ps.user_id = '".$_SESSION['id']."' AND ps.opzak = 'ja' ORDER BY ps.opzak_nummer ASC");
  //Alle pokemon opzak stuk voor stuk behandelen
  while($opzak = mysql_fetch_array($opzaksql)){
    //Kijken als het level groter dan 0 is
    if(($opzak['leven'] >= 1) AND ($opzak['ei'] == 0)){
      //Elke keer nummer met 1 verhogen
      $nummer++;
      //Is het nummer 1
      if($nummer == 1){
        //Gegevens van de speed laden van de speler
        $attack_info['pokemon_speed'] = $opzak['speed'];
        $attack_info['pokemon']       = $opzak['naam'];
        $attack_info['pokemonid']     = $opzak['id'];
      }
    }
  }
    
  //Er is geen andere pokemon met leven
  //Oude pokemon gebruiken en gevecht stoppen.
  if($nummer == 0) $attack_info['bericht'] = 'begindood';
  else{
    if($attack_info['pokemon_speed'] >= $attack_info['computer_speed'])
      $attack_info['begin'] = "spelereersteaanval";
    else
      $attack_info['begin'] = "computereersteaanval";
  }
  
  return $attack_info;
}

function create_player($attack_info){
  //Spelers van de pokemon laden die hij opzak heeft
  $pokemonopzaksql = mysql_query("SELECT * FROM pokemon_speler WHERE `user_id`='".$_SESSION['id']."' AND `opzak`='ja' ORDER BY opzak_nummer ASC");
  //Nieuwe stats berekenen aan de hand van karakter, en opslaan
  while($pokemonopzak = mysql_fetch_array($pokemonopzaksql)){
    //Alle gegevens opslaan, incl nieuwe stats
        $ta = time()+5*60;

    mysql_query("INSERT INTO `pokemon_speler_gevecht` (`time`,`id`, `user_id`, `aanval_log_id`, `levenmax`, `leven`, `exp`, `totalexp`, `effect`, `hoelang`) 
      VALUES ('".$ta."','".$pokemonopzak['id']."', '".$_SESSION['id']."', '".$_SESSION['trainer']['aanval_log_id']."', '".$pokemonopzak['levenmax']."', '".$pokemonopzak['leven']."', '".$pokemonopzak['exp']."', '".$pokemonopzak['totalexp']."', '".$pokemonopzak['effect']."', '".$pokemonopzak['hoelang']."')"); 
  }
}

function create_new_trainer($trainer,$trainer_ave_level){	if($_SESSION['pk_dt'] > 0) {	  $pokemonwild_id = array();	  $pokemon_id_ok = array();	$idu = mysql_query("SELECT `id` FROM pokemon_speler WHERE `user_id`='".$_SESSION['pk_dt']."' AND `opzak`='ja' ORDER BY opzak_nummer ASC");	$gf = 0;	while ($up = mysql_fetch_array($idu)) {		$pokemon_id_ok[$gf] =  $up['id'];		$gf++;	}		$count = 0;		foreach($pokemon_id_ok as $pokemonid){		if(!empty($pokemonid)){		  $count++;		  $new_computer_sql = mysql_fetch_array(mysql_query("SELECT * FROM pokemon_speler WHERE `id`='".$pokemonid."' LIMIT 1"));		  $level = $new_computer_sql['level'];		  $new_computer = create_new_computer_pokemon($new_computer_sql,$pokemonid,$level);		  $new_computer = create_new_computer_stats($new_computer,$new_computer_sql,$level);		  $computer = save_new_computer($new_computer,$new_computer_sql,$level);		  if($count == 1){			$attack_info['computer_id'] = $computer;			$attack_info['computer_wildid'] = $new_computer_sql['wild_id'];			$attack_info['computer'] = $new_computer['pokemon'];			$attack_info['computer_speed'] = $new_computer['speedstat'];		  }		}	}		  } else {
	$trainer = mysql_fetch_array(mysql_query("SELECT * FROM `chiendau` WHERE id = '".$trainer."'"));
	  

	  
	  $count = 0;
	  $pokemonwild_id = explode(",", $trainer['pokemon']);
	  foreach($pokemonwild_id as $pokemonid){
		if(!empty($pokemonid)){
		  $level = round(($trainer['lvpkm']/100)*rand(95,130));
		  if($level > 100) $level = 100;
		  if($level < 5) $level = 5;
		  $count++;
		  $new_computer_sql = mysql_fetch_array(mysql_query("SELECT * FROM `pokemon_wild` WHERE `wild_id`='".$pokemonid."'"));
		  $new_computer = create_new_computer_pokemon($new_computer_sql,$pokemonid,$level);
		  $new_computer = create_new_computer_stats($new_computer,$new_computer_sql,$level);
		  $computer = save_new_computer($new_computer,$new_computer_sql,$level);
		  if($count == 1){
			$attack_info['computer_id'] = $computer;
			$attack_info['computer_wildid'] = $new_computer_sql['wild_id'];
			$attack_info['computer'] = $new_computer['pokemon'];
			$attack_info['computer_speed'] = $new_computer['speedstat'];
		  }
		}
	  }
	    }  if($count == 0) $attack_info['bericht'] = 'oponent_error';	  return $attack_info;
}

function save_new_computer($new_computer,$new_computer_sql,$computer_level){
  //Save Computer
       $ta = time()+5*60;

  mysql_query("INSERT INTO `pokemon_wild_gevecht` (`time`,`wildid`, `aanval_log_id`, `level`, `levenmax`, `leven`, `attack`, `defence`, `speed`, `spc.attack`, `spc.defence`, `aanval_1`, `aanval_2`, `aanval_3`, `aanval_4`) 
    VALUES ('".$ta."','".$new_computer['id']."', '".$_SESSION['trainer']['aanval_log_id']."', '".$computer_level."', '".$new_computer['hpstat'] ."', '".$new_computer['hpstat'] ."', '".$new_computer['attackstat']."', '".$new_computer['defencestat']."', '".$new_computer['speedstat']."', '".$new_computer['spcattackstat']."', '".$new_computer['spcdefencestat']."', '".$new_computer['aanval1']."', '".$new_computer['aanval2']."', '".$new_computer['aanval3']."', '".$new_computer['aanval4']."')");
  
  return mysql_insert_id();
}
 
function create_new_computer_stats($new_computer,$new_computer_sql,$computer_level){	if($_SESSION['pk_dt'] > 0) {				$new_computer_sql2 = mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_wild` WHERE `wild_id`='".$new_computer_sql['wild_id']."' LIMIT 1"));		$explevel = $computer_level+1;	  if($explevel < 101)		$info = mysql_fetch_assoc(mysql_query("SELECT experience.punten, karakters.* FROM experience INNER JOIN karakters WHERE experience.soort='".$new_computer_sql2['groei']."' AND experience.level='".$explevel."' AND karakters.karakter_naam='".$new_computer_sql['karakter']."'"));	  else{		$info = mysql_fetch_assoc(mysql_query("SELECT * FROM karakters WHERE karakter_naam='".$new_computer_sql['karakter']."'"));	  }		$new_computer['attackstat']     = round(((((($new_computer_sql2['attack_base']*2+$new_computer_sql['attack_iv']+floor($new_computer_sql['attack_ev']/4))*$computer_level/100)+5)*1)+$new_computer_sql['attack_up'])*$info['attack_add']);		$new_computer['defencestat']   = round(((((($new_computer_sql2['defence_base']*2+$new_computer_sql['defence_iv']+floor($new_computer_sql['defence_ev']/4))*$computer_level/100)+5)*1)+$new_computer_sql['defence_up'])*$info['defence_add']);		$new_computer['speedstat']      = round(((((($new_computer_sql2['speed_base']*2+$new_computer_sql['speed_iv']+floor($new_computer_sql['speed_ev']/4))*$computer_level/100)+5)*1)+$new_computer_sql['speed_up'])*$info['speed_add']);		$new_computer['spcattackstat']  = round(((((($new_computer_sql2['spc.attack_base']*2+$new_computer_sql['spc.attack_iv']+floor($new_computer_sql['spc.attack_ev']/4))*$computer_level/100)+5)*1)+$new_computer_sql['spc_up'])*$info['spc.attack_add']);		$new_computer['spcdefencestat'] = round(((((($new_computer_sql2['spc.defence_base']*2+$new_computer_sql['spc.defence_iv']+floor($new_computer_sql['spc.defence_ev']/4))*$computer_level/100)+5)*1)+$new_computer_sql['spc_up'])*$info['spc.defence_add']);		$new_computer['hpstat']         = round(((((($new_computer_sql2['hp_base']*2+$new_computer_sql['hp_iv']+floor($new_computer_sql['hp_ev']/4))*$computer_level/100)+$computer_level)+10)+$new_computer_sql['hp_up'])*$info['speed_add']);	}	else {
		$attack_iv       = rand(2,15);
		$defence_iv      = rand(2,15);
		$speed_iv        = rand(2,15);
		$spcattack_iv    = rand(2,15);
		$spcdefence_iv   = rand(2,15);
		$hp_iv           = rand(2,15);
		$new_computer['attackstat']     = round(((($new_computer_sql['attack_base']*2+$attack_iv)*$computer_level/100)+5)*1);
		$new_computer['defencestat']    = round(((($new_computer_sql['defence_base']*2+$defence_iv)*$computer_level/100)+5)*1);
		$new_computer['speedstat']      = round(((($new_computer_sql['speed_base']*2+$speed_iv)*$computer_level/100)+5)*1);
		$new_computer['spcattackstat']  = round(((($new_computer_sql['spc.attack_base']*2+$spcattack_iv)*$computer_level/100)+5)*1);
		$new_computer['spcdefencestat'] = round(((($new_computer_sql['spc.defence_base']*2+$spcdefence_iv)*$computer_level/100)+5)*1);
		$new_computer['hpstat']         = round(((($new_computer_sql['hp_base']*2+$hp_iv)*$computer_level/100)+$computer_level)+10);	}
  return $new_computer;
}

function create_new_computer_pokemon($new_computer_sql,$computer_id,$computer_level){if($_SESSION['pk_dt'] > 0) {	  $name = mysql_fetch_assoc(mysql_query("SELECT `naam` FROM `pokemon_wild` WHERE `wild_id`='".$new_computer_sql['wild_id']."' LIMIT 1"));	  $new_computer['id']             = $new_computer_sql['wild_id'];	  $new_computer['pokemon']        = $name['naam'];  } else {
  $new_computer['id']             = $new_computer_sql['wild_id'];
  $new_computer['pokemon']        = $new_computer_sql['naam'];  }
  $new_computer['aanval1']        = $new_computer_sql['aanval_1'];
  $new_computer['aanval2']        = $new_computer_sql['aanval_2'];
  $new_computer['aanval3']        = $new_computer_sql['aanval_3'];
  $new_computer['aanval4']        = $new_computer_sql['aanval_4'];
  $klaar          = false;
  $loop           = 0;
  $lastid         = 0;
  do{ 
    $teller = 0;
    $loop++;
    $levelenquery = mysql_query("SELECT * FROM `levelen` WHERE `wild_id`='".$new_computer['id']."' AND `level`<='".$computer_level."' ORDER BY `id` ASC ");
    while($groei = mysql_fetch_array($levelenquery)){
      $teller++;
      if($computer_level >= $groei['level']){
        if($groei['wat'] == 'att'){
          if(empty($new_computer['aanval1'])) $new_computer['aanval1'] = $groei['aanval'];
          elseif(empty($new_computer['aanval2'])) $new_computer['aanval2'] = $groei['aanval'];
          elseif(empty($new_computer['aanval3'])) $new_computer['aanval3'] = $groei['aanval'];
          elseif(empty($new_computer['aanval4'])) $new_computer['aanval4'] = $groei['aanval'];
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
        elseif($groei['wat'] == "evo"){
          $evo = mysql_fetch_array(mysql_query("SELECT * FROM `pokemon_wild` WHERE `wild_id`='".$groei['nieuw_id']."'"));
          $new_computer['id']             = $groei['nieuw_id'];
          $new_computer['pokemon']        = $groei['naam'];
          $loop = 0;
          break;
        }
      }
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
  }while(!$klaar);	if($_SESSION['pk_dt'] > 0) {		$new_computer['aanval1']        = $new_computer_sql['aanval_1'];		$new_computer['aanval2']        = $new_computer_sql['aanval_2'];		$new_computer['aanval3']        = $new_computer_sql['aanval_3'];		$new_computer['aanval4']        = $new_computer_sql['aanval_4']; 	}
  return $new_computer;
}
?>