<?PHP

////ngân hàng
if(isset($_POST['pk'])){
    $name = htmlspecialchars(addslashes($_POST['username'])); 

		$user_id_pk = $_POST['username'];
	
			$pkm = mysql_query("SELECT * FROM `pokemon_speler` WHERE `opzak`='ja' AND `user_id`='".$user_id_pk."'");
			if(mysql_num_rows($pkm)>0) {
					include('../attack/trainer/trainer-start.php');
					$_SESSION['pk_dt'] = $user_id_pk;
					$info = create_new_trainer_attack('pk',$trainer_ave_level,$gebied);
			}
			
} 


if(isset($_POST['gym'])){

$ducnghia_vh_Trainer = mysql_fetch_assoc(mysql_query("SELECT `naam` FROM `trainer` WHERE id='".$_GET[id]."'"));
        include('../attack/trainer/trainer-start.php');
        mysql_data_seek($pokemon_sql, 0);
        $opzak = mysql_num_rows($pokemon_sql);
        $level = 0;
        while($pokemon = mysql_fetch_assoc($pokemon_sql)){ $level += $pokemon['level']; }
        $trainer_ave_level = $level/$opzak;
        $lv = $_POST[lv];
        //Make Fight
        create_new_trainer_attack($ducnghia_vh_Trainer['naam'],$trainer_ave_level,$gebied);

$ducnghiaJSON[ducnghia] = $ducnghia_vh_Trainer[naam];

 echo json_encode($ducnghiaJSON);
die;
} 


if(isset($_POST['trainer'])){

$v = mysql_fetch_assoc(mysql_query("SELECT * FROM `chiendau` WHERE `id` = '".$_POST[id]."'"));

if($v[level] > $datauser->level) {
    $a[code] = 0;
    $a[msg] = 'Bạn phải đạt trình độ cấp '.$v[level].' để có thể khiêu chiến với người này. ';
} else {
        include('../attack/trainer/trainer-start.php');
        mysql_data_seek($pokemon_sql, 0);
        $opzak = mysql_num_rows($pokemon_sql);
        $level = 0;
        while($pokemon = mysql_fetch_assoc($pokemon_sql)){ $level += $pokemon['level']; }
        $trainer_ave_level = $level/$opzak;
        $lv = $_POST[lv];
        //Make Fight
        create_new_trainer_attack($v['id'],5,$gebied);
        $a[code]=1;
}



 echo json_encode($a);
die;
} 





if(isset($_POST['wild'])){
     $ktra = mysql_fetch_assoc(mysql_query("SELECT `id` FROM `aanval_log` WHERE `user_id`='".$_SESSION['id']."'"));
if($ktra[id] !=0 ) {
    
} else {
    	$wid = $datauser->ducnghia_pokemon;
        $leveltegenstander = $datauser->ducnghia_level;

     		$ducnghia_xem = mysql_fetch_assoc(mysql_query("SELECT * FROM pokemon_wild WHERE `wild_id`='$wid' AND evolutie = '1'"));
        include("../attack/wild/wild-start.php");
        create_new_attack($wid,$leveltegenstander,$gebied);
                    mysql_query("UPDATE `users` SET `ducnghia_pokemon` = '0' , `ducnghia_level` = '0' WHERE `id`='".$_SESSION['id']."'");
}
$ducnghiaJSON[ducnghia] = $msg;

 echo json_encode($ducnghiaJSON);
die;
} 





if(isset($_POST['hp'])){
    if($datauser['silver'] < 40) {
        $msg = 'Anh không đủ 40 bạc';
    } else {
    mysql_query("UPDATE `gebruikers` SET  `silver` = `silver` - '40'  WHERE `user_id`='".$_SESSION['id']."'");
    mysql_query("UPDATE `pokemon_speler` SET `leven`=`levenmax` WHERE `user_id`='" .$datauser->id."' AND `opzak_nummer` = '1'");mysql_query("UPDATE `pokemon_speler` SET `leven`=`levenmax` WHERE `user_id`='" .$datauser->id."' AND `opzak_nummer` = '2'");mysql_query("UPDATE `pokemon_speler` SET `leven`=`levenmax` WHERE `user_id`='" .$datauser->id."' AND `opzak_nummer` = '3'");mysql_query("UPDATE `pokemon_speler` SET `leven`=`levenmax` WHERE `user_id`='" .$datauser->id."' AND `opzak_nummer` = '4'"); mysql_query("UPDATE `pokemon_speler` SET `leven`=`levenmax` WHERE `user_id`='" .$datauser->id."' AND `opzak_nummer` = '5'");mysql_query("UPDATE `pokemon_speler` SET `leven`=`levenmax` WHERE `user_id`='" .$datauser->id."' AND `opzak_nummer` = '6'");
 $msg = 'Toàn bộ pokemon , của anh đã được hồi phục.';
}
$ducnghiaJSON[ducnghia] = $msg;

 echo json_encode($ducnghiaJSON);
die;
} 


//rut



