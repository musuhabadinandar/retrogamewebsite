<?php
//Is all the information send
if( (isset($_GET['aanval_log_id'])) && (isset($_GET['sid']))){
  //Session On
  //Connect With Database
   include_once('../../templates/config.php'); 
include_once('../../templates/ducnghia.php'); 

  //Include Attack Functions
  include("../attack.inc.php"); 
  $page = 'attack/trainer/trainer-attack';
	//Goeie taal erbij laden voor de page
	include_once('../../language/language-pages.php');
	include_once('../../language/language-general.php');
  //Load User Information
  $gebruiker = mysql_fetch_array(mysql_query("SELECT * FROM `users`, `gebruikers_item` WHERE ((`users`.`user_id`='".$_SESSION['id']."') AND (`gebruikers_item`.`user_id`='".$_SESSION['id']."'))"));
  if($gebruiker['itembox'] == 'bag')
    $gebruiker['item_over'] = 20-$gebruiker['items'];
  elseif($gebruiker['itembox'] == 'Yellow box')
    $gebruiker['item_over'] = 50-$gebruiker['items'];
  elseif($gebruiker['itembox'] == 'Blue box')
    $gebruiker['item_over'] = 100-$gebruiker['items'];
  elseif($gebruiker['itembox'] == 'Red box')
    $gebruiker['item_over'] = 250-$gebruiker['items'];	
  //Load Data
  $aanval_log = aanval_log($_GET['aanval_log_id']);
  //Test if fight is over
  if($aanval_log['laatste_aanval'] == "end_screen"){
    if(mysql_num_rows(mysql_query("SELECT `id` FROM pokemon_speler_gevecht WHERE `user_id`='".$_SESSION['id']."' AND `leven`>'0'")) == 0)
	{
      
       $money = 0;
      $win = 0;
      //Update user
      mysql_query("UPDATE `users` SET `xu`=`xu`-'".$money."', `thua`=`thua`+'1' WHERE `user_id`='".$_SESSION['id']."'");




             	
    }
    else
	{
      $win = 1;
      //Load Trainer Data
      $trainer = mysql_fetch_array(mysql_query("SELECT * FROM `trainer` WHERE `naam`='".$aanval_log['trainer']."'"));	
    	//HM Cut
    	if($trainer['badge'] == 'Hive')
		{
    		mysql_query("UPDATE `gebruikers_tmhm` SET `HM01`='1' WHERE `user_id`='".$_SESSION['id']."'");
    		$hm = $txt['you_also_get_hm'].' HM01 Cut.';
    	}
    	//HM Fly
    	elseif($trainer['badge'] == 'Feather')
		{
    		mysql_query("UPDATE `gebruikers_tmhm` SET `HM02`='1' WHERE `user_id`='".$_SESSION['id']."'");
    		$hm = $txt['you_also_get_hm'].' HM02 Fly.';
    	}
    	//HM Surf
    	elseif($trainer['badge'] == 'Cascade'){
    		mysql_query("UPDATE `gebruikers_tmhm` SET `HM03`='1' WHERE `user_id`='".$_SESSION['id']."'");
    		$hm = $txt['you_also_get_hm'].' HM03 Surf.';
    	}
    	//HM Strength
    	elseif($trainer['badge'] == 'Knuckle'){
    		mysql_query("UPDATE `gebruikers_tmhm` SET `HM04`='1' WHERE `user_id`='".$_SESSION['id']."'");
    		$hm = $txt['you_also_get_hm'].' HM04 Strength.';
    	}
    	//HM Flash
    	elseif($trainer['badge'] == 'Relic'){
    		mysql_query("UPDATE `gebruikers_tmhm` SET `HM05`='1' WHERE `user_id`='".$_SESSION['id']."'");
    		$hm = $txt['you_also_get_hm'].' HM05 De fog.';
    	}
    	//HM Rock Smash
    	elseif($trainer['badge'] == 'Storm'){
    		mysql_query("UPDATE `gebruikers_tmhm` SET `HM06`='1' WHERE `user_id`='".$_SESSION['id']."'");
    		$hm = $txt['you_also_get_hm'].' HM06 Rock Smash.';
    	}
    	//HM Waterfall
    	elseif($trainer['badge'] == 'Fen'){
    		mysql_query("UPDATE `gebruikers_tmhm` SET `HM07`='1' WHERE `user_id`='".$_SESSION['id']."'");
    		$hm = $txt['you_also_get_hm'].' HM07 Waterfall.';
    	}
    	//HM Dive
    	elseif($trainer['badge'] == 'Rain'){
    		mysql_query("UPDATE `gebruikers_tmhm` SET `HM08`='1' WHERE `user_id`='".$_SESSION['id']."'");
    		$hm = $txt['you_also_get_hm'].' HM08 Rock Climb.';
    	}
  	
      //Give Badge
      if(!empty($trainer['badge'])){ 
       	mysql_query("UPDATE `gebruikers_badges` SET `".$trainer['badge']."`='1' WHERE `user_id`='".$_SESSION['id']."'");
      	mysql_query("UPDATE gebruikers SET badges = badges + '1' WHERE user_id = '".$_SESSION['id']."'");
      	rankerbij('gym',$txt);
      }								
      else{
        #miss query van Gold + 1
        rankerbij('trainer',$txt);
      }
      //Give money
      
 
      $money = round($trainer['prijs']*(rand(90,110)/100));
      $ducnghia_siver = $money;
       $ducnghia = rand(1,5);
       
       if($_SESSION[leotop] >=1) {
                  $u_pk=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id`  = '".$_SESSION[leotop]."' LIMIT 1"));
 $toptoi = $datauser[top];
 $toppk = $u_pk[top];
 
                 mysql_query("UPDATE `users` SET `top`='".$toppk."' WHERE `id`='".$user_id."'");
                 mysql_query("UPDATE `users` SET `top`='".$toptoi."' WHERE `id`='".$u_pk[id]."'");
if($toppk <10) {
    tin(''.$datauser[username].' vừa lên Top #'.$toppk.' ');
}
$_SESSION[leotop] =0;

       }

    
                mysql_query("UPDATE `users` SET `xu`=`xu`+'".$ducnghia_siver."' WHERE `user_id`='".$_SESSION['id']."'");

          
                         mysql_query("INSERT INTO `ducnghia_lichsu` SET `user_id` = '{$_SESSION['id']}',`id_tran` = '{$_GET['aanval_log_id']}', `loai` = 'Huấn Luyện',`trangthai` = '0', `time` = '".time()."'");

      
      $chiendau = mysql_fetch_array(mysql_query("SELECT * FROM `chiendau` WHERE `id`='".$aanval_log['trainer']."'"));	

      	$check_nv = mysql_fetch_assoc(mysql_query("SELECT * FROM `ducnghia_data_nhiemvu` WHERE `user_id` = '$user_id' AND `loai` = 'sotai'  "));
             	
             	if($datauser->nhiemvu->loai=="sotai" AND $datauser->nhiemvu->pokemon ==$chiendau[id] AND $datauser->nhiemvu->id>=1 ){
             	            $song = $datauser->nhiemvu->song +1;
             	            $datauser->nhiemvu('song',$song);
 
             	}
             	
      
      //Maybe Give badge case
     
    }
      
    echo $trainer['badge']." | ".$money ." | ".$rarecandy." | ".$hm." | ".$win;
    //Sync pokemon
    pokemon_player_hand_update();
    //Let Pokemon grow
    pokemon_grow($txt);
    //Remove Attack
    remove_attack($_GET['aanval_log_id']);
  }
  else
  {

  }
}
?>