<?
function create_new_attack($computer_id,$computer_level,$gebied,$ai){

  //Delete last attack logs
  mysql_query("DELETE FROM `aanval_log` WHERE `user_id`='".$_SESSION['id']."'");
  mysql_query("DELETE FROM `pokemon_speler_gevecht` WHERE `user_id`='".$_SESSION['id']."'");


  //Create Attack log
  create_aanval_log($gebied);

  //First we create new computer
  $attack_info = create_new_computer($computer_id,$computer_level,$ai);
  
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
  }
  //There Are no living pokemon.
  else{
    //Clear Computer
    mysql_query("DELETE FROM `pokemon_wild_gevecht` WHERE `id`='".$attack_info['computer_id']."'");
    //Clear Player
    mysql_query("DELETE FROM `pokemon_speler_gevecht` WHERE `user_id`='".$_SESSION['id']."'");
  }
  
  return $attack_info;
}

function create_aanval_log($gebied){
  mysql_query("INSERT INTO `aanval_log` (`user_id`, `gebied`)
    VALUES ('".$_SESSION['id']."', '".$gebied."')");
    
  $_SESSION['attack']['aanval_log_id'] = mysql_insert_id();
}

function save_attack($attack_info){
  $gebruikt = ','.$attack_info['pokemonid'].',';
  
  //UPDATE Query
  mysql_query("UPDATE `aanval_log` SET `laatste_aanval`='".$attack_info['begin']."', `tegenstanderid`='".$attack_info['computer_id']."', `pokemonid`='".$attack_info['pokemonid']."', `gebruikt_id`='".$gebruikt."' WHERE `id`='".$_SESSION['attack']['aanval_log_id']."'");
  
  //Save Player Page Status   
}

function who_can_start($attack_info){
  //Kijken wie de meeste speed heeft, die mag dus beginnen.
  //Speed stat tegenstander -> $speedstat
  //Pokemons laden die de speler opzak heeft
  $nummer = 0;
  $opzaksql = mysql_query("SELECT pokemon_speler.id, pokemon_speler.opzak_nummer, pokemon_speler.leven, pokemon_speler.speed, pokemon_speler.ei, pokemon_wild.naam FROM pokemon_speler INNER JOIN pokemon_wild ON pokemon_speler.wild_id = pokemon_wild.wild_id WHERE `user_id`='".$_SESSION['id']."' AND `opzak`='ja' ORDER BY `opzak_nummer` ASC");
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
      VALUES ('".$ta."','".$pokemonopzak['id']."', '".$_SESSION['id']."', '".$_SESSION['attack']['aanval_log_id']."', '".$pokemonopzak['levenmax']."', '".$pokemonopzak['leven']."', '".$pokemonopzak['exp']."', '".$pokemonopzak['totalexp']."', '".$pokemonopzak['effect']."', '".$pokemonopzak['hoelang']."')"); 
  }
}

function create_new_computer($computer_id,$computer_level,$ai){
  //Load pokemon basis
  $new_computer_sql = mysql_fetch_array(mysql_query("SELECT * FROM `pokemon_wild` WHERE `wild_id`='".$computer_id."'"));
  
  //We create new computer pokemon
  $new_computer = create_new_computer_pokemon($new_computer_sql,$computer_id,$computer_level);
  
  //We create new stats for computer
  $new_computer = create_new_computer_stats($new_computer,$new_computer_sql,$computer_level,$ai);
  
  //Save Computer
  $computer = save_new_computer($new_computer,$new_computer_sql,$computer_level);
  
  return $computer;
}