if(isset($_POST['skill'])){
     $link = base64_decode($_SESSION['aanvalnieuw']);
		  #Code splitten, zodat informatie duidelijk word
		  list ($nieuweaanval['pokemonid'], $nieuweaanval['aanvalnaam']) = split ('[/]', $link);
     $pokemoninfo  = mysql_fetch_assoc(mysql_query("SELECT pokemon_wild.wild_id, pokemon_wild.naam, pokemon_speler.id, pokemon_speler.aanval_1, pokemon_speler.aanval_2, pokemon_speler.aanval_3, pokemon_speler.aanval_4 FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_wild.wild_id = pokemon_speler.wild_id WHERE `id`='".$nieuweaanval['pokemonid']."'"));
          $finish = False;
    $id = $_POST[id];
 
 
 if($id ==5) {
                 $finish = true;

 }
 if($id <5 and $id >=1) {
     mysql_query("UPDATE `pokemon_speler` SET `aanval_$id`='".$nieuweaanval['aanvalnaam']."' WHERE `id`='".$nieuweaanval['pokemonid']."'");
            $pokemoninfo['aanval_'.$id.''] = $nieuweaanval['aanvalnaam'];
            $finish = true; 
 }
 
  if($finish){
            $current = array_pop($_SESSION['used']);      

            $count = 0;
            $sql = mysql_query("SELECT pokemon_wild.naam, pokemon_speler.id, pokemon_speler.wild_id, pokemon_speler.roepnaam, pokemon_speler.level, pokemon_speler.trade, pokemon_speler.expnodig, pokemon_speler.exp FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_wild.wild_id = pokemon_speler.wild_id WHERE pokemon_speler.id='".$current."'");
            while($select = mysql_fetch_assoc($sql)){
              #Change name for male and female
              $select['naam_goed'] = pokemon_naam($select['naam'],$select['roepnaam']);
              if($select['level'] < 100){
                #Gegevens laden van pokemon die leven groeit uit levelen tabel
                $levelensql = mysql_query("SELECT `id`, `level`, `trade`, `wild_id`, `wat`, `nieuw_id`, `aanval` FROM `levelen` WHERE `wild_id`='".$select['wild_id']."' AND `level`>'".$_SESSION['lvl_old']."' AND `level`<='".$select['level']."' AND aanval!='".$nieuweaanval['aanvalnaam']."' ORDER BY id ASC");
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
                    #Is het level groter of gelijk aan de level die benodigd is? Naar andere pagina gaan
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
            if($count == 0) unset($_SESSION['aanvalnieuw']);  
          }

$ducnghiaJSON[ducnghia] = $msg;

 echo json_encode($ducnghiaJSON);
die;
} 
//rut



if(isset($_POST['tienhoa'])){
     
    $id = $_POST[id];
 $link = base64_decode($_SESSION['evolueren']);
		  #Code splitten, zodat informatie duidelijk word
		  list ($evolueren['pokemonid'], $evolueren['nieuw_id']) = split ('[/]', $link);
		  $pokemon = mysql_fetch_assoc(mysql_query("SELECT pokemon_wild.wild_id, pokemon_wild.naam, pokemon_wild.groei, pokemon_speler.* FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_wild.wild_id = pokemon_speler.wild_id WHERE pokemon_speler.id='".$evolueren['pokemonid']."'"));

$update = mysql_fetch_assoc(mysql_query("SELECT * FROM `pokemon_wild` WHERE `wild_id`='".$evolueren['nieuw_id']."'"));
 if($id ==1) {
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
  
	#Event taal pack includen

	$event = '<img src="images/icons/blue.png" width="16" height="16" class="imglower" /> '.$pokemon['naam'].' '.$txt['event_is_evolved_in'].' '.$update['naam'].'.';
	
	#Melding geven aan de uitdager
	mysql_query("INSERT INTO gebeurtenis (id, datum, ontvanger_id, bericht, gelezen)
	VALUES (NULL, '".$date."', '".$_SESSION['id']."', '".$event."', '0')");
     
 } if($id==2) {
   $tekst = "<div class='blue'>".$pokemon['naam']." da tien hoa</div>";
  $button = False;
#Checken als meer pokemon moet evolueren
  $current = array_pop($_SESSION['used']);      
  
  $count = 0;
  $sql = mysql_query("SELECT pokemon_wild.naam, pokemon_speler.id, pokemon_speler.wild_id, pokemon_speler.roepnaam, pokemon_speler.level, pokemon_speler.trade, pokemon_speler.expnodig, pokemon_speler.exp FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_wild.wild_id = pokemon_speler.wild_id WHERE pokemon_speler.id='".$current."'");
  while($select = mysql_fetch_assoc($sql)){
    #Change name for male and female
    $select['naam_goed'] = pokemon_naam($select['naam'],$select['roepnaam']);
    if($select['level'] < 101){
      #Gegevens laden van pokemon die leven groeit uit levelen tabel
      $levelensql = mysql_query("SELECT `id`, `level`, `trade`, `wild_id`, `wat`, `nieuw_id`, `aanval` FROM `levelen` WHERE `wild_id`='".$select['wild_id']."' AND `level`>'".$_SESSION['lvl_old']."' ORDER BY id ASC");
      #Voor elke actie kijken als het klopt.
      while($levelen = mysql_fetch_assoc($levelensql)){
        #als de actie een aanval leren is
        if($levelen['wat'] == "att"){
          #Kent de pokemon deze aanval al
          if(($select['aanval_1'] != $levelen['aanval']) AND ($select['aanval_2'] != $levelen['aanval']) AND ($select['aanval_3'] != $levelen['aanval']) AND ($select['aanval_4'] != $levelen['aanval'])){
            unset($_SESSION['evolueren']);
            $_SESSION['aanvalnieuw'] = base64_encode($select['id']."/".$levelen['aanval']);
            $count++;
            $_SESSION['lvl_old'] = $levelen['level'];
            array_push($_SESSION['used'], $select['id']);
            break;
          }
        }
        #Does the pokemon evolve
        elseif($levelen['wat'] == "evo"){
          #The level is greater than or equal to the level that is required? To another page
          if(($levelen['level'] <= $select['level']) OR (($levelen['trade'] == 1) AND ($select['trade'] == "1.5"))){
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
 
 

$ducnghiaJSON[ducnghia] = $msg;

 echo json_encode($ducnghiaJSON);
die;
} 
//rut
