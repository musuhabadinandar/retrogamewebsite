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
  $gebruiker = mysql_fetch_array(mysql_query("SELECT * FROM `users`, `gebruikers_item` WHERE ((`users`.`user_id`='".$_SESSION['id']."') AND (`gebruikers_item`.`user_id`='".$_SESSION['id']."'))"));
  //Load computer info
  $computer_info = computer_data($aanval_log['tegenstanderid']);
  //Test if fight is over
  if($aanval_log['laatste_aanval'] == "end_screen"){
		if($computer_info['leven'] == 0){
      rankerbij('attack',$txt);  
     	///bosss
	 $user_ss = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `user_id` = '".$_SESSION['id']."'"));

 
////boss

 
      //Update User
                  $ducnghia_tile = mysql_fetch_assoc(mysql_query("SELECT * FROM `ducnghia` WHERE `user_id`='".$_SESSION['id']."'"));
                  $ducnghia_tilex = mysql_fetch_assoc(mysql_query("SELECT * FROM `aanval_log` WHERE `id`='".$_GET['aanval_log_id']."'"));

             mysql_query("INSERT INTO `ducnghia_lichsu` SET `user_id` = '{$_SESSION['id']}',`id_tran` = '{$_GET['aanval_log_id']}', `loai` = 'BOSS',`trangthai` = '0', `time` = '".time()."'");

        mysql_query("UPDATE `users` SET `chiendau`='' WHERE `user_id`='".$_SESSION['id']."'");

      

      $ducnghia = rand(1,5);
     
          mysql_query("UPDATE `gebruikers` SET `gewonnen`=`gewonnen`+'1' WHERE `user_id`='".$_SESSION['id']."'"); 
          
      
      
             	$check_nv = mysql_fetch_assoc(mysql_query("SELECT * FROM `ducnghia_data_nhiemvu` WHERE `user_id` = '$gebruiker[user_id]' AND `loai` = 'pokemon'  "));
             	
             	if($check_nv[pokemon] ==$gebruiker[pokemonnv] ){
             	             mysql_query("UPDATE `ducnghia_data_nhiemvu` SET `song`=`song`+'1' WHERE `user_id`='".$_SESSION['id']."' AND `loai` = 'pokemon'"); 
 
             	}
             	
             	$check_nv3 = mysql_fetch_assoc(mysql_query("SELECT * FROM `ducnghia_data_nhiemvu` WHERE `user_id` = '$gebruiker[user_id]' AND `loai` = 'ngaunhien'  "));
             	
             	if($check_nv3[id]!=0){
             	             mysql_query("UPDATE `ducnghia_data_nhiemvu` SET `song`=`song`+'1' WHERE `user_id`='".$_SESSION['id']."' AND `loai` = 'ngaunhien'"); 
 
             	}
             	
           $bac_xh = (rand(5,50))*2;
           $exp_new = (rand(50,100))*2;
          mysql_query("UPDATE `gebruikers` SET `silver`=`silver`+'".$bac_xh."',`exp` = `exp` + '".$exp_new."',`conghien` =`conghien` + '1' WHERE `user_id`='".$_SESSION['id']."'"); 

function n($amount){
 return number_format(round($amount),0,",",".");                          
}
if($user_ss[giatoc] >0) {
    $check_menu_gt=mysql_query("SELECT * FROM `gebruikers` WHERE `giatoc` = '$user_ss[giatoc]' AND `map_num` ='$user_ss[map_num]'  ");
        mysql_query("UPDATE `ducnghia_giatoc` SET `xu`=`xu`+'5',`exp` = `exp` + '5' WHERE `id`='".$user_ss['giatoc']."'"); 

     while($l_gt=mysql_fetch_assoc($check_menu_gt)) {
         
         $bacgt = n($bac_xh/3);
         $expgt = n($exp_new/2);
                 mysql_query("UPDATE `gebruikers` SET `silver`=`silver`+'".$bacgt."',`exp` = `exp` + '".$expgt."' WHERE `user_id`='".$l_gt['user_id']."'"); 

}
}


      $text = 1;
      $money = 0;
	  // Check if he won an item
	  $isIt = rand (1,90);
	  if ($isIt == 10) {
	  // Give item
	  $items1 = array("black","blue","green","pink","red","white","yellow"); // Array for the items
	  $items2 = array("black","blue","green","pink","red","white","yellow"); // Array for the items
	  $r = rand(0,6);
	  $item = $items2[$r];
	  $theinsert = $items1[$r];
	  $additem = mysql_query('UPDATE gebruikers_item SET '.$theinsert.' =  '.$theinsert.' + 1 WHERE user_id = "'.$_SESSION['id'].'"'); 
	  $s = rand(0,5);
	  if ($s== 0) { $evnt = 'הבסת את <b>'.$computer_info['naam'].'</b> וגילית שהוא שמר על <b>'.$item.'</b>. לקחת את הפרי.'; }
	  if ($s== 1) { $evnt = 'הבסת את <b>'.$computer_info['naam'].'</b> והתברר שהוא החזיק <b>'.$item.'</b> בידיו. לקחת את הפרי עם אומץ רב!'; }
	  if ($s== 2) { $evnt = 'הבסת את <b>'.$computer_info['naam'].'</b>. חבריו הפוקימונים התחננו שתחוס על חייהם והעניקו לך <b>'.$item.'</b>.'; }
	  if ($s== 3) { $evnt = 'הבסת את <b>'.$computer_info['naam'].'</b>. בדרך ליציאה מזירת הקרב, <b>'.$item.'</b> נפל לך על הראש. קמת ולקחת אותו בלי להסס.'; }
	  if ($s== 4) { $evnt = 'מרוב פחד, <b>'.$computer_info['naam'].'</b>, לא הפסיק לפלוט שטויות מפיו עד שחשף את המקום הסודי ל<b>'.$item.'</b> שהוא החביא. מצאת אותו ולקחת במהירות.'; }
	  if ($s== 5) { $evnt = '<b>'.$computer_info['naam'].'</b> העריץ את הכוח שהפגנת בקרב מולו, והעניק לך <b>'.$item.'</b>.'; }
				mysql_query("INSERT INTO gebeurtenis (id, datum, ontvanger_id, bericht, gelezen) 
				VALUES (NULL, NOW(), '".$_SESSION['id']."', '".$evnt."', '0')");
	  }
	  
	  	//  $isIt2 = rand (1,200);
	// if ($isIt2 == 50) {
	//  $additem2 = mysql_query('UPDATE gebruikers SET nails = nails + 1 WHERE user_id = "'.$_SESSION['id'].'"'); 
	//  $s2 = rand(0,2);
//	  if ($s2== 0) { $evnt = 'לאחר שהבסת את <b>'.$computer_info['naam'].'</b>, גילית שהוא החביא בכיס מסמר. לקחת אותו מכיסו וברחת.'; }
//	  if ($s2== 1) { $evnt = '<b>'.$computer_info['naam'].'</b> בכוחותיו האחרונים ניסה לזרוק עליך מסמר, אך החטיא. לקחת את המסמר.'; }
//	  if ($s2== 2) { $evnt = 'תפסת את <b>'.$computer_info['naam'].'</b> בזמן שבנה סוכה עם חבריו, ולקחת לו מסמר בלי למצמץ.'; }
	//			mysql_query("INSERT INTO gebeurtenis (id, datum, ontvanger_id, bericht, gelezen) 
	//			VALUES (NULL, NOW(), '".$_SESSION['id']."', '".$evnt."', '0')");
//	  }

    }
    else{
      if($gebruiker['rank'] >= 4) rankeraf('attack_lose'); 
      //Rank Higher Than 3 Decrease silver with 25%
      if($gebruiker['rank'] >= 3) $money = round($gebruiker['silver']/4);
      else $money = 0;
      //Update user
              mysql_query("UPDATE `gebruikers` SET `chiendau`='' WHERE `user_id`='".$_SESSION['id']."'");

       mysql_query("INSERT INTO `ducnghia_lichsu` SET `user_id` = '{$_SESSION['id']}',`id_tran` = '{$_GET['aanval_log_id']}', `loai` = 'BOSS',`trangthai` = '1', `time` = '".time()."'");
      mysql_query("UPDATE `gebruikers` SET `silver`=`silver`-'".$money."', `verloren`=`verloren`+'1' WHERE `user_id`='".$_SESSION['id']."'");
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
    header("Location: ?page=attack/trainer/trainer-attack");
  }
}
?>