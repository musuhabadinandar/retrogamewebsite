<?
//Every information is send
if((isset($_GET['opzak_nummer'])) && (isset($_GET['computer_info_name'])) && (isset($_GET['aanval_log_id'])) && (isset($_GET['sid']))){ 
  //Session On
  session_start();
  //Connect With Database
  include_once('../templates/config.php');
include_once('../templates/ducnghia.php');
  //Include Game Functions
  //Include Attack Functions
  include("attack.inc.php");
  //Include Attack lang
  $page = 'attack/wild/wild-attack';
	//Goeie taal erbij laden voor de page
	include('../language/language-pages.php');
  //Load Attack Info
  $_GET['opzak_nummer'] = mysql_real_escape_string($_GET['opzak_nummer']);
  $_GET['computer_info_name'] = mysql_real_escape_string($_GET['computer_info_name']);
  $_GET['sid'] = mysql_real_escape_string($_GET['sid']);
  $_GET['aanval_log_id'] = mysql_real_escape_string($_GET['aanval_log_id']);
  $aanval_log = aanval_log($_GET['aanval_log_id']);
  //Check if the right aanval_log is choosen
  if($aanval_log['user_id'] != $_SESSION['id']) exit;
  //Load Computer Info
  $computer_info = computer_data($aanval_log['tegenstanderid']);
  $computer_info['naam_goed'] = computer_naam($computer_info['naam']);
  //Good is zero -> change pokemon is failed
  $good = 0;
  //Refresh?
  $refresh = 0;
  //Load New Pokemon Data
  $change_pokemon = mysql_fetch_array(mysql_query("SELECT pokemon_wild.*, pokemon_speler.*, pokemon_speler_gevecht.* FROM pokemon_wild INNER JOIN pokemon_speler ON pokemon_speler.wild_id = pokemon_wild.wild_id INNER JOIN pokemon_speler_gevecht ON pokemon_speler.id = pokemon_speler_gevecht.id  WHERE pokemon_speler.user_id='".$_SESSION['id']."' AND pokemon_speler.opzak='ja' AND pokemon_speler.opzak_nummer='".$_GET['opzak_nummer']."'"));
  //Does The Pokemon excist
  if($change_pokemon['id'] != ""){
    //Are you hit by block and you're pokemon still alive.
    if(($change_pokemon['leven'] > 0) AND ($aanval_log['effect_speler'] == "Block")) $message = $txt['change_block'];
    //Is the new pokemon an egg
    elseif($change_pokemon['ei'] == 1) $message = $txt['change_egg'];
    //Is the new pokemon alive
    elseif($change_pokemon['leven'] == 0) $message = $txt['new_pokemon_dead_1'].$change_pokemon['naam'].$txt['now_pokemon_dead_2'];
    //You've caught the computer
    elseif($aanval_log['laatste_aanval'] == "gevongen") $message = $txt['success_catched_1'].$computer_info['naam_goed'].$txt['success_catched_2'];
    //The fight is ended
    elseif($aanval_log['laatste_aanval'] == "klaar") $message = $taal['attack']['general']['dead_1'].$computer_info['naam_goed'].$taal['attack']['general']['dead_2'];
    //Check if it is not your turn
    elseif($aanval_log['laatste_aanval'] == "pokemon"){
      $message = $computer_info['naam_goed'].$txt['not_your_turn'];
      //Refresh?
      $refresh = 1;
    }
    //Check if you can do something
    elseif(($aanval_log['laatste_aanval'] == "computer") OR ($aanval_log['laatste_aanval'] == "wissel") OR ($aanval_log['laatste_aanval'] == "speler_wissel") OR ($aanval_log['laatste_aanval'] == "spelereersteaanval")){
      //Change Pokemon Was A Succes
      $good = 1;
      //Check Who can begin
      if($computer_info['speed'] > $change_pokemon['speed']){
        $message = $txt['success_change_1']." ".$computer_info['naam_goed']." ".$txt['success_change_2'];
        $lastmove = "pokemon";
        //Pagina has to make refresh
        $refresh = 1;
      }
      else{
        $message = $txt['success_change_you_attack'];
        $lastmove = "computer";
      }
      //Check if New pokemon is used before
      $used_id = explode(",", $aanval_log['gebruikt_id']);
      if(in_array($change_pokemon['id'], $used_id)) $gebruiktid = $aanval_log['gebruikt_id'];
      //New pokemon is not used before
      else $gebruiktid = $aanval_log['gebruikt_id'].",".$change_pokemon['id'].",";
      //Save last move
      mysql_query("UPDATE `aanval_log` SET `laatste_aanval`='".$lastmove."' ,`aanval_bezig_speler`='', `pokemonid`='".$change_pokemon['id']."', `gebruikt_id`='".$gebruiktid."' WHERE `id`='".$aanval_log['id']."'");
      
       $skill1 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$change_pokemon['aanval_1']."'"));
  		    $skill2 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$change_pokemon['aanval_2']."'"));
  			    $skill3 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$change_pokemon['aanval_3']."'"));
  			     $skill4 =  mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval` WHERE `naam` = '" .$change_pokemon['aanval_4']."'"));
    }
    //You can't do something
    else $message = $computer_info['naam_goed'].$taal['attack']['general']['lastattack'];
  }
  else $message = "Error: 1001";
  //Bericht, Goed/Fout, 
  		  


  echo $message." | ".$good." | ".$refresh." | ".$change_pokemon['naam']." | ".$change_pokemon['level']." | ".$change_pokemon['aanval_1']." | ".$change_pokemon['aanval_2']." | ".$change_pokemon['aanval_3']." | ".$change_pokemon['aanval_4']." | ".$_GET['opzak_nummer']." | ".$change_pokemon['leven']." | ".$change_pokemon['levenmax']." | ".$change_pokemon['exp']." | ".$change_pokemon['expnodig']." | ".$change_pokemon['shiny']." | ".$change_pokemon['wild_id']." | ".$skill1['soort']." | ".$skill2['soort']." | ".$skill3['soort']." | ".$skill4['soort'];
}

 
?>