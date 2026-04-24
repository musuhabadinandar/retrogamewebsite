<?PHP

	$map = new map($user->map->id);

	$user->map->x = (int) $_POST['x'];
	$user->map->y = (int) $_POST['y'];

if(isset($_POST[auto])) {
    			mysql_query("UPDATE `users` SET `map` = '" . json_encode($user->map) . "',`data` = '1' WHERE `id` = '" . $user->id . "'");


    if($datauser->cvatpham(22)>=1) {			
 mysql_query("UPDATE `pokemon_speler` SET `leven`=`levenmax` WHERE `user_id`='" .$gebruiker['id']."' AND `opzak_nummer` = '1'");
 mysql_query("UPDATE `pokemon_speler` SET `leven`=`levenmax` WHERE `user_id`='" .$gebruiker['id']."' AND `opzak_nummer` = '2'");mysql_query("UPDATE `pokemon_speler` SET `leven`=`levenmax` WHERE `user_id`='" .$gebruiker['id']."' AND `opzak_nummer` = '3'");mysql_query("UPDATE `pokemon_speler` SET `leven`=`levenmax` WHERE `user_id`='" .$gebruiker['id']."' AND `opzak_nummer` = '4'"); mysql_query("UPDATE `pokemon_speler` SET `leven`=`levenmax` WHERE `user_id`='" .$gebruiker['id']."' AND `opzak_nummer` = '5'");mysql_query("UPDATE `pokemon_speler` SET `leven`=`levenmax` WHERE `user_id`='" .$gebruiker['id']."' AND `opzak_nummer` = '6'");
    }
} else {

			mysql_query("UPDATE `users` SET `map` = '" . json_encode($user->map) . "',`data` = '0' WHERE `id` = '" . $user->id . "'");
}
				$map_monsters = array();

				foreach ($map->grass as $grass) {
					$x1 = $grass->x / 16;
					$y1 = $grass->y / 16;

					$width = $grass->width / 16;
					$height = $grass->height / 16;

					$x2 = $x1 + ($width + 1);
					$y2 = $y1 + ($height + 1);

					if ($user->map->x >= $x1 && $user->map->x <= $x2 - 2) {
						if ($user->map->y + 2 >= $y1 && $user->map->y + 2 <= $y2) {
							foreach ($grass->encounters as $monster) {
								$map_monsters = array_merge($map_monsters, array_fill(0, $monster->rate * 100, $monster));
							}
						}
					}
				}

				$map_monster_rand = $map_monsters[rand(0, count($map_monsters) - 1)];
			
			if ($map_monster_rand->id > 0) {


				$opponent_monster_level = $map_monster_rand->min_level;


				$opponent_monster_moves = array();
				$opponent_monster_rand_moves = array();
				foreach ($opponent_monster_base->moves as $move) {
					if ($move->level >= 1 && $move->level <= $opponent_monster_level) {
						array_push($opponent_monster_moves, $move);
					}
				}
				

			

			

			}
//	echo $opponent_monster_level;

if($map_monster_rand->id <1) {
    		die('{"name":"undefined"}');

} else {
    $rarity = rand(1,1000); 
	if ($rarity <= 100) {
	$rarity = 2;
	} else if ($rarity >= 101 AND $rarity <=905 ) {
	$rarity = 1;
	} else if ($rarity > 995) {
	$rarity = 3;
	}

           $pokemondb = mysql_fetch_assoc(mysql_query("SELECT * FROM pokemon_wild where zeldzaamheid='" . $rarity . "' AND `wild_id` <='666' ORDER BY rand() limit 1 "));

$h = date("h");
if($user->map->id ==11) {
    $id_p = $pokemondb['wild_id'];
    $hot = '<b class="viptxt"><small>[Đ.BIỆT]</small></b>';
} else {
        $id_p = $map_monster_rand->id;
$hot = '['.$map_monster_rand->id.']';
}
    
       $pokemon = mysql_fetch_assoc(mysql_query("SELECT * FROM pokemon_wild WHERE wild_id= '".$id_p."'  "));
 if($pokemon['effort_attack']>=1) {
    $evs= '+'.$pokemon['effort_attack'].' ATT ';
}	
if($pokemon['effort_defence']>=1) {
    $evs= '+'.$pokemon['effort_defence'].' DFC ';
}
if($pokemon['effort_speed']>=1) {
    $evs= '+'.$pokemon['effort_speed'].' SPE ';
    
    if($pokemon['effort_hp']>=1) {
    $evs= '+'.$pokemon['effort_hp'].' hp ';
}
if($pokemon['effort_spc.attack']>=1) {
    $evs= '+'.$pokemon['effort_spc.attack'].' S.ATT ';
}
if($pokemon['effort_spc.defence']>=1) {
    $evs= '+'.$pokemon['effort_spc.defence'].' S.DFC ';
}
}else {
      $evs= 'Không ';
  
}
				
		      mysql_query("UPDATE `users` SET `ducnghia_pokemon`='".$id_p."',`pokemonnv`='".$id_p."', `ducnghia_level`='{$opponent_monster_level}'  WHERE `id`='".$_SESSION['id']."'");
	mysql_query("DELETE FROM `aanval_log` WHERE `user_id`='".$_SESSION['id']."'");
		mysql_query("DELETE FROM `pokemon_speler_gevecht` WHERE `user_id`='".$_SESSION['id']."'");
	mysql_query("DELETE FROM `pokemon_wild_gevecht` WHERE `user_id`='".$_SESSION['id']."'");
$info1 = '<i class="fa fa-globe" aria-hidden="true"></i>'.$now.' <br> <i class="fa fa-empire" aria-hidden="true"></i> EVs : '.$evs.'  ';

    
    
    		$json = array('name'=>''.$hot.''.$pokemon[naam].'', 'id'=>$id_p, 'level'=>$opponent_monster_level, 'move'=>$h,'info'=>$info1);

  		
		echo json_encode($json);

}
