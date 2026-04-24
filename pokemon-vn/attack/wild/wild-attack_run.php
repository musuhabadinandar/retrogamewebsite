<?
//Every information is send
if((isset($_GET['computer_info_name'])) && (isset($_GET['aanval_log_id'])) && (isset($_GET['sid']))){
  //Session On
  session_start();
  //Connect With Database
    include_once('../../templates/config.php'); 
include_once('../../templates/ducnghia.php'); 

  //Include Attack Functions
  include("../../attack/attack.inc.php");
  $page = 'attack/wild/wild-attack';
  //Goeie taal erbij laden voor de page
  include_once('../../language/language-pages.php');
  //Load Attack Info
  $aanval_log = aanval_log($_GET['aanval_log_id']);
  //Check if the right aanval_log is choosen
  if($aanval_log['user_id'] != $_SESSION['id']) exit;
  //Load Pokemon info
  $pokemon_info = pokemon_data($aanval_log['pokemonid']);
  //Check if the right pokemon is choosen
  if($pokemon_info['user_id'] != $_SESSION['id']) exit;
  //Run default Failed
  $good = 0;
  //Load Pokemon info
  $computer_info = computer_data($aanval_log['tegenstanderid']);
  //Create Right name for computer
  $computer_info['naam_goed'] = computer_naam($computer_info['naam']);
  //Check if you have already caught the computer
  if($aanval_log['laatste_aanval'] == "gevongen") $message = $txt['success_catched_1'].$computer_info['naam_goed'] .$txt['success_catched_2'];
  //Check if the fight is finished yet
  elseif($aanval_log['laatste_aanval'] == "klaar") $message = $txt['new_pokemon_dead_1'].$computer_info['naam_goed'] .$txt['new_pokemon_dead_2'];
  //Check if it is not your turn
  elseif($aanval_log['laatste_aanval'] == "pokemon") $message = $computer_info['naam_goed'] .$taal['attack']['general']['lastattack'];
  //Alle Checks done, Try catching the pokemon
  else{
    //If Computer has more life dan pokemon, 20% change to escape
    //Else 80%
    if($_GET['pokemon_leven'] > $_GET['computer_leven']) $change = 80;
    else $change = 20;
    //Get numbers from 1 to 100
    $rand = rand(1,100);
    //Pokemon made it
    if($change > $rand){
      //Run succeed
      $good = 1;
      //Player is higher than rank 4
      //Decrease Rank
      if($gegeven['rank'] >= 4) rankeraf('attack_run');
  
      $message = $txt['success_run'].$computer_info['naam_goed'] ;
      
      //Copy Life en Effect Stats to pokemon_speler table
      $player_hand_query = mysql_query("SELECT `id`, `leven`, `effect` FROM `pokemon_speler_gevecht` WHERE `user_id`='".$_SESSION['id']."'");
      while($player_hand = mysql_fetch_array($player_hand_query)){
        mysql_query("UPDATE `pokemon_speler` SET `leven`='".$player_hand['leven']."', `effect`='".$player_hand['effect']."' WHERE `id`='".$player_hand['id']."'");
      }
      //Remove attack 
      remove_attack($aanval_log['id'],$aanval_log['tegenstanderid']);
    }
    else{
      $message = $txt['failure_run'].$computer_info['naam_goed'] ;
      mysql_query("UPDATE `aanval_log` SET `laatste_aanval`='pokemon', `beurten`=`beurten`+'1' WHERE `id`='".$aanval_log['id']."'");  
    }
  }
  //Send Information Back
  echo $message." | ".$good;
}
?>