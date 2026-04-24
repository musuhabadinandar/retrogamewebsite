<? //Is all the information send
if( (isset($_GET['aanval_log_id'])) && (isset($_GET['sid']))){
  //Session On
  session_start();
  //Connect With Database
  include_once('../../templates/config.php'); 
include_once('../../templates/ducnghia.php'); 

  //Include Attack Functions
  include("../attack.inc.php"); 
  //Goeie taal erbij laden voor de page
  include_once('../../language/language-general.php');
  //Load Data
  $aanval_log = aanval_log($_GET['aanval_log_id']);
  //Load User Information
  //Load computer info
  $computer_info = computer_data($aanval_log['tegenstanderid']);
  //Test if fight is over
  if($aanval_log['laatste_aanval'] == "end_screen"){
		if($computer_info['leven'] == 0){
      rankerbij('attack',$txt);  
      //Update User
      ///sukien
      
      
                  $ducnghia_tile = mysql_fetch_assoc(mysql_query("SELECT * FROM `ducnghia` WHERE `user_id`='".$_SESSION['id']."'"));
                  $ducnghia_tilex = mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval_log` WHERE `id`='".$_GET['aanval_log_id']."'"));

           
          mysql_query("UPDATE `ducnghia_vuotai` SET `pokemon`=`pokemon`-'1' WHERE `user_id`='".$_SESSION['id']."'"); 

      

      $ducnghia = rand(1,5);
     
          mysql_query("UPDATE `users` SET `thang`=`thang`+'1' WHERE `user_id`='".$_SESSION['id']."'"); 
          
      
      
             	
           $bac_xh = (rand(5,50))*10;
           $exp_new = (rand(50,100))*2+(300*$datauser->level);
          mysql_query("UPDATE `users` SET `xu`=`xu`+'".$bac_xh."',`exp` = `exp` + '".$exp_new."',`conghien` =`conghien` + '1' WHERE `user_id`='".$_SESSION['id']."'"); 

$user_ss = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `user_id` = '".$_SESSION['id']."'"));
function n($amount){
 return number_format(round($amount),0,",",".");                          
}



      $text = 1;
      $money = 0;
	  // Check if he won an item
	  $isIt = rand (1,90);
	  
	  
	  
    }
    else{
    
      //Update user
              mysql_query("UPDATE `users` SET `chiendau`='' WHERE `user_id`='".$_SESSION['id']."'");

       mysql_query("INSERT INTO `ducnghia_lichsu` SET `user_id` = '{$_SESSION['id']}',`id_tran` = '{$_GET['aanval_log_id']}', `loai` = 'Thám Hiểm',`trangthai` = '1', `time` = '".time()."'");
      mysql_query("UPDATE `users` SET `xu`=`xu`-'".$money."', `thua`=`thua`+'1' WHERE `user_id`='".$_SESSION['id']."'");
      $text = 0;
    }
    echo $text." | ".$money;
    //Sync pokemon
    pokemon_player_hand_update();
    //Let Pokemon grow
    pokemon_grow($txt);
    //Remove Attack
    remove_attack($_GET['aanval_log_id']);
    unset($_SESSION['attack']['aanval_log_id']);
  }
  else{

  }
}
?>