function save_new_computer($new_computer,$new_computer_sql,$computer_level){
  //Computer Shiny?
  $randshiny = rand(1,200);
  if($randshiny == 150) $shiny = 1;
  else $shiny = 0;
     $ta = time()+5*60;

  //Save Computer
  mysql_query("INSERT INTO `pokemon_wild_gevecht` (`boss`,`time`,`wildid`, `aanval_log_id`, `shiny`, `level`, `levenmax`, `leven`, `attack`, `defence`, `speed`, `spc.attack`, `spc.defence`, `aanval_1`, `aanval_2`, `aanval_3`, `aanval_4`, `effect`) 
    VALUES ('999','".$ta."','".$new_computer['id']."', '".$_SESSION['attack']['aanval_log_id']."', '".$shiny."', '".$computer_level."', '".$new_computer['hpstat'] ."', '".$new_computer['hpstat'] ."', '".$new_computer['attackstat']."', '".$new_computer['defencestat']."', '".$new_computer['speedstat']."', '".$new_computer['spcattackstat']."', '".$new_computer['spcdefencestat']."', '".$new_computer['aanval1']."', '".$new_computer['aanval2']."', '".$new_computer['aanval3']."', '".$new_computer['aanval4']."', '".$new_computer_sql['effect']."')");
  
  //Get Computer Id
  $attack_info['computer_id'] = mysql_insert_id();
  $attack_info['computer_wildid'] = $new_computer['id'];
  $attack_info['computer_speed'] = $new_computer['speedstat'];
  
  return $attack_info;
}

function create_new_computer_stats($new_computer,$new_computer_sql,$computer_level,$ai){
  //Iv willekeurig getal tussen 2,15
  //Normaal tussen 1,31 maar wilde pokemon moet wat minder sterk zijn
  $attack_iv       = rand(2,15);
  $defence_iv      = rand(2,15);
  $speed_iv        = rand(2,15);
  $spcattack_iv    = rand(2,15);
  $spcdefence_iv   = rand(2,15);
  $hp_iv           = rand(2,15);

if($ai<=4) {
    $att = 5+$ai*10;
        $hp = 50+$ai*10;
$df = 50+$ai*3;
$sp = 150;
}

if($ai==5) {
    $att = 100;
        $hp = 500*5;
$df = 50*3;
$sp = 150;
}

if($ai>=6 AND $ai <=9) {
    $att = 6+$ai*10;
        $hp = 70+$ai*10;
$df = 80+$ai*3;
$sp = 150;
}

if($ai==10) {
    $att = 50;
        $hp = 600*5;
$df = 250*3;
$sp = 150;
}
if($ai>=11 AND $ai <=14) {
    $att = 7+$ai*10;
        $hp = 90+$ai*10;
$df = 180+$ai*3;
$sp = 150;
}

if($ai==15) {
    $att = 70;
        $hp = 700*5;
$df = 350*3;
$sp = 150;
}

if($ai>=16 AND $ai <=19) {
    $att = 7+$ai*10;
        $hp = 190+$ai*10;
$df = 180+$ai*3;
$sp = 150;
}

if($ai==20) {
    $att = 70;
        $hp = 800*5;
$df = 450*3;
$sp = 150;
}


  //Stats berekenen
  $new_computer['attackstat']     = round(((($new_computer_sql['attack_base']*2+$attack_iv)*$computer_level/100)+5)+$att);
  $new_computer['defencestat']    = round(((($new_computer_sql['defence_base']*2+$defence_iv)*$computer_level/100)+5)+$df);
  $new_computer['speedstat']      = round(((($new_computer_sql['speed_base']*2+$speed_iv)*$computer_level/100)+5)+$sp);
  $new_computer['spcattackstat']  = round(((($new_computer_sql['spc.attack_base']*2+$spcattack_iv)*$computer_level/100)+5)*1);
  $new_computer['spcdefencestat'] = round(((($new_computer_sql['spc.defence_base']*2+$spcdefence_iv)*$computer_level/100)+5)*1);
  $new_computer['hpstat']         = round(((($new_computer_sql['hp_base']*2+$hp_iv)*$computer_level/100)+$computer_level)+$hp);
  return $new_computer;
}

function create_new_computer_pokemon($new_computer_sql,$computer_id,$computer_level){
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
    $levelenquery = mysql_query("SELECT * FROM `levelen` WHERE `wild_id`='".$new_computer['id']."' AND `level`<='".$computer_level."' ORDER BY `id` ASC ");
    //Voor elke pokemon alle gegeven behandelen
    while($groei = mysql_fetch_array($levelenquery)){
      //Teller met 1 verhogen
      $teller++;
      //Is het nog binnen de level?
      if($computer_level >= $groei['level']){
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
          $evo = mysql_fetch_array(mysql_query("SELECT * FROM `pokemon_wild` WHERE `wild_id`='".$groei['nieuw_id']."'"));
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
  }while(!$klaar);
  return $new_computer;
}
?>