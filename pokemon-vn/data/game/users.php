<?PHP
 include_once("../../attack/duel/duel.inc.php");
	
		$demmail = mysql_num_rows(mysql_query("SELECT * FROM `chat_users` WHERE `user_fr` = $user_id AND `view` = 0"));



   
		$user = new user($_SESSION['user_id']);


    
 

	$timeat = $user->timeauto - time();
	if($timeat>=1) {
	    $tent = thoigiantinh($user->timeauto);
	} else {
	    $tent = 'Hết giờ.';
	}
	$j[sesion] = md5($_POST[data]);
	$j[uid] = $_POST[data];
	$j[timeauto] = $timeat;
		$j[thoigian] = $tent;
		$j[inbox] = $demmail;
		$user->map->id = $_POST[id];
$user->map->x = $_POST[x];
	$user->map->y = $_POST[y];
		$j[inbox] = $demmail;
  $j[skin] =  $user->sprite;
 $j[viettat] =  $user->viettat;
$j[icon] =  $user->icon;
	mysql_query("UPDATE `users` SET `map` = '" . json_encode($user->map) . "' WHERE `id` = '" . $user->id . "'");
	
	$map = new map($user->map->id);

	$j[thoitiet] =$map->thoitiet;
	
////pk nha
  $duel_sql = mysql_query("SElECT `id`, `datum`, `uitdager`, `tegenstander`, `t_pokemonid`, `status` FROM `duel` WHERE `id`='".$user->pk."'");
  $duel = mysql_fetch_array($duel_sql);
    $time = strtotime(date("Y-m-d H:i:s"))-strtotime($duel['datum']);
  if(mysql_num_rows($duel_sql) == 1){
  ///status = chấp nhận
  if($duel['status'] == "accept"){
      $j[pk] = 1;
      $_SESSION['duel']['duel_id'] = $user->pk;
      $_SESSION['duel']['begin_zien'] = true;
      start_attack($duel);
            mysql_query("UPDATE `users` SET `pk`='0' WHERE `id`='".$_SESSION['id']."'");

    }
if($time > 60 AND $duel['status'] != "accept"){
      mysql_query("DELETE FROM `duel` WHERE `id`='".$user->pk."'");
      //Remove Duel
             mysql_query("UPDATE `users` SET `pk`='0' WHERE `id`='".$_SESSION['id']."'");
     
      mysql_query("DELETE FROM `pokemon_speler_gevecht` WHERE `duel_id`='".$user->pk."'");
$j[pk] = 0;
    }
  } else {
      $j[pk] = 0;

  }
  //song
    
    ///song
	


	echo json($j);
die;