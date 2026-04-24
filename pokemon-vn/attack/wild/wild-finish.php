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
      $v = rand(1,10);
      if($v==1) {
          $n = rand(1,3);
          $user->setvatpham(27,$n);

          
      }
     
     
      $vpdb = rand(1,100);
      if($vpdb ==15) {
          $user->setvatpham(35,1);
          $user->setvatpham(33,1);
                                 
$thuong.=t(''.shopvatpham(35).'');
$thuong.=t(''.shopvatpham(33).'');


      }
      if($vpdb ==20) {
          $user->setvatpham(34,1);
            $user->setvatpham(35,1);
                                        
$thuong.=t(''.shopvatpham(35).'');
$thuong.=t(''.shopvatpham(34).'');

      }
      ///song
      
      
                  $ducnghia_tile = mysql_fetch_assoc(mysql_query("SELECT * FROM `ducnghia` WHERE `user_id`='".$_SESSION['id']."'"));
                  $ducnghia_tilex = mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval_log` WHERE `id`='".$_GET['aanval_log_id']."'"));

             mysql_query("INSERT INTO `ducnghia_lichsu` SET `user_id` = '{$_SESSION['id']}',`id_tran` = '{$_GET['aanval_log_id']}', `loai` = 'Thám Hiểm',`trangthai` = '0', `time` = '".time()."'");

        mysql_query("UPDATE `users` SET `chiendau`='' WHERE `user_id`='".$_SESSION['id']."'");

      

      $ducnghia = rand(1,5);
     
          mysql_query("UPDATE `users` SET `thang`=`thang`+'1' WHERE `user_id`='".$_SESSION['id']."'"); 
          
      
      

             	if($datauser->nhiemvu->loai=="pokemon" AND $datauser->nhiemvu->pokemon ==$datauser->pokemonnv AND $datauser->nhiemvu->id>=1){
             	    $song = $datauser->nhiemvu->song +1;
             	            $datauser->nhiemvu('song',$song);
 
             	}
             	
             
             	
           $bac_xh = (rand(5,50))*2+$datauser->level;
           $exp_new = (rand(50,100))*2+(300*$datauser->level);
           $tx = $datauser->nhanvat();
           $bac_xh = $bac_xh + ($bac_xh/100*$tx);
           $exp_new = $exp_new + ($exp_new/100*$tx);
           
           
          mysql_query("UPDATE `users` SET `xu`=`xu`+'".$bac_xh."',`exp` = `exp` + '".$exp_new."',`conghien` =`conghien` + '1' WHERE `user_id`='".$_SESSION['id']."'"); 
          $exp = $exp_new;
          $xu = $bac_xh;

$user_ss = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `user_id` = '".$_SESSION['id']."'"));
function n($amount){
 return number_format(round($amount),0,",",".");                          
}
if($user_ss[giatoc] >0) {
    $check_menu_gt=mysql_query("SELECT * FROM `users` WHERE `giatoc` = '$user_ss[giatoc]' AND `map_num` ='$user_ss[map_num]'  ");
        mysql_query("UPDATE `ducnghia_giatoc` SET `xu`=`xu`+'5',`exp` = `exp` + '5' WHERE `id`='".$user_ss['giatoc']."'"); 

     while($l_gt=mysql_fetch_assoc($check_menu_gt)) {
         
         $bacgt = n($bac_xh/3);
         $expgt = n($exp_new/2);
                 mysql_query("UPDATE `users` SET `xu`=`xu`+'".$bacgt."',`exp` = `exp` + '".$expgt."' WHERE `user_id`='".$l_gt['user_id']."'"); 

}
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
    $thuong.='';
    echo "".$text." | ".$money." | " .$thuong." | " .$xu." | " .$exp." ";
    //Sync pokemon
    pokemon_player_hand_update();
    //Let Pokemon grow
    pokemon_grow($txt);
    //Remove Attack
    remove_attack($_GET['aanval_log_id']);
    unset($_SESSION['attack']['aanval_log_id']);
  }
  else{
    header("Location: ?page=attack/trainer/trainer-attack");
  }
}
?